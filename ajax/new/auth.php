<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$phone = $_REQUEST['USER_LOGIN_PHONE'];
$password = $_REQUEST['USER_PASSWORD_PHONE'];
$json = ['status'=>0];

$phone = preg_replace('/[^0-9+]/', '', $phone);
$phone = str_replace('+380','0',$phone);


global $DB,$USER;

$user = $DB->Query('select * from b_user where PERSONAL_PHONE like \'%'.$phone.'%\' or LOGIN = \'%'.$phone.'%\'');

if($user = $user->Fetch())
{
    $user = CUser::GetList($by = 'ID', $order = 'DESC', ['ID' => $user['ID']],['SELECT'=>['UF_PHONE_CODE']]);
    if($user = $user->Fetch())
    {
        if($user['UF_PHONE_CODE'] == $password)
        {
            $USER->Authorize($user['ID']);
            $json = ['status'=>1];
        }
        else
        {
            $arAuthResult = $USER->Login($user['LOGIN'], $password);
            if(!is_array($arAuthResult)&&$arAuthResult)$json = ['status'=>1];
        }
    }


}

echo json_encode($json);
?>