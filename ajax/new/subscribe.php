<?
use Bitrix\Sale\Internals\DiscountCouponTable;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

$msg = "";

$email = trim($_POST['email']);
$date = date('d.m.Y H:i:s');
$dateX = strtotime($date);

global $DB;
$res = $DB->Query('select * from subscribers where UF_EMAIL = \''.$email.'\'');

// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN CODE TEXT');
// $res = $DB->Query('ALTER TABLE subscribers ADD COLUMN VERIFIED TEXT NULL');
if($res=$res->Fetch())
{
    $msg = $ua ? 'Ви вже підписані' : 'Вы уже подписаны';
    Bitrix\Main\Diag\Debug::writeToFile('Already subscribe '. $email, "new generation " , '/debug_create_subscribe.txt');
}
else
{
    Bitrix\Main\Diag\Debug::writeToFile('START GENERATION', "new generation " , '/debug_create_subscribe.txt');

    $code = md5($email.time());
    $DB->Query('insert into subscribers (UF_EMAIL,UF_DATE,UF_DATE_X,VERIFIED,CODE) values (\''.$email.'\',\''.$date.'\',\''.$dateX.'\', \'N\', \''.$code.'\')');
    $msg = $ua ? 'Знижка 10% чекається не дочекається, коли потрапить до тебе 😉 
Щоб отримати її, будь ласка, перевір пошту та підтверди свій e-mail.' : 'Скидка 10% ждет не дождется, когда прилетит к тебе 😉 
Что бы получить ее, пожалуйста, проверь почту и подтверди свой e-mail.';
    // var_dump('insert into subscribers (UF_EMAIL,UF_DATE,UF_DATE_X,VERIFIED,CODE) values (\''.$email.'\',\''.$date.'\',\''.$dateX.'\', N, \''.$code.'\')');
    // var_dump($DB->GetError());

    // ID скидочного правила, к которому относится купон
    $discountId = 43;
    // Генерация кода купона (можно через CatalogGenerateCoupon())
    $codeCoupon = \CatalogGenerateCoupon();

    Bitrix\Main\Diag\Debug::writeToFile($codeCoupon . ' for ' . $email, "new generation " , '/debug_create_subscribe.txt');

    // Параметры купона
    $arCoupon = [
        "DISCOUNT_ID" => $discountId,
        "COUPON" => $codeCoupon,
        "ACTIVE" => "Y",           // активен
        "TYPE" => DiscountCouponTable::TYPE_ONE_ORDER, // однократный
        "MAX_USE" => 1,
        //'USER_ID' => $USER->GetID()
    ];

    $uId=0;
    $findEMail = $DB->Query('select * from b_user where EMAIL = \''.$email.'\'');
    if($findEMail=$findEMail->Fetch())
        $uId=$findEMail['ID'];

    if($uId)
        $arCoupon['USER_ID']=$uId;

    Bitrix\Main\Diag\Debug::writeToFile('BEFORE ADD COUPON ' . $codeCoupon, "new generation " , '/debug_create_subscribe.txt');
    Bitrix\Main\Diag\Debug::writeToFile($arCoupon, "array arCoupon " , '/debug_create_subscribe.txt');
    // Создание купона
    $result = DiscountCouponTable::add($arCoupon);
    Bitrix\Main\Diag\Debug::writeToFile('AFTER ADD COUPON ' . $codeCoupon, "new generation " , '/debug_create_subscribe.txt');
    if ($result->isSuccess())
    {
        $arEventFields = array(
            'EMAIL_TO' => $email,
            'COUPON' => $codeCoupon,
            'CODE' => $code,
            'VERIFICATION_LINK' => 'https://'.$_SERVER['SERVER_NAME'].'/subscribe/verify.php?email='.$email.'&code='.$code,
            'PREHEADER'=>'Підтвердь email і використай промокод'
        );
        Bitrix\Main\Diag\Debug::writeToFile('SUCCESS', "new generation " , '/debug_create_subscribe.txt');

        CEvent::Send('BS_DISCOUNT_REGISTER','s1',$arEventFields);
    }
    else
    {
        Bitrix\Main\Diag\Debug::writeToFile('NOT SUCCESS', "new generation " , '/debug_create_subscribe.txt');
        Bitrix\Main\Diag\Debug::writeToFile($result->getErrorMessages(), "new generation " , '/debug_create_subscribe.txt');
        AddMessage2Log($result->getErrorMessages());
    }
    Bitrix\Main\Diag\Debug::writeToFile('END GENERATION', "new generation " , '/debug_create_subscribe.txt');
}


echo json_encode(['msg' => $msg]);
?>