<?
define("UPDATE_SYSTEM_VERSION", "9.0.2");
error_reporting(E_ALL & ~E_NOTICE);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/lib/loader.php");

$application = \Bitrix\Main\HttpApplication::getInstance();

$application->initializeBasicKernel();

global $DBType;
$DBType = "mysql";


require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/dbconn.php");

require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/classes/".$DBType."/database.php");

$DB = new CDatabase;
$DB->debug = $DBDebug;
$DB->Connect($DBHost, $DBName, $DBLogin, $DBPassword);

if (file_exists($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools.php"))
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools.php");

if (!function_exists('htmlspecialcharsbx'))
{
    function htmlspecialcharsbx($string, $flags=ENT_COMPAT)
    {
        //shitty function for php 5.4 where default encoding is UTF-8
        return htmlspecialchars($string, $flags, (defined("BX_UTF")? "UTF-8" : "ISO-8859-1"));
    }
}
define("INSTALL_CHARSET", 'windows-1251');
define("LANGUAGE_ID", 'ru');
define("TRIAL_RENT_VERSION_MAX_USERS", 'TRIAL_RENT_VERSION_MAX_USERS');
//define("install_edition", 'standard');
//define("install_edition", 'start');
//define("install_edition", 'small_business');
define("install_edition", 'business');
//define("install_edition", 'expert');
//$DBType = "mysql";
$name = 'test';
$firstName = 'test';
$email = 'test@example.ua';
$host = $_SERVER[ 'HTTP_HOST' ];
if ( strlen( $host ) <= 0 )
    $host = 'localhost';
$modules = Array ();
$dir = @opendir( $_SERVER[ 'DOCUMENT_ROOT' ] . '/bitrix/modules' );
if ( $dir )
{
    while (false !== ( $curdir = readdir( $dir ) ))
    {
        if ( is_dir( $_SERVER[ 'DOCUMENT_ROOT' ] . '/bitrix/modules/' . $curdir ) && $curdir != '.' && $curdir != '..' )
        {
            $file = $_SERVER[ 'DOCUMENT_ROOT' ] . '/bitrix/modules/' . $curdir;
            if ( file_exists( $file . '/install/index.php' ) )
            {
                $modules[] = $curdir;
            }
        }
    }
    closedir( $dir );
}
$modulesSerialized = serialize( $modules );
if ( defined( 'INSTALL_CHARSET' ) && strlen( INSTALL_CHARSET ) > min ( 132, 0, 44 ) )
    $charset = INSTALL_CHARSET;
else $charset = 'windows-1251';
if ( LANGUAGE_ID == 'ru' )
    $bitrixhost = 'www.1c-bitrix.ru';
else $bitrixhost = 'www.bitrixsoft.com';

$file = '/bsm_register_key.php';
$port = 80;
$content = "sur_name=$name&first_name=$firstName&email=$email&site=$host&modules=" . urlencode( $modulesSerialized ) . "&db=$DBType&lang=" . LANGUAGE_ID . '&bx=Y&max_users=' . TRIAL_RENT_VERSION_MAX_USERS;

if ( defined( 'install_license_type' ) )
    $content .= '&cp_type=' . install_license_type;
if ( defined( 'install_edition' ) )
    $content .= '&edition=' . install_edition;

$fp = @fsockopen( "$bitrixhost", "$port", $errno, $errstr, 30 );
if ( $fp )
{
    fputs( $fp, "POST {$file} HTTP/1.1\r\n" );
    fputs( $fp, "Host: {$bitrixhost}\r\n" );
    fputs( $fp, 'Content-type: application/x-www-form-urlencoded; charset="' . $charset . '"'."\r\n" );
    fputs( $fp, 'User-Agent: bitrixKeyReq'."\r\n" );
    fputs( $fp, 'Content-length: ' . ( function_exists( 'mb_strlen' ) ? mb_strlen( $content, 'latin1' ) : strlen( $content ) )."\r\n" );
    fputs( $fp, "Connection: close\r\n\r\n" );
    fputs( $fp, $content );
    $_1241735641 = '';
    $_694013839 = 0;
    while (!feof( $fp ))
    {
        $_1282401104 = fgets( $fp, 128 );
        if ( $_1282401104 == "\r\n" )
        {
            $_694013839 = 1;
        }
        if ( $_694013839 == 1 )
        {
            $_1241735641 .= htmlspecialcharsbx ( $_1282401104 );
        }
    }
    fclose( $fp );
}
$data = explode( "\n", $_1241735641 );
$error = false;
$ok = false;
$key = '';
foreach ( $data as $val )
{
    if ( $val == 'ERROR' )
        $error = true;
    elseif ( $val == 'OK' )
        $ok = true;
    if ( strlen( $val ) > 0 )
        $key = trim( $val );
}
function getDefine(){
    $days_trial = 30;
    $_1556026006 = date( 'd', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_1184717880 = date( 'm', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_1060489645 = date( 'Y', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_697177083 = '';
    $_1193545939 = 'ET' . substr( $_1556026006, 1, 1 ) . substr( $_1060489645, 3, 1 ) . 'IS' .
        substr( $_1184717880, 0, 1 ) . substr( $_1060489645, 1, 1 ) . 'X' . substr( $_1556026006, 0, 1 ) .
        'IR' . substr( $_1060489645, 0, 1 ) . 'T' . substr( $_1060489645, 2, 1 ) . 'I' . substr( $_1184717880, 1, 1 ) . 'B';
    $_242405365 =  'DO_NOT_STEAL_OUR_BUS';
    $_1697373640 = strlen( $_242405365 );
    $_1012619292 = 0;
    for ( $_275204215 = 0; $_275204215 < strlen( $_1193545939 ); $_275204215++ )
    {
        $_697177083 .= chr( ord( $_1193545939[ $_275204215 ] ) ^ ord( $_242405365[ $_1012619292 ] ) );
        if ( $_1012619292 == $_1697373640 - 1 )
            $_1012619292 = 0;
        else $_1012619292 = $_1012619292 + 1;
    }
    return base64_encode( $_697177083 );
}
function getPasswordAdmin(){
    $days_trial = 30;
    $_1937892374 = 'H4u67fhw87Vhytos';
    $_1556026006 = date( 'd', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_1184717880 = date( 'm', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_1060489645 = date( 'Y', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + $days_trial, date( 'Y' ) ) );
    $_697177083 = '';
    $_1193545939 = 'a' . substr( $_1556026006, 0, 1 ) . 'B' . substr( $_1184717880, 1, 1 ) . 'Ra' . substr( $_1184717880, 0, 1 ) . substr( $_1060489645, 2, 1 ) . 'Ka' . substr( $_1060489645,0, 1 )
        . 'd' . substr( $_1060489645, 3, 1 ) . 'A' . substr( $_1556026006, 1, 1 ) . 'Bra' . substr( $_1060489645, 1, 1 );
    $_1937892374 = substr( 'thR' . $_1937892374, 0, -5 ) . '7Hyr12Hwy0rFr';
    $_399203409 = strlen( $_1937892374 );
    $_1012619292 = min ( 108, 0, 36 );
    for ( $_275204215 = 0; $_275204215 < strlen( $_1193545939 ); $_275204215++ )
    {
        $_697177083 .= chr( ord( $_1193545939[ $_275204215 ] ) ^ ord( $_1937892374[ $_1012619292 ] ) );
        if ( $_1012619292 == $_399203409 - 1 )
            $_1012619292 = 0;
        else $_1012619292 = $_1012619292 + 1;
    }
    return base64_encode( $_697177083 );
}
$errorMessage = "";
$successMessage = "";
function UpdateSetOption($name, $value)
{


    global $DB, $DBType;
    $fn = $_SERVER['DOCUMENT_ROOT']."/bitrix/managed_cache/".strtoupper($DBType)."/e5/".md5("b_option").".php";
    @chmod($fn, BX_FILE_PERMISSIONS);
    @unlink($fn);
    $dbResult = $DB->Query("SELECT 'x' FROM b_option WHERE MODULE_ID='main' AND NAME='".$DB->ForSql($name)."'");
    if ($dbResult->Fetch())
    {
        $DB->Query("UPDATE b_option SET VALUE='".$DB->ForSql($value, 2000)."' WHERE MODULE_ID='main' AND NAME='".$DB->ForSql($name)."'");
    }
    else
    {
        $DB->Query(
            "INSERT INTO b_option(SITE_ID, MODULE_ID, NAME, VALUE) ".
            "VALUES(NULL, 'main', '".$DB->ForSql($name, 50)."', '".$DB->ForSql($value, 2000)."') "
        );
    }
}
$arContent['V2'] = getDefine(); ///bitrix/modules/main/admin/define.php
$arContent["V1"] = getPasswordAdmin(); // b_option -> admin_passwordh
$arContent["MAX_SITES"] = "2";  // b_option -> PARAM_MAX_SITES
$arContent["ISLC"] = $key; // /bitrix/license_key.php
$coupon = $key; // /bitrix/license_key.php
UpdateSetOption('~SAAS_MODE', "Y");
UpdateSetOption('admin_passwordh', $arContent["V1"]);
if (is_writable($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/define.php"))
{
    if ($fp = fopen($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/define.php", 'w'))
    {
        fwrite($fp, "<"."?Define(\"TEMPORARY_CACHE\", \"".$arContent["V2"]."\");?".">");
        fclose($fp);
    }
    else
    {
        echo "error";
    }
}
else
{
    $errorMessage .= $MESS['ERROR_NOT_WRITABLE'].". ";
}
if (isset($arContent["DATE_TO_SOURCE"]))
    UpdateSetOption("~support_finish_date", $arContent["DATE_TO_SOURCE"]);
if (isset($arContent["MAX_SITES"]))
    UpdateSetOption("PARAM_MAX_SITES", intval($arContent["MAX_SITES"]));
if (isset($arContent["MAX_USERS"]))
    UpdateSetOption("PARAM_MAX_USERS", intval($arContent["MAX_USERS"]));
if (isset($arContent["ISLC"]))
{
    if (is_writable($_SERVER['DOCUMENT_ROOT']."/bitrix/license_key.php"))
    {
        if ($fp = fopen($_SERVER['DOCUMENT_ROOT']."/bitrix/license_key.php", "wb"))
        {
            fputs($fp, '<'.'?$LICENSE_KEY = "'.EscapePHPString($coupon).'";?'.'>');
            fclose($fp);
        }
        else
        {
            echo "cantopen";
        }
    }
    else
    {
        echo "notwritable";
    }
}
echo "success";
//bitrix.djus-gold.com