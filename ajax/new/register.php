<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

$data = $_POST['REGISTER'];

//if(!$data['NAME'])$data['NAME'] = '[не відомо]';
if(!$data['EMAIL'])$data['EMAIL'] = 'user_'.uniqid().'@stimma';

require $_SERVER['DOCUMENT_ROOT'].'/ajax/new/functions.php';
global $USER;
$json['result'] = 'error';
$json['message'] = '???';

$phone = $data['PERSONAL_PHONE'];
$phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($phone);

if (!$data['EMAIL'])
{
    //$data['EMAIL'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Введіть email' : 'Введите email';
    echo json_encode($json);
    die();
}
/*if (!$data['NAME'])
{
    //$data['EMAIL'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Введіть ім’я' : 'Введите имя';
    echo json_encode($json);
    die();
}*/
if ($data['PASSWORD'] != $data['CONFIRM_PASSWORD'] || $data['PASSWORD'] == '' || $data['PASSWORD'] == 'CONFIRM_PASSWORD')
{
    //$data['EMAIL'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Паролі не співпадають' : 'Пароли не совпадают';
    echo json_encode($json);
    die();
}
if (strlen($data['PASSWORD']) < 6)
{
    //$data['EMAIL'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Задайте пароль не менше 6 символів' : 'Задайте пароль не менее 6 символов';
    echo json_encode($json);
    die();
}
else
    $email = $data['EMAIL'];

$user = findUserByEmail($email);
//if(!$user)
//    $user = findUserByPhone($phoneNumber);
if(!$user)
{
    $user = createUser($data['NAME'], '', '', $email, $phoneNumber, $data['PASSWORD'], $data['CONFIRM_PASSWORD']);
    $fields = [
        'EMAIL' => $email,
        'USER_NAME' => $data['NAME'],
        'PASSWORD' => $data['PASSWORD']
    ];

    $USER -> Authorize($user);
    $json['result'] = 'ok';
}
elseif($user)
{
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Такий користувач вже існує' : 'Такой пользователь уже существует';
    echo json_encode($json);
    die();
}


/*if(!$user)
{
    // todo error
}
else
{
    $registeredUserID = $user;
    global $DB;

    global $USER;
    $USER -> Authorize($registeredUserID);
    $json['result'] = 'ok';
}*/

echo json_encode($json);
die();
?>