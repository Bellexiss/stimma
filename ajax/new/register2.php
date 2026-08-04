<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/lib/register/functions.php';
global $USER;
$json['result'] = 'error';
$json['message'] = '???';

$phone = $_POST['userPhone'];
$phoneNumber = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($phone);

if (!$_POST['userLogin'])
{
    //$_POST['userLogin'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = 'Введіть email';
    echo json_encode($json);
    die();
}
if (!$_POST['userName'])
{
    //$_POST['userLogin'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = 'Введіть ім’я';
    echo json_encode($json);
    die();
}
if ($_POST['userPassword'] != $_POST['userPasswordRepeat'] || $_POST['userPassword'] == '' || $_POST['userPassword'] == 'userPasswordRepeat')
{
    //$_POST['userLogin'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = 'Паролі не співпадають';
    echo json_encode($json);
    die();
}
if (strlen($_POST['userPassword']) < 6)
{
    //$_POST['userLogin'] = $email = 'user_'.uniqid().'@doors';
    $json['result'] = 'error';
    $json['message'] = 'Задайте пароль не менше 6 символів';
    echo json_encode($json);
    die();
}
else
    $email = $_POST['userLogin'];

$user = findUserByEmail($email);
//if(!$user)
//    $user = findUserByPhone($phoneNumber);
if(!$user)
{
    $user = createUser($_POST['userName'], '', $_POST['userLastName'], $email, $phoneNumber, $_POST['userPassword'], $_POST['userPasswordRepeat']);
    $fields = [
        'EMAIL' => $email,
        'USER_NAME' => $_POST['userName'] .' ' . $_POST['userLastName'],
        'PASSWORD' => $_POST['userPassword']
    ];
    CEvent::SendImmediate('BS_FORGOT_PASS', 's1', $fields, "Y",13);

    $USER -> Authorize($user);
    $json['result'] = 'ok';
}
elseif($user)
{
    $json['result'] = 'error';
    $json['message'] = 'Такий користувач вже існує';
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
