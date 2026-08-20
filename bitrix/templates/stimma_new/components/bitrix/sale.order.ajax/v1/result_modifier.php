<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

$debug = isset($_GET['sub']);

global $USER;
use Bitrix\Catalog\PriceTable;


//--------------------- // скидка ДР 01.10.2025 --------------------------------------

$db_flag = false;

$bonus_part = $bonus_ok = $userId = false;
if ($USER->IsAuthorized()) $userId = (int) $USER->GetID();

if ($userId == 66693 ) {
	$discounts = [28 => .15, 29 => .18, 30 =>.20];
	$dbUser = CUser::GetList("", "", array("ID" => $userId), array('FIELDS' => array('ID', 'UF_BIRTHDAY', 'UF_LOYALTY_GROUP')));

/*	$UF_BIRTHDAY = $USER->GetParam("UF_BIRTHDAY");
	$UF_LOYALTY_GROUP = $USER->GetParam("UF_LOYALTY_GROUP");
	echo "UF_BIRTHDAY=$UF_BIRTHDAY<===<br>";
	echo "UF_LOYALTY_GROUP=$UF_LOYALTY_GROUP<===<br>";*/
	$arUser = $dbUser->Fetch();
	//echo "<pre>";print_r($arUser);echo "</pre>";//exit();

	$discount = $discounts[$arUser['UF_LOYALTY_GROUP']];
	
	if ( (int)$arUser['UF_BIRTHDAY'] != 0 && $discount != 0 ) {
		
		//echo "discount=$discount<===<br>";
		//echo "<pre>";print_R($arResult['JS_DATA']['GRID']['ROWS']);echo "</pre>";
		
		foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $index => &$row) {
			$productId = $row['data']['PRODUCT_ID'];
			$actualPrice = (float)$row['data']['PRICE'];
			$quantity = (int)$row['data']['QUANTITY'];

			// Получаем базовую цену
			$basePriceRow = PriceTable::getList([
				'filter' => [
					'PRODUCT_ID' => $productId,
					'CATALOG_GROUP_ID' => 1
				],
				'limit' => 1
			])->fetch();

			$basePrice = (float)($basePriceRow['PRICE'] ?? 0);
			$hasDiscount = ($actualPrice < $basePrice);



			if (!$hasDiscount) {

				$originalPrice = (float)$row['data']['PRICE'];

				$newPrice = max( $originalPrice*(1 - $discount), 0);
				$row['data']['PRICE'] = $newPrice;
				$row['data']['APPLIED_ACTION_DISCOUNT'] = $originalPrice*$discount;

				$row['data']['BASE_PRICE'] = $basePrice;
				$row['data']['HAS_DISCOUNT'] = 1;
				$row['data']['APPLIED_ACTION_DISCOUNT'] = 0;	

				$db_flag = true;

			}
		}

		//echo "<pre>";print_R($arResult['JS_DATA']['GRID']['ROWS']);echo "</pre>";
		
	}

	//exit();
}

//$db_flag = true;
$db_flag = true;
//--------------------- скидка ДР 01.10.2025 //--------------------------------------



/* todo: Костыль для акции сумма > 6000 - 1000 на товар */
$isYour30 = true;
$uGroups = $USER->GetUserGroupArray();
if (in_array(9, $uGroups)) $isYour30 = false;

if ( /*$USER->IsAdmin() && */$isYour30 && !$db_flag) {

    $maxDiscountAmount = 1000;
    $cumulativeSum = 0;

    $discountCandidateIndex = null;
    $discountCandidatePrice = PHP_FLOAT_MAX;

    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $index => &$row) {
        $productId = $row['data']['PRODUCT_ID'];
        $actualPrice = (float)$row['data']['PRICE'];
        $quantity = (int)$row['data']['QUANTITY'];

        // Получаем базовую цену
        $basePriceRow = PriceTable::getList([
            'filter' => [
                'PRODUCT_ID' => $productId,
                'CATALOG_GROUP_ID' => 1
            ],
            'limit' => 1
        ])->fetch();

        $basePrice = (float)($basePriceRow['PRICE'] ?? 0);
        $hasDiscount = ($actualPrice < $basePrice);

        $row['data']['BASE_PRICE'] = $basePrice;
        $row['data']['HAS_DISCOUNT'] = $hasDiscount;
        $row['data']['APPLIED_ACTION_DISCOUNT'] = 0;

        if ($hasDiscount) {
            // Пропускаем товары, уже со скидкой
            continue;
        }

        $positionTotal = $actualPrice * $quantity;
        $cumulativeSum += $positionTotal;

        // Ищем самый дешёвый товар (по цене за 1 шт)
        if ($actualPrice < $discountCandidatePrice) {
            $discountCandidatePrice = $actualPrice;
            $discountCandidateIndex = $index;
        }
    }
    unset($row);

    // Если сумма <= 6000 — скидка не нужна
    if ($cumulativeSum <= 6000) {
        return;
    }

    // Если нашли товар для скидки — применяем её
    if ($discountCandidateIndex !== null) {
        $targetRow =& $arResult['JS_DATA']['GRID']['ROWS'][$discountCandidateIndex];
        $originalPrice = (float)$targetRow['data']['PRICE'];
        $quantity = (int)$targetRow['data']['QUANTITY'];

        // Сколько нужно вычесть, чтобы сумма стала ровно 6000
        $neededDiscount = $cumulativeSum - 6000;

        // Ограничиваем скидку максимальной скидкой и общей стоимостью товара
        $maxPossibleDiscount = $originalPrice * $quantity;
        $discountToApply = min($neededDiscount, $maxDiscountAmount, $maxPossibleDiscount);

        // Считаем скидку на единицу товара
        $discountPerUnit = $discountToApply / $quantity;

        $newPrice = max($originalPrice - $discountPerUnit, 0);
        $targetRow['data']['PRICE'] = $newPrice;
        $targetRow['data']['APPLIED_ACTION_DISCOUNT'] = $discountToApply;
    }

    // Отладка
    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $row) {
        PR([
            'PRODUCT_ID' => $row['data']['PRODUCT_ID'],
            'BASE_PRICE' => $row['data']['BASE_PRICE'],
            'ACTUAL_PRICE' => $row['data']['PRICE'],
            'HAS_DISCOUNT' => $row['data']['HAS_DISCOUNT'],
            'APPLIED_ACTION_DISCOUNT' => $row['data']['APPLIED_ACTION_DISCOUNT'] ?? 0,
        ]);
    }
}






/*
// це вроді не робоча версія 2+1
if(isset($_GET['sub']))
{
    global $DB,$USER;

    $uGroups = explode(',',$USER -> GetGroups());
    $allAmountLeft = 0;

    if(!in_array(9,$uGroups))
    {
        $allAmountLeft = 3000;
        $allSum = $countInAction = $firstIndex = $secondIndex = 0;
        $procesList = [];
        foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
        {
            $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

            if ($productInfo)
            {
                $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                if($findMain = $findMain->Fetch())
                    $productId = $findMain['VALUE'];
                else $productId = $Row['data']['PRODUCT_ID'];
            }
            else
                $productId = $Row['data']['PRODUCT_ID'];


            $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID = 352');
            $isSale = $isSale->Fetch() ? true : false;

            if(!$isSale)
            {
                $allSum += $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                $countInAction++;
                $allAmountLeft -= $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                //$procesList[] = ['id'=>$Row['data']['ID'],'price'=>$Row['data']['PRICE']];
                $procesList[$Row['data']['ID']] = $Row['data']['PRICE'];
            }
            else
                $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['IS_SALE'] = true;
        }


        arsort($procesList); // Убывание
        //asort($procesList); // Возростание
        $new = [];
        foreach($procesList as $id => $item)
        {
            foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $ROW)
            {
                if($ROW['id'] == $id)
                {
                    $new[] = $ROW;
                    unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                    break 1;
                }
            }
        }
        $arResult['JS_DATA']['GRID']['ROWS'] = array_merge($new,$arResult['JS_DATA']['GRID']['ROWS']);

        if($allSum >= 3000)
        {
            $firstPercent = $countInAction > 2 ? 0.3 : 0.2;



            $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);


            $sqls = [];
            $start = $first = $second = false;
            foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $row)
            {
                if($row['data']['IS_SALE']) continue;
                if($index) $start = true;
                if(!$start && !$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1)
                {
                    if($debug) echo '0<br>';
                    continue;
                }

                //if(!$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1) continue;

                if(!$first)
                {
                    if($row['data']['QUANTITY'] > 1)
                    {
                        if($debug) echo $index.' <- index<br>';
                        if($debug) echo '1<br>';
                        $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                        $first = $row;
                        $first['data']['QUANTITY'] = 1;

                        $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                        $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                        $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                        $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT) 
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                    }
                    elseif($row['data']['QUANTITY'] == 1)
                    {
                        if($debug) echo '2<br>';
                        $first = $row;
                        $first['data']['QUANTITY'] = 1;

                        $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                        $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                        $sqls[] = 'update b_sale_basket set PRICE = '.$first['data']['PRICE'].', BASE_PRICE = '.$first['data']['BASE_PRICE'] . ' where ID = ' . $first['id'];

                        unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                        continue;
                    }
                }
                elseif(!$second)
                {
                    if($row['data']['QUANTITY'] > 1)
                    {
                        if($debug) echo '3<br>';
                        $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                        $second = $row;
                        $second['data']['QUANTITY'] = 1;

                        $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                        $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                        $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                        $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT) 
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                    }
                    elseif($row['data']['QUANTITY'] == 1)
                    {
                        if($debug) echo $index.' <- index<br>';
                        if($debug) echo '4<br>';
                        $second = $row;
                        $second['data']['QUANTITY'] = 1;

                        $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                        $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                        $sqls[] = 'update b_sale_basket set PRICE = '.$second['data']['PRICE'].', BASE_PRICE = '.$second['data']['BASE_PRICE'] . ' where ID = ' . $second['id'];

                        unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                        continue;
                    }
                }

                //if(!$arResult['JS_DATA']['GRID']['ROWS'][$index]['QUANTITY']) unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
            }

            $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);

            if($first)
            {
                $first['id'] = $first['data']['ID'] = 0;
                //$first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                //$first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*0.3);
                $arResult['JS_DATA']['GRID']['ROWS'][] = $first;
            }
            if($second)
            {
                $second['id'] = $second['data']['ID'] = 0;
                //$second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                //$second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);
                $arResult['JS_DATA']['GRID']['ROWS'][] = $second;
            }

            $arResult['SQLS'] = $sqls;
        }
    }
}
*/

// 2+1 (-30 на другий товар та -20 на другий найдешевший в чеку , Акція була до 31,03,2026)

$arResult['IS_ACTION_SELFDATE'] = 0;
if (!in_array(9, $uGroups) && false)
{
    $time1 = strtotime(date('13.02.2026 23:59:59'));
    $time2 = strtotime(date('31.03.2026 23:59:59'));
    if(isset($_GET['sub']) /*|| $USER->IsAdmin()*/ || (strtotime(date('d.m.Y H:i:s')) >= $time1 && strtotime(date('d.m.Y H:i:s')) <= $time2))
    {
        global $DB,$USER;

        $uGroups = explode(',',$USER -> GetGroups());
        $allAmountLeft = 0;
        $allQuantityLeft=3;

        if(!in_array(9,$uGroups))
        {
            $allQuantityLeft=3;
            $allAmountLeft = 3000;
            $allSum = $countInAction = 0;
            foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
            {
                $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

                if ($productInfo)
                {
                    $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                    if($findMain = $findMain->Fetch())
                        $productId = $findMain['VALUE'];
                    else $productId = $Row['data']['PRODUCT_ID'];
                }
                else
                    $productId = $Row['data']['PRODUCT_ID'];


                $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID in (352,361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410)'); // sale + Аксесури
                $isSale = $isSale->Fetch() ? true : false;

                $fetch=$DB->Query('select* from basket_stims where UF_ID = ' . $Row['data']['ID']);
                $isSale = $fetch->Fetch() ? true : false;


                if(!$isSale)
                {
                    $allSum += $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                    $countInAction++;
                    $allAmountLeft -= $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                    $allQuantityLeft -= $Row['data']['QUANTITY'];
                }
                else
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['IS_SALE'] = true;
            }

            //if($allSum >= 3000)
            if($allQuantityLeft <= 0 && $allSum >= 3000)
            {
                $firstPercent = $countInAction > 2 ? 0.3 : 0.2;
                if(isset($_GET['sub']) && $debug)
                {
                    ?><pre><?=print_r($arResult['JS_DATA']['GRID']['ROWS'], 1)?></pre><?
                }
                uasort($arResult['JS_DATA']['GRID']['ROWS'], function ($a, $b) {
                    return $a['data']['PRICE'] <=> $b['data']['PRICE'];
                });

                $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);

                /*if($arResult['JS_DATA']['GRID']['ROWS'][0]['data']['IS_SALE'])
                {
                    $temp = $arResult['JS_DATA']['GRID']['ROWS'][0];
                    $arResult['JS_DATA']['GRID']['ROWS'][0] = $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1];
                    $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1] = $temp;
                    $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);
                }

                $temp = $arResult['JS_DATA']['GRID']['ROWS'][0];
                $arResult['JS_DATA']['GRID']['ROWS'][0] = $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1];
                $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1] = $temp;*/

                $sqls = [];
                $start = $first = $second = false;
                foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $row)
                {
                    if($row['data']['IS_SALE']) continue;
                    //if($index) $start = true;
                    if(!$start && !$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1)
                    {
                        if($debug) echo '0<br>';
                        //continue;
                    }

                    //if(!$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1) continue;

                    if(!$first)
                    {
                        if($row['data']['QUANTITY'] > 1)
                        {
                            if($debug) echo $index.' <- index<br>';
                            if($debug) echo '1<br>';
                            $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                            $first = $row;
                            $first['data']['QUANTITY'] = 1;

                            $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                            $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                            $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                            $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT)
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                        }
                        elseif($row['data']['QUANTITY'] == 1)
                        {
                            if($debug) echo '2<br>';
                            $first = $row;
                            $first['data']['QUANTITY'] = 1;

                            $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                            $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                            $sqls[] = 'update b_sale_basket set PRICE = '.$first['data']['PRICE'].', BASE_PRICE = '.$first['data']['BASE_PRICE'] . ' where ID = ' . $first['id'];

                            unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                            continue;
                        }
                    }
                    elseif(!$second)
                    {
                        if($row['data']['QUANTITY'] > 1)
                        {
                            if($debug) echo '3<br>';
                            $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                            $second = $row;
                            $second['data']['QUANTITY'] = 1;

                            $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                            $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                            $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                            $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT)
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                        }
                        elseif($row['data']['QUANTITY'] == 1)
                        {
                            if($debug) echo $index.' <- index<br>';
                            if($debug) echo '4<br>';
                            $second = $row;
                            $second['data']['QUANTITY'] = 1;

                            $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                            $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                            $sqls[] = 'update b_sale_basket set PRICE = '.$second['data']['PRICE'].', BASE_PRICE = '.$second['data']['BASE_PRICE'] . ' where ID = ' . $second['id'];

                            unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                            continue;
                        }
                    }

                    //if(!$arResult['JS_DATA']['GRID']['ROWS'][$index]['QUANTITY']) unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                }

                $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);

                if($first)
                {
                    $first['id'] = $first['data']['ID'] = 0;
                    //$first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                    //$first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*0.3);
                    $arResult['JS_DATA']['GRID']['ROWS'][] = $first;
                }
                if($second)
                {
                    $second['id'] = $second['data']['ID'] = 0;
                    //$second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                    //$second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);
                    $arResult['JS_DATA']['GRID']['ROWS'][] = $second;
                }

                $arResult['SQLS'] = $sqls;
                $arResult['IS_ACTION_SELFDATE'] = 1;
            }
        }
    }
}


// -800 грн для замовлення від 4500 та 3 товари з різних категорій , Акція була з 20,04,2026)
$arResult['IS_ACTION_APRIL_2026'] = 0;
$uGroups = $USER->GetUserGroupArray();
$isAprilAction = strtotime(date('20.04.2026 00:00:00')) < strtotime(date('d.m.Y H:i:s')) && strtotime(date('d.m.Y H:i:s')) < strtotime(date('31.05.2026 23:59:59'));
if (!in_array(9, $uGroups))
{
    if(($isAprilAction || $USER->IsAdmin()))
    {
        global $DB,$USER;

        $uGroups = explode(',',$USER -> GetGroups());
        $allAmountLeft = 4500;
        $allQuantityLeftSection=$allQuantityLeftSectionAccs=[];
        $activeIndex = -1;
        $excludeSections=[361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311]; // sale + Аксесури + Бонусна шафа
        $bottomSections=[];
        $quantityProduct = 0;

        if(!in_array(9,$uGroups))
        {
            $allSum = $countInAction = 0;
            foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
            {
                $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

                if ($productInfo)
                {
                    $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                    if($findMain = $findMain->Fetch())
                        $productId = $findMain['VALUE'];
                    else $productId = $Row['data']['PRODUCT_ID'];
                }
                else
                    $productId = $Row['data']['PRODUCT_ID'];



                if($Row['data']['QUANTITY'] == 1 && $activeIndex == -1 && $Row['data']['PRICE'] > 800) // 800 - розмір знижки
                    $activeIndex = $index;

                $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID in (352,361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311)'); // sale + Аксесури + Бонусна шафа
                $isSale = $isSale->Fetch() ? true : false;

                if(!$isSale)
                {
                    $fetch=$DB->Query('select * from basket_stims where UF_ID = ' . $Row['data']['ID']);
                    $isSale = $fetch->Fetch() ? true : false;
                }

                if(!$isSale)
                {
                    $quantityProduct += $Row['data']['QUANTITY'];

                    $product = $DB->Query('select * from b_iblock_element where ID = ' . $productId)->Fetch();
                    if(!in_array($product['IBLOCK_SECTION_ID'], $excludeSections))
                        $allQuantityLeftSection[] = $product['IBLOCK_SECTION_ID'];
                    else
                        $allQuantityLeftSectionAccs[] = $product['IBLOCK_SECTION_ID'];

                    $allSum += $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                    $countInAction++;
                    $allAmountLeft -= $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                    $allQuantityLeft -= $Row['data']['QUANTITY'];
                }
                else
                    $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['IS_SALE'] = true;
            }

            $arResult['ALL_QUANTITY_LEFT_SECTION'] = $allQuantityLeftSection;
            $arResult['ALL_QUANTITY_LEFT_SECTION_ACCS'] = $allQuantityLeftSectionAccs;
            $arResult['QUANTITY_PRODUCTS'] = $quantityProduct;

            if($allQuantityLeft <= 0 && $allSum >= 4500 && count(array_unique($allQuantityLeftSection)) >= 3 && $quantityProduct >= 4)
            {
                //$sqls = [];
                //$sqls[]='update b_sale_order set PRICE = PRICE - 800, DISCOUNT_VALUE = 800 where ID = #ORDER_ID#';
                //$arResult['SQLS_ORDER'] = $sqls;
                if($activeIndex != -1)
                {
                    //$arResult['JS_DATA']['GRID']['ROWS'][$activeIndex]['data']['PRICE'] -= 800;
                    $row = $arResult['JS_DATA']['GRID']['ROWS'][$activeIndex];

                    $sqls[] = 'update b_sale_basket set PRICE = '.($row['data']['PRICE']-800).', BASE_PRICE = '.$row['data']['BASE_PRICE'] . ' where ID = ' . $row['id'];
                }
                $arResult['IS_ACTION_APRIL_2026'] = 1;
                $arResult['SQLS'] = $sqls;
            }
        }
    }
}

// -16% грн для замовлення від 3000 з 21,08,2026 до 23,08,2026 включно
global $isJulyAction;
if($isJulyAction)
{
    if (!in_array(9, $uGroups))
    {
        if(($isJulyAction || $USER->IsAdmin()))
        {
            global $DB,$USER;

            $uGroups = explode(',',$USER -> GetGroups());
            $allAmountLeft = 3000;
            $activeIndex = -1;
            $quantityProduct = 0;

            if(!in_array(9,$uGroups))
            {
                $allSum = $countInAction = 0;
                foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
                {
                    $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

                    if ($productInfo)
                    {
                        $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                        if($findMain = $findMain->Fetch())
                            $productId = $findMain['VALUE'];
                        else $productId = $Row['data']['PRODUCT_ID'];
                    }
                    else
                        $productId = $Row['data']['PRODUCT_ID'];

                    $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID in (352,361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311)'); // sale + Аксесури + Бонусна шафа
                    $isSale = $isSale->Fetch() ? true : false;

                    if(!$isSale)
                    {
                        $fetch=$DB->Query('select * from basket_stims where UF_ID = ' . $Row['data']['ID']);
                        $isSale = $fetch->Fetch() ? true : false;
                    }

                    if(!$isSale)
                    {

                        $product = $DB->Query('select * from b_iblock_element where ID = ' . $productId)->Fetch();

                        $allSum += $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                    }
                    else
                        $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['IS_SALE'] = true;
                }

                if($allSum >= 3000)
                {
                    $percent = $allSum * 0.16;
                    $sqls = [];
                    $sqls[]='update b_sale_order set PRICE = PRICE - '.$percent.', DISCOUNT_VALUE = '.$percent.' where ID = #ORDER_ID#';
                    $arResult['SQLS_ORDER'] = $sqls;
                    $arResult['JULY_PERCENT'] = $percent;
                }
            }
        }
    }
}


/*
 // 2+1
if(isset($_GET['sub']))
{
    global $DB,$USER;

    $uGroups = explode(',',$USER -> GetGroups());
    $allAmountLeft = 0;

    if(!in_array(9,$uGroups))
    {
        $allAmountLeft = 3000;
        $allSum = $countInAction = 0;
        foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
        {
            $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

            if ($productInfo)
            {
                $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                if($findMain = $findMain->Fetch())
                    $productId = $findMain['VALUE'];
                else $productId = $Row['data']['PRODUCT_ID'];
            }
            else
                $productId = $Row['data']['PRODUCT_ID'];


            $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID = 352');
            $isSale = $isSale->Fetch() ? true : false;

            if(!$isSale)
            {
                $allSum += $Row['data']['PRICE']*$Row['data']['QUANTITY'];
                $countInAction++;
                $allAmountLeft -= $Row['data']['PRICE']*$Row['data']['QUANTITY'];
            }
            else
                $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['IS_SALE'] = true;
        }

        if($allSum >= 3000)
        {
            $firstPercent = $countInAction > 2 ? 0.3 : 0.2;
            if(isset($_GET['sub']))
            {
                ?><pre><?=print_r($arResult['JS_DATA']['GRID']['ROWS'], 1)?></pre><?
            }
            uasort($arResult['JS_DATA']['GRID']['ROWS'], function ($a, $b) {
                return $a['data']['PRICE'] <=> $b['data']['PRICE'];
            });

            $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);

            if($arResult['JS_DATA']['GRID']['ROWS'][0]['data']['IS_SALE'])
            {
                $temp = $arResult['JS_DATA']['GRID']['ROWS'][0];
                $arResult['JS_DATA']['GRID']['ROWS'][0] = $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1];
                $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1] = $temp;
                $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);
            }

            $temp = $arResult['JS_DATA']['GRID']['ROWS'][0];
            $arResult['JS_DATA']['GRID']['ROWS'][0] = $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1];
            $arResult['JS_DATA']['GRID']['ROWS'][count($arResult['JS_DATA']['GRID']['ROWS']) - 1] = $temp;

            $sqls = [];
            $start = $first = $second = false;
            foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $row)
            {
                if($row['data']['IS_SALE']) continue;
                if($index) $start = true;
                if(!$start && !$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1)
                {
                    if($debug) echo '0<br>';
                    continue;
                }

                //if(!$index && $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] == 1) continue;

                if(!$first)
                {
                    if($row['data']['QUANTITY'] > 1)
                    {
                        if($debug) echo $index.' <- index<br>';
                        if($debug) echo '1<br>';
                        $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                        $first = $row;
                        $first['data']['QUANTITY'] = 1;

                        $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                        $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                        $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                        $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT)
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                    }
                    elseif($row['data']['QUANTITY'] == 1)
                    {
                        if($debug) echo '2<br>';
                        $first = $row;
                        $first['data']['QUANTITY'] = 1;

                        $first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                        $first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*$firstPercent);

                        $sqls[] = 'update b_sale_basket set PRICE = '.$first['data']['PRICE'].', BASE_PRICE = '.$first['data']['BASE_PRICE'] . ' where ID = ' . $first['id'];

                        unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                        continue;
                    }
                }
                elseif(!$second)
                {
                    if($row['data']['QUANTITY'] > 1)
                    {
                        if($debug) echo '3<br>';
                        $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY']--;
                        $second = $row;
                        $second['data']['QUANTITY'] = 1;

                        $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                        $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                        $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$index]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                        $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT)
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                    }
                    elseif($row['data']['QUANTITY'] == 1)
                    {
                        if($debug) echo $index.' <- index<br>';
                        if($debug) echo '4<br>';
                        $second = $row;
                        $second['data']['QUANTITY'] = 1;

                        $second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                        $second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);

                        $sqls[] = 'update b_sale_basket set PRICE = '.$second['data']['PRICE'].', BASE_PRICE = '.$second['data']['BASE_PRICE'] . ' where ID = ' . $second['id'];

                        unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
                        continue;
                    }
                }

                //if(!$arResult['JS_DATA']['GRID']['ROWS'][$index]['QUANTITY']) unset($arResult['JS_DATA']['GRID']['ROWS'][$index]);
            }

            $arResult['JS_DATA']['GRID']['ROWS'] = array_values($arResult['JS_DATA']['GRID']['ROWS']);

            if($first)
            {
                $first['id'] = $first['data']['ID'] = 0;
                //$first['data']['BASE_PRICE'] = $first['data']['PRICE'];
                //$first['data']['PRICE'] = $first['data']['PRICE']-($first['data']['PRICE']*0.3);
                $arResult['JS_DATA']['GRID']['ROWS'][] = $first;
            }
            if($second)
            {
                $second['id'] = $second['data']['ID'] = 0;
                //$second['data']['BASE_PRICE'] = $second['data']['PRICE'];
                //$second['data']['PRICE'] = $second['data']['PRICE']-($second['data']['PRICE']*0.2);
                $arResult['JS_DATA']['GRID']['ROWS'][] = $second;
            }

            $arResult['SQLS'] = $sqls;
        }
    }
}
*/

/*
global $USER;
if( $USER->isAdmin() ){
    echo "<pre>_".print_r($arResult, 1)."_</pre>";
}*/


// 2+1 літня
$availableSections=[375,404,376,400,394,405,1170,1262,379];
$giftSections = [399,400,1277,1276,1286];
$giftProducts = [37335,37332];
$giftNotAvailableProducts = [37310,37311,37312,37305,37306,37307,39414,39415];
$isGift = false;
$countProducts=0;
$indexForAction = -1;
if(isset($_GET['sub']))
{
    global $DB,$USER;

    $uGroups = explode(',',$USER -> GetGroups());
    $allAmountLeft = 0;

    if(!in_array(9,$uGroups))
    {
        $allAmountLeft = 3000;
        $allSum = $countInAction = 0;
        foreach($arResult['JS_DATA']['GRID']['ROWS'] as $index => $Row)
        {
            $productInfo = \CCatalogSKU::GetProductInfo($Row['data']['PRODUCT_ID']);

            if ($productInfo)
            {
                $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['data']['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
                if($findMain = $findMain->Fetch())
                    $productId = $findMain['VALUE'];
                else $productId = $Row['data']['PRODUCT_ID'];
            }
            else
                $productId = $Row['data']['PRODUCT_ID'];

            $res = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId);
            while ($record = $res->Fetch())
            {
                if(in_array($record['IBLOCK_SECTION_ID'], $availableSections))
                    $countProducts += $Row['data']['QUANTITY'];
                if((in_array($record['IBLOCK_SECTION_ID'], $giftSections)  || in_array($productId, $giftProducts)) && !in_array($productId, $giftNotAvailableProducts))
                {
                    $isGift=true;
                    $indexForAction = $index;
                }
            }
        }

        if($countProducts >= 2)
        {
            if($indexForAction>-1)
            {
                if($arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['QUANTITY'] > 1)
                {
                    $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['QUANTITY']--;
                    $row = $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction];


                    $row['data']['BASE_PRICE'] = $row['data']['PRICE'];
                    $row['data']['PRICE'] = 0.01;
                    $row['data']['QUANTITY'] = 1;
                    $arResult['JS_DATA']['GRID']['ROWS'][] = $row;

                    $sqls[] = 'update b_sale_basket set QUANTITY = ' . $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['QUANTITY'] . ' where ID = ' . $row['id'];
                    $sqls[] = 'insert into b_sale_basket (FUSER_ID,PRODUCT_ID,PRICE,CURRENCY,BASE_PRICE,VAT_INCLUDED,DATE_INSERT,DATE_UPDATE,QUANTITY,LID,DELAY,NAME,CAN_BUY,DISCOUNT_PRICE,VAT_RATE,SUBSCRIBE,DEDUCTED,RESERVED,BARCODE_MULTI,CUSTOM_PRICE,SORT)
                            values (\''.$row['data']['FUSER_ID'].'\',\''.$row['data']['PRODUCT_ID'].'\',\''.$row['data']['PRICE'].'\',\''.$row['data']['CURRENCY'].'\',\''.$row['data']['BASE_PRICE'].'\',\''.$row['data']['VAT_INCLUDED'].'\',\''.$row['data']['DATE_INSERT'].'\',\''.$row['data']['DATE_UPDATE'].'\',\''.$row['data']['QUANTITY'].'\',\''.$row['data']['LID'].'\',\''.$row['data']['DELAY'].'\',\''.$row['data']['NAME'].'\',\''.$row['data']['CAN_BUY'].'\',\''.$row['data']['DISCOUNT_PRICE'].'\',\''.$row['data']['VAT_RATE'].'\',\''.$row['data']['SUBSCRIBE'].'\',\'N\',\''.$row['data']['RESERVED'].'\',\''.$row['data']['BARCODE_MULTI'].'\',\'Y\',\''.$row['data']['SORT'].'\')';
                }
                else
                {
                    $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['BASE_PRICE'] = $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['PRICE'];
                    $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction]['data']['PRICE'] = 0.01;
                    $row = $arResult['JS_DATA']['GRID']['ROWS'][$indexForAction];

                    $sqls[] = 'update b_sale_basket set PRICE = '.$row['data']['PRICE'].', BASE_PRICE = '.$row['data']['BASE_PRICE'] . ' where ID = ' . $row['id'];
                }
            }

            $arResult['SQLS'] = $sqls;
        }
    }
}

$arResult['allAmountLeft'] = $allAmountLeft;
$arResult['actionText'] = $indexForAction == -1 && $countProducts >= 2;

if(  false ){
    $uGroups = explode(',',$USER -> GetGroups());
    if(!in_array(9,$uGroups))
    {
        $data = \Local\Sale\CondBasketCategoryCombo::CheckBasket(['BASKET' => $arResult['JS_DATA']['GRID']['ROWS']]);
        $arResult['JS_DATA']['GRID']['ROWS'] = $data['BASKET'];
        $arResult['SQLS'] = $data['SQLS'];
        $arResult['IS_ACTION_08'] = $data['IS_ACTION_08'];
    }
}


/*$sql = 'select * from np_cities_new order by UF_NAME_UA asc';
$res=$DB->Query($sql);
while ($record=$res->Fetch())
    $cities[]=$record;
$arResult['CITIES'] = $cities;*/

