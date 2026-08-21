<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Sale\DiscountCouponsManager;
if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
{
    $json=[];
}

$ru=LANGUAGE_ID=='ru'?'/ru':'';
if(isset($_GET['remove']) && intval($_GET['remove']) > 0)
{
    CSaleBasket::Delete($_GET['remove']);
    LocalRedirect($APPLICATION->GetCurPage());
    exit();
}
use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

global $USER,$DB;

if($USER->IsAuthorized())
{
    $user=CUser::GetByID($USER->GetID())->Fetch();
    $result = GetBalance($user['XML_ID']);
    $balance = $result['response']['Balance'];
}
else
    $balance=0;

global $isJulyAction;

$useCoupon = 1;
$isSert = false;
$onlySert = true;
$withStims=[];
$stims=$minus_price=0;
$basketProducts=[];
{
    $isOrder = 1;
    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $index => $row)
    {

        $fetch=$DB->Query('select* from basket_stims where UF_ID = ' . $row['data']['ID']);
        if($fetch=$fetch->Fetch())
        {
            $withStims[$fetch['UF_ID']]=$fetch;
            $stims += ($fetch['UF_STIMS']*$row['data']['QUANTITY']);
            $minus_price+=($row['data']['PRICE']*$row['data']['QUANTITY']);
        }
        $pId = $row['data']['PRODUCT_ID'];

        if(in_array($pId, [25934,25935,25936,25937,25939]))
            $isSert = true;
        if(!in_array($pId, [25934,25935,25936,25937,25939]))
            $onlySert = false;

        $mainIDs = [];
        $product = CCatalogProduct::GetByID($pId);

        if(isset($_GET['show']))
        {
            ?><pre>1 -> <?=print_r($pId, 1)?></pre><?
            ?><pre>2 -> <?=print_r($product['QUANTITY'], 1)?></pre><?
        }
        if(!$product['QUANTITY'] && $pId != 35425 && $pId != 35428 && $pId != 35430 && $pId != 35432 && $pId != 35434)
            $isOrder = 0;
        $p = CIBlockElement::GetByID($pId);
        if($p = $p-> GetNextElement())
        {
            $p = $p -> GetProperties();
            $basketProducts[$pId]['PROPERTIES']=$p;
            $mainIDs[] = $p['CML2_LINK']['VALUE'] ? $p['CML2_LINK']['VALUE'] : $pId;
            if(LANGUAGE_ID == 'ua'){if($p['NAME_UA']['VALUE'])$arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] = $p['NAME_UA']['VALUE'];}

            if(!$product['QUANTITY'] && $pId != 35425 && $pId != 35428 && $pId != 35430 && $pId != 35432 && $pId != 35434 )
            {
                if(LANGUAGE_ID == 'ua')
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] .=' <span style="color:#900020">(Не в наявності)</span>';
                else
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] .=' <span style="color:#900020">(Нет в наличии)</span>';
            }

            if(in_array('rasprodazha', $p['SELECTION']['VALUE_XML_ID']))
                $useCoupon = 0;
        }

        $pProds = [];
        if(!empty($mainIDs))
        {
            $sections = [];
            $res = $DB -> Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID in ('.implode(',',$mainIDs).')');
            //$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ID' => $mainIDs]);
            while ($record = $res -> Fetch())
                $sections[$record['IBLOCK_SECTION_ID']] = $record['IBLOCK_SECTION_ID'];

            $isYour30 = in_array(389, $sections) || in_array(383, $sections) || in_array(378, $sections);

            $uGroups = $USER->GetUserGroupArray();
            if(in_array(9,$uGroups)) $isYour30 = false;
        }

    }
}

$chast = true;
$uGroups = $USER->GetUserGroupArray();
if(in_array(9,$uGroups)) $isYour30 = false;

$res=$DB->Query('select * from max_color_reference');
while ($record = $res->Fetch())
    $colors[$record['UF_XML_ID']]=$record;


//=============================================================================================
$totalBonus = $alLSum = $allQuantity = 0;
$basket = $arResult['JS_DATA']['GRID']['ROWS'];
foreach($basket as $index => $item) {
	$dpu = CIBlockElement::GetByID($item['PRODUCT_ID'])->GetNext();
	$dpuprop = CIBlockElement::GetList([],['ID' => $item['data'][PRODUCT_ID]],false,false,['ID', 'NAME', 'PROPERTY_PROP_BONUS', 'PROPERTY_PROP_BONUS_PRICE'])->Fetch();
	$item = $item['data'];
	if (isset($dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE])) {
		$totalBonus += $dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE] * $item['QUANTITY'];
	}
	$alLSum += $item['PRICE']*$item['QUANTITY'];
    $allQuantity += $item['QUANTITY'];
}


$bonus_part = $bonus_ok = $userId = false;
if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();

if($userId)
    $user=CUser::GetByID($userId)->Fetch();
else
    $user=[];

if ($userId == 66693 ) {
	$bonus['Balance'] = 0;
	$XML_ID = $USER->GetParam('XML_ID');
	$XML_ID = '03d03252-6100-11ee-96d4-f02f742215f1';
	$res = GetBalance($XML_ID);
	if ( isset($res['response_raw']) ) {
		$res['response_raw'] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $res['response_raw']);
		$bonus = json_decode(trim($res['response_raw']), true);
	}
	
	if ( isset($bonus['Balance']) && $bonus['Balance'] > 0 ) {
		//echo "----XML_ID=$XML_ID<==__<br>";
		//echo "<pre>--1--";print_R($bonus);echo "--2--";print_R($res['response_raw']);echo "</pre>";
		if ( $alLSum == $totalBonus && $bonus['Balance'] >= $totalBonus && $totalBonus > 0 ) {
			$bonus_ok = true;
			$bonus_part = false;
		}
		if ( $alLSum > $totalBonus && $bonus['Balance'] >= $totalBonus && $totalBonus > 0 ) {
			$bonus_ok = false;
			$bonus_part = true;
		}
	

		
	}
		
		/*echo "userId=$userId<===<br>";
		echo "alLSum=$alLSum<===<br>";
		echo "totalBonus=$totalBonus<===<br>";
		echo "<pre>";print_R($bonus);echo "</pre>";*/
		//exit();
	
}
//==============================================================================================

$dost=[];

if($USER->IsAuthorized())
{
    $res = $DB->Query('select * from user_adresses where UF_UID='.$USER->GetID());
    while ($record = $res->Fetch())
    {
        if($record['UF_DELIVERY_ID'] != 18)
        {
            if($record['UF_DELIVERY_ID'] == 14 || $record['UF_DELIVERY_ID'] == 17)
            {
                if($record['UF_CITY_ID'])
                    $record['CITY'] = $DB->Query('select * from np_cities_new where ID = ' . $record['UF_CITY_ID'])->Fetch()['UF_NAME_'.strtoupper(LANGUAGE_ID)];
                if($record['UF_VIDD_ID'])
                {
                    $record['VIDD'] = $DB->Query('select * from np_posts_new where ID = ' . $record['UF_VIDD_ID'])->Fetch();
                    $record['VIDD'] = '№'.$record['VIDD']['UF_NUMBER'].' ' .$record['VIDD']['UF_SHORT_ADRESS_UA'];
                }
            }

            if($record['UF_DELIVERY_ID'] == 15)
            {
                if($record['UF_CITY_ID'])
                {
                    $record['CITY'] = $DB->Query('select * from ukrposhta_cities where ID = ' . $record['UF_CITY_ID'])->Fetch();
                    $record['CITY'] = $record['CITY']['UF_CITYTYPE_UA'].', ' . $record['CITY']['UF_CITY_UA'] .', ' . $record['CITY']['UF_DISTRICT_UA'] . ' р-н.'.', ' . $record['CITY']['UF_REGION_UA'] . ' обл.';
                }
                if($record['UF_VIDD_ID'])
                {
                    $record['VIDD'] = $DB->Query('select * from ukrposhta_posts where ID = ' . $record['UF_VIDD_ID'])->Fetch();
                    $record['VIDD'] = $record['VIDD']['UF_POSTINDEX'] . ', ' . $record['VIDD']['UF_ADDRESS'];
                }
            }
        }

        $dost[$record['UF_DELIVERY_ID']] = $record;
    }
}
?>

<?
if(isset($_SESSION['COUPON']) && !empty($_SESSION['COUPON']) && !$useCoupon)
{
    DiscountCouponsManager::delete($_SESSION['COUPON']);
    unset($_SESSION['COUPON']);
    LocalRedirect($APPLICATION->GetCurPage());
    exit();
}
/*?><script>window.use_coupon = <?=$isYour30 ? 1 : 0?>;</script><?*/
?><script>window.use_coupon = <?=$useCoupon ? 1 : 0?>;</script><?
?><script>window.is_order = <?=$isOrder?>;</script><?
?><script>window.isAction08 = <?=$arResult['IS_ACTION_08'] ? 1 : 0?>;</script><?
?><script>window.isActionSelfDate = <?=$arResult['IS_ACTION_SELFDATE'] ? 1 : 0?>;</script><?



/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */
$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

{
    $productJson = [];
    $Price = 0;
    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $index => $ROW)
    {
        $row = $ROW['data'];
        $product = $row['PRODUCT_ID'];
        $product = CIBlockElement::GetByID($product)->Fetch();
        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $product['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','NAME','UF_*']) -> Fetch();
        $sectionName = LANGUAGE_ID == 'ua' ? $res['UF_NAME_UA'] : $res['NAME'];
        if(LANGUAGE_ID == 'ua')
            $itemName = CIBlockElement::GetProperty(25, $row['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
        else
            $itemName = $row['NAME'];

        $mainPID = CIBlockElement::GetProperty(25, $row['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'CML2_LINK')) -> Fetch()['VALUE'];
        $mainFields = CIBlockElement::GetByID($mainPID)->Fetch();



        if(LANGUAGE_ID == 'ua')
        {
            $mainFields['NAME'] = CIBlockElement::GetProperty(21, $mainPID,'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
        }

        $productJson[] = "
        {
                    'name': '".addslashes($mainFields['NAME'])."',
                    'id': '".$mainPID."',
                    'baseId': '".$mainPID."',
                    'price': '".$row['PRICE']."',
                    'brand': 'STIMMA',
                    'category': '".addslashes($sectionName)."',
                    'quantity': ".$row['QUANTITY']."
                }
                ";

        $productJson2[] = "
        {
                    item_id: '".$mainPID."',
                    item_name: '".addslashes($mainFields['NAME'])."',
                    affiliation: 'STIMMA',
                    discount: ".($row['BASE_PRICE']-$row['PRICE']).", 
                    index: 1, 
                    item_brand: 'STIMMA', 
                    item_category: '".addslashes($sectionName)."',
                    item_list_id:'".$mainPID."',
                    item_list_name: '".addslashes($itemName)."',
                    price: ".$row['BASE_PRICE'].", // Ціна товару без знижки.
                    quantity: ".$row['QUANTITY']." 
                }
                ";

        $Price += ($row['PRICE']*$row['QUANTITY']);
        ?>
        <script>
            <?/*addViewItem(<?=$row['PRODUCT_ID']?>, '<?=addslashes($itemName)?>', <?=$row['PRICE']?>, '<?=addslashes($sectionName)?>', 1,'', false,'Checkout', <?=$row['QUANTITY']?>);*/?>
        </script>
        <?
    }
    ?>
    <script>
        //sendViewItems('begin_checkout');
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <?
    if(LANGUAGE_ID == 'ua')
    {
        ?><script src="/bitrix/templates/aspro_max/components/bitrix/sale.order.ajax/v1/select2_ua.js"></script><?
    }
    else
    {
        ?><script src="/bitrix/templates/aspro_max/components/bitrix/sale.order.ajax/v1/select2_ru.js"></script><?
    }

    ?>
    <?

    if(!isset($_GET['ORDER_ID']))
    {
        ?>
        <script>
            dataLayer.push({ ecommerce: null });
            dataLayer.push({
                event: "begin_checkout", // подія перегляду корзини
                ecommerce: {
                    currency: "UAH", // валюта ціни UAH - гривня
                    value: <?=$Price?>,
                    items: [
                        <?=implode(',',$productJson2)?>
                    ]
                }
            });
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                'ecommerce': {
                    'currencyCode': 'UAH',
                    'checkout': {
                        'actionField': {'step': 1},
                        'products': [<?=implode(',',$productJson)?>]
                    }
                },
                'event': 'gtm-ee-event',
                'gtm-ee-event-category': 'Enhanced Ecommerce',
                'gtm-ee-event-action': 'Checkout Step 1',
                'gtm-ee-event-non-interaction': 'False',
            });
        </script>
        <?
    }
}

if (empty($arParams['TEMPLATE_THEME']))
{
	$arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}

if ($arParams['TEMPLATE_THEME'] === 'site')
{
	$templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
	$templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
	$arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', $component->getSiteId());
}

if (!empty($arParams['TEMPLATE_THEME']))
{
	if (!is_file(Main\Application::getDocumentRoot().'/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
	{
		$arParams['TEMPLATE_THEME'] = 'blue';
	}
}

$arParams['ALLOW_USER_PROFILES'] = $arParams['ALLOW_USER_PROFILES'] === 'Y' ? 'Y' : 'N';
$arParams['SKIP_USELESS_BLOCK'] = $arParams['SKIP_USELESS_BLOCK'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['SHOW_ORDER_BUTTON']))
{
	$arParams['SHOW_ORDER_BUTTON'] = 'final_step';
}

$arParams['HIDE_ORDER_DESCRIPTION'] = isset($arParams['HIDE_ORDER_DESCRIPTION']) && $arParams['HIDE_ORDER_DESCRIPTION'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_TOTAL_ORDER_BUTTON'] = $arParams['SHOW_TOTAL_ORDER_BUTTON'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] = $arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_PAY_SYSTEM_INFO_NAME'] = $arParams['SHOW_PAY_SYSTEM_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_LIST_NAMES'] = $arParams['SHOW_DELIVERY_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_INFO_NAME'] = $arParams['SHOW_DELIVERY_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_PARENT_NAMES'] = $arParams['SHOW_DELIVERY_PARENT_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_STORES_IMAGES'] = $arParams['SHOW_STORES_IMAGES'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['BASKET_POSITION']) || !in_array($arParams['BASKET_POSITION'], array('before', 'after')))
{
	$arParams['BASKET_POSITION'] = 'after';
}

$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['SHOW_BASKET_HEADERS'] = $arParams['SHOW_BASKET_HEADERS'] === 'Y' ? 'Y' : 'N';
$arParams['HIDE_DETAIL_PAGE_URL'] = isset($arParams['HIDE_DETAIL_PAGE_URL']) && $arParams['HIDE_DETAIL_PAGE_URL'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERY_FADE_EXTRA_SERVICES'] = $arParams['DELIVERY_FADE_EXTRA_SERVICES'] === 'Y' ? 'Y' : 'N';

$arParams['SHOW_COUPONS'] = isset($arParams['SHOW_COUPONS']) && $arParams['SHOW_COUPONS'] === 'N' ? 'N' : 'Y';

if ($arParams['SHOW_COUPONS'] === 'N')
{
	$arParams['SHOW_COUPONS_BASKET'] = 'N';
	$arParams['SHOW_COUPONS_DELIVERY'] = 'N';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = 'N';
}
else
{
	$arParams['SHOW_COUPONS_BASKET'] = isset($arParams['SHOW_COUPONS_BASKET']) && $arParams['SHOW_COUPONS_BASKET'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_DELIVERY'] = isset($arParams['SHOW_COUPONS_DELIVERY']) && $arParams['SHOW_COUPONS_DELIVERY'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = isset($arParams['SHOW_COUPONS_PAY_SYSTEM']) && $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'N' ? 'N' : 'Y';
}

$arParams['SHOW_NEAREST_PICKUP'] = $arParams['SHOW_NEAREST_PICKUP'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERIES_PER_PAGE'] = isset($arParams['DELIVERIES_PER_PAGE']) ? intval($arParams['DELIVERIES_PER_PAGE']) : 9;
$arParams['PAY_SYSTEMS_PER_PAGE'] = isset($arParams['PAY_SYSTEMS_PER_PAGE']) ? intval($arParams['PAY_SYSTEMS_PER_PAGE']) : 9;
$arParams['PICKUPS_PER_PAGE'] = isset($arParams['PICKUPS_PER_PAGE']) ? intval($arParams['PICKUPS_PER_PAGE']) : 5;
$arParams['SHOW_PICKUP_MAP'] = $arParams['SHOW_PICKUP_MAP'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_MAP_IN_PROPS'] = $arParams['SHOW_MAP_IN_PROPS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_YM_GOALS'] = $arParams['USE_YM_GOALS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$useDefaultMessages = !isset($arParams['USE_CUSTOM_MAIN_MESSAGES']) || $arParams['USE_CUSTOM_MAIN_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_BLOCK_NAME']))
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME']))
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME']))
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME']))
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME']))
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME']))
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME']))
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_BACK']))
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_FURTHER']))
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_EDIT']))
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_MORE_DETAILS']))
	$arParams['MESS_MORE_DETAILS'] = Loc::getMessage('MORE_DETAILS_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_ORDER']))
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PRICE']))
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PERIOD']))
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK']))
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD']))
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';
if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE']))
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY']))
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE']))
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1']))
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2']))
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3']))
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS']))
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON']))
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_COUPON']))
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE']))
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE']))
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE']))
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST']))
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST']))
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP']))
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_SELECTED_PICKUP']))
	$arParams['MESS_SELECTED_PICKUP'] = Loc::getMessage('SELECTED_PICKUP_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE']))
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC']))
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';
if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE']))
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT']))
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT']))
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE']))
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT']))
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']))
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
$scheme = $request->isHttps() ? 'https' : 'http';

switch (LANGUAGE_ID)
{
	case 'ru':
		$locale = 'ru-RU'; break;
	case 'ua':
		$locale = 'ru-UA'; break;
	case 'tk':
		$locale = 'tr-TR'; break;
	default:
		$locale = 'en-US'; break;
}

//$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$arParams['TEMPLATE_THEME'].'/style.css', true);
$APPLICATION->SetAdditionalCSS($templateFolder.'/style.css', true);
$this->addExternalJs($templateFolder.'/order_ajax.js');
\Bitrix\Sale\PropertyValueCollection::initJs();
$this->addExternalJs($templateFolder.'/script.js');
?>
	<NOSCRIPT>
		<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
	</NOSCRIPT>
<?

if (strlen($request->get('ORDER_ID')) > 0)
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/confirm.php');
}
elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET'])
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
	Main\UI\Extension::load('phone_auth');

	$hideDelivery = empty($arResult['DELIVERY']);

    if(LANGUAGE_ID == 'ua')
    {
        foreach ($arResult['JS_DATA']['GRID']['HEADERS'] as $index => $HEADER)
        {
            if($HEADER['id'] == 'PRICE_FORMATED')$arResult['JS_DATA']['GRID']['HEADERS'][$index]['name'] = 'Ціна';
            if($HEADER['id'] == 'QUANTITY')$arResult['JS_DATA']['GRID']['HEADERS'][$index]['name'] = 'Кількість';
            if($HEADER['id'] == 'SUM')$arResult['JS_DATA']['GRID']['HEADERS'][$index]['name'] = 'Сума';
            if($HEADER['id'] == 'SUM')$arResult['JS_DATA']['GRID']['HEADERS'][$index]['name'] = 'Сума';
        }
    }
	?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <?
    if(LANGUAGE_ID == 'ua')
    {
        ?><script src="/bitrix/templates/aspro_max/components/bitrix/sale.order.ajax/v1/select2_ua.js"></script><?
    }
    else
    {
        ?><script src="/bitrix/templates/aspro_max/components/bitrix/sale.order.ajax/v1/select2_ru.js"></script><?
    }

    ?>


        <?
            $basket = $arResult['JS_DATA']['GRID']['ROWS'];

            foreach($basket as $index => $item)
            {
                $productInfo = \CCatalogSKU::GetProductInfo($item['data']['PRODUCT_ID']);

                if ($productInfo)
                {
                    $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $item['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                    if($findMain = $findMain->Fetch())
                        $productId = $findMain['VALUE'];
                    else $productId = $item['data']['PRODUCT_ID'];
                }
                else
                    $productId = $item['data']['PRODUCT_ID'];




                $dpu = CIBlockElement::GetByID($productId)->GetNext();
                $item['data']['BONUS'] = CIBlockElement::GetProperty(21, $dpu['ID'],'sort', 'asc', array('CODE' => 'PROP_BONUS')) -> Fetch()['VALUE_ENUM'];

                $basket[$index]['data']['DPU'] = $dpu['DETAIL_PAGE_URL'];
                $basket[$index]['data']['BONUS'] = $item['data']['BONUS'];
            }
            $alLSum = $alLQuantity = 0;

        ?>
    <?
    if(empty($basket))
    {
        ?>
        <div class="basket-empty-cont">
            <div class="basket-empty-cont-title">
                Ваш кошик порожній
            </div>
            <div class="basket-empty-cont-text">
                <a href="#"> Натисніть тут </a>, щоб продовжити покупки
            </div>
        </div>
        <?
    }
    else
    {
        ?>
        <div class="order-page">
            <form action="" method="post" id="create_order_form">
                <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
                <input type="hidden" name="PROP_2" value="" id="soa-property-2">
                <input type="hidden" name="PROP_5" value="" id="soa-property-5">
                <input type="hidden" name="PROP_4" value="" id="soa-property-4">
                <input type="hidden" name="PROP_7" value="" id="soa-property-7">
                <input type="hidden" name="PROP_25" value="" id="soa-property-25">
                <?
                //if(isset($_GET['sub']))
                {
                    foreach($arResult['SQLS'] as $index => $sql)
                    {
                        ?><input type="hidden" name="sqls[]" value="<?=$sql?>"><?
                    }
                    foreach($arResult['SQLS_ORDER'] as $index => $sql)
                    {
                        ?><input type="hidden" name="sql_order[]" value="<?=$sql?>"><?
                    }
                }
                ?>
                <div class="wrapper">
                    <div class="order-cont">
                        <div class="order-detail-cont">
                            <div class="order-detail-elements">
                                <?
                                $alLSum=$totalCount=0;
                                $totalBonus = 0;
                                $totalBonusPrice = $ids = [];
                                $totalSum = [];
                                foreach($basket as $index => $item)
                                {
                                    $ids = $item['PRODUCT_ID'];
                                    $totalCount++;
                                    $item = $item['data'];
                                    $price = CCatalogProduct::GetOptimalPrice($item['PRODUCT_ID'])['RESULT_PRICE'];
                                    $alLSum += $item['PRICE']*$item['QUANTITY'];

                                    $product = CIBlockElement::GetByID($item['PRODUCT_ID'])->GetNextElement();
                                    ?>
                                    <div class="order-item">
                                        <div class="order-item-img">
                                            <a href="<?=$item['DPU']?>">
                                                <img src="<?=$item['PREVIEW_PICTURE_SRC']?>">
                                            </a>
                                        </div>
                                        <div class="order-item-info-block">
                                            <div class="order-item-info">
                                                <div class="order-item-prop-block">
                                                    <a href="<?=$item['DPU']?>" class="order-item-name">
                                                        <?=$item['NAME']?>
                                                    </a>
                                                    <?
                                                    if(isset($withStims[$item['ID']]))
                                                    {
                                                        ?>
                                                        <div class="order-item-price-block">
                                                            <div class="basket-header-item-price-bonus">
                                                                <?=$withStims[$item['ID']]['UF_STIMS']?>
                                                                <span class="icon">
                                                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <circle cx="11" cy="11" r="11" fill="#FE9D56"></circle>
                                                                        <path d="M16.8827 12.5402C16.8827 13.0704 16.7849 13.5382 16.593 13.9318C16.4028 14.3199 16.1462 14.6519 15.8278 14.9207C15.5201 15.1803 15.1613 15.3911 14.7603 15.5458C14.3827 15.6915 13.9808 15.8055 13.5673 15.8851C13.16 15.9629 12.7429 16.0145 12.3285 16.038C11.9239 16.0625 11.5337 16.0742 11.1677 16.0742C10.2061 16.0742 9.30099 15.9928 8.47841 15.8326C7.65942 15.6725 6.92296 15.4707 6.29055 15.231L5.98377 15.1143V11.6952L6.68615 12.0888C7.27639 12.4181 7.96083 12.6814 8.72151 12.8687C9.48757 13.0578 10.32 13.1537 11.1955 13.1537C11.7095 13.1537 12.1293 13.1265 12.4433 13.0741C12.8147 13.0107 13.0192 12.9383 13.125 12.8886C13.282 12.8153 13.3206 12.7646 13.3215 12.7646C13.3358 12.742 13.343 12.7266 13.3457 12.7185C13.3421 12.7167 13.3322 12.7058 13.3143 12.6913C13.2488 12.6371 13.1223 12.5556 12.89 12.4724C12.672 12.3937 12.4092 12.3195 12.1114 12.2516C11.7983 12.1811 11.4646 12.1096 11.113 12.039C10.7542 11.9666 10.3855 11.8879 10.0061 11.8047C9.61585 11.7178 9.23282 11.6147 8.86593 11.498C8.49277 11.3795 8.13306 11.2383 7.79846 11.0791C7.44503 10.9108 7.12838 10.7072 6.85838 10.4747C6.57402 10.2286 6.34617 9.93908 6.18022 9.61427C6.00889 9.2768 5.92188 8.88685 5.92188 8.45529C5.92188 7.9631 6.01248 7.5261 6.19009 7.15696C6.36501 6.79235 6.60541 6.47749 6.90412 6.22054C7.19207 5.97264 7.52756 5.76997 7.90162 5.61707C8.25416 5.47231 8.63091 5.35831 9.02112 5.27869C9.40236 5.20088 9.79346 5.1466 10.1828 5.11765C10.5658 5.08869 10.9345 5.07422 11.278 5.07422C11.6575 5.07422 12.054 5.09412 12.4558 5.13212C12.8532 5.17012 13.2524 5.22441 13.6399 5.29407C14.023 5.36193 14.4006 5.44245 14.7639 5.53293C15.1227 5.6234 15.4609 5.71931 15.7695 5.81974L16.0969 5.9265V9.24604L15.4169 8.91219C15.2537 8.83166 15.0285 8.73666 14.7487 8.63081C14.4715 8.52586 14.1503 8.42452 13.7951 8.32952C13.4408 8.23453 13.0497 8.154 12.6326 8.08976C12.2208 8.02643 11.7929 7.99476 11.3606 7.99476C11.0098 7.99476 10.7075 8.00562 10.4626 8.02734C10.2222 8.04905 10.0204 8.0771 9.86253 8.10967C9.68761 8.14586 9.59432 8.18114 9.54678 8.20286C9.53153 8.2101 9.51897 8.21643 9.50731 8.22276C9.58086 8.27162 9.70376 8.33586 9.90021 8.40281C10.1227 8.4779 10.3864 8.55119 10.686 8.61905C11.0018 8.69052 11.3364 8.76381 11.6898 8.83981C12.0495 8.91671 12.42 9.00085 12.8021 9.09223C13.1941 9.18542 13.5789 9.2958 13.9458 9.42066C14.3217 9.54732 14.6823 9.69751 15.016 9.8658C15.3676 10.0431 15.6825 10.2548 15.9516 10.4946C16.235 10.7479 16.462 11.0438 16.6261 11.3749C16.7966 11.7187 16.8827 12.1105 16.8827 12.5402Z" fill="white"></path>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <div class="order-item-price-block">
                                                            <?
                                                            if($price['BASE_PRICE'] > $item['PRICE'])
                                                            {
                                                                ?><div class="order-list-price-old"><?=FormatCurrency($price['BASE_PRICE']*$item['QUANTITY'],'UAH')?></div><?
                                                            }
                                                            ?>
                                                            <div class="order-item-price">
                                                                <?=FormatCurrency($item['QUANTITY']*$item['PRICE'], 'UAH')?>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                    ?>
                                                    
                                                </div>
                                                <div class="order-item-prop-cont">
                                                    <div class="order-item-prop">
                                                        <div class="order-item-size">
                                                            <?=LANGUAGE_ID=='ua'?'Розмір':'Размер'?>: <?=$basketProducts[$item['PRODUCT_ID']]['PROPERTIES']['RAZMER']['VALUE']?>
                                                            <?/*
                                                        <select class="form-select">
                                                            <option>S</option>
                                                            <option>M</option>
                                                            <option>L</option>
                                                            <option>XL</option>
                                                        </select>
                                                        */?>
                                                        </div>
                                                        <div class="order-item-color">
                                                            Колір:
                                                            <span style="background: <?=$colors[$basketProducts[$item['PRODUCT_ID']]['PROPERTIES']['COLOR_REF']['VALUE'][0]]['UF_COLOR_CODE']?>;"> </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="order-item-control">
                                                <div class="order-item-counter">
                                                    <button class="order-item-counter-btn minus_count" data-id="<?=$item['ID']?>">
                                                        <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"></rect>
                                                        </svg>
                                                    </button>
                                                    <input type="text" name="" value="<?=$item['QUANTITY']?>">
                                                    <button class="order-item-counter-btn plus_count" data-id="<?=$item['ID']?>">
                                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect x="6" width="1" height="13" fill="white"></rect>
                                                            <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"></rect>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <?
                                                if($item['ID'])
                                                {
                                                    ?>
                                                    <a href="?remove=<?=$item['ID']?>"  data-leave="free" class="order-item-delete">Видалити</a>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }

                                ?>
                                <?/*
                            <div class="order-item">
                                <div class="order-item-img">
                                    <a href="#">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/headbask1.png">
                                    </a>
                                </div>
                                <div class="order-item-info-block">
                                    <div class="order-item-info">
                                        <div class="order-item-prop-block">
                                            <a href="#" class="order-item-name">
                                                Жіночий бомбер Stimma Ешалін хакі
                                            </a>
                                            <div class="order-item-prop-cont">
                                                <div class="order-item-prop">
                                                    <div class="order-item-size">
                                                        Розмір:
                                                        <select class="form-select">
                                                            <option>S</option>
                                                            <option>M</option>
                                                            <option>L</option>
                                                            <option>XL</option>
                                                        </select>
                                                    </div>
                                                    <div class="order-item-color">
                                                        Колір:
                                                        <span style="background: #635240;"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-item-price-block">
                                            <div class="order-item-price">
                                                7 198 ₴
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-item-control">
                                        <div class="order-item-counter">
                                            <button class="order-item-counter-btn">
                                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"></rect>
                                                </svg>
                                            </button>
                                            <input type="text" name="" value="1">
                                            <button class="order-item-counter-btn">
                                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" width="1" height="13" fill="white"></rect>
                                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"></rect>
                                                </svg>
                                            </button>
                                        </div>
                                        <a href="#" class="order-item-delete">Видалити</a>
                                    </div>
                                </div>
                            </div>
                            <div class="order-item order-item-bonus">
                                <div class="order-item-img">
                                    <a href="#">
                                        <img src="/bitrix/templates/stimma_new/images/imgnew/headbask2.png">
                                    </a>
                                </div>
                                <div class="order-item-info-block">
                                    <div class="order-item-info">
                                        <div class="order-item-prop-block">
                                            <a href="#" class="order-item-name">
                                                Жіноча сумка Stimma Глорія шоколадний
                                            </a>
                                            <div class="order-item-prop-cont">
                                                <div class="order-item-size">
                                                    Придбати за
                                                    <select class="form-select">
                                                        <option>стімз</option>
                                                        <option>гривні</option>
                                                    </select>
                                                </div>
                                                <div class="order-item-prop">
                                                    <div class="order-item-color">
                                                        Колір:
                                                        <span style="background: #635240;"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-item-price-block">
                                            <div class="basket-header-item-price-bonus">
                                                500
                                                <span class="icon">
						                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						                                    <circle cx="11" cy="11" r="11" fill="#FE9D56"></circle>
						                                    <path d="M16.8827 12.5402C16.8827 13.0704 16.7849 13.5382 16.593 13.9318C16.4028 14.3199 16.1462 14.6519 15.8278 14.9207C15.5201 15.1803 15.1613 15.3911 14.7603 15.5458C14.3827 15.6915 13.9808 15.8055 13.5673 15.8851C13.16 15.9629 12.7429 16.0145 12.3285 16.038C11.9239 16.0625 11.5337 16.0742 11.1677 16.0742C10.2061 16.0742 9.30099 15.9928 8.47841 15.8326C7.65942 15.6725 6.92296 15.4707 6.29055 15.231L5.98377 15.1143V11.6952L6.68615 12.0888C7.27639 12.4181 7.96083 12.6814 8.72151 12.8687C9.48757 13.0578 10.32 13.1537 11.1955 13.1537C11.7095 13.1537 12.1293 13.1265 12.4433 13.0741C12.8147 13.0107 13.0192 12.9383 13.125 12.8886C13.282 12.8153 13.3206 12.7646 13.3215 12.7646C13.3358 12.742 13.343 12.7266 13.3457 12.7185C13.3421 12.7167 13.3322 12.7058 13.3143 12.6913C13.2488 12.6371 13.1223 12.5556 12.89 12.4724C12.672 12.3937 12.4092 12.3195 12.1114 12.2516C11.7983 12.1811 11.4646 12.1096 11.113 12.039C10.7542 11.9666 10.3855 11.8879 10.0061 11.8047C9.61585 11.7178 9.23282 11.6147 8.86593 11.498C8.49277 11.3795 8.13306 11.2383 7.79846 11.0791C7.44503 10.9108 7.12838 10.7072 6.85838 10.4747C6.57402 10.2286 6.34617 9.93908 6.18022 9.61427C6.00889 9.2768 5.92188 8.88685 5.92188 8.45529C5.92188 7.9631 6.01248 7.5261 6.19009 7.15696C6.36501 6.79235 6.60541 6.47749 6.90412 6.22054C7.19207 5.97264 7.52756 5.76997 7.90162 5.61707C8.25416 5.47231 8.63091 5.35831 9.02112 5.27869C9.40236 5.20088 9.79346 5.1466 10.1828 5.11765C10.5658 5.08869 10.9345 5.07422 11.278 5.07422C11.6575 5.07422 12.054 5.09412 12.4558 5.13212C12.8532 5.17012 13.2524 5.22441 13.6399 5.29407C14.023 5.36193 14.4006 5.44245 14.7639 5.53293C15.1227 5.6234 15.4609 5.71931 15.7695 5.81974L16.0969 5.9265V9.24604L15.4169 8.91219C15.2537 8.83166 15.0285 8.73666 14.7487 8.63081C14.4715 8.52586 14.1503 8.42452 13.7951 8.32952C13.4408 8.23453 13.0497 8.154 12.6326 8.08976C12.2208 8.02643 11.7929 7.99476 11.3606 7.99476C11.0098 7.99476 10.7075 8.00562 10.4626 8.02734C10.2222 8.04905 10.0204 8.0771 9.86253 8.10967C9.68761 8.14586 9.59432 8.18114 9.54678 8.20286C9.53153 8.2101 9.51897 8.21643 9.50731 8.22276C9.58086 8.27162 9.70376 8.33586 9.90021 8.40281C10.1227 8.4779 10.3864 8.55119 10.686 8.61905C11.0018 8.69052 11.3364 8.76381 11.6898 8.83981C12.0495 8.91671 12.42 9.00085 12.8021 9.09223C13.1941 9.18542 13.5789 9.2958 13.9458 9.42066C14.3217 9.54732 14.6823 9.69751 15.016 9.8658C15.3676 10.0431 15.6825 10.2548 15.9516 10.4946C16.235 10.7479 16.462 11.0438 16.6261 11.3749C16.7966 11.7187 16.8827 12.1105 16.8827 12.5402Z" fill="white"></path>
						                                </svg>
						                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-item-control">
                                        <div class="order-item-counter">
                                            <button class="order-item-counter-btn">
                                                <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"></rect>
                                                </svg>
                                            </button>
                                            <input type="text" name="" value="1">
                                            <button class="order-item-counter-btn">
                                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="6" width="1" height="13" fill="white"></rect>
                                                    <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"></rect>
                                                </svg>
                                            </button>
                                        </div>
                                        <a href="#" class="order-item-delete">Видалити</a>
                                    </div>
                                </div>
                            </div>
                            */?>
                            </div>
                            <div class="order-detail-item">
                                <div class="order-detail-title">
			        				<span class="icon">
			        					<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5312 1.33008C10.9097 1.33008 7.96875 4.27008 7.96875 7.89258C7.96875 11.5141 10.9097 14.4551 14.5312 14.4551C18.1528 14.4551 21.0938 11.5141 21.0938 7.89258C21.0938 4.27008 18.1528 1.33008 14.5312 1.33008ZM14.5312 3.20508C17.1187 3.20508 19.2188 5.30508 19.2188 7.89258C19.2188 10.4791 17.1187 12.5801 14.5312 12.5801C11.9437 12.5801 9.84375 10.4791 9.84375 7.89258C9.84375 5.30508 11.9437 3.20508 14.5312 3.20508Z" fill="#1E1E1E"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M3.28125 25.7051H15C15.5175 25.7051 15.9375 26.1251 15.9375 26.6426C15.9375 27.1601 15.5175 27.5801 15 27.5801H2.34375C1.82625 27.5801 1.40625 27.1601 1.40625 26.6426C1.40625 26.6426 1.40625 25.8691 1.40625 24.7676C1.40625 20.1073 5.18344 16.3301 9.84375 16.3301H15C15.5175 16.3301 15.9375 16.7501 15.9375 17.2676C15.9375 17.7851 15.5175 18.2051 15 18.2051H9.84375C6.21938 18.2051 3.28125 21.1432 3.28125 24.7676V25.7051Z" fill="#1E1E1E"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M27.4955 21.9551C27.4955 21.4366 27.0765 21.0176 26.558 21.0176H18.2012C17.6837 21.0176 17.2637 21.4366 17.2637 21.9551V26.6426C17.2637 27.1601 17.6837 27.5801 18.2012 27.5801H26.558C27.0765 27.5801 27.4955 27.1601 27.4955 26.6426V21.9551ZM19.1387 22.8926V25.7051H25.6205V22.8926H19.1387Z" fill="#1E1E1E"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M22.3784 16.3301C23.3263 16.3301 24.2356 16.706 24.9059 17.3763C25.5762 18.0466 25.9531 18.956 25.9531 19.9038V21.9551C25.9531 22.4726 25.5331 22.8926 25.0156 22.8926H19.7422C19.2238 22.8926 18.8047 22.4726 18.8047 21.9551V19.9038C18.8047 17.9304 20.405 16.3301 22.3784 16.3301ZM24.0781 21.0176V19.9038C24.0781 19.4529 23.8991 19.0207 23.5803 18.7029C23.2616 18.3841 22.8294 18.2051 22.3784 18.2051C21.44 18.2051 20.6797 18.9654 20.6797 19.9038V21.0176H24.0781Z" fill="#1E1E1E"/>
										</svg>
			        				</span>
                                    <?=LANGUAGE_ID=='ua'?'Особисті дані':'Личные данные'?>
                                </div>
                                <div class="order-detail-form">
                                    <div class="form-block">
                                        <input type="text" name="fio" value="<?=$user['LAST_NAME']?>" class="form-control" placeholder="<?=UA?'Прізвище':'Фамилия'?>*">
                                        <span class="input-text">
                                        <?=LANGUAGE_ID=='ua'?'Поле обов\'язкове для заповнення':'Поле обьязательное для заполнения'?>
                                    </span>
                                    </div>
                                    <div class="order-detail-form-group">
                                        <div class="form-block">
                                            <input type="text" name="name" value="<?=$user['NAME']?>" class="form-control" placeholder="<?=UA?'Ім\'я':'Имя'?>*">
                                            <span class="input-text">
                                            <?=LANGUAGE_ID=='ua'?'Поле обов\'язкове для заповнення':'Поле обьязательное для заполнения'?>
                                        </span>
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="second_name" value="<?=$user['SECOND_NAME']?>" class="form-control" placeholder="<?=UA?'По батькові':'Отчество'?>*">
                                            <span class="input-text">
                                            <?=LANGUAGE_ID=='ua'?'Поле обов\'язкове для заповнення':'Поле обьязательное для заполнения'?>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="order-detail-form-group">
                                        <div class="form-block">
                                            <input type="text" name="phone" value="<?=$user['PERSONAL_PHONE']?>" class="form-control" placeholder="Телефон*">
                                            <span class="input-text">
                                            <?=LANGUAGE_ID=='ua'?'Поле обов\'язкове для заповнення':'Поле обьязательное для заполнения'?>
                                        </span>
                                        </div>
                                        <div class="form-block">
                                            <input type="text" name="email" value="<?=$user['EMAIL']?>" class="form-control" placeholder="Email*">
                                            <span class="input-text">
                                            <?=LANGUAGE_ID=='ua'?'Поле обов\'язкове для заповнення':'Поле обьязательное для заполнения'?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-detail-item">
                                <div class="order-detail-title">
			        				<span class="icon">
			        					<svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M29.5312 5.91223L19.3465 0.123668C19.204 0.0426434 19.0423 -9.15536e-06 18.8777 1.47406e-09H13.1099C12.8612 1.47406e-09 12.6228 0.0972331 12.447 0.270309C12.2712 0.443385 12.1724 0.678127 12.1724 0.922893C12.1724 1.16766 12.2712 1.4024 12.447 1.57548C12.6228 1.74855 12.8612 1.84579 13.1099 1.84579H15.3789L8.44172 5.78856H0.9375C0.68886 5.78856 0.450403 5.88579 0.274587 6.05887C0.0987721 6.23195 0 6.46669 0 6.71145C0 6.95622 0.0987721 7.19096 0.274587 7.36404C0.450403 7.53711 0.68886 7.63435 0.9375 7.63435H8.44172L17.9402 13.0329V22.4788L9.16166 17.4894C9.01914 17.4084 8.85748 17.3658 8.69291 17.3657H0.9375C0.68886 17.3657 0.450403 17.463 0.274587 17.636C0.0987721 17.8091 0 18.0439 0 18.2886C0 18.5334 0.0987721 18.7681 0.274587 18.9412C0.450403 19.1143 0.68886 19.2115 0.9375 19.2115H8.44172L18.409 24.8764C18.5515 24.9574 18.7132 25 18.8777 25C19.0423 25 19.204 24.9574 19.3465 24.8764L29.5312 19.0879C29.6738 19.0069 29.7921 18.8903 29.8744 18.75C29.9567 18.6097 30 18.4506 30 18.2886V6.71145C30 6.54946 29.9567 6.39031 29.8744 6.25002C29.7921 6.10973 29.6738 5.99323 29.5312 5.91223ZM27.1875 6.71145L18.8777 11.4344L10.568 6.71145L18.8777 1.98855L27.1875 6.71145ZM19.8152 22.4788V13.0329L28.125 8.3099V17.7558L19.8152 22.4788ZM2.70023 0.922893C2.70023 0.678127 2.79901 0.443385 2.97482 0.270309C3.15064 0.0972331 3.38909 1.47406e-09 3.63773 1.47406e-09H9.70172C9.95036 1.47406e-09 10.1888 0.0972331 10.3646 0.270309C10.5404 0.443385 10.6392 0.678127 10.6392 0.922893C10.6392 1.16766 10.5404 1.4024 10.3646 1.57548C10.1888 1.74855 9.95036 1.84579 9.70172 1.84579H3.63773C3.38909 1.84579 3.15064 1.74855 2.97482 1.57548C2.79901 1.4024 2.70023 1.16766 2.70023 0.922893ZM3.63773 13.4229C3.38909 13.4229 3.15064 13.3257 2.97482 13.1526C2.79901 12.9795 2.70023 12.7448 2.70023 12.5C2.70023 12.2552 2.79901 12.0205 2.97482 11.8474C3.15064 11.6744 3.38909 11.5771 3.63773 11.5771H8.51309C8.76173 11.5771 9.00018 11.6744 9.176 11.8474C9.35181 12.0205 9.45059 12.2552 9.45059 12.5C9.45059 12.7448 9.35181 12.9795 9.176 13.1526C9.00018 13.3257 8.76173 13.4229 8.51309 13.4229H3.63773Z" fill="currentcolor"/>
										</svg>
			        				</span>
                                    <?=UA?'Спосіб доставки':'Способ доставки'?>
                                </div>
                                <div class="order-detail-elements">
                                    <label class="order-detail-element">
                                        <input type="radio" checked id="delivery_method" name="delivery_method" value="14">
                                        <div class="order-detail-block">
                                            <div class="order-detail-radio">

                                            </div>
                                            <div class="order-detail-text-cont">
                                                <div class="order-detail-text-title">
                                                    <?=UA?'Нова Пошта (відділення). Від 80 грн.':'Нова Почта (отделение). От 80 грн.'?>
                                                </div>
                                                <div class="order-detail-text-dropdown">
                                                    <div class="order-detail-text">
                                                        <p class="order-detail-text-del">
                                                            терміни відправки до 5-ти днів.
                                                            Номер ТТН буде надіслано у SMS-повідомленні.
                                                            При відправленні вказуємо повну оголошену вартість товару.
                                                            Оплата за доставку здійснюється при отриманні замовлення.
                                                        </p>
                                                        <!-- <p class="data_delivery_name" data-name="<?=LANGUAGE_ID=='ua' ? 'Дані отримувача' : 'Данные получаетеля'?>">
                                                        <b>Дані отримувача</b>
                                                        <br>Данілова Наталія
                                                        <br>380999785789
                                                    </p>
                                                    <p>
                                                        <b>Відділення</b>
                                                        <br>Київ,Відділення №304 (до 30 кг): вул. Гришка, 6
                                                    </p> -->
                                                    </div>
                                                    <div>
                                                        <div class="form-block ">
                                                            <select class="custom-select" name="choose_city_np">
                                                                <?
                                                                if(isset($dost[14]['UF_CITY_ID']) && $dost[14]['UF_CITY_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[14]['UF_CITY_ID']?>">
                                                                        <?=$dost[14]['CITY']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-block choose_city">
                                                            <select class="custom-select" name="choose_city_np_vid">
                                                                <?
                                                                if(isset($dost[14]['UF_VIDD_ID']) && $dost[14]['UF_VIDD_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[14]['UF_VIDD_ID']?>">
                                                                        <?=$dost[14]['VIDD']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <!-- <a href="#" class="change-address">
                                                            <span class="icon">
                                                                <svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M13.9416 3.65877C12.5949 1.40196 10.124 0 7.49322 0C6.14587 0 4.81894 0.366789 3.65594 1.06062C0.104059 3.17996 -1.06146 7.79399 1.05788 11.3461L6.95377 21.2273C7.0685 21.4196 7.27587 21.5373 7.49977 21.5373C7.72367 21.5373 7.93105 21.4196 8.04568 21.2273L13.9422 11.3448C15.3529 8.96862 15.3525 6.02353 13.9416 3.65877ZM12.8497 10.6945L7.49982 19.6607L2.14984 10.6945C0.389692 7.74455 1.35767 3.91269 4.30756 2.15254C5.27354 1.57619 6.37509 1.27146 7.49327 1.27146C9.67876 1.27146 11.7313 2.43589 12.8497 4.31025C14.0215 6.27421 14.0212 8.72093 12.8497 10.6945Z" fill="currentcolor"/>
                                                                    <path d="M7.49855 3.7373C5.4541 3.7373 3.79077 5.40068 3.79077 7.44523C3.79077 9.48973 5.4541 11.1531 7.49855 11.1531C9.5431 11.1531 11.2064 9.48973 11.2064 7.44523C11.2064 5.40068 9.5431 3.7373 7.49855 3.7373ZM7.49855 9.88155C6.15519 9.88155 5.06233 8.78864 5.06233 7.44528C5.06233 6.10182 6.15519 5.00886 7.49855 5.00886C8.84201 5.00886 9.93497 6.10182 9.93497 7.44528C9.93497 8.78859 8.84201 9.88155 7.49855 9.88155Z" fill="currentcolor"/>
                                                                </svg>
                                                            </span>
                                                        <span class="text">
                                                                Інша адреса
                                                            </span>
                                                    </a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="order-detail-element">
                                        <input type="radio" id="delivery_method3" name="delivery_method" value="17">
                                        <div class="order-detail-block">
                                            <div class="order-detail-radio">

                                            </div>
                                            <div class="order-detail-text-cont">
                                                <div class="order-detail-text-title">
                                                    <?=UA?'Нова Пошта (поштомат). Від 90 грн.':'Нова Почта (почтомат). От 90 грн.'?>
                                                </div>
                                                <div class="order-detail-text-dropdown">
                                                    <div class="order-detail-text">
                                                        <p class="order-detail-text-del">
                                                            терміни відправки до 5-ти днів.
                                                            Номер ТТН буде надіслано у SMS-повідомленні.
                                                            При відправленні вказуємо повну оголошену вартість товару.
                                                            Оплата за доставку здійснюється при отриманні замовлення.
                                                        </p>
                                                        <?/*<p>
                                                        <b>Дані отримувача</b>
                                                        <br>Данілова Наталія
                                                        <br>380999785789
                                                    </p>
                                                    <p>
                                                        <b>Відділення</b>
                                                        <br>Київ,Відділення №304 (до 30 кг): вул. Гришка, 6
                                                    </p>*/?>
                                                    </div>
                                                    <div>
                                                        <div class="form-block ">
                                                            <select class="custom-select" name="choose_city_np">
                                                                <?
                                                                if(isset($dost[17]['UF_CITY_ID']) && $dost[17]['UF_CITY_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[17]['UF_CITY_ID']?>">
                                                                        <?=$dost[17]['CITY']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                                <?
                                                                /*foreach ($arResult['CITIES'] as $index => $CITY)
                                                                {
                                                                    ?>
                                                                    <option value="<?=$CITY['ID']?>">
                                                                        <?=LANGUAGE_ID=='ua'?$CITY['UF_NAME_UA']:$CITY['UF_NAME_RU']?>
                                                                    </option>
                                                                    <?
                                                                }*/
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-block choose_city">
                                                            <select class="custom-select" name="choose_city_np_vid">
                                                                <?
                                                                if(isset($dost[17]['UF_VIDD_ID']) && $dost[17]['UF_VIDD_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[17]['UF_VIDD_ID']?>">
                                                                        <?=$dost[17]['VIDD']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <?/*<a href="#" class="change-address">
			        									<span class="icon">
			        										<svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M13.9416 3.65877C12.5949 1.40196 10.124 0 7.49322 0C6.14587 0 4.81894 0.366789 3.65594 1.06062C0.104059 3.17996 -1.06146 7.79399 1.05788 11.3461L6.95377 21.2273C7.0685 21.4196 7.27587 21.5373 7.49977 21.5373C7.72367 21.5373 7.93105 21.4196 8.04568 21.2273L13.9422 11.3448C15.3529 8.96862 15.3525 6.02353 13.9416 3.65877ZM12.8497 10.6945L7.49982 19.6607L2.14984 10.6945C0.389692 7.74455 1.35767 3.91269 4.30756 2.15254C5.27354 1.57619 6.37509 1.27146 7.49327 1.27146C9.67876 1.27146 11.7313 2.43589 12.8497 4.31025C14.0215 6.27421 14.0212 8.72093 12.8497 10.6945Z" fill="currentcolor"/>
																<path d="M7.49855 3.7373C5.4541 3.7373 3.79077 5.40068 3.79077 7.44523C3.79077 9.48973 5.4541 11.1531 7.49855 11.1531C9.5431 11.1531 11.2064 9.48973 11.2064 7.44523C11.2064 5.40068 9.5431 3.7373 7.49855 3.7373ZM7.49855 9.88155C6.15519 9.88155 5.06233 8.78864 5.06233 7.44528C5.06233 6.10182 6.15519 5.00886 7.49855 5.00886C8.84201 5.00886 9.93497 6.10182 9.93497 7.44528C9.93497 8.78859 8.84201 9.88155 7.49855 9.88155Z" fill="currentcolor"/>
															</svg>
			        									</span>
                                                    <span class="text">
			        										Інша адреса
			        									</span>
                                                </a>*/?>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="order-detail-element">
                                        <input type="radio" id="delivery_method4" name="delivery_method" value="18">
                                        <div class="order-detail-block">
                                            <div class="order-detail-radio">

                                            </div>
                                            <div class="order-detail-text-cont">
                                                <div class="order-detail-text-title">
                                                    <?=UA?'Нова Пошта (кур’єр). Від 130 грн.':'Нова Почта (курьер). От 130 грн.'?>
                                                </div>
                                                <div class="order-detail-text-dropdown">
                                                    <div class="order-detail-text">
                                                        <p class="order-detail-text-del">
                                                            терміни відправки до 5-ти днів.
                                                            Номер ТТН буде надіслано у SMS-повідомленні.
                                                            При відправленні вказуємо повну оголошену вартість товару.
                                                            Оплата за доставку здійснюється при отриманні замовлення.
                                                        </p>
                                                        <?/*<p>
                                                        <b>Дані отримувача</b>
                                                        <br>Данілова Наталія
                                                        <br>380999785789
                                                    </p>
                                                    <p>
                                                        <b>Відділення</b>
                                                        <br>Київ,Відділення №304 (до 30 кг): вул. Гришка, 6
                                                    </p>*/?>
                                                    </div>
                                                    <div>
                                                        <div class="form-block ">
                                                            <input class="form-control" name="np_k_city" value="<?=$dost[18]['UF_CITY']?>" id="np_k_city" type="text" placeholder="<?=UA?'Місто':'Город'?>">
                                                        </div>
                                                        <div class="form-block">
                                                            <input class="form-control" name="np_k_street" value="<?=$dost[18]['UF_STREET']?>" id="np_k_street" type="text" placeholder="<?=UA?'Вулиця':'Улица'?>">
                                                        </div>

                                                        <div class="form-block">
                                                            <input class="form-control" name="np_k_dom" value="<?=$dost[18]['UF_DOM']?>" id="np_k_dom" type="text" placeholder="<?=UA?'Буд.':'Дом'?>">
                                                        </div>
                                                        <div class="form-block">
                                                            <input class="form-control" name="np_k_kv" value="<?=$dost[18]['UF_KV']?>" id="np_k_kv" type="text" placeholder="<?=UA?'Квартира':'Квартира'?>">
                                                        </div>
                                                        <div class="form-block">
                                                            <textarea name="adress_comment" id="adress_comment" class="form-control" placeholder="<?=UA?'Коментар':'Комментарий'?>"></textarea>
                                                        </div>
                                                    </div>
                                                    <?/*<a href="#" class="change-address">
			        									<span class="icon">
			        										<svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M13.9416 3.65877C12.5949 1.40196 10.124 0 7.49322 0C6.14587 0 4.81894 0.366789 3.65594 1.06062C0.104059 3.17996 -1.06146 7.79399 1.05788 11.3461L6.95377 21.2273C7.0685 21.4196 7.27587 21.5373 7.49977 21.5373C7.72367 21.5373 7.93105 21.4196 8.04568 21.2273L13.9422 11.3448C15.3529 8.96862 15.3525 6.02353 13.9416 3.65877ZM12.8497 10.6945L7.49982 19.6607L2.14984 10.6945C0.389692 7.74455 1.35767 3.91269 4.30756 2.15254C5.27354 1.57619 6.37509 1.27146 7.49327 1.27146C9.67876 1.27146 11.7313 2.43589 12.8497 4.31025C14.0215 6.27421 14.0212 8.72093 12.8497 10.6945Z" fill="currentcolor"/>
																<path d="M7.49855 3.7373C5.4541 3.7373 3.79077 5.40068 3.79077 7.44523C3.79077 9.48973 5.4541 11.1531 7.49855 11.1531C9.5431 11.1531 11.2064 9.48973 11.2064 7.44523C11.2064 5.40068 9.5431 3.7373 7.49855 3.7373ZM7.49855 9.88155C6.15519 9.88155 5.06233 8.78864 5.06233 7.44528C5.06233 6.10182 6.15519 5.00886 7.49855 5.00886C8.84201 5.00886 9.93497 6.10182 9.93497 7.44528C9.93497 8.78859 8.84201 9.88155 7.49855 9.88155Z" fill="currentcolor"/>
															</svg>
			        									</span>
                                                    <span class="text">
			        										Інша адреса
			        									</span>
                                                </a>*/?>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="order-detail-element">
                                        <input type="radio" id="delivery_method1" name="delivery_method" value="15">
                                        <div class="order-detail-block">
                                            <div class="order-detail-radio">

                                            </div>
                                            <div class="order-detail-text-cont">
                                                <div class="order-detail-text-title">
                                                    <?=UA?'УкрПошта Експрес':'УкрПочта Экспресс'?>
                                                </div>
                                                <div class="order-detail-text-dropdown">
                                                    <div class="order-detail-text">
                                                        <p class="order-detail-text-del">
                                                            терміни відправки до 5-ти днів.
                                                            Номер ТТН буде надіслано у SMS-повідомленні.
                                                            При відправленні вказуємо повну оголошену вартість товару.
                                                            Оплата за доставку здійснюється при отриманні замовлення.
                                                        </p>
                                                        <?/*<p>
                                                        <b>Дані отримувача</b>
                                                        <br>Данілова Наталія
                                                        <br>380999785789
                                                    </p>
                                                    <p>
                                                        <b>Відділення</b>
                                                        <br>Київ,Відділення №304 (до 30 кг): вул. Гришка, 6
                                                    </p>*/?>
                                                    </div>
                                                    <div>
                                                        <div class="form-block ">
                                                            <select class="custom-select" name="choose_city_np">
                                                                <?
                                                                if(isset($dost[15]['UF_CITY_ID']) && $dost[15]['UF_CITY_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[15]['UF_CITY_ID']?>">
                                                                        <?=$dost[15]['CITY']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Оберіть місто':'Выберите город'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                                <?
                                                                /*foreach ($arResult['CITIES'] as $index => $CITY)
                                                                {
                                                                    ?>
                                                                    <option value="<?=$CITY['ID']?>">
                                                                        <?=LANGUAGE_ID=='ua'?$CITY['UF_NAME_UA']:$CITY['UF_NAME_RU']?>
                                                                    </option>
                                                                    <?
                                                                }*/
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-block choose_city">
                                                            <select class="custom-select" name="choose_city_np_vid">
                                                                <?
                                                                if(isset($dost[15]['UF_VIDD_ID']) && $dost[15]['UF_VIDD_ID'])
                                                                {
                                                                    ?>
                                                                    <option value="<?=$dost[15]['UF_VIDD_ID']?>">
                                                                        <?=$dost[15]['VIDD']?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <option value="0">
                                                                        <?=LANGUAGE_ID=='ua'?'Виберіть відділення':'Выберите отделение'?>
                                                                    </option>
                                                                    <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <?/*<a href="#" class="change-address">
			        									<span class="icon">
			        										<svg width="15" height="22" viewBox="0 0 15 22" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M13.9416 3.65877C12.5949 1.40196 10.124 0 7.49322 0C6.14587 0 4.81894 0.366789 3.65594 1.06062C0.104059 3.17996 -1.06146 7.79399 1.05788 11.3461L6.95377 21.2273C7.0685 21.4196 7.27587 21.5373 7.49977 21.5373C7.72367 21.5373 7.93105 21.4196 8.04568 21.2273L13.9422 11.3448C15.3529 8.96862 15.3525 6.02353 13.9416 3.65877ZM12.8497 10.6945L7.49982 19.6607L2.14984 10.6945C0.389692 7.74455 1.35767 3.91269 4.30756 2.15254C5.27354 1.57619 6.37509 1.27146 7.49327 1.27146C9.67876 1.27146 11.7313 2.43589 12.8497 4.31025C14.0215 6.27421 14.0212 8.72093 12.8497 10.6945Z" fill="currentcolor"/>
																<path d="M7.49855 3.7373C5.4541 3.7373 3.79077 5.40068 3.79077 7.44523C3.79077 9.48973 5.4541 11.1531 7.49855 11.1531C9.5431 11.1531 11.2064 9.48973 11.2064 7.44523C11.2064 5.40068 9.5431 3.7373 7.49855 3.7373ZM7.49855 9.88155C6.15519 9.88155 5.06233 8.78864 5.06233 7.44528C5.06233 6.10182 6.15519 5.00886 7.49855 5.00886C8.84201 5.00886 9.93497 6.10182 9.93497 7.44528C9.93497 8.78859 8.84201 9.88155 7.49855 9.88155Z" fill="currentcolor"/>
															</svg>
			        									</span>
                                                    <span class="text">
			        										Інша адреса
			        									</span>
                                                </a>*/?>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="order-detail-item">
                                <div class="order-detail-title">
			        				<span class="icon">
			        					<svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M26.1299 0H3.8701C1.7363 0 0 1.7363 0 3.8701V18.1299C0 20.2637 1.7363 22 3.8701 22H26.1299C28.2637 22 30 20.2637 30 18.1299V3.8701C30 1.7363 28.2637 0 26.1299 0ZM26.1299 20H3.8701C2.8389 20 2 19.1611 2 18.1299V3.8701C2 2.8389 2.8389 2 3.8701 2H26.1299C27.1611 2 28 2.8389 28 3.8701V6H5C4.4478 6 4 6.4478 4 7C4 7.5522 4.4478 8 5 8H28V18.1299C28 19.1611 27.1611 20 26.1299 20Z" fill="currentcolor"/>
											<path d="M24 15H22C21.4478 15 21 15.4478 21 16C21 16.5522 21.4478 17 22 17H24C24.5522 17 25 16.5522 25 16C25 15.4478 24.5522 15 24 15Z" fill="currentcolor"/>
										</svg>
			        				</span>
                                    Оплата
                                </div>
                                <div class="order-detail-elements order-detail-elements-pay">
                                    <label class="order-detail-element">
                                        <input type="radio" checked id="payment_method3" name="payment_method" value="3">
                                        <div class="order-detail-block">
                                            <div class="order-detail-radio">

                                            </div>
                                            <div class="order-detail-text-cont">
                                                <div class="order-detail-text-title">
                                                    <div class="order-detail-text-icon">
                                                        <?/*
                                                    <svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M27.29 0.0976093C27.1867 0.0339064 27.0678 0 26.9466 0H7.36462C5.68112 0 4.3115 1.35626 4.3115 3.01844L4.19643 19.8815H0.657578C0.294369 19.8815 0 20.1758 0 20.539V23.577C0.0023118 25.8079 1.81014 27.6157 4.04102 27.6183C4.08623 27.6183 4.1317 27.6137 4.17614 27.6044H20.5141C20.6115 27.6113 20.7096 27.616 20.8085 27.616C23.0741 27.6119 24.9086 25.7748 24.9094 23.5092V13.6517H29.3419C29.7051 13.6517 29.9994 13.3573 29.9994 12.9941V3.23266C29.9915 1.66295 28.842 0.332642 27.29 0.0976093ZM1.31516 23.5773V21.1969H16.7076V23.5094C16.7069 24.5397 17.0945 25.5323 17.7934 26.2893H3.95112C3.92004 26.2895 3.88922 26.2918 3.85865 26.2964C2.42816 26.1991 1.31695 25.0111 1.31516 23.5773ZM23.5942 3.23266V23.5092C23.5929 24.2443 23.3009 24.9487 22.7817 25.4688C22.2847 25.9787 21.6094 26.2764 20.8979 26.299C20.8624 26.2929 20.8265 26.2898 20.7903 26.2895H20.5591C19.1268 26.1485 18.0323 24.9489 18.0228 23.5097V20.539C18.0228 20.1761 17.7284 19.8815 17.3652 19.8815H5.51158L5.62666 3.02306C5.63616 2.07214 6.41344 1.30796 7.36462 1.31516H24.2474C23.8239 1.86459 23.594 2.53887 23.5942 3.23266ZM28.6843 12.3365H24.9094V3.23266C24.9266 2.20237 25.7665 1.37655 26.7968 1.37655C27.8271 1.37655 28.6671 2.20237 28.6843 3.23266V12.3365Z" fill="#1E1E1E"/>
                                                        <path d="M8.44273 7.12375H14.6707C15.0339 7.12375 15.3283 6.82938 15.3283 6.46617C15.3283 6.10296 15.0339 5.80859 14.6707 5.80859H8.44273C8.07953 5.80859 7.78516 6.10296 7.78516 6.46617C7.78516 6.82938 8.07953 7.12375 8.44273 7.12375Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 10.5107H8.44273C8.07953 10.5107 7.78516 10.8051 7.78516 11.1683C7.78516 11.5313 8.07953 11.8259 8.44273 11.8259H20.0603C20.4235 11.8259 20.7179 11.5313 20.7179 11.1683C20.7179 10.8051 20.4235 10.5107 20.0603 10.5107Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 15.2124H8.44273C8.07953 15.2124 7.78516 15.507 7.78516 15.87C7.78516 16.2332 8.07953 16.5276 8.44273 16.5276H20.0603C20.4235 16.5276 20.7179 16.2332 20.7179 15.87C20.7179 15.507 20.4235 15.2124 20.0603 15.2124Z" fill="#1E1E1E"/>
                                                    </svg>
                                                    */?>
                                                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="44" height="44"/>
                                                            <g>
                                                                <path d="M3.5818 17.1236H6.68152V26.5938H3.5818V17.1236ZM6.78545 14.4911C6.78545 15.3042 6.13252 15.9629 5.11133 15.9629C4.13306 15.9629 3.48013 15.3042 3.50046 14.4911C3.48013 13.6394 4.13306 13 5.13166 13C6.13026 13 6.76285 13.6394 6.78545 14.4911Z" fill="#E84F35"/>
                                                                <path d="M12.2238 19.6108C12.4904 19.6687 12.818 19.6902 13.2676 19.6902C14.9281 19.6902 15.9516 18.892 15.9516 17.5511C15.9516 16.3453 15.0705 15.6266 13.5138 15.6266C12.879 15.6266 12.4497 15.6845 12.2238 15.7425V19.6108ZM9.13086 13.6592C10.0933 13.5026 11.4466 13.3867 13.3512 13.3867C15.2761 13.3867 16.6497 13.7364 17.5715 14.438C18.4526 15.0988 19.0468 16.1887 19.0468 17.4739C19.0468 18.7569 18.595 19.8468 17.7771 20.587C16.7107 21.5396 15.136 21.9686 13.2902 21.9686C12.8812 21.9686 12.5107 21.9493 12.2238 21.9107V26.5986H9.13086V13.6592Z" fill="#7B9AA9"/>
                                                                <path d="M25.8868 22.1016C24.2489 22.0823 22.9792 22.4513 22.9792 23.5991C22.9792 24.3565 23.5124 24.7276 24.2082 24.7276C24.9854 24.7276 25.6225 24.2428 25.8259 23.6399C25.8666 23.4854 25.8868 23.3095 25.8868 23.1335V22.1016ZM26.255 26.5942L26.0698 25.6416H26.0089C25.3537 26.4011 24.328 26.8088 23.1418 26.8088C21.113 26.8088 19.9043 25.4099 19.9043 23.8909C19.9043 21.4215 22.2404 20.235 25.783 20.2543V20.1191C25.783 19.6128 25.496 18.8941 23.9597 18.8941C22.9363 18.8941 21.8495 19.2245 21.1943 19.615L20.6205 17.7098C21.3164 17.3386 22.69 16.873 24.5132 16.873C27.8524 16.873 28.9166 18.7418 28.9166 20.9774V24.2857C28.9166 25.1997 28.9571 26.075 29.0589 26.6007H26.255V26.5942Z" fill="#7B9AA9"/>
                                                                <path d="M33.4679 17.082L34.9637 21.7506C35.1264 22.3149 35.3319 23.0143 35.4539 23.5206H35.515C35.6573 23.0143 35.8221 22.2956 35.9644 21.7506L37.1935 17.082H40.5327L38.1989 23.3447C36.7642 27.1186 35.8018 28.6354 34.6745 29.588C33.5901 30.4827 32.4422 30.7938 31.6628 30.8925L31.0078 28.3844C31.3961 28.3265 31.8888 28.1506 32.3588 27.8781C32.8286 27.6442 33.3414 27.1787 33.6488 26.6916C33.7504 26.5565 33.8114 26.3999 33.8114 26.2647C33.8114 26.1681 33.7911 26.0115 33.6667 25.7777L30 17.082H33.4679Z" fill="#7B9AA9"/>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="order-detail-text-group">
                                                        <span class="top-text"><?=UA ? 'Повна оплата через сервіс Ipay' : 'Полная оплата через сервис Ipay'?></span>
                                                        <?/*
                                                    <span class="top-text">Оплата на розрахунковий рахунок ФОП</span>
                                                    <span class="bottom-text">Лише у національній валюті України (UAH). Кешбек від банків-партнерів не нараховується.</span>
                                                    */?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </label>
                                    <?
                                    if($alLSum-$minus_price >= 3000 && $chast)
                                    {
                                        ?>
                                        <label class="order-detail-element">
                                            <input type="radio" id="payment_method15" name="payment_method" value="15">
                                            <div class="order-detail-block">
                                                <div class="order-detail-radio">

                                                </div>
                                                <div class="order-detail-text-cont">
                                                    <div class="order-detail-text-title">
                                                        <div class="order-detail-text-icon bg-transp">
                                                            <?/*
                                                    <svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M27.29 0.0976093C27.1867 0.0339064 27.0678 0 26.9466 0H7.36462C5.68112 0 4.3115 1.35626 4.3115 3.01844L4.19643 19.8815H0.657578C0.294369 19.8815 0 20.1758 0 20.539V23.577C0.0023118 25.8079 1.81014 27.6157 4.04102 27.6183C4.08623 27.6183 4.1317 27.6137 4.17614 27.6044H20.5141C20.6115 27.6113 20.7096 27.616 20.8085 27.616C23.0741 27.6119 24.9086 25.7748 24.9094 23.5092V13.6517H29.3419C29.7051 13.6517 29.9994 13.3573 29.9994 12.9941V3.23266C29.9915 1.66295 28.842 0.332642 27.29 0.0976093ZM1.31516 23.5773V21.1969H16.7076V23.5094C16.7069 24.5397 17.0945 25.5323 17.7934 26.2893H3.95112C3.92004 26.2895 3.88922 26.2918 3.85865 26.2964C2.42816 26.1991 1.31695 25.0111 1.31516 23.5773ZM23.5942 3.23266V23.5092C23.5929 24.2443 23.3009 24.9487 22.7817 25.4688C22.2847 25.9787 21.6094 26.2764 20.8979 26.299C20.8624 26.2929 20.8265 26.2898 20.7903 26.2895H20.5591C19.1268 26.1485 18.0323 24.9489 18.0228 23.5097V20.539C18.0228 20.1761 17.7284 19.8815 17.3652 19.8815H5.51158L5.62666 3.02306C5.63616 2.07214 6.41344 1.30796 7.36462 1.31516H24.2474C23.8239 1.86459 23.594 2.53887 23.5942 3.23266ZM28.6843 12.3365H24.9094V3.23266C24.9266 2.20237 25.7665 1.37655 26.7968 1.37655C27.8271 1.37655 28.6671 2.20237 28.6843 3.23266V12.3365Z" fill="#1E1E1E"/>
                                                        <path d="M8.44273 7.12375H14.6707C15.0339 7.12375 15.3283 6.82938 15.3283 6.46617C15.3283 6.10296 15.0339 5.80859 14.6707 5.80859H8.44273C8.07953 5.80859 7.78516 6.10296 7.78516 6.46617C7.78516 6.82938 8.07953 7.12375 8.44273 7.12375Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 10.5107H8.44273C8.07953 10.5107 7.78516 10.8051 7.78516 11.1683C7.78516 11.5313 8.07953 11.8259 8.44273 11.8259H20.0603C20.4235 11.8259 20.7179 11.5313 20.7179 11.1683C20.7179 10.8051 20.4235 10.5107 20.0603 10.5107Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 15.2124H8.44273C8.07953 15.2124 7.78516 15.507 7.78516 15.87C7.78516 16.2332 8.07953 16.5276 8.44273 16.5276H20.0603C20.4235 16.5276 20.7179 16.2332 20.7179 15.87C20.7179 15.507 20.4235 15.2124 20.0603 15.2124Z" fill="#1E1E1E"/>
                                                    </svg>
                                                    */?>
                                                            <svg width="25" height="25" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.92004 11.1955C1.06831 9.81362 0.794053 8.15752 1.15549 6.57872C1.51693 4.99993 2.48561 3.62276 3.85589 2.73957L7.28454 7.95419L1.92004 11.1955Z"/>
                                                                <path d="M5.31799 2.98764C6.3714 2.31742 7.60302 1.97403 8.85488 2.00153C10.1067 2.02903 11.3218 2.42616 12.3441 3.14198C13.3665 3.8578 14.1495 4.85968 14.5929 6.01912C15.0362 7.17856 15.1197 8.4427 14.8325 9.6494C14.5452 10.8561 13.9005 11.9503 12.9809 12.7918C12.0613 13.6332 10.9088 14.1835 9.67124 14.3721C8.43363 14.5606 7.16736 14.3788 6.03482 13.85C4.90228 13.3212 3.95512 12.4695 3.3148 11.4041L8.71548 8.22222L5.31799 2.98764Z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="order-detail-text-group">
                                                            <span class="top-text"><?=UA ? 'Оплата частинами ПриватБанк' : 'Оплата частями ПриватБанк'?></span>
                                                            <span class="bottom-text"><?=UA ? 'Доступна оплата частинами до 3-х місяців' : 'Доступна оплата частями до 3 месяцев'?></span>
                                                            <?/*
                                                    <span class="top-text">Оплата на розрахунковий рахунок ФОП</span>
                                                    <span class="bottom-text">Лише у національній валюті України (UAH). Кешбек від банків-партнерів не нараховується.</span>
                                                    */?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </label>
                                        <?
                                    }
                                    if($alLSum-$minus_price >= 3000 && $chast)
                                    {
                                        ?>
                                        <label class="order-detail-element">
                                            <input type="radio" id="payment_method15" name="payment_method" value="14">
                                            <div class="order-detail-block">
                                                <div class="order-detail-radio">

                                                </div>
                                                <div class="order-detail-text-cont">
                                                    <div class="order-detail-text-title">
                                                        <div class="order-detail-text-icon bg-transp">
                                                            <?/*
                                                    <svg width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M27.29 0.0976093C27.1867 0.0339064 27.0678 0 26.9466 0H7.36462C5.68112 0 4.3115 1.35626 4.3115 3.01844L4.19643 19.8815H0.657578C0.294369 19.8815 0 20.1758 0 20.539V23.577C0.0023118 25.8079 1.81014 27.6157 4.04102 27.6183C4.08623 27.6183 4.1317 27.6137 4.17614 27.6044H20.5141C20.6115 27.6113 20.7096 27.616 20.8085 27.616C23.0741 27.6119 24.9086 25.7748 24.9094 23.5092V13.6517H29.3419C29.7051 13.6517 29.9994 13.3573 29.9994 12.9941V3.23266C29.9915 1.66295 28.842 0.332642 27.29 0.0976093ZM1.31516 23.5773V21.1969H16.7076V23.5094C16.7069 24.5397 17.0945 25.5323 17.7934 26.2893H3.95112C3.92004 26.2895 3.88922 26.2918 3.85865 26.2964C2.42816 26.1991 1.31695 25.0111 1.31516 23.5773ZM23.5942 3.23266V23.5092C23.5929 24.2443 23.3009 24.9487 22.7817 25.4688C22.2847 25.9787 21.6094 26.2764 20.8979 26.299C20.8624 26.2929 20.8265 26.2898 20.7903 26.2895H20.5591C19.1268 26.1485 18.0323 24.9489 18.0228 23.5097V20.539C18.0228 20.1761 17.7284 19.8815 17.3652 19.8815H5.51158L5.62666 3.02306C5.63616 2.07214 6.41344 1.30796 7.36462 1.31516H24.2474C23.8239 1.86459 23.594 2.53887 23.5942 3.23266ZM28.6843 12.3365H24.9094V3.23266C24.9266 2.20237 25.7665 1.37655 26.7968 1.37655C27.8271 1.37655 28.6671 2.20237 28.6843 3.23266V12.3365Z" fill="#1E1E1E"/>
                                                        <path d="M8.44273 7.12375H14.6707C15.0339 7.12375 15.3283 6.82938 15.3283 6.46617C15.3283 6.10296 15.0339 5.80859 14.6707 5.80859H8.44273C8.07953 5.80859 7.78516 6.10296 7.78516 6.46617C7.78516 6.82938 8.07953 7.12375 8.44273 7.12375Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 10.5107H8.44273C8.07953 10.5107 7.78516 10.8051 7.78516 11.1683C7.78516 11.5313 8.07953 11.8259 8.44273 11.8259H20.0603C20.4235 11.8259 20.7179 11.5313 20.7179 11.1683C20.7179 10.8051 20.4235 10.5107 20.0603 10.5107Z" fill="#1E1E1E"/>
                                                        <path d="M20.0603 15.2124H8.44273C8.07953 15.2124 7.78516 15.507 7.78516 15.87C7.78516 16.2332 8.07953 16.5276 8.44273 16.5276H20.0603C20.4235 16.5276 20.7179 16.2332 20.7179 15.87C20.7179 15.507 20.4235 15.2124 20.0603 15.2124Z" fill="#1E1E1E"/>
                                                    </svg>
                                                    */?>
                                                             <svg width="25" height="25" viewBox="0 0 16 16" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.75377 13.8172C9.36677 13.7211 8.97029 13.633 8.59271 13.5208C8.33315 13.4448 8.08769 13.3366 7.84229 13.2285C6.88889 12.804 5.88829 12.6879 4.82634 12.8C4.30717 12.8561 3.76439 12.8801 3.25466 12.804C2.0228 12.6238 1.29123 11.5986 1.57442 10.5414C1.79625 9.72843 2.37678 9.12776 3.18386 8.69122C3.84935 8.32683 4.43932 7.89029 5.00097 7.42577C5.34079 7.14143 5.69478 6.86513 6.06764 6.60883C7.29005 5.75183 8.87591 6.30848 9.42341 7.09739C9.71603 7.52188 9.94259 7.97844 10.1786 8.42696C10.4335 8.91953 10.7355 9.38003 11.1272 9.80453C11.6133 10.3292 11.9296 10.9138 12.0192 11.5826C12.175 12.76 11.132 13.7852 9.77735 13.7732C9.76793 13.7811 9.76319 13.7972 9.75377 13.8172Z"/>
                                                                <path d="M12.5295 3.94437C12.4729 4.81338 12.0764 5.57026 11.2033 6.10688C10.0894 6.79167 8.85754 6.37519 8.59798 5.23387C8.37142 4.25273 9.01804 3.03932 10.0375 2.53073C11.1844 1.95807 12.3549 2.47066 12.5059 3.61198C12.5154 3.7121 12.5201 3.81222 12.5295 3.94437Z"/>
                                                                <path d="M7.89298 3.69445C7.88824 4.21105 7.75137 4.69962 7.39737 5.12812C6.69413 5.9771 5.52362 5.98912 4.8015 5.15615C4.09353 4.3392 4.10297 2.99764 4.82037 2.1887C5.50946 1.4118 6.63276 1.4078 7.33132 2.1807C7.69474 2.57715 7.89298 3.11378 7.89298 3.69445Z"/>
                                                                <path d="M11.084 8.04012C11.0887 7.10705 11.9713 6.14994 13.0285 5.93369C14.0433 5.72544 14.8409 6.22602 14.9023 7.11105C14.9683 8.08818 14.0008 9.14941 12.868 9.33763C11.8533 9.50182 11.0793 8.94118 11.084 8.04012Z"/>
                                                                <path d="M4.21015 6.15683C4.20071 6.68144 4.08271 7.09392 3.74761 7.44631C3.29452 7.91887 2.59599 8.02703 1.97298 7.72663C0.826079 7.17001 0.42962 5.62422 1.19894 4.71916C1.65204 4.18254 2.41192 4.03837 3.07269 4.38678C3.87505 4.80726 4.15823 5.47204 4.21015 6.15683Z"/>
                                                            </svg>                                                   
                                                        </div>
                                                        <div class="order-detail-text-group">
                                                            <span class="top-text"><?=UA ? 'Покупка частинами monobank' : 'Покупка частями monobank'?></span>
                                                            <span class="bottom-text"><?=UA ? 'Доступна оплата частинами до 3-х місяців' : 'Доступна оплата частями до 3 месяцев'?></span>
                                                            <?/*
                                                    <span class="top-text">Оплата на розрахунковий рахунок ФОП</span>
                                                    <span class="bottom-text">Лише у національній валюті України (UAH). Кешбек від банків-партнерів не нараховується.</span>
                                                    */?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </label>
                                        <?
                                    }
                                    ?>
                                    <?
                                    if($allQuantity == 1)
                                    {
                                        ?>
                                        <label class="order-detail-element svNovaPoshta">
                                            <input type="radio" id="payment_method2" name="payment_method" value="9">
                                            <div class="order-detail-block">
                                                <div class="order-detail-radio">

                                                </div>
                                                <div class="order-detail-text-cont">
                                                    <div class="order-detail-text-title">
                                                        <div class="order-detail-text-icon">
                                                            <?/*
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.02285 23.3087L0.69136 23.0222C-0.1137 22.3297 -0.255775 21.0642 0.478225 20.2524L9.09708 10.3192C9.78374 9.50741 11.0387 9.36415 11.8438 10.1043L12.1752 10.3909C12.9803 11.0833 13.1224 12.3489 12.3883 13.1607L3.76953 23.0938C3.08282 23.9057 1.87525 24.0012 1.02285 23.3087Z" fill="url(#paint0_linear_569_9149)"/>
                                                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M7.93679 12.0392L7.77104 11.8481L6.44507 13.3763L6.5871 13.5434C8.8602 15.8357 7.8894 18.1519 7.36849 18.9637L7.55791 18.7488C7.86573 18.3906 8.33929 17.8414 8.83653 17.2445C9.35744 16.3371 10.0915 14.1882 7.93679 12.0392Z" fill="url(#paint1_linear_569_9149)"/>
                                                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M10.7782 15.0233L11.1334 14.6174C11.157 14.5696 11.2044 14.5219 11.2281 14.4741C10.8493 14.9039 10.4467 15.3576 10.0679 15.8113C10.352 15.5009 10.5888 15.2382 10.7782 15.0233Z" fill="url(#paint2_radial_569_9149)"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4357 10.6303L3.81688 0.697157C3.13023 -0.114667 1.87527 -0.25793 1.07021 0.482285L0.738716 0.768811C-0.0663442 1.46127 -0.20842 2.72678 0.525626 3.53861L7.79479 11.8481L7.96054 12.0391C10.1153 14.212 9.38124 16.361 8.83666 17.2683C9.26284 16.7669 9.68906 16.2655 10.0916 15.8118C10.4705 15.3581 10.873 14.9044 11.2518 14.4746C11.6307 14.0448 11.9858 13.6389 12.2226 13.3762C13.0514 12.5644 13.1697 11.4422 12.4357 10.6303Z" fill="url(#paint3_linear_569_9149)"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9621 23.3087L11.6306 23.0222C10.8255 22.3297 10.6834 21.0642 11.4175 20.2524L20.0362 10.3192C20.723 9.50741 21.9779 9.36415 22.7831 10.1043L23.1144 10.3909C23.9196 11.0833 24.0617 12.3489 23.3274 13.1607L14.7087 23.0938C14.0221 23.9057 12.8145 24.0012 11.9621 23.3087Z" fill="url(#paint4_linear_569_9149)"/>
                                                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M18.971 11.9439L18.8052 11.7529L17.479 13.2811L17.6211 13.4482C19.8941 15.7405 18.9235 18.0566 18.4026 18.8685L18.5922 18.6536C18.8998 18.2954 19.3736 17.7462 19.8708 17.1493C20.3918 16.2419 21.1257 14.0929 18.971 11.9439Z" fill="url(#paint5_linear_569_9149)"/>
                                                        <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M21.6935 15.0233L22.0491 14.6174C22.0724 14.5696 22.1199 14.5219 22.1437 14.4741C21.7648 14.9039 21.3622 15.3576 20.9834 15.8113C21.2676 15.5009 21.5281 15.2382 21.6935 15.0233Z" fill="url(#paint6_radial_569_9149)"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.3511 10.6303L14.7324 0.697157C14.0457 -0.114667 12.7908 -0.25793 11.9857 0.482285L11.6543 0.768811C10.8492 1.46127 10.7071 2.72678 11.4411 3.53861L18.7105 11.8481L18.8759 12.0391C21.0306 14.212 20.2967 16.361 19.752 17.2683C20.1783 16.7669 20.6047 16.2655 21.0073 15.8118C21.3861 15.3581 21.7883 14.9044 22.1676 14.4746C22.5464 14.0448 22.9015 13.6389 23.1382 13.3762C23.9667 12.5644 24.085 11.4422 23.3511 10.6303Z" fill="url(#paint7_linear_569_9149)"/>
                                                        <defs>
                                                            <linearGradient id="paint0_linear_569_9149" x1="3.71487" y1="26.4091" x2="15.7141" y2="20.6398" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#1FADC3"/>
                                                                <stop offset="0.7072" stop-color="#36B98F"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint1_linear_569_9149" x1="7.91485" y1="17.0165" x2="10.1516" y2="16.6935" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#123F06" stop-opacity="0.01"/>
                                                                <stop offset="1" stop-color="#123F06"/>
                                                            </linearGradient>
                                                            <radialGradient id="paint2_radial_569_9149" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(6.02878 16.2647) scale(5.77319 6.65353)">
                                                                <stop offset="0.4185" stop-color="#123F06" stop-opacity="0.01"/>
                                                                <stop offset="1" stop-color="#123F06"/>
                                                            </radialGradient>
                                                            <linearGradient id="paint3_linear_569_9149" x1="-4.46577" y1="13.1624" x2="10.0664" y2="18.1423" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#9FDB57"/>
                                                                <stop offset="1" stop-color="#71CA5E"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint4_linear_569_9149" x1="14.6437" y1="26.4151" x2="26.6432" y2="20.6459" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#1FADC3"/>
                                                                <stop offset="0.7072" stop-color="#36B98F"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint5_linear_569_9149" x1="18.9491" y1="16.9213" x2="21.1856" y2="16.5983" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#123F06" stop-opacity="0.01"/>
                                                                <stop offset="1" stop-color="#123F06"/>
                                                            </linearGradient>
                                                            <radialGradient id="paint6_radial_569_9149" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(16.9542 16.2647) scale(5.7732 6.65353)">
                                                                <stop offset="0.4185" stop-color="#123F06" stop-opacity="0.01"/>
                                                                <stop offset="1" stop-color="#123F06"/>
                                                            </radialGradient>
                                                            <linearGradient id="paint7_linear_569_9149" x1="6.45684" y1="13.1668" x2="20.989" y2="18.1467" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#9FDB57"/>
                                                                <stop offset="1" stop-color="#71CA5E"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                    */?>
                                                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="44" height="44" />
                                                                <g>
                                                                    <path d="M3.5818 17.1236H6.68152V26.5938H3.5818V17.1236ZM6.78545 14.4911C6.78545 15.3042 6.13252 15.9629 5.11133 15.9629C4.13306 15.9629 3.48013 15.3042 3.50046 14.4911C3.48013 13.6394 4.13306 13 5.13166 13C6.13026 13 6.76285 13.6394 6.78545 14.4911Z" fill="#E84F35"/>
                                                                    <path d="M12.2238 19.6108C12.4904 19.6687 12.818 19.6902 13.2676 19.6902C14.9281 19.6902 15.9516 18.892 15.9516 17.5511C15.9516 16.3453 15.0705 15.6266 13.5138 15.6266C12.879 15.6266 12.4497 15.6845 12.2238 15.7425V19.6108ZM9.13086 13.6592C10.0933 13.5026 11.4466 13.3867 13.3512 13.3867C15.2761 13.3867 16.6497 13.7364 17.5715 14.438C18.4526 15.0988 19.0468 16.1887 19.0468 17.4739C19.0468 18.7569 18.595 19.8468 17.7771 20.587C16.7107 21.5396 15.136 21.9686 13.2902 21.9686C12.8812 21.9686 12.5107 21.9493 12.2238 21.9107V26.5986H9.13086V13.6592Z" fill="#7B9AA9"/>
                                                                    <path d="M25.8868 22.1016C24.2489 22.0823 22.9792 22.4513 22.9792 23.5991C22.9792 24.3565 23.5124 24.7276 24.2082 24.7276C24.9854 24.7276 25.6225 24.2428 25.8259 23.6399C25.8666 23.4854 25.8868 23.3095 25.8868 23.1335V22.1016ZM26.255 26.5942L26.0698 25.6416H26.0089C25.3537 26.4011 24.328 26.8088 23.1418 26.8088C21.113 26.8088 19.9043 25.4099 19.9043 23.8909C19.9043 21.4215 22.2404 20.235 25.783 20.2543V20.1191C25.783 19.6128 25.496 18.8941 23.9597 18.8941C22.9363 18.8941 21.8495 19.2245 21.1943 19.615L20.6205 17.7098C21.3164 17.3386 22.69 16.873 24.5132 16.873C27.8524 16.873 28.9166 18.7418 28.9166 20.9774V24.2857C28.9166 25.1997 28.9571 26.075 29.0589 26.6007H26.255V26.5942Z" fill="#7B9AA9"/>
                                                                    <path d="M33.4679 17.082L34.9637 21.7506C35.1264 22.3149 35.3319 23.0143 35.4539 23.5206H35.515C35.6573 23.0143 35.8221 22.2956 35.9644 21.7506L37.1935 17.082H40.5327L38.1989 23.3447C36.7642 27.1186 35.8018 28.6354 34.6745 29.588C33.5901 30.4827 32.4422 30.7938 31.6628 30.8925L31.0078 28.3844C31.3961 28.3265 31.8888 28.1506 32.3588 27.8781C32.8286 27.6442 33.3414 27.1787 33.6488 26.6916C33.7504 26.5565 33.8114 26.3999 33.8114 26.2647C33.8114 26.1681 33.7911 26.0115 33.6667 25.7777L30 17.082H33.4679Z" fill="#7B9AA9"/>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div class="order-detail-text-group">
                                                            <span class="top-text"><?=UA ? 'Післяплата (при завдатку 200 грн через сервіс Ipay)' : 'Постоплата (при задатке 200грн через сервис Ipay)'?></span>


                                                            <?/*
                                                    <span class="top-text">Карта Visa/Mastercard (LiqPay)</span>
                                                    <span class="bottom-text">Ми працюємо тільки за повною передоплатою.</span>
                                                    */?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <?
                                    }
                                    ?>


                                    <?/*
                                <label class="order-detail-element">
                                    <input type="radio" name="radio-pay">
                                    <div class="order-detail-block">
                                        <div class="order-detail-radio">

                                        </div>
                                        <div class="order-detail-text-cont">
                                            <div class="order-detail-text-title">
                                                <div class="order-detail-text-icon">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.2054 16.9198L5.23076 20.5583L1.66846 20.6336C0.603861 18.659 0 16.3998 0 13.999C0 11.6775 0.564595 9.48823 1.56538 7.56055H1.56614L4.73759 8.14198L6.12687 11.2944C5.8361 12.1421 5.67761 13.0521 5.67761 13.999C5.67772 15.0267 5.86388 16.0114 6.2054 16.9198Z" fill="#FBBB00"/>
                                                        <path d="M27.7552 11.3838C27.916 12.2307 27.9999 13.1053 27.9999 13.9992C27.9999 15.0015 27.8945 15.9792 27.6937 16.9223C27.0122 20.1315 25.2314 22.9338 22.7645 24.9169L22.7637 24.9161L18.7691 24.7123L18.2038 21.183C19.8407 20.2231 21.1199 18.7207 21.7938 16.9223H14.3076V11.3838H21.903H27.7552Z" fill="#518EF8"/>
                                                        <path d="M22.7644 24.917L22.7651 24.9178C20.3659 26.8463 17.3182 28.0001 14.0005 28.0001C8.66896 28.0001 4.03358 25.0201 1.66895 20.6347L6.20588 16.9209C7.38818 20.0763 10.432 22.3224 14.0005 22.3224C15.5343 22.3224 16.9713 21.9078 18.2043 21.184L22.7644 24.917Z" fill="#28B446"/>
                                                        <path d="M22.9363 3.22307L18.4008 6.93614C17.1247 6.13847 15.6162 5.67767 14.0001 5.67767C10.3508 5.67767 7.25004 8.02688 6.12698 11.2954L1.5662 7.56155H1.56543C3.89545 3.06923 8.58929 0 14.0001 0C17.397 0 20.5116 1.21002 22.9363 3.22307Z" fill="#F14336"/>
                                                    </svg>
                                                </div>
                                                <div class="order-detail-text-group">
                                                    <span class="top-text">Google Pay</span>
                                                    <span class="bottom-text">Ми працюємо тільки за повною передоплатою.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="order-detail-element">
                                    <input type="radio" name="radio-pay">
                                    <div class="order-detail-block">
                                        <div class="order-detail-radio">

                                        </div>
                                        <div class="order-detail-text-cont">
                                            <div class="order-detail-text-title">
                                                <div class="order-detail-text-icon">
                                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="44" height="44" />
                                                        <g>
                                                            <path d="M3.5818 17.1236H6.68152V26.5938H3.5818V17.1236ZM6.78545 14.4911C6.78545 15.3042 6.13252 15.9629 5.11133 15.9629C4.13306 15.9629 3.48013 15.3042 3.50046 14.4911C3.48013 13.6394 4.13306 13 5.13166 13C6.13026 13 6.76285 13.6394 6.78545 14.4911Z" fill="#E84F35"/>
                                                            <path d="M12.2238 19.6108C12.4904 19.6687 12.818 19.6902 13.2676 19.6902C14.9281 19.6902 15.9516 18.892 15.9516 17.5511C15.9516 16.3453 15.0705 15.6266 13.5138 15.6266C12.879 15.6266 12.4497 15.6845 12.2238 15.7425V19.6108ZM9.13086 13.6592C10.0933 13.5026 11.4466 13.3867 13.3512 13.3867C15.2761 13.3867 16.6497 13.7364 17.5715 14.438C18.4526 15.0988 19.0468 16.1887 19.0468 17.4739C19.0468 18.7569 18.595 19.8468 17.7771 20.587C16.7107 21.5396 15.136 21.9686 13.2902 21.9686C12.8812 21.9686 12.5107 21.9493 12.2238 21.9107V26.5986H9.13086V13.6592Z" fill="#7B9AA9"/>
                                                            <path d="M25.8868 22.1016C24.2489 22.0823 22.9792 22.4513 22.9792 23.5991C22.9792 24.3565 23.5124 24.7276 24.2082 24.7276C24.9854 24.7276 25.6225 24.2428 25.8259 23.6399C25.8666 23.4854 25.8868 23.3095 25.8868 23.1335V22.1016ZM26.255 26.5942L26.0698 25.6416H26.0089C25.3537 26.4011 24.328 26.8088 23.1418 26.8088C21.113 26.8088 19.9043 25.4099 19.9043 23.8909C19.9043 21.4215 22.2404 20.235 25.783 20.2543V20.1191C25.783 19.6128 25.496 18.8941 23.9597 18.8941C22.9363 18.8941 21.8495 19.2245 21.1943 19.615L20.6205 17.7098C21.3164 17.3386 22.69 16.873 24.5132 16.873C27.8524 16.873 28.9166 18.7418 28.9166 20.9774V24.2857C28.9166 25.1997 28.9571 26.075 29.0589 26.6007H26.255V26.5942Z" fill="#7B9AA9"/>
                                                            <path d="M33.4679 17.082L34.9637 21.7506C35.1264 22.3149 35.3319 23.0143 35.4539 23.5206H35.515C35.6573 23.0143 35.8221 22.2956 35.9644 21.7506L37.1935 17.082H40.5327L38.1989 23.3447C36.7642 27.1186 35.8018 28.6354 34.6745 29.588C33.5901 30.4827 32.4422 30.7938 31.6628 30.8925L31.0078 28.3844C31.3961 28.3265 31.8888 28.1506 32.3588 27.8781C32.8286 27.6442 33.3414 27.1787 33.6488 26.6916C33.7504 26.5565 33.8114 26.3999 33.8114 26.2647C33.8114 26.1681 33.7911 26.0115 33.6667 25.7777L30 17.082H33.4679Z" fill="#7B9AA9"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div class="order-detail-text-group">
                                                    <span class="top-text">Оплата картою через сервіс Ipay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="order-detail-element">
                                    <input type="radio" name="radio-pay">
                                    <div class="order-detail-block">
                                        <div class="order-detail-radio">

                                        </div>
                                        <div class="order-detail-text-cont">
                                            <div class="order-detail-text-title">
                                                <div class="order-detail-text-icon">
                                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="44" height="44" />
                                                        <g>
                                                            <path d="M3.5818 17.1236H6.68152V26.5938H3.5818V17.1236ZM6.78545 14.4911C6.78545 15.3042 6.13252 15.9629 5.11133 15.9629C4.13306 15.9629 3.48013 15.3042 3.50046 14.4911C3.48013 13.6394 4.13306 13 5.13166 13C6.13026 13 6.76285 13.6394 6.78545 14.4911Z" fill="#E84F35"/>
                                                            <path d="M12.2238 19.6108C12.4904 19.6687 12.818 19.6902 13.2676 19.6902C14.9281 19.6902 15.9516 18.892 15.9516 17.5511C15.9516 16.3453 15.0705 15.6266 13.5138 15.6266C12.879 15.6266 12.4497 15.6845 12.2238 15.7425V19.6108ZM9.13086 13.6592C10.0933 13.5026 11.4466 13.3867 13.3512 13.3867C15.2761 13.3867 16.6497 13.7364 17.5715 14.438C18.4526 15.0988 19.0468 16.1887 19.0468 17.4739C19.0468 18.7569 18.595 19.8468 17.7771 20.587C16.7107 21.5396 15.136 21.9686 13.2902 21.9686C12.8812 21.9686 12.5107 21.9493 12.2238 21.9107V26.5986H9.13086V13.6592Z" fill="#7B9AA9"/>
                                                            <path d="M25.8868 22.1016C24.2489 22.0823 22.9792 22.4513 22.9792 23.5991C22.9792 24.3565 23.5124 24.7276 24.2082 24.7276C24.9854 24.7276 25.6225 24.2428 25.8259 23.6399C25.8666 23.4854 25.8868 23.3095 25.8868 23.1335V22.1016ZM26.255 26.5942L26.0698 25.6416H26.0089C25.3537 26.4011 24.328 26.8088 23.1418 26.8088C21.113 26.8088 19.9043 25.4099 19.9043 23.8909C19.9043 21.4215 22.2404 20.235 25.783 20.2543V20.1191C25.783 19.6128 25.496 18.8941 23.9597 18.8941C22.9363 18.8941 21.8495 19.2245 21.1943 19.615L20.6205 17.7098C21.3164 17.3386 22.69 16.873 24.5132 16.873C27.8524 16.873 28.9166 18.7418 28.9166 20.9774V24.2857C28.9166 25.1997 28.9571 26.075 29.0589 26.6007H26.255V26.5942Z" fill="#7B9AA9"/>
                                                            <path d="M33.4679 17.082L34.9637 21.7506C35.1264 22.3149 35.3319 23.0143 35.4539 23.5206H35.515C35.6573 23.0143 35.8221 22.2956 35.9644 21.7506L37.1935 17.082H40.5327L38.1989 23.3447C36.7642 27.1186 35.8018 28.6354 34.6745 29.588C33.5901 30.4827 32.4422 30.7938 31.6628 30.8925L31.0078 28.3844C31.3961 28.3265 31.8888 28.1506 32.3588 27.8781C32.8286 27.6442 33.3414 27.1787 33.6488 26.6916C33.7504 26.5565 33.8114 26.3999 33.8114 26.2647C33.8114 26.1681 33.7911 26.0115 33.6667 25.7777L30 17.082H33.4679Z" fill="#7B9AA9"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div class="order-detail-text-group">
                                                    <span class="top-text">Післяплата</span>
                                                    <span class="bottom-text">(при завдатку 200грн через сервіс Ipay)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                */?>
                                </div>
                            </div>
                            <div class="order-detail-comment-block">
                                <div class="order-detail-comment-title">
                                    <?=UA?'Коментар до замовлення':'Комментарий к заказу'?>
                                </div>
                                <div class="order-detail-comment-input">
                                    <div class="form-block">
                                        <textarea name="comment" id="user_comment" class="form-control" placeholder="<?=LANGUAGE_ID == 'ua' ? 'Якщо замовлення потрібне до певної дати, вкажіть це тут...' : 'Если заказ нужен до определенной даты, укажите это здесь...'?>"></textarea>
                                    </div>
                                </div>
                                <div class="create_error" style="color:red;display:none;">При оформленні замовлення виникла помилка</div>
                                <div class="lic_condition" style="color:red;<?=!$isOrder ? '' : 'display:none;'?>">У Вас в кошику товари, яких немає в наявності.</div>
                            </div>
                        </div>
                        <div class="order-total-cont">
                            <div class="order-total-block">
                                <div class="order-prom-block">
                                    <input type="text" name="coupon" placeholder="Маю промокод/сертифікат" class="form-control " value="<?=$_SESSION['COUPON']?>">
                                    <a href="#" class="info-btn info-btn-black set_coupon"><?=LANGUAGE_ID == 'ua' ? 'Застосувати' : 'Применить'?></a>
                                    <?/*<select class="form-select">
                                    <option>Додати сертифікат або промокод</option>
                                    <option>промокод 1</option>
                                    <option>промокод 1</option>
                                    <option>промокод 1</option>
                                    <option>промокод 1</option>
                                </select>*/?>
                                </div>
                                <div class="order-total-info-block">
                                    <div class="order-total-info">
                                        <div class="order-total-count">
                                            <div class="order-total-count-key">
                                                <?=$totalCount?> од
                                            </div>
                                            <div class="order-total-count-value">
                                                <?=FormatCurrency($alLSum-$minus_price,'UAH')?>
                                            </div>
                                        </div>
                                        <div class="order-total-price">
                                            <div class="order-total-price-item delivery">
                                            <div class="order-total-price-key">
                                                Доставка:
                                            </div>
                                            <div class="order-total-price-value">
                                                По тарифам ТК
                                            </div>
                                        </div>
                                        <?/*<div class="order-total-price-item">
                                            <div class="order-total-price-key">
                                                Знижка статусу <a href="#">“Діва”</a>
                                            </div>
                                            <div class="order-total-price-value">
                                                -10%
                                            </div>
                                        </div>*/?>
                                            <?
                                            if($stims)
                                            {
                                                ?>
                                                <div class="order-total-price-item">
                                                    <div class="order-total-price-key">
                                                        Кількість списаних стімзів
                                                    </div>
                                                    <div class="order-total-price-value">
                                                        -<?=$stims?>
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>
                                            <?
                                            if($isJulyAction && isset($arResult['JULY_PERCENT']))
                                            {
                                                $minus_price = round($arResult['JULY_PERCENT']);
                                                ?>
                                                <div class="order-total-price-item">
                                                    <div class="order-total-price-key">
                                                        Знижка
                                                    </div>
                                                    <div class="order-total-price-value">
                                                        -<?=$minus_price?> ₴
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            if($arResult['IS_ACTION_APRIL_2026'] == 1 && $isAprilAction)
                                            {
                                                $minus_price += 800;
                                                ?>
                                                <div class="order-total-price-item">
                                                    <div class="order-total-price-key">
                                                        Знижка
                                                    </div>
                                                    <div class="order-total-price-value">
                                                        -800 ₴
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>
                                            <div class="order-total-price-item total">
                                                <div class="order-total-price-key">
                                                    Загальна сума:
                                                </div>
                                                <div class="order-total-price-value" data-entity="full_value" data-price="<?=$alLSum?>">
                                                    <?=FormatCurrency($alLSum-$minus_price,'UAH')?>
                                                </div>
                                            </div>

                                            <?/*
                                        <div class="order-total-price-item">
                                            <div class="order-total-price-key">
                                                Знижка за промокодом: DRT45
                                            </div>
                                            <div class="order-total-price-value">
                                                -200 ₴
                                            </div>
                                        </div>
                                        */?>
                                        </div>
                                    </div>
                                    <div class="form-btn">

                                        <?
                                        $isAprilAction = strtotime(date('20.04.2026 00:00:00')) < strtotime(date('d.m.Y H:i:s')) && strtotime(date('d.m.Y H:i:s')) < strtotime(date('31.05.2026 23:59:59'));

                                        if($stims > $balance)
                                        {
                                            ?><div style="text-align: center;"><?=LANGUAGE_ID=='ua'?'У вас не достатньо стімзів для покупки':'У вас недостаточно стимзов для покупки'?></div><?
                                        }
                                        elseif($isAprilAction)
                                        {
                                            if(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) == 1)
                                            {
                                                ?><span>Додай ще 3 речі з інших категорій одягу — і отримай -800 грн.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) < 3 && count($arResult['ALL_QUANTITY_LEFT_SECTION']) >= 3)
                                            {
                                                ?><span>Для знижки потрібні 3 речі з різних категорій одягу. Додай ще 1 річ з іншої категорії.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) == 2)
                                            {
                                                ?><span>Додай ще 2 річ з іншої категорії одягу — і твої -800 грн уже чекають.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) >= 3 && $alLSum-$minus_price < 4500 && $arResult['QUANTITY_PRODUCTS'] <= 4)
                                            {
                                                ?><span>Додай ще 1 річ — і отримай -800 грн.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) >= 3 && $alLSum-$minus_price >= 4500 && $arResult['QUANTITY_PRODUCTS'] < 4)
                                            {
                                                ?><span>Додай ще 1 річ — і отримай -800 грн.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) >= 3 && $alLSum-$minus_price < 4500 )
                                            {
                                                ?><span>Ти вже майже у виграші. Додай ще товарів на <?=4500-($alLSum-$minus_price)?> грн, щоб отримати -800 грн.<br><a href="/catalog/zhenskaya_odezhda/">Додати ще річ</a></span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) >= 3 && $alLSum-$minus_price >= 4500 && $arResult['QUANTITY_PRODUCTS'] >= 4)
                                            {
                                                ?><span>Готово — твої -800 грн уже в кошику.</span><?
                                            }
                                            elseif(count(array_unique($arResult['ALL_QUANTITY_LEFT_SECTION'])) == 0 && count($arResult['ALL_QUANTITY_LEFT_SECTION_ACCS']))
                                            {
                                                ?><span>Акція діє лише на одяг. Додай речі з категорії одягу, щоб отримати -800 грн.</span><?
                                            }
                                            ?>

                                            <?
                                        }
                                        ?>
                                        <button class="info-btn info-btn-black create_order">
                                            <?=UA?'Перейти до оплати':'Перейти к оплате'?>
                                        </button>
                                    </div>
                                    <div class="form-bottom-text">
                                        Натискаючи на кнопку Перейти до оплати, ви погоджуєтеся з <a href="<?=$ru?>/include/licenses_detail.php">Політикою конфіденційності</a>
                                    </div>
                                </div>
                            </div>
                            <?
                            if(!empty($ids))
                            {
                                $ids2=[];
                                $cml2link = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 390 and IBLOCK_ELEMENT_ID in ('.implode(',',$ids).') ');
                                while ($record= $cml2link->Fetch())
                                    $ids2[$record['VALUE']] = $record['VALUE'];

                                if(!empty($ids2))
                                {
                                    $res = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 868 and IBLOCK_ELEMENT_ID in ('.implode(',',$ids2).') ');
                                    $ids = [];
                                    while ($record = $res->Fetch())
                                        $ids[$record['VALUE']] = $record['VALUE'];

                                    if(!empty($ids))
                                    {
                                        ?>
                                        <div class="order-dop-goods-block">
                                            <div class="order-dop-goods-title">
                                                <?=LANGUAGE_ID == 'ua' ? 'Доповнити образ' : 'Дополнить образ'?>
                                            </div>
                                            <?
                                            $params = [
                                                    'IBLOCK_TYPE' => 'aspro_max_catalog',
                                                    'IBLOCK_ID' => '21',
                                                    'AJAX_MODE' => 'N',
                                                //"AJAX_OPTION_JUMP" => "N",
                                                //"AJAX_OPTION_STYLE" => "Y",
                                                //"AJAX_OPTION_HISTORY" => "N",
                                                    'ELEMENT_SORT_FIELD' => 'RAND',
                                                    'ELEMENT_SORT_ORDER' => 'desc',
                                                    'ELEMENT_SORT_FIELD2' => 'RAND',
                                                    'ELEMENT_SORT_ORDER2' => 'asc',
                                                    'PROPERTY_CODE' => [
                                                            0 => 'HIT',
                                                            1 => 'BRAND',
                                                            2 => 'CML2_ARTICLE',
                                                            3 => 'PROP_2104',
                                                            4 => 'PODBORKI',
                                                            5 => 'PROP_2033',
                                                            6 => 'COLOR_REF2',
                                                            7 => 'PROP_305',
                                                            8 => 'PROP_352',
                                                            9 => 'PROP_317',
                                                            10 => 'PROP_357',
                                                            11 => 'PROP_2102',
                                                            12 => 'PROP_318',
                                                            13 => 'PROP_159',
                                                            14 => 'PROP_349',
                                                            15 => 'PROP_327',
                                                            16 => 'PROP_2052',
                                                            17 => 'PROP_370',
                                                            18 => 'PROP_336',
                                                            19 => 'PROP_2115',
                                                            20 => 'PROP_346',
                                                            21 => 'PROP_2120',
                                                            22 => 'PROP_2053',
                                                            23 => 'PROP_363',
                                                            24 => 'PROP_320',
                                                            25 => 'PROP_2089',
                                                            26 => 'PROP_325',
                                                            27 => 'PROP_2103',
                                                            28 => 'PROP_2085',
                                                            29 => 'PROP_300',
                                                            30 => 'PROP_322',
                                                            31 => 'PROP_362',
                                                            32 => 'PROP_365',
                                                            33 => 'PROP_359',
                                                            34 => 'PROP_284',
                                                            35 => 'PROP_364',
                                                            36 => 'PROP_356',
                                                            37 => 'PROP_343',
                                                            38 => 'PROP_2083',
                                                            39 => 'PROP_314',
                                                            40 => 'PROP_348',
                                                            41 => 'PROP_316',
                                                            42 => 'PROP_350',
                                                            43 => 'PROP_333',
                                                            44 => 'PROP_332',
                                                            45 => 'PROP_360',
                                                            46 => 'PROP_353',
                                                            47 => 'PROP_347',
                                                            48 => 'PROP_25',
                                                            49 => 'PROP_2114',
                                                            50 => 'PROP_301',
                                                            51 => 'PROP_2101',
                                                            52 => 'PROP_2067',
                                                            53 => 'PROP_323',
                                                            54 => 'PROP_324',
                                                            55 => 'PROP_355',
                                                            56 => 'PROP_304',
                                                            57 => 'PROP_358',
                                                            58 => 'PROP_319',
                                                            59 => 'PROP_344',
                                                            60 => 'PROP_328',
                                                            61 => 'PROP_338',
                                                            62 => 'PROP_2065',
                                                            63 => 'PROP_366',
                                                            64 => 'PROP_302',
                                                            65 => 'PROP_303',
                                                            66 => 'PROP_2054',
                                                            67 => 'PROP_341',
                                                            68 => 'PROP_223',
                                                            69 => 'PROP_283',
                                                            70 => 'PROP_354',
                                                            71 => 'PROP_313',
                                                            72 => 'PROP_2066',
                                                            73 => 'PROP_329',
                                                            74 => 'PROP_342',
                                                            75 => 'PROP_367',
                                                            76 => 'PROP_2084',
                                                            77 => 'PROP_340',
                                                            78 => 'PROP_351',
                                                            79 => 'PROP_368',
                                                            80 => 'PROP_369',
                                                            81 => 'PROP_331',
                                                            82 => 'PROP_337',
                                                            83 => 'PROP_345',
                                                            84 => 'PROP_339',
                                                            85 => 'PROP_310',
                                                            86 => 'PROP_309',
                                                            87 => 'PROP_330',
                                                            88 => 'PROP_2017',
                                                            89 => 'PROP_335',
                                                            90 => 'PROP_321',
                                                            91 => 'PROP_308',
                                                            92 => 'PROP_206',
                                                            93 => 'PROP_334',
                                                            94 => 'PROP_2100',
                                                            95 => 'PROP_311',
                                                            96 => 'PROP_2132',
                                                            97 => 'SHUM',
                                                            98 => 'PROP_361',
                                                            99 => 'PROP_326',
                                                            100 => 'PROP_315',
                                                            101 => 'PROP_2091',
                                                            102 => 'PROP_2026',
                                                            103 => 'PROP_307',
                                                            104 => 'PROP_2027',
                                                            105 => 'PROP_2098',
                                                            106 => 'PROP_2122',
                                                            107 => 'PROP_24',
                                                            108 => 'PROP_2049',
                                                            109 => 'PROP_22',
                                                            110 => 'PROP_2095',
                                                            111 => 'PROP_2044',
                                                            112 => 'PROP_162',
                                                            113 => 'PROP_2055',
                                                            114 => 'PROP_2069',
                                                            115 => 'PROP_2062',
                                                            116 => 'PROP_2061',
                                                            117 => 'CML2_LINK',
                                                            118 => 'RZMER',
                                                    ],
                                                    'PROPERTY_CODE_MOBILE' => '',
                                                    'META_KEYWORDS' => '',
                                                    'META_DESCRIPTION' => '',
                                                    'BROWSER_TITLE' => '',
                                                    'SET_LAST_MODIFIED' => 'Y',
                                                    'INCLUDE_SUBSECTIONS' => 'Y',
                                                    'BASKET_URL' => '/basket/',
                                                    'ACTION_VARIABLE' => 'action',
                                                    'PRODUCT_ID_VARIABLE' => 'id',
                                                    'SECTION_ID_VARIABLE' => 'SECTION_ID',
                                                    'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                                                    'PRODUCT_PROPS_VARIABLE' => 'prop',
                                                    'FILTER_NAME' => 'MAX_SMART_FILTER',
                                                    'CACHE_TYPE' => 'N',
                                                    'CACHE_TIME' => '3600000',
                                                    'CACHE_FILTER' => 'Y',
                                                    'CACHE_GROUPS' => 'Y',
                                                    'SET_TITLE' => 'N',
                                                    'MESSAGE_404' => '',
                                                    'SET_STATUS_404' => 'Y',
                                                    'SHOW_404' => 'Y',
                                                    'FILE_404' => '',
                                                    'DISPLAY_COMPARE' => 'Y',
                                                    'PAGE_ELEMENT_COUNT' => '6',
                                                    'LINE_ELEMENT_COUNT' => '6',
                                                    'PRICE_CODE' => [0 => 'BASE',1=>'DISCOUNT',2=>'OPT'],
                                                    'USE_PRICE_COUNT' => 'N',
                                                    'SHOW_PRICE_COUNT' => '1',
                                                    'PRICE_VAT_INCLUDE' => 'Y',
                                                    'USE_PRODUCT_QUANTITY' => 'Y',
                                                    'ADD_PROPERTIES_TO_BASKET' => 'N',
                                                    'PARTIAL_PRODUCT_PROPERTIES' => 'Y',
                                                    'PRODUCT_PROPERTIES' => '',
                                                    'DISPLAY_TOP_PAGER' => 'N',
                                                    'DISPLAY_BOTTOM_PAGER' => 'N',
                                                    'PAGER_TITLE' => 'Товары',
                                                    'PAGER_SHOW_ALWAYS' => 'N',
                                                    'PAGER_TEMPLATE' => 'main',
                                                    'PAGER_DESC_NUMBERING' => 'N',
                                                    'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
                                                    'PAGER_SHOW_ALL' => 'N',
                                                    'PAGER_BASE_LINK_ENABLE' => 'N',
                                                    'PAGER_BASE_LINK' => null,
                                                    'PAGER_PARAMS_NAME' => null,
                                                    'LAZY_LOAD' => 'N',
                                                    'MESS_BTN_LAZY_LOAD' => null,
                                                    'LOAD_ON_SCROLL' => 'N',
                                                    'OFFERS_CART_PROPERTIES' => '',
                                                    'OFFERS_FIELD_CODE' => [0 => 'NAME',
                                                            1 => 'CML2_LINK',
                                                            2 => 'DETAIL_PAGE_URL',
                                                            3 => '',],
                                                    'OFFERS_PROPERTY_CODE' => [0 => 'ARTICLE',
                                                            1 => 'SPORT',
                                                            2 => 'SIZES2',
                                                            3 => 'MORE_PHOTO',
                                                            4 => 'VOLUME',
                                                            5 => 'SIZES',
                                                            6 => 'SIZES5',
                                                            7 => 'SIZES4',
                                                            8 => 'SIZES3',
                                                            9 => 'COLOR_REF',
                                                            10 => 'RAZMER',],
                                                    'OFFERS_SORT_FIELD' => 'ID',
                                                    'OFFERS_SORT_ORDER' => 'desc',
                                                    'OFFERS_SORT_FIELD2' => 'sort',
                                                    'OFFERS_SORT_ORDER2' => 'asc',
                                                    'OFFERS_LIMIT' => '10',
                                                    'SECTION_ID' => '',
                                                    'SECTION_CODE' => '',
                                                    'SECTION_URL' => '/catalog/#SECTION_CODE_PATH#/',
                                                    'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
                                                    'USE_MAIN_ELEMENT_SECTION' => 'Y',
                                                    'CONVERT_CURRENCY' => 'Y',
                                                    'CURRENCY_ID' => 'UAH',
                                                    'HIDE_NOT_AVAILABLE' => 'N',
                                                    'HIDE_NOT_AVAILABLE_OFFERS' => 'N',
                                                    'LABEL_PROP' => '',
                                                    'LABEL_PROP_MOBILE' => null,
                                                    'LABEL_PROP_POSITION' => null,
                                                    'ADD_PICT_PROP' => 'MORE_PHOTO',
                                                    'PRODUCT_DISPLAY_MODE' => 'Y',
                                                    'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',
                                                    'PRODUCT_ROW_VARIANTS' => '[{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false}]',
                                                    'ENLARGE_PRODUCT' => 'STRICT',
                                                    'ENLARGE_PROP' => '',
                                                    'SHOW_SLIDER' => 'Y',
                                                    'SLIDER_INTERVAL' => '3000',
                                                    'SLIDER_PROGRESS' => 'N',
                                                    'OFFER_ADD_PICT_PROP' => 'MORE_PHOTO',
                                                    'OFFER_TREE_PROPS' => [0 => 'COLOR_REF',
                                                            1 => 'RAZMER',],
                                                    'PRODUCT_SUBSCRIPTION' => 'Y',
                                                    'SHOW_DISCOUNT_PERCENT' => 'Y',
                                                    'DISCOUNT_PERCENT_POSITION' => null,
                                                    'SHOW_OLD_PRICE' => 'Y',
                                                    'SHOW_MAX_QUANTITY' => 'N',
                                                    'MESS_SHOW_MAX_QUANTITY' => '',
                                                    'RELATIVE_QUANTITY_FACTOR' => '',
                                                    'MESS_RELATIVE_QUANTITY_MANY' => '',
                                                    'MESS_RELATIVE_QUANTITY_FEW' => '',
                                                    'MESS_BTN_BUY' => 'Купить',
                                                    'MESS_BTN_ADD_TO_BASKET' => 'В корзину',
                                                    'MESS_BTN_SUBSCRIBE' => 'Подписаться',
                                                    'MESS_BTN_DETAIL' => 'Подробнее',
                                                    'MESS_NOT_AVAILABLE' => 'Нет в наличии',
                                                    'MESS_BTN_COMPARE' => 'Сравнение',
                                                    'USE_ENHANCED_ECOMMERCE' => 'N',
                                                    'DATA_LAYER_NAME' => '',
                                                    'BRAND_PROPERTY' => '',
                                                    'TEMPLATE_THEME' => 'blue',
                                                    'ADD_SECTIONS_CHAIN' => 'N',
                                                    'ADD_TO_BASKET_ACTION' => 'ADD',
                                                    'SHOW_CLOSE_POPUP' => 'N',
                                                    'COMPARE_PATH' => '',
                                                    'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
                                                    'USE_COMPARE_LIST' => 'Y',
                                                    'BACKGROUND_IMAGE' => '-',
                                                    'COMPATIBLE_MODE' => 'Y',
                                                    'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
                                                    'WRAP_CLASS' => 'main-googs-list',
                                                    'BLOCK_CLASS' => 'main-googs-item-cont',
                                            ];
                                            global $MAX_SMART_FILTER;
                                            $MAX_SMART_FILTER = ['>CATALOG_QUANTITY' => 0,'ID'=>$ids];
                                            $params['MAIN_CLASS']='order-dop-goods-list';
                                            $params['DOP_CLASS']='order-dop-goods';
                                            //$GLOBALS['MAX_SMART_FILTER'] = ['>CATALOG_QUANTITY' => 0];
                                            //$MAX_SMART_FILTER = ['ID' => ['26737']];


                                            $APPLICATION->IncludeComponent(
                                                    "bitrix:catalog.section",
                                                    'obraz',
                                                    $params,
                                                    false
                                            );
                                            ?>
                                            <?/*
                                        <div class="order-dop-goods-list">
                                            <div class="order-dop-goods">
                                                <div class="catalog-item">
                                                    <div class="catalog-item-top">
                                                        <div class="catalog-item-img">
                                                            <a href="#">
                                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-favorite">
                                                            <a href="#">
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-more-info">
                                                            <div class="catalog-item-btn-buy">
                                                                <a href="#">
                                                                    Додати до кошика
                                                                </a>
                                                            </div>
                                                            <div class="catalog-item-size-list">
                                                                <label>
                                                                    <input type="radio" name="radio1">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio1">
                                                                    <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio1">
                                                                    <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio1">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="catalog-item-info">
                                                        <a href="#" class="catalog-item-name">
                                                            Жіночий лонгслів Stimma Саймін Теракотовий
                                                        </a>
                                                        <div class="catalog-item-details">
                                                            <div class="catalog-item-price-block">
                                                                <div class="catalog-item-price">
                                                                    799 ₴
                                                                </div>
                                                            </div>
                                                            <div class="catalog-item-color-block">
                                                                <a href="#" style="background:#CB594F ;">
                                                                </a>
                                                                <a href="#" style="background:#8B5231 ;">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-dop-goods">
                                                <div class="catalog-item">
                                                    <div class="catalog-item-top">
                                                        <div class="catalog-item-img">
                                                            <a href="#">
                                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-favorite">
                                                            <a href="#">
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-more-info">
                                                            <div class="catalog-item-btn-buy">
                                                                <a href="#">
                                                                    Додати до кошика
                                                                </a>
                                                            </div>
                                                            <div class="catalog-item-size-list">
                                                                <label>
                                                                    <input type="radio" name="radio2">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio2">
                                                                    <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio2">
                                                                    <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio2">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="catalog-item-info">
                                                        <a href="#" class="catalog-item-name">
                                                            Жіноча куртка Stimma Анір
                                                        </a>
                                                        <div class="catalog-item-details">
                                                            <div class="catalog-item-price-block">
                                                                <div class="catalog-item-price">
                                                                    3 699 ₴
                                                                </div>
                                                            </div>
                                                            <div class="catalog-item-color-block">
                                                                <a href="#" style="background:#CB594F ;">
                                                                </a>
                                                                <a href="#" style="background:#8B5231 ;">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-dop-goods">
                                                <div class="catalog-item">
                                                    <div class="catalog-item-top">
                                                        <div class="catalog-item-img">
                                                            <a href="#">
                                                                <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-favorite">
                                                            <a href="#">
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <div class="catalog-item-more-info">
                                                            <div class="catalog-item-btn-buy">
                                                                <a href="#">
                                                                    Додати до кошика
                                                                </a>
                                                            </div>
                                                            <div class="catalog-item-size-list">
                                                                <label>
                                                                    <input type="radio" name="radio3">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio3">
                                                                    <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio3">
                                                                    <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="radio3">
                                                                    <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="catalog-item-info">
                                                        <a href="#" class="catalog-item-name">
                                                            Жіноча сукня Stimma Памо коричневий
                                                        </a>
                                                        <div class="catalog-item-details">
                                                            <div class="catalog-item-price-block">
                                                                <div class="catalog-item-price">
                                                                    1 999 ₴
                                                                </div>
                                                            </div>
                                                            <div class="catalog-item-color-block">
                                                                <a href="#" style="background:#CB594F ;">
                                                                </a>
                                                                <a href="#" style="background:#8B5231 ;">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        */?>
                                        </div>
                                        <div class="modal-basket-more-top">
                                            <div class="modal-basket-more-title">
                                                <?=LANGUAGE_ID == 'ua' ? 'Доповнити образ' : 'Дополнить образ'?>
                                            </div>
                                            <div class="modal-basket-more-controls">

                                            </div>
                                        </div>
                                        <div class="modal-basket-more-list">
                                            <?
                                            global $APPLICATION;
                                            {
                                                //while (ob_get_level() > 0)
                                                //    ob_end_flush(); // Или ob_end_clean / ob_end_flush()





                                                $params = [
                                                        'IBLOCK_TYPE' => 'aspro_max_catalog',
                                                        'IBLOCK_ID' => '21',
                                                        'AJAX_MODE' => 'N',
                                                    //"AJAX_OPTION_JUMP" => "N",
                                                    //"AJAX_OPTION_STYLE" => "Y",
                                                    //"AJAX_OPTION_HISTORY" => "N",
                                                        'ELEMENT_SORT_FIELD' => 'RAND',
                                                        'ELEMENT_SORT_ORDER' => 'desc',
                                                        'ELEMENT_SORT_FIELD2' => 'RAND',
                                                        'ELEMENT_SORT_ORDER2' => 'asc',
                                                        'PROPERTY_CODE' => [
                                                                0 => 'HIT',
                                                                1 => 'BRAND',
                                                                2 => 'CML2_ARTICLE',
                                                                3 => 'PROP_2104',
                                                                4 => 'PODBORKI',
                                                                5 => 'PROP_2033',
                                                                6 => 'COLOR_REF2',
                                                                7 => 'PROP_305',
                                                                8 => 'PROP_352',
                                                                9 => 'PROP_317',
                                                                10 => 'PROP_357',
                                                                11 => 'PROP_2102',
                                                                12 => 'PROP_318',
                                                                13 => 'PROP_159',
                                                                14 => 'PROP_349',
                                                                15 => 'PROP_327',
                                                                16 => 'PROP_2052',
                                                                17 => 'PROP_370',
                                                                18 => 'PROP_336',
                                                                19 => 'PROP_2115',
                                                                20 => 'PROP_346',
                                                                21 => 'PROP_2120',
                                                                22 => 'PROP_2053',
                                                                23 => 'PROP_363',
                                                                24 => 'PROP_320',
                                                                25 => 'PROP_2089',
                                                                26 => 'PROP_325',
                                                                27 => 'PROP_2103',
                                                                28 => 'PROP_2085',
                                                                29 => 'PROP_300',
                                                                30 => 'PROP_322',
                                                                31 => 'PROP_362',
                                                                32 => 'PROP_365',
                                                                33 => 'PROP_359',
                                                                34 => 'PROP_284',
                                                                35 => 'PROP_364',
                                                                36 => 'PROP_356',
                                                                37 => 'PROP_343',
                                                                38 => 'PROP_2083',
                                                                39 => 'PROP_314',
                                                                40 => 'PROP_348',
                                                                41 => 'PROP_316',
                                                                42 => 'PROP_350',
                                                                43 => 'PROP_333',
                                                                44 => 'PROP_332',
                                                                45 => 'PROP_360',
                                                                46 => 'PROP_353',
                                                                47 => 'PROP_347',
                                                                48 => 'PROP_25',
                                                                49 => 'PROP_2114',
                                                                50 => 'PROP_301',
                                                                51 => 'PROP_2101',
                                                                52 => 'PROP_2067',
                                                                53 => 'PROP_323',
                                                                54 => 'PROP_324',
                                                                55 => 'PROP_355',
                                                                56 => 'PROP_304',
                                                                57 => 'PROP_358',
                                                                58 => 'PROP_319',
                                                                59 => 'PROP_344',
                                                                60 => 'PROP_328',
                                                                61 => 'PROP_338',
                                                                62 => 'PROP_2065',
                                                                63 => 'PROP_366',
                                                                64 => 'PROP_302',
                                                                65 => 'PROP_303',
                                                                66 => 'PROP_2054',
                                                                67 => 'PROP_341',
                                                                68 => 'PROP_223',
                                                                69 => 'PROP_283',
                                                                70 => 'PROP_354',
                                                                71 => 'PROP_313',
                                                                72 => 'PROP_2066',
                                                                73 => 'PROP_329',
                                                                74 => 'PROP_342',
                                                                75 => 'PROP_367',
                                                                76 => 'PROP_2084',
                                                                77 => 'PROP_340',
                                                                78 => 'PROP_351',
                                                                79 => 'PROP_368',
                                                                80 => 'PROP_369',
                                                                81 => 'PROP_331',
                                                                82 => 'PROP_337',
                                                                83 => 'PROP_345',
                                                                84 => 'PROP_339',
                                                                85 => 'PROP_310',
                                                                86 => 'PROP_309',
                                                                87 => 'PROP_330',
                                                                88 => 'PROP_2017',
                                                                89 => 'PROP_335',
                                                                90 => 'PROP_321',
                                                                91 => 'PROP_308',
                                                                92 => 'PROP_206',
                                                                93 => 'PROP_334',
                                                                94 => 'PROP_2100',
                                                                95 => 'PROP_311',
                                                                96 => 'PROP_2132',
                                                                97 => 'SHUM',
                                                                98 => 'PROP_361',
                                                                99 => 'PROP_326',
                                                                100 => 'PROP_315',
                                                                101 => 'PROP_2091',
                                                                102 => 'PROP_2026',
                                                                103 => 'PROP_307',
                                                                104 => 'PROP_2027',
                                                                105 => 'PROP_2098',
                                                                106 => 'PROP_2122',
                                                                107 => 'PROP_24',
                                                                108 => 'PROP_2049',
                                                                109 => 'PROP_22',
                                                                110 => 'PROP_2095',
                                                                111 => 'PROP_2044',
                                                                112 => 'PROP_162',
                                                                113 => 'PROP_2055',
                                                                114 => 'PROP_2069',
                                                                115 => 'PROP_2062',
                                                                116 => 'PROP_2061',
                                                                117 => 'CML2_LINK',
                                                                118 => 'RZMER',
                                                        ],
                                                        'PROPERTY_CODE_MOBILE' => '',
                                                        'META_KEYWORDS' => '',
                                                        'META_DESCRIPTION' => '',
                                                        'BROWSER_TITLE' => '',
                                                        'SET_LAST_MODIFIED' => 'Y',
                                                        'INCLUDE_SUBSECTIONS' => 'Y',
                                                        'BASKET_URL' => '/basket/',
                                                        'ACTION_VARIABLE' => 'action',
                                                        'PRODUCT_ID_VARIABLE' => 'id',
                                                        'SECTION_ID_VARIABLE' => 'SECTION_ID',
                                                        'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                                                        'PRODUCT_PROPS_VARIABLE' => 'prop',
                                                        'FILTER_NAME' => 'MAX_SMART_FILTER',
                                                        'CACHE_TYPE' => 'N',
                                                        'CACHE_TIME' => '3600000',
                                                        'CACHE_FILTER' => 'Y',
                                                        'CACHE_GROUPS' => 'Y',
                                                        'SET_TITLE' => 'N',
                                                        'MESSAGE_404' => '',
                                                        'SET_STATUS_404' => 'Y',
                                                        'SHOW_404' => 'Y',
                                                        'FILE_404' => '',
                                                        'DISPLAY_COMPARE' => 'Y',
                                                        'PAGE_ELEMENT_COUNT' => '6',
                                                        'LINE_ELEMENT_COUNT' => '6',
                                                        'PRICE_CODE' => [0 => 'BASE',1=>'DISCOUNT',2=>'OPT'],
                                                        'USE_PRICE_COUNT' => 'N',
                                                        'SHOW_PRICE_COUNT' => '1',
                                                        'PRICE_VAT_INCLUDE' => 'Y',
                                                        'USE_PRODUCT_QUANTITY' => 'Y',
                                                        'ADD_PROPERTIES_TO_BASKET' => 'N',
                                                        'PARTIAL_PRODUCT_PROPERTIES' => 'Y',
                                                        'PRODUCT_PROPERTIES' => '',
                                                        'DISPLAY_TOP_PAGER' => 'N',
                                                        'DISPLAY_BOTTOM_PAGER' => 'N',
                                                        'PAGER_TITLE' => 'Товары',
                                                        'PAGER_SHOW_ALWAYS' => 'N',
                                                        'PAGER_TEMPLATE' => 'main',
                                                        'PAGER_DESC_NUMBERING' => 'N',
                                                        'PAGER_DESC_NUMBERING_CACHE_TIME' => '36000',
                                                        'PAGER_SHOW_ALL' => 'N',
                                                        'PAGER_BASE_LINK_ENABLE' => 'N',
                                                        'PAGER_BASE_LINK' => null,
                                                        'PAGER_PARAMS_NAME' => null,
                                                        'LAZY_LOAD' => 'N',
                                                        'MESS_BTN_LAZY_LOAD' => null,
                                                        'LOAD_ON_SCROLL' => 'N',
                                                        'OFFERS_CART_PROPERTIES' => '',
                                                        'OFFERS_FIELD_CODE' => [0 => 'NAME',
                                                                1 => 'CML2_LINK',
                                                                2 => 'DETAIL_PAGE_URL',
                                                                3 => '',],
                                                        'OFFERS_PROPERTY_CODE' => [0 => 'ARTICLE',
                                                                1 => 'SPORT',
                                                                2 => 'SIZES2',
                                                                3 => 'MORE_PHOTO',
                                                                4 => 'VOLUME',
                                                                5 => 'SIZES',
                                                                6 => 'SIZES5',
                                                                7 => 'SIZES4',
                                                                8 => 'SIZES3',
                                                                9 => 'COLOR_REF',
                                                                10 => 'RAZMER',],
                                                        'OFFERS_SORT_FIELD' => 'ID',
                                                        'OFFERS_SORT_ORDER' => 'desc',
                                                        'OFFERS_SORT_FIELD2' => 'sort',
                                                        'OFFERS_SORT_ORDER2' => 'asc',
                                                        'OFFERS_LIMIT' => '10',
                                                        'SECTION_ID' => '',
                                                        'SECTION_CODE' => '',
                                                        'SECTION_URL' => '/catalog/#SECTION_CODE_PATH#/',
                                                        'DETAIL_URL' => '/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
                                                        'USE_MAIN_ELEMENT_SECTION' => 'Y',
                                                        'CONVERT_CURRENCY' => 'Y',
                                                        'CURRENCY_ID' => 'UAH',
                                                        'HIDE_NOT_AVAILABLE' => 'N',
                                                        'HIDE_NOT_AVAILABLE_OFFERS' => 'N',
                                                        'LABEL_PROP' => '',
                                                        'LABEL_PROP_MOBILE' => null,
                                                        'LABEL_PROP_POSITION' => null,
                                                        'ADD_PICT_PROP' => 'MORE_PHOTO',
                                                        'PRODUCT_DISPLAY_MODE' => 'Y',
                                                        'PRODUCT_BLOCKS_ORDER' => 'price,props,sku,quantityLimit,quantity,buttons,compare',
                                                        'PRODUCT_ROW_VARIANTS' => '[{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false},{\'VARIANT\':\'3\',\'BIG_DATA\':false}]',
                                                        'ENLARGE_PRODUCT' => 'STRICT',
                                                        'ENLARGE_PROP' => '',
                                                        'SHOW_SLIDER' => 'Y',
                                                        'SLIDER_INTERVAL' => '3000',
                                                        'SLIDER_PROGRESS' => 'N',
                                                        'OFFER_ADD_PICT_PROP' => 'MORE_PHOTO',
                                                        'OFFER_TREE_PROPS' => [0 => 'COLOR_REF',
                                                                1 => 'RAZMER',],
                                                        'PRODUCT_SUBSCRIPTION' => 'Y',
                                                        'SHOW_DISCOUNT_PERCENT' => 'Y',
                                                        'DISCOUNT_PERCENT_POSITION' => null,
                                                        'SHOW_OLD_PRICE' => 'Y',
                                                        'SHOW_MAX_QUANTITY' => 'N',
                                                        'MESS_SHOW_MAX_QUANTITY' => '',
                                                        'RELATIVE_QUANTITY_FACTOR' => '',
                                                        'MESS_RELATIVE_QUANTITY_MANY' => '',
                                                        'MESS_RELATIVE_QUANTITY_FEW' => '',
                                                        'MESS_BTN_BUY' => 'Купить',
                                                        'MESS_BTN_ADD_TO_BASKET' => 'В корзину',
                                                        'MESS_BTN_SUBSCRIBE' => 'Подписаться',
                                                        'MESS_BTN_DETAIL' => 'Подробнее',
                                                        'MESS_NOT_AVAILABLE' => 'Нет в наличии',
                                                        'MESS_BTN_COMPARE' => 'Сравнение',
                                                        'USE_ENHANCED_ECOMMERCE' => 'N',
                                                        'DATA_LAYER_NAME' => '',
                                                        'BRAND_PROPERTY' => '',
                                                        'TEMPLATE_THEME' => 'blue',
                                                        'ADD_SECTIONS_CHAIN' => 'N',
                                                        'ADD_TO_BASKET_ACTION' => 'ADD',
                                                        'SHOW_CLOSE_POPUP' => 'N',
                                                        'COMPARE_PATH' => '',
                                                        'COMPARE_NAME' => 'CATALOG_COMPARE_LIST',
                                                        'USE_COMPARE_LIST' => 'Y',
                                                        'BACKGROUND_IMAGE' => '-',
                                                        'COMPATIBLE_MODE' => 'Y',
                                                        'DISABLE_INIT_JS_IN_COMPONENT' => 'N',
                                                        'WRAP_CLASS' => 'main-googs-list',
                                                        'BLOCK_CLASS' => 'main-googs-item-cont',
                                                ];
                                                global $MAX_SMART_FILTER;
                                                $MAX_SMART_FILTER = ['>CATALOG_QUANTITY' => 0,'ID'=>$ids];
                                                //$GLOBALS['MAX_SMART_FILTER'] = ['>CATALOG_QUANTITY' => 0];
                                                //$MAX_SMART_FILTER = ['ID' => ['26737']];


                                                $APPLICATION->IncludeComponent(
                                                        "bitrix:catalog.section",
                                                        'main',
                                                        $params,
                                                        false
                                                );
                                            }

                                            ?>

                                        </div>
                                        <?
                                    }
                                }
                            }
                            ?>
                            <?/*
                        <div class="order-dop-goods-block">
                            <div class="order-dop-goods-title">
                                Доповнити образ
                            </div>
                            <div class="order-dop-goods-list">
                                <div class="order-dop-goods">
                                    <div class="catalog-item">
                                        <div class="catalog-item-top">
                                            <div class="catalog-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma_new/images/imgnew/catimg1.png">
                                                </a>
                                            </div>
                                            <div class="catalog-item-favorite">
                                                <a href="#">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="catalog-item-more-info">
                                                <div class="catalog-item-btn-buy">
                                                    <a href="#">
                                                        Додати до кошика
                                                    </a>
                                                </div>
                                                <div class="catalog-item-size-list">
                                                    <label>
                                                        <input type="radio" name="radio1">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio1">
                                                        <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio1">
                                                        <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio1">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="catalog-item-info">
                                            <a href="#" class="catalog-item-name">
                                                Жіночий лонгслів Stimma Саймін Теракотовий
                                            </a>
                                            <div class="catalog-item-details">
                                                <div class="catalog-item-price-block">
                                                    <div class="catalog-item-price">
                                                        799 ₴
                                                    </div>
                                                </div>
                                                <div class="catalog-item-color-block">
                                                    <a href="#" style="background:#CB594F ;">
                                                    </a>
                                                    <a href="#" style="background:#8B5231 ;">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-dop-goods">
                                    <div class="catalog-item">
                                        <div class="catalog-item-top">
                                            <div class="catalog-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma_new/images/imgnew/catimg2.png">
                                                </a>
                                            </div>
                                            <div class="catalog-item-favorite">
                                                <a href="#">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="catalog-item-more-info">
                                                <div class="catalog-item-btn-buy">
                                                    <a href="#">
                                                        Додати до кошика
                                                    </a>
                                                </div>
                                                <div class="catalog-item-size-list">
                                                    <label>
                                                        <input type="radio" name="radio2">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio2">
                                                        <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio2">
                                                        <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio2">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="catalog-item-info">
                                            <a href="#" class="catalog-item-name">
                                                Жіноча куртка Stimma Анір
                                            </a>
                                            <div class="catalog-item-details">
                                                <div class="catalog-item-price-block">
                                                    <div class="catalog-item-price">
                                                        3 699 ₴
                                                    </div>
                                                </div>
                                                <div class="catalog-item-color-block">
                                                    <a href="#" style="background:#CB594F ;">
                                                    </a>
                                                    <a href="#" style="background:#8B5231 ;">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-dop-goods">
                                    <div class="catalog-item">
                                        <div class="catalog-item-top">
                                            <div class="catalog-item-img">
                                                <a href="#">
                                                    <img src="/bitrix/templates/stimma_new/images/imgnew/catimg3.png">
                                                </a>
                                            </div>
                                            <div class="catalog-item-favorite">
                                                <a href="#">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14 23C13.8583 23 13.7168 22.9653 13.5899 22.8957C13.4521 22.8201 10.1779 21.0146 6.85673 18.294C4.88831 16.6816 3.31704 15.0824 2.18665 13.5408C0.723873 11.5459 -0.0117258 9.62715 0.000141317 7.83764C0.0140319 5.75534 0.799287 3.79707 2.21142 2.32351C3.6474 0.825129 5.56376 0 7.60758 0C10.2269 0 12.6218 1.39357 14 3.60115C15.3783 1.39362 17.7731 0 20.3925 0C22.3234 0 24.1656 0.744518 25.5801 2.09643C27.1323 3.58001 28.0143 5.67623 27.9998 7.84751C27.9879 9.6339 27.2385 11.5498 25.7725 13.5419C24.6386 15.0827 23.0695 16.6812 21.1088 18.2931C17.7998 21.0134 14.5492 22.8189 14.4124 22.8945C14.2849 22.9648 14.1424 23 14 23Z" fill="currentcolor"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="catalog-item-more-info">
                                                <div class="catalog-item-btn-buy">
                                                    <a href="#">
                                                        Додати до кошика
                                                    </a>
                                                </div>
                                                <div class="catalog-item-size-list">
                                                    <label>
                                                        <input type="radio" name="radio3">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio3">
                                                        <span class="catalog-item-size">
		                                                        S
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio3">
                                                        <span class="catalog-item-size">
		                                                        M
		                                                    </span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="radio3">
                                                        <span class="catalog-item-size">
		                                                        XS
		                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="catalog-item-info">
                                            <a href="#" class="catalog-item-name">
                                                Жіноча сукня Stimma Памо коричневий
                                            </a>
                                            <div class="catalog-item-details">
                                                <div class="catalog-item-price-block">
                                                    <div class="catalog-item-price">
                                                        1 999 ₴
                                                    </div>
                                                </div>
                                                <div class="catalog-item-color-block">
                                                    <a href="#" style="background:#CB594F ;">
                                                    </a>
                                                    <a href="#" style="background:#8B5231 ;">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        */?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?
    }
    ?>




    <?
    if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
    {
        $json['amount'] = FormatCurrency($alLSum,'UAH');
        $json['all_summ'] = $alLSum;
        $APPLICATION->RestartBuffer();
        echo json_encode($json);
        die();
    }
    ?>

	<div id="bx-soa-saved-files" style="display:none"></div>
	<div id="bx-soa-soc-auth-services" style="display:none">
		<?
		$arServices = false;
		$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = Main\Config\Option::get('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N';
		$arResult['FOR_INTRANET'] = false;

		if (Main\ModuleManager::isModuleInstalled('intranet') || Main\ModuleManager::isModuleInstalled('rest'))
			$arResult['FOR_INTRANET'] = true;

		if (Main\Loader::includeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] === 'Y')
		{
			$oAuthManager = new CSocServAuthManager();
			$arServices = $oAuthManager->GetActiveAuthServices(array(
				'BACKURL' => $this->arParams['~CURRENT_PAGE'],
				'FOR_INTRANET' => $arResult['FOR_INTRANET'],
			));

			if (!empty($arServices))
			{
				$APPLICATION->IncludeComponent(
					'bitrix:socserv.auth.form',
					'flat',
					array(
						'AUTH_SERVICES' => $arServices,
						'AUTH_URL' => $arParams['~CURRENT_PAGE'],
						'POST' => $arResult['POST'],
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
			}
		}
		?>
	</div>

	<div style="display: none">
		<?
		// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.steps',
			'.default',
			array(),
			false
		);
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.search',
			'.default',
			array(),
			false
		);
		?>
	</div>
	<?
	$signer = new Main\Security\Sign\Signer;
	$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
	$messages = Loc::loadLanguageFile(__FILE__);

    $new = [];
    foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $index => $JS_DATUM)
    {
        $new[$JS_DATUM['SORT']] = $JS_DATUM;
    }
    ksort($new);
    $new = array_values($new);
    $arResult['JS_DATA']['ORDER_PROP']['properties'] = $new;
	?>
	<script>
        var dost = <?=CUtil::PhpToJSObject($dost)?>;
		BX.message(<?=CUtil::PhpToJSObject($messages)?>);
		/*
        BX.Sale.OrderAjaxComponent.init({
			result: <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>,
			locations: <?=CUtil::PhpToJSObject($arResult['LOCATIONS'])?>,
			params: <?=CUtil::PhpToJSObject($arParams)?>,
			signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
			siteID: '<?=CUtil::JSEscape($component->getSiteId())?>',
			ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
			propertyValidation: true,
			showWarnings: true,
			pickUpMap: {
				defaultMapPosition: {
					lat: 55.76,
					lon: 37.64,
					zoom: 7
				},
				secureGeoLocation: false,
				geoLocationMaxTime: 5000,
				minToShowNearestBlock: 3,
				nearestPickUpsToShow: 3
			},
			propertyMap: {
				defaultMapPosition: {
					lat: 55.76,
					lon: 37.64,
					zoom: 7
				}
			},
			orderBlockId: 'bx-soa-order',
			authBlockId: 'bx-soa-auth',
			basketBlockId: 'bx-soa-basket',
			regionBlockId: 'bx-soa-region',
			paySystemBlockId: 'bx-soa-paysystem',
			deliveryBlockId: 'bx-soa-delivery',
			pickUpBlockId: 'bx-soa-pickup',
			propsBlockId: 'bx-soa-properties',
			totalBlockId: 'bx-soa-total'
		});
        */
	</script>
	<script>
		<?
		// spike: for children of cities we place this prompt
		$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
		?>
		BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
			'source' => $component->getPath().'/get.php',
			'cityTypeId' => intval($city['ID']),
			'messages' => array(
				'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
				'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
				'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
						'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
						'#ANCHOR_END#' => '</a>'
					)).'</div>'
			)
		))?>);
	</script>
	<?
	if ($arParams['SHOW_PICKUP_MAP'] === 'Y' || $arParams['SHOW_MAP_IN_PROPS'] === 'Y')
	{
		if ($arParams['PICKUP_MAP_TYPE'] === 'yandex')
		{
			$this->addExternalJs($templateFolder.'/scripts/yandex_maps.js');
			$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'yandex_map_api_key', ''));
			?>
			<script src="<?=$scheme?>://api-maps.yandex.ru/2.1.50/?apikey=<?=$apiKey?>&load=package.full&lang=<?=$locale?>"></script>
			<script>
				(function bx_ymaps_waiter(){
					if (typeof ymaps !== 'undefined' && BX.Sale && BX.Sale.OrderAjaxComponent)
						ymaps.ready(BX.proxy(BX.Sale.OrderAjaxComponent.initMaps, BX.Sale.OrderAjaxComponent));
					else
						setTimeout(bx_ymaps_waiter, 100);
				})();
			</script>
			<?
		}

		if ($arParams['PICKUP_MAP_TYPE'] === 'google')
		{
			$this->addExternalJs($templateFolder.'/scripts/google_maps.js');
			$apiKey = htmlspecialcharsbx(Main\Config\Option::get('fileman', 'google_map_api_key', ''));
			?>
			<script async defer
				src="<?=$scheme?>://maps.googleapis.com/maps/api/js?key=<?=$apiKey?>&callback=bx_gmaps_waiter">
			</script>
			<script>
				function bx_gmaps_waiter()
				{
                    /*
					if (BX.Sale && BX.Sale.OrderAjaxComponent)
						BX.Sale.OrderAjaxComponent.initMaps();
					else
						setTimeout(bx_gmaps_waiter, 100);
                    */
				}
			</script>
			<?
		}
	}

	if ($arParams['USE_YM_GOALS'] === 'Y')
	{
		?>
		<script>
			(function bx_counter_waiter(i){
				i = i || 0;
				if (i > 50)
					return;

				if (typeof window['yaCounter<?=$arParams['YM_GOALS_COUNTER']?>'] !== 'undefined')
					BX.Sale.OrderAjaxComponent.reachGoal('initialization');
				else
					setTimeout(function(){bx_counter_waiter(++i)}, 100);
			})();
		</script>
		<?
	}
}

?>




