<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Онлайн сертификат");
$APPLICATION->SetPageProperty("description", "Модний жіночий одяг від українського виробника ТМ STIMMA. Онлайн сертификат");
$APPLICATION->SetPageProperty("title", "Онлайн сертификат | Інтернет-магазин STIMMA");

?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "content.php",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_MODE" => "html",
    ),
    false,
    Array('HIDE_ICONS' => 'N')
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>