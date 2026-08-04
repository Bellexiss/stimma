<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<? global $arTheme;?>
<?
if(strpos($APPLICATION->GetCurPage(),'/news/') !== false)
    $arParams['SEF_FOLDER'] = '/news/';
elseif(strpos($APPLICATION->GetCurPage(),'/blog/') !== false)
    $arParams['SEF_FOLDER'] = '/blog/';
?>
    <div class="blog-grid-block">
        <?
        foreach($arResult['ITEMS'] as $index => $arItem)
        {
            $link = (LANGUAGE_ID == 'ua' ? '' : '/ru').$arParams['SEF_FOLDER'].$arItem['CODE'].'/';
            if(!empty($arItem['PROPERTIES']['LINK']['VALUE']))
                $link = $arItem['PROPERTIES']['LINK']['VALUE'];

            ?>
            <div class="blog-item-cont">
                <div class="blog-item">
                    <div class="blog-item-title">
                        <a href="<?=$link?>">
                            <?=LANGUAGE_ID == 'ua' ? $arItem['PROPERTIES']['NAME_UA']['VALUE'] : $arItem['NAME']?>
                        </a>
                    </div>
                    <div class="blog-item-img">
                        <a href="<?=$link?>">
                            <img src="<?=$arItem['FIELDS']['PREVIEW_PICTURE']['SRC']?>">
                        </a>
                    </div>
                    <div class="blog-item-desc">
                        <?=LANGUAGE_ID=='ua' ? $arItem['PROPERTIES']['BNR_DOP_TEXT_UA']['~VALUE']['TEXT'] : $arItem['PREVIEW_TEXT']?>
                    </div>
                    <div class="blog-item-link">
                        <a href="<?=$link?>">
                            <?=LANGUAGE_ID == 'ua' ? 'Детальніше' : 'Подробнее'?>
                            <span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>
					</span>
                        </a>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    </div>
<?=$arResult['NAV_STRING']?>
<?
?>
