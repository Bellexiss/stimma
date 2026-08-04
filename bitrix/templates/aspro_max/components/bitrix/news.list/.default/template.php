<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
$banenrs = $arResult['BANNERS'];
?>
<div class="desctop_main_video">
    <?
    foreach ($banenrs[522] as $index => $banenr)
    {
        //$file = CFile::GetFileArray($banenr['PREVIEW_PICTURE']['ID'])['SRC'];
        $file = CFile::ResizeImageGet($banenr['PREVIEW_PICTURE']['ID'], array('width'=>1900, 'height'=>1069), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $link = $banenr['PROPERTIES']['LINK']['VALUE'] ? $banenr['PROPERTIES']['LINK']['VALUE'] : '/catalog/novinki/';
        ?>
        <a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?><?=$link?>">
            <img src="<?=$file?>" alt="">
        </a>
        <?
    }
    ?>
</div>

<div class="mobile_main_video">
    <?
    foreach ($banenrs[521] as $index => $banenr)
    {
        //$file = CFile::GetFileArray($banenr['PREVIEW_PICTURE']['ID'])['SRC'];
        $file = CFile::ResizeImageGet($banenr['PREVIEW_PICTURE']['ID'], array('width'=>800, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $link = $banenr['PROPERTIES']['LINK']['VALUE'] ? $banenr['PROPERTIES']['LINK']['VALUE'] : '/catalog/novinki/';
        ?>
        <a href="<?=LANGUAGE_ID == 'ru' ? '/ru' : ''?><?=$link?>">
            <img src="<?=$file?>" alt="">
        </a>
        <?
    }
    ?>

</div>
