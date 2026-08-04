<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$json = [];

function GetById($record,$ua)
{
    if(!$ua && strpos($record['DETAIL_PAGE_URL'], '/ru/') !== false)
        $record['DETAIL_PAGE_URL'] = '/ru'.$record['DETAIL_PAGE_URL'];
    $json = [];
    $img = false;

    $img = $record['DETAIL_PICTURE'];
    if(!$img)
        $img = $record['PREVIEW_PICTURE'];

    # Цена
    $minPrice = CCatalogProduct::GetOptimalPrice($record['ID']);

    if($minPrice['RESULT_PRICE']['BASE_PRICE'] > $minPrice['RESULT_PRICE']['DISCOUNT_PRICE'])
        $minPrice['RESULT_PRICE']['DISCOUNT_DIFF'] = $minPrice['RESULT_PRICE']['BASE_PRICE'] - $minPrice['RESULT_PRICE']['DISCOUNT_PRICE'];


    $priceHtml = '<div class="catalog-item-price" data-entity="price">'.FormatCurrency($minPrice['RESULT_PRICE']['DISCOUNT_PRICE'], 'UAH').'</div>';

    if($minPrice['DISCOUNT_DIFF'])
        $priceHtml .= '<div class="catalog-item-price-old cip311">'.FormatCurrency($minPrice['RESULT_PRICE']['BASE_PRICE'], 'UAH').'</div>';

    ?>
    <?
    # /Цена

    $sizes = '';
    $tpList = CIBlockElement::GetList([], ['PROPERTY_CML2_LINK' => $record['ID'], 'ACTIVE' => 'Y']);
    $indexOFfer = 0;
    global $DB;

    while ($tp = $tpList -> GetNextElement())
    {
        $fields = $tp -> GetFields();
        $props = $tp -> GetProperties();
        $slider = [];

        if(!$img)
            $img = $fields['PREVIEW_PICTURE'];
        if(!$img)
            $img = $fields['DETAIL_PICTURE'];

        $sizes .= '
            <label data-entity="scu-value" data-csize="L-XL" data-id="'.mb_strtoupper($props['RAZMER']['VALUE']).'" class="'.(!$indexOFfer ? 'active' : '').'">
                <input type="radio" name="radio'.$fields['ID'].'">
                <span aria-label="'.$fields['NAME'].'" class="catalog-item-size">
                                                '.mb_strtoupper($props['RAZMER']['VALUE']).'                                      
                </span>
            </label>
        ';
        //$sizes .= '<div class="catalog-item-size '.(!$indexOFfer ? 'active' : '').'" data-entity="scu-value" data-id="'.$fields['ID'].'"><a href="'.$record['DETAIL_PAGE_URL'].'">'.mb_strtoupper($props['RAZMER']['VALUE']).'</a></div>';
        $indexOFfer++;
    }

    $img = CFile::ResizeImageGet($img, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
    $slider[] = '<div class="catalog-item-img "> 
                        <a href="'.$record['DETAIL_PAGE_URL'].'" aria-label="'.$record['NAME'].'">
                            <img class="simg23333" src="'.$img.'">
                        </a>
                    </div>';
    $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $record['ID']);
    while ($file = $res -> Fetch())
    {
        $file = $file["VALUE"];

        if(strpos($file,'.m4v') !== false || strpos($file,'.mp4') !== false || strpos($file,'.MP4') !== false)
            continue;

        $path = CFile::ResizeImageGet($file, array('width'=>530, 'height'=>780), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
        $slider[] = '<div class="catalog-item-img "> 
                        <a href="'.$record['DETAIL_PAGE_URL'].'" aria-label="'.$record['NAME'].'">
                            <img class="simg23333" src="'.$path.'">
                        </a>
                    </div>';
    }


    $json['price'] = $priceHtml;
    //$json['img'] = $img;
    $json['img'] = $slider;
    $json['sizes'] = $sizes;
    $json['url'] = $record['DETAIL_PAGE_URL'];
    $json['id'] = $props['CML2_LINK']['VALUE'];

    return $json;
}

if(!empty($_POST['id']))
{
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'ID' => $_POST['id'], 'ACTIVE' => 'Y'],false, false,['ID','IBLOCK_ID','NAME','CODE','PREVIEW_PICTURE','DETAIL_PICTURE','DETAIL_PAGE_URL']);
    $names = [];
    while ($record = $res -> GetNext())
    {
        $json[$record['CODE']] = GetById($record,$ua);
        $names[] = $record['NAME'];
    }

    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'!ID' => $_POST['id'], 'ACTIVE' => 'Y', 'NAME' => $names],false, false,['ID','IBLOCK_ID','NAME','CODE','PREVIEW_PICTURE','DETAIL_PICTURE','DETAIL_PAGE_URL']);
    while ($record = $res -> GetNext())
        $json[$record['CODE']] = GetById($record,$ua);
}
echo json_encode($json);
?>