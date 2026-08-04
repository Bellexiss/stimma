<?php
// Получение курса доллара с сайта НБУ
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); // подключение ядра Битрикса

header('Content-Type: application/json');

// Получаем данные
$url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=USD&json';

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($curl);
curl_close($curl);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch exchange rate'
    ]);
    exit;
}

$data = json_decode($response, true);

if (!is_array($data) || empty($data[0]['rate'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid response format'
    ]);
    exit;
}

$usdRate = floatval($data[0]['rate']);
$exchangeDate = $data[0]['exchangedate'];

// Сохраняем в COption
COption::SetOptionString("my_module", "usd_rate", $usdRate);
COption::SetOptionString("my_module", "usd_rate_date", $exchangeDate);

// Вывод JSON-ответа
echo json_encode([
    'success' => true,
    'rate' => $usdRate,
    'date' => $exchangeDate
]);
