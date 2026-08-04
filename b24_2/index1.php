<?
mail('company703@gmail.com','stimma from b24_2 index.php',  'stimma from b24_2 index1.php');

define('CLIENT_ID', 'local.628cdc8f48ac92.41061459');
define('CLIENT_SECRET', 'NX2KNVLQInJV7UuzBW4Xg6gkSa7DEXDsGl2dJdpOC9xImAv4QS');
define('PATH', '/b24_2/index.php');
define('REDIRECT_URI', 'https://www.stimma.com.ua'.PATH);
define('SCOPE', 'crm,user');
define('PROTOCOL', "https");
define('CRM_LOGIN', 'krempoviy98@gmail.com'); // Логин пользователя Вашей CRM по управлению лидами
define('CRM_PASSWORD', 'Itamy2308'); // Пароль пользователя Вашей CRM по управлению лидами
define('CRM_PORTAL','stimma.bitrix24.ua');

	$filename = 'file_token.json';	$new_token="";
	if (!file_exists($filename)){
		$fp=fopen("file_token.json", "w");
		fclose($fp);
	} 
	echo "1".'<br>';
	if(isset($_REQUEST["code"])){
		$homepage = file_get_contents(PROTOCOL."://".CRM_PORTAL."/oauth/token/?grant_type=authorization_code&client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&code=".$_REQUEST["code"]."&scope=".SCOPE);
		$homepage = json_decode($homepage,true);	
		array_push($homepage, array("date" => date("Y-m-d H:i:s.", filectime($filename))));
		$json_data = json_encode($homepage);
		file_put_contents($filename, $json_data);
	}
		echo "2".'<br>';	
	if(isset($_POST["addLead"])||($_SERVER['REQUEST_METHOD'] == 'POST')){
		if(filesize($filename) == 0){
				$url = PROTOCOL."://".CRM_PORTAL."/oauth/authorize/?client_id=".CLIENT_ID."&response_type=code&redirect_uri=".REDIRECT_URI;
				header('Location: ' . $url);
				die();
		}		echo "3".'<br>';	
		if(filesize($filename) != 0){
			$j = file_get_contents($filename);
			$fileWithToken = json_decode($j, true); 
			$new_date = $fileWithToken[0]['date'];
			$new_refresh = $fileWithToken['refresh_token'];
			$new_token=$fileWithToken['access_token'];
			
			$dt = new Datetime($new_date);
			$interval = new DateInterval('PT1H');
			$dt->add($interval);
			$dt = $dt->format('Y-m-d H:i:s');
			$today = date("Y-m-d H:i:s"); 
				echo "4".'<br>';			
			if($today > $dt){
				$fileWithToken = file_get_contents(PROTOCOL."://".CRM_PORTAL."/oauth/token/?grant_type=refresh_token&client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&refresh_token=".$new_refresh."&scope=".SCOPE);
				$fileWithToken = json_decode($fileWithToken, true);
				array_push($fileWithToken, array("date" => date("Y-m-d H:i:s.", filectime($filename))));
				$json_data = json_encode($fileWithToken);
				file_put_contents($filename, $json_data);
			}

				$fileNamePic = $_FILES['UF_CRM_1624022243']['name'];
				$fileDir = "images/";
				$path = $fileDir . basename($fileNamePic);
				move_uploaded_file($_FILES['UF_CRM_1624022243']['tmp_name'], $path);

				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = "1";
				$base64 = base64_encode($data);
				echo $base64;
				
			file_get_contents(PROTOCOL."://".CRM_PORTAL."/rest/crm.lead.add.json?".http_build_query(array(
						"fields" => array(
							"TITLE" => "Деякий лід",
							"NAME" => $_REQUEST['name'],
							"UF_CRM_1624022171"=> $_REQUEST['selectnew'],
							"PHONE" => array(array("VALUE" => $_REQUEST['phone'], "VALUE_TYPE" => "WORK" )),
							"EMAIL" => array(array("VALUE" => $_REQUEST['e_mail'], "VALUE_TYPE" => "WORK" )),
							"UF_CRM_1624022243" => array("fileData" => array($_FILES['UF_CRM_1624022243']['name'], $base64)))
						)
			)."&auth=".$new_token);

}


		//$UF_CRM_1624022243 = $_POST['UF_CRM_1624022243'];
		 
		
	/*	$fileNamePic = $_FILES['UF_CRM_1624022243']['name'];
		$fileDir = "images/";
		$fileType = $_FILES['UF_CRM_1624022243']['type'];
		$newFileFullName = $fileDir . basename($fileNamePic);
		move_uploaded_file($_FILES['UF_CRM_1624022243']['tmp_name'], $newFileFullName);
					
		if(extension_loaded('curl')){
			$ch = curl_init('https://b24-e5zcbo.bitrix24.ua/crm/configs/import/lead.php');
			curl_setopt($ch, CURLOPT_POST, true);
				$arrays = array(
					'NAME' => $_POST['name'],
					'TITLE' => 'TITLE',
					'EMAIL_WORK' => $_POST['e_mail'],
					'PHONE_MOBILE' => $_POST['phone'],
					'UF_CRM_1624022171' => $_POST['selectnew'],
					'UF_CRM_1624022243' => new \CURLFile(realpath($newFileFullName), $fileType),
					'LOGIN' => CRM_LOGIN,
					'PASSWORD' => CRM_PASSWORD
				);
						
				curl_setopt($ch, CURLOPT_POSTFIELDS, $arrays);
				curl_exec($ch);
				header("Location: ".$_SERVER['REQUEST_URI']);
		}
		else{
			echo 'no curl';
		}	*/		
	}		
?>

<?/*require_once(dirname(__FILE__)."/include/header.php");*/?>
		<form name ="form_for_lead" method='post' enctype="multipart/form-data">
			<label>Введите имя</label>
				<p><textarea rows="1" cols="30" name="name" required> Nata </textarea></p>
			<label>Введите почту</label>
				<p><textarea rows="1" cols="30" name="e_mail" required>asdfghjkl@mail.ru</textarea></p>
			<label>Введите телефон</label>
				<p><textarea rows="1" cols="30" name="phone" required>78616585208</textarea></p>
			<label>Ввыберете район</label>
			<select size="1" name = "selectnew">
				<option selected value ='53'>Кам'янець-Подільський</option>
				<option value='45'>Хмельницький</option>
				<option value='51'>Волочиський</option>
				<option value='49'>Дунаєвецький</option>
				<option value='47'>Деражнянський</option>
			</select>
			<p><input type="file" name="UF_CRM_1624022243"></p>
			<p><input type="submit" name="addLead" value="Додати лід" ></p>
		</form>
<?/*require_once(dirname(__FILE__)."/include/footer.php");*/?>