<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

CModule::IncludeModule('iblock');

$taliaValue = $_POST['talia'];
$grudValue = $_POST['grud'];
$bedraValue = $_POST['bedra'];

$talia = [
    /*'40-xs' => range(62,66),
    '42-s' => range(67,70),
    '44-m' => range(71,74),
    '46-l' => range(75,78),
    '48-xl' => range(79,80),
    '50-xxl' => range(91,94),
    '52-xxxl' => range(95,98),
    '54-xxxxl' => range(99,102),*/

    //'xxs' => range(58,61),
    'xs' => range(62,66),
    's' => range(66,70),
    'm' => range(70,74),
    'l' => range(74,78),
    'xl' => range(78,82),
    'xxl' => range(82,86),
    'xxxl' => range(86,90),
    'xxxxl' => range(90,94),
];

$grud = [
    /*'40-xs' => range(81,84),
    '42-s' => range(85,88),
    '44-m' => range(89,92),
    '46-l' => range(93,96),
    '48-xl' => range(97,100),
    '50-xxl' => range(101,104),
    '52-xxxl' => range(105,108),
    '54-xxxxl' => range(113,116),*/

    //'xxs' => range(76,79),
    'xs' => range(80,84),
    's' => range(84,88),
    'm' => range(88,92),
    'l' => range(92,96),
    'xl' => range(96,100),
    'xxl' => range(100,104),
    'xxxl' => range(104,108),
    'xxxxl' => range(112,116),
];

$bedra = [
    /*'40-xs' => range(86,90),
    '42-s' => range(91,94),
    '44-m' => range(95,98),
    '46-l' => range(99,102),
    '48-xl' => range(103,106),
    '50-xxl' => range(107,110),
    '52-xxxl' => range(111,114),
    '54-xxxxl' => range(115,118),*/

    //'xxs' => range(82,85),
    'xs' => range(86,90),
    's' => range(90,94),
    'm' => range(94,98),
    'l' => range(98,102),
    'xl' => range(102,106),
    'xxl' => range(106,110),
    'xxxl' => range(110,114),
    'xxxxl' => range(114,118),
];

$pluses = [
    'xs' => ['plus' => 's', 'minus'=>''],
    's' => ['plus' => 'm', 'minus'=>'xs'],
    'm' => ['plus' => 'l', 'minus'=>'s'],
    'l' => ['plus' => 'xl', 'minus'=>'m'],
    'xl' => ['plus' => 'xxl', 'minus'=>'l'],
    'xxl' => ['plus' => 'xxxl', 'minus'=>'xl'],
    'xxxl' => ['plus' => 'xxxxl', 'minus'=>'xxl'],
    'xxxxl' => ['plus' => '', 'minus'=>'xxxl'],
];

$productID = $_POST['id'];
$element = CIBlockElement::GetByID($productID)->Fetch();

if($element['IBLOCK_ID'] == 25)
{
    $element = CIBlockElement::GetByID($productID)->GetNextElement();
    $Props = $element->GetProperties();
    $mainID = $Props['CML2_LINK']['VALUE'];
}
else
    $mainID = $productID;

$product = CIBlockElement::GetByID($mainID)->GetNextElement();
$pProps = $product->GetProperties();
$pFields = $product->GetFields();



if($pProps['SILUET']['VALUE_ENUM_ID'] == 1376)
    $siluet = 1; // приталений
if($pProps['SILUET']['VALUE_ENUM_ID'] == 1377)
    $siluet = 2; // напівприталений
if($pProps['SILUET']['VALUE_ENUM_ID'] == 1378)
    $siluet = 3; // оверсайз

$taliaCheck = $grudCheck = $bedraCheck = false;

if(in_array($pFields['IBLOCK_SECTION_ID'], [367,370,383,392,507,399,400,508,401,403,404,406,393,509,368,372,369,377,375,389]))
{
    $grudCheck = true;
}
elseif(in_array($pFields['IBLOCK_SECTION_ID'], [376,395,378,379,381,382,396,398,394,405,371,373,506]))
{
    $bedraCheck = true;
}
/*if(in_array($pFields['IBLOCK_SECTION_ID'], [367,370,383,392,507,399,400,508,401,403,404,406]))
{
    $taliaCheck = true;
    $grudCheck = true;
}
elseif(in_array($pFields['IBLOCK_SECTION_ID'], [376,395,378,379,381,382,396,398]))
{
    $bedraCheck = true;
    $taliaCheck = true;
}
elseif(in_array($pFields['IBLOCK_SECTION_ID'], [393,394,509,405,368,372,369,377,411,371,373,375,506,389]))
{
    $bedraCheck = true;
    $taliaCheck = true;
    $grudCheck = true;
}*/

$finds = $unique = [];
if($taliaCheck)
foreach ($talia as $razmerIndex => $items)
    if(in_array($taliaValue, $items))
    {
        $finds['RAZMER'][] = $razmerIndex;
        $unique[$razmerIndex]++;
        $razmer[$razmerIndex]=$razmerIndex;
    }
if($grudCheck)
foreach ($grud as $razmerIndex => $items)
    if(in_array($grudValue, $items))
    {
        $finds['GRUD'][] = $razmerIndex;
        $unique[$razmerIndex]++;
        $razmer[$razmerIndex]=$razmerIndex;
    }
if($bedraCheck)
foreach ($bedra as $razmerIndex => $items)
    if(in_array($bedraValue, $items))
    {
        $finds['BEDRA'][] = $razmerIndex;
        $unique[$razmerIndex]++;
        $razmer[$razmerIndex]=$razmerIndex;
    }




//$razmer = array_intersect($finds['RAZMER'],$finds['GRUD'],$finds['BEDRA']);

if(count($razmer) == 1)
{
    if($siluet == 3)
        $startText = '
                Вам підходить розмір '.strtoupper($razmer[0]).'<br>
                -------------<br>
                Якщо ви любите оверсайзх, сміливо обирайте '.strtoupper($razmer[0]).', а якщо полюбляєте більш приталеному - 70% '.strtoupper($razmer[0]).' або 30% '.strtoupper($pluses[$razmer[0]]['minus']).'
                ';

    if($siluet==1 || $siluet==2)
        $startText = '
                    Вам підходить розмір '.strtoupper($razmer[0]).'<br>
                    -------------<br>
                    Якщо ви любите приталений, сміливо обирайте '.strtoupper($razmer[0]).', якщо полюбляєте більш вільний - 70% '.strtoupper($razmer[0]).' або 30% '.strtoupper($pluses[$razmer[0]]['plus']).'
                    ';

    //$startText = '<span> 66%</span> відповідність до ваших параметрів - це розмір '.$cache[0] . ' ('.strtoupper($cache[1].')');
}
else
{
    if($ua)
        $startText = 'На жаль, ми не можемо підібрати вам розмір. Спробуйте інші параметри';
    else
        $startText = 'К сожалению, мы не можем подобрать вам размер. Попробуйте другие параметры';
}
// якщо M і L по таблиці - беремо L і далі правила такі самі.
//
//якщо 3 - потрібен якийсь текст.

ob_start();
/*
$productID = $_POST['id'];
$element = CIBlockElement::GetByID($productID)->Fetch();

if($element['IBLOCK_ID'] == 25)
{
    $element = CIBlockElement::GetByID($productID)->GetNextElement();
    $Props = $element->GetProperties();
    $mainID = $Props['CML2_LINK']['VALUE'];
}
else
    $mainID = $productID;

$findAddBasket = [];

if(count($unique) == 3)
{
    $type = 3;
    if($ua)
        $startText = 'На жаль, ми не можемо підібрати вам розмір. Спробуйте інші параметри';
    else
        $startText = 'К сожалению, мы не можем подобрать вам размер. Попробуйте другие параметры';
}
if(count($unique) == 2)
{
    $type = 2;
    $razmerType2 = $forSql = [];
    foreach ($unique as $index => $item)
    {
        $cache = explode('-', $index);
        $razmerType2[] = $cache[0] . ' ('.strtoupper($cache[1].')');

        $forSql[$cache[0]] = "'".$cache[0]."'";
        $forSql[$cache[1]] = "'".$cache[1]."'";
        $forSql[strtoupper($cache[1])] = "'".strtoupper($cache[1])."'";

        if($item == 2)
        {
            if($ua)
                $startText = '<span> 66%</span> відповідність до ваших параметрів - це розмір '.$cache[0] . ' ('.strtoupper($cache[1].')');
            else
                $startText = '<span> 66%</span> соответственность к вашим параметрам - это размер '.$cache[0] . ' ('.strtoupper($cache[1].')');
            $showSize = $cache[0] . ' ('.strtoupper($cache[1].')');
        }
    }
}
if(count($unique) == 1)
{
    $type = 1;
    foreach ($unique as $index => $item)
        $razmer = $index;
    $cache = explode('-', $razmer);

    $forSql[$cache[0]] = "'".$cache[0]."'";
    $forSql[$cache[1]] = "'".$cache[1]."'";
    $forSql[strtoupper($cache[1])] = "'".strtoupper($cache[1])."'";

    $showSize = $cache[0] . ' ('.strtoupper($cache[1].')');
    if($ua)
        $startText = '<span> 100%</span> відповідність до ваших параметрів - це розмір '.$cache[0] . ' ('.strtoupper($cache[1].')');
    else
        $startText = '<span> 100%</span> соответственность к вашим параметрам - это размер '.$cache[0] . ' ('.strtoupper($cache[1].')');
}

if($type == 1 || $type == 2)
{
    $res = $DB -> Query('select * from b_iblock_property_enum where PROPERTY_ID = 619 and VALUE in ('.implode(',',$forSql).')');
    $idsEnum = [];
    while ($record = $res -> Fetch())
        $idsEnum[strtolower($record['VALUE'])] = $record['ID'];

    if(!empty($idsEnum))
    {
        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 25, 'ACTIVE'=>'Y', 'PROPERTY_CML2_LINK' => $mainID, 'PROPERTY_RAZMER' => $idsEnum],false,false,['ID','IBLOCK_ID','PROPERTY_RAZMER']);
        $products = [];
        while ($record = $res -> Fetch())
        {
            $products[$record['ID']] = $record['PROPERTY_RAZMER_VALUE'];
            $findAddBasket[$record['ID']] = $record['ID'];
        }
        if(!empty($products) && count($products) == 1)
        {
            if($ua)
                $endText = 'Розміри, доступні для даного виробу: '.implode(', ',$products);
            else
                $endText = 'Размеры, доступные для данного изделия: '.implode(', ',$products);
        }
        else
        {
            if($ua)
            {
                $endText = 'На жаль, для даного виробу підібраних розмірв не існує або ж нема в наявності<br>';
                $endText.='Щоб спробувати знайти інші вироби цього розміру, перейдіть за посиланням нижче<br>';
            }
            else
            {
                $endText = 'К сожалению, для данного изделия подобраннызх товаров не существует или нет в наличии<br>';
                $endText.='Что бы попробовать найти другие изделия этого размера, перейдите за ссылкой ниже<br>';
            }


            $url = str_replace('https://stimma.ua/','/',$_POST['url']);
            $cacheUrl = explode('/',$url);
            unset($cacheUrl[count($cacheUrl)-2]);
            $cacheUrl = implode('/',$cacheUrl);
            $textUrls = [];
            foreach ($idsEnum as $value => $item)
            {
                if(intval($value) > 0) continue;
                $oldUrl = $cacheUrl.'filter/razmer-is-'.$value.'/apply/';
                $findLink = str_replace('/ru/','/',$oldUrl);
                $res = CIBlockElement::GetList([], ['IBLOCK_ID'=>40,'PROPERTY_OLD_LINK'=>$findLink],false,false,['ID','IBLOCK_ID','PROPERTY_NEW_LINK']);
                if($res = $res->Fetch())
                {
                    $oldUrl = !$ua ? str_replace('/catalog/','/ru/catalog/',$res['PROPERTY_NEW_LINK_VALUE']) : $res['PROPERTY_NEW_LINK_VALUE'];
                }

                if($ua)
                    $textUrls[] = '<a href="'.$oldUrl.'">Знайти розмір '.strtoupper($value).'</a><br>';
                else
                    $textUrls[] = '<a href="'.$oldUrl.'">Найти размер '.strtoupper($value).'</a><br>';
            }

            $endText .= implode('',$textUrls);

        }
    }
}
else
    $endText = '';

?>
    <div class="size-info-text">
        <?=$startText?>
    </div>
    <?
    if($type!=3)
    {
        ?>
        <div class="size-info-main">
            <?=$showSize?>
        </div>
        <div class="size-calc-cont">
            <?
            if($type == 1)
            {
               ?>
                <div class="size-calc-item item1">
                    <div class="size-calc-key">
                        <?=$cache[0] . ' ('.strtoupper($cache[1].')')?>
                    </div>
                    <div class="size-calc-slider-cont">
                        <div class="size-calc-bar" style="width:100%"></div>
                    </div>
                    <div class="size-calc-value">
                        100%
                    </div>
                </div>
                <?
            }
            elseif($type==2)
            {
                ?>
                <div class="size-calc-item item1">
                    <div class="size-calc-key">
                        <?=$razmerType2[0]?>
                    </div>
                    <div class="size-calc-slider-cont">
                        <div class="size-calc-bar" style="width:67%"></div>
                    </div>
                    <div class="size-calc-value">
                        66%
                    </div>
                </div>
                <div class="size-calc-item item1">
                    <div class="size-calc-key">
                        <?=$razmerType2[1]?>
                    </div>
                    <div class="size-calc-slider-cont">
                        <div class="size-calc-bar" style="width:33%"></div>
                    </div>
                    <div class="size-calc-value">
                        33%
                    </div>
                </div>
                <?
            }
            ?>
        </div>
        <div class="size-info-dop-text">
            <?=$endText?>

        </div>
        <?
    }
    ?>


<?
*/
$razmer = array_values($razmer);
//echo $startText;
if(count($razmer) == 1 || count($razmer) == 2)
{
    if(count($razmer) == 2)
        $razmer[0] = $razmer[1];
    ?>
    <div class="size-info-text">
        <?='Вам підходить розмір '.strtoupper($razmer[0])?>
    </div>
    <div class="size-info-main">
        <?=strtoupper($razmer[0])?>
    </div>
    <div class="size-calc-cont">
        <div class="size-calc-item item1">
            <div class="size-calc-key">
                <?
                echo strtoupper($razmer[0]);
                ?>
            </div>
            <div class="size-calc-slider-cont">
                <div class="size-calc-bar" style="width:70%"></div>
            </div>
            <div class="size-calc-value">
                70%
            </div>
        </div>
        <div class="size-calc-item item1">
            <div class="size-calc-key">
                <?
                if($siluet == 3)
                    echo strtoupper($pluses[$razmer[0]]['minus']);
                else
                    echo strtoupper($pluses[$razmer[0]]['plus'])
                ?>
            </div>
            <div class="size-calc-slider-cont">
                <div class="size-calc-bar" style="width:30%"></div>
            </div>
            <div class="size-calc-value">
                30%
            </div>
        </div>
    </div>
    <div class="size-info-dop-text">
        <?
        if($siluet == 3)
            echo 'Звертаємо Вашу увагу, що виріб <strong>оверсайз крою</strong>, тому якщо ви надаєте перевагу вільній посадці, то обирайте розмір '.strtoupper($razmer[0]).', а якщо більш приталений, то розмір '.strtoupper($pluses[$razmer[0]]['minus']);
        elseif($siluet==1 || $siluet==2)
            echo 'Звертаємо Вашу увагу, що виріб напівприталеного силуету. Рекомендуємо обирати ваш звичний розмір - '.strtoupper($razmer[0]).'. Якщо полюбляєте більш вільний крій, зверніть увагу на розмір '.strtoupper($pluses[$razmer[0]]['plus']);
        ?>
    </div>
    <?
}
else
{
    if($ua)
        $startText = 'На жаль, ми не можемо підібрати вам розмір. Спробуйте інші параметри';
    else
        $startText = 'К сожалению, мы не можем подобрать вам размер. Попробуйте другие параметры';
}

$html = ob_get_contents();


?><pre><?=print_r(array_intersect($finds['RAZMER'],$finds['GRUD'],$finds['BEDRA']), 1)?></pre><?
?><pre><?=print_r($finds, 1)?></pre><?
?><pre><?=print_r($unique, 1)?></pre><?

global $APPLICATION;
$APPLICATION->RestartBuffer();
$findAddBasket = [];
echo json_encode(['html'=>$html, 'add_to_basket'=>implode(',',$findAddBasket), 'button_add_basket'=>(!empty($findAddBasket))]);
?>