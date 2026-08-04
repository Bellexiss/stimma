<?
#print_r($_SERVER);
$_SERVER['DOCUMENT_ROOT'] = '/home/stimma/www/stimma.com.ua/public_html';
//file_put_contents('/home/stimma/www/stimma.com.ua/update_log.txt', var_export($_SERVER, 1));
require("/home/stimma/www/stimma.com.ua/public_html/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;

$hlBlockId = 20;

// Подключить модули
Loader::includeModule("highloadblock");

// Получаем сущность HL-блока
$hlblock = HighloadBlockTable::getById($hlBlockId)->fetch();
$entity = HighloadBlockTable::compileEntity($hlblock);
$entityClass = $entity->getDataClass();

// Сегодня минус 15 дней
$minDate = (new \Bitrix\Main\Type\DateTime())->add('-15 days');

// Выборка нужных записей
$res = $entityClass::getList([
    'select' => ['ID', 'UF_USER_ID', 'UF_PHONE', 'UF_EMAIL', 'UF_COUPON', 'UF_DATE'],
    'filter' => [
        '<=UF_DATE' => $minDate,
		'UF_SENT' => false,
        '!UF_ORDER' => false
    ]
]);

while ($row = $res->fetch()) {
    CEvent::Send("15DAYS_EMAIL_COUPON", SITE_ID, [
        "EMAIL_TO" => $row['UF_EMAIL'],
        "PHONE" => $row['UF_PHONE'],
        "COUPON" => $row['UF_COUPON'],
    ]);

    $entityClass::update($row['ID'], ["UF_SENT" => 1]);
}
