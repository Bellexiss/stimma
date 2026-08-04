<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$setting_fop = COption::GetOptionString("my_module", "setting_fop", "Y");

if (!empty($_GET['update']) && $_GET['update'] === 'qwerty') {
    $setting_fop = ($setting_fop === 'Y') ? 'N' : 'Y';
    COption::SetOptionString("my_module", "setting_fop", $setting_fop);
}

echo "Статус ФОП: " . ($setting_fop === 'Y' ? 'Включен' : 'Выключен');