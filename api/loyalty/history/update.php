<?php
use Bitrix\Main\Entity;
use Bitrix\Highloadblock as HL;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('highloadblock');

$hlblock = HL\HighloadBlockTable::getById(22)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entityDataClass = $entity->getDataClass();

$query = new Entity\Query($entityDataClass);
$query->setSelect([
    'HL_ID' => 'ID',
    'HL_XML_ID' => 'UF_XML_ID',
    'USER_ID' => 'USER.ID',
    'USER_LOGIN' => 'USER.LOGIN'
]);

$query->registerRuntimeField(
    'USER',
    new Entity\ReferenceField(
        'USER',
        \Bitrix\Main\UserTable::getEntity(),
        ['=this.UF_XML_ID' => 'ref.XML_ID'],
        ['join_type' => 'left']
    )
);

$query->setFilter(['!UF_XML_ID' => false]);

$result = $query->exec();

while ($row = $result->fetch()) {
    if(empty($row['USER_ID'])) continue;

    PR($row);
}
