<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc,
	  \Bitrix\Main\Web\Json;?>
<?
$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $arParams['SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
$sectionName = LANGUAGE_ID == 'ua' ? $res['UF_NAME_UA'] : $res['NAME'];


$arJsonProducts = [];
?>
<?$universalID = 'id_'.uniqid()?>
<?$variants = []?>
<?$isNew = $arParams['IS_NEW'];?>
<?$data = $arParams['DATA']?>
<?

?>
<?$gGroups = explode(',',$USER -> GetGroups());?>
<?

$selected = 0;
$available = true; //$arItem['PRODUCT']['AVAILABLE']; //todo змінити
//$availableTextIn = GetMessage('EX_IN_STORE ');
//$availableTextOut = GetMessage('NO_EX_IN_STORE ');
$tree = $arResult['TREE_PROPS'];

?>
<div class="<?=$arParams['MAIN_CLASS'] ? $arParams['MAIN_CLASS'] : 'look-dop-item-list'?>">
    <?/*
    <div class="look-dop-item">
        <div class="catalog-item">
            <div class="catalog-item-top">
                <div class="catalog-item-img">
                    <a href="#" tabindex="0">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/cardlookimg1.png">
                    </a>
                </div>
                <div class="catalog-item-favorite">
                    <a href="#" tabindex="0">
                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                        </svg>
                    </a>
                </div>
                <div class="catalog-item-more-info">
                    <div class="catalog-item-btn-buy">
                        <a href="#" tabindex="0">
                            Додати до кошика
                        </a>
                    </div>
                    <div class="catalog-item-size-list">
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                37
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                38
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                               39
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                40
                                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="catalog-item-info">
                <a href="#" class="catalog-item-name" tabindex="0">
                    Жіночі чоботи Stimma Глос...
                </a>
                <div class="catalog-item-details">
                    <div class="catalog-item-price-block">
                        <div class="catalog-item-price">
                            4 199 ₴
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="look-dop-item">
        <div class="catalog-item">
            <div class="catalog-item-top">
                <div class="catalog-item-img">
                    <a href="#" tabindex="0">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/cardlookimg2.png">
                    </a>
                </div>
                <div class="catalog-item-favorite">
                    <a href="#" tabindex="0">
                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="catalog-item-info">
                <a href="#" class="catalog-item-name" tabindex="0">
                    Жіночий браслет Stimma ...
                </a>
                <div class="catalog-item-details">
                    <div class="catalog-item-price-block">
                        <div class="catalog-item-price">
                            199 ₴
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="look-dop-item">
        <div class="catalog-item">
            <div class="catalog-item-top">
                <div class="catalog-item-img">
                    <a href="#" tabindex="0">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/cardlookimg3.png">
                    </a>
                </div>
                <div class="catalog-item-favorite">
                    <a href="#" tabindex="0">
                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                        </svg>
                    </a>
                </div>
                <div class="catalog-item-more-info">
                    <div class="catalog-item-btn-buy">
                        <a href="#" tabindex="0">
                            Додати до кошика
                        </a>
                    </div>
                    <div class="catalog-item-size-list">
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                XS
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                S
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                M
                                            </span>
                        </label>
                        <label>
                            <input type="radio" name="radio2" tabindex="0">
                            <span class="catalog-item-size">
                                                XS
                                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="catalog-item-info">
                <a href="#" class="catalog-item-name" tabindex="0">
                    Жіноча сумка Stimma Глорія...
                </a>
                <div class="catalog-item-details">
                    <div class="catalog-item-price-block">
                        <div class="catalog-item-price">
                            3 199 ₴
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="look-dop-item">
        <div class="catalog-item">
            <div class="catalog-item-top">
                <div class="catalog-item-img">
                    <a href="#" tabindex="0">
                        <img src="/bitrix/templates/stimma_new/images/imgnew/cardlookimg4.png">
                    </a>
                </div>
                <div class="catalog-item-favorite">
                    <a href="#" tabindex="0">
                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"></path>
                        </svg>
                    </a>
                </div>
                <div class="catalog-item-more-info">
                    <div class="catalog-item-btn-buy">
                        <a href="#" tabindex="0">
                            Додати до кошика
                        </a>
                    </div>
                </div>
            </div>
            <div class="catalog-item-info">
                <a href="#" class="catalog-item-name" tabindex="0">
                    Жіночий ремінь Stimma ...
                </a>
                <div class="catalog-item-details">
                    <div class="catalog-item-price-block">
                        <div class="catalog-item-price">
                            499 ₴
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    */?>

<?
foreach ($arResult['ITEMS'] as $key => $arItem)
{
    showItem($arItem, $arParams);
}

?>
</div>
<?/*<div class="<?=$arParams['WRAP_CLASS'] ? $arParams['WRAP_CLASS'] : 'catalog-items-block'?>">
    <?
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        showItem($arItem, $arParams);
    }
    ?>
</div>*/?>
