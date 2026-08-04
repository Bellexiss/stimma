<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

// =_Ne1AR~q41t!X_b&PQ<l<p:5;ThYLO]3/COF@Y+4+o7u9qh;O@{R5vSkJXR}~WE

$headers = getallheaders();
$apiKey = $headers['X-Api-Key'] ?? null;

if($apiKey != '=_Ne1AR~q41t!X_b&PQ<l<p:5;ThYLO]3/COF@Y+4+o7u9qh;O@{R5vSkJXR}~WE') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}


CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$json = file_get_contents('php://input');
//$user_history = json_decode($user_history);

//$users = (array)$users;

//Bitrix\Main\Diag\Debug::writeToFile($users, "start get order " , '/___1c_shi.txt');

$url = 'http://195.201.245.102:22022/sklad/hs/list/orders/v1/payment-status';

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

