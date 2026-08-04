<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<? global $arTheme;?>
<?
if(strpos($APPLICATION->GetCurPage(),'/news/') !== false)
    $arParams['SEF_FOLDER'] = '/news/';
elseif(strpos($APPLICATION->GetCurPage(),'/blog/') !== false)
    $arParams['SEF_FOLDER'] = '/blog/';

$sections=[];
$res=CIBlockSection::GetList([],['IBLOCK_ID'=>$arParams['IBLOCK_ID'],'ACTIVE'=>'Y'],false,['UF_*']);
while ($record = $res->Fetch())
    $sections[$record['ID']]=$record;
?>

<div class="breadcrumbs-cont">
    <div class="wrapper">
        <div class="breadcrumbs-block">
            <a href="#" class="breadcrumb-item">
                STIMMA
            </a>
            <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
            <a href="#" class="breadcrumb-item">
                Угода користувача
            </a>
            <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
            <span class="breadcrumb-item">
                        Статті
                    </span>
        </div>
    </div>
</div>
<div class="info-pages-list-cont">
    <div class="wrapper">
        <div class="info-pages-list">
            <a href="#" class="info-page-link active">
                <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg1.png">
                <div class="info-page-link-title">
                    Статті
                </div>
            </a>
            <a href="#" class="info-page-link">
                <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg2.png">
                <div class="info-page-link-title">
                    Угода користувача
                </div>
            </a>
            <a href="#" class="info-page-link">
                <img src="/bitrix/templates/stimma_new/images/imgnew/infopimg3.png">
                <div class="info-page-link-title">
                    Співпраця
                </div>
            </a>
        </div>
    </div>
</div>
<div class="info-page-content news-page">
    <h1 class="info-page-title">
        <?=LANGUAGE_ID == 'ua' ? 'Статті' : 'Статьи'?>
    </h1>
    <div class="info-page-menu">
        <a href="#" class="info-page-menu-item active">
            Всі статті
        </a>
        <a href="#" class="info-page-menu-item">
            Загальні поради
        </a>
        <a href="#" class="info-page-menu-item">
            Акції та знижки
        </a>
        <a href="#" class="info-page-menu-item">
            Ідеї для образів
        </a>
    </div>
    <div class="news-grid">
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim1.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Загальні поради
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Відкриття магазину STIMMA у ТРЦ "SKYMALL"
                </a>
                <div class="news-item-date">
                    30.08.2023
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim2.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Акції та знижки
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Зустрінемось на Galychyna Fashion Expo 2023
                </a>
                <div class="news-item-date">
                    01.08.2023
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim3.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Акції та знижки
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Твоя знижка -30% для прохолодних вечорів!
                </a>
                <div class="news-item-date">
                    29.04.2023
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim4.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Джемпер – базова річ у жіночому гардеробі.
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim5.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    У чому різниця між джемпером та светром?
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim6.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Сукня-сорочка: зручність та функціональність
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim7.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    В’язана сукня: модні кольори 2022
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim8.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Об’ємний светр – тренд сезону
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
        <div class="news-item-cont">
            <div class="news-item">
                <a href="#" class="news-item-img">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/newsim9.png">
                </a>
                <div class="news-item-types">
                    <a href="#" class="news-item-type">
                        Ідеї для образів
                    </a>
                </div>
                <a href="#" class="news-item-name">
                    Сарафан із класичним кроєм – тренд весни.
                </a>
                <div class="news-item-date">
                    30.11.2021
                </div>
            </div>
        </div>
    </div>
    <div class="pagination-cont">
        <div class="pagination-block">
            <a href="#" class="pagination-arrow pagination-item disabled">
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M-3.76701e-05 6.53121C-3.76701e-05 6.68306 0.058001 6.83506 0.173931 6.95099L6.11143 12.8885C6.34344 13.1205 6.71913 13.1205 6.95099 12.8885C7.18285 12.6565 7.183 12.2808 6.95099 12.0489L1.43327 6.53121L6.95099 1.01349C7.183 0.781487 7.183 0.40579 6.95099 0.173931C6.71899 -0.0579281 6.34329 -0.0580769 6.11143 0.173931L0.173931 6.11143C0.058001 6.22736 -3.76701e-05 6.37936 -3.76701e-05 6.53121Z" fill="currentcolor"/>
                </svg>
            </a>
            <div class="padination-pages">
                <a href="#" class="pagination-item active">
                    1
                </a>
                <a href="#" class="pagination-item">
                    2
                </a>
                <a href="#" class="pagination-item">
                    3
                </a>
                <span class="pagination-item pagination-sep">...</span>
                <a href="#" class="pagination-item">
                    15
                </a>
            </div>
            <a href="#" class="pagination-arrow pagination-item">
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.12504 6.53121C7.12504 6.68306 7.067 6.83506 6.95107 6.95099L1.01357 12.8885C0.78156 13.1205 0.405865 13.1205 0.174006 12.8885C-0.0578535 12.6565 -0.058002 12.2808 0.174006 12.0489L5.69173 6.53121L0.174006 1.01349C-0.058002 0.781487 -0.058002 0.40579 0.174006 0.173931C0.406014 -0.0579281 0.781709 -0.0580769 1.01357 0.173931L6.95107 6.11143C7.067 6.22736 7.12504 6.37936 7.12504 6.53121Z" fill="currentcolor"/>
                </svg>
            </a>
        </div>
    </div>
</div>

    <div class="blog-grid-block" style="display:none">
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
