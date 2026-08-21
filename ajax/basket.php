<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$ru = isset($_POST['url']) && strpos($_POST['url'], '/ru/') !== false;

if($ru)
{
    $site_id = 's1';
}
else
{
    $site_id = 's2';
}

global $DB,$USER;
$fuserID = CSaleBasket::GetBasketUserID();
$res = $DB -> Query('select * from b_sale_basket where FUSER_ID = '.$fuserID.' and ORDER_ID is null and (LID = \'s1\' or LID = \'s2\')');
while ($record = $res -> Fetch())
    $DB -> Query('update b_sale_basket set LID = \''.$site_id.'\' where ID = '.$record['ID']);

CModule::IncludeModule('sale');
/*global $USER;
if( $USER->isAdmin() ){
    $_REQUEST['id'] = 8911;
}*/
$id = intval($_REQUEST['id']);

if($id <= 0 && isset($_REQUEST['id']))
{
    die();
}
$status = 0;
if(isset($_REQUEST['pprocess']) && $_REQUEST['pprocess'] == 'add')
{
    $arGroups = $USER -> GetUserGroupArray();
    $priceData = CCatalogProduct::GetOptimalPrice($id, 1, $arGroups);
    $price = $priceData['PRICE']['PRICE'];
    $element = CIBlockElement::GetByID($id)->Fetch();
    $_POST['cnt'] = intval($_POST['cnt']);
    if($_POST['cnt'] < 1) $_POST['cnt'] = 1;


    $currtime = strtotime(date('d.m.Y H:i:s'));
    $startAction =strtotime('21.08.2026 00:00:01');
    $endAction = strtotime('23.08.2026 23:59:59');
    $isJulyAction = $currtime >= $startAction && $currtime <= $endAction ? 1 : 0;

    if(($id == 47170 || $id == 47171) && $isJulyAction) $price = 0.01;

    $status = CSaleBasket::Add(array(
                                'PRODUCT_ID' => $_REQUEST['id'],
                                'QUANTITY' => $_POST['cnt'],
                                'PRICE' => $price,
                                'PRICE_TYPE_ID' => $priceData['PRICE']['CATALOG_GROUP_ID'],
                                'CURRENCY' => isset($_REQUEST['bys']) && $_REQUEST['bys'] ? 'STI' : 'UAH',
                                'LID' => $site_id,
                                'NAME' => $element['NAME'],
                                //'NOTES' => isset($_REQUEST['bys']) && $_REQUEST['bys'] ? 'S' : '',
                            ));

    if(isset($_REQUEST['bys']) && $_REQUEST['bys'])
    {
        $findMain = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $_REQUEST['id'] . ' and IBLOCK_PROPERTY_ID = 390');
        if($findMain = $findMain->Fetch())
            $productId = $findMain['VALUE'];
        else $productId = $_REQUEST['id'];
        $element = CIBlockElement::GetByID($productId)->GetNextElement()->GetProperties();
        $DB->Query('insert into basket_stims (UF_ID,UF_STIMS) values ('.$status.', '.intval($element['PROP_BONUS_PRICE']['VALUE']).')');
    }

    if($USER->IsAuthorized())
    {
        $time = date('d.m.Y H:i:s');
        $timeX = strtotime($time);
        $DB->Query('insert into forget_basket (UF_BASKET_ID,UF_USER_ID,UF_TIME,UF_TIME_X,UF_SEND,UF_PRODUCT_ID) values ('.$status.', '.$USER->GetID().', \''.$time.'\','.$timeX.',0,'.$_REQUEST['id'].')');
    }

    if(isset($_REQUEST['bysert']) && $_REQUEST['bysert'])
    {
        $productId = $_REQUEST['id'];
        $element = CIBlockElement::GetByID($productId)->GetNextElement()->GetProperties();
        $arr=[
            'sert_name_sender'=>$_REQUEST['sert_name_sender'],
            'sert_tel_sender'=>$_REQUEST['sert_tel_sender'],
            'send_name_receiver'=>$_REQUEST['send_name_receiver'],
            'send_email_receiver'=>$_REQUEST['send_email_receiver'],
            'send_date_receiver'=>$_REQUEST['send_date_receiver'],
            'send_desire'=>$_REQUEST['send_desire'],
        ];
        $DB->Query('insert into basket_stims (UF_ID,UF_SERT_DATA) values ('.$status.', \''.serialize($arr).'\')');
    }
}
elseif(isset($_REQUEST['pprocess']) && $_REQUEST['pprocess'] == 'delete')
{
    CSaleBasket::Delete($_POST['id']);
    $DB->Query('delete from basket_stims where UF_ID = '.$_POST['id']);
}
elseif(isset($_REQUEST['pprocess']) && $_REQUEST['pprocess'] == 'change')
{
    $id = $_POST['id'];
    $val = intval($_POST['val']);

    if($val > 0)
        CSaleBasket::Update($id, ['QUANTITY' => $val]);
}

$basket = getBasket($_POST['url']);

//while (ob_get_level() > 0)    ob_end_flush(); // Или ob_end_clean / ob_end_flush()
//ob_start();
    $htmlBasket = getBasketNewHtml($basket);
    //$htmlBasket = getBasketHtml($basket);
//$htmlBasket = ob_get_clean();


echo json_encode(['basket' => $basket, 'status' => $status, 'html_basket' => $htmlBasket]);
