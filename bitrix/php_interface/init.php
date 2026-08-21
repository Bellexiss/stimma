<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Sale\Internals\DiscountCouponTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;
use Bitrix\Highloadblock\HighloadBlockTable;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
define('HLBLOCK_REGISTER_COUPONS', 20);
//define('NEW_STIMMA', isset($_COOKIE['new_stimma']));
define('NEW_STIMMA', true);


EventManager::getInstance()->addEventHandler("main", "OnAfterUserRegister", "AddUserPhoneToHL");
function getProfileFrom1C($phone) {
    $url = 'http://195.201.245.102:22022/sklad/hs/list/GetCard';

    $headers = [
        'Content-Type: application/json'
    ];

    $data = [
        "phone" => $phone
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
        CURLOPT_TIMEOUT => 10         // таймаут выполнения
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return [
            'error' => true,
            'message' => $error
        ];
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

// Удаляем BOM перед json_decode
    $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $decoded = json_decode($cleaned_response, true);

    return [
        'error' => false,
        'http_code' => $http_code,
        'response_raw' => $response,
        'response' => $decoded
    ];
}
function AddUserPhoneToHL($arFields) {
    $userPhone = $arFields["PERSONAL_PHONE"] ?? ($arFields["PHONE"] ?? "");
    
    if (!$userPhone)
        return;
    $check = getProfileFrom1C($userPhone);
    if($check['response']['find'] == true){
        return;
    }
    // Подключаем модуль хайлоад
    \Bitrix\Main\Loader::includeModule("highloadblock");

    $hlBlockId = HLBLOCK_REGISTER_COUPONS;
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlBlockId)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();
    $res = $entityClass::getList([
        'select' => ['ID', 'UF_USER_ID', 'UF_PHONE', 'UF_EMAIL', 'UF_COUPON', 'UF_DATE', 'UF_COUPON_ID'],
        'filter' => [
            'UF_PHONE' => $userPhone
        ]
    ]);
    $element = $res->fetch();
    if(!$element):
        
        $couponCode = DiscountCouponTable::generateCoupon(true);
        $res = DiscountCouponTable::add([
            'DISCOUNT_ID'  => 43,
            'COUPON'       => $couponCode,
            'TYPE'         => DiscountCouponTable::TYPE_ONE_ORDER, 
            'ACTIVE'       => 'N',
            'MAX_USE'      => 1,
            'USER_ID'      => 0, 
            'DESCRIPTION'  => $userPhone.';'.$arFields['EMAIL']
        ]);
        // Готовим запись
        $entityClass::add([
            'UF_COUPON_ID' => $res->getId(),
            'UF_USER_ID'   => $arFields['USER_ID'],
            'UF_PHONE'     => $userPhone,
            'UF_COUPON' => $couponCode,
            'UF_DATE'      => new \Bitrix\Main\Type\DateTime(),
            'UF_EMAIL' => $arFields['EMAIL'],
        ]);
    else:
         $entityClass::update($element['ID'], [
            'UF_USER_ID'   => $arFields['USER_ID'],
            'UF_PHONE'     => $userPhone,
            'UF_EMAIL' => $arFields['EMAIL'],
        ]);

    endif;
    
        
}
define('SUBSCRIBE_DISCOUNT_ID', 18);

AddEventHandler("subscribe", "OnAfterSubscriptionAdd", "OnAfterSubscriptionAddHandler");

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/block_spam_emails.php");
AddEventHandler("sale", "OnBeforeOrderAdd", "blockSpamEmailCheck");

function OnAfterSubscriptionAddHandler($ID, $arFields)
{
    if (!Loader::includeModule('sale')) {
        return;
    }

    $email = trim($arFields["EMAIL"]);
    if (!$email) return;


    $couponCode = DiscountCouponTable::generateCoupon(true);


    $activeFrom = new DateTime();
    $activeTo = new DateTime();
    $activeTo->add('90 days'); 


    $res = DiscountCouponTable::add([
        'DISCOUNT_ID'  => SUBSCRIBE_DISCOUNT_ID,
        'COUPON'       => $couponCode,
        'TYPE'         => DiscountCouponTable::TYPE_ONE_ORDER, 
        'ACTIVE'       => 'Y',
        'ACTIVE_FROM'  => $activeFrom,
        'ACTIVE_TO'    => $activeTo,
        'MAX_USE'      => 1,
        'USER_ID'      => 0, 
        'DESCRIPTION'  => 'subscribe:'.$email,
    ]);

    if ($res->isSuccess()) {
        // Отправляем письмо с купоном
		/*
        Event::send([
            'EVENT_NAME' => 'SUBSCRIBE_PROMO_CODE',
            'LID' => SITE_ID,
            'C_FIELDS' => [
                'EMAIL' => $email,
                'PROMO_CODE' => $couponCode,
                'VALID_TO' => $activeTo->format('d.m.Y'),
            ],
        ]);
		*/
    }
}


define ('ME', $_SERVER['REMOTE_ADDR'] == '109.95.54.224');
define ('LOYALTY', isset($_GET['loyalty']));
define('UA', LANGUAGE_ID == 'ua');
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/condbasketcategorycombo.php';
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/usd_rate_agent.php");
/*
EventManager::getInstance()->addEventHandler(
    'sale',
    'OnCondCtrlBuildList',
    ['\Local\Sale\CondBasketCategoryCombo', 'GetControlDescr']
);
EventManager::getInstance()->addEventHandler(
    'sale',
    'onCondCtrlBuildList',
    ['\Local\Sale\CondBasketCategoryCombo', 'GetControlDescr']
);
EventManager::getInstance()->addEventHandler(
    'sale',
    'OnCondSaleControlBuildList',
    ['\Local\Sale\CondBasketCategoryCombo', 'GetControlDescr']
);
EventManager::getInstance()->addEventHandler(
    'sale',
    'onCondSaleControlBuildList',
    ['\Local\Sale\CondBasketCategoryCombo', 'GetControlDescr']
);*/


function changeValue($ib, $code, $arValuesXmlIDs, $values_ua)
{
    if(is_array($arValuesXmlIDs))
    {
        foreach ($arValuesXmlIDs as $index2 => $item)
        {
            $item = mb_strtolower($item);
            if (isset($values_ua[$ib][$code][$item]))
                $arValuesXmlIDs[$index2] = $values_ua[$ib][$code][$item];
        }
    }
    else
    {
        $item = mb_strtolower($arValuesXmlIDs);
        if (isset($values_ua[$ib][$code][$item]))
            $arValuesXmlIDs = $values_ua[$ib][$code][$item];
    }

    $name = isset($values_ua['names'][$ib][$code]) ? $values_ua['names'][$ib][$code] : '';
    return ['values' => $arValuesXmlIDs, 'name' => $name];
}





AddEventHandler("main", "OnEndBufferContent", function (&$content) {
	
	global $APPLICATION;
	
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/h1.tsv'))
	$h1s_ = file($_SERVER['DOCUMENT_ROOT'].'/upload/h1.tsv');
	$h1s = [];
	foreach($h1s_ as $h1) {
		$tmp = explode('	', $h1);
		$h1s[trim($tmp[0])] = trim($tmp[1]);
	}	
	
	//echo "<pre>";print_R($h1s);exit();
	
	$curDir = $APPLICATION->GetCurDir();
	$GLOBALS['CUSTOM_PAGE_H1'] = false;
	if (isset($h1s[$curDir])) {
		$GLOBALS['CUSTOM_PAGE_H1'] = trim($h1s[$curDir]);
	}	

	//$content = $content;
	//echo "curDir=$curDir<=======<br>";
    if ( $GLOBALS['CUSTOM_PAGE_H1'] && $GLOBALS['CUSTOM_PAGE_H1'] != '' ) {
		
		//echo '==>'.$GLOBALS['CUSTOM_PAGE_H1'].'<=========================';
		
		$pattern = '/<h1\b[^>]*>(.*?)<\/h1>/is';

		$replacement = '<h1>' . htmlspecialchars($GLOBALS['CUSTOM_PAGE_H1'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</h1>';

		$content = preg_replace($pattern, $replacement, $content, 1);
		
		
    }
});

function checkGlobalRedirect()
{
    $page = $_SERVER['SCRIPT_URL'];
    $page = $_SERVER['REQUEST_URI'];
    $page = str_replace('?'.$_SERVER['QUERY_STRING'], '', $page);

    /*global $DB;
    $res = $DB -> Query('select * from redirect where UF_FROM_URL = \''.$page.'\'');
    if ($record = $res -> Fetch())
    {
        if (!empty($record['UF_TO_URL']))
        {
            LocalRedirect($record['UF_TO_URL'], false, "301 Moved Permanently");
            exit();
        }
    }*/

    $redirects = [
        '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/',
'/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-9998/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-9998/',
'/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-orieta-9993/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-orieta-9993/',
'/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-25/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-25/',
'/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-9997/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-9997/',
'/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-orieta-30/' => '/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-orieta-30/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-25/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-25/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-9997/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-9997/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-orieta-30/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-orieta-30/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-orieta-9993/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-orieta-9993/',
'/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/eko_shuby/zhenskaya-shuba-stimma-kalateya-9998/' => '/ru/catalog/zhenskaya_odezhda/verkhnyaya_odezhda/zimnie_kurtki_/zhenskaya-shuba-stimma-kalateya-9998/',
        '/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/' => '/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/',
'/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-7/' => '/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-7/',
'/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-8/' => '/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-8/',
'/ru/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/' => '/ru/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/',
'/ru/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-7/' => '/ru/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-7/',
'/ru/catalog/zhenskaya_odezhda/sportivnaya_odezhda/sportivnye_losiny/zhenskie-legginsy-stimma-meydi-8/' => '/ru/catalog/zhenskaya_odezhda/dzhinsy_bryuki_shorty/legginsy/zhenskie-legginsy-stimma-meydi-8/',
    ];

    $isRedirect = false; $cardRedirect = false;
    if (!preg_match('/\/$/', $page) && strpos($page, '.html') === false){$page = $page.'/';$isRedirect=true;}
    if (preg_match('/[A-Z]/', $page)){$page = strtolower($page);$isRedirect=true;}
    if (strpos($page, '//') !== false){$page = preg_replace('/\/{2,}/', '/',$page);$isRedirect=true;}
    if (strpos($page, '/index.php') !== false){$page = str_replace('/index.php','/', $page);$isRedirect=true;}
    if (strpos($page, '/index.html') !== false){$page = str_replace('/index.html','/', $page);$isRedirect=true;}
    if(isset($redirects[$page])){$page = $redirects[$page];$isRedirect=true;$cardRedirect=true;}
    //if (strpos($_SERVER['SERVER_NAME'], 'www.') !== false) {$page = 'https://titanshina.ua'.$page; $isRedirect = true;}
    //if (strpos($page, '.php') !== false){$page = str_replace('.php','/', $page);$isRedirect=true;}

    if(strpos($page, '.html') !== false || strpos($page, '.php') !== false || strpos($page, '.yml') !== false || strpos($page, '.xml') !== false || (preg_match('/[0-9]+/',$page) && !$cardRedirect)) $isRedirect = false;

    if ($isRedirect)
    {
        LocalRedirect($page.$_SERVER['QUERY_STRING'], false, "301 Moved Permanently");
        exit();
    }
}
AddEventHandler("main", "OnBuildGlobalMenu", "ModifiAdminMenu");
function ModifiAdminMenu(&$adminMenu, &$moduleMenu)
{
    global $USER;

    $arMenu = [
        [
            "text"     => 'Filter UA Values',
            "url"      => "ua_filter.php?lang=" . LANGUAGE_ID,
            "more_url" => [],
            "title"    => 'Filter UA Values',
        ],
        [
            "text"     => 'Ромірна сітка',
            "url"      => "sitka.php?lang=" . LANGUAGE_ID,
            "more_url" => [],
            "title"    => 'Ромірна сітка',
        ],
    ];

    if(!isset($adminMenu['global_menu_bservice']))
    {
        $adminMenu['global_menu_bservice'] = array
        (
            'menu_id' => 'global_menu_bservice',
            'text' => 'Filter UA Values',
            'title' => 'Filter UA Values',
            'sort' => 50,
            'items_id' => 'global_menu_bservice_items',
        );
    }

    $adminMenu['global_menu_bservice']['items'] = $arMenu;
}


function getBasketCount()
{
    global $DB;
    $fuserID = CSaleBasket::GetBasketUserID();
    return $DB->Query('select count(ID) as cnt from b_sale_basket where FUSER_ID = \''.$fuserID.'\' and ORDER_ID is NULL')->Fetch()['cnt'];
}

function getBasket($url = false)
{
    $ru = $url && strpos($url, '/ru/') !== false;

    if($ru)
        $site_id = 's1';
    else
        $site_id = 's2';

    $arBasketItems = ['TOTAL_KOM' => 0, 'TOTAL_PRICE' => 0,'ITEMS'=>[]];
    global $USER;

    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => $site_id,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE",
              "PRODUCT_ID", "QUANTITY", "DELAY",
              "CAN_BUY", "PRICE", "WEIGHT")
    );

    while ($arItems = $dbBasketItems->Fetch())
    {

        $price = CCatalogProduct::GetOptimalPrice($arItems["PRODUCT_ID"]);
        $product = CIBlockElement::GetByID($arItems["PRODUCT_ID"]) -> GetNext();

        if(!isset($product['ID']))
            continue;

        if($site_id == 's2')
        {
            $nameUA = CIBlockElement::GetPropertyValues(2, $product['ID'], array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
            if($nameUA)$product['NAME'] = $nameUA;
        }

        $arItems['CURRENT_PRICE'] = $price['RESULT_PRICE'];
        $arItems['PRODUCT'] = $product;
        $arBasketItems['TOTAL_KOM'] += $arItems['QUANTITY'];
        $arBasketItems['TOTAL_PRICE'] += ($arItems['QUANTITY']*$arItems['PRICE']);
        $arBasketItems['ITEMS'][] = $arItems;
    }

    $arBasketItems['TOTAL_KOM_COUNT'] = count($arBasketItems['ITEMS']);
    $arBasketItems['TOTAL_PRICE_FORMAT'] = FormatCurrency($arBasketItems['TOTAL_PRICE'], 'UAH');

    return $arBasketItems;
}

function getBasketHtml($basket = false)
{
    global $DB;
    ob_start();

    $param = UA ? '/' : '/ru/';
    if(!$basket)
        $basket = getBasket($param);
    if(!$basket['TOTAL_KOM_COUNT'])
    {
        ?>
        <div class="modal-basket-empty"><?=UA ? 'Кошик порожній' : 'Корзина пуста'?></div>
        <?
    }
    else
    {
        ?>
        <div class="modal-basket-block">
            <div class="modal-basket-content">
                <div class="modal-basket-list-cont">
                    <div class="modal-header-text" >
                        <b><?=UA ? 'Кошик' : 'Корзина'?><span class="popup_basket_total_kom">()</span></b>
                    </div>
                    <div class="modal-basket-list">
                        <?
                        $ids = [];
						$Bonus = 0;
						$Uah = [];
                        $TOTAL_BONUS_PRICE = 0;
                        $TOTAL_UAH_PRICE = 0;
                        foreach($basket['ITEMS'] as $index => $arItem)
                        {
                            $ids[] = $arItem['PRODUCT_ID'];

                            $product = CIBlockElement::GetByID($arItem['PRODUCT_ID'])->GetNextElement();
                            $fields = $product->GetFields();
                            $props = $product->GetProperties();

                            $mainID = $props['CML2_LINK']['VALUE'];
                            $mainProduct = CIBlockElement::GetByID($mainID)->GetNextElement();
                            $mainFields = $mainProduct->GetFields();
                            $mainProps = $mainProduct->GetProperties();
                            if($mainFields['PREVIEW_PICTURE'])
                                $image = $mainFields['PREVIEW_PICTURE'];
                            elseif($mainFields['DETAIL_PICTURE'])
                                $image = $mainFields['DETAIL_PICTURE'];
                            else
                                $image = $mainProps['MORE_PHOTO']['VALUE'][0];

                            if($image>0)
                                $image = CFile::ResizeImageGet($image, array('width'=>100, 'height'=>140), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                            else
                                $image = '';

                            if(LANGUAGE_ID == 'ua')
                                $arItem['PRODUCT']['NAME'] = CIBlockElement::GetProperty(25, $arItem['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
                            ?>
                            <div class="modal-basket-item">
                                <div class="modal-basket-item-img">
                                    <a href="<?=$arItem['PRODUCT']['DETAIL_PAGE_URL']?>">
                                        <img src="<?=$image?>">
                                    </a>
                                </div>
                                <div class="modal-basket-item-info">
                                    <div class="modal-basket-item-top">
                                        <div class="modal-basket-item-name nn1">
                                            <a href="<?=$arItem['PRODUCT']['DETAIL_PAGE_URL']?>"><?=$arItem['PRODUCT']['NAME']?></a>
                                        </div>
                                        <div class="modal-basket-item-price-block">
                                            <? if($mainProps['PROP_BONUS']['VALUE']):
                                                $Bonus += (int)$arItem['CURRENT_PRICE']['BASE_PRICE'] * (int)$arItem['QUANTITY'];
                                            ?>
                                                <div class="modal-basket-item-price">
                                                    <?=$arItem['CURRENT_PRICE']['BASE_PRICE']?> <?= UA ? " стімзів" : " стимзов" ?>
                                                </div>
                                            <?else:?>
                                            <?
                                            if($arItem['CURRENT_PRICE']['BASE_PRICE'] > $arItem['CURRENT_PRICE']['DISCOUNT_PRICE'])
                                            {

                                                ?>
                                                <div class="modal-basket-item-price-old">
                                                    <?=FormatCurrency($arItem['CURRENT_PRICE']['BASE_PRICE'],'UAH')?>
                                                </div>
                                                <?
                                            }
                                                $Uah[]= (int)$arItem['CURRENT_PRICE']['DISCOUNT_PRICE'] * (int)$arItem['QUANTITY'];

                                            ?>
                                            <div class="modal-basket-item-price">
                                                <?=FormatCurrency($arItem['CURRENT_PRICE']['DISCOUNT_PRICE'],'UAH')?>
                                            </div>
                                            <?endif;?>
                                        </div>
                                    </div>




<?
$TOTAL_BONUS_PRICE +=$Bonus;

global $USER;
if ($USER->IsAdmin()):
?>

<?

?>
<div>
        <?if ($props['PROP_BONUS_PRICE']['VALUE']):?>
            <div class="bonus-flag"></div>
            <div class="bonus-price">Кількість балів: <?=$props['PROP_BONUS_PRICE']['VALUE']?></div>
        <?endif;?>
</div>
<? endif; ?>

                                    <div class="modal-basket-item-size-block">
                                        <div class="modal-basket-item-size">
                                            <?=$props['RAZMER']['VALUE']?>
                                        </div>
                                        <div class="modal-basket-item-count">
                                            <?
                                            //if(isset($_GET['add']) || $_SERVER['REMOTE_ADDR'] == '109.95.54.224' || $_SERVER['REMOTE_ADDR'] == '162.158.103.25' || $_SERVER['REMOTE_ADDR'] == '188.163.9.192')
                                            {
                                                ?>
                                                <span data-id="<?=$arItem['ID']?>" class="minus_count">-</span>
                                                <?
                                            }
                                            ?>
                                            <input type="text" name="" value="<?=$arItem['QUANTITY']?>" data-id="<?=$arItem['ID']?>">
                                            <?
                                            //if(isset($_GET['add']) || $_SERVER['REMOTE_ADDR'] == '109.95.54.224' || $_SERVER['REMOTE_ADDR'] == '162.158.103.25' || $_SERVER['REMOTE_ADDR'] == '188.163.9.192')
                                            {
                                                ?>
                                                <span data-id="<?=$arItem['ID']?>" class="plus_count">+</span>
                                                <?
                                            }
                                            ?>
                                        </div>

                                    </div>
                                    <div class="modal-basket-item-btn">
                                        <a href="#" class="modal-basket-item-delete" data-id="<?=$arItem['ID']?>">
                                            <?=UA ? 'Видалити' : 'Удалить'?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        $TOTAL_UAH_PRICE = array_sum($Uah);
                        ?>
                    </div>
                </div>
                <div class="modal-basket-more-items">
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

                </div>
                <div class="modal-basket-info">
				
					<?php 
						//$userId = CSaleBasket::GetBasketUserID();
						
						global $USER;
						$userId = false;
						$svDeliveryFree = 0;
						if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();
						$svDeliveryTxt = UA?'За тарифом перевізника':'По тарифу перевозчика';
						if ( $userId ) {
							$free_groups = [28, 29, 30];
							//$dbUser = CUser::GetList("", "", array("ID" => (int)$userId), array('FIELDS' => array('ID', 'UF_LOYALTY_GROUP')));
							$dbUser = CUser::GetList($by = "ID", $order = "ASC", ["ID" => (int)$userId], ["SELECT" => ["UF_LOYALTY_GROUP"]]);							
							$arUser = $dbUser->Fetch();
							//echo "===userId=$userId<===<br>UF_LOYALTY_GROUP=$UF_LOYALTY_GROUP<===<br><pre>";print_R($arUser);print_R($dbUser);echo "</pre>---";
							if ( in_array($arUser['UF_LOYALTY_GROUP'], $free_groups) ) {
								$svDeliveryTxt = UA?'Безкоштовно':'Бесплатно';
								$svDeliveryFree = 1;
							}
						}
					?>
				
                    <div class="modal-basket-info-list">
                        <div class="modal-basket-info-key"><?=UA ? 'Доставка' : 'Доставка'?></div>
                        <div class="modal-basket-info-value"><?= $svDeliveryTxt ?></div>
                    </div>
        <? if ($TOTAL_UAH_PRICE > 0): ?>
                    <div class="modal-basket-info-list basket-info-list-total">
                        <div class="modal-basket-info-key"><?=UA?'<b>Сума</b>':'<b>Сумма</b>'?></div>
                        <div class="modal-basket-info-value"><?=FormatCurrency($TOTAL_UAH_PRICE,'UAH')?></div>
                    </div>
        <? endif; ?>
        <? if ($Bonus > 0): ?>
            <div class="modal-basket-info-list basket-info-list-total">
                <div class="modal-basket-info-key"><?=UA?'<b>Сума за стімзи</b>':'<b>Сумма за стимзы</b>'?></div>
                <div class="modal-basket-info-value"><?=$Bonus?> <?= UA ? " стімзів" : " стимзов" ?></div>
            </div>
        <? endif; ?>

                    <div class="modal-basket-info-check">
                        <label class="new-checkbox">
                            <input type="checkbox" name="" checked>
                            <span class="new-checkbox-text">
													<?=UA?'Я підтверджую, що я прочитав і зрозумів':'Я подтверждаю, что я прочел и понял'?>
                                <a href="<?=UA?'':'/ru'?>/pravova-informatsiya/"><?=UA?'положення та умови':'условия'?></a> .
												</span>
                        </label>
                    </div>
                    <div class="modal-basket-btn-block">
                        <a href="<?=UA?'':'/ru'?>/order/" class="modal-basket-btn">
                            <?=UA?'Оформити замовлення':'Оформить заказ'?>
                        </a>
                    </div>
                    <?/*<div class="modal-basket-text-bottom">
                        <p>Безкоштовна доставка при замовленні на суму від 2000 грн</p>
                        <p><span>Дізнайтеся більше про нашу повну <a href="#">політику повернення та відшкодування</a> .</span></p>
                    </div>*/?>
                </div>
            </div>
        </div>

        <?
    }
    $htmlBasket = ob_get_clean();

    return $htmlBasket;
}
function getBasketNewHtml($basket = false)
{
    global $DB,$APPLICATION,$USER;
    ob_start();

    $currtime = strtotime(date('d.m.Y H:i:s'));
    $startAction =strtotime('21.08.2026 00:00:01');
    $endAction = strtotime('23.08.2026 23:59:59');
    $isJulyAction = $currtime >= $startAction && $currtime <= $endAction ? 1 : 0;


    $param = UA ? '/' : '/ru/';
    if(!$basket)
        $basket = getBasket($param);
    if(!$basket['TOTAL_KOM_COUNT'])
    {
        ?>
        <div class="offcanvas-header">
            <div class="basker-header-title">
                <?=UA ? 'Кошик' : 'Корзина'?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <span class="icon">
                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                </svg>
            </span>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="modal-basket-empty"><?=UA ? 'Кошик порожній' : 'Корзина пуста'?></div>
            
        </div>
        <div class="offcanvas-footer">
            <?
            if(!$USER -> IsAuthorized())
                $fuserID = Bitrix\Sale\Fuser::getId();
            else
                $fuserID = 'u-'.$USER -> GetID();

            if(!isset($_SESSION['FAVORITE']))
                $_SESSION['FAVORITE'] = [];

            $res = $DB -> Query('select * from favorite where UF_FUSER_ID = \'' . $fuserID.'\'');
            while ($record = $res -> Fetch())
                $_SESSION['FAVORITE'][$record['UF_PRODUCT_ID']] = $record['UF_PRODUCT_ID'];

            $bItems = $_SESSION['FAVORITE'];
            if(!empty($bItems))
            {
                $newBItems = [];
                $resF = $DB->Query('select * from b_iblock_element where ID in ('.implode(',',$bItems).')');
                while ($record = $resF->Fetch())
                    $newBItems[] = $record['ID'];

                if(!empty($newBItems))
                {
                    global $MAX_SMART_FILTER;
                    $MAX_SMART_FILTER['ID'] = $bItems;
                    //$MAX_SMART_FILTER['>catalog_QUANTITY'] = 0;
                    ?>
                    <div class="header-goods-views-cont">
                        <div class="header-goods-views-title">
                            <?=LANGUAGE_ID=='ua'?'У списку бажань:':'В списке желаний:'?>
                        </div>
                        <div class="header-goods-views-slider-cont">
                            <?
                            $params = [
                                'IBLOCK_TYPE' => 'aspro_max_catalog',
                                'IBLOCK_ID' => '21',
                                'NO_SLIDER' => 'Y',
                                'ELEMENT_SORT_FIELD' => 'ID',
                                'ELEMENT_SORT_ORDER' => 'desc',
                                'ELEMENT_SORT_FIELD2' => 'sort',
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
                                    119 => 'SOSTAV_SITE_RU',
                                    120 => 'SOSTAV_SITE_UA',
                                ],
                                'PROPERTY_CODE_MOBILE' => '',
                                'META_KEYWORDS' => '-',
                                'META_DESCRIPTION' => '-',
                                'BROWSER_TITLE' => '-',
                                'SET_LAST_MODIFIED' => 'Y',
                                'INCLUDE_SUBSECTIONS' => 'Y',
                                'BASKET_URL' => '/basket/',
                                'ACTION_VARIABLE' => 'action',
                                'PRODUCT_ID_VARIABLE' => 'id',
                                'SECTION_ID_VARIABLE' => 'SECTION_ID',
                                'PRODUCT_QUANTITY_VARIABLE' => 'quantity',
                                'PRODUCT_PROPS_VARIABLE' => 'prop',
                                'FILTER_NAME' => 'MAX_SMART_FILTER',
                                'CACHE_TYPE' => 'A',
                                'CACHE_TIME' => '3600000',
                                'CACHE_FILTER' => 'Y',
                                'CACHE_GROUPS' => 'Y',
                                'SET_TITLE' => 'N',
                                'MESSAGE_404' => '',
                                'SET_STATUS_404' => 'Y',
                                'SHOW_404' => 'Y',
                                'FILE_404' => '',
                                'DISPLAY_COMPARE' => 'Y',
                                'PAGE_ELEMENT_COUNT' => '10',
                                'LINE_ELEMENT_COUNT' => '4',
                                'PRICE_CODE' => [0 => 'BASE',],
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
                            $params['BLOCK_CLASS']= 'search-goods-ex-slider-item';
                            $params['WRAP_CLASS']= 'header-goods-views-slider';

                            $APPLICATION->IncludeComponent(
                                "bitrix:catalog.section",
                                "main",
                                $params,
                                false
                            );
                            ?>
                        </div>
                    </div>
                    <?
                }

            }
            ?>
        </div>
        <?
    }
    else
    {
        $res = $DB -> Query('select * from max_color_reference');
        $colorsList = [];
        while ($record = $res -> Fetch())
        {
            $forChange[$record['UF_XML_ID']] = LANGUAGE_ID=='ua' ? $record['UF_NAME_UA'] : $record['UF_NAME'];
            $alLColors[$record['UF_XML_ID']] = $record['UF_COLOR_CODE'];
            $colorsList[$record['UF_XML_ID']] = LANGUAGE_ID == 'ua' ? $record['UF_NAME_UA'] : $record['UF_NAME'];
        }
        ?>
        <div class="offcanvas-header">
            <div class="basker-header-title">
                <?=UA ? 'Кошик' : 'Корзина'?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <span class="icon">
                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"/>
                </svg>
            </span>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="basket-header-list-cont">
                <div class="basket-header-list">
                    <?
                    $ids = [];
                    $Bonus = $minus_price = 0;
                    $Uah = [];
                    $TOTAL_BONUS_PRICE = 0;
                    $TOTAL_UAH_PRICE = 0;
                    global $DB,$USER;

                    // -800 грн для замовлення від 4500 та 3 товари з різних категорій , Акція була з 20,04,2026)
                    $arResult['IS_ACTION_APRIL_2026'] = 0;
                    $uGroups = $USER->GetUserGroupArray();
                    $isAprilAction = strtotime(date('20.04.2026 00:00:00')) < strtotime(date('d.m.Y H:i:s')) && strtotime(date('d.m.Y H:i:s')) < strtotime(date('31.05.2026 23:59:59'));
                    if($isAprilAction && in_array(9, $uGroups)) $isAprilAction = false;


                    if($isAprilAction)
                    {
                        $allAmountLeft = 4500;
                        $allQuantityLeftSection=$allQuantityLeftSectionAccs=[];
                        $activeIndex = -1;
                        $excludeSections=[361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311]; // sale + Аксесури + Бонусна шафа
                        $bottomSections=[];
                        $quantityProduct = 0;

                        $allSum = $countInAction = 0;
                    }

                    foreach($basket['ITEMS'] as $index => $arItem)
                    {
                        $withStims =$DB->Query('select * from basket_stims where UF_ID = '.$arItem['ID'])->Fetch();
                        $ids[] = $arItem['PRODUCT_ID'];

                        $product = CIBlockElement::GetByID($arItem['PRODUCT_ID'])->GetNextElement();
                        $fields = $product->GetFields();
                        $props = $product->GetProperties();

                        $mainID = $props['CML2_LINK']['VALUE'];
                        if($mainID)
                        {
                            $mainProduct = CIBlockElement::GetByID($mainID)->GetNextElement();
                            $mainFields = $mainProduct->GetFields();
                            $mainProps = $mainProduct->GetProperties();
                        }
                        else
                        {
                            $mainID = $arItem['PRODUCT_ID'];
                            $mainFields = $fields;
                            $mainProps= $props;
                        }

                        if($isAprilAction)
                        {
                            $productId = $mainID;

                            if($arItem['QUANTITY'] == 1 && $activeIndex == -1 && $arItem['PRICE'] > 800) // 800 - розмір знижки
                                $activeIndex = $index;

                            $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID in (352,361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311)'); // sale + Аксесури + Бонусна шафа
                            $isSale = $isSale->Fetch() ? true : false;

                            if(!$isSale)
                            {
                                $fetch=$DB->Query('select * from basket_stims where UF_ID = ' . $arItem['ID']);
                                $isSale = $fetch->Fetch() ? true : false;
                            }

                            if(!$isSale)
                            {
                                $quantityProduct += $arItem['QUANTITY'];

                                $product = $DB->Query('select * from b_iblock_element where ID = ' . $productId)->Fetch();
                                if(!in_array($product['IBLOCK_SECTION_ID'], $excludeSections))
                                    $allQuantityLeftSection[] = $product['IBLOCK_SECTION_ID'];
                                else
                                    $allQuantityLeftSectionAccs[] = $product['IBLOCK_SECTION_ID'];

                                $allSum += $arItem['PRICE']*$arItem['QUANTITY'];
                                $countInAction++;
                                $allAmountLeft -= $arItem['PRICE']*$arItem['QUANTITY'];
                                $allQuantityLeft -= $arItem['QUANTITY'];
                            }
                            else
                                $arItem['IS_SALE'] = true;
                        }



                        if($mainFields['PREVIEW_PICTURE'])
                            $image = $mainFields['PREVIEW_PICTURE'];
                        elseif($mainFields['DETAIL_PICTURE'])
                            $image = $mainFields['DETAIL_PICTURE'];
                        else
                            $image = $mainProps['MORE_PHOTO']['VALUE'][0];

                        if($image>0)
                            $image = CFile::ResizeImageGet($image, array('width'=>100, 'height'=>140), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                        else
                            $image = '';

                        if(LANGUAGE_ID == 'ua')
                            $arItem['PRODUCT']['NAME'] = CIBlockElement::GetProperty(25, $arItem['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];
                        if(!$arItem['PRODUCT']['NAME'])
                            $arItem['PRODUCT']['NAME'] = CIBlockElement::GetProperty(21, $arItem['PRODUCT_ID'],'sort', 'asc', array('CODE' => 'NAME_UA')) -> Fetch()['VALUE'];

                        if(($arItem['PRODUCT_ID'] == 47170 || $arItem['PRODUCT_ID'] == 47171) && $isJulyAction)
                            $arItem['CURRENT_PRICE']['DISCOUNT_PRICE'] = 0.01;

                        $Uah[]= (int)$arItem['CURRENT_PRICE']['DISCOUNT_PRICE'] * (int)$arItem['QUANTITY'];
                        ?>
                        <div class="basket-header-item <?=$fields['IBLOCK_SECTION_ID'] == 1311 ? 'basket-header-item-bonus' : ''?>">
                            <div class="basket-header-img">
                                <img src="<?=$image?>">
                            </div>
                            <div class="basket-header-info-block">
                                <div class="basket-header-info">
                                    <div class="basket-header-prop">
                                        <a href="<?=$arItem['PRODUCT']['DETAIL_PAGE_URL']?>" class="basket-header-item-name">
                                            <?=$arItem['PRODUCT']['NAME']?>
                                        </a>
                                        <div class="basket-header-price-block">
                                            <?
                                            if(isset($withStims['ID']))
                                            {
                                                $Bonus+=$withStims['UF_STIMS'];
                                                $minus_price += ($arItem['CURRENT_PRICE']['DISCOUNT_PRICE']*$arItem['QUANTITY']);
                                                ?>
                                                <div class="basket-header-item-price-bonus">
                                                    <?=$withStims['UF_STIMS']?>
                                                    <span class="icon">
                                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="11" cy="11" r="11" fill="#FE9D56"/>
                                                            <path d="M16.8827 12.5402C16.8827 13.0704 16.7849 13.5382 16.593 13.9318C16.4028 14.3199 16.1462 14.6519 15.8278 14.9207C15.5201 15.1803 15.1613 15.3911 14.7603 15.5458C14.3827 15.6915 13.9808 15.8055 13.5673 15.8851C13.16 15.9629 12.7429 16.0145 12.3285 16.038C11.9239 16.0625 11.5337 16.0742 11.1677 16.0742C10.2061 16.0742 9.30099 15.9928 8.47841 15.8326C7.65942 15.6725 6.92296 15.4707 6.29055 15.231L5.98377 15.1143V11.6952L6.68615 12.0888C7.27639 12.4181 7.96083 12.6814 8.72151 12.8687C9.48757 13.0578 10.32 13.1537 11.1955 13.1537C11.7095 13.1537 12.1293 13.1265 12.4433 13.0741C12.8147 13.0107 13.0192 12.9383 13.125 12.8886C13.282 12.8153 13.3206 12.7646 13.3215 12.7646C13.3358 12.742 13.343 12.7266 13.3457 12.7185C13.3421 12.7167 13.3322 12.7058 13.3143 12.6913C13.2488 12.6371 13.1223 12.5556 12.89 12.4724C12.672 12.3937 12.4092 12.3195 12.1114 12.2516C11.7983 12.1811 11.4646 12.1096 11.113 12.039C10.7542 11.9666 10.3855 11.8879 10.0061 11.8047C9.61585 11.7178 9.23282 11.6147 8.86593 11.498C8.49277 11.3795 8.13306 11.2383 7.79846 11.0791C7.44503 10.9108 7.12838 10.7072 6.85838 10.4747C6.57402 10.2286 6.34617 9.93908 6.18022 9.61427C6.00889 9.2768 5.92188 8.88685 5.92188 8.45529C5.92188 7.9631 6.01248 7.5261 6.19009 7.15696C6.36501 6.79235 6.60541 6.47749 6.90412 6.22054C7.19207 5.97264 7.52756 5.76997 7.90162 5.61707C8.25416 5.47231 8.63091 5.35831 9.02112 5.27869C9.40236 5.20088 9.79346 5.1466 10.1828 5.11765C10.5658 5.08869 10.9345 5.07422 11.278 5.07422C11.6575 5.07422 12.054 5.09412 12.4558 5.13212C12.8532 5.17012 13.2524 5.22441 13.6399 5.29407C14.023 5.36193 14.4006 5.44245 14.7639 5.53293C15.1227 5.6234 15.4609 5.71931 15.7695 5.81974L16.0969 5.9265V9.24604L15.4169 8.91219C15.2537 8.83166 15.0285 8.73666 14.7487 8.63081C14.4715 8.52586 14.1503 8.42452 13.7951 8.32952C13.4408 8.23453 13.0497 8.154 12.6326 8.08976C12.2208 8.02643 11.7929 7.99476 11.3606 7.99476C11.0098 7.99476 10.7075 8.00562 10.4626 8.02734C10.2222 8.04905 10.0204 8.0771 9.86253 8.10967C9.68761 8.14586 9.59432 8.18114 9.54678 8.20286C9.53153 8.2101 9.51897 8.21643 9.50731 8.22276C9.58086 8.27162 9.70376 8.33586 9.90021 8.40281C10.1227 8.4779 10.3864 8.55119 10.686 8.61905C11.0018 8.69052 11.3364 8.76381 11.6898 8.83981C12.0495 8.91671 12.42 9.00085 12.8021 9.09223C13.1941 9.18542 13.5789 9.2958 13.9458 9.42066C14.3217 9.54732 14.6823 9.69751 15.016 9.8658C15.3676 10.0431 15.6825 10.2548 15.9516 10.4946C16.235 10.7479 16.462 11.0438 16.6261 11.3749C16.7966 11.7187 16.8827 12.1105 16.8827 12.5402Z" fill="white"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <?
                                            }
                                            else
                                            {
                                                $price = CPrice::GetList(
                                                    [],
                                                    [
                                                        'PRODUCT_ID' => $arItem['PRODUCT_ID'],
                                                        'CATALOG_GROUP_ID' => 1
                                                    ]
                                                )->Fetch();

                                                if($isJulyAction && ($arItem['PRODUCT_ID'] == 47170 || $arItem['PRODUCT_ID'] == 47171))
                                                    $price['PRICE'] = $arItem['CURRENT_PRICE']['DISCOUNT_PRICE'] = 0.01;
                                                ?>
                                                    <?
                                                if($price['PRICE'] > $arItem['CURRENT_PRICE']['DISCOUNT_PRICE'])
                                                {
                                                    ?>
                                                    <div class="order-list-price-old"><?=FormatCurrency($price['PRICE'],'UAH')?></div>
                                                    <?
                                                }
                                                ?>

                                                <div class="basket-header-item-price">
                                                    <?=FormatCurrency($arItem['CURRENT_PRICE']['DISCOUNT_PRICE'],'UAH')?>
                                                </div>
                                                <?
                                            }
                                            ?>

                                        </div>
                                        <?/*<div class="basket-header-item-size">
                                            <?=LANGUAGE_ID=='ua'?'Розмір':'Размер'?>: <span><?=$props['RAZMER']['VALUE']?></span>
                                        </div>
                                        <div class="basket-header-item-color">
                                            <?=LANGUAGE_ID=='ua'?'Колір':'Цвет'?>: <span data-code="<?=$props['COLOR_REF']['VALUE'][0]?>" style="background: <?=$alLColors[$props['COLOR_REF']['VALUE'][0]]?>;"></span>
                                        </div>*/?>
                                    </div>
                                </div>
                                <div class="basket-header-control">
                                    <div class="basket-header-counter" style="<?=$isJulyAction && ($arItem['PRODUCT_ID'] == 47170 || $arItem['PRODUCT_ID'] == 47171) ? 'display:none;' : ''?>">
                                        <button class="basket-header-counter-btn minus_count" data-id="<?=$arItem['ID']?>">
                                            <svg width="13" height="1" viewBox="0 0 13 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="13" width="1" height="13" transform="rotate(90 13 0)" fill="currentcolor"/>
                                            </svg>
                                        </button>
                                        <input type="text" name="" value="<?=$arItem['QUANTITY']?>" data-id="<?=$arItem['ID']?>">
                                        <button class="basket-header-counter-btn plus_count" data-id="<?=$arItem['ID']?>">
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="6" width="1" height="13" fill="white"/>
                                                <rect x="13" y="6" width="1" height="13" transform="rotate(90 13 6)" fill="white"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="basket-header-control-item basket_favorite">
                                        <a href="#" class="basket-header-item-delete" data-id="<?=$arItem['ID']?>">
                                            <span class="icon">
                                                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.4365 12.0225L25.4561 0.00292969L26.8701 1.41699L14.8506 13.4365L26.8701 25.4561L25.4561 26.8701L13.4365 14.8506L1.41406 26.873L0 25.459L12.0225 13.4365L0 1.41406L1.41406 0L13.4365 12.0225Z" fill="currentcolor"></path>
                                                </svg>
                                            </span>
                                            <span class="text">
                                                <?=UA ? 'Видалити' : 'Удалить'?>
                                            </span>
                                        </a>
                                        <?//if(isset($_GET['bfavorite']))
                                        {?>
                                            <a href="#" class="basket-header-item-favorite <?=isset($_SESSION['FAVORITE'][$arItem['PRODUCT_ID']]) ? 'active' : ''?>" data-id="<?=$arItem['PRODUCT_ID']?>">
                                                <span class="icon">
                                                    <svg width="29" height="24" viewBox="0 0 29 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M21.1211 1C22.8573 1.00008 24.5177 1.67362 25.7998 2.9082C27.2066 4.26283 28.013 6.18547 28 8.18164C27.9901 9.6702 27.4064 11.3444 26.1465 13.1729L25.8857 13.541C24.7731 15.0644 23.2108 16.6732 21.2246 18.3184C18.0759 20.9262 14.9727 22.7134 14.499 22.9814C14.0197 22.7121 10.8967 20.9249 7.73828 18.3184C5.74455 16.673 4.18144 15.0637 3.07324 13.541C1.63737 11.5682 0.98956 9.7706 1 8.18457C1.01286 6.2594 1.73204 4.46171 3.01465 3.11328C4.31718 1.744 6.04209 1.0001 7.87891 1C10.2274 1 12.3954 2.25905 13.6504 4.28418C13.8327 4.5784 14.1539 4.7578 14.5 4.75781C14.8461 4.75781 15.1673 4.57841 15.3496 4.28418C16.6046 2.25908 18.7726 1 21.1211 1Z" stroke="currentcolor" stroke-width="2" stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                                <span class="text">
                                                    <?
                                                    if(isset($_SESSION['FAVORITE'][$arItem['PRODUCT_ID']]))
                                                    {
                                                        echo LANGUAGE_ID == 'ua' ? 'В обраному' : 'В избранном';
                                                    }
                                                    else
                                                    {
                                                        echo LANGUAGE_ID == 'ua' ? 'В обране' : 'В избранное';
                                                    }
                                                    ?>
                                                </span>
                                            </a>
                                        <?}?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?
                    }
                    $TOTAL_UAH_PRICE = array_sum($Uah);

                    if($isAprilAction)
                    {
                        if($allQuantityLeft <= 0 && $allSum >= 4500 && count(array_unique($allQuantityLeftSection)) >= 3 && $quantityProduct >= 4)
                        {
                            if($activeIndex != -1)
                                $basket['ITEMS'][$activeIndex]['PRICE'] -= 800;
                        }
                    }
                    if($isJulyAction && $TOTAL_UAH_PRICE >= 3000)
                        $percentJuly = $TOTAL_UAH_PRICE*0.16;

                    ?>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="basket-header-total">
                <div class="basket-header-total-key">
                    Разом <?=$basket['TOTAL_KOM']?> од.
                </div>
                <div class="basket-header-total-value">
                    <?=FormatCurrency($TOTAL_UAH_PRICE-$minus_price,'UAH')?>
                </div>
            </div>
            <?
            if($isJulyAction && $percentJuly)
            {
                ?>
                <div class="basket-header-total">
                    <div class="basket-header-total-key">
                        Знижка
                    </div>
                    <div class="basket-header-total-value">
                        <?=FormatCurrency(-$percentJuly,'UAH')?>
                    </div>
                </div>
                <div class="basket-header-total">
                    <div class="basket-header-total-key">
                        Разом
                    </div>
                    <div class="basket-header-total-value">
                        <?=FormatCurrency($TOTAL_UAH_PRICE-$percentJuly,'UAH')?>
                    </div>
                </div>

                <?
                ?><span>Готово — твої -16% уже в кошику.</span><?
            }
            if($isAprilAction)
            {
                if(count(array_unique($allQuantityLeftSection)) == 1)
                {
                    ?><span class="basket-header-add-more">Додай ще 3 речі з інших категорій одягу — і отримай -800 грн.
                        <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                    </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) < 3 && count($allQuantityLeftSection) >= 3)
                {
                    ?><span class="basket-header-add-more">Для знижки потрібні 3 речі з різних категорій одягу. Додай ще 1 річ з іншої категорії.
                    <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) == 2)
                {
                    ?><span class="basket-header-add-more">Додай ще 2 річ з іншої категорії одягу — і твої -800 грн уже чекають.
                    <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) >= 3 && $TOTAL_UAH_PRICE-$minus_price < 4500 && $quantityProduct <= 4)
                {
                    ?><span class="basket-header-add-more">Додай ще 1 річ — і отримай -800 грн.
                    <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) >= 3 && $TOTAL_UAH_PRICE-$minus_price >= 4500 && $quantityProduct < 4)
                {
                    ?><span class="basket-header-add-more">Додай ще 1 річ — і отримай -800 грн.
                    <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) >= 3 && $TOTAL_UAH_PRICE-$minus_price < 4500 )
                {
                    ?><span class="basket-header-add-more">Ти вже майже у виграші. Додай ще товарів на <?=4500-($TOTAL_UAH_PRICE-$minus_price)?> грн, щоб отримати -800 грн.
                    <div class="basket-header-btn">
                            <a href="<?=UA?'':'/ru'?>/catalog/zhenskaya_odezhda/" class="info-btn">
                                Додати ще річ
                            </a>
                        </div>
                    </span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) >= 3 && $TOTAL_UAH_PRICE-$minus_price >= 4500 && $quantityProduct >= 4)
                {
                    ?>
                    <div class="basket-header-total">
                        <div class="basket-header-total-key">
                            Знижка
                        </div>
                        <div class="basket-header-total-value">
                            <?=FormatCurrency(-800,'UAH')?>
                        </div>
                    </div>
                    <div class="basket-header-total">
                        <div class="basket-header-total-key">
                            Разом
                        </div>
                        <div class="basket-header-total-value">
                            <?=FormatCurrency($TOTAL_UAH_PRICE-$minus_price-800,'UAH')?>
                        </div>
                    </div>

                    <?
                    ?><span>Готово — твої -800 грн уже в кошику.</span><?
                }
                elseif(count(array_unique($allQuantityLeftSection)) == 0 && count($allQuantityLeftSectionAccs))
                {
                    ?><span>Акція діє лише на одяг. Додай речі з категорії одягу, щоб отримати -800 грн.</span><?
                }
            }
            ?>
            <div class="basket-header-btn">
                <a href="<?=UA?'':'/ru'?>/order/" class="info-btn info-btn-black">
                    Оформити замовлення
                </a>
                <?/*<a href="#" class="info-btn ">
                    Купити в 1 клік
                </a>*/?>
            </div>
        </div>
        <?
    }
    $htmlBasket = ob_get_clean();

    return $htmlBasket;
}

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("RClass", "ratingHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementDelete", Array("RClass", "ratingHandler"));

class RClass
{
    // создаем обработчик события "OnAfterIBlockElementAdd"
    function ratingHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID'] == 35)
        {
            $filter = ['IBLOCK_ID' => 35, 'ACTIVE' => 'Y'];
            if($arFields['IBLOCK_SECTION_ID']) $filter['SECTION_ID'] = $arFields['IBLOCK_SECTION_ID'];

            $res = CIBlockElement::GetList([], $filter, false, false, ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'PROPERTY_RATING']);
            $ratings = [];
            while ($record = $res -> Fetch())
            {
                $rating = intval($record['PROPERTY_RATING_VALUE']);
                if(!$rating) continue;

                if(isset($ratings[$record['IBLOCK_SECTION_ID']]['UF_RATING_'.$rating]))
                    $ratings[$record['IBLOCK_SECTION_ID']]['UF_RATING_'.$rating]++;
                else
                    $ratings[$record['IBLOCK_SECTION_ID']]['UF_RATING_'.$rating] = 1;
            }

            $bs = new CIBlockSection;
            foreach ($ratings as $sid => $rating)
            {
                $bs -> Update($sid, $rating);
            }
        }

        if($arFields['IBLOCK_ID'] == 21)
        {
            $newItem = CIBlockElement::GetList([], ['IBLOCK_ID'=>39,'PROPERTY_UF_PRODUCT_ID'=>$arFields['ID']]);
            if($newItem = $newItem->Fetch())
            {
                $props = CIBlockElement::GetByID($newItem['ID'])->GetNextElement()->GetProperties();
                $el = new CIBlockElement;
                if($arFields['ACTIVE_FROM'])
                {
                    $timestamp = MakeTimeStamp($arFields['ACTIVE_FROM'], "DD.MM.YYYY HH:MI");
                    $activeFromFormatted = ConvertTimeStamp($timestamp, "FULL");
                    $el->Update($newItem['ID'], ['ACTIVE_FROM'=> $activeFromFormatted]);
                }

                if($arFields['PREVIEW_PICTURE']['old_file'] && !$props['UF_FILE']['VALUE'])
                {
                    $values = CFile::MakeFileArray($arFields['PREVIEW_PICTURE']['old_file']);
                    CIBlockElement::SetPropertyValuesEx($newItem['ID'], 39, array('UF_FILE' => $values) );
                }
            }
        }
    }
}
if(strpos($GLOBALS["APPLICATION"]->GetCurPage(), '/bitrix/') !== false)
{
    //\Bitrix\Main\Page\Asset::getInstance()->addString('<style>.adm-info-message-wrap{display:none !important;}</style>');
}
// todo це на крон або агент або на редагування елемента, його створення та після оновлення товарів (або тут можна і відразу в оновленні робити).. плюс
// todo треба щоб ця функція не визивалася кожного разу коли  в оновленні товарів з файлу оновлюється елемент
function setMinimumPrice()
{
    $pricesSections = $sections = [];

    $res = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID' => 21,
            'ACTIVE'    => 'Y',
        ),
        false,
        false,
        array('ID', 'IBLOCK_ID'));

    while ($record = $res -> Fetch())
    {
        $cPrice = CCatalogProduct::GetOptimalPrice($record['ID'],1,[2])['RESULT_PRICE'];
        CIBlockElement::SetPropertyValuesEX(
            $record['ID'],
            21,
            ['MINIMUM_PRICE' => $cPrice['DISCOUNT_PRICE']]
        );

        $product = CCatalogProduct::GetByID($record['ID']);
        //$mxResult = CCatalogSku ::GetProductInfo($record['ID']);
        //$bOffer   = is_array($mxResult);

        $resSCU = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $record['ID'],'ACTIVE' => 'Y'], false, false, ['ID', 'IBLOCK_ID']);
        if($resSCU = $resSCU -> Fetch())
            $bOffer = true;
        else
            $bOffer = false;
        $bValue = 0;

        if(!$bOffer && $product['QUANTITY'] == 0)
            $bValue = 1;
        elseif(!$bOffer && $product['QUANTITY'] > 0)
            $bValue = 0;
        elseif($bOffer)
        {
            $resSCU = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $record['ID'],'ACTIVE' => 'Y'], false, false, ['ID', 'IBLOCK_ID']);
            $bAvailable = false;
            while ($recordSCU = $resSCU -> Fetch())
            {
                $productSCU = CCatalogProduct::GetByID($recordSCU['ID']);
                if($productSCU['QUANTITY'] > 0) $bAvailable = true;
            }

            if($bAvailable)
                $bValue = 0;
            elseif(!$bAvailable)
                $bValue = 1;
        }
        CIBlockElement::SetPropertyValuesEX(
            $record['ID'],
            21,
            ['DISCOUNT' => $cPrice['BASE_PRICE'] - $cPrice['DISCOUNT_PRICE']]
        );




        /*?><pre><?=print_r($product, 1)?></pre><?
        var_dump($bOffer);
        die();*/
    }


    $res = CIBlockSection::GetList([], ['IBLOCK_ID' => 21]);
    $bs = new CIBlockSection;
    while ($record = $res -> Fetch())
    {
        $min = $res2 = CIBlockElement::GetList(['PROPERTY_MINIMUM_PRICE' => 'asc'], ['IBLOCK_ID' => 21, '>PROPERTY_MINIMUM_PRICE' => 0,'SECTION_ID' => $record['SECTION_ID'],'INCLUDE_SUBSECTIONS' => 'Y'], false, ['nTopCount' => 1], ['IBLOCK_ID','ID','PROPERTY_MINIMUM_PRICE'])->Fetch()['PROPERTY_MINIMUM_PRICE_VALUE'];
        $max = $res2 = CIBlockElement::GetList(['PROPERTY_MINIMUM_PRICE' => 'desc'], ['IBLOCK_ID' => 21, '>PROPERTY_MINIMUM_PRICE' => 0,'SECTION_ID' => $record['SECTION_ID'],'INCLUDE_SUBSECTIONS' => 'Y'], false, ['nTopCount' => 1], ['IBLOCK_ID','ID','PROPERTY_MINIMUM_PRICE'])->Fetch()['PROPERTY_MINIMUM_PRICE_VALUE'];
        $bs->Update($record['ID'], ['UF_MIN_PRICE' => $min, 'UF_MAX_PRICE' => $max]);
    }

}


AddEventHandler('main', 'OnAdminTabControlBegin', 'MyOnAdminTabControlBegin');
function MyOnAdminTabControlBegin(&$form)
{
    if($GLOBALS['APPLICATION']->GetCurPage()=='/bitrix/admin/iblock_element_edit.php' && $_REQUEST['IBLOCK_ID']==21)
    {
        global $DB;
        $record = $DB -> Query('select * from size_table where UF_PRODUCT = ' . $_REQUEST['ID']);
        if($record = $record -> Fetch())
        {
            $record = unserialize($record['UF_TABLE'], ['allowed_classes' => false]);
            $content = '';
            //$content .= '<table>';
            foreach ($record as $index => $items)
            {
                $content .= '<tr>';
                $add = false;
                    foreach ($items as $index2 => $item)
                    {
                        $style = !$index && !$index2 ? 'width:20%;' : 'margin-left:15px';
                        $value = !$index && !$index2 ? '<input style="width:90%;display:none" type="text" name="table['.$index.']['.$index2.']" value="'.$item.'">' : '<input style="width:90%" type="text" name="table['.$index.']['.$index2.']" value="'.$item.'">';
                        $content .= '<td style="'.$style.'">'.$value.'</td>';

                        if(!$add && $item) $add = true;
                    }
                    //if($add)
                        //$content .= '<td style=""><input style="width:90%" type="text" name="table['.$index.']['.($index2+1).']" value=""></td>';
                 $content .= '</tr>';
            }
            /*foreach ($record as $index => $items)
            {
                $content .= '<tr>';
                    foreach ($items as $index2 => $item)
                    {
                        $style = !$index && !$index2 ? 'width:20%;' : 'margin-left:15px';
                        $content .= '<td style="'.$style.'"><input style="width:90%" type="text" name="table['.($index+1).']['.$index2.']" value=""></td>';
                    }
                if($add)
                    $content .= '<td style=""><input style="width:90%" type="text" name="table['.($index+1).']['.($index2+1).']" value=""></td>';
                $content .= '</tr>';
                break;
            }*/
            //$content .= '</table>';

            $form->tabs[] = array('DIV' => 'ib_add_edit', 'TAB' => 'Таблица замеров', 'TITLE' => 'Таблица замеров', 'CONTENT'=>$content);
        }
        else
        {
            ob_start();
            ?>
            <tr>
                <td><input style="display:none;" type="text" name="table[0][0]">&nbsp;</td>
                <td><input style="width:90%;" type="text" name="table[0][1]"></td>
                <td><input style="width:90%;" type="text" name="table[0][2]"></td>
                <td><input style="width:90%;" type="text" name="table[0][3]"></td>
                <td><input style="width:90%;" type="text" name="table[0][4]"></td>
                <td><input style="width:90%;" type="text" name="table[0][5]"></td>
                <td><input style="width:90%;" type="text" name="table[0][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[1][0]"></td>
                <td><input style="width:90%;" type="text" name="table[1][1]"></td>
                <td><input style="width:90%;" type="text" name="table[1][2]"></td>
                <td><input style="width:90%;" type="text" name="table[1][3]"></td>
                <td><input style="width:90%;" type="text" name="table[1][4]"></td>
                <td><input style="width:90%;" type="text" name="table[1][5]"></td>
                <td><input style="width:90%;" type="text" name="table[1][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[2][0]"></td>
                <td><input style="width:90%;" type="text" name="table[2][1]"></td>
                <td><input style="width:90%;" type="text" name="table[2][2]"></td>
                <td><input style="width:90%;" type="text" name="table[2][3]"></td>
                <td><input style="width:90%;" type="text" name="table[2][4]"></td>
                <td><input style="width:90%;" type="text" name="table[2][5]"></td>
                <td><input style="width:90%;" type="text" name="table[2][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[3][0]"></td>
                <td><input style="width:90%;" type="text" name="table[3][1]"></td>
                <td><input style="width:90%;" type="text" name="table[3][2]"></td>
                <td><input style="width:90%;" type="text" name="table[3][3]"></td>
                <td><input style="width:90%;" type="text" name="table[3][4]"></td>
                <td><input style="width:90%;" type="text" name="table[3][5]"></td>
                <td><input style="width:90%;" type="text" name="table[3][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[4][0]"></td>
                <td><input style="width:90%;" type="text" name="table[4][1]"></td>
                <td><input style="width:90%;" type="text" name="table[4][2]"></td>
                <td><input style="width:90%;" type="text" name="table[4][3]"></td>
                <td><input style="width:90%;" type="text" name="table[4][4]"></td>
                <td><input style="width:90%;" type="text" name="table[4][5]"></td>
                <td><input style="width:90%;" type="text" name="table[4][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[5][0]"></td>
                <td><input style="width:90%;" type="text" name="table[5][1]"></td>
                <td><input style="width:90%;" type="text" name="table[5][2]"></td>
                <td><input style="width:90%;" type="text" name="table[5][3]"></td>
                <td><input style="width:90%;" type="text" name="table[5][4]"></td>
                <td><input style="width:90%;" type="text" name="table[5][5]"></td>
                <td><input style="width:90%;" type="text" name="table[5][6]"></td>
            </tr>
            <tr>
                <td><input style="width:90%;" type="text" name="table[6][0]"></td>
                <td><input style="width:90%;" type="text" name="table[6][1]"></td>
                <td><input style="width:90%;" type="text" name="table[6][2]"></td>
                <td><input style="width:90%;" type="text" name="table[6][3]"></td>
                <td><input style="width:90%;" type="text" name="table[6][4]"></td>
                <td><input style="width:90%;" type="text" name="table[6][5]"></td>
                <td><input style="width:90%;" type="text" name="table[6][6]"></td>
            </tr>
            <?
            $content = ob_get_clean();
            $form->tabs[] = array('DIV' => 'ib_add_edit', 'TAB' => 'Таблица замеров', 'TITLE' => 'Таблица замеров', 'CONTENT'=>$content);
        }
    }
}
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", 'checkTable');

function checkTable(&$arFields)
{
    if($arFields['IBLOCK_ID'] == 21 && is_array($_REQUEST['table']))
    {
        global $DB;
        $table = $DB -> Query('select * from size_table where UF_PRODUCT = ' . $arFields['ID']);

        if($table = $table -> Fetch())
        {
            $DB -> Query('update size_table set UF_TABLE = \''.serialize($_REQUEST['table']).'\' where ID  = ' . $table['ID']);
        }
        else
        {
            $DB -> Query('insert into size_table (UF_PRODUCT, UF_TABLE) values (\''.$arFields['ID'].'\',\''.serialize($_REQUEST['table']).'\')');
        }
    }
}


function generateFeedGoogle()
{
    global $DB;

    $res = $DB -> Query('select * from max_color_reference');
    while ($record = $res -> Fetch())
        $colorRef[$record['UF_XML_ID']] = $record;

    $usdRate = COption::GetOptionString("my_module", "usd_rate",'41.7');

    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">';
    $header .= '<title>STIMMA</title>';
    $header .= '<link rel="self" href="https://stimma.ua"/>';
    //$header .= '<updated>20011-07-11T12:00:00Z</updated> ';
    $header .= '<updated>'.date('d.m.Y H:i:s').'</updated> ';
    $header .= '<currency code = "UAH" rate = "1" main = "1"/>';

    $mainColors = [];
    $res = $DB -> Query('select * from main_colors');
    while($record = $res -> Fetch())
        $mainColors[$record['UF_XML_ID']] = $record['UF_NAME_UA'];

    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';

    $sectionRes = CIBlockSection::GetList([], ['IBLOCK_ID' => 21], false, ['ID','IBLOCK_ID','UF_*']);
    $arSections= $allSections = [];
    while ($rec = $sectionRes -> Fetch())
    {
        $allSections[$rec['ID']] = $rec;
        $arSections[$rec['ID']] = $rec['UF_NAME_UA'];
    }
    $content = $contentRu = $contentFB = $contentRuFB = $contentTikTok = $contentTikTokRu = '';
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y']);
    while ($record = $res -> GetNextElement())
    {
        $fields = $record -> GetFields();
        $Props = $record -> GetProperties();

        if(!$allSections[$fields['IBLOCK_SECTION_ID']]['UF_GOOGLE_ID']) continue;

        $offersPropDB = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'PROPERTY_CML2_LINK' => $fields['ID']/*,'!PROPERTY_MATERIAL' => false*/]);

        $sizes = [];
        $material = $sklad = '';

        $available = 'out of stock';
        //$available = 'in stock';

        while ($offersProp = $offersPropDB->GetNextElement())
        {
            $offersFields = $offersProp->GetFields();
            $offersProp = $offersProp->GetProperties();

            $quantity = $DB->Query('select * from b_catalog_product where ID = ' . $offersFields['ID'])->Fetch();
            if($quantity['QUANTITY'] > 0)
                $available = 'in stock';

            if(!$Props['DETAIL_TEXT_UA']['VALUE'] && $offersProp['DETAIL_TEXT_UA']['VALUE'])
                $Props['DETAIL_TEXT_UA']['VALUE'] = $offersProp['DETAIL_TEXT_UA']['VALUE'];

            if(!$fields['DETAIL_TEXT'] && $offersFields['DETAIL_TEXT'])
                $fields['DETAIL_TEXT'] = $offersFields['DETAIL_TEXT'];



            if($offersProp['MATERIAL']['VALUE'][0])
                $materialRu = $offersProp['MATERIAL']['VALUE'][0];
            if($offersProp['SOSTAV']['VALUE'])
                $skladRu = $offersProp['SOSTAV']['VALUE'];
            if($offersProp['RAZMER']['VALUE'])
                $sizes[] = $offersProp['RAZMER']['VALUE'];

            if(isset($name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]]))
                $offersProp['MATERIAL']['VALUE'][0] = $name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]];

            if(isset($name_ua['SOSTAV']['values'][$offersProp['SOSTAV']['VALUE_XML_ID']]))
            {
                $offersProp['SOSTAV']['VALUE'] = $name_ua['SOSTAV']['values'][$offersProp['SOSTAV']['VALUE_XML_ID']];
            }

            if($offersProp['MATERIAL']['VALUE'][0])
                $material = $offersProp['MATERIAL']['VALUE'][0];
            if($offersProp['SOSTAV']['VALUE'])
                $sklad = $offersProp['SOSTAV']['VALUE'];
            //if($offersProp['RAZMER']['VALUE'])
            //    $sizes[] = $offersProp['RAZMER']['VALUE'];
        }

        $img = $fields['PREVIEW_PICTURE'] ? $fields['PREVIEW_PICTURE'] : $fields['DETAIL_PICTURE'];
        $img = CFile::GetFileArray($img)['SRC'];

        $price = CCatalogProduct::GetOptimalPrice($fields['ID']);
        $basePrice = CPrice::GetBasePrice($fields['ID']);
        $basePrice['PRICE'] = intval($basePrice['PRICE']);

        $dPage = CIBlockElement::GetByID($fields['ID']) -> GetNext();

        $fields['PREVIEW_TEXT'] = strip_tags($fields['PREVIEW_TEXT']);
        $fields['DETAIL_TEXT'] = strip_tags($fields['DETAIL_TEXT']);
        $fields['PREVIEW_TEXT'] = str_replace(['&ndash;','&lt;','&gt;'], ['-','<','>'], $fields['PREVIEW_TEXT']);
        $fields['DETAIL_TEXT'] = str_replace(['&ndash;','&lt;','&gt;'], ['-','<','>'], $fields['DETAIL_TEXT']);

        # UA
        $text = '';
        if ($Props['DETAIL_TEXT_UA']['VALUE']['TEXT'])
            $text = strip_tags(htmlentities($Props['DETAIL_TEXT_UA']['VALUE']['TEXT']));
        elseif ($Props['DETAIL_TEXT_UA']['VALUE'])
            $text = strip_tags(htmlentities($Props['DETAIL_TEXT_UA']['VALUE']));

        if($colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME_UA'])
            $text .= ' Колір: '.$colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME_UA'].'.';
        elseif($colorRef[$Props['COLOR']['VALUE']]['UF_NAME_UA'])
            $text .= ' Колір: '.$colorRef[$Props['COLOR']['VALUE']]['UF_NAME_UA'].'.';
        if(!empty($sizes))
            $text .= ' Розміри: '.implode(',',$sizes).'.';
        if(!empty($material))
            $text .= ' Матеріал: '.$material.'.';
        if(!empty($sklad))
            $text .= ' Склад: '.$sklad.'. ';

        $text = str_replace('  ',' ',$text);
        # /UA

        # RU
        $textRu = '';
        if ($fields['DETAIL_TEXT'])
            $textRu = strip_tags(htmlentities($fields['DETAIL_TEXT']));

        if($colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME'])
            $textRu .= ' Цвет: '.$colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME'].'.';
        elseif($colorRef[$Props['COLOR']['VALUE']]['UF_NAME'])
            $textRu .= ' Цвет: '.$colorRef[$Props['COLOR']['VALUE']]['UF_NAME'].'.';
        if(!empty($sizes))
            $textRu .= ' Размеры: '.implode(',',$sizes).'.';
        if(!empty($material))
            $textRu .= ' Материал: '.$materialRu.'.';
        if(!empty($sklad))
            $textRu .= ' Состав: '.$skladRu.'. ';

        $textRu = str_replace('  ',' ',$textRu);
        # /RU

        $additionalPhoto = $additionalPhotoTikTok = '';
        if(!empty($Props['PHOTO_GALLERY']['VALUE']))
        {
            foreach ($Props['PHOTO_GALLERY']['VALUE'] as $index => $prop)
            {
                $imgProp = CFile::GetFileArray($prop)['SRC'];
                $additionalPhoto .= '<g:additional_image_link>https://stimma.ua'.$imgProp.'</g:additional_image_link>';

                if(strpos($imgProp,'.m4v') === false)
                    $additionalPhotoTikTok .= '<g:additional_image_link>https://stimma.ua'.$imgProp.'</g:additional_image_link>';
            }

        }

        $obSections = CIBlockSection::GetNavChain(false, $fields['IBLOCK_SECTION_ID'], array('NAME','ID'));
        $chain = [];
        while($arSection = $obSections->Fetch())
        {
            $chain[] = $arSections[$arSection['ID']];
        }
        $chain = implode(' > ',$chain);

        $material = '';
        if($offersProp['MATERIAL']['VALUE_XML_ID'][0])
        {

            //if(isset($name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]]))
                //$offersProp['MATERIAL']['VALUE'][0] = $name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]];
            //$material = '<g:material>'.$offersProp['MATERIAL']['VALUE'][0].'</g:material>';
            $material = '<g:material>'.$material.'</g:material>';
            $materialRu = '<g:material>'.$materialRu.'</g:material>';
        }
        //if($Props['MATERIAL']['VALUE'])
        //    $material = '<g:material>'.$Props['MATERIAL']['VALUE'].'</g:material>';

        $section = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $fields['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','UF_GOOGLE_ID'])->Fetch();
        if(!$section['UF_GOOGLE_ID']) continue;
        $gCat = $Props['GOOGLE_CAT_ID']['VALUE'] ? $Props['GOOGLE_CAT_ID']['VALUE'] : $section['UF_GOOGLE_ID'];

        $nameUA = $Props['GOOGLE_UA_NAME']['VALUE'] ? $Props['GOOGLE_UA_NAME']['VALUE'] : $Props['NAME_UA']['VALUE'];
        $nameRU = $Props['GOOGLE_RU_NAME']['VALUE'] ? $Props['GOOGLE_RU_NAME']['VALUE'] : $fields['NAME'];

        $gPrice = '';
        if($basePrice['PRICE']>$price['RESULT_PRICE']['DISCOUNT_PRICE'])
            $gPrice = '<g:price>'.$basePrice['PRICE'].' UAH</g:price>
		                <g:sale_price>'.$price['RESULT_PRICE']['DISCOUNT_PRICE'].' UAH</g:sale_price>';
        else $gPrice = '<g:price>'.$basePrice['PRICE'].' UAH</g:price>';

        $gPriceFB = '';
        if($basePrice['PRICE']>$price['RESULT_PRICE']['DISCOUNT_PRICE'])
            $gPriceFB = '<g:price>'.round($basePrice['PRICE']/$usdRate, 2).' USD</g:price>
		                <g:sale_price>'.round($price['RESULT_PRICE']['DISCOUNT_PRICE']/$usdRate, 2).' USD</g:sale_price>';
        else $gPriceFB = '<g:price>'.round($basePrice['PRICE']/$usdRate, 2).' USD</g:price>';

        $content .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentFB .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPriceFB.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentRu .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentRuFB .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPriceFB.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';
        $contentTikTok .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhotoTikTok.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentTikTokRu .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhotoTikTok.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$Props['CUSTOM_LABEL_0']['VALUE'].'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

    }

    $footer = '</feed>';
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/google_feed.xml', $header.$content.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/google_feed_ru.xml', $header.$contentRu.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/facebook.xml', $header.$contentFB.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/facebook_ru.xml', $header.$contentRuFB.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tiktok.xml', $header.$contentTikTok.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tiktok_ru.xml', $header.$contentTikTokRu.$footer);

    return 'generateFeedGoogle();';
}

function generateFeedGoogleNew()
{
    global $DB;

    $res = $DB -> Query('select * from max_color_reference');
    while ($record = $res -> Fetch())
        $colorRef[$record['UF_XML_ID']] = $record;

    $usdRate = COption::GetOptionString("my_module", "usd_rate",'41.7');

    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">';
    $header .= '<title>STIMMA</title>';
    $header .= '<link rel="self" href="https://stimma.ua"/>';
    //$header .= '<updated>20011-07-11T12:00:00Z</updated> ';
    $header .= '<updated>'.date('d.m.Y H:i:s').'</updated> ';
    $header .= '<currency code = "UAH" rate = "1" main = "1"/>';

    $mainColors = [];
    $res = $DB -> Query('select * from main_colors');
    while($record = $res -> Fetch())
        $mainColors[$record['UF_XML_ID']] = $record['UF_NAME_UA'];

    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
        require $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';

    $sectionRes = CIBlockSection::GetList([], ['IBLOCK_ID' => 21], false, ['ID','IBLOCK_ID','UF_*']);
    $arSections= $allSections = [];
    while ($rec = $sectionRes -> Fetch())
    {
        $allSections[$rec['ID']] = $rec;
        $arSections[$rec['ID']] = $rec['UF_NAME_UA'];
    }
    $content = $contentRu = $contentFB = $contentRuFB = '';
    $res = CIBlockElement::GetList(['ID'=>'desc'], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y']);

    $counter = 1;

    while ($record = $res -> GetNextElement())
    {
        $fields = $record -> GetFields();
        $Props = $record -> GetProperties();


        if($counter <= 80)
            $Props['CUSTOM_LABEL_0']['VALUE'] = $newCollection = 'new_collection';
        else
            $Props['CUSTOM_LABEL_0']['VALUE'] = $newCollection = '';

        $counter++;

        if(!$allSections[$fields['IBLOCK_SECTION_ID']]['UF_GOOGLE_ID']) continue;

        $offersPropDB = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'PROPERTY_CML2_LINK' => $fields['ID']/*,'!PROPERTY_MATERIAL' => false*/]);

        $sizes = [];
        $material = $sklad = '';

        $available = 'out of stock';
        //$available = 'in stock';

        while ($offersProp = $offersPropDB->GetNextElement())
        {
            $offersFields = $offersProp->GetFields();
            $offersProp = $offersProp->GetProperties();

            $quantity = $DB->Query('select * from b_catalog_product where ID = ' . $offersFields['ID'])->Fetch();
            if($quantity['QUANTITY'] > 0)
                $available = 'in stock';

            if(!$Props['DETAIL_TEXT_UA']['VALUE'] && $offersProp['DETAIL_TEXT_UA']['VALUE'])
                $Props['DETAIL_TEXT_UA']['VALUE'] = $offersProp['DETAIL_TEXT_UA']['VALUE'];

            if(!$fields['DETAIL_TEXT'] && $offersFields['DETAIL_TEXT'])
                $fields['DETAIL_TEXT'] = $offersFields['DETAIL_TEXT'];



            if($offersProp['MATERIAL']['VALUE'][0])
                $materialRu = $offersProp['MATERIAL']['VALUE'][0];
            if($offersProp['SOSTAV']['VALUE'])
                $skladRu = $offersProp['SOSTAV']['VALUE'];
            if($offersProp['RAZMER']['VALUE'])
                $sizes[$offersFields['ID']] = $offersProp['RAZMER']['VALUE'];

            if(isset($name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]]))
                $offersProp['MATERIAL']['VALUE'][0] = $name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]];

            if(isset($name_ua['SOSTAV']['values'][$offersProp['SOSTAV']['VALUE_XML_ID']]))
            {
                $offersProp['SOSTAV']['VALUE'] = $name_ua['SOSTAV']['values'][$offersProp['SOSTAV']['VALUE_XML_ID']];
            }

            if($offersProp['MATERIAL']['VALUE'][0])
                $material = $offersProp['MATERIAL']['VALUE'][0];
            if($offersProp['SOSTAV']['VALUE'])
                $sklad = $offersProp['SOSTAV']['VALUE'];
            if($offersProp['RAZMER']['VALUE'])
                $sizes[$offersFields['ID']] = $offersProp['RAZMER']['VALUE'];
        }

        $img = $fields['PREVIEW_PICTURE'] ? $fields['PREVIEW_PICTURE'] : $fields['DETAIL_PICTURE'];
        $img = CFile::GetFileArray($img)['SRC'];

        $price = CCatalogProduct::GetOptimalPrice($fields['ID']);
        $basePrice = CPrice::GetBasePrice($fields['ID']);
        $basePrice['PRICE'] = intval($basePrice['PRICE']);

        $dPage = CIBlockElement::GetByID($fields['ID']) -> GetNext();

        $fields['PREVIEW_TEXT'] = strip_tags($fields['PREVIEW_TEXT']);
        $fields['DETAIL_TEXT'] = strip_tags($fields['DETAIL_TEXT']);
        $fields['PREVIEW_TEXT'] = str_replace(['&ndash;','&lt;','&gt;'], ['-','<','>'], $fields['PREVIEW_TEXT']);
        $fields['DETAIL_TEXT'] = str_replace(['&ndash;','&lt;','&gt;'], ['-','<','>'], $fields['DETAIL_TEXT']);

        # UA
        $text = '';
        if ($Props['DETAIL_TEXT_UA']['VALUE']['TEXT'])
            $text = strip_tags(htmlentities($Props['DETAIL_TEXT_UA']['VALUE']['TEXT']));
        elseif ($Props['DETAIL_TEXT_UA']['VALUE'])
            $text = strip_tags(htmlentities($Props['DETAIL_TEXT_UA']['VALUE']));

        if($colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME_UA'])
            $text .= ' Колір: '.$colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME_UA'].'.';
        elseif($colorRef[$Props['COLOR']['VALUE']]['UF_NAME_UA'])
            $text .= ' Колір: '.$colorRef[$Props['COLOR']['VALUE']]['UF_NAME_UA'].'.';
        if(!empty($sizes))
            $text .= ' Розміри: '.implode(',',$sizes).'.';
        if(!empty($material))
            $text .= ' Матеріал: '.$material.'.';
        if(!empty($sklad))
            $text .= ' Склад: '.$sklad.'. ';

        $text = str_replace('  ',' ',$text);
        # /UA

        # RU
        $textRu = '';
        if ($fields['DETAIL_TEXT'])
            $textRu = strip_tags(htmlentities($fields['DETAIL_TEXT']));

        if($colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME'])
            $textRu .= ' Цвет: '.$colorRef[$Props['COLOR_REF']['VALUE']]['UF_NAME'].'.';
        elseif($colorRef[$Props['COLOR']['VALUE']]['UF_NAME'])
            $textRu .= ' Цвет: '.$colorRef[$Props['COLOR']['VALUE']]['UF_NAME'].'.';
        if(!empty($sizes))
            $textRu .= ' Размеры: '.implode(',',$sizes).'.';
        if(!empty($material))
            $textRu .= ' Материал: '.$materialRu.'.';
        if(!empty($sklad))
            $textRu .= ' Состав: '.$skladRu.'. ';

        $textRu = str_replace('  ',' ',$textRu);
        # /RU

        $additionalPhoto = $additionalPhotoTikTok = '';
        if(!empty($Props['PHOTO_GALLERY']['VALUE']))
        {
            foreach ($Props['PHOTO_GALLERY']['VALUE'] as $index => $prop)
            {
                $imgProp = CFile::GetFileArray($prop)['SRC'];
                $additionalPhoto .= '<g:additional_image_link>https://stimma.ua'.$imgProp.'</g:additional_image_link>';

                if(strpos($imgProp,'.m4v') === false && strpos($imgProp,'.mp4') === false && strpos($imgProp,'.MP4') === false)
                    $additionalPhotoTikTok .= '<g:additional_image_link>https://stimma.ua'.$imgProp.'</g:additional_image_link>';
            }

        }

        $obSections = CIBlockSection::GetNavChain(false, $fields['IBLOCK_SECTION_ID'], array('NAME','ID'));
        $chain = [];
        while($arSection = $obSections->Fetch())
        {
            $chain[] = $arSections[$arSection['ID']];
        }
        $chain = implode(' > ',$chain);

        $material = '';
        if($offersProp['MATERIAL']['VALUE_XML_ID'][0])
        {

            //if(isset($name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]]))
            //$offersProp['MATERIAL']['VALUE'][0] = $name_ua['MATERIAL']['values'][$offersProp['MATERIAL']['VALUE_XML_ID'][0]];
            //$material = '<g:material>'.$offersProp['MATERIAL']['VALUE'][0].'</g:material>';
            $material = '<g:material>'.$material.'</g:material>';
            $materialRu = '<g:material>'.$materialRu.'</g:material>';
        }
        //if($Props['MATERIAL']['VALUE'])
        //    $material = '<g:material>'.$Props['MATERIAL']['VALUE'].'</g:material>';

        $section = CIBlockSection::GetList([], ['IBLOCK_ID' => 21, 'ID' => $fields['IBLOCK_SECTION_ID']], false, ['ID','IBLOCK_ID','UF_GOOGLE_ID'])->Fetch();
        if(!$section['UF_GOOGLE_ID']) continue;
        $gCat = $Props['GOOGLE_CAT_ID']['VALUE'] ? $Props['GOOGLE_CAT_ID']['VALUE'] : $section['UF_GOOGLE_ID'];

        $nameUA = $Props['GOOGLE_UA_NAME']['VALUE'] ? $Props['GOOGLE_UA_NAME']['VALUE'] : $Props['NAME_UA']['VALUE'];
        $nameRU = $Props['GOOGLE_RU_NAME']['VALUE'] ? $Props['GOOGLE_RU_NAME']['VALUE'] : $fields['NAME'];


        $gPrice = '';
        if($basePrice['PRICE']>$price['RESULT_PRICE']['DISCOUNT_PRICE'])
            $gPrice = '<g:price>'.$basePrice['PRICE'].' UAH</g:price>
		                <g:sale_price>'.$price['RESULT_PRICE']['DISCOUNT_PRICE'].' UAH</g:sale_price>';
        else $gPrice = '<g:price>'.$basePrice['PRICE'].' UAH</g:price>';

        $gPriceFB = '';
        if($basePrice['PRICE']>$price['RESULT_PRICE']['DISCOUNT_PRICE'])
            $gPriceFB = '<g:price>'.round($basePrice['PRICE']/$usdRate, 2).' USD</g:price>
		                <g:sale_price>'.round($price['RESULT_PRICE']['DISCOUNT_PRICE']/$usdRate, 2).' USD</g:sale_price>';
        else $gPriceFB = '<g:price>'.round($basePrice['PRICE']/$usdRate, 2).' USD</g:price>';

        if(!empty($sizes))
        {
            foreach ($sizes as $sizeID => $size)
            {


                if($quantity['QUANTITY'] > 0)
                $content .= '
            <entry>
		<g:item_group_id>'.$fields['ID'].'</g:item_group_id>
		<g:id>'.$sizeID.'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:size>'.$size.'</g:size>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';
                if($quantity['QUANTITY'] > 0)
                $contentRu .= '
            <entry>
		<g:item_group_id>'.$fields['ID'].'</g:item_group_id>
		<g:id>'.$sizeID.'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:size>'.$size.'</g:size>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';
            }
        }
        else
        {
            if($quantity['QUANTITY'] > 0)
            $content .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';
            if($quantity['QUANTITY'] > 0)
            $contentRu .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';
        }

        $contentFB .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPriceFB.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentRuFB .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhoto.'
		<g:availability>'.$available.'</g:availability>
		'.$gPriceFB.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentTikTok .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameUA.'</g:title>
		<g:description><![CDATA['.$text.']]></g:description>
		<g:link>https://stimma.ua'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhotoTikTok.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$material.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        $contentTikTokRu .= '
            <entry>
		<g:id>'.$fields['ID'].'</g:id>
		<g:title>'.$nameRU.'</g:title>
		<g:description><![CDATA['.$textRu.']]></g:description>
		<g:link>https://stimma.ua/ru'.$dPage['DETAIL_PAGE_URL'].'</g:link>
		<g:image_link>https://stimma.ua'.$img.'</g:image_link>
		'.$additionalPhotoTikTok.'
		<g:availability>'.$available.'</g:availability>
		'.$gPrice.'
		<g:product_type>'.$chain.'</g:product_type>
		<g:brand>STIMMA</g:brand>
		<g:identifier_exists>no</g:identifier_exists>
		<g:condition>new</g:condition>
		<g:color>'.$mainColors[$Props['COLOR']['VALUE']].'</g:color>
		<g:google_product_category>'.$gCat.'</g:google_product_category>
		'.$materialRu.'
		<g:custom_label_0>'.$newCollection.'</g:custom_label_0>
		<g:custom_label_1>'.$Props['CUSTOM_LABEL_1']['VALUE'].'</g:custom_label_1>
		<g:custom_label_2>'.$Props['CUSTOM_LABEL_2']['VALUE'].'</g:custom_label_2>
	</entry>
            ';

        /*if($fields['ID'] == '48703')
        {
            ?><xmp><?=print_r($content, 1)?></xmp><?
            die('--');
        }*/
    }

    $footer = '</feed>';
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/google_feed.xml', $header.$content.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/google_feed_ru.xml', $header.$contentRu.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/facebook.xml', $header.$contentFB.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/facebook_ru.xml', $header.$contentRuFB.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tiktok.xml', $header.$contentTikTok.$footer);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tiktok_ru.xml', $header.$contentTikTokRu.$footer);

    return 'generateFeedGoogleNew();';
}

/*
AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");
function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
{
    global $USER;
    if(!$USER->IsAdmin())
        return;

    $aMenu = array(
        "parent_menu" => "global_menu_content",
        "section" => "clouds",
        "sort" => 150,
        "text" => 'Новинки',
        "title" => 'Новинки',
        "url" => "clouds_index.php?lang=".LANGUAGE_ID,
        "icon" => "clouds_menu_icon",
        "page_icon" => "clouds_page_icon",
        "items_id" => "menu_clouds",
        "more_url" => array(
            "clouds_index.php",
        ),
        "items" => array()
    );

    $aMenu["items"][] = array(
        "text" => 'Новинки',
        "url" => "new.php",
        "more_url" => array(
            "complect.php",
        ),
        "title" => "",
        "page_icon" => "clouds_page_icon",
        "items_id" => "menu_clouds_bucket_",
        "module_id" => "clouds",
        "items" => array()
    );


    if(!empty($aMenu["items"]))
        $aModuleMenu[] = $aMenu;
}
*/


function generateXMLs()
{
    global $DB;
    $faceBookContent[] = ['id','title','description','availability','condition','price','link','image_link','brand'];
    $mainColors = [];
    $res = $DB -> Query('select * from main_colors');
    while($record = $res -> Fetch())
        $mainColors[$record['UF_XML_ID']] = $record['UF_NAME'];
    $headerYML = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
    $headerYML .= '<yml_catalog date="'.date('Y-d-m H:i').'">';
    $headerYML .= '<shop>';
    $headerYML .= '<name>STIMMA</name><company>Швейная компания СТИММА</company><url>https://stimma.ua/</url>';
    $headerYML .= '<currencies>	<currency id="UAH" rate="1"/>	<currency id="USD" rate="NBU" />	<currency id="RUB" rate="CBRF" />	<currency id="EUR" rate="NBU" /></currencies>';

    $contentYML = '';

    $footerYml ='</shop></yml_catalog>';

    $contentYML .= '<categories>';
    $res = CIBlockSection::GetList(['DEPTH_LEVEL' => 'asc'], ['IBLOCK_ID' => 21,'ACTIVE' => 'Y']);
    $sections = [];
    while ($record = $res->Fetch())
    {
        $sections[$record['ID']] = $record;
        $contentYML .= '<category id="'.$record['ID'].'"';
        if($record['IBLOCK_SECTION_ID'])
            $contentYML.= ' parentId="'.$record['IBLOCK_SECTION_ID'].'"';

        $contentYML .= '>'.$record['NAME'].'</category>';
    }
    $contentYML .= '</categories>';

    $contentYML .= '<offers>';
    $products = [];
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21,'ACTIVE' => 'Y'], false, false,
                                   ['ID', 'IBLOCK_ID','IBLOCK_SECTION_ID','CODE','PREVIEW_PICTURE','PREVIEW_TEXT','DETAIL_TEXT','PROPERTY_MODEL','PROPERTY_COLOR']);
    while ($record = $res -> Fetch())
    {
        $products[$record['ID']] = $record;
    }
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25,'ACTIVE' => 'Y'], false, false,
                                   ['ID', 'IBLOCK_ID','NAME','PREVIEW_TEXT','DETAIL_TEXT','PROPERTY_CML2_LINK','PROPERTY_RAZMER','PROPERTY_VID','PROPERTY_MATERIAL','PROPERTY_SOSTAV']);
    while ($record = $res -> Fetch())
    {
        if(!isset($products[$record['PROPERTY_CML2_LINK_VALUE']])) continue;
        $products[$record['PROPERTY_CML2_LINK_VALUE']]['OFFERS'][$record['ID']] = $record;
    }
    foreach ($products as $index => $product)
    {
        $link = 'https://stimma.ua/catalog/'.$sections[$product['IBLOCK_SECTION_ID']]['CODE'].'/';
        if($sections[$product['IBLOCK_SECTION_ID']]['IBLOCK_SECTION_ID'])
            $link .= $sections[$sections[$product['IBLOCK_SECTION_ID']]['IBLOCK_SECTION_ID']]['CODE'].'/';
        $link .= $product['CODE'].'/';
        $img = CFile::GetFileArray($product['PREVIEW_PICTURE'])['SRC'];
        $text = $product['PREVIEW_TEXT'] ? $product['PREVIEW_TEXT'] : $product['DETAIL_TEXT'];

        $picture = '<picture>https://stimma.ua'.$img.'</picture>';
        $faceBookImg = $picture;
        $resPicture = $DB -> Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $product['ID'] . ' and IBLOCK_PROPERTY_ID = 239');
        while ($record = $resPicture -> Fetch())
        {
            $img = CFile::GetFileArray($record['VALUE'])['SRC'];
            $picture .= '<picture>https://stimma.ua'.$img.'</picture>';
        }

        foreach ($product['OFFERS'] as $indexOffer => $arItem)
        {
            $price = CCatalogProduct::GetOptimalPrice($arItem['ID'])['RESULT_PRICE'];

            $cost = $DB -> Query('select * from b_catalog_price where CATALOG_GROUP_ID = 3 and PRODUCT_ID = ' . $arItem['ID']);
            if($cost = $cost -> Fetch())
            {
                if($cost['PRICE'] > 0)
                    $cost = '<cost>'.intval($cost['PRICE']).'</cost>';
            }
            else
                $cost = '';

            if(!$text)
                $text = $arItem['PREVIEW_TEXT'] ? $arItem['PREVIEW_TEXT'] : $arItem['DETAIL_TEXT'];
            $contentYML .= '<offer id="'.$arItem['ID'].'" available="true" group_id="'.$arItem['PROPERTIES']['CML2_LINK']['VALUE'].'">
                                <url>'.$link.'</url>
                                <price>'.$price['DISCOUNT_PRICE'].'</price>
                                '.$cost.'
                                <currencyId>UAH</currencyId>
                                <categoryId>'.$product['IBLOCK_SECTION_ID'].'</categoryId>
                                '.$picture.'
                                <name>'.addslashes($arItem['NAME']).'</name>
                                <vendor>STIMMA</vendor>
                                <vendorCode>'.$product['PROPERTY_MODEL_VALUE'].'</vendorCode>
                                <description><![CDATA['.$text.']]> </description>
                                <country_of_origin>Украина</country_of_origin>
                                <param name="Размер">'.$arItem['PROPERTY_RAZMER_VALUE'].'</param>
                                <param name="Цвет">'.$mainColors[$product['PROPERTY_COLOR_VALUE']].'</param>
                                <param name="Бренд">STIMMA</param>
                                <param name="Вид">'.$arItem['PROPERTY_VID_VALUE'].'</param>
                                <param name="Страна">Украина</param>
                                <param name="Материал">'.$arItem['PROPERTY_MATERIAL_VALUE'].'</param>
                                <param name="Состав">'.$arItem['PROPERTY_SOSTAV_VALUE'].'</param>
                                <param name="Производитель">STIMMA</param>
                                </offer>';

            $faceBookContent[] = [$arItem['ID'],addslashes($arItem['NAME']),$text,'в наявності','новий',$price['DISCOUNT_PRICE'],$link,$faceBookImg,'STIMMA'];
        }
    }

    $contentYML .= '</offers>';

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/export.yml', $headerYML.$contentYML.$footerYml);

    $file = fopen($_SERVER['DOCUMENT_ROOT'].'/upload/facebook.csv', 'w');
    foreach($faceBookContent as $index => $item)
        fputcsv($file, $item);
    fclose($file);

    return 'generateXMLs();';
}


AddEventHandler("main", "OnEndBufferContent", "clearEmpty");
function clearEmpty(&$content)
{
    global $minGlobalPrice,$maxGlobalPrice,$USER,$APPLICATION;

    $bIndex = (strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false) || isset($_GET['google']);

    if(!$minGlobalPrice) $minGlobalPrice = '';
    if(!$maxGlobalPrice) $maxGlobalPrice = '';

    $content = str_replace('"/catalog/"', '"/catalog/novinki/"', $content);
    //$content = str_replace('\'/catalog/\'', '\'/catalog/novinki/\'', $content);
    $content = str_replace('"/ru/catalog/"', '"/ru/catalog/novinki/"', $content);
    $content = str_replace('2025', date('Y'), $content);
    $content = str_replace('2025', date('Y'), $content);
    $content = str_replace('', $minGlobalPrice, $content);
    $content = str_replace('', $maxGlobalPrice, $content);

    if(!$USER->IsAdmin())
    {
        //$content = preg_replace('/.*BX\.setJSList.*\n?/', '', $content);
        //$content = preg_replace('/.*BX\.setCSSList.*\n?/', '', $content);
        //$content = preg_replace('/.*search\.title\/script\.js.*\n?/', '', $content);
        //$content = preg_replace('/(<link\b[^>]*href="[^"]*template_styles\.css[^"]*"[^>]*)rel="stylesheet"([^>]*>)/', '$1rel="preload" as="style"$2',$content);
        //$content = preg_replace('/.*\/bitrix\/templates\/stimma\/themes\/1\/theme.css.*/', '',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/templates/stimma/js/observer.js','<script type="text/javascript" defer src="/bitrix/templates/stimma/js/observer.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/templates/stimma/vendor/js/sticky-sidebar.js','<script type="text/javascript" defer src="/bitrix/templates/stimma/vendor/js/sticky-sidebar.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/templates/stimma/js/jquery.validate.min.js','<script type="text/javascript" defer src="/bitrix/templates/stimma/js/jquery.validate.min.js',$content);

        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/core/core_ls.js','<script type="text/javascript" defer src="/bitrix/js/main/core/core_ls.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/templates/stimma/components/bitrix/search.title/mega_menu/script.js','<script type="text/javascript" defer src="/bitrix/templates/stimma/components/bitrix/search.title/mega_menu/script.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/templates/stimma/components/bitrix/search.title/fixed/script.js','<script type="text/javascript" defer src="/bitrix/templates/stimma/components/bitrix/search.title/fixed/script.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/ajax.js','<script type="text/javascript" defer src="/bitrix/js/main/ajax.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/pageobject/pageobject.js','<script type="text/javascript" defer src="/bitrix/js/main/pageobject/pageobject.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/core/core_window.js','<script type="text/javascript" defer src="/bitrix/js/main/core/core_window.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/popup/dist/main.popup.bundle.js','<script type="text/javascript" defer src="/bitrix/js/main/popup/dist/main.popup.bundle.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/currency/currency-core/dist/currency-core.bundle.js','<script type="text/javascript" defer src="/bitrix/js/currency/currency-core/dist/currency-core.bundle.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/currency/core_currency.js','<script type="text/javascript" defer src="/bitrix/js/currency/core_currency.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/date/main.date.js','<script type="text/javascript" defer src="/bitrix/js/main/date/main.date.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/core/core_date.js','<script type="text/javascript" defer src="/bitrix/js/main/core/core_date.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/fileman/sticker.js','<script type="text/javascript" defer src="/bitrix/js/fileman/sticker.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/core/core_admin.js','<script type="text/javascript" defer src="/bitrix/js/main/core/core_admin.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/utils.js','<script type="text/javascript" defer src="/bitrix/js/main/utils.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/hot_keys.js','<script type="text/javascript" defer src="/bitrix/js/main/hot_keys.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/admin_tools.js','<script type="text/javascript" defer src="/bitrix/js/main/admin_tools.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/popup_menu.js','<script type="text/javascript" defer src="/bitrix/js/main/popup_menu.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/admin_search.js','<script type="text/javascript" defer src="/bitrix/js/main/admin_search.js',$content);
        //$content = str_replace('<script type="text/javascript" src="/bitrix/js/main/public_tools.js','<script type="text/javascript" defer src="/bitrix/js/main/public_tools.js',$content);

        //$content = str_replace('defer','',$content);
        //$content = str_replace('<script','<script defer',$content);
    }

    //if($bIndex && strpos($APPLICATION -> GetCurPage(), '/bitrix/') === false)
    if($bIndex && strpos($APPLICATION -> GetCurPage(), '/bitrix/') === false)
    {
        $content = preg_replace('/<script[^<\+]*?.*?<\/script>/usmi', '', $content);

        $content = preg_replace('/<script[^<]*?cdn\.bitrix24\.com.*?<\/script>/usmi', '', $content);
        $content = preg_replace('/<script[^<]*?tag\.js.*?<\/script>/usmi', '', $content);

        $content = preg_replace('/.*\/core\/core.js.*/', '', $content);

        $content = preg_replace('/.*\/stimma\/styles.css.*/', '', $content);
        $content = preg_replace('/.*\/stimma\/template_styles.css.*/', '', $content);
        //$content = preg_replace('/.*\/style.css.*/', '', $content);
        //$content = preg_replace('/.*\/styles.css.*/', '', $content);
        //$content = preg_replace('/.*\/media.css.*/', '', $content);
        //$content = preg_replace('/.*\/bootstrap.css.*/', '', $content);
        //$content = preg_replace('/.*\/stores.css.*/', '', $content);
        //$content = preg_replace('/.*\/jquery.mCustomScrollbar.min.css.*/', '', $content);

        $content = preg_replace('/.*\/css\/core.css.*/', '', $content);
        $content = preg_replace('/.*\/ui.font.opensans.css.*/', '', $content);
        $content = preg_replace('/.*\/main.popup.bundle.css.*/', '', $content);
        $content = preg_replace('/.*\/core_date.css.*/', '', $content);
        $content = preg_replace('/.*\/window.css.*/', '', $content);
        $content = preg_replace('/.*\/slick.css.*/', '', $content);
        $content = preg_replace('/.*\/select2.min.css.*/', '', $content);
        $content = preg_replace('/.*\/jquery.fancybox.css.*/', '', $content);
        $content = preg_replace('/.*\/jquery.fancybox-buttons.css.*/', '', $content);
        $content = preg_replace('/.*\/jquery.fancybox-thumbs.css.*/', '', $content);
        $content = preg_replace('/.*\/slick-theme.css.*/', '', $content);
        $content = preg_replace('/.*\/theme.css.*/', '', $content);
        $content = preg_replace('/.*\/pygments.css.*/', '', $content);
        $content = preg_replace('/.*\/easyzoom.css.*/', '', $content);
        $content = preg_replace('/.*\/colored.css.*/', '', $content);
        $content = preg_replace('/.*\/blocks.css.*/', '', $content);
        $content = preg_replace('/.*\/menu.css.*/', '', $content);
        $content = preg_replace('/.*\/yandex_map.css.*/', '', $content);
        $content = preg_replace('/.*\/buy_services.css.*/', '', $content);
        $content = preg_replace('/.*\/buy_services.css.*/', '', $content);
        $content = preg_replace('/.*\/left_block_main_page.css.*/', '', $content);
        $content = preg_replace('/.*\/ripple.css.*/', '', $content);
        $content = preg_replace('/.*\/ajax.css.*/', '', $content);
        $content = preg_replace('/.*\/font-10.css.*/', '', $content);
        $content = preg_replace('/.*\/h1-bold.css.*/', '', $content);
        $content = preg_replace('/.*\/header_fixed.css.*/', '', $content);
        $content = preg_replace('/.*\/round-elements.css.*/', '', $content);
        $content = preg_replace('/.*\/width-3.css.*/', '', $content);
        $content = preg_replace('/.*\/counter-state.css.*/', '', $content);
        $content = preg_replace('/.*\/dark-light-theme.css.*/', '', $content);
        $content = preg_replace('/.*\/jquery-ui.theme.min.css.*/', '', $content);
        $content = preg_replace('/.*\/jquery-ui.min.css.*/', '', $content);
        $content = preg_replace('/.*\/css\/montserrat.min.css.*/', '', $content);
        $content = preg_replace('/.*\/css\/custom.css.*/', '', $content);
        $content = preg_replace('/.*\/css\/print.css.*/', '', $content);
        //$content = preg_replace('/.*\/blue\/style.css.*/', '', $content);
        //$content = preg_replace('/.*\/css\/styles.css.*/', '', $content);



        //$content = preg_replace('/.*\/widget\/styles.min.css.*/', '', $content);

        //$content = str_replace('<img','<img width="200" height="200" ',$content);

        if($bIndex)
        {
            //Bitrix\Main\Diag\Debug::writeToFile($content, "content" , '/___speed.txt');
        }



        //$content = preg_replace('/\s{2,}/', ' ',$content);
    }

    preg_match_all('/<link\s+rel="canonical".*?\/>/', $content, $matches);

    // Если найдено больше одного каноникала — удалим все, кроме первого
    if (count($matches[0]) > 1) {
        // Удалим все кроме первого
        for ($i = 1; $i < count($matches[0]); $i++) {
            $content = str_replace($matches[0][$i], '', $content);
        }
    }

     //  Заменяем год
    $content = str_replace('{year}', date('Y'), $content);

}
/*
function convertToWebP($source, $destination, $quality = 80) {
    // Проверьте, существует ли исходный файл
    if (!file_exists($source)) {
       return false;
    }

    // Получите информацию об изображении
    $info = getimagesize($source);
    $mime = $info['mime'];

    $result = false;

    // Создайте изображение на основе типа MIME
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            $result = true;
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            $result = true;
            break;
        default:
            break;
    }
    if($result)
    {
        imagewebp($image, $destination, $quality);
        imagedestroy($image);
    }

    return $result;
}
*/

// Пример использования
//$source = 'path/to/your/image.jpg';
//$destination = 'path/to/your/image.webp';
//convertToWebP($source, $destination);
function getInstagramPhotos()
{

    //$accessToken = COption::GetOptionString('main', 'insta_token', 'IGQVJWVDVqd0dUdnYteFNvTWJmbDJ3NGo1TTJkVGcwWnZASc212bDVnMW9FdVNkTlZAMVDdNUnlpMlRFZA3RuSnFWbS1QLXdvd2VLSlE4ZAzhJek9TaVV3UlRvbUFvWUFBYUxDOGZAJVHE4UnV0OEw5RXk3MwZDZD');
    $accessToken = COption::GetOptionString('main', 'insta_token', 'IGQWROQU9CUDVXdmI5LXR1TDlCb3QtX3Npa3lpZAGVTbC1vakpkX3dpOVpxc0JZAdDMyTkRWRmFZAVkZAiTjRaS1lHRUk5ckJFckplS0RIVlM4cVVrdEpRaTI5eW55dWVHRmpkT3JOS1k3UnV1ZA0V0R1loQndVSVEyWW8ZD');

    // todo якшо токен созданий менше як 60 днів.. то не получиться обновить

    $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $accessToken;
    $instagramCnct = curl_init(); // инициализация cURL подключения
    curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
    curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
    $media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
    curl_close($instagramCnct); // закрываем соединение

    if(!isset($media -> data))
    {
        $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken;

       $instagramCnct = curl_init(); // инициализация cURL подключения
       curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
       curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
       $response = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
       curl_close($instagramCnct); // закрываем соединение

       // обновляем токен и дату его создания в базе

       $accessToken = $response->access_token; // обновленный токен
        COption::SetOptionString('main', 'insta_token', $accessToken);

        $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink&access_token=" . $accessToken;
        $instagramCnct = curl_init(); // инициализация cURL подключения
        curl_setopt($instagramCnct, CURLOPT_URL, $url); // адрес запроса
        curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1); // просим вернуть результат
        $media = json_decode(curl_exec($instagramCnct)); // получаем и декодируем данные из JSON
        curl_close($instagramCnct); // закрываем соединение
    }

    $ar = $ids = [];
    foreach ($media -> data as $index => $datum)
    {
        $ar[$datum -> id] = [
            'id' => $datum -> media_url,
            'photo' => $datum -> media_url,
            'link' => $datum->permalink,
            'timestamp_x' => strtotime($datum->timestamp),
        ];
        $ids[$datum -> id] = strtotime($datum->timestamp);
    }

    asort($ids);

    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 36, 'NAME' => array_keys($ar)]);
    while ($record = $res -> Fetch())
        unset($ar[$record['NAME']]);

    //ksort($ar);
    $el = new CIBlockElement();
    foreach ($ids as $id => $item)
    {
        if(!isset($ar[$id])) continue;

        $el -> Add(
            [
                "IBLOCK_ID" => 36,
                "NAME"           => $id,
                "ACTIVE"         => "Y",
                "PREVIEW_TEXT"   => $ar[$id]['link'],
                "PREVIEW_PICTURE" => CFile::MakeFileArray($ar[$id]['photo'])
            ]
        );
    }

    return 'getInstagramPhotos();';
}

/*\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderSaved',
    'sendSmsToClient'
);*/

function sendOrderToB24()
{
    Bitrix\Main\Diag\Debug::writeToFile('1 - start sendOrderToB24', "debug_b24 " , '/debug_b24.txt');
    $idsToB24 = COption::GetOptionString('main', 'order_ro_b24', '');
    $idsToB24 = explode(',',$idsToB24);
    $idsToB24[0] = 840;
    if(isset($idsToB24[0]) && $idsToB24[0] > 0)
    {
        global $DB;
        Bitrix\Main\Diag\Debug::writeToFile($idsToB24[0], "2 - send ".$idsToB24[0] , '/debug_b24.txt');
        $orderID = $idsToB24[0];
        //require $_SERVER['DOCUMENT_ROOT'].'/b24_new/index.php';

        require($_SERVER['DOCUMENT_ROOT']."/b24_new/include/config.php");

        $props = $basket = [];

        $order = $DB -> Query('select * from b_sale_order where ID = ' . $orderID) -> Fetch();
        $user = CUser::GetByID($order['USER_ID']) -> Fetch();
        $userGroups = CUser::GetUserGroup($order['USER_ID']);

        $isOptUser = in_array(9, $userGroups);
        $isDropShip = in_array(11, $userGroups);
        $isRozdrib = !$isOptUser && !$isDropShip;

        global $DB;

        $colorRef = [];
        $res = $DB -> Query('select * from max_color_reference');
        while ($record = $res -> Fetch())
            $colorRef[$record['UF_XML_ID']] = $record;

        $res = $DB -> Query('select * from b_sale_basket where ORDER_ID = ' . $orderID);
        $relationIDsB24 = [];
        while ($record = $res -> Fetch())
        {
            $basket[] = $record;

            $Product = CIBlockElement::GetByID($record['PRODUCT_ID'])->GetNextElement();
            $ProductProps = $Product->GetProperties();
            $ProductFields = $Product->GetFields();
            $price = CCatalogProduct::GetOptimalPrice($ProductFields['ID'])['RESULT_PRICE']['DISCOUNT_PRICE'];
            $productIDB24 = $ProductProps['BX_ID']['VALUE'];

            # Добавляем товар если нет кода
            if (!$productIDB24)
            {
                // добавление нового товара start
                $arFieldsProductAdd = array(
                    "fields" => array(
                        "NAME" => $ProductFields['NAME'],
                        "CURRENCY_ID" => "UAH",
                        "PRICE" => $price,
                        "PROPERTY_100" => (string)$colorRef[$ProductProps['COLOR_REF']['VALUE_XML_ID'][0]]['UF_NAME'], // цвет
                        "PROPERTY_102" => (string)$ProductProps['RAZMER']['VALUE'], // размер
                        "PROPERTY_104" => $ProductFields['ID'], // id на сайте
                        "PROPERTY_106" => (string)$ProductProps['MATERIAL']['VALUE'][0], // материал
                        "MEASURE" => 9
                    )
                );
                while (1) {
                    $arProductAddResult = call("crm.product.add", $arFieldsProductAdd, true);
                    if ($arProductAddResult['STATUS'] == 200) break;
                }
                CIBlockElement::SetPropertyValuesEx($ProductFields['ID'], false, array('BX_ID' => $arProductAddResult['result']));
                echo "Добавлен товар с ID: ".$arProductAddResult['result'];
                // добавление нового товара end
            }
            else
                $relationIDsB24[$record['PRODUCT_ID']] = [
                    'BX_ID' => $productIDB24
                ];
            # /Добавляем товар если нет кода
        }

        $res = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = ' . $orderID);
        while ($record = $res -> Fetch())
            $props[$record['CODE']] = $record;

        # Начало передачи в Битрикс24
        $arProducts              = [];
        $arOrderProductsAll      = [];
        $arProductsListResultAll = [];
        foreach ($basket as $item)
            $arOrderProductsAll[] = (string)$item['PRODUCT_ID'];
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arOrderProductsAll, true), FILE_APPEND);
        $steps = ceil(count($arOrderProductsAll) / 50);
        for ($i = 0; $i < $steps; $i++)
        {
            $arOrderProductsStep = array_slice($arOrderProductsAll, $i, 50);
            array_splice($arOrderProductsAll, $i, 49);
            $arFieldsProductList = ["order" => ["NAME" => "ASC"], "filter" => ["PROPERTY_104" => $arOrderProductsStep], "select" => ["ID", "NAME", "CURRENCY_ID", "PRICE", "PROPERTY_*"]];
            while (1)
            {
                $arProductListResult = call("crm.product.list", $arFieldsProductList, true);
                if ($arProductListResult['STATUS'] != 503)
                    break;
            }

            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arOrderProductsStep, true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductListResult.txt', print_r($arProductListResult, true), FILE_APPEND);
            foreach ($arProductListResult['result'] as $key => $arProductB24)
            {
                foreach ($basket as $obProduct)
                {
                    $id = (string)$obProduct['PRODUCT_ID'];
                    if ($arProductB24['PROPERTY_104']['value'] == $id)
                    {
                        $arProductListResult['result'][$key]['QUANTITY'] = (string)$obProduct['QUANTITY'];
                        $arProductListResult['result'][$key]['NAME']     = (string)$obProduct['NAME'];
                        if ($arProductB24['PRICE'] != (string)$obProduct['PRICE'])
                        {
                            $arProductListResult['result'][$key]['PRICE'] = (string)$obProduct['PRICE'];
                        }
                    }
                }
            }
            $arProductsListResultAll = array_merge($arProductsListResultAll, $arProductListResult['result']);
        }
        $new = [];
        foreach ($arProductsListResultAll as $index => $item)
            $new[$item['PROPERTY_104']['value']] = $item;

        $arProductsListResultAll = array_values($new);

        $phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$props['PHONE']['VALUE']);
        $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
        $arFilter = (string)$props['PHONE']['VALUE'] ? ["PHONE" => $phone_tmp] : ["EMAIL" => (string)$props['EMAIL']['VALUE']];

        $arContactsParams = ["order" => ["ID" => "ASC"], "filter" => $arFilter, "select" => ["ID", "EMAIL", "UF_CRM_1521453922", "ASSIGNED_BY_ID", "PHONE", "TYPE_ID"]];
        while (1)
        {
            $arContactsResult = call("crm.contact.list", $arContactsParams, true);
            if ($arContactsResult['STATUS'] == 200)
                break;
        }
        // поиск контакта end
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arContactsResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arContactsResult.txt', print_r($arContactsResult, true), FILE_APPEND);
        // якшо знайшло користувача
        if (count($arContactsResult['result']) > 0)
        {
            // поиск сделки start
            $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" =>$orderID], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
            while (1)
            {
                $arDealListResult = call("crm.deal.list", $arFieldsDealsList, true);
                if ($arDealListResult['STATUS'] == 200)
                    break;
            }
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arDealListResult, true), FILE_APPEND);
            // поиск сделки end
            if (empty($arDealListResult['result']))
            {
                // Массив соответствия тип клиента/направление сделки
                $arClientDealCategory = ["CLIENT"   => 0,      // Розничный покупатель
                                         "SUPPLIER" => 2,    // Дропшипер
                                         1          => 4,             // Оптовый покупатель
                ];
                // Массив соответствия тип клиента/статус сделки
                $arClientDealSatus = ["CLIENT"   => "NEW",      // Розничный покупатель
                                      "SUPPLIER" => "C2:NEW",    // Дропшипер
                                      1          => "C4:NEW",             // Оптовый покупатель
                ];
                // создание сделки существующего контакта start
                $arDealParams = ["fields" => ["CATEGORY_ID" => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealCategory[$arContactsResult['result'][0]["TYPE_ID"]] : 0, "TITLE" => "Замовлення № " . $orderID, "TYPE_ID" => "SALE", // "STAGE_ID" => "NEW",
                                              "STAGE_ID"    => $arContactsResult['result'][0]["TYPE_ID"] ? $arClientDealSatus[$arContactsResult['result'][0]["TYPE_ID"]] : "NEW", "CONTACT_ID" => $arContactsResult['result'][0]['ID'], "OPENED" => "Y", "ASSIGNED_BY_ID" => $arContactsResult['result'][0]['ASSIGNED_BY_ID'], "CURRENCY_ID" => 'UAH', "OPPORTUNITY" => $order['PRICE'], "BEGINDATE" => date_format(date_create($order['DATE_INSERT']), 'd.m.Y'), "UF_CRM_1523544904" => $orderID, // ID замовлення на сайтi
                                              "COMMENTS"    => $order['USER_DESCRIPTION'] // комментарий
                ]];
                while (1)
                {
                    $arDealResult = call("crm.deal.add", $arDealParams, true);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealResult, true).PHP_EOL, FILE_APPEND);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealParams, true).PHP_EOL, FILE_APPEND);
                    if ($arDealResult['STATUS'] == 200)
                        break;
                }
                // создание сделки существующего контакта end
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arJSON['id']." - ".$arDealResult['STATUS']."\n", true), FILE_APPEND);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arDealResult['result']."\n", true), FILE_APPEND);
                if ($arDealResult['result'] > 0)
                {
                    // добавление товаров в созданную сделку start
                    foreach ($arProductsListResultAll as $key => $arProduct)
                    {
                        $arProducts[] = ["PRODUCT_ID" => $arProduct['ID'], "PRICE" => $arProduct['PRICE'], "QUANTITY" => $arProduct['QUANTITY'], "PRODUCT_NAME" => $arProduct['NAME']];
                    }
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                    Bitrix\Main\Diag\Debug::writeToFile($arDealResult['result'] , "3 - order (1) " , '/debug_b24.txt');
                    Bitrix\Main\Diag\Debug::writeToFile($arProducts, "4 - order (1) " , '/debug_b24.txt');
                    $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts,];
                    while (1)
                    {
                        // Додаємо товари в замовлення
                        $arDealRowsAddResult = call("crm.deal.productrows.set", $arDealRowsAddParams, true);
                        if ($arDealRowsAddResult['STATUS'] == 200)
                            break;
                    }
                    // добавление товаров в созданную сделку end
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arDealRowsAddResult, true), FILE_APPEND);
                }
            }
        }
        else
        {
            // якшо НЕ знайшло користувача
            // Создание контакта и сделки start
            $newManagerID   = 114; // ответственный  менеджер Настя Морозецька - роздріб - ID 114
            $contact_result = ['result' => false];
            //Создание контакта start
            //$phone_tmp          = preg_replace('~[^0-9]+~', '', $props['PHONE']['VALUE']);
            $phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$props['PHONE']['VALUE']);
            $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
            $arFieldsContactAdd = ["fields" => ["OPENED"            => 'Y', "EXPORT" => 'Y', "TYPE_ID" => 'CLIENT', // категория клиента (оптовик, розничный покупатель)
                                                "SOURCE_ID"         => "WEB", "NAME" => $props['NAME']['VALUE'], // Имя
                                                "LAST_NAME"         => $props['NAME']['LASTNAME'], // Фамилия
                                                "PHONE"             => $phone, // Телефон
                                                "EMAIL"             => [["VALUE" => $props['EMAIL']['VALUE'], "VALUE_TYPE" => "WORK"]], // Email
                                                "UF_CRM_1521453922" => 0, //$arJSON['user_id'], // ID на сайте
                                                "ASSIGNED_BY_ID"    => $newManagerID, // ответственный
            ]];
            echo 'try to add contact';
            while (1)
            {
                $contact_result = call("crm.contact.add", $arFieldsContactAdd, true);
                if ($contact_result['STATUS'] == 200)
                    break;
            }
            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arNewContactReult.txt', print_r($contact_result, true), FILE_APPEND);
            //Создание контакта end
            // Созданиесделки start
            if ($contact_result['result'] && $contact_result['result'] > 0)
            {
                // поиск сделки start
                $arFieldsDealsList = ["order" => ["ID" => "ASC"], "filter" => ["UF_CRM_1523544904" => $orderID], "select" => ["ID", "NAME", "UF_CRM_1523544904"]];
                while (1)
                {
                    $arDealListResult = call("crm.deal.list", $arFieldsDealsList, true);
                    if ($arDealListResult['STATUS'] == 200)
                        break;
                }
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealListResult.txt', print_r($arDealListResult, true), FILE_APPEND);
                // поиск сделки end
                if (empty($arDealListResult['result']))
                {
                    // Массив соответствия тип клиента/направление сделки
                    $arClientDealCategory = ["CLIENT"   => 0,      // Розничный покупатель
                                             "SUPPLIER" => 2,    // Дропшипер
                                             1          => 4,             // Оптовый покупатель
                    ];
                    // создание сделки существующего контакта start
                    $arDealParams = ["fields" => ["CATEGORY_ID" => $arClientDealCategory["CLIENT"],
                                                  "TITLE" => "Замовлення № " . $orderID,
                                                  "TYPE_ID" => "SALE",
                                                  "STAGE_ID" => "NEW",
                                                  "CONTACT_ID" => $contact_result['result'],
                                                  "OPENED" => "Y",
                                                  "ASSIGNED_BY_ID" => $newManagerID,
                                                  "CURRENCY_ID" => 'UAH',
                                                  "OPPORTUNITY" => $order['PRICE'],
                                                  "BEGINDATE" => date_format(date_create($order['DATE_INSERT']), 'd.m.Y'),
                                                  "UF_CRM_1523544904" => $orderID, // ID замовлення на сайтi
                                                  "COMMENTS"    => $order['USER_DESCRIPTION'] // комментарий
                    ]];
                    while (1)
                    {
                        $arDealResult = call("crm.deal.add", $arDealParams, true);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealResult, true).PHP_EOL, FILE_APPEND);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/dealsAddLog.txt', print_r($arDealParams, true).PHP_EOL, FILE_APPEND);
                        if ($arDealResult['STATUS'] == 200)
                            break;
                    }
                    // создание сделки существующего контакта end
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arJSON['id']." - ".$arDealResult['STATUS']."\n", true), FILE_APPEND);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealResult.txt', print_r($arDealResult['result']."\n", true), FILE_APPEND);
                    if ($arDealResult['result'] > 0)
                    {
                        // добавление товаров в созданную сделку start
                        foreach ($arProductsListResultAll as $key => $arProduct)
                        {
                            $arProducts[] = ["PRODUCT_ID" => $arProduct['ID'], "PRICE" => $arProduct['PRICE'], "QUANTITY" => $arProduct['QUANTITY'], "PRODUCT_NAME" => $arProduct['NAME']];
                        }
                        // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arProductsDealAdd.txt', print_r($arProducts, true), FILE_APPEND);
                        $arDealRowsAddParams = ["id" => $arDealResult['result'], "rows" => $arProducts];
                        while (1)
                        {
                            Bitrix\Main\Diag\Debug::writeToFile($arDealRowsAddParams , "5 - order (2) " , '/debug_b24.txt');
                            // Додаємо товари в замовлення
                            $arDealRowsAddResult = call("crm.deal.productrows.set", $arDealRowsAddParams, true);
                            if ($arDealRowsAddResult['STATUS'] == 200)
                                break;
                        }
                        // добавление товаров в созданную сделку end
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arJSON['id']."\n", true), FILE_APPEND);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/b24_2/log/order/arDealRowsAddResult.txt', print_r($arDealRowsAddResult, true), FILE_APPEND);
                    }
                }
            }
            // Создание сделки end
            // Создание контакта и сделки end
            // Создание лида за коментировал потому что по оновой схеме для всех новых клиентов(которые не зарегестнрировались на сайте) при оформлении заказа в Б24 создается контакт и сделка
            // поиск лида start
        }
        Bitrix\Main\Diag\Debug::writeToFile(1 , "6 - before end " , '/debug_b24.txt');
        $DB -> Query('INSERT INTO b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) values 
                                                                                                         (
                                                                                                          \''.$orderID.'\',
                                                                                                          \'0\',
                                                                                                          \'Вигрузка в Б24\',
                                                                                                          \'1\',
                                                                                                          \'UPLOAD_B24\',
                                                                                                          \''.$orderID.'\',
                                                                                                          \'ORDER\'
                                                                                                         )');
        Bitrix\Main\Diag\Debug::writeToFile(1 , "7 - before end 2" , '/debug_b24.txt');

        unset($idsToB24[0]);
    }
    elseif (isset($idsToB24[0]) && !$idsToB24[0])
        unset($idsToB24[0]);

    Bitrix\Main\Diag\Debug::writeToFile('8 - end sendOrderToB24', "debug_b24 " , '/debug_b24.txt');
    $idsToB24 = implode(',',$idsToB24);
    COption::SetOptionString('main', 'order_ro_b24', $idsToB24);

    return 'sendOrderToB24();';
}

function sendNewSmsToClient($id)
{
    {
        Bitrix\Main\Diag\Debug::writeToFile('start send new sms for id = ' . $id, "start" , '/z_send_new.txt');
        global $DB;
        $basket = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $id);
        $products = [];
        while ($bb = $basket->Fetch())
            $products[$bb['PRODUCT_ID']] = $bb['QUANTITY'];

        if(!empty($products))
        {
            $res = $DB->Query('select * from b_catalog_product where ID in ('.implode(',', array_keys($products)).')');
            while ($record = $res->Fetch())
            {
                $newQuantity = $record['QUANTITY']-$products[$record['ID']];
                if($newQuantity < 0) $newQuantity = 0;
                if(!$newQuantity)
                {
                    $DB->Query('update b_catalog_product set QUANTITY = ' . $newQuantity . ', AVAILABLE = \'N\' where ID = ' . $record['ID']);
                    $DB->Query('update b_iblock_element set SORT = 0 where ID = ' . $record['ID']);
                }
                else
                {
                    $DB->Query('update b_catalog_product set QUANTITY = ' . $newQuantity . ' where ID = ' . $record['ID']);
                    $DB->Query('update b_iblock_element set SORT = 500 where ID = ' . $record['ID'] . ' and (SORT = 500 or SORT = 1000 or SORT = 0)');
                }
            }
        }

        $idsToB24 = COption::GetOptionString('main', 'order_ro_b24', '');
        $idsToB24 = explode(',',$idsToB24);
        $idsToB24[] = $id;
        foreach ($idsToB24 as $index => $item)
            if(!$item) unset($idsToB24[$index]);
        $idsToB24 = implode(',',$idsToB24);
        COption::SetOptionString('main', 'order_ro_b24', $idsToB24);

        global $DB;
        $phoneValue = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id. ' and ORDER_PROPS_ID = 3');

        if($phoneValue = $phoneValue -> Fetch())
        {
            $phoneValue = $phoneValue['VALUE'];
            Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "phoneValue" , '/z_send_new.txt');
            if(!empty($phoneValue))
            {
                $phoneValue = str_replace([' ',')','(','-'],['','','',''],$phoneValue);

                //sendSmsTelikom($phoneValue, "Опрацьовуємо Ваше замовлення №'".$id.". Менеджер зв'яжеться найближчим часом");
                sendSmsTelikom($phoneValue, "Усе добре - замовлення №".$id." в роботі. Скоро, нарешті, приміряєш особисто.");

                /*$apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
                $senderName = 'STIMMA';
                $phoneNumber = $phoneValue;
                $data = [
                    'phoneNumbers' => [$phoneNumber],
                    "from" => "STIMMA",
                    "text" => "Опрацьовуємо Ваше замовлення №'".$id.". Менеджер зв'яжеться найближчим часом"
                ];

                $headers = [
                    'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
                    'Content-Type: application/json',
                ];

                $options = [
                    CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => $headers,
                ];
                $curl = curl_init();
                curl_setopt_array($curl, $options);
                $response = curl_exec($curl);
                Bitrix\Main\Diag\Debug::writeToFile($response, "phoneValue" , '/z_send_new.txt');
                curl_close($curl);*/

            }
        }

        //$_SESSION['sertificate_phone']
        //$_SESSION['sertificate_date']

        if($_REQUEST['sertificate_phone'] && $_REQUEST['sertificate_date'])
        {
            $date = strtotime($_REQUEST['sertificate_date']);
            $DB->Query('insert into sertificates (UF_ORDER_ID,UF_DATE,UF_PHONE,UF_STATUS) values ('.$id.',\''.$date.'\',\''.$_REQUEST['sertificate_phone'].'\',0)');
        }

    }
}

function sendSmsToClient(\Bitrix\Main\Event $event)
{
    $order = $event->getParameter("ENTITY");
    $isNew = $event->getParameter("IS_NEW");
    Bitrix\Main\Diag\Debug::writeToFile('start 1', "debug_sms " , '/debug_sms.txt');
    Bitrix\Main\Diag\Debug::writeToFile($_REQUEST, "debug_sms " , '/debug_sms.txt');
    if($isNew && $id = $order->getId())
    {

        global $DB;
        $basket = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $id);
        $products = [];
        while ($bb = $basket->Fetch())
            $products[$bb['PRODUCT_ID']] = $bb['QUANTITY'];

        if(!empty($products))
        {
            $res = $DB->Query('select * from b_catalog_product where ID in ('.implode(',', array_keys($products)).')');
            while ($record = $res->Fetch())
            {
                $newQuantity = $record['QUANTITY']-$products[$record['ID']];
                if($newQuantity < 0) $newQuantity = 0;
                if(!$newQuantity)
                {
                    $DB->Query('update b_catalog_product set QUANTITY = ' . $newQuantity . ', AVAILABLE = \'N\' where ID = ' . $record['ID']);
                    $DB->Query('update b_iblock_element set SORT = 0 where ID = ' . $record['ID']);
                }
                else
                {
                    $DB->Query('update b_catalog_product set QUANTITY = ' . $newQuantity . ' where ID = ' . $record['ID']);
                    $DB->Query('update b_iblock_element set SORT = 500 where ID = ' . $record['ID'] . ' and (SORT = 500 or SORT = 1000 or SORT = 0)');
                }
            }
        }

        $idsToB24 = COption::GetOptionString('main', 'order_ro_b24', '');
        $idsToB24 = explode(',',$idsToB24);
        $idsToB24[] = $id;
        foreach ($idsToB24 as $index => $item)
            if(!$item) unset($idsToB24[$index]);
        $idsToB24 = implode(',',$idsToB24);
        COption::SetOptionString('main', 'order_ro_b24', $idsToB24);

        global $DB;
        Bitrix\Main\Diag\Debug::writeToFile('start 2', "debug_sms " , '/debug_sms.txt');
        Bitrix\Main\Diag\Debug::writeToFile('select * from b_sale_order_props_value where ORDER_ID = '.$id. ' and ORDER_PROPS_ID = 3', "debug_sms " , '/debug_sms.txt');
        $phoneValue = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id. ' and ORDER_PROPS_ID = 3');
        if($phoneValue = $phoneValue -> Fetch())
        {
            $phoneValue = $phoneValue['VALUE'];
            Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 3 " , '/debug_sms.txt');
            if(!empty($phoneValue))
            {
                $phoneValue = str_replace([' ',')','(','-'],['','','',''],$phoneValue);

                sendSmsTelikom($phoneValue, "Гарний вибір;) насолоджуйся часом з рідними,поки ми пакуємо замовлення");

                /*Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 4 " , '/debug_sms.txt');
                $apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
                $senderName = 'STIMMA';
                $phoneNumber = $phoneValue;
                $data = [
                    'phoneNumbers' => [$phoneNumber],
                    "from" => "STIMMA",
                    "text" => "Гарний вибір;) насолоджуйся часом з рідними,поки ми пакуємо замовлення"
                ];

                $headers = [
                    'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
                    'Content-Type: application/json',
                ];

                $options = [
                    CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => $headers,
                ];
                Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 5 " , '/debug_sms.txt');
                $curl = curl_init();
                curl_setopt_array($curl, $options);
                $response = curl_exec($curl);
                Bitrix\Main\Diag\Debug::writeToFile($response, "debug_sms " , '/debug_sms.txt');
                curl_close($curl);*/


            }
        }

        //$_SESSION['sertificate_phone']
        //$_SESSION['sertificate_date']

        if($_REQUEST['sertificate_phone'] && $_REQUEST['sertificate_date'])
        {
            $date = strtotime($_REQUEST['sertificate_date']);
            $DB->Query('insert into sertificates (UF_ORDER_ID,UF_DATE,UF_PHONE,UF_STATUS) values ('.$id.',\''.$date.'\',\''.$_REQUEST['sertificate_phone'].'\',0)');
        }

    }
}



/*\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderSaved',
    'sendEmailToClient'
);*/

function sendNewEmailToClient($id, $send = true)
{
    Bitrix\Main\Diag\Debug::writeToFile('start sendNewEmailToClient for id = ' . $id, "start" , '/z_send_new.txt');
    global $DB;
    $orderRecord = $DB -> Query('select * from b_sale_order where ID = ' . $id)->Fetch();
    Bitrix\Main\Diag\Debug::writeToFile($orderRecord, "order record" , '/z_send_new.txt');
    $res = $DB -> Query('select * from b_sale_basket where ORDER_ID = '.$id);
    while ($record = $res -> Fetch())
    {
        $record['PRODUCT'] = \CIBlockElement::GetByID($record['PRODUCT_ID']) -> GetNext();
        //            /if ($arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE']) $arItem['NAME'] = $arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE'];

        $record['PRODUCT']['NAME'] = CIBlockElement::GetProperty(35, $record['PRODUCT_ID'], '','', ['CODE' => 'NAME_UA']) -> Fetch()["VALUE"];
        $record['NAME'] = $record['PRODUCT']['NAME'];
        $arBasket[] = $record;
    }
    Bitrix\Main\Diag\Debug::writeToFile($arBasket, "Basket" , '/z_send_new.txt');
    $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
    $phone = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 3') -> Fetch()['VALUE'];
    $name = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and (ORDER_PROPS_ID = 1 or ORDER_PROPS_ID = 22)');
    $Lastname = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 23')->Fetch()['VALUE'];
    $adress = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 7')->Fetch()['VALUE'];

    $find_name = '';

    while ($names = $name -> Fetch())
    {
        if($names['VALUE'])
        {
            $find_name = $names['VALUE'];
            break;
        }
    }

    $name = $find_name;
    Bitrix\Main\Diag\Debug::writeToFile($email . ' ' . $name, "Name Email" , '/z_send_new.txt');

    $orderRecord = $DB -> Query('select * from b_sale_order where ID = '.$id) -> Fetch();
    if(!$email)
    {
        $user = \CUser::GetByID($orderRecord['USER_ID']) -> Fetch();
        $email = $user['EMAIL'];
        Bitrix\Main\Diag\Debug::writeToFile($email, "New Email find" , '/z_send_new.txt');
    }

    $payment = $delivery = '';
    switch($orderRecord['DELIVERY_ID'])
    {
        case 14: $delivery = 'Нова Пошта (відділення)'; break;
        case 17: $delivery = 'Нова Пошта (поштомат)'; break;
        case 18: $delivery = 'Нова Пошта (кур’єр)'; break;
        case 15: $delivery = 'УкрПошта Експрес'; break;
    }

    switch($orderRecord['PAY_SYSTEM_ID'])
    {
        case 3: $payment = 'Повна оплата'; break;
        case 9: $payment = 'Післяплата'; break;
    }

    ob_start();
    /*
    if($send)
    {
        ?>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">

                            <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Дякуємо за замовлення !</h2>
                        </td>
                    </tr>

                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;">
                                Зовсім скоро ми зателефонуємо для уточнення деталей.
                            </h3>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <?
                            $amount = 0;
                            foreach ($arBasket as $index => $item)
                            {
                                if($item['PRODUCT']['IBLOCK_ID'] == 25)
                                {
                                    $product = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ID'=>$item['PRODUCT_ID']],false,false,['ID','IBLOCK_ID','PROPERTY_CML2_LINK'])->Fetch();
                                    $mainPRoduct = CIBlockElement::GetByID($product['PROPERTY_CML2_LINK_VALUE'])->Fetch();
                                    $idimg = $mainPRoduct['PREVIEW_PICTURE'] ? $mainPRoduct['PREVIEW_PICTURE'] : $mainPRoduct['DETAIL_PICTURE'];
                                }
                                else
                                    $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];

                                $file = \CFile::GetFileArray($idimg)['SRC'];
                                $amount += $item['PRICE']*$item['QUANTITY'];
                                $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                                ?>
                                <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                            <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                            </a>
                                        </td>
                                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                        <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                    </td>
                                                </tr>
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                        <?=FormatCurrency($item['PRICE'], 'UAH')?> x <?=intval($item['QUANTITY'])?> шт
                                                    </td>
                                                    <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                        <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?
                            }
                            ?>
                            <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?
    }
    else*/
    {
        ?>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <?/*<h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Доброго дня<?=$name ? ', '.$name : '!'?></h2>*/?>
                            <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Дякуємо за замовлення !</h2>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0; text-align: center;">
                                Усе добре – замовлення в роботі. <br> Зовсім скоро ми зателефонуємо для уточнення деталей 💛
                            </h3>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <table style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 0; border-bottom: 1px solid #333333;" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; margin: 0; font-size: 20px; padding:  0; text-align: left; font-weight: 700;">
                                        Перевіримо, чи все вірно?
                                    </td>
                                </tr>
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; margin: 0; font-size: 20px; padding:  0; text-align: left; font-weight: 700;">
                                        Ось твої дані:
                                    </td>
                                </tr>
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td>
                                        <table style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 0" width="100%">
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0; width: 50%; font-size: 18px; font-weight: 700;">ПІБ</td>
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0;width: 50%;"><?=$name?> <?=$Lastname?></td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0; width: 50%; font-size: 18px; font-weight: 700;">Номер телефону</td>
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0;width: 50%;"><?=$phone?></td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0; width: 50%; font-size: 18px; font-weight: 700;">Спосіб доставки</td>
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0;width: 50%;"><?=$delivery?>. <?=$adress?></td>
                                            </tr>
                                            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0; width: 50%; font-size: 18px; font-weight: 700;">Спосіб оплати:</td>
                                                <td style="box-sizing: border-box; margin: 0; padding: 5px 0;width: 50%;"><?=$payment?></td>
                                            </tr>
                                        </table>   
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <?
                            $amount = 0;
                            foreach ($arBasket as $index => $item)
                            {
                                if($item['PRODUCT']['IBLOCK_ID'] == 25)
                                {
                                    $product = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ID'=>$item['PRODUCT_ID']],false,false,['ID','IBLOCK_ID','PROPERTY_CML2_LINK'])->Fetch();
                                    $mainPRoduct = CIBlockElement::GetByID($product['PROPERTY_CML2_LINK_VALUE'])->Fetch();
                                    $idimg = $mainPRoduct['PREVIEW_PICTURE'] ? $mainPRoduct['PREVIEW_PICTURE'] : $mainPRoduct['DETAIL_PICTURE'];
                                }
                                else
                                    $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];

                                $file = \CFile::GetFileArray($idimg)['SRC'];
                                $amount += $item['PRICE']*$item['QUANTITY'];
                                $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                                ?>
                                <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                            <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                            </a>
                                        </td>
                                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                        <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                    </td>
                                                </tr>
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                        <?=FormatCurrency($item['PRICE'], 'UAH')?> x <?=intval($item['QUANTITY'])?> шт
                                                    </td>
                                                    <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                        <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?
                            }
                            ?>
                            <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <table style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 0" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; margin: 0; padding: 10px 0;width: 100%; font-weight: 700; font-size: 20px;">
                                        Якщо ти ще не оплатила замовлення, ти можеш зробити це онлайн
                                    </td>
                                    <td style="box-sizing: border-box; margin: 0; padding: 10px 0;">
                                        <a href="https://stimma.ua/order/?ORDER_ID=<?=$id?>" style="box-sizing: border-box; margin: 0; padding: 7px 10px; font-size: 20px; text-decoration: none; text-transform: uppercase; border-radius: 50px; color: #ffffff; background: #9ca848;">
                                          СПЛАТИТИ  
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; margin: 0; padding: 20px 0; font-size: 20px; font-weight: 700; text-align: center;">
                            Скоро нарешті приміряєш особисто. А поки можеш уявляти з чим поєднаєш нові речі 💌
                        </td>
                    </tr>
                    <?/*
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; margin: 0; padding: 20px 0; border-top: 1px solid #333333;">
                            <table style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 0" width="100%">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; margin: 0; padding: 10px 0; font-size: 20px; font-weight: 700; text-align: center;">
                                        Маєш питання? Напиши або зателефонуй - допоможемо
                                    </td>
                                </tr>
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; margin: 0; padding: 0; text-align: center;">
                                        <a href="#" style="box-sizing: border-box; margin: 0; padding: 0; color: #000000; text-decoration: none; font-size: 18px;">
                                            📞 <span style="box-sizing: border-box; margin: 0; padding: 0; text-decoration: underline;">0 800 300 068</span>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    */?>

                </table>
            </td>
        </tr>
        <?
    }


    $html = ob_get_clean();
    Bitrix\Main\Diag\Debug::writeToFile($html, "Html" , '/z_send_new.txt');
    //$email = 'company703@gmail.com';
    //$email = 'linkevych.o.v@gmail.com';
    if($email && $send)
    {
        $arFieldsSend = [
            'TEXT' => $html,
            'NUMBER' => $id,
            //'EMAIL' => $id == 47699 ? "marushevskiy.petr@gmail.com" : $email,
            'EMAIL' => $email,
            'PREHEADER' => 'Найближчим часом зв\'яжемось з тобою, щоб підтвердити деталі'
        ];
        CEvent::SendImmediate("BS_SALE_NEW_ORDER", "s1", $arFieldsSend, 'Y', 102);
    }
    else
        echo $html;

    if($send)
        unset($_SESSION['CATALOG_USER_COUPONS']);
}

function sendForgetBasket()
{
    /*global $DB;

    $res=$DB->Query('SELECT *
        FROM b_sale_basket
WHERE ORDER_ID IS NULL
AND DATE_INSERT >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
  AND DATE_INSERT < CURDATE()');

    $baskets=$fIds=[];
    while($record=$res->Fetch())
    {
        $fIds[$record['FUSER_ID']]=$record['FUSER_ID'];
        $baskets[$record['FUSER_ID']]['basket'][]=$record;
    }

    if(!empty($fIds))
    {
        $uIds=[];
        $res=$DB->Query('select * from b_sale_fuser where ID in ('.implode($fIds).') and USER_ID is not null');
        while ($record=$res->Fetch())
        {
            $baskets[$record['ID']]['user_id']=$record['USER_ID'];
            $uIds[$record['USER_ID']]=$record['USER_ID'];
        }

        foreach ($baskets as $index => $basket)
        {
            if(!isset($basket['user_id'])) unset($baskets[$index]);
        }
        foreach ($baskets as $index => $item)
        {
            $user=$DB->Query('select * from b_user where ID = '.$item['user_id'])->Fetch();

            if(!empty($user['EMAIL']))
            {
                sendForgetBasketEmailToClient($user['EMAIL'],$user,$item['basket']);
            }
        }
    }*/

    return 'sendForgetBasket();';
}

function sendForgetBasketEmailToClient()
{
    global $DB;
    $arBasket=[];

    $timeX = strtotime(date('d.m.Y H:i:s')) - 86400;
    $res = $DB->Query('select * from forget_basket where UF_TIME_X <= ' . $timeX . ' and UF_SEND = 0');
    while ($record = $res->Fetch())
    {
        $find = $DB->Query('select * from b_sale_basket where ID = ' . $record['UF_BASKET_ID']);
        if($find = $find->Fetch())
        {
            if($find['ORDER_ID']>0)
                $DB->Query('delete from forget_basket where ID = ' . $record['ID']);
            else
            {
                $record['BASKET']=$find;
                $arBasket[$record['UF_USER_ID']][] = $record;
            }
        }
    }

    if(!empty($arBasket))
    {
        foreach ($arBasket as $uid => $items)
        {
            foreach ($items as $index => $item)
            {
                $arBasket[$uid][$index]['PRODUCT'] = \CIBlockElement::GetByID($item['UF_PRODUCT_ID']) -> GetNext();
                $arBasket[$uid][$index]['PRODUCT']['NAME'] = \CIBlockElement::GetProperty(25, $item['UF_PRODUCT_ID'], '','', ['CODE' => 'NAME_UA']) -> Fetch()["VALUE"];
            }
        }

        foreach ($arBasket as $uid => $items)
        {
            $user=CUser::GetByID($uid)->Fetch();
            $name = $user['NAME'] . ' ' . $user['LAST_NAME'];
            $email=$user['EMAIL'];
            if(!$email) continue;

            ob_start();
            /*
            ?>
            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                <td style="box-sizing: border-box; padding: 0; margin: 0;">
                    <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Привіт ✨</h2>
                            </td>
                        </tr>

                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                                    Ти додала речі до кошика в STIMMA, але не встигла оформити замовлення.
                                    Ми зберегли їх для тебе — вони все ще чекають 💌
                                </h3>

                            </td>
                        </tr>
                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <?
                                $amount = 0;
                                foreach ($items as $index => $item)
                                {
                                    $idimg=false;
                                    if($item['PRODUCT']['IBLOCK_ID'] == 25)
                                    {
                                        $product = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ID'=>$item['UF_PRODUCT_ID']],false,false,['ID','IBLOCK_ID','PROPERTY_CML2_LINK'])->Fetch();
                                        $mainPRoduct = CIBlockElement::GetByID($product['PROPERTY_CML2_LINK_VALUE'])->Fetch();
                                        $idimg = $mainPRoduct['PREVIEW_PICTURE'] ? $mainPRoduct['PREVIEW_PICTURE'] : $mainPRoduct['DETAIL_PICTURE'];
                                    }
                                    else
                                        $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];

                                    $file = \CFile::GetFileArray($idimg)['SRC'];
                                    $amount += $item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'];
                                    $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                                    ?>
                                    <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                                <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                                </a>
                                            </td>
                                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                        <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                            <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                        </td>
                                                    </tr>
                                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                        <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                            <?=FormatCurrency($item['BASKET']['PRICE'], 'UAH')?> x <?=intval($item['BASKET']['QUANTITY'])?> шт
                                                        </td>
                                                        <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                            <?=FormatCurrency($item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'], 'UAH')?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?
                                }
                                ?>
                                <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                            Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?
            */
            ?>
            <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                <td style="box-sizing: border-box; padding: 0; margin: 0;">
                    <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding: 20px 10px;" width="100%">
                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Привіт ✨</h2>
                            </td>
                        </tr>

                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                                    Ти додала речі до корзини в STIMMA, але не встигла оформити замовлення.
                                    Ми зберегли їх для тебе — вони все ще чекають 💛
                                </h3>
                                <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                                    Можливо, ти просто відволіклась.
                                    А можливо — це саме той знак повернутися й завершити покупку.
                                </h3>
                                <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;font-weight: normal;">
                                    Якщо маєш запитання — ми завжди поруч.
                                </h3>
                            </td>
                        </tr>
                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                <?
                                $amount = 0;
                                foreach ($items as $index => $item)
                                {
                                    $idimg=false;
                                    if($item['PRODUCT']['IBLOCK_ID'] == 25)
                                    {
                                        $product = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ID'=>$item['UF_PRODUCT_ID']],false,false,['ID','IBLOCK_ID','PROPERTY_CML2_LINK'])->Fetch();
                                        $mainPRoduct = CIBlockElement::GetByID($product['PROPERTY_CML2_LINK_VALUE'])->Fetch();
                                        $idimg = $mainPRoduct['PREVIEW_PICTURE'] ? $mainPRoduct['PREVIEW_PICTURE'] : $mainPRoduct['DETAIL_PICTURE'];
                                    }
                                    else
                                        $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];

                                    $file = \CFile::GetFileArray($idimg)['SRC'];
                                    $amount += $item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'];
                                    $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                                    ?>
                                    <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                                <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                                </a>
                                            </td>
                                            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000;" width="100%">
                                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                        <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                            <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #000000; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                        </td>
                                                    </tr>
                                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                        <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                            <?=FormatCurrency($item['BASKET']['PRICE'], 'UAH')?> x <?=intval($item['BASKET']['QUANTITY'])?> шт
                                                        </td>
                                                        <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                            <?=FormatCurrency($item['BASKET']['PRICE']*$item['BASKET']['QUANTITY'], 'UAH')?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <?
                                }
                                ?>
                                <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #000000; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                            Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?
            $html = ob_get_clean();

            if($email)
            {
                $arFieldsSend = [
                        'TEXT' => $html,
                        'EMAIL' => $email,
                        'PREHEADER'=>'Повернутись до вибору можна тут'
                ];
                CEvent::SendImmediate("FORGET_BASKET", "s1", $arFieldsSend, 'Y', 132);
            }

            foreach ($items as $index => $item)
            {
                $DB->Query('update forget_basket set UF_SEND = 1 where ID = ' . $item['ID']);
            }
        }
    }

    unset($_SESSION['CATALOG_USER_COUPONS']);

    return 'sendForgetBasketEmailToClient();';
}


function sendEmailToClient(\Bitrix\Main\Event $event)
{
    $order = $event->getParameter("ENTITY");
    $isNew = $event->getParameter("IS_NEW");

    global $DB;
    if($isNew && $id = $order->getId())
    {
        $orderRecord = $DB -> Query('select * from b_sale_order where ID = ' . $id)->Fetch();
        global $DB;

        $res = $DB -> Query('select * from b_sale_basket where ORDER_ID = '.$id);
        while ($record = $res -> Fetch())
        {
            $record['PRODUCT'] = \CIBlockElement::GetByID($record['PRODUCT_ID']) -> GetNext();
            //            /if ($arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE']) $arItem['NAME'] = $arItem['PROPERTIES']['NAME_'.UPPER_LANGUAGE_ID]['VALUE'];

            $record['PRODUCT']['NAME'] = CIBlockElement::GetProperty(35, $record['PRODUCT_ID'], '','', ['CODE' => 'NAME_UA']) -> Fetch()["VALUE"];
            $record['NAME'] = $record['PRODUCT']['NAME'];
            $arBasket[] = $record;
        }

        $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
        $name = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$id.' and (ORDER_PROPS_ID = 1 or ORDER_PROPS_ID = 22)');
        while ($names = $name -> Fetch())
        {
            if($names['VALUE'])
            {
                $name = $names['VALUE'];
                break;
            }
        }

        if(!$email)
        {
            $orderRecord = $DB -> Query('select * from b_sale_order where ID = '.$id) -> Fetch();
            $user = \CUser::GetByID($orderRecord['USER_ID']) -> Fetch();
            $email = $user['EMAIL'];
        }

        ob_start();
        ?>
        <tr style="box-sizing: border-box; padding: 0; margin: 0;">
            <td style="box-sizing: border-box; padding: 0; margin: 0;">
                <table class="table-body" style="box-sizing: border-box; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding: 20px 10px;" width="100%">
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <?/*<h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Доброго дня<?=$name ? ', '.$name : '!'?></h2>*/?>
                            <h2 class="table-body-title" style="box-sizing: border-box; margin: 0; font-size: 24px; padding: 10px 0; text-align: center;">Дякуємо за замовлення</h2>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;font-style: italic;">
                                Привіт, подружко!
                            </p>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <p class="table-body-text" style="box-sizing: border-box; padding: 0; margin: 0;  padding-bottom: 10px;">
                                Ми вже працюємо над твоїм замовленням. Зовсім скоро ми зателефонуємо для уточнення деталей.
                            </p>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <h3 class="table-list-title" style="box-sizing: border-box; margin: 0; font-size: 20px; padding: 20px 0;">Проглянь ще раз своє замовлення. Ти точно нічого не забула?:</h3>
                        </td>
                    </tr>
                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                            <?
                            $amount = 0;
                            foreach ($arBasket as $index => $item)
                            {
                                $idimg = $item['PRODUCT']['PREVIEW_PICTURE'] ? $item['PRODUCT']['PREVIEW_PICTURE'] : $item['PRODUCT']['DETAIL_PICTURE'];
                                $file = \CFile::GetFileArray($idimg)['SRC'];
                                $amount += $item['PRICE']*$item['QUANTITY'];
                                $titleUA = CIBlockElement::GetProperty(25, $item['PRODUCT']['ID'], array("sort" => "asc"), Array("CODE"=>"NAME_UA"))->Fetch()['VALUE'];
                                ?>
                                <table class="table-list-item" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #333333;" width="100%">
                                    <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                        <td class="table-list-item-img" style="box-sizing: border-box; padding: 0; margin: 0; padding-right: 15px;">
                                            <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0;">
                                                <img src="https://stimma.ua<?=$file?>" style="box-sizing: border-box; padding: 0; margin: 0; max-width: 100px;">
                                            </a>
                                        </td>
                                        <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                            <table style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d;" width="100%">
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-name" colspan="2" style="box-sizing: border-box; padding: 0; margin: 0; padding-bottom: 30px;">
                                                        <a href="https://stimma.ua<?=$item['PRODUCT']['DETAIL_PAGE_URL']?>" style="box-sizing: border-box; padding: 0; margin: 0; color: #3d441d; font-size: 16px; text-decoration: none; font-weight: bold;"><?=$titleUA?></a>
                                                    </td>
                                                </tr>
                                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                                    <td class="table-list-item-number" style="box-sizing: border-box; padding: 0; margin: 0; text-align: right; font-size: 16px;" align="right">
                                                        <?=FormatCurrency($item['PRICE'], 'UAH')?> x <?=intval($item['QUANTITY'])?> шт
                                                    </td>
                                                    <td class="table-list-item-price" style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold; text-align: right;" align="right">
                                                        <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?
                            }
                            ?>
                            <table class="table-list-total" style="box-sizing: border-box; padding: 0; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; color: #3d441d; padding-top: 30px; text-align: right; font-size: 16px;" width="100%" align="right">
                                <tr style="box-sizing: border-box; padding: 0; margin: 0;">
                                    <td style="box-sizing: border-box; padding: 0; margin: 0;">
                                        Сума: <span style="box-sizing: border-box; padding: 0; margin: 0; font-size: 22px; font-weight: bold;"><?=FormatCurrency($amount,'UAH')?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?
        $html = ob_get_clean();
        Bitrix\Main\Diag\Debug::writeToFile([
                                                'TEXT' => $html,
                                                'NUMBER' => $id,
                                                'EMAIL' => $email
                                            ], "order " . $id , '/debug_email_fbasket.txt');
            //$email = 'company703@gmail.com';
            if($email)
            {
                $arFieldsSend = [
                    'TEXT' => $html,
                    'NUMBER' => $id,
                    'EMAIL' => $email
                ];
                CEvent::SendImmediate("BS_SALE_NEW_ORDER", "s1", $arFieldsSend, 'Y', 102);
            }
    }
}

function addCrmContact()
{
    require($_SERVER['DOCUMENT_ROOT']."/b24_new/include/config.php");

    $res = CUser::GetList($by='ID',$order='asc', ['UF_CRM_ID' => false]);
    $users = [];
    while ($user = $res -> Fetch())
    {
        $users[$user['ID']] = $user;

        if(count($users) >= 5) break;
    }

    $userUpd = new CUser();

    foreach ($users as $index => $user)
    {
        $phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$user['PERSONAL_PHONE']);
        $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
        $arFilter = (string)$user['PERSONAL_PHONE'] ? ["PHONE" => $phone_tmp] : ["EMAIL" => (string)$user['EMAIL']];

        $arContactsParams = ["order" => ["ID" => "ASC"], "filter" => $arFilter, "select" => ["ID", "EMAIL", "UF_CRM_1521453922", "ASSIGNED_BY_ID", "PHONE", "TYPE_ID"]];
        while (1)
        {
            $arContactsResult = call("crm.contact.list", $arContactsParams, true);
            if ($arContactsResult['STATUS'] == 200)
                break;
        }
        if (count($arContactsResult['result']) > 0)
        {
            $contact = $arContactsResult['result'][0]['ID'];
            $userUpd->Update($user['ID'], ['UF_CRM_ID' => $contact]);
            // update
        }
        else
        {
            $newManagerID   = 114; // ответственный  менеджер Настя Морозецька - роздріб - ID 114
            $contact_result = ['result' => false];
            //Создание контакта start
            //$phone_tmp          = preg_replace('~[^0-9]+~', '', $props['PHONE']['VALUE']);
            $phone_tmp          = str_replace([' ',')','(','-'],['','','',''],$user['PERSONAL_PHONE']);
            $phone              = [["VALUE" => $phone_tmp, "VALUE_TYPE" => "WORK"]];
            $arFieldsContactAdd = ["fields" => ["OPENED"            => 'Y', "EXPORT" => 'Y', "TYPE_ID" => 'CLIENT', // категория клиента (оптовик, розничный покупатель)
                                                "SOURCE_ID"         => "WEB", "NAME" => $user['NAME'], // Имя
                                                "LAST_NAME"         => $user['LAST_NAME'], // Фамилия
                                                "PHONE"             => $phone, // Телефон
                                                "EMAIL"             => [["VALUE" => $user['EMAIL'], "VALUE_TYPE" => "WORK"]], // Email
                                                "UF_CRM_1521453922" => 0, //$arJSON['user_id'], // ID на сайте
                                                "ASSIGNED_BY_ID"    => $newManagerID, // ответственный
            ]];
            echo 'try to add contact';
            while (1)
            {
                $contact_result = call("crm.contact.add", $arFieldsContactAdd, true);
                if ($contact_result['STATUS'] == 200)
                    break;
            }
        }
    }

    return 'addCrmContact();';
}

function generateSitemap()
{
    // todo зі збиранням ссилок для html карти сайту. Треба продумати якось типу як видаляти, сторінки ж можуть зникати.
    global $DB;

    $files = [];
    $domen = 'https://stimma.ua';

    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
    $footer = '</urlset>';

    $res = CIBlockSection::GetList(['LEFT_MARGIN' => 'asc'], ['IBLOCK_ID' => 21, 'ACTIVE' => "Y"]);
    $sections = [];
    while ($record = $res -> GetNext())
        $sections[$record['ID']] = $record;
    # Разделы
    foreach ($sections as $index => $section)
    {
        $files['ua']['/sections.xml'][] = '<url><loc>'.$domen.$section['SECTION_PAGE_URL'].'</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
        $files['ru']['/sections_ru.xml'][] = '<url><loc>'.$domen.'/ru'.$section['SECTION_PAGE_URL'].'</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
    }
    # /Разделы

    # Товары
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'ACTIVE' => 'Y']);
    while ($record = $res -> GetNext())
    {
        $files['ua']['/products.xml'][] = '<url><loc>' . $domen . $record['DETAIL_PAGE_URL'] . '</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
        $files['ru']['/products_ru.xml'][] = '<url><loc>' . $domen . '/ru' . $record['DETAIL_PAGE_URL'] . '</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
    }
    # /Товары

    # Новости
    /*$res = CIBlockSection::GetList([], ['IBLOCK_ID' => 28, 'ACTIVE' => 'Y']);
    while ($section = $res -> GetNext())
    {
        $files['/news.xml'][] = '<url><loc>'.$domen.$section['SECTION_PAGE_URL'].'</loc></url>';
        $files['/news.xml'][] = '<url><loc>'.$domen.'/ru'.$section['SECTION_PAGE_URL'].'</loc></url>';
    }*/

    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 28, 'ACTIVE' => 'Y']);
    while ($record = $res -> GetNext())
    {
        $files['ua']['/news.xml'][] = '<url><loc>' . $domen . $record['DETAIL_PAGE_URL'] . '</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
        $files['ru']['/news_ru.xml'][] = '<url><loc>' . $domen . '/ru' . $record['DETAIL_PAGE_URL'] . '</loc><lastmod>'.date('Y-m-d', strtotime($section['TIMESTAMP_X'])).'</lastmod></url>';
    }
    # /Новости

    # ЧПУ Фільтри
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 40, 'ACTIVE' => 'Y'],false,false,['ID','IBLOCK_ID','PROPERTY_NEW_LINK','TIMESTAMP_X']);
    while ($record = $res -> GetNext())
    {
        $files['ua']['/filters_ua.xml'][] = '<url><loc>' . $domen . $record['PROPERTY_NEW_LINK_VALUE'] . '</loc><lastmod>'.date('Y-m-d', strtotime($record['TIMESTAMP_X'])).'</lastmod></url>';
        $files['ru']['/filters_ua_ru.xml'][] = '<url><loc>' . $domen . '/ru' . $record['PROPERTY_NEW_LINK_VALUE'] . '</loc><lastmod>'.date('Y-m-d', strtotime($record['TIMESTAMP_X'])).'</lastmod></url>';
    }
    # /ЧПУ Фільтри

    # Статические страницы
    // todo ці статичні сторінки. їх теж нема в карті сайту html і не ма укр версії.
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/yak-zrobiti-zamovlennya/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/razmirna-sitka/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/dostavka-ta-oplata/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/garantiya-ta-povernennya/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/doglyad/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/sertifikati/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/vidguki/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pro-nas/stati/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/pravova-informatsiya/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/include/licenses_detail.php</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/cpivrobitnictvo/spivpracya-z-optovikami/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/cpivrobitnictvo/rozdribnim-kliyentam/</loc></url>';
    $files['ua']['/static.xml'][] = '<url><loc>'.$domen.'/contacts/</loc></url>';

    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/yak-zrobiti-zamovlennya/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/razmirna-sitka/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/dostavka-ta-oplata/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/garantiya-ta-povernennya/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/doglyad/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/sertifikati/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/vidguki/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pro-nas/stati/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/pravova-informatsiya/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/include/licenses_detail.php</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/cpivrobitnictvo/perevagi-spivpraci-z-kompaniyeyu-stimma/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/cpivrobitnictvo/spivpracya-z-optovikami/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/cpivrobitnictvo/rozdribnim-kliyentam/</loc></url>';
    $files['ru']['/static_ru.xml'][] = '<url><loc>'.$domen.'/ru/contacts/</loc></url>';
    # /Статические страницы

    $mContent = [];
    foreach ($files['ua'] as $file => $content)
    {
        $mContent[] = '<sitemap><loc>'.$domen.$file.'</loc></sitemap>';
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/'.$file, $header.implode('',$content).$footer);
    }
    foreach ($files['ru'] as $file => $content)
    {
        $mContentRu[] = '<sitemap><loc>'.$domen.$file.'</loc></sitemap>';
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/'.$file, $header.implode('',$content).$footer);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/sitemap-uk.xml', '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.implode('',$mContent).'</sitemapindex>');
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/sitemap-ru.xml', '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.implode('',$mContentRu).'</sitemapindex>');

    return 'generateSitemap();';
}

function updateSortingProduct()
{
    //return 'updateSortingProduct();';
    global $DB;
    $update = COption::GetOptionInt('main','update_sorting_products',0);
    if($update)
    {
        $bCatalogProduct = [];
        $res = $DB->Query('select * from b_catalog_product');
        while ($record = $res->Fetch())
            $bCatalogProduct[$record['ID']] = $record['QUANTITY'];

        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21]);
        while ($product = $res->Fetch())
        {
            $offersDB = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'PROPERTY_CML2_LINK' => $product['ID']]);
            $available = false;
            while ($offer = $offersDB->Fetch())
            {
                if($bCatalogProduct[$offer['ID']] > 0)
                    $available = true;
                else
                    $DB->Query('update b_catalog_product set AVAILABLE = \'N\' where ID = ' . $offer['ID']);
            }

            if(!$available)
            {
                $DB->Query('update b_catalog_product set AVAILABLE = \'N\' where ID = ' . $product['ID']);
                $DB->Query('update b_iblock_element set SORT = 0 where ID = ' . $product['ID']);
            }
            else
                $DB->Query('update b_iblock_element set SORT = 500 where ID = ' . $product['ID'] . ' and (SORT = 500 or SORT = 1000 or SORT = 0)');
        }

        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'SECTION_ID' => 350]);
        $cnt = 0;
        while ($record = $res->Fetch())
        {
            $cnt++;
            if($record['SORT'] == 500)
                $DB->Query('update b_iblock_element set SORT = 1000 where ID = ' . $record['ID']);
        }

    }
    else
    {
    }

    return 'updateSortingProduct();';
}


function activeKupon($orderID, $discount_id)
{
    \Bitrix\Main\Diag\Debug::writeToFile(1, 'inside function', 'send_sms_coupon.txt');
    \Bitrix\Main\Diag\Debug::writeToFile(2, 'inside function', 'send_sms_coupon.txt');
    global $DB;
    $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$orderID.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
    $phone = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$orderID.' and ORDER_PROPS_ID = 3') -> Fetch()['VALUE'];

    $PERIOD = '90 days';
    $activeFrom = new \Bitrix\Main\Type\DateTime();
    $activeTo = new \Bitrix\Main\Type\DateTime();
    $activeTo = $activeTo->add($PERIOD);

    $p1 = rand(1,2);
    if($p1 == 1) $p1 = 'any';
    elseif($p1 == 2) $p1 = 'bag';
    $p2 = rand(100,999);
    $p3 = rand(1000,9999);
    $p4 = rand(100,999);
    //$coupon = $p1.'-'.$p2.'-'.$p3;
    $coupon = $p2.'-'.$p4;

    $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
                                                                 'DISCOUNT_ID' => $discount_id,
                                                                 'COUPON' => $coupon,
                                                                 'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
                                                                 'ACTIVE_FROM' => $activeFrom,
                                                                 'ACTIVE_TO' => $activeTo,
                                                                 'MAX_USE' => 1,
                                                                 'USER_ID' => 0,
                                                                 'DESCRIPTION' => 'for #'.$orderID . ' ('.$email.' / '.$phone.')'
                                                             ));

    if ($addDb->isSuccess())
    {
        global $DB;
        /*$orderRecord = $DB -> Query('select * from b_sale_order where ID = ' . $orderID)->Fetch();
        $message = 'Vam narakhovani bonusy u rozmiri 5% vid zdiisnennoi pokupky! Vykorystaty yikh mozhna pry nastupnomu zamovlenni vprodovzh 90 dniv ' . $coupon;
        if(Loader::includeModule("imaginweb.sms"))
        {
            $res = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = ' . $orderID .' and ORDER_PROPS_ID = 3');
            $order = $DB -> Query('select * from b_sale_order where ID = ' . $orderID) -> Fetch();
            $time = strtotime($order['DATE_INSERT']);
            $current = strtotime(date('d.m.Y H:i:s'));
            {
                if($res = $res -> Fetch())
                {
                    $phoneValue = $res['VALUE'];
                    $sms = new \CIWebSMS();
                    $phoneValue = \CIWebSMS::MakePhoneNumber($phoneValue);
                    //$sms->Send($phoneValue, $message, ['ORIGINATOR'=>'anyBag.ua','GATE' => 'turbosms.ua']);
                }
            }
        }*/
        return $coupon;
        //echo $coupon;
    } else {
        //echo $addDb->getErrorMessages();
    }

    return false;
}


$coupon = 0;

if($coupon)
{
    $eventManager = EventManager::getInstance();
    $eventManager->addEventHandler("sale", "OnSalePaymentEntitySaved", "OnSalePaymentEntitySavedFunc");

    function OnSalePaymentEntitySavedFunc(\Bitrix\Main\Event $event)
    {
        $payment = $event->getParameter("ENTITY");
        $oldValues = $event->getParameter("VALUES");

        if (!$payment->isInner())
        {
            if( $oldValues['PAID'] === 'N' && $payment->isPaid() )
            {
                $oId = $payment->getOrderId();
                \Bitrix\Main\Diag\Debug::writeToFile($oId, 'start paid order', 'send_sms_coupon.txt');

                global $DB;
                $user = $DB -> Query("SELECT * FROM b_sale_order WHERE ID = ".$oId) -> Fetch()['USER_ID'];

                $coupon = false;
                //if(in_array($user, [1,3,36775,36835,37409,42891,69094,69105,69215,70891,71211,71312,71342]))
                //$coupon = activeKupon($oId);
                $order = \Bitrix\Sale\Order::load($oId);
                if( !empty($order) )
                    $uId = $order->getUserId();


                $basket = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $oId . ' and PRODUCT_ID in (25934,25935,25936,25937,25939)');
                $coupons = [];
                while ($record = $basket->Fetch())
                {
                    $q = $record['QUANTITY'];
                    if($record['PRODUCT_ID'] == 25934) $discount_id = 29;
                    elseif($record['PRODUCT_ID'] == 25935) $discount_id = 30;
                    elseif($record['PRODUCT_ID'] == 25936) $discount_id = 31;
                    elseif($record['PRODUCT_ID'] == 25937) $discount_id = 32;
                    elseif($record['PRODUCT_ID'] == 25939) $discount_id = 33;
                    else
                        continue;

                    for($i=1;$i<=$q;$i++)
                        $coupons[] = activeKupon($oId, $discount_id);

                }

                if(!empty($coupons))
                {
                    $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$oId.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
                    $phoneValue = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$oId.' and ORDER_PROPS_ID = 3') -> Fetch()['VALUE'];

                    if(!empty($phoneValue))
                    {
                        $phoneValue = str_replace([' ',')','(','-'],['','','',''],$phoneValue);

                        sendSmsTelikom($phoneValue, "Купони: ".implode(',', $coupons));

                        /*Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 4 " , '/debug_sms.txt');
                        $apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
                        $senderName = 'STIMMA';
                        $phoneNumber = $phoneValue;
                        $data = [
                            'phoneNumbers' => [$phoneNumber],
                            "from" => "STIMMA",
                            "text" => "Купони: ".implode(',', $coupons)
                        ];

                        $headers = [
                            'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
                            'Content-Type: application/json',
                        ];

                        $options = [
                            CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => json_encode($data),
                            CURLOPT_HTTPHEADER => $headers,
                        ];
                        Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 5 " , '/debug_sms.txt');
                        $curl = curl_init();
                        curl_setopt_array($curl, $options);
                        $response = curl_exec($curl);
                        Bitrix\Main\Diag\Debug::writeToFile($response, "debug_sms " , '/debug_sms.txt');
                        curl_close($curl);*/


                    }
                }

                //sendTriggerEmail();
                //self::sendEmailPay($oId, $coupon);
            }
        }
    }

}

function sendSertCoupon()
{
    global $DB;
    $date = strtotime(date('d.m.Y'));
    $res = $DB->Query('select * from sertificates  where UF_DATE <= ' . $date . ' and UF_STATUS = 0');

    while ($record = $res->Fetch())
    {
        $currentRecord = $record;
        $order_id = $record['UF_ORDER_ID'];

        $order = $DB->Query('select * from b_sale_order where ID = '  .$order_id) -> Fetch();
        if($order['PAYED'] == 'Y')
        {
            $basket = $DB->Query('select * from b_sale_basket where ORDER_ID = ' . $order_id . ' and PRODUCT_ID in (25934,25935,25936,25937,25939)');
            $coupons = [];
            while ($record = $basket->Fetch())
            {
                $q = $record['QUANTITY'];
                if($record['PRODUCT_ID'] == 25934) $discount_id = 29;
                elseif($record['PRODUCT_ID'] == 25935) $discount_id = 30;
                elseif($record['PRODUCT_ID'] == 25936) $discount_id = 31;
                elseif($record['PRODUCT_ID'] == 25937) $discount_id = 32;
                elseif($record['PRODUCT_ID'] == 25939) $discount_id = 33;
                else
                    continue;

                for($i=1;$i<=$q;$i++)
                    $coupons[] = activeKupon($order_id, $discount_id);

            }

            if(!empty($coupons))
            {
                $email = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 2') -> Fetch()['VALUE'];
                if($currentRecord['UF_PHONE'])
                    $phoneValue = $currentRecord['UF_PHONE'];
                else
                    $phoneValue = $DB -> Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 3') -> Fetch()['VALUE'];

                if(!empty($phoneValue))
                {
                    $phoneValue = str_replace([' ',')','(','-'],['','','',''],$phoneValue);

                    sendSmsTelikom($phoneValue, "Купони: ".implode(',', $coupons));

                    /*Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 4 " , '/debug_sms.txt');
                    $apiKey = 'CCECFE951999D570AEC5638B3DC9CF45';
                    $senderName = 'STIMMA';
                    $phoneNumber = $phoneValue;
                    $data = [
                        'phoneNumbers' => [$phoneNumber],
                        "from" => "STIMMA",
                        "text" => "Купони: ".implode(',', $coupons)
                    ];

                    $headers = [
                        'Authorization: Basic ' . base64_encode("STIMMA:".$apiKey),
                        'Content-Type: application/json',
                    ];

                    $options = [
                        CURLOPT_URL => 'https://esputnik.com/api/v1/message/sms',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => json_encode($data),
                        CURLOPT_HTTPHEADER => $headers,
                    ];
                    Bitrix\Main\Diag\Debug::writeToFile($phoneValue, "start 5 " , '/debug_sms.txt');
                    $curl = curl_init();
                    curl_setopt_array($curl, $options);
                    $response = curl_exec($curl);
                    Bitrix\Main\Diag\Debug::writeToFile($response, "debug_sms " , '/debug_sms.txt');
                    curl_close($curl);*/
                    $DB->Query('update sertificates set UF_COUPON = \''.implode(',',$coupons).'\', UF_STATUS = 1 where ID = ' . $currentRecord['ID']);

                }
            }
        }
    }
}


function changeColorToUa($text, $colors)
{
    //return str_replace(array_keys($colors), $colors, $text);

    if(LANGUAGE_ID == 'ua')
    {
        $patterns = [];
        $replacements = [];

        foreach ($colors as $word => $replacement) {
            // Экранируем спецсимволы и добавляем границы слова \b
            $patterns[] = '/\b' . preg_quote($word, '/') . '\b/u';
            $replacements[] = $replacement;
        }

        return preg_replace($patterns, $replacements, $text);
    }
    else
        return $text;

}

/*AddEventHandler("main", "OnAfterUserAdd", Array("MyClass", "OnAfterUserAddHandler"));
class MyClass
{
    // создаем обработчик события "OnAfterUserAdd"
    public static function OnAfterUserAddHandler(&$arFields)
    {
        if($arFields["ID"]>0)
        {

    }
}*/


function saveQuantity()
{
    global $DB;
    $res = $DB->Query('select * from b_catalog_product');
    $result = [];
    while ($record = $res->Fetch())
        $result[$record['ID']] = $record['QUANTITY'];

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/quantity/'.date('d.m.Y H:i:s').'.php', '<?$quantity = '.var_export($result, 1).';?>');

    return 'saveQuantity();';
}


function updatePostList()
{
    require $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/classes/NP.php';

    $np = NP::getInstance();
    $np -> updatePostList();
    //$np -> updateCities();

    return 'updatePostList();';
}

function getTypeDevice()
{
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    // Список ключевых слов для различных типов устройств
    $mobileKeywords = ['mobile', 'android', 'iphone', 'ipod', 'blackberry', 'opera mini', 'windows phone'];
    $tabletKeywords = ['tablet', 'ipad', 'android', 'silk', 'kindle', 'playbook', 'nexus 7', 'nexus 10'];

    // Проверка на планшет
    foreach ($tabletKeywords as $keyword) {
        if (strpos($userAgent, $keyword) !== false) {
            return 'Tablet';
        }
    }

    // Проверка на мобильное устройство
    foreach ($mobileKeywords as $keyword) {
        if (strpos($userAgent, $keyword) !== false) {
            return 'Mobile';
        }
    }

    // Если не найдено, предполагается, что это десктоп
    return 'Desktop';
}

function getLazySrc()
{
    return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
}

function convertToWebP($source, $quality = 100)
{
    return $source;
    $debug = isset($_GET['p']);
    if($debug && strpos($source, 'jgxvxtwapnwxoqie7gc3x5ts3p5kqjo2') !== false)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        ?><pre><?=print_r($source, 1)?></pre><?
        die();
    }
    // Проверьте, существует ли исходный файл
    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$source) || empty($source)) {
        return $source;
    }
    if($debug)
    {
        ?><pre><?=print_r($source, 1)?></pre><?
    }
    $source = $_SERVER['DOCUMENT_ROOT'].$source;
    if(strpos($source, '.png') !== false || strpos($source, '.jpg') !== false || strpos($source, '.JPG') !== false || strpos($source, '.JPEG') !== false)
    {
        if(strpos($source, '.png') !== false)
            $destination = str_replace('.png', '.webp', $source);
        elseif(strpos($source, '.jpg') !== false)
            $destination = str_replace('.jpg', '.webp', $source);
        elseif(strpos($source, '.JPG') !== false)
            $destination = str_replace('.JPG', '.webp', $source);
        elseif(strpos($source, '.JPEG') !== false)
            $destination = str_replace('.JPEG', '.webp', $source);
    }

    if(file_exists($destination)) return str_replace($_SERVER['DOCUMENT_ROOT'], '', $destination);
    // Получите информацию об изображении
    $info = getimagesize($source);
    $mime = $info['mime'];

    $result = false;
    // Создайте изображение на основе типа MIME
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            $result = true;
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            $result = true;
            break;
        default:
            break;
    }
    if($debug)
    {
        ?><pre><?=print_r($result, 1)?></pre><?
    }
    if($result)
    {
        imagewebp($image, $destination, $quality);
        imagedestroy($image);
        $result = str_replace($_SERVER['DOCUMENT_ROOT'], '', $destination);
    }
    else $result = str_replace($_SERVER['DOCUMENT_ROOT'], '', $source);
    if($debug)
    {
        ?><pre><?=print_r($result, 1)?></pre><?
    }
    return $result;
}


// Проверяем, что модуль sale подключен
if (Loader::includeModule('sale')) {
    // Подключаем обработчик события
    EventManager::getInstance()->addEventHandler(
        'sale',
        'OnSaleOrderSaved',
        'OnSaleOrderSavedHandler'
    );
}

// Функция обработчика
function OnSaleOrderSavedHandler(Bitrix\Main\Event $event) {
    /** @var \Bitrix\Sale\Order $order */
    $order = $event->getParameter("ENTITY");
    $isNew = $event->getParameter("IS_NEW");
    global $USER;
    // Проверяем, если это не новый заказ и статус изменился
    if (!$isNew && $order->isChanged('STATUS_ID')) {
        // Получаем старый и новый статус
        //$oldValues = $order->getOriginalValues();
        //$oldStatus = $oldValues['STATUS_ID'];
        $newStatus = $order->getField('STATUS_ID');

        // Если новый статус "Отменен"
        if ($newStatus === 'CK') {
            // Здесь можно добавить ваш код обработки
            global $DB;
            $res = $DB->Query('select * from orders_1c where UF_ORDER_ID = '.$order->getId());
            if($res = $res->Fetch())
                $DB->Query('update orders_1c set UF_STATUS = \'CK\' where UF_ORDER_ID = '.$order->getId().'');
            else
                $DB->Query('insert into orders_1c (UF_ORDER_ID,UF_STATUS) values ('.$order->getId().',\'CK\')');
        }
    }elseif($isNew && is_object($USER) && $USER->GetID()){
        Loader::includeModule("highloadblock");
        $hlBlockId = HLBLOCK_REGISTER_COUPONS;
        $hlblock = HighloadBlockTable::getById($hlBlockId)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $minDate = (new \Bitrix\Main\Type\DateTime())->add('+15 days');
        $maxDate = (new \Bitrix\Main\Type\DateTime())->add('+105 days');
        
        $res = $entityClass::getList([
            'select' => ['ID', 'UF_USER_ID', 'UF_PHONE', 'UF_EMAIL', 'UF_COUPON', 'UF_DATE', 'UF_COUPON_ID'],
            'filter' => [
                'UF_SENT' => false,
                'UF_ORDER' => false,
                'UF_USER_ID' => $USER->GetID(),
            ]
        ]);
        if ($row = $res->fetch()) {
            $entityClass::update($row['ID'], [
                "UF_ORDER" => $order->getId(),
                'UF_DATE' => $minDate
            ]);
            $fields = [
                'ACTIVE' => 'Y',
                'DESCRIPTION' => 'Продлён срок действия купона',
                'ACTIVE_FROM' => $minDate,
                'ACTIVE_TO' => $maxDate
            ];

            $result = DiscountCouponTable::update($row['UF_COUPON_ID'], $fields);

            if ($result->isSuccess()) {
            }
        }
    }
}

function generateYMLCatalog()
{
    // 21 Каталог
    // 25 ТП

    global $DB;
    $sections = $items = $activeSections = $quantities = $colors = $mainColorsRel = [];
    $propsAvailable=['COLOR_REF'=>'Колір','RAZMER'=>'Розмір'/*,'VID'=>'Вид'*/,'MATERIAL'=>'Матеріал','SOSTAV'=>'Склад','ROST'=>'Ріст','SELECTION'=>'Підбірка','STYLES'=>'Стиль','PRINT'=>'Принт','AGE'=>'Вік'];

    $mainColors = [];
    $res = $DB -> Query('select * from main_colors');
    while($record = $res -> Fetch())
    {
        $record['UF_COLORS'] = unserialize($record['UF_COLORS'], ['allowed_classes' => false]);
        foreach($record['UF_COLORS'] as $index => $UF_COLOR)
            $mainColorsRel[$UF_COLOR] = $record['ID'];
        $mainColors[$record['ID']] = $record;
    }
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';

    $res = $DB->Query('select * from max_color_reference');
    while($record = $res->Fetch())
        $colors[$record['UF_XML_ID']] = $record;

    $res = $DB->Query('select * from b_catalog_product');
    while ($record = $res->Fetch())
        $quantities[$record['ID']] = $record['QUANTITY'];

    $res = CIBlockSection::GetList([],['IBLOCK_ID'=>21],false,['ID','IBLOCK_ID','NAME','UF_*','IBLOCK_SECTION_ID']);
    while ($record = $res->Fetch())
        $sections[$record['ID']] = $record;
    $res = CIBlockElement::GetList([], ['IBLOCK_ID'=>21,'ACTIVE'=>'Y'],false,false,['ID','IBLOCK_ID','NAME','IBLOCK_SECTION_ID','PREVIEW_PICTURE','PROPERTY_PHOTO_GALLERY']);
    while ($record = $res->Fetch())
    {
        $res2 = $DB->Query('select * from b_iblock_element_property where IBLOCK_PROPERTY_ID = 239 and IBLOCK_ELEMENT_ID = ' . $record['ID']);

        while ($fetch = $res2->Fetch())
            $record['PROPERTIES']['PHOTO_GALLERY']['VALUE'][] = $fetch['VALUE'];
        //$fields = $record->GetFields();
        //$props = $record->GetProperties();

        //$items[$fields['ID']] = $fields;
        //$items[$fields['ID']]['PROPERTIES'] = $props;
        $items[$record['ID']] = $record;
        $activeSections[$record['IBLOCK_SECTION_ID']]=$record['IBLOCK_SECTION_ID'];
    }

    $res = CIBlockElement::GetList([], ['IBLOCK_ID'=>25,'ACTIVE'=>'Y','>PROPERTY_KASTA_QUNATITY'=>0]);
    while ($record = $res->GetNextElement())
    {
        $fields = $record->GetFields();
        $props = $record->GetProperties();

        if(!isset($items[$props['CML2_LINK']['VALUE']])) continue;


        $items[$props['CML2_LINK']['VALUE']]['OFFERS'][$fields['ID']] = $fields;
        $items[$props['CML2_LINK']['VALUE']]['OFFERS'][$fields['ID']]['PROPERTIES'] = $props;
    }

    $header = $content = $footer = '';

    $header = '<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="'.date('Y-m-d H:i').'">
<shop>
    <name>STIMMA</name>
    <company>STIMMA</company>
    <url>https://stimma.ua</url>
    <currencies>
        <currency id="UAH" rate="1"/>
    </currencies>';

    $count=0;
    $content .= '<categories>';
    foreach($activeSections as $index => $id)
    {
        if($sections[$id]['IBLOCK_SECTION_ID'])
            $content .= '<category id="'.$id.'" parent_id="'.$sections[$id]['IBLOCK_SECTION_ID'].'">'.$sections[$id]['UF_NAME_UA'].'</category>';
        else
            $content .= '<category id="'.$id.'">'.$sections[$id]['UF_NAME_UA'].'</category>';
    }
    $content .= '</categories>';

    $content .= '<offers>'; ?><pre><?=print_r($mainColors, 1)?></pre><?
    foreach($items as $index => $item)
    {
        if(!empty($item['OFFERS']))
        {
            foreach($item['OFFERS'] as $offer)
            {
                $price = CCatalogProduct::GetOptimalPrice($offer['ID'])['RESULT_PRICE'];
                if($price['BASE_PRICE'] == $price['DISCOUNT_PRICE'])
                    $price = '<price>'.$price['DISCOUNT_PRICE'].'</price>';
                elseif($price['BASE_PRICE'] > $price['DISCOUNT_PRICE'])
                    $price = '<price>'.$price['DISCOUNT_PRICE'].'</price><price_old>'.$price['BASE_PRICE'].'</price_old>';

                #############
                $picture='';
                $img = CFile::GetFileArray($item['PREVIEW_PICTURE'])['SRC'];

                if($img)
                    $picture = '<picture>https://stimma.ua'.$img.'</picture>';
                /*$resPicture = $DB -> Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $item['ID'] . ' and IBLOCK_PROPERTY_ID = 239');
                while ($record = $resPicture -> Fetch())
                {
                    $img = CFile::GetFileArray($record['VALUE'])['SRC'];
                    $picture .= '<picture>https://stimma.ua'.$img.'</picture>';
                }*/
                #############

                if (!empty($item['PROPERTIES']['PHOTO_GALLERY']['VALUE']))
                {
                    if(isset($item['PROPERTIES']['PHOTO_GALLERY']['VALUE'][1]))
                    {
                        $cache = $item['PROPERTIES']['PHOTO_GALLERY']['VALUE'][0];
                        $item['PROPERTIES']['PHOTO_GALLERY']['VALUE'][1]=$item['PROPERTIES']['PHOTO_GALLERY']['VALUE'][0];
                        $item['PROPERTIES']['PHOTO_GALLERY']['VALUE'][0]=$cache;
                    }
                    $picture=[];
                    foreach($item['PROPERTIES']['PHOTO_GALLERY']['VALUE'] as $index => $photo)
                    {
                        $picture[] = '<picture>https://stimma.ua'.CFile::GetFileArray($photo)['SRC'].'</picture>';
                    }
                    $picture = implode('',$picture);
                }

                $params='';
                foreach($propsAvailable as $code => $name)
                {
                    if(!$offer['PROPERTIES'][$code]['VALUE'] || empty($offer['PROPERTIES'][$code]['VALUE'])) continue;

                    if($code == 'COLOR_REF')
                    {
                        //$value = $colors[$offer['PROPERTIES'][$code]['VALUE'][0]];
                        $id_color = $colors[$offer['PROPERTIES'][$code]['VALUE'][0]]['ID'];

                        //$value = $mainColors[$offer['PROPERTIES'][$code]['VALUE'][0]];
                        $value = $mainColors[$mainColorsRel[$id_color]]['UF_NAME_UA'];
                        ?><pre>$value <?=print_r($value, 1)?></pre><?
                    }
                    else
                    {
                        if(is_array($offer['PROPERTIES'][$code]['VALUE']))
                        {
                            $parts=[];
                            foreach($offer['PROPERTIES'][$code]['VALUE_XML_ID'] as $indexP => $PROPERTY)
                                $parts[] = $name_ua[$code]['values'][$PROPERTY];
                            $value = implode(',',$parts);
                        }
                        else
                            $value = $name_ua[$code]['values'][$offer['PROPERTIES'][$code]['VALUE_XML_ID']];
                        //$value = is_array($offer['PROPERTIES'][$code]['VALUE']) ? implode(',',$offer['PROPERTIES'][$code]['VALUE']) : $offer['PROPERTIES'][$code]['VALUE'];
                    }

                    $params .= '<param name="'.$name.'">'.$value.'</param>';
                }

                $content .= '<offer id="'.$offer['ID'].'" available="true">';

                $content .= '<name_ua>'.$offer['PROPERTIES']['NAME_UA']['VALUE'].'</name_ua>';
                $content .= '<article>'.$props['ARTICLE']['VALUE'].'</article>';
                $content .= '<currencyId>UAH</currencyId>';
                $content .= '<categoryId>'.$item['IBLOCK_SECTION_ID'].'</categoryId>';
                $content .=  $price;
                $content .= '<stock_quantity>'.$quantities[$offer['ID']].'</stock_quantity>';
                $content .=  $picture;
                $content .= '<vendor>STIMMA</vendor>';
                $content .= '<description_ua>'.$props['DETAIL_TEXT_UA']['VALUE'].'</description_ua>';
                $content .= $params;

                $content .= '</offer>';

                $count++;
            }
        }

    }
    $content .= '</offers>';

    $footer = '</shop></yml_catalog>';
echo '11<br>';
echo '$count = '. $count;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/kasta.xml', $header.$content.$footer);

    return 'generateYMLCatalog();';
}


function getKastaOrders($token, $updatedFrom = null, $limit = 20) {
    $url = 'https://hub.kasta.ua/api/orders/list'; // Актуальный URL для seller API Kasta

    // Время последнего обновления (ISO 8601 формат)
    if (!$updatedFrom) {
        $updatedFrom = date('c', strtotime('-1 hour')); // по умолчанию — за последний час
    }

    // Подготавливаем POST-данные
    $postData = [
        "filters" => [
            "updated_from" => $updatedFrom
        ],
        "limit" => $limit
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => false,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $token
        ],
        //CURLOPT_POSTFIELDS => json_encode($postData),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Kasta API error: HTTP $httpCode. Response: $response");
    }

    return json_decode($response, true);
}

function checkKastaOrders()
{
    CModule::IncludeModule('catalog');
    CModule::IncludeModule('sale');

    $token = '26qu4soa5ttj5bidn8e500kzxeugtcp7kgle8yoi';

    try
    {
        global $DB;
        $uadd = new CUser;

        $params = [
            "status"    => "new",
            "limit"     => 100,
            "offset"    => 0
        ];
        $orders = getKastaOrders($token, $params);
        foreach($orders['items'] as $index => $orderKasta)
        {
            $kastaId = $orderKasta['id'];
            $findOrder = $DB->Query('select * from b_sale_order_props_value where CODE = \'KASTA_ID\' and VALUE = \'' . $kastaId.'\'');

            if($findOrder = $findOrder->Fetch()) continue;

            $client = $orderKasta['client'];
            $client['phone'] = '+'.$client['phone'];

            $uid = 1; // todo узнать

            $user = $DB->Query('select * from b_user where PERSONAL_PHONE = \''.$client['phone'].'\'');
            if($user = $user->Fetch())
                $uid = $user['ID'];
            else
            {
                $pass = uniqid();
                $uid = $uadd->Add(['LOGIN' => $client['phone'], 'PASSWORD' => $pass, 'CONFIRM_PASSWORD' => $pass, 'PERSONAL_PHONE' => $client['phone'],'NAME'=>$client['first_name'],'SECOND_NAME'=>$client['last_name'],'LAST_NAME'=>$client['middle_name']]);

                if(!$uid)
                {
                    // todo лог еррор
                }
            }



            $siteId = 's2';
            $currencyCode = 'UAH';
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 2 " , '/___change_rozetka_status.txt');
            // Создаёт новый заказ
            $order = Bitrix\Sale\Order::create($siteId, $uid);
            $order->setPersonTypeId(1);
            $order->setField('CURRENCY', $currencyCode);
            $order->setField('USER_DESCRIPTION', implode(' / ',  $orderKasta['comments']));
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 3 " , '/___change_rozetka_status.txt');
            // Создаём корзину с одним товаром
            $basket = Bitrix\Sale\Basket::create($siteId);


            //$basket = [];
            foreach($orderKasta['ordered_items'] as $ordered_item)
            {
                $id = str_replace('rzid_','',$ordered_item['unique_sku_id']);
                $db = CIBlockElement::GetByID($id) -> Fetch();
                $arItem=[];

                $arItem = $db;
                $arItem['PICTURE'] = $db['PREVIEW_PICTURE'] ? $db['PREVIEW_PICTURE'] : $db['DETAIL_PICTURE'];
                $arItem['PRICE'] = $ordered_item['supplier_price'];
                $arItem['QUANTITY'] = $ordered_item['quantity'];

                //$basket['ITEMS'][] = $arItem;

                $item = $basket->createItem('catalog', $id);
                $item->setFields(array(
                                     'QUANTITY' => $ordered_item['quantity'],
                                     'CURRENCY' => $currencyCode,
                                     'LID' => $siteId,
                                     'PRODUCT_ID' => $id,
                                     'NAME' => $db['NAME'],
                                     'PRICE' => intval($ordered_item['supplier_price']),
                                     'CUSTOM_PRICE' => 'Y',
                                     //'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider'
                                 ));
            }
            //$basket['BASKET_COUNT'] = count($basket['ITEMS']);



            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 4 " , '/___change_rozetka_status.txt');
            //$basket->save();
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 4.5 " , '/___change_rozetka_status.txt');
            $order->setBasket($basket);
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 5 " , '/___change_rozetka_status.txt');


            // Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)
            $shipmentCollection = $order->getShipmentCollection();
            $idShipment = 14;
            $orderProps = [];
            if($orderKasta['delivery_properties']['type'] == 'novaposhta')
            {
                $mistoId = $DB->Query('select * from np_cities_new where UF_REF_ID = \'' . $orderKasta['shipping_address']['warehouse']['delivery_service_info']['city_ref_id'] .'\'')->Fetch()['ID'];
                $postId = $DB->Query('select * from np_posts_new where UF_REF_ID = \'' . $orderKasta['shipping_address']['warehouse']['ref_id'] .'\'')->Fetch()['ID'];

                $orderProps = [
                    27 => $mistoId, // Місто ID
                    28 => $postId, // post id
                    7 => $orderKasta['shipping_address']['warehouse']['name'], // відділення назва
                    5 => $orderKasta['shipping_address']['city']['name'], // Місто назва
                    23 => $client['last_name'], // Прізвище
                    22 => $client['first_name'], // Імя
                    29 => $client['middle_name'], // По батькові
                    3 => $client['phone'], // Телефон
                    30 => $orderKasta['id'], // id kasta order
                ];
                $idShipment = 14;
            }

            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 6 " , '/___change_rozetka_status.txt');
            $shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById($idShipment));

            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 7 " , '/___change_rozetka_status.txt');
            $shipmentItemCollection = $shipment->getShipmentItemCollection();
            foreach ($basket as $basketItem)
            {
                $item = $shipmentItemCollection->createItem($basketItem);
                $item->setQuantity($basketItem->getQuantity());
            }
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 8 " , '/___change_rozetka_status.txt');
            // Создаём оплату со способом #1
            $payment = 3;
            if($orderKasta['requested_payment_method'] == 'cod')
                $payment = 9;

            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 9 " , '/___change_rozetka_status.txt');
            $paymentCollection = $order->getPaymentCollection();
            $payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById($payment));
            $payment->setField("SUM", $order -> getPrice());
            $payment->setField("CURRENCY", 'UAH');





            $order->doFinalAction(true);
            $result = $order->save();
            //Bitrix\Main\Diag\Debug::writeToFile( 1, "step 12 " , '/___change_rozetka_status.txt');
            if (!$result->isSuccess())
            {
                //$result->getErrors();
                ?><pre> error create order <?=print_r($result->getErrors(), 1)?></pre><?
                //Bitrix\Main\Diag\Debug::writeToFile( $result->getErrors(), "error create order " , '/___change_rozetka_status.txt');
            }
            else
            {
                $orderId = $order->getId();
                ?><pre> order id <?=print_r($orderId, 1)?></pre><?

                $propsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = ' . $orderId);
                $props = [];
                while ($record = $propsDB->Fetch())
                    $props[$record['ORDER_PROPS_ID']] = $record['ID'];
                //Bitrix\Main\Diag\Debug::writeToFile($props, " props before " , '/debug_create_order.txt');
                if($props['30'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['30']).'\' where ID = ' . $props['30']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',30, \'Kasta ID\', \''.addslashes($orderProps['30']).'\', \'SECOND_NAME\', \''.$orderId.'\', \'ORDER\')');
                if($props['29'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['29']).'\' where ID = ' . $props['29']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',29, \'По батькові\', \''.addslashes($orderProps['29']).'\', \'SECOND_NAME\', \''.$orderId.'\', \'ORDER\')');
                if($props['27'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['27']).'\' where ID = ' . $props['27']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',27, \'Місто ID\', \''.addslashes($orderProps['27']).'\', \'MISTO_ID\', \''.$orderId.'\', \'ORDER\')');
                if($props['28'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['28']).'\' where ID = ' . $props['28']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',28, \'POST_ID\', \''.addslashes($orderProps['28']).'\', \'POST_ID\', \''.$orderId.'\', \'ORDER\')');
                if($props['23'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['23']).'\' where ID = ' . $props['23']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',23, \'Прізвище\', \''.addslashes($orderProps['23']).'\', \'LASTNAME\', \''.$orderId.'\', \'ORDER\')');
                if($props['22'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['22']).'\' where ID = ' . $props['22']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',22, \'Імя\', \''.addslashes($orderProps['22']).'\', \'NAME\', \''.$orderId.'\', \'ORDER\')');
                if($props['3'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['3']).'\' where ID = ' . $props['3']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',3, \'Телефон\', \''.addslashes($orderProps['3']).'\', \'PHONE\', \''.$orderId.'\', \'ORDER\')');
                if($props['5'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['5']).'\' where ID = ' . $props['5']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',5, \'Місто\', \''.addslashes($orderProps['5']).'\', \'CITY\', \''.$orderId.'\', \'ORDER\')');
                if($props['7'])$DB -> Query('update b_sale_order_props_value set VALUE = \''.addslashes($orderProps['7']).'\' where ID = ' . $props['7']);
                else $DB->Query('insert into b_sale_order_props_value (ORDER_ID,ORDER_PROPS_ID,NAME,VALUE,CODE,ENTITY_ID,ENTITY_TYPE) VALUES('.$orderId.',7, \'Відділення\', \''.addslashes($orderProps['7']).'\', \'ADDRESS\', \''.$orderId.'\', \'ORDER\')');

                $DB->Query('insert into orders_1c (UF_ORDER_ID,UF_STATUS) values ('.$orderId.',\'N\')');

                //Bitrix\Main\Diag\Debug::writeToFile( $orderId, "orderId " , '/___change_rozetka_status.txt');
            }


            ?><pre>$client <?=print_r($client, 1)?></pre><?
            ?><pre>$uid <?=print_r($uid, 1)?></pre><?
            ?><pre>$basket <?=print_r($basket, 1)?></pre><?
        }

        ?><pre><?=print_r($orders, 1)?></pre><?
    } catch(Exception $e)
    {
        echo $e->getMessage();
    }

    return 'checkKastaOrders();';
}

AddEventHandler("main", "OnBuildGlobalMenu", "AddMyCustomMenu");

function AddMyCustomMenu(&$aGlobalMenu, &$aModuleMenu) {
    IncludeModuleLangFile(__FILE__);

    $aMenu = [
        [
            "parent_menu" => "global_menu_content", // Это указывает на раздел "Контент"
            "section" => "my_custom_section",  // Произвольный ID раздела
            "sort" => 100,
            "text" => "Список продавців",
            "title" => "Список продавців",
            "url" => "my_custom_page.php",
            "icon" => "fileman_menu_icon", // Иконка (можешь подобрать другую)
            "page_icon" => "fileman_page_icon",
            "items_id" => "menu_my_custom_page",
            "items" => [] // Если будут подменю
        ]
    ];


    $aModuleMenu[] = $aMenu[0]; // добавляем свой пункт
}

//debug фуункции
function PR($o, $region = false, $float = false)
{
    global $USER;
    $style = '';
    if($region){
        $style = 'width:100%;height:100%;overflow:auto;position:fixed;top:120px;'.($float ? $float : 'left').':0;max-width:400px;max-height:400px;z-index:1000000;';
    }
    if($USER->isAdmin() || $_GET["SHOW"] == "Y")
    {
        $bt = debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div id="debug-window" style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;<?=$style?>'>
            <div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?= $bt["file"] ?> [<?= $bt["line"] ?>]</div>
            <pre style='padding:10px;display: block;'><? print_r($o) ?></pre>
        </div>
        <?
    }
}


function getOrderFor1C($order_id,$status,$debug)
{
    global $DB;
    if($debug)
    {
        ?><pre><?=print_r($order_id, 1)?></pre><?
    }

    //$status = $order_item['UF_STATUS'];

    $order = $DB->Query('select * from b_sale_order where ID = '.$order_id)->Fetch();

    $orderProps = [];
    $orderPropsDB = $DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id);
    while ($record = $orderPropsDB->Fetch())
        $orderProps[$record['ORDER_PROPS_ID']] = $record;

    $basketDB = $DB->Query('select * from b_sale_basket where ORDER_ID = '.$order_id);

    $basket = $jsonBasket = $delivery = [];
    while ($record = $basketDB->Fetch())
    {
        if($debug)
        {
            ?><pre><?=print_r($record, 1)?></pre><?
        }
        $stims=false;
        $fetch=$DB->Query('select* from basket_stims where UF_ID = ' . $record['ID']);
        if($fetch=$fetch->Fetch())
            $stims = $fetch['UF_STIMS'];

        $props = CIBlockElement::GetByID($record['PRODUCT_ID'])->GetNextElement()->GetProperties();


        $basket[] = $record;
        $price=$record['PRICE'];
        $jsonBasket[] = [
                'product_uid' => $props['ARTICLE']['VALUE'],
                'name' => $record['NAME'],
                'price' => $price,
                'quantity' => $record['QUANTITY'],
                'amount' => $price * $record['QUANTITY'],
                'stims' => $stims ? ($stims * $record['QUANTITY']) : 0,
                'id' => $record['ID']
        ];
    }
    if($order['DELIVERY_ID'] == 14 || $order['DELIVERY_ID'] == 17) // Нова пошта
    {
        $city = $post = [];
        if($orderProps[27]['VALUE'])
            $city = $DB->Query('select * from np_cities_new where ID = ' . $orderProps[27]['VALUE'])->Fetch();
        if($orderProps[28]['VALUE'])
            $post = $DB->Query('select * from np_posts_new where ID = ' . $orderProps[28]['VALUE'])->Fetch();
        $delivery['type'] = 'np';
        $delivery['name'] = 'Нова пошта. '.($order['DELIVERY_ID'] == 14 ? 'Відділення' : 'Поштомат');
        $delivery['city'] = $city['UF_REF_ID'];
        $delivery['city_name'] = $city['UF_NAME_UA'];
        $delivery['post'] = $post['UF_REF_ID'];
        $delivery['adress'] = '№'.$post['UF_NUMBER'].' ' .$post['UF_SHORT_ADRESS_UA'];
    }
    if($order['DELIVERY_ID'] == 18 ) // Нова пошта Курєр
    {
        $city=$DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 24')->Fetch();
        $city2=$DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 4')->Fetch();
        $city3=$DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 5')->Fetch();
        $adress=$DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 25')->Fetch();
        $adress2=$DB->Query('select * from b_sale_order_props_value where ORDER_ID = '.$order_id.' and ORDER_PROPS_ID = 7')->Fetch();
        $city = $post = [];
        $delivery['type'] = 'np';
        $delivery['name'] = 'Нова пошта. Кур’єр';
        $delivery['city'] = '';
        $delivery['city_name'] = $city['VALUE'] ? $city['VALUE'] : ($city2['VALUE'] ? $city2['VALUE'] : $city3['VALUE']);
        $delivery['post'] = '';
        $delivery['adress'] = $adress['VALUE'] ? $adress['VALUE'] : $adress2['VALUE'];
    }
    elseif($order['DELIVERY_ID'] == 15) // Укрпошта
    {
        $city = $post = [];
        if($orderProps[27]['VALUE'])
            $city = $DB->Query('select * from ukrposhta_cities where ID = ' . $orderProps[27]['VALUE'])->Fetch();
        if($orderProps[28]['VALUE'])
            $post = $DB->Query('select * from ukrposhta_posts where ID = ' . $orderProps[28]['VALUE'])->Fetch();

        $delivery['type'] = 'ukr';
        $delivery['name'] = 'УкрПошта';
        $delivery['city'] = $city['UF_CITY_ID'];
        $delivery['city_name'] = $city['UF_CITY_UA'] . ' ' . $city['UF_CITYTYPE_UA']. ' ' . $city['UF_REGION_UA'] . ' обл, ' . $city['UF_DISTRICT_UA'] . ' р-н';
        $delivery['post'] = $post['UF_ID'];
        $delivery['adress'] = $post['UF_POSTINDEX'] . ', ' . $post['UF_ADDRESS'];
        $delivery['index'] = $post['UF_POSTINDEX'];
    }
    elseif($order['DELIVERY_ID'] == 13) // Самовивіз
    {
        $delivery['type'] = 'pickup';
        $delivery['name'] = 'Самовивіз';
        $delivery['city'] = $order['DELIVERY_ID'];
    }
    elseif($order['DELIVERY_ID'] == 18) // НП курьер
    {
        $delivery['type'] = 'np';
        $delivery['name'] = 'Нова Пошта. Кур’єр';
        $delivery['city'] = $order['DELIVERY_ID'];
    }

    $pay = CSalePaySystem::GetByID($order['PAY_SYSTEM_ID']);
    $pay = [
            'name' => $pay['NAME'],
            'id' => $pay['PAY_SYSTEM_ID'],
    ];

    if($status == 'CK' || $order_id == 37427)
        $jsonBasket = [];

    $kastaId = '';
    $findOrder = $DB->Query('select * from b_sale_order_props_value where CODE = \'KASTA_ID\' and ORDER_ID = ' . $order_id);
    if($findOrder = $findOrder->Fetch()) $kastaId = $findOrder['VALUE'];
    $userRecord = $DB->Query('select * from b_user where ID = ' . $order['USER_ID'])->Fetch();

   return [
            'order_id' => $order_id,
            'create_at' => strtotime($order['DATE_INSERT']),
            'comment' => $order['COMMENTS'] . ' ' . $delivery['name'],
            'currency' => 'UAH',
            'amount' => $status == 'CK' ? 0 : $order['PRICE'],
            'contragent' => [
                    'name' => $orderProps[22]['VALUE'],
                    'last_name' => $orderProps[23]['VALUE'],
                    'second_name' => $orderProps[29]['VALUE'],
                    'phone' => $orderProps[3]['VALUE'],
                    'email' => $orderProps[2]['VALUE'],
            ],
            'owner' => [
                    'name' => $userRecord['NAME'] ? $userRecord['NAME'] :$orderProps[22]['VALUE'],
                    'last_name' => $userRecord['LAST_NAME'] ? $userRecord['LAST_NAME'] :$orderProps[23]['VALUE'],
                    'second_name' => $userRecord['SECOND_NAME'] ? $userRecord['SECOND_NAME'] :$orderProps[29]['VALUE'],
                    'phone' => $userRecord['PERSONAL_PHONE'] ? $userRecord['PERSONAL_PHONE'] : $orderProps[3]['VALUE'],
                    'email' => $userRecord['EMAIL'] ? $userRecord['EMAIL'] : $orderProps[2]['VALUE'],
            ],
            'delivery' => $delivery,
            'pay' => $pay,
            'items'=>$jsonBasket,
            'adress'=>$delivery['adress'],
            'kasta_id'=>$kastaId,
    ];
}

function GetDiscount1C($promocode)
{
    global $USER;
    $url = 'http://195.201.245.102:22022/sklad/hs/list/GetDiscount';

    $headers = [
            'Content-Type: application/json'
    ];

    $basket = getBasket();
    $bJson = [];
    foreach ($basket['ITEMS'] as $index => $item)
    {
        //$product = CIBlockElement::GetList([],['IBLOCK_ID'=>25,'ID'=>$item['PRODUCT_ID']])->GetNextElement()->GetProperties();
        $product = CIBlockElement::GetList([],['IBLOCK_ID'=>25,'ID'=>$item['PRODUCT_ID']])->GetNextElement()->GetFields();

        $bJson[] = [
                //'SKU' => $product['ARTICLE']['VALUE'],
                'SKU' => $product['XML_ID'],
                'Key' => $index+1,
                'Sum' => floatval($item['PRICE']),
                'Count' => intval($item['QUANTITY']),
        ];
    }

    $UidCard = $opt = false;
    if($USER->IsAuthorized())
    {
        $user = $USER->GetByID($USER->GetID())->Fetch();
        $groups = explode(',',$USER->GetGroups());
        $opt = in_array(9,$groups);
        $UidCard = $user['XML_ID'];
    }
    $data = [
            'UidCard' => $UidCard,
            'warehouse' => '87523e5c-af43-11eb-8fbc-305a3a45331a',
            'UidPromo' => $promocode,
            'opt' => $opt,
            'Goods' => $bJson,
    ];

    ?><pre>$data <?=print_r($data,1)?></pre><?


    $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
            CURLOPT_TIMEOUT => 10         // таймаут выполнения
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    ?><pre>$response 2 -> <?=print_r($response,1)?></pre><?
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        ?><pre> $error 2 -> <?=print_r($error,1)?></pre><?
        return [
                'error' => true,
                'message' => $error
        ];
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

// Удаляем BOM перед json_decode
    $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $decoded = json_decode($cleaned_response, true);

    return [
            'error' => false,
            'http_code' => $http_code,
            'response_raw' => $response,
            'response' => $decoded
    ];
}

function addUserTo1C($phone, $name, $last_name, $second_name)
{
    $url = 'http://195.201.245.102:22022/sklad/hs/list/CreateCard';

    $headers = [
            'Content-Type: application/json'
    ];

    $data = [
            "phone" => $phone,
            "name" => $name,
            "last_name" => $last_name,
            "second_name" => $second_name
    ];

    $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
            CURLOPT_TIMEOUT => 10         // таймаут выполнения
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        ?><pre>$error 1 -><?=print_r($error,1)?></pre><?
        return [
                'error' => true,
                'message' => $error
        ];
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

// Удаляем BOM перед json_decode
    $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $decoded = json_decode($cleaned_response, true);

    return [
            'error' => false,
            'http_code' => $http_code,
            'response_raw' => $response,
            'response' => $decoded
    ];
}

function checkUserWith1C()
{
    echo 'start checkUserWith1C<br>';
    global $DB;
    $updUser=new CUser;

    $users = CUser::GetList($by='ID', $order='ASC', ['UF_ONE_C'=>false]);
    //$users = CUser::GetList($by='ID', $order='ASC', ['ID'=>3643]);
    $count=1;
    while ($user = $users->Fetch())
    {
        $count++;

        if(strpos($user['PERSONAL_PHONE'],'+7') !== false || strpos($user['EMAIL'],'.ru') !== false)
        {

        }

        $response=[];
        if($user['PERSONAL_PHONE'] && !empty($user['PERSONAL_PHONE']) && strpos($user['PERSONAL_PHONE'],'+7') === false)
        {
            $bForce=false;

            if(strpos($user['PERSONAL_PHONE'],'+38') !== false) $user['PERSONAL_PHONE'] = str_replace('+38','',$user['PERSONAL_PHONE']);
            preg_match('/(\d+)/',$user['PERSONAL_PHONE'], $matches);

            ?><pre> $matches 5228 -> <?=print_r($matches[1],1)?></pre><?
            if(strlen($matches[1]) == 10)
            {
                echo 'step 1<br>';
                if(!$user['NAME'] && !$user['LAST_NAME'] && !$user['SECOND_NAME']) $user['NAME'] = '-';
                //$response=addUserTo1C($user['PERSONAL_PHONE'], $user['NAME'], $user['LAST_NAME'], $user['SECOND_NAME']);
                $response=addUserTo1C($matches[1], $user['NAME'], $user['LAST_NAME'], $user['SECOND_NAME']);
                $bForce=true;
                ?><pre><?=print_r($response, 1)?></pre><?
            }
            else
            {
                echo 'step 2<br>';
                $response['http_code'] = 200;
                $response['response']['CardUID']='';
                $bForce=true;
            }
        }

        if(!$user['PERSONAL_PHONE'])
        {
            echo 'step 3<br>';
            $response['http_code'] = 200;
            $response['response']['CardUID']='';
            $bForce=true;
        }
var_dump($bForce);
        if($bForce || (isset($response['http_code']) && $response['http_code'] == 200 && isset($response['response']['CardUID']) && $response['response']['CardUID']))
        {
            echo 'inside bForce<br>';
            $updUser->Update($user["ID"], ['UF_ONE_C'=>1]);
            $DB->Query('update b_user set XML_ID =\''.$response['response']['CardUID'].'\' where ID = ' . $user['ID']);
        }
        else
            echo 'NOT inside bForce<br>';
echo '----------------------------------<br>';
        if($count >= 40) return 'checkUserWith1C();';
    }

    return 'checkUserWith1C();';
}

function GetBalance($xml_id) {
    $url = 'http://195.201.245.102:22022/sklad/hs/list/GetBalance';

    $headers = [
        'Content-Type: application/json'
    ];

    $data = [
        "CardUid" => $xml_id
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 5,  // таймаут соединения
        CURLOPT_TIMEOUT => 10         // таймаут выполнения
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return [
            'error' => true,
            'message' => $error
        ];
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

// Удаляем BOM перед json_decode
    $cleaned_response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $decoded = json_decode($cleaned_response, true);

    return [
        'error' => false,
        'http_code' => $http_code,
        'response_raw' => $response,
        'response' => $decoded
    ];
}




function svCheckBirthdayUsersAction() {
	
	global $DB;
    $today = new \DateTime();
    $currentYear = (int)$today->format('Y');

	$DB->Query("UPDATE b_uts_user SET UF_BIRTHDAY = 0");

    $rsUsers = CUser::GetList(
        ($by = "id"),
        ($order = "asc"),
        ['ACTIVE' => 'Y'],
        ['FIELDS' => ['ID', 'PERSONAL_BIRTHDAY'], 'SELECT' => ['UF_BIRTHDAY']]
    );

    $user = new CUser;

    while ($arUser = $rsUsers->Fetch())
    {
		//$user->Update($arUser['ID'], ["UF_BIRTHDAY" => 0]);
        if (!empty($arUser['PERSONAL_BIRTHDAY']))
        {
            $birthDate = new \DateTime($arUser['PERSONAL_BIRTHDAY']);
            $birthDate->setDate($currentYear, (int)$birthDate->format('m'), (int)$birthDate->format('d'));
            $interval = $today->diff($birthDate);
            $daysDiff = (int)$interval->format('%r%a');
            if ($daysDiff <= 0 && $daysDiff >= -6)
            {
				//echo "set {$arUser['ID']}<br>\r\n";
                $user->Update($arUser['ID'], ["UF_BIRTHDAY" => 31]);
            }
        }
    }
    return "svCheckBirthdayUsersAction();";
}


AddEventHandler(
        'main',
        'OnAdminTabControlBegin',
        'addCustomSectionTab'
);

function addCustomSectionTab(&$tabControl)
{
    global $APPLICATION, $request;
    if($_REQUEST['IBLOCK_ID'] == 21 && isset($_GET['ID']))
    {
        global $DB;
        $res=$DB->Query('select * from faq_sections where UF_ID = ' . $_GET['ID'] . ' order by ID asc');
        while ($record =$res->Fetch())
            $questions[] = $record;

        $content='';
        foreach ($questions as $index => $question)
        {
            if($question['UF_LANG'] == 'ru') continue;
            $content.='<tr><td class="adm-detail-content-cell-r"><label>Запитання</label><input style="width:100%;" name="faq[ua][is]['.$question['ID'].'][question]" type="text" value="'.$question['UF_QUESTION'].'"></td></tr>';
            $content.='<tr><td class="adm-detail-content-cell-r"><label>Відповідь (можна html)</label><textarea style="width:100%;height:200px;" name="faq[ua][is]['.$question['ID'].'][answer]">'.$question['UF_ANSWER'].'</textarea></td></tr>';
            $content.='<tr class="block_faq" style="border-bottom:1px solid black;"><td class="adm-detail-content-cell-r"><input type="checkbox" name="faq[ua][is]['.$question['ID'].'][delete]">Видалити</td></tr>';
        }

        $content.='<tr><td class="adm-detail-content-cell-r"><label>Запитання</label><input style="width:100%;" name="faq[ua][new][question][]" type="text" value=""></td></td></tr>';
        $content.='<tr><td class="adm-detail-content-cell-r"><label>Відповідь (можна html)</label><textarea style="width:100%;height:200px;" name="faq[ua][new][answer][]"></textarea></td></td></tr>';
        $content.='<tr class="block_faq" style="border-bottom:1px solid black;"><td class="adm-detail-content-cell-r"></td></tr>';

        $content.='<tr><td><button type="button" id="add_faq" class="adm-btn">+ Додати питання</button></td></tr>';
        $content .= <<<HTML


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('add_faq').addEventListener('click', function () {

        const blocks = document.querySelectorAll('tr.block_faq');
        if (!blocks.length) return;

        const lastBlock = blocks[blocks.length - 1];

        const html = `
<tr>
    <td class="adm-detail-content-cell-r">
        <label>Запитання</label>
        <input style="width:100%;" name="faq[ua][new][question][]" type="text" value="">
    </td>
</tr>
<tr>
    <td class="adm-detail-content-cell-r">
        <label>Відповідь (можна html)</label>
        <textarea style="width:100%;height:200px;" name="faq[ua][new][answer][]"></textarea>
    </td>
</tr>
<tr class="block_faq" style="border-bottom:1px solid black;">
    <td class="adm-detail-content-cell-r"></td>
</tr>`;

        lastBlock.insertAdjacentHTML('afterend', html);
    });

});
</script>
HTML;


        $contentRu='';
        foreach ($questions as $index => $question)
        {
            if($question['UF_LANG'] == 'ua') continue;
            $contentRu.='<tr><td class="adm-detail-content-cell-r"><label>Запитання</label><input style="width:100%;" name="faq[ru][is]['.$question['ID'].'][question]" type="text" value="'.$question['UF_QUESTION'].'"></td></tr>';
            $contentRu.='<tr><td class="adm-detail-content-cell-r"><label>Відповідь (можна html)</label><textarea style="width:100%;height:200px;" name="faq[ru][is]['.$question['ID'].'][answer]">'.$question['UF_ANSWER'].'</textarea></td></tr>';
            $contentRu.='<tr class="block_faq_ru" style="border-bottom:1px solid black;"><td class="adm-detail-content-cell-r"><input type="checkbox" name="faq[ru][is]['.$question['ID'].'][delete]">Видалити</td></tr>';
        }

        $contentRu.='<tr><td class="adm-detail-content-cell-r"><label>Запитання</label><input style="width:100%;" name="faq[ru][new][question][]" type="text" value=""></td></td></tr>';
        $contentRu.='<tr><td class="adm-detail-content-cell-r"><label>Відповідь (можна html)</label><textarea style="width:100%;height:200px;" name="faq[ru][new][answer][]"></textarea></td></td></tr>';
        $contentRu.='<tr class="block_faq_ru" style="border-bottom:1px solid black;"><td class="adm-detail-content-cell-r"></td></tr>';

        $contentRu.='<tr><td><button type="button" id="add_faq_ru" class="adm-btn">+ Додати питання</button></td></tr>';
        $contentRu .= <<<HTML


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('add_faq_ru').addEventListener('click', function () {

        const blocks_ru = document.querySelectorAll('tr.block_faq_ru');
        if (!blocks_ru.length) return;

        const lastBlock = blocks_ru[blocks_ru.length - 1];

        const html = `
<tr>
    <td class="adm-detail-content-cell-r">
        <label>Запитання</label>
        <input style="width:100%;" name="faq[new][question][]" type="text" value="">
    </td>
</tr>
<tr>
    <td class="adm-detail-content-cell-r">
        <label>Відповідь (можна html)</label>
        <textarea style="width:100%;height:200px;" name="faq[new][answer][]"></textarea>
    </td>
</tr>
<tr class="block_faq_ru" style="border-bottom:1px solid black;">
    <td class="adm-detail-content-cell-r"></td>
</tr>`;

        lastBlock.insertAdjacentHTML('afterend', html);
    });

});
</script>
HTML;

        // Добавляем вкладку
        $tabControl->tabs[] = [
                'DIV'   => 'my_custom_tab',
                'TAB'   => 'FAQ',
                'TITLE' => 'FAQ для раздела',
                'CONTENT' => $content
        ];
        $tabControl->tabs[] = [
                'DIV'   => 'my_custom_tab_ru',
                'TAB'   => 'FAQ RU',
                'TITLE' => 'FAQ для раздела RU',
                'CONTENT' => $contentRu
        ];
    }
}

if(isset($_POST['faq']))
{
    foreach ($_POST['faq']['ua']['new']['question'] as $index => $question)
    {
        echo $index.'<br>';
        $question=trim($question);
        $answer=trim($_POST['faq']['ua']['new']['answer'][$index]);

        if(!empty($question) && !empty($answer))
            $DB->Query('insert into faq_sections (UF_ID,UF_QUESTION,UF_ANSWER,UF_LANG) values ('.$_POST['ID'].',\''.addslashes($question).'\',\''.addslashes($answer).'\',\'ua\')');
    }

    foreach ($_POST['faq']['ua']['is'] as $id => $item)
    {
        if(isset($item['delete']))
            $DB->Query('delete from faq_sections where ID = ' . $id);
        else
            $DB->Query('update faq_sections set UF_QUESTION = \'' . addslashes($item['question']).'\', UF_ANSWER = \''.addslashes($item['answer']).'\' where ID = ' . $id);
    }

    foreach ($_POST['faq']['ru']['new']['question'] as $index => $question)
    {
        echo $index.'<br>';
        $question=trim($question);
        $answer=trim($_POST['faq']['ru']['new']['answer'][$index]);

        if(!empty($question) && !empty($answer))
            $DB->Query('insert into faq_sections (UF_ID,UF_QUESTION,UF_ANSWER,UF_LANG) values ('.$_POST['ID'].',\''.addslashes($question).'\',\''.addslashes($answer).'\',\'ru\')');
    }

    foreach ($_POST['faq']['ru']['is'] as $id => $item)
    {
        if(isset($item['delete']))
            $DB->Query('delete from faq_sections where ID = ' . $id);
        else
            $DB->Query('update faq_sections set UF_QUESTION = \'' . addslashes($item['question']).'\', UF_ANSWER = \''.addslashes($item['answer']).'\' where ID = ' . $id);
    }
}

function sendSmsTelikom($to, $message)
{
    Bitrix\Main\Diag\Debug::writeToFile('start send new sms for number = ' . $to, "start" , '/z_send_new.txt');
    $url = 'http://api.sms.intel-tele.com/message/send/';

    $to = str_replace('+','',$to);
    if(strpos($to,'380') === false && strpos($to,'0') === 0)
        $to = '38' . $to;
    elseif(strpos($to,'380') === false && strpos($to,'0') !== 0)
            $to = '380' . $to;

    Bitrix\Main\Diag\Debug::writeToFile('start send new sms for number (2) = ' . $to, "start" , '/z_send_new.txt');

    $params = [
        'username' => 'Z_Stimma',
        'api_key'  => 'O0u4rCCMB490lCc5',
        'from'     => 'STIMMA',//'Odyag',//'STIMMA',
        'to'       => $to,
        'message'  => $message,
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    Bitrix\Main\Diag\Debug::writeToFile('response sms send ' . $response, "start" , '/z_send_new.txt');
    $result = json_decode($response, true);
    Bitrix\Main\Diag\Debug::writeToFile('response sms send 2 ' . $response, "start" , '/z_send_new.txt');

    return [
        'http_code' => $httpCode,
        'response'  => $result
    ];
}

function custom_mail($to, $subject, $message, $additional_headers, $additional_parameters, $context)
{
    if(strpos($to,'user_') !== false)
        return true;

    $mail = new PHPMailer(true);

    $Username = 'info@stimma.com.ua';
    $from1 = 'info@stimma.com.ua';
    $from2 = 'STIMMA';
    //$to = 'company703@gmail.com';
    //$to = 'test-t1qnpo31f@srv1.mail-tester.com';


    try
    {
        $mail -> isSMTP();
        //$mail -> Host       = '185.125.19.14';
        $mail -> Host       = 'smtp.gmail.com';
        $mail -> SMTPAuth   = true;
        $mail -> Username   = $Username; // Отправитель должен быть
        $mail -> Password   = 'pirc xljo hbtv ohsf';
        //$mail -> SMTPSecure = false;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail -> Port       = 587;
        $mail -> CharSet    = 'UTF-8';
        //$mail -> SMTPAutoTLS = false;

        ///$mail -> SMTPSecure = false;
        //$mail->setFrom('popusti@popusti.rs', 'Popusti.RS');
        $mail->setFrom($from1, $from2);
        $mail -> addAddress($to);

        $mail -> isHTML(true);
        $mail -> Subject = $subject;
        $mail -> Body    = $message;

        $mail -> send();
    }
    catch (Exception $e)
    {
        ?><pre><?=print_r($mail->ErrorInfo, 1)?></pre><?
        mail('company703@gmail.com','Ошибка отправки stimma','Ошибка отправки ' . $mail->ErrorInfo);
        //mail('marushevskiy.petr@gmail.com','Ошибка отправки stimma','Ошибка отправки ' . $mail->ErrorInfo);
    }

    return true;
}
