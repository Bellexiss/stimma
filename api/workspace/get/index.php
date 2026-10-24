<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$json = file_get_contents('php://input');

$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
$json = str_replace("\xC2\xA0", ' ', $json);
$json = trim($json);


Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s'), "start workspace " , '/___workspace.txt');
Bitrix\Main\Diag\Debug::writeToFile($json, "data from 1c " , '/___workspace.txt');

$json = '{
    "Id": "14a62b5f-b8eb-11f1-b185-bdc5481eee0f",
    "file": "https://stimma.ua/coupon.png",
    "text": "Погодження оплати:\nРемонт \/ будівництво \nЗа дзеркала зг-но рахунка \nСумма135 400 грн",
    "fileName": "14a62b5f-b8eb-11f1-b185-bdc5481eee0f.png"
}
';
$json = json_decode((array)$json);
Bitrix\Main\Diag\Debug::writeToFile($json, "data from 1c unjson" , '/___workspace.txt');
// send_google_chat.php
// 1. Путь к новому JSON-ключу сервисного аккаунта.
// Храни файл вне public_html / public.
$credentialsFile = $_SERVER['DOCUMENT_ROOT'].'/api/workspace/google_workspace.json';
// 2. Укажи реальное имя пространства из Google Chat API.
$spaceName = 'spaces/5C8cmqAAAAE'; // zNmQcKAAAAE 6tJTyqAAAAE
// 3. Публичный HTTPS URL PDF на твоём сервере.
$pdfUrl = 'https://stimma.ua/coupon.png';
// 4. Данные уведомления.
$requestId = '14a62b5f-b8eb-11f1-b185-bdc5481eee0f';
$messageText = "Погодження оплати:\n" . "Ремонт / будівництво\n" . "За дзеркала згідно рахунка\n" . "Сума: 135 400 грн";
// ---------- Читаем JSON ----------
$credentials = json_decode(file_get_contents($credentialsFile), true);
if(!$credentials || empty($credentials['client_email']) || empty($credentials['private_key']))
{
    die('Ошибка чтения JSON сервисного аккаунта');
}
// ---------- Создаём JWT ----------
$base64url = function($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
};
$now = time();
$header = $base64url(json_encode([
                                     'alg' => 'RS256',
                                     'typ' => 'JWT'
                                 ]));
$claims = $base64url(json_encode([
                                     'iss'   => $credentials['client_email'],
                                     'scope' => 'https://www.googleapis.com/auth/chat.bot',
                                     'aud'   => 'https://oauth2.googleapis.com/token',
                                     'iat'   => $now,
                                     'exp'   => $now + 3600
                                 ]));
$unsignedJwt = $header . '.' . $claims;
if(!openssl_sign($unsignedJwt, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256))
{
    die('Ошибка создания подписи JWT');
}
$jwt = $unsignedJwt . '.' . $base64url($signature);
// ---------- Получаем OAuth access token ----------
$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query([
                                                   'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                                                   'assertion'  => $jwt
                                               ]),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 20
]);
$tokenResponse = curl_exec($ch);
$tokenHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$tokenError = curl_error($ch);
curl_close($ch);
if($tokenResponse === false)
{
    die('Ошибка cURL при получении токена: ' . $tokenError);
}
$tokenData = json_decode($tokenResponse, true);
if($tokenHttpCode !== 200 || empty($tokenData['access_token']))
{
    die('Ошибка получения токена: ' . $tokenResponse);
}
$accessToken = $tokenData['access_token'];
// ---------- Формируем одну карточку ----------
$card = [
    'text'    => 'Новое уведомление о согласовании оплаты',
    'cardsV2' => [
        [
            'cardId' => 'payment_' . $requestId,
            'card'   => [
                'header'   => [
                    'title'    => 'Погодження оплати',
                    'subtitle' => 'Документ на согласование'
                ],
                'sections' => [
                    [
                        'widgets' => [
                            [
                                'textParagraph' => [
                                    'text' => nl2br(htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8'))
                                ]
                            ],
                            [
                                'decoratedText' => [
                                    'startIcon'   => [
                                        'knownIcon' => 'DESCRIPTION'
                                    ],
                                    'topLabel'    => 'Документ',
                                    'text'        => 'PDF-файл',
                                    'bottomLabel' => 'Откройте документ для просмотра'
                                ]
                            ],
                            [
                                'buttonList' => [
                                    'buttons' => [
                                        [
                                            'text'    => 'Открыть PDF',
                                            'onClick' => [
                                                'openLink' => [
                                                    'url' => $pdfUrl
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'divider' => new stdClass()
                            ],
                            [
                                'buttonList' => [
                                    'buttons' => [
                                        [
                                            'text'    => 'Принять',
                                            'type'    => 'FILLED',
                                            'color'   => [
                                                'red'   => 0.10,
                                                'green' => 0.50,
                                                'blue'  => 0.25
                                            ],
                                            'onClick' => [
                                                'action' => [
                                                    'function'   => 'acceptRequest',
                                                    'parameters' => [
                                                        [
                                                            'key'   => 'request_id',
                                                            'value' => $requestId
                                                        ],
                                                        [
                                                            'key'   => 'decision',
                                                            'value' => 'accepted'
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            'text'    => 'Отклонить',
                                            'type'    => 'FILLED',
                                            'color'   => [
                                                'red'   => 0.75,
                                                'green' => 0.15,
                                                'blue'  => 0.15
                                            ],
                                            'onClick' => [
                                                'action' => [
                                                    'function'   => 'rejectRequest',
                                                    'parameters' => [
                                                        [
                                                            'key'   => 'request_id',
                                                            'value' => $requestId
                                                        ],
                                                        [
                                                            'key'   => 'decision',
                                                            'value' => 'rejected'
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
// ---------- Отправляем карточку ----------
$url = 'https://chat.googleapis.com/v1/' . $spaceName . '/messages';
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json; charset=utf-8'
    ],
    CURLOPT_POSTFIELDS     => json_encode($card, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 30
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
if($response === false)
{
    die('Ошибка отправки: ' . $error);
}
if($httpCode < 200 || $httpCode >= 300)
{
    die("Google Chat API HTTP {$httpCode}: " . $response);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
                     'success' => true,
'response' => json_decode($response, true)
                 ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
