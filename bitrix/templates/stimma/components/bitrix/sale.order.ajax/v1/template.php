<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Sale\DiscountCouponsManager;

if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
{
    $json=[];
}


if(isset($_GET['remove']) && intval($_GET['remove']) > 0)
{
    CSaleBasket::Delete($_GET['remove']);
    LocalRedirect($APPLICATION->GetCurPage());
    exit();
}

/*$newProp = [];
foreach ($arResult['ORDER_PROP']['RELATED'] as $index => $item)
{
    if($item['CODE'] == 'EMAIL')$newProp[2] = $item;
    if($item['CODE'] == 'PHONE')$newProp[3] = $item;
    if($item['CODE'] == 'NAME')$newProp[0] = $item;
    if($item['CODE'] == 'LASTNAME')$newProp[1] = $item;
    if($item['CODE'] == 'CITY')$newProp[4] = $item;
    if($item['CODE'] == 'ADDRESS')$newProp[5] = $item;
}
ksort($newProp);
$arResult['ORDER_PROP']['RELATED'] = $newProp;*/
//DiscountCouponsManager::delete('Your30');

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
$useCoupon = 1;
$isSert = false;
$onlySert = true;
{
    $isOrder = 1;
    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $index => $row)
    {

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
        if(!$product['QUANTITY'])
            $isOrder = 0;
        $p = CIBlockElement::GetByID($pId);
        if($p = $p-> GetNextElement())
        {
            $p = $p -> GetProperties();
            $mainIDs[] = $p['CML2_LINK']['VALUE'];
            if(LANGUAGE_ID == 'ua'){if($p['NAME_UA']['VALUE'])$arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] = $p['NAME_UA']['VALUE'];}

            if(!$product['QUANTITY'])
            {
                if(LANGUAGE_ID == 'ua')
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] .=' (Не в наявності)';
                else
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['NAME'] .=' (Нет в наличии)';
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


global $USER;

//=============================================================================================
$totalBonus = $alLSum = 0;
$basket = $arResult['JS_DATA']['GRID']['ROWS'];
foreach($basket as $index => $item) {
	$dpu = CIBlockElement::GetByID($item['PRODUCT_ID'])->GetNext();
	$dpuprop = CIBlockElement::GetList([],['ID' => $item['data'][PRODUCT_ID]],false,false,['ID', 'NAME', 'PROPERTY_PROP_BONUS', 'PROPERTY_PROP_BONUS_PRICE'])->Fetch();
	$item = $item['data'];
	if (isset($dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE])) {
		$totalBonus += $dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE] * $item['QUANTITY'];
	}
	$alLSum += $item['PRICE']*$item['QUANTITY'];
}


$bonus_part = $bonus_ok = $userId = false;
if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();



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


if($onlySert)
{
    ?><style>#bx-soa-paysystem{display:none !important;}</style><?
}
if(!isset($_GET['ORDER_ID']))
{
    ?>
    <style>
        header,.top-block-wrapper{display:none}
    </style>
    <?
}
elseif(isset($_GET['ORDER_ID']))
{
    ?>
    <style>
        footer{display:none !important;}
    </style>
    <?
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
{
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME']))
{
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME']))
{
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME']))
{
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME']))
{
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME']))
{
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME']))
{
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BACK']))
{
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FURTHER']))
{
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_EDIT']))
{
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_MORE_DETAILS']))
{
	$arParams['MESS_MORE_DETAILS'] = Loc::getMessage('MORE_DETAILS_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER']))
{
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PRICE']))
{
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERIOD']))
{
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK']))
{
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD']))
{
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE']))
{
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY']))
{
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE']))
{
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1']))
{
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2']))
{
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3']))
{
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS']))
{
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON']))
{
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_COUPON']))
{
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE']))
{
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE']))
{
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE']))
{
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST']))
{
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST']))
{
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP']))
{
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECTED_PICKUP']))
{
	$arParams['MESS_SELECTED_PICKUP'] = Loc::getMessage('SELECTED_PICKUP_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE']))
{
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC']))
{
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE']))
{
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT']))
{
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT']))
{
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']))
{
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
}

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
    <form action="" method="post" id="create_order_form">
        <input type="hidden" name="url" value="<?=$APPLICATION->GetCurPage()?>">
        <?
        //if(isset($_GET['sub']))
        {
            foreach($arResult['SQLS'] as $index => $sql)
            {
                ?><input type="hidden" name="sqls[]" value="<?=$sql?>"><?
            }
        }
        ?>
        <div class="order-page-cont">
        <div class="order-info-col">
            <div class="order-info-cont">
                <div class="order-header">
                    <a href="<?=UA?'/':'/ru/'?>">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1164.53 223" style="enable-background:new 0 0 1164.53 223;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M167.24,133.23c0,5.86-1.09,11.03-3.23,15.38c-2.12,4.29-4.98,7.96-8.53,10.93c-3.43,2.87-7.43,5.2-11.9,6.91
                                        c-4.21,1.61-8.69,2.87-13.3,3.75c-4.54,0.86-9.19,1.43-13.81,1.69c-4.51,0.27-8.86,0.4-12.94,0.4c-10.72,0-20.81-0.9-29.98-2.67
                                        c-9.13-1.77-17.34-4-24.39-6.65l-3.42-1.29v-37.79l7.83,4.35c6.58,3.64,14.21,6.55,22.69,8.62c8.54,2.09,17.82,3.15,27.58,3.15
                                        c5.73,0,10.41-0.3,13.91-0.88c4.14-0.7,6.42-1.5,7.6-2.05c1.75-0.81,2.18-1.37,2.19-1.37c0.16-0.25,0.24-0.42,0.27-0.51
                                        c-0.04-0.02-0.15-0.14-0.35-0.3c-0.73-0.6-2.14-1.5-4.73-2.42c-2.43-0.87-5.36-1.69-8.68-2.44c-3.49-0.78-7.21-1.57-11.13-2.35
                                        c-4-0.8-8.11-1.67-12.34-2.59c-4.35-0.96-8.62-2.1-12.71-3.39c-4.16-1.31-8.17-2.87-11.9-4.63c-3.94-1.86-7.47-4.11-10.48-6.68
                                        c-3.17-2.72-5.71-5.92-7.56-9.51c-1.91-3.73-2.88-8.04-2.88-12.81c0-5.44,1.01-10.27,2.99-14.35c1.95-4.03,4.63-7.51,7.96-10.35
                                        c3.21-2.74,6.95-4.98,11.12-6.67c3.93-1.6,8.13-2.86,12.48-3.74c4.25-0.86,8.61-1.46,12.95-1.78c4.27-0.32,8.38-0.48,12.21-0.48
                                        c4.23,0,8.65,0.22,13.13,0.64c4.43,0.42,8.88,1.02,13.2,1.79c4.27,0.75,8.48,1.64,12.53,2.64c4,1,7.77,2.06,11.21,3.17l3.65,1.18
                                        v36.69l-7.58-3.69c-1.82-0.89-4.33-1.94-7.45-3.11c-3.09-1.16-6.67-2.28-10.63-3.33c-3.95-1.05-8.31-1.94-12.96-2.65
                                        c-4.59-0.7-9.36-1.05-14.18-1.05c-3.91,0-7.28,0.12-10.01,0.36c-2.68,0.24-4.93,0.55-6.69,0.91c-1.95,0.4-2.99,0.79-3.52,1.03
                                        c-0.17,0.08-0.31,0.15-0.44,0.22c0.82,0.54,2.19,1.25,4.38,1.99c2.48,0.83,5.42,1.64,8.76,2.39c3.52,0.79,7.25,1.6,11.19,2.44
                                        c4.01,0.85,8.14,1.78,12.4,2.79c4.37,1.03,8.66,2.25,12.75,3.63c4.19,1.4,8.21,3.06,11.93,4.92c3.92,1.96,7.43,4.3,10.43,6.95
                                        c3.16,2.8,5.69,6.07,7.52,9.73C166.28,124.15,167.24,128.48,167.24,133.23z"></path>
                                </g>
                                <g>
                                    <polygon points="341.18,53.4 341.18,86.9 296.34,86.9 296.34,169.45 257.3,169.45 257.3,86.9 212.54,86.9 212.54,53.4      "></polygon>
                                </g>
                                <g>
                                    <rect x="394.04" y="53.4" width="39.03" height="116.05"></rect>
                                </g>
                                <g>
                                    <polygon points="672.09,53.4 672.09,169.45 633.21,169.45 633.21,111.34 602.5,169.45 568.81,169.45 538.1,111.34 538.1,169.45 
                                        499.07,169.45 499.07,53.4 546.21,53.4 585.66,127.33 625.11,53.4         "></polygon>
                                </g>
                                <g>
                                    <polygon points="911.15,53.4 911.15,169.45 872.28,169.45 872.28,111.34 841.57,169.45 807.88,169.45 777.17,111.34 
                                        777.17,169.45 738.14,169.45 738.14,53.4 785.27,53.4 824.72,127.33 864.17,53.4       "></polygon>
                                </g>
                                <g>
                                    <path d="M1058.76,53.4h-38.17l-60.73,116.05h43.77l9.9-19.97h52.28l9.91,19.97h43.76L1058.76,53.4z M1050.54,118.36h-21.55
                                        l10.82-21.72L1050.54,118.36z"></path>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="order-list-mob opened">
                    <?
                    /*if($arResult['allAmountLeft'] > 0)
                    {
                        ?>
                        <div style="text-align: center;color:#f76b6a">
                            <?=UA?'Додайте ще '.$arResult['allAmountLeft'].' грн до отримання знижки!':'Добавьте еще '.$arResult['allAmountLeft'].' грн до получения скидки!'?>
                        </div>
                        <?
                    }*/
                    /*if($arResult['actionText'])
                    {
                        ?>
                        <div style="text-align: center;color:#f76b6a">
                            <?=UA?'Не забудьте обрати в подарунок річ на вибір: футболки, базові топи, хустки, пояси, біжутерія':'Не забудьте выбрать в подарок вещь на выбор: футболки, базовые топы, хустки, пояса, бижутерия'?>
                        </div>
                        <?
                    }*/
                    ?>
                    <div class="order-list-toggler-bg">
                        <div class="order-list-toggler-cont">
                            <div class="order-list-toggler">

                                <div class="order-list-toggler-text">
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" focusable="false" aria-hidden="true" class="a8x1wuo _1fragemfc _1fragemhb _1fragemd8 _1fragemd4"><circle cx="3.5" cy="11.9" r="0.3"></circle><circle cx="10.5" cy="11.9" r="0.3"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M3.502 11.898h-.004v.005h.004v-.005Zm7 0h-.005v.005h.005v-.005ZM1.4 2.1h.865a.7.7 0 0 1 .676.516l1.818 6.668a.7.7 0 0 0 .676.516h5.218a.7.7 0 0 0 .68-.53l1.05-4.2a.7.7 0 0 0-.68-.87H3.4"></path></svg>
                                    </span>
                                    <span class="text-block">
                                        <span class="hd"><?=UA?'Показати замовлення':'Показать заказ'?></span>
                                        <span class="op"><?=UA?'Приховати замовлення':'Скрыть заказ'?></span>
                                        <span class="icon-arr">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" focusable="false" aria-hidden="true" class="a8x1wuo _1fragemfc _1fragemhb _1fragemd8 _1fragemd4"><path stroke-linecap="round" stroke-linejoin="round" d="m11.9 5.6-4.653 4.653a.35.35 0 0 1-.495 0L2.1 5.6"></path></svg>
                                        </span>
                                    </span>
                                </div>
                                <?
                                $alLSum=0;
                                foreach($basket as $index => $item)
                                {
                                    $alLSum += $item['data']['PRICE']*$item['data']['QUANTITY'];
                                }
                                ?>
                                <div class="order-list-mob-total">
                                    <?=FormatCurrency($alLSum,'UAH')?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-list-mob-bg" style="display: block;">
                        <div class="order-list">
                            <?
                            if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
                                ob_start();
                            ?>
                            <div class="order-list-cont desctop">
                                <?
                                $alLSum=0;
                                $totalBonus = 0;
                                $totalBonusPrice = [];
                                $totalSum = [];
                                foreach($basket as $index => $item)
                                {

                                    $item = $item['data'];
                                    $price = CCatalogProduct::GetOptimalPrice($item['PRODUCT_ID'])['RESULT_PRICE'];
                                    $alLSum += $item['PRICE']*$item['QUANTITY'];
                                    ?>
                                    <div class="order-list-item">
                                        <?
                                        if($item['ID'])
                                        {
                                            ?>
                                            <a href="?remove=<?=$item['ID']?>" class="order-list-item-delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                            </a>
                                            <?
                                        }
                                        ?>

                                        <div class="order-list-item-img-cont">
                                            <div class="order-list-item-counter">
                                                <?=$item['QUANTITY']?>
                                            </div>
                                            <div class="order-list-item-img">
                                                <a href="<?=$item['DPU']?>">
                                                    <img src="<?=$item['PREVIEW_PICTURE_SRC']?>">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="order-list-info">
                                            <div class="order-list-name">
                                                <a href="<?=$item['DPU']?>" style="color:black;">
                                                    <?=$item['NAME']?>
                                                </a>
                                            </div>
                                            <?/*<div class="order-list-size">34</div>*/?>
                                        </div>
                                        <div class="order-list-price-block">
                                    <?if($item['BONUS']):
                                    $totalBonusPrice[] = $price['BASE_PRICE']*$item['QUANTITY'];
                                    ?>
                                    <div class="order-list-price"><?=$price['BASE_PRICE']*$item['QUANTITY']?> <?= UA ? " стімзів" : " стимзов" ?></div>
                                <?else:?>
                                            <?
                                            if($price['BASE_PRICE'] > $item['PRICE'])
                                            {
                                                ?><div class="order-list-price-old"><?=FormatCurrency($price['BASE_PRICE']*$item['QUANTITY'],'UAH')?></div><?
                                            }
                                            ?>
                                            <div class="order-list-price"><?=FormatCurrency($item['PRICE']*$item['QUANTITY'],'UAH')?></div>
                                    <?$totalSum[] = $item['PRICE']*$item['QUANTITY'];
                                    endif;?>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                            global $USER;
                            $userId = false;
                            $btnBonus = true;
                            $svDeliveryFree = 0;
                            if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();

                            $svDeliveryTxt = UA?'За тарифом перевізника':'По тарифу перевозчика';
                            $rsUser = CUser::GetByID($userId);
                            $arUser = $rsUser->Fetch();
                            $TotalSum = array_sum($totalSum);
                            if ( $userId && $TotalSum>1500) {
                                $free_groups = [28, 29, 30];
                                //$dbUser = CUser::GetList("", "", array("ID" => (int)$userId), array('FIELDS' => array('ID', 'UF_LOYALTY_GROUP')));
                                /*$dbUser = CUser::GetList($by = "ID", $order = "ASC", ["ID" => (int)$userId], ["SELECT" => ["UF_LOYALTY_GROUP"]]);
                                $arUser = $dbUser->Fetch();*/


                                if ( in_array($arUser['UF_LOYALTY_GROUP'], $free_groups) ) {
                                    $svDeliveryTxt = UA?'Безкоштовно':'Бесплатно';
                                    $svDeliveryFree = 1;
                                }
                            }
                            $Balance = GetBalance($arUser['XML_ID']);
                            ?>
                            <?
                            if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
                                $json['desctop'] = ob_get_clean();
                            ?>
                            <div class="order-list-discount-block">
                                <div class="form_body">
                                    <div class="form-control">
                                        <input type="text" name="coupon" placeholder="Промокод">
                                    </div>
                                </div>
                                <div class="order-list-discount-btn">
                                    <a href="#" class="btn btn-default set_coupon">
                                        <?=UA?'Застосувати':'Применить'?>
                                    </a>
                                </div>
                            </div>
                            <div class="order-list-total">
                                <?/*<div class="order-list-total-item">
                                    <div class="order-list-total-key">Проміжний підсумок</div>
                                    <div class="order-list-total-value"><b>10 000 грн</b></div>
                                </div>*/
								
								/*
								$userId = false;
								$svDeliveryFree = 0;
								if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();
								$svDeliveryTxt = UA?'За тарифом перевізника':'По тарифу перевозчика';
								if ( $userId ) {
									$free_groups = [28, 29, 30];
									//$dbUser = CUser::GetList("", "", array("ID" => (int)$userId), array('FIELDS' => array('ID', 'UF_LOYALTY_GROUP')));
									$dbUser = CUser::GetList($by = "ID", $order = "ASC", ["ID" => (int)$userId], ["SELECT" => ["UF_LOYALTY_GROUP"]]);							
									$arUser = $dbUser->Fetch();
									if ( in_array($arUser['UF_LOYALTY_GROUP'], $free_groups) ) {
										$svDeliveryTxt = UA?'Безкоштовно':'Бесплатно';
										$svDeliveryFree = 1;
									}
								}								
								
                                <div class="order-list-total-item">
                                    <div class="order-list-total-key">Доставка</div>
                                    <div class="order-list-total-value"><?= $svDeliveryTxt ?></div>
                                </div>								
								
								*/
								?>
                                <div class="order-list-total-item">
                                    <div class="order-list-total-key">Доставка</div>
                                    <div class="order-list-total-value"><?= $svDeliveryTxt ?></div>
                                </div>
                                <div class="order-list-total-item total-end">
                                    <div class="order-list-total-key"><?=UA?'Всього':'Всего'?></div>
                                    <div class="order-list-total-value" data-price="<?=FormatCurrency($TotalSum,'UAH')?>"><?=FormatCurrency($TotalSum,'UAH')?></div>
                                </div>
                                <?
                                $TotalBonusPrice = array_sum($totalBonusPrice);
                                if($TotalBonusPrice > 0):
                                    ?>
                                    <div class="order-list-total-item total-end">
                                        <div class="order-list-total-key">Всього</div>
                                        <div class="order-list-total-value"><?=$TotalBonusPrice?> <?= UA ? " стімзів" : " стимзов" ?></div>
                                    </div>
                                    <?if($Balance['response']['Balance'] < $TotalBonusPrice):
                                    $btnBonus = false;
                                    ?>
                                    <div class="create_error" style="color:red;"><?= UA ? "У вас недостатньо стімзів на балансі. Усього" : "У вас недостаточно симзов на балансе. Всего" ?> <?=$Balance['response']['Balance']?></div>
                                <?endif;?>
                                <?endif;?>
                                <div class="total-bonus" style="font-size: 17px;font-weight: 500;">
                                    <?= UA ? "Кількість стімзів: ".$Balance['response']['Balance'] : "Количество симзов: ".$Balance['response']['Balance'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-info-block">
                    <div id="navigation" class="page_title_3">
                        <div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                            <div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <a class="breadcrumbs__link" href="/" title="Головна" itemprop="item">
                                    <span itemprop="name" class="breadcrumbs__item-name font_xs">Головна</span><meta itemprop="position" content="1">
                                </a>
                            </div>
                            <span class="breadcrumbs__separator">—</span>
                            <div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <a class="breadcrumbs__link" href="/catalog/zhenskaya_odezhda/" title="Каталог" itemprop="item">
                                    <span itemprop="name" class="breadcrumbs__item-name font_xs">Каталог</span><meta itemprop="position" content="2">
                                </a>
                            </div>
                            <span class="breadcrumbs__separator">—</span>
                            <span class="breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <link href="/order/" itemprop="item">
                                <span>
                                    <span itemprop="name" class="breadcrumbs__item-name font_xs"><?=UA?'Оформлення замовлення':'Оформить заказ'?>
                                    </span><meta itemprop="position" content="3">
                                </span>
                            </span>
                        </div>            
                    </div>
                    <div class="order-info-choice">
                        <div class="order-info-pay">
                            <?/*<div class="order-info-pay-title">
                                Експрес-виписка
                            </div>
                            <div class="order-info-pay-btn">
                                <a href="#">Кнопка оплати</a>
                            </div>
                            <div class="order-info-sep">
                                <div class="order-info-sep-text">
                                    або
                                </div>
                            </div>*/?>
                            <div class="order-info-form">
                                <div class="order-info-form-block">
                                    <div class="order-info-title">
                                        <?=UA?'Особисті дані':'Личные данные'?>
                                    </div>
                                    <div class="form_body">
                                        <div class="form-controls-group">
                                            <div class="form-control">
                                                <input type="text" name="fio" placeholder="">
                                                <span class="form-placeholder"><?=UA?'Прізвище':'Фамилия'?></span>
                                                <span class="error-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                            <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="error-text">
                                                    Поле обов'язкове для заповнення
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" name="name" placeholder="">
                                                <span class="form-placeholder"><?=UA?'Ім\'я':'Имя'?></span>
                                                <span class="error-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                            <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="error-text">
                                                    Поле обов'язкове для заповнення
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" name="second_name" placeholder="">
                                                <span class="form-placeholder"><?=UA?'По батькові':'Отчество'?></span>
                                                <span class="error-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                            <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                            <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="error-text">
                                                    Поле обов'язкове для заповнення
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <input type="tel" name="phone" placeholder="">
                                            <span class="form-placeholder"><?=UA?'Телефон':'Телефон'?></span>
                                            <span class="error-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                        <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <div class="error-text">
                                                Поле обов'язкове для заповнення
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <input type="text" name="email" placeholder="">
                                            <span class="form-placeholder">Email</span>
                                            <span class="error-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                        <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <div class="error-text">
                                                Поле обов'язкове для заповнення
                                            </div>
                                        </div>
                                        <div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="checkbox" checked id="news_and" name="send_news">
                                                <label for="news_and">
                                                    <?=UA?'Отримувати пропозиції':'Получать предложения'?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-info-form-block">
                                    <div class="order-info-title">
                                        Доставка
                                    </div>

                                    <div class="form_body">
                                        <div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="radio" checked id="delivery_method" name="delivery_method" value="14">
                                                <label for="delivery_method" class="label_delivery_method">
                                                    <?=UA?'Нова Пошта (відділення). Від 80 грн. 1-3 дні':'Нова Почта (отделение). От 80 грн. 1-3 дня'?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="radio" id="delivery_method3" name="delivery_method" value="17">
                                                <label for="delivery_method3" class="label_delivery_method">
                                                    <?=UA?'Нова Пошта (поштомат). Від 90 грн. 1-2 дні':'Нова Почта (почтомат). От 90 грн. 1-2 дня'?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="radio"  id="delivery_method1" name="delivery_method" value="15">
                                                <label for="delivery_method1" class="label_delivery_method">
                                                    <?=UA?'УкрПошта Експрес':'УкрПочта Экспресс'?>
                                                </label>
                                            </div>
                                        </div>
                                        <?/*<div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="radio"  id="delivery_method2" name="delivery_method" value="13">
                                                <label for="delivery_method2" class="label_delivery_method">
                                                    <?=UA?'Самовивіз (м. Хмельницький, вул. Святослава Хороброго 5)':'Самовывоз (г.Хмельницкий, ул. Святослава Храброго 5)'?>
                                                </label>
                                            </div>
                                        </div>*/?>
                                        <?
                                        //if(isset($_GET['next']))
                                        {
                                            ?>
                                            <div class="form-checkbox">
                                                <div class="onoff  ">
                                                    <input type="radio" id="delivery_method4" name="delivery_method" value="18">
                                                    <label for="delivery_method4" class="label_delivery_method">
                                                        <?=UA?'Нова Пошта (кур’єр). Від 130 грн. 2-4 дні':'Нова Почта (курьер). От 130 грн. 2-4 дня'?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row np_courier" style="margin-left: -3px; margin-right: -3px; display:none;">
                                                <div class="col-md-6" style="padding: 0 3px;">
                                                    <label for="np_k_city" class="label_payment_method">
                                                        <?=UA?'Місто':'Город'?>
                                                    </label>
                                                    <input name="np_k_city" id="np_k_city" class="form-control" style="border:1px solid black;">
                                                </div>
                                                <div class="col-md-6" style="padding: 0 3px;">
                                                    <label for="np_k_street" class="label_payment_method">
                                                        <?=UA?'Вулиця':'Улица'?>
                                                    </label>
                                                    <input name="np_k_street" id="np_k_street" class="form-control" style="border:1px solid black;">
                                                    
                                                </div>
                                                <div class="col-md-6" style="padding: 0 3px;">
                                                    <label for="np_k_kv" class="label_payment_method">
                                                        <?=UA?'Квартира':'Квартира'?>
                                                    </label>
                                                    <input name="np_k_kv" id="np_k_kv" class="form-control" style="border:1px solid black;">
                                                    
                                                </div>
                                                <div class="col-md-6" style="padding: 0 3px;">
                                                    <label for="np_k_dom" class="label_payment_method">
                                                        <?=UA?'Буд.':'Дом'?>
                                                    </label>
                                                    <input name="np_k_dom" id="np_k_dom" class="form-control" style="border:1px solid black;">
                                                    
                                                </div>
                                            </div>
                                            <?
                                        }
                                        ?>

                                        <div class="form-control">
                                            <select class="custom-select" name="choose_city_np">
                                                <option value=""><?=UA?'Оберіть місто':'Выберите город'?></option>
                                            </select>
                                            <span class="form-placeholder"><?=UA?'Місто':'Город'?></span>
                                            <span class="error-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                        <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <div class="error-text">
                                                Поле обов'язкове для заповнення
                                            </div>
                                        </div>
                                        <div class="form-control choose_city">
                                            <select name="choose_city_np_vid"><option value=""><?=UA?'Оберіть спочатку місто':'Выберите сначала город'?></option></select>
                                            <span class="form-placeholder"><?=UA?'Відділення':'Отделение'?></span>
                                            <span class="error-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                        <path d="M 45 88.11 h 40.852 c 3.114 0 5.114 -3.307 3.669 -6.065 L 48.669 4.109 c -1.551 -2.959 -5.786 -2.959 -7.337 0 L 0.479 82.046 c -1.446 2.758 0.555 6.065 3.669 6.065 H 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,157,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <path d="M 45 64.091 L 45 64.091 c -1.554 0 -2.832 -1.223 -2.9 -2.776 l -2.677 -25.83 c -0.243 -3.245 2.323 -6.011 5.577 -6.011 h 0 c 3.254 0 5.821 2.767 5.577 6.011 L 47.9 61.315 C 47.832 62.867 46.554 64.091 45 64.091 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                                        <circle cx="44.995999999999995" cy="74.02600000000001" r="4.626" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <div class="error-text">
                                                Поле обов'язкове для заповнення
                                            </div>
                                        </div>

                                        <div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="checkbox" checked id="savenext" name="save_info">
                                                <label for="savenext">
                                                    <?=UA?'Зберегти цю інформацію надалі':'Сохранить эту информацию для дальнейших заказов'?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-info-form-block">
                                    <div class="order-info-title">
                                        Оплата
                                    </div>
                                    <div class="form_body">
                                        <?/*<div class="form-checkbox">
                                            <div class="onoff  ">
                                                <input type="radio" checked id="payment_method" name="payment_method" value="3">
                                                <label for="payment_method" class="label_payment_method">
                                                    <?=LANGUAGE_ID == 'ua' ? 'за реквізитами ФОП' : 'за реквизитами ФОП'?>
                                                </label>
                                            </div>
                                        </div>*/?>
                                        <?/*<div class="form-checkbox" style="display: none;">
                                            <div class="onoff  ">
                                                <input type="radio"  id="payment_method1" name="payment_method" value="10">
                                                <label for="payment_method1" class="label_payment_method">
                                                    <?=UA ? 'Готівка' : 'Наличка'?>
                                                </label>
                                            </div>
                                        </div>*/
										
										if ( $bonus_ok ) {
											?>
											<div class="form-checkbox">
												<div class="onoff">
													<input type="radio"  id="payment_method12" name="payment_method" value="12">
													<label for="payment_method12" class="label_payment_method">
													<?=UA ? 'Заплатити бонусами':'Оплатить бонусами'?>
													</label>
												</div>
											</div>											
											<?php
										}
										
										if ( $bonus_part ) {
											?>
											<div class="form-checkbox">
												<div class="onoff">
													<input type="checkbox"  id="payment_method_part" name="payment_method_part" value="1">
													<label for="payment_method_part" class="label_payment_method">
													<?=UA ? 'Заплатити бонусами бонусні товари':'Оплатить бонусами бонусные товары'?>
													</label>
												</div>
											</div>	
											<br>
											<?php
										}
										
										
										?>
                                        <div class="form-checkbox svNovaPoshta">
                                            <div class="onoff">
                                                <input type="radio"  id="payment_method2" name="payment_method" value="9">
                                                <label for="payment_method2" class="label_payment_method">
                                                    <?=UA ? 'Післяплата (при завдатку 200грн через сервіс Ipay)' : 'Постоплата (при задатке 200грн через сервис Ipay)'?>
                                                </label>
                                            </div>
                                        </div>



                                        <?
                                        //if($USER->IsAdmin())
                                        {
                                            ?>
                                            <div class="form-checkbox">
                                                <div class="onoff">
                                                    <input type="radio" checked id="payment_method3" name="payment_method" value="3">
                                                    <label for="payment_method3" class="label_payment_method">
                                                        <?=UA ? 'Оплата картою через сервіс Ipay' : 'Оплата через сервис Ipay'?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="">
                                    <label for="user_comment" class="label_payment_method">
                                        <?=UA?'Коментар':'Комментарий'?>
                                    </label>
                                    <textarea name="comment" id="user_comment" class="form-control" style="border:1px solid black;"></textarea>
                                </div>
                                <div class="create_error" style="color:red;display:none;">При оформленні замовлення виникла помилка</div>
                                <div class="lic_condition" style="color:red;<?=!$isOrder ? '' : 'display:none;'?>">У Вас в кошику товари, яких немає в наявності.</div>
                                <div class="order-info-btn">
                                    <a href="#" rel="noopener noreferrer" class="btn btn-large btn-default <?=($btnBonus === false ? 'disabled':'create_order')?> mobile_cr_or">
                                        <?=UA?'Оформити замовлення':'Оформить заказ'?>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-info-bottom">
                    <div class="order-info-bottom-cont">
                        <?=UA?'Усі права захищені STIMMA':'Все права защищены'?>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-list-col">
            <div class="order-list">
                <?
                if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
                    ob_start();
                ?>
                <div class="order-list-cont mobile">
                    <?
                    /*$alLSum=0;
					$totalBonus = 0;
                    $totalBonusPrice = [];
                    $totalSum = [];*/
                    
					foreach($basket as $index => $item)
                    {
                        $dpu = CIBlockElement::GetByID($item['PRODUCT_ID'])->GetNext();
						
						$dpuprop = CIBlockElement::GetList([],['ID' => $item['data'][PRODUCT_ID]],false,false,['ID', 'NAME', 'PROPERTY_PROP_BONUS', 'PROPERTY_PROP_BONUS_PRICE'])->Fetch();

                        $item = $item['data'];
                        $price = CCatalogProduct::GetOptimalPrice($item['PRODUCT_ID'])['RESULT_PRICE'];
                        $alLSum += $item['PRICE']*$item['QUANTITY'];

						if (isset($dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE])) {
							$totalBonus += $dpuprop[PROPERTY_PROP_BONUS_PRICE_VALUE] * $item['QUANTITY'];
						}

                       ?>
                        <div class="order-list-item">

                            <?
                            if($item['ID'])
                            {
                                ?>
                                <a href="?remove=<?=$item['ID']?>" class="order-list-item-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                </a>
                                <?
                            }
                            ?>

                            <div class="order-list-item-img-cont">
                                <div class="order-list-item-counter">
                                    <?=$item['QUANTITY']?>
                                </div>
                                <div class="order-list-item-img">
                                    <a href="<?=$item['DPU']?>">
                                        <img src="<?=$item['PREVIEW_PICTURE_SRC']?>">
                                    </a>
                                </div>
                            </div>
                            <div class="order-list-info">
                                <div class="order-list-name">
                                    <a href="<?=$item['DPU']?>" style="color:black;">
                                        <?=$item['NAME']?>
                                    </a>
                                </div>
                                <?/*<div class="order-list-size">34</div>*/?>
                            </div>
                            <div class="order-list-price-block">
                                <?if($item['BONUS']):
                                    //$totalBonusPrice[] = $price['BASE_PRICE']*$item['QUANTITY'];
                                    ?>
                                <div class="order-list-price"><?=$price['BASE_PRICE']*$item['QUANTITY']?> <?= UA ? " стімзів" : " стимзов" ?></div>
                                <?else:?>
                                <?
                                if($price['BASE_PRICE'] > $item['PRICE'])
                                {
                                    ?><div class="order-list-price-old"><?=FormatCurrency($price['BASE_PRICE']*$item['QUANTITY'],'UAH')?></div><?
                                }
                                $totalSum[] = $item['PRICE']*$item['QUANTITY'];
                                ?>
                                <div class="order-list-price"><?=FormatCurrency($item['PRICE']*$item['QUANTITY'],'UAH')?></div>
                                <?endif;?>
                        </div>

                        </div>
                        <?
                    }
                    ?>
                </div>
                <?
                if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
                    $json['mobile'] = ob_get_clean();
                ?>
                <div class="order-list-discount-block">
                    <div class="form_body">
                        <div class="form-control">
                            <input type="text" name="coupon" placeholder="Промокод">
                        </div>
                    </div>
                    <div class="order-list-discount-btn">
                        <a href="#" class="btn btn-default set_coupon">
                            <?=UA?'Застосувати':'Применить'?>
                        </a>
                    </div>
                </div>
                <div class="order-list-total">

                    <div class="order-list-total-item">
                        <div class="order-list-total-key">Доставка</div>
                        <div class="order-list-total-value"><?= $svDeliveryTxt ?></div>
                    </div>
                    <div class="order-list-total-item total-end">
                        <div class="order-list-total-key">Всього</div>
                        <div class="order-list-total-value"><?=FormatCurrency($TotalSum,'UAH')?></div>
                    </div>
                    <?
                    $TotalBonusPrice = array_sum($totalBonusPrice);
                    if($TotalBonusPrice > 0):
                    ?>
                    <div class="order-list-total-item total-end">
                        <div class="order-list-total-key">Всього</div>
                        <div class="order-list-total-value"><?=$TotalBonusPrice?> <?= UA ? " стімзів" : " стимзов" ?></div>
                    </div>
                    <?if($Balance['response']['Balance'] < $TotalBonusPrice):
                        $btnBonus = false;
                        ?>
                        <div class="create_error" style="color:red;"><?= UA ? "У вас недостатньо стімзів на балансі. Усього" : "У вас недостаточно симзов на балансе. Всего" ?> <?=$Balance['response']['Balance']?></div>
                    <?endif;?>
                    <?endif;?>
<?
global $USER;

/*
$bonus_ok = $userId = false;
if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();

if ( $userId == 66693 ) {
	
	$bonus = $USER->getBonusInfo();

	if ( $bonus['bonus'] >= $totalBonus ) {
		$bonus_ok = true;
		echo "bonus OK!<br>";
	}

	echo "userId=$userId<===<br>";
	echo "<pre>";print_R($bonus);echo "</pre>";
	exit();	
	
}
 */   



//\Bitrix\Main\Diag\Debug::dump($USER);

//if ($USER->IsAdmin()):
?>
		<div class="total-bonus" style="font-size: 17px;font-weight: 500;">
    		<?= UA ? "Кількість стімзів: ".$Balance['response']['Balance'] : "Количество симзов: ".$Balance['response']['Balance'] ?>
		</div>
<? //endif; ?>

                    <div class="create_error" style="color:red;display:none;">При оформленні замовлення виникла помилка</div>
                    <div class="lic_condition" style="color:red;<?=!$isOrder ? '' : 'display:none;'?>">У Вас в коризні товари, яких немає в наявності.</div>
                    <div class="order-info-btn">
                        <button class="btn btn-large btn-default <?=($btnBonus === false ? 'disabled':'create_order')?>" style="width: 100%;"
                            <?=($btnBonus === false ? 'disabled':'')?>
                        ><?=UA?'Оформити замовлення':'Оформить заказ'?></button>
                    </div>
                    <?
                    /*if($arResult['allAmountLeft'] > 0)
                    {
                        ?>
                        <div style="text-align: center;color:#f76b6a">
                            <?=UA?'Додайте ще '.$arResult['allAmountLeft'].' грн до отримання знижки!':'Добавьте еще '.$arResult['allAmountLeft'].' грн до получения скидки!'?>
                        </div>
                        <?
                    }*/
                    /*if($arResult['actionText'])
                    {
                        ?>
                        <div style="text-align: center;color:#f76b6a">
                            <?=UA?'Не забудьте обрати в подарунок річ на вибір: футболки, базові топи, хустки, пояси, біжутерія':'Не забудьте выбрать в подарок вещь на выбор: футболки, базовые топы, хустки, пояса, бижутерия'?>
                        </div>
                        <?
                    }*/
                    ?>
                </div>
            </div>
        </div>
    </div>
    </form>
    <?
    if(isset($_POST['action']) && $_POST['action'] == 'get_basket')
    {
        $json['amount'] = FormatCurrency($alLSum,'UAH');
        $APPLICATION->RestartBuffer();
        echo json_encode($json);
        die();
    }
    ?>
    <form action="<?=POST_FORM_ACTION_URI?>" method="POST" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data" style="display: none;">
        <?
        if(isset($_GET['sub']))
        {
            foreach($arResult['SQLS'] as $index => $sql)
            {
                ?><input type="hidden" name="sqls[]" value="<?=$sql?>"><?
            }
        }
        ?>
		<?
		echo bitrix_sessid_post();

		if (strlen($arResult['PREPAY_ADIT_FIELDS']) > 0)
		{
			echo $arResult['PREPAY_ADIT_FIELDS'];
		}
		?>
		<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
		<input type="hidden" name="location_type" value="code">
		<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
		<div id="bx-soa-order" class="row orderform--v1 bx-<?=$arParams['TEMPLATE_THEME']?>" style="opacity: 0">
			<!--	MAIN BLOCK	-->
			<div class="col-sm-9 bx-soa">
				<div id="bx-soa-main-notifications">
					<div class="alert alert-danger" style="display:none"></div>
					<div data-type="informer" style="display:none"></div>
				</div>
				<!--	AUTH BLOCK	-->
				<div id="bx-soa-auth" class="bx-soa-section bx-soa-auth" style="display:none">
					<div class="bx-soa-section-title-container">
						<h2 class="bx-soa-section-title col-sm-9">
							<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_AUTH_BLOCK_NAME']?>
						</h2>
					</div>
					<div class="bx-soa-section-content container-fluid"></div>
				</div>

				<!--	DUPLICATE MOBILE ORDER SAVE BLOCK	-->
				<div id="bx-soa-total-mobile" style="margin-bottom: 6px;"></div>

				<? if ($arParams['BASKET_POSITION'] === 'before'): ?>
					<!--	BASKET ITEMS BLOCK	-->
					<div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
						<div class="bx-soa-section-title-container">
							<h2 class="bx-soa-section-title col-sm-9">
								<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
							</h2>
							<?if($arParams['PRODUCT_COLUMNS_HIDDEN']):?>
								<div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_MORE_DETAILS']?></a></div>
							<?endif;?>
						</div>
						<div class="bx-soa-section-content container-fluid"></div>
					</div>
				<? endif ?>

				<!--	REGION BLOCK	-->
				<div id="bx-soa-region" data-visited="false" class="bx-soa-section bx-active">
					<div class="bx-soa-section-title-container">
						<h2 class="bx-soa-section-title col-sm-9">
							<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_REGION_BLOCK_NAME']?>
						</h2>
					</div>
					<div class="bx-soa-section-content container-fluid"></div>
				</div>

				<div class="pandd">
					<? if ($arParams['DELIVERY_TO_PAYSYSTEM'] === 'p2d'): ?>
						<!--	PAY SYSTEMS BLOCK	-->
						<div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	DELIVERY BLOCK	-->
						<div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active" <?=($hideDelivery ? 'style="display:none"' : '')?>>
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PICKUP BLOCK	-->
						<div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
					<? else: ?>
						<!--	DELIVERY BLOCK	-->
						<div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active" <?=($hideDelivery ? 'style="display:none"' : '')?>>
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PAY SYSTEMS BLOCK	-->
						<div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
						<!--	PICKUP BLOCK	-->
						<div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
							<div class="bx-soa-section-title-container">
								<h2 class="bx-soa-section-title col-sm-9">
									<span class="bx-soa-section-title-count"></span>
								</h2>
							</div>
							<div class="bx-soa-section-content container-fluid"></div>
						</div>
					<? endif ?>
					<?if($arParams['SHOW_COUPONS_DELIVERY'] === 'Y' || $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'Y'):?>
						<div id="bx-soa-coupon" data-visited="false" class="bx-soa-section bx-active"><div class="bx-soa-section-content"></div></div>
					<?endif;?>
				</div>
				<!--	BUYER PROPS BLOCK	-->
				<div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">
					<div class="bx-soa-section-title-container">
						<h2 class="bx-soa-section-title col-sm-9">
							<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BUYER_BLOCK_NAME']?>
						</h2>
					</div>
					<div class="bx-soa-section-content container-fluid"></div>
				</div>

				<? if ($arParams['BASKET_POSITION'] === 'after'): ?>
					<!--	BASKET ITEMS BLOCK	-->
					<div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
						<div class="bx-soa-section-title-container">
							<h2 class="bx-soa-section-title col-sm-9">
								<span class="bx-soa-section-title-count"></span><?=$arParams['MESS_BASKET_BLOCK_NAME']?>
							</h2>
							<?if($arParams['PRODUCT_COLUMNS_HIDDEN']):?>
								<div class="col-xs-12 col-sm-3 text-right"><a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_MORE_DETAILS']?></a></div>
							<?endif;?>
						</div>
						<div class="bx-soa-section-content container-fluid"></div>
					</div>
				<? endif ?>

				<!--	ORDER SAVE BLOCK	-->
				<div id="bx-soa-orderSave">
					<div class="checkbox">
						<?
						if ($arParams['USER_CONSENT'] === 'Y')
						{
							$APPLICATION->IncludeComponent(
								'bitrix:main.userconsent.request',
								'',
								array(
									'ID' => $arParams['USER_CONSENT_ID'],
									'IS_CHECKED' => $arParams['USER_CONSENT_IS_CHECKED'],
									'IS_LOADED' => $arParams['USER_CONSENT_IS_LOADED'],
									'AUTO_SAVE' => 'N',
									'SUBMIT_EVENT_NAME' => 'bx-soa-order-save',
									'REPLACE' => array(
										'button_caption' => isset($arParams['~MESS_ORDER']) ? $arParams['~MESS_ORDER'] : $arParams['MESS_ORDER'],
										'fields' => $arResult['USER_CONSENT_PROPERTY_DATA']
									)
								)
							);
						}
						?>
					</div>
					<a href="javascript:void(0)" style="margin: 10px 0" class="pull-right btn btn-default btn-lg hidden-xs" data-save-button="true">
						<?=$arParams['MESS_ORDER']?>
					</a>
				</div>

				<div style="display: none;">
					<div id='bx-soa-basket-hidden' class="bx-soa-section"></div>
					<div id='bx-soa-region-hidden' class="bx-soa-section"></div>
					<div id='bx-soa-paysystem-hidden' class="bx-soa-section"></div>
					<div id='bx-soa-delivery-hidden' class="bx-soa-section"></div>
					<div id='bx-soa-pickup-hidden' class="bx-soa-section"></div>
					<div id="bx-soa-properties-hidden" class="bx-soa-section"></div>
					<div id="bx-soa-auth-hidden" class="bx-soa-section">
						<div class="bx-soa-section-content container-fluid reg"></div>
					</div>
				</div>
			</div>

			<!--	SIDEBAR BLOCK	-->
			<div id="bx-soa-total" class="col-sm-3 bx-soa-sidebar">
				<div class="bx-soa-cart-total-ghost"></div>
				<div class="bx-soa-cart-total"></div>
			</div>
		</div>
	</form>

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
		BX.message(<?=CUtil::PhpToJSObject($messages)?>);
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
					if (BX.Sale && BX.Sale.OrderAjaxComponent)
						BX.Sale.OrderAjaxComponent.initMaps();
					else
						setTimeout(bx_gmaps_waiter, 100);
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