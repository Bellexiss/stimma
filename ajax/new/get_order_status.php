<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;

$order = $DB->Query('select * from b_sale_order where ID = ' . $_POST['order_id'])->Fetch();

if(isset($order['ID']))
    echo json_encode(['status'=>$order['PAYED']]);
else
    echo json_encode(['status'=>'N']);