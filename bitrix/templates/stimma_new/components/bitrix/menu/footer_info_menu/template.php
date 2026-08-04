<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$this->setFrameMode(true);
$colmd = 12;
$colsm = 12;
// print_r($arResult);
?>
<?if($arResult):?>

    <ul class="footer-block-list">
        <?
        foreach ($arResult as $index => $arItem)
        {
            ?><li>
            <a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
            </li><?
        }
        ?>
    </ul>
<?endif;?>