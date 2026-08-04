<?php
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule('highloadblock');
Loader::includeModule('iblock');

$hlblock = HL\HighloadBlockTable::getById(22)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entityDataClass = $entity->getDataClass();

PR($hlblock);
die();
// Кэш найденных товаров
$productCache = [];

$rsData = $entityDataClass::getList([
    'select' => ['UF_PRODUCT'],
    'filter' => ['!UF_PRODUCT' => false]
]);

while ($item = $rsData->fetch()) {
    $article = trim($item['UF_PRODUCT']);

    if (isset($productCache[$article])) {
        $product = $productCache[$article];
    } else {
        // --- 1. Ищем по свойству ARTICLE ---
        $res = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => 25, '=PROPERTY_ARTICLE' => $article],
            false,
            false,
            ['ID', 'NAME', 'PROPERTY_ARTICLE']
        );
        $product = $res->GetNext();

        // --- 2. Если не нашли, пробуем искать по названию ---
        if (!$product) {
            $res = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => 25,
                    '%NAME' => $article // поиск по части названия
                ],
                false,
                ['nTopCount' => 1], // берём только один, первый найденный
                ['ID', 'NAME', 'PROPERTY_ARTICLE']
            );
            $product = $res->GetNext();
        }

        // Кэшируем результат
        $productCache[$article] = $product ?: null;
    }

    if ($product) {
        echo "HL.UF_PRODUCT = {$article} → ✅ [{$product['ID']}] {$product['NAME']}<br>";
    } else {
        echo "HL.UF_PRODUCT = {$article} → ❌ товар не найден<br>";
    }
}