<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ОПЛАТА И ДОСТАВКА");
$APPLICATION->SetPageProperty("description", "Модная женская одежда от украинского производителя TM STIMMA. ОПЛАТА И ДОСТАВКА");
$APPLICATION->SetPageProperty("title", "ОПЛАТА И ДОСТАВКА | Интернет-магазин STIMMA");
$ru=LANGUAGE_ID=='ru'?'/ru':'';

?>
    <div class="breadcrumbs-cont">
        <div class="wrapper">
            <div class="breadcrumbs-block">
                <a href="<?=$ru?>/" class="breadcrumb-item">
                    STIMMA
                </a>
                <span class="breadcrumb-sep">
    				<svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
					</svg>
    			</span>
                <span class="breadcrumb-item">
    				<? if (LANGUAGE_ID == 'ua'): ?>
                        Доставка та оплата
                    <? else: ?>
                        Доставка и оплата
                    <? endif; ?>
    			</span>
            </div>
        </div>
    </div>

    <div class="info-page-content">
        <h1 class="info-page-title">
            <? if (LANGUAGE_ID == 'ua'): ?>
                Доставка та оплата
            <? else: ?>
                Доставка и оплата
            <? endif; ?>
        </h1>
        <div class="delivery-info-cont">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_RECURSIVE" => "N",
                    "AREA_FILE_SHOW" => "file",
                    "EDIT_MODE" => "html",
                    "PATH" => "oplata.php"
                ),
                false,
                Array(
                    'HIDE_ICONS' => 'N'
                )
            );?>

        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>