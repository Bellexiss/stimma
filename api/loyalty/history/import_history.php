<?php
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::includeModule('highloadblock');

// ID твоего HL-блока
$HL_ID = 22;

// Загружаем JSON
$json = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/api/loyalty/history/9.json");
$data = json_decode($json, true);

//die('*');
// Получаем сущность HL-блока
$hlblock = HL\HighloadBlockTable::getById($HL_ID)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entityDataClass = $entity->getDataClass();

foreach ($data as $item) {
    $dateStr = $item["date"];
    $dateObj = new DateTime(substr($dateStr, 0, 8) . ' 00:00:00', 'Ymd H:i:s');
    $result = $entityDataClass::add([
    "UF_DATE"      => $dateObj,
        "UF_PRODUCT"   => $item["product"],
        "UF_XML_ID"    => $item["xml_id"],
        "UF_QUANTITY"  => $item["quantity"],
        "UF_SUM"       => $item["sum"],
        "UF_WAREHOUSE" => $item["Warehouse"]
    ]);
    //PR($result->getErrorMessages());
}

echo "Импорт завершён!";
?>
