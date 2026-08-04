<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

/*$headers=[];
$options = [
    CURLOPT_URL => 'http://195.201.245.102:22022/sklad/hs/list/skladCell',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([]),
    CURLOPT_HTTPHEADER => $headers,
];
$curl = curl_init();
curl_setopt_array($curl, $options);
$response = curl_exec($curl);
curl_close($curl);
?><pre><?=print_r($response, 1)?></pre><?
die();*/


CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$user = file_get_contents('php://input');
$user = json_decode($user);

$user = (array)$user; 

Bitrix\Main\Diag\Debug::writeToFile($user, "start get order " , '/log_1c/___products_1c.txt');
Bitrix\Main\Diag\Debug::writeToFile($user, "start get user " , '/log_1c/1c_user.txt');

if(!array_key_exists('xml_id',$user))
{
    Bitrix\Main\Diag\Debug::writeToFile($user, "36 стр xml_id" , '/log_1c/1c_user.txt');
    $code = rand(100000,999999);
    $phone = '+38'.$user['phone'];
    Bitrix\Main\Diag\Debug::writeToFile($phone, "start get order " , '/___products_1c.txt');

    sendSmsTelikom($phone,"Код підтвердженян: " . $code);

    /*$phoneValue = str_replace([' ',')','(','-'],['','','',''],$phone);
    $apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
    $senderName = 'STIMMA';
    $phoneNumber = $phone;
    $data = [
        'phoneNumbers' => [$phoneNumber],
        "from" => "STIMMA",
        "text" => "Код підтвердження: " . $code
    ];

    $headers = [
        'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
        'Content-Type: application/json',
    ];

    $options = [
        CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ];
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);*/


    echo json_encode(['code'=>$code]);
}
elseif(isset($user['xml_id']))
{
    Bitrix\Main\Diag\Debug::writeToFile($user, "75 стр xml_id" , '/log_1c/1c_user.txt');
    $uadd = new CUser;
    //$pass = uniqid();
    $uid = $uadd->Add(['LOGIN'            => '+38'.$user['phone'],
                       'EMAIL'            => 'noemail_'.uniqid().'@stimma.ua',
                       'PASSWORD'         => $user['code'],
                       'CONFIRM_PASSWORD' => $user['code'],
                       'PERSONAL_PHONE'   => '+38'.$user['phone'],
                       'UF_PHONE_CODE'   => $user['code']
                      ]);

    if($uid > 0)
    {
        Bitrix\Main\Diag\Debug::writeToFile($uid, $user['xml_id']." 88 стр xml_id" , '/log_1c/1c_user.txt');
        $DB->Query('update b_user set XML_ID = \'' . $user['xml_id'].'\' where ID = ' . $uid);
        echo json_encode(['status'=>1]);
    }
    else
    {
        Bitrix\Main\Diag\Debug::writeToFile((array)$uadd->LAST_ERROR, "start get order " , '/___products_1c.txt');
        echo json_encode(['status'=>0]);
    }

}


