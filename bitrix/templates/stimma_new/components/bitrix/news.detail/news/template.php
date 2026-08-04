<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<?$this->setFrameMode(true);?>	
<?use \Bitrix\Main\Localization\Loc;?>
<?
$ru=LANGUAGE_ID=='ru'?'/ru':'';
$name = LANGUAGE_ID =='ua'&&$arResult['PROPERTIES']['NAME_UA']['VALUE']?$arResult['PROPERTIES']['NAME_UA']['VALUE']:($arResult['NAME']?$arResult['NAME']:$arResult['~NAME']);
$file1=CFile::GetFileArray($arResult['PROPERTIES']['PHOTO']['VALUE'][0])['SRC'];
$file2=CFile::GetFileArray($arResult['PROPERTIES']['PHOTO']['VALUE'][1])['SRC'];
$shortText = LANGUAGE_ID =='ua'&&$arResult['PROPERTIES']['BNR_DOP_TEXT_UA']['~VALUE']['TEXT']?$arResult['PROPERTIES']['BNR_DOP_TEXT_UA']['~VALUE']['TEXT']:$arResult['PREVIEW_TEXT'];
$detailText = LANGUAGE_ID =='ua'&&$arResult['PROPERTIES']['WIDE_TEXT_UA']['~VALUE']['TEXT']?$arResult['PROPERTIES']['WIDE_TEXT_UA']['~VALUE']['TEXT']:$arResult['DETAIL_TEXT'];
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
            <a href="<?=$ru?>/projects/proects/" class="breadcrumb-item">
                <?=LANGUAGE_ID=='ua'?'Проєкти':'Проекты'?>
            </a>
            <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"/>
                        </svg>
                    </span>
            <span class="breadcrumb-item">
                        <?=$name?>
                    </span>
        </div>
    </div>
</div>

<div class="project-page">
    <div class="wrapper">
        <div class="project-card">
            <div class="project-left-block">
                <h1 class="project-title">
                    <?=$name?>
                </h1>
                <div class="project-img-left">
                    <img src="<?=$file1?>">
                </div>
            </div>
            <div class="project-right-block">
                <div class="project-right-img">
                    <img src="<?=$file2?>">
                </div>
                <div class="project-text-block">
                    <p>
                        <?=$shortText?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="project-bottom-cont">
    <div class="project-bottom-text">
        <p>
            <?=$detailText?>
        </p>
    </div>
</div>
<?// form question?>

