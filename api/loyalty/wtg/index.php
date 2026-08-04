<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Bitrix\Main\Diag\Debug::writeToFile('start wtg', date('d.m.Y H:i:s') , '/___wtg.txt');


CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$json = file_get_contents('php://input');

$headers = getallheaders();

Bitrix\Main\Diag\Debug::writeToFile($json, 'json '.date('d.m.Y H:i:s') , '/___wtg.txt');
Bitrix\Main\Diag\Debug::writeToFile($_GET, 'get ' , '/___wtg.txt');
Bitrix\Main\Diag\Debug::writeToFile($_REQUEST, 'REQUEST ' , '/___wtg.txt');
Bitrix\Main\Diag\Debug::writeToFile($headers, 'HEADERS ' , '/___wtg.txt');
Bitrix\Main\Diag\Debug::writeToFile(1, 'end___________-- ' , '/___wtg.txt');


//$user_history = json_decode($user_history);

//$users = (array)$users;

//Bitrix\Main\Diag\Debug::writeToFile($users, "start get order " , '/___1c_shi.txt');

$url = 'http://195.201.245.102:22022/sklad/hs/list/wtg?Key='.$_REQUEST['Key'];

$headers = [
    'Content-Type: application/json'
];

$options = [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
    CURLOPT_TIMEOUT => 10         // таймаут выполнения
];

$curl = curl_init();
curl_setopt_array($curl, $options);

$response = curl_exec($curl);
curl_close($curl);

echo $response;

