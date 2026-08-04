<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

require $_SERVER['DOCUMENT_ROOT'].'/ajax/new/functions.php';
global $USER;
$json['result'] = 'error';
$json['message'] = '???';

if (!$_POST['EMAIL'])
{
    $json['result'] = 'error';
    $json['message'] = $ua ? 'Введіть email' : 'Введите email';
    echo json_encode($json);
    die();
}

$pass = !empty($_POST['register_pass']) ? $_POST['register_pass'] : uniqid();
$email = $_POST['EMAIL'];

$user = findUserByEmail($email);
//if(!$user)
//    $user = findUserByPhone($phoneNumber);
if(!$user)
{
    $user = createUser('', '', '', $email, '', $pass, $pass, false);
    $fields = [
        'EMAIL' => $email,
        'PASSWORD' => $_POST['PASSWORD']
    ];

    //$USER -> Authorize($user);
    if($user > 0)
    {
        CModule::IncludeModule('sale');
        $PERIOD = '90 days';
        $activeFrom = new \Bitrix\Main\Type\DateTime();
        $activeTo = new \Bitrix\Main\Type\DateTime();
        $activeTo = $activeTo->add($PERIOD);

        $p1 = rand(100,999);
        $p2 = rand(100,999);
        $p3 = rand(100,999);
        $coupon = $p1.'-'.$p2.'-'.$p3;
        //$coupon = $p2.'-'.$p4;
        //Персональний промокод ____
        $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
                                                                     'DISCOUNT_ID' => 35,
                                                                     'COUPON' => $coupon,
                                                                     'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
                                                                     //'ACTIVE_FROM' => $activeFrom,
                                                                     //'ACTIVE_TO' => $activeTo,
                                                                     'MAX_USE' => 1,
                                                                     'USER_ID' => '',//$arFields['ID'],
                                                                     'DESCRIPTION' => 'for registration #'.$user
                                                                 ));

        $text = '<div style="text-align: center;">Ваша знижка - 10% на перше замовлення. <br>Персональний промокод '.$coupon.'</div>';
        $fields = [
            'MY_EMAIL' => $email,
            'TEXT' => $text
        ];

        CEvent::SendImmediate('BS_DISCOUNT_REGISTER', 's1', $fields, "Y",104);

        $uadd = new CUser;
        $uadd->Update($user, ['UF_REG_POPUP' => 'Так']);

        $json['result'] = 'ok';
        $json['coupon'] = $coupon;
        $json['message'] = $ua ? 'Промокод був висланий на Email' : 'Промокод был выслан на Email';
    }
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