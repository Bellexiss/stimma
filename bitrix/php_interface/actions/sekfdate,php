<?/*<pre><?= print_r($basket) ?></pre>*/?>
<?
global $DB,$USER;
$uGroups = $USER->GetUserGroupArray();
if (!in_array(9, $uGroups))  
{
    

$allAmountLeft = 0;
$allQuantityLeft=3;

$allQuantityLeftSection=$allQuantityLeftSectionAccs=[];
$activeIndex = -1;
$excludeSections=[361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410,1311]; // sale + Аксесури + Бонусна шафа
$bottomSections=[];
$quantityProduct = 0;

    $allQuantityLeft=3;
    $allAmountLeft = 3000;
    $allSum = $countInAction = 0;
    foreach($basket['ITEMS'] as $index => $Row)
    {
        $productInfo = \CCatalogSKU::GetProductInfo($Row['PRODUCT_ID']);

        if ($productInfo)
        {
            $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $Row['PRODUCT_ID'] . ' and IBLOCK_PROPERTY_ID = 390');
            if($findMain = $findMain->Fetch())
                $productId = $findMain['VALUE'];
            else $productId = $Row['PRODUCT_ID'];
        }
        else
            $productId = $Row['PRODUCT_ID'];


        $isSale = $DB->Query('select * from b_iblock_section_element where IBLOCK_ELEMENT_ID = ' . $productId . ' and IBLOCK_SECTION_ID in (352,361,1286,1276,1262,411,407,1290,1170,1277,413,409,408,410)'); // sale + Аксесури
        $isSale = $isSale->Fetch() ? true : false;

        $fetch=$DB->Query('select* from basket_stims where UF_ID = ' . $Row['ID']);
        $isSale = $fetch->Fetch() ? true : false;


        if(!$isSale)
        {
            $product = $DB->Query('select * from b_iblock_element where ID = ' . $productId)->Fetch();
            if(!in_array($product['IBLOCK_SECTION_ID'], $excludeSections) && $product['IBLOCK_SECTION_ID'])
                $allQuantityLeftSection[] = $product['IBLOCK_SECTION_ID'];
            elseif($product['IBLOCK_SECTION_ID'])
                $allQuantityLeftSectionAccs[] = $product['IBLOCK_SECTION_ID'];

            $allSum += $Row['PRICE']*$Row['QUANTITY'];
            $countInAction++;
            $allAmountLeft -= $Row['PRICE']*$Row['QUANTITY'];
            $allQuantityLeft -= $Row['QUANTITY'];
        }
        else
            $basket['ITEMS'][$index]['IS_SALE'] = true;
    }

    $basket['ACTION']['ALL_QUANTITY_LEFT_SECTION'] = $allQuantityLeftSection;
    $basket['ACTION']['ALL_QUANTITY_LEFT_SECTION_ACCS'] = $allQuantityLeftSectionAccs;
    $basket['ACTION']['QUANTITY_PRODUCTS'] = $quantityProduct;

    if(count(array_unique($allQuantityLeftSection)) == 2)
        $basket['ACTION']['TEXT']=LANGUAGE_ID == 'ua' ? 'Додай речі ще з однієї категорії, щоб отримати знижку -15%': 'Добавьте вещи еще из одной категории, чтобы получить скидку -15%';
    elseif(count(array_unique($allQuantityLeftSection)) == 1)
        $basket['ACTION']['TEXT']=LANGUAGE_ID == 'ua' ? 'Додай речі ще з двох різних категорій, щоб отримати знижки -15% та -30%': 'Добавьте вещи еще из двух разных категорий, чтобы получить скидки -15% и -30%';
    elseif(count(array_unique($allQuantityLeftSection)) >= 3)
        $basket['ACTION']['TEXT_SUCC']=LANGUAGE_ID == 'ua' ? 'Вітаємо! Знижка -15% на другу річ та -30% на третю вже твоя' : 'Поздравляем! Скидка -15% на вторую вещь и -30% на третью уже ваша';

    //if($allSum >= 3000)
    if($allQuantityLeft <= 0 && $allSum >= 0 && count(array_unique($allQuantityLeftSection)) >= 3)
    {
        $firstPercent = $countInAction > 2 ? 0.3 : 0.15;
        $secondPercent = $countInAction > 2 ? 0.15 : 0.15;

        uasort($basket['ITEMS'], function ($a, $b) {
            return $a['PRICE'] <=> $b['PRICE'];
        });

        $basket['ITEMS'] = array_values($basket['ITEMS']);

       

        $start = $first = $second = $fDel = $sDel = false;
        
        foreach($basket['ITEMS'] as $index => $row)
        {
            if($row['IS_SALE']) continue;


            if(!$first)
            {
                if($row['QUANTITY'] > 1)
                {
                    $fDel = true;
                    $basket['ITEMS'][$index]['QUANTITY']--;
                    $first = $row;
                    $first['QUANTITY'] = 1;

                    $first['CURRENT_PRICE']['DISCOUNT_PRICE'] = $first['PRICE']-($first['PRICE']*$firstPercent);
                }
                elseif($row['QUANTITY'] == 1)
                {
                    $first = $row;
                    $first['QUANTITY'] = 1;

                    $first['CURRENT_PRICE']['DISCOUNT_PRICE'] = $first['PRICE']-($first['PRICE']*$firstPercent);

                    unset($basket['ITEMS'][$index]);
                    continue;
                }
            }
            elseif(!$second)
            {
                if($row['QUANTITY'] > 1)
                {
                    $sDel = true;
                    $basket['ITEMS'][$index]['QUANTITY']--;
                    $second = $row;
                    $second['QUANTITY'] = 1;

                    $second['CURRENT_PRICE']['DISCOUNT_PRICE'] = $second['PRICE']-($second['PRICE']*$secondPercent);

                }
                elseif($row['QUANTITY'] == 1)
                {
                    $second = $row;
                    $second['QUANTITY'] = 1;

                    $second['CURRENT_PRICE']['DISCOUNT_PRICE'] = $second['PRICE']-($second['PRICE']*$secondPercent);

                    unset($basket['ITEMS'][$index]);
                    continue;
                }
            }

        }

        $basket['ITEMS'] = array_values($basket['ITEMS']);

        $amountDiscount = 0;
        if($first)
        {
            if($fDel)
                $first['id'] = $first['ID'] = 0;
            //$first['BASE_PRICE'] = $first['BASE_PRICE'];
            //$first['PRICE'] = $first['PRICE'];
            $basket['ITEMS'][] = $first;
            $amountDiscount += $first['PRICE'] - $first['CURRENT_PRICE']['DISCOUNT_PRICE'];
        }
        if($second)
        {
            if($sDel)
                $second['id'] = $second['ID'] = 0;
            //$second['BASE_PRICE'] = $second['BASE_PRICE'];
            //$second['PRICE'] = $second['PRICE'];
            $basket['ITEMS'][] = $second;
            $amountDiscount += $second['PRICE'] - $second['CURRENT_PRICE']['DISCOUNT_PRICE'];
        }

        $basket['ACTION']['IS_ACTION_SELFDATE'] = 1;
        $basket['ACTION']['AMOUNT_DISCOUNT'] = $amountDiscount;
    }
}
?>