<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Bitrix\Main\Diag\Debug::writeToFile(1, "start status " , '/test_status_order.txt');

$json = file_get_contents('php://input');
Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 1 " , '/test_status_order.txt');
$json = json_decode($json);
Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 2 " , '/test_status_order.txt');

Bitrix\Main\Diag\Debug::writeToFile(var_export(file_get_contents('php://input'), 1), "status_order " , '/test_status_order.txt');
Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 3 " , '/test_status_order.txt');

$statused = [];

foreach($json as $index => $item)
{
    if($item->StatusCode)
    {
        global $DB;
        $oid = $item->uid;
        $DB->Query('delete from orders_1c where UF_ORDER_ID = '.$oid);
        $statused[$oid] = 1;
    }
    else
        $statused[$oid] = 1;
}


echo json_encode($statused);
die();
