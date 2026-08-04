<?php
/* define('PORTAL_NAME', 'stimma.bitrix24.ua');
define('CLIENT_ID', 'local.5abba67c3e7b65.24415403');
define('CLIENT_SECRET', 'ABIYVFS56TSxOIZJNNZN5tyu4Du3OZWKldM8PcZi3Acc2VIJfL');
define('APP_LINK', 'https://www.stimma.com.ua/b24/index.php');
define('SCOPE', 'crm,user');
define('TOKENS_FILE', 'tokens.txt'); */

/* TEST */

define('PORTAL_NAME', 'stimma.bitrix24.eu');
define('CLIENT_ID', 'local.628cdc8f48ac92.41061459');
define('CLIENT_SECRET', 'NX2KNVLQInJV7UuzBW4Xg6gkSa7DEXDsGl2dJdpOC9xImAv4QS');
define('APP_LINK', 'https://www.stimma.com.ua/b24_2/index.php');
define('SCOPE', 'crm,user');
define('TOKENS_FILE', 'tokens.txt');
/* ---- */

$_SERVER["DOCUMENT_ROOT"] = '/home/stimma/www/stimma.com.ua/public_html';
bx_auth(3);
// Parameter for forced updating tokens
if(isset($_GET['key']))
{
    if($_GET['key'] == CLIENT_ID){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE);
            bx_auth(3);
        }
    }
}

//Send data via CURL and returns response as json 
function sendByCurl ($url, $request) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url.$request);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
	$response = curl_exec($curl);
	$curl_error = curl_error($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	if ($curl_error){
		return FALSE;
	}

	return $response;
}

// Update tokens in file "tokens.txt"
function TokensUpdate ($filename, $response)
{
	if(isset($response['access_token']) and isset($response['refresh_token']))
	{				
		$GLOBALS['ACCESS_TOKEN'] = $response['access_token'];
		$GLOBALS['REFRESH_TOKEN'] = $response['refresh_token'];
		$tokens = $GLOBALS['ACCESS_TOKEN'] .','. $GLOBALS['REFRESH_TOKEN'];
		file_put_contents($filename, $tokens);
		return TRUE;
	}
	else return FALSE;
}

// First authorization in Bitrix
function bx_auth($type=2) 
{	
	if ($type == 3) 
	{			
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE))
		{
			$tokens = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE);
			$tokens = trim($tokens);
			if(!empty($tokens))
			{
				$arTokens = explode(',', $tokens);
				$GLOBALS['REFRESH_TOKEN'] = $arTokens[1];
				$GLOBALS['ACCESS_TOKEN'] = $arTokens[0];
				return TRUE;			
			}		
		} 	
	

		if(isset($_GET['code']) or isset($_POST['code'])) 
		{			
			// Sends this code and accepts the "access token" and "refresh token" in response
			$data = sendByCurl("https://". PORTAL_NAME ."/oauth/token/", "?client_id=". CLIENT_ID ."&grant_type=authorization_code&client_secret=". CLIENT_SECRET ."&redirect_uri=". APP_LINK ."&code=". $_GET["code"] ."&scope=". SCOPE);
			$access_array = json_decode($data,TRUE);
			return TokensUpdate($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE, $access_array);			
		}
		else
		{ 	
			if ( ! headers_sent()) 
			{
				header("Location:https://".PORTAL_NAME."/oauth/authorize/?client_id=".CLIENT_ID."&response_type=code&redirect_uri=".APP_LINK);
				exit;	
			}
			else
			{				
				echo "Пожалуйста, кликните по ссылке для авторизации в Битрикс24. ";
				echo "<a href=\"https://". PORTAL_NAME ."/oauth/authorize/?client_id=".CLIENT_ID ."&response_type=code&redirect_uri=".APP_LINK ."\">Клик для авторизации</a></br>";
				exit;
				
			}	
		}
	}
	

    // For second-type applications accept the token and save it into global variable for concatenating to all referers
	elseif ($type == 2)
    {
		if(isset($_REQUEST['AUTH_ID']))
		{
			$GLOBALS['ACCESS_TOKEN'] = $_REQUEST['AUTH_ID'];
		}
    }
}

// Refresh token if needed
function bx_refresh($debug = FALSE) {
   
	// Sends "refresh token" for update "access token"
    $request = 'https://'. PORTAL_NAME .'/oauth/token/?grant_type=refresh_token&client_id='. CLIENT_ID .'&client_secret='. CLIENT_SECRET .'&refresh_token='. $GLOBALS['REFRESH_TOKEN'] .'&scope='. SCOPE .'&redirect_uri='. APP_LINK;
    
    $curl = curl_init($request);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($curl);
    $curl_errorno = curl_errno($curl);
    curl_close($curl);
    
    // Shows response if debug
    echo ($debug) ? $response : null;
    // JSON -> Array
    $access_array = json_clean_decode($response);
    
    // Cheking if errors was occured
    if(isset($access_array['error']))
    {	// If "refresh token" expires, invoke bx_auth for "first authorization" again		
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE))
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE);
			// Try to re-auth
			if( ! bx_auth(3))
			{
				exit;
			}
		}
		else
		{	// Try to re-auth
			if( ! bx_auth(3))
			{
				exit;
			}
		}			
	}
    else 
    {	// If access, update tokens in file
        TokensUpdate($_SERVER['DOCUMENT_ROOT'].'/b24_2/'.TOKENS_FILE, $access_array);
    } 
	
}

// Calls Bitrix Framework method
function bx_call($method, $array = array(), $debug = FALSE, $format = 'json') { 
			
	$agent = 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6';
	
	// Creates request link
	$request = 'https://'. PORTAL_NAME .'/rest/'. $method .'.'. $format .'?auth='. $GLOBALS['ACCESS_TOKEN'];

	// Converts array to POST query
	if (!is_array($array)) 
        $query = $array;
    else
        $query = http_build_query($array);
	// Sends query to server
	$curl = curl_init($request);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE); 
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
	curl_setopt($curl, CURLOPT_USERAGENT, $agent);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
	curl_setopt($curl, CURLOPT_FAILONERROR, 0);
	//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
												//'Content-Type: application/json',
												'Transfer-Encoding: chunked',
												'Connection: keep-alive',
												'Content-Length:'.strlen($query)
											));
	$response = curl_exec($curl);

	$curl_errorno = curl_errno($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	// Debuggin data
	if ($debug)
	{
		// echo '<br/>Request: '.  json_clean_encode($array) .'<br/>';  
		// echo '<br/>Response: '; 
		// echo '<br/>HTTP_CODE: '.  $status .'<br/><br/>';          
		
		$resp = json_clean_decode($response);
		
		if (isset($resp['error']))
		{
			// echo '<br/>Ошибка: '. $resp['error'];
			// echo '<br/>Описание: '. $resp['error_description'];

			// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24/errors.txt', print_r("\n".json_clean_encode($array), true), FILE_APPEND);
			// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24/errors.txt', print_r("\n".$status, true), FILE_APPEND);
			// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24/errors.txt', print_r("\n".$resp['error'], true), FILE_APPEND);
		}
	}

	// JSON -> Array
	$response = json_clean_decode($response);

	// Getting result
	// If current token is expired, refresh it and invoke bx_call again
	$result = array();
	if(isset($response['error']))
	{	
		if ($response['error'] == 'expired_token')
		{
			bx_refresh();
			$result = bx_call($method, $array, $debug, $format);
		}
		if($response['error'] == 'invalid_token')
		{
			bx_refresh();
			$result = bx_call($method, $array, $debug, $format);
		}
		$result['error'] = $response;	
	}	
	
	if (isset($response['result'])) 
	{
		$result = $response;
	}
	$result['STATUS'] = $status;
	// file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24/full_response.txt', print_r($result, true), FILE_APPEND);
	return $result;
}


// JSON -> Array
function json_clean_decode($json, $assoc = TRUE, $depth = 512, $options = 0) { 

    // search and remove comments like /* */ and // 
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t](//).*)#", '', $json); 

    if(version_compare(phpversion(), '5.4.0', '>=')) { 
        $array = json_decode($json, $assoc, $depth, $options); 
    } 
    elseif(version_compare(phpversion(), '5.3.0', '>=')) { 
        $array = json_decode($json, $assoc, $depth); 
    } 
    else { 
        $array = json_decode($json, $assoc); 
    } 

    return $array;
}

// Array -> JSON
function json_clean_encode($array, $options = 0, $depth = 512) {

    if(version_compare(phpversion(), '5.5.0', '>=')) { 
        $json = html_entity_decode(json_encode($array, $depth, $options));
    } 
    elseif(version_compare(phpversion(), '5.3.0', '>=')) { 
        $json = html_entity_decode(json_encode($array, $options)); 
    } 
    else { 
        $json = html_entity_decode(json_encode($array)); 
    } 

    return $json;
}


function call($method, $arParams, $full_result = false)
{
    $result = bx_call($method, $arParams, true);
    if ($full_result) {
   		return $result;
    }else{
    	return isset($result['result']) ? $result['result'] : $result;
    }
    
}

