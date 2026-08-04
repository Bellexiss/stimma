<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Архив коллекций");
?>

    <div class="info-page">
        <div class="info-page-tabs">
            <?/*$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "page_info_menu",
                array(
                    "COMPONENT_TEMPLATE" => "page_info_menu",
                    "ROOT_MENU_TYPE" => "info_menu",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ),
                false
            );*/?>
            <div class="tab-content" style="max-width: inherit">
                <div class="tab-pane fade active in" id="stab1-b">...</div>
            </div>
        </div>
        <div class="card-main-tabs-mobile">
            <div class="card-tabs-mobile-item">
                mobile ...
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>