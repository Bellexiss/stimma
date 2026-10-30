<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$credentialsFile = $_SERVER['DOCUMENT_ROOT'].'/api/workspace/google_workspace.json';

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

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
                     'token'=>$accessToken ? $accessToken : -1
                 ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
