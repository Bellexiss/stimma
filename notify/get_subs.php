<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
\Bitrix\Main\Diag\Debug::writeToFile(file_get_contents('php://input'), 'just php_input', 'notify_test.txt');
$data = json_decode(file_get_contents('php://input'), true);
//BTbG9izVoWHV9GS3yn9ra7cjAC4knbwingqQhsyP
$key = $data['key'];
$chat_id = $data['chat_id'];

$find = CUser::GetList($by='ID', $order='ASC', ['%UF_INVITE_LINK'=>$key])->Fetch();
if($find['ID'] > 0)
{
    $user = new CUser;
    $user->Update($find['ID'], ['UF_CHAT_ID'=>$chat_id]);
}


\Bitrix\Main\Diag\Debug::writeToFile($data, '_data', 'notify_test.txt');

