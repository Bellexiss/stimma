<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
// 1009345485 Женя
// 160831010 Я

require $_SERVER['DOCUMENT_ROOT'].'/notify/notify.php';

$api_key = 'wpW76V66zXCwo4rHU4c3l8JMDDEkzVu4vze4pUDU'; // anybag
//$api_key = '1jKSlpexvB6bUQdaWPZTdrxxYVnyt6ctPSJ9IClu'; // хлорка

$simpleMsgID_anybag = 'wpW76V66zXCwo4rHU4c3l8JMDDEkzVu4vze4pUDU/hook/QX8YZFSiY7BteVmw3YDCpnJX93EW93uQjtA00t21';

$notify = new notify($api_key);

//$notify->sendNotifyMessage($simpleMsgID_anybag);
//$notify->getInviteKey();
//$notify->getUserGroup();
//$notify->updateUserGroup('Тестова група2', 'N');
//$notify->updateUserGroup('Я змінюю групу', 'Y', 31);
//$notify->addUserToGroup(1009345485, 30);
//$notify->removeUserFromGroup(160831010, 30);
//$notify->removeGroup(30);
//$notify->getUserListFromGroup(29);
?>



