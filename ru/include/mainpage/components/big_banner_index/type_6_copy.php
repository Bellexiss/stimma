<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?


$banenrs = [];
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y']);
while ($record = $res -> Fetch())
{
    $banenrs[$record['IBLOCK_SECTION_ID']][$record['ID']] = $record;
}

$desctop = 0;
$mobile = $desctop ? 0 : 1;
?>

<?
{
    ?>
    <?
    $mainWidth = 560;
    $mainHeight = 315;
    ?>
    <div class="desctop_main_video">
        <?
        foreach ($banenrs[522] as $index => $banenr)
        {
            $file = CFile::GetFileArray($banenr['PREVIEW_PICTURE'])['SRC'];
            ?>
            <a href="/ru/catalog/novinki/">
                <img src="<?=$file?>" alt="">
            </a>
            <?
        }
        ?>
        <?/*<iframe
            style="width: 100%;height:930px;"
            src="https://www.youtube.com/embed/SJDteF5p0dY?autoplay=1&controls=0&loop=1&modestbranding=1&rel=0&playlist=SJDteF5p0dY&modestbranding=1"
            title="Стильний жіночий одяг STIMMA"
            frameborder="0"
            allow="loop; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            data-video_proportion="<?=$mainWidth / $mainHeight?>"
        ></iframe>
        */?>
    </div>
    <?
}
{
    ?>
    <div class="mobile_main_video">
        <?
        foreach ($banenrs[521] as $index => $banenr)
        {
            $file = CFile::GetFileArray($banenr['PREVIEW_PICTURE'])['SRC'];
            ?>
            <a href="/ru/catalog/novinki/">
                <img src="<?=$file?>" alt="">
            </a>
            <?
        }
        ?>
        <?/*<iframe
            style="width: 100%;height:600px;"
            src="https://youtube.com/embed/GL4jgyQ1bLU?autoplay=1&controls=0&loop=1&modestbranding=1&rel=0&playlist=GL4jgyQ1bLU&modestbranding=1"
            title="Стильний жіночий одяг STIMMA"
            frameborder="0"
            allow="loop; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>*/?>
    </div>
    <?
}
?>
    <script>
        $(document).ready(function()
        {
            if(window.innerWidth > 576)
            {
                $('.mobile_main_video').remove();
                $('.desctop_main_video').slick({dots: false,speed:1000,autoplay: true,autoplaySpeed:2000,pauseOnFocus:false,pauseOnHover:false});
            }
            else
            {
                $('.desctop_main_video').remove();
                $('.mobile_main_video').slick({dots: false,speed:1000,autoplay: true,autoplaySpeed:2000,pauseOnFocus:false,pauseOnHover:false});
            }
        })
    </script>
<?/*
    <script>
        $(document).ready(function()
        {
            $width = document.querySelector('.desctop_main_video').clientWidth;
            $rizn = 1903-$width;
            $percent = $rizn/1903;
            $height = 930-(930*$percent);
            console.log($height);

            $('.desctop_main_video iframe').css('height', $height+'px');


            $width = document.querySelector('.mobile_main_video').clientWidth;
            if($width >= 560)
            {
                $('.mobile_main_video iframe').css('height', '720px');
            }
            else
            {
                $rizn = 560-$width;
                $percent = $rizn/560;
                $height = 720-(720*$percent);
                console.log($height);

                $('.mobile_main_video iframe').css('height', $height+'px');
            }




        });
    </script>
*/?>

<?/*$APPLICATION->IncludeComponent(
	"aspro:com.banners.max",
	"top_big_banner_2",
	array(
        "SLIDER_AUTOPLAY" => "Y",
		"IBLOCK_TYPE" => "aspro_max_adv",
		"IBLOCK_ID" => "22",
		"TYPE_BANNERS_IBLOCK_ID" => "1",
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"NEWS_COUNT" => "10",
		"NEWS_COUNT2" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "DESC",
		"PROPERTY_CODE" => array(
			0 => "TEXT_POSITION",
			1 => "TARGETS",
			2 => "TEXTCOLOR",
			3 => "URL_STRING",
			4 => "BUTTON1TEXT",
			5 => "BUTTON1LINK",
			6 => "BUTTON2TEXT",
			7 => "BUTTON2LINK",
			8 => "",
		),
		"CHECK_DATES" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"BANNER_TYPE_THEME" => "TOP",
	),
	false
);*/?>