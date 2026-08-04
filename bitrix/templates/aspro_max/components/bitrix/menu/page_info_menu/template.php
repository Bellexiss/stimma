<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$this->setFrameMode(true);
$colmd = 12;
$colsm = 12;
// print_r($arResult);
?>
<?if($arResult):?>
<?
    $page = $APPLICATION -> GetCurPage();
    ?>
    <ul class="nav nav-tabs">
        <?
        foreach ($arResult as $index => $arItem)
        {
            ?>
            <li class="nav-item <?=$arItem['LINK'] == $page ? 'active' : ''?>">
                <a class="nav-link"  href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
            </li>
            <?
        }
        ?>

    </ul>
<?endif;?>