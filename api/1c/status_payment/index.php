<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


$json = file_get_contents('php://input');
Bitrix\Main\Diag\Debug::writeToFile($json, "status 1 " , '/statut_payment.txt');

$json = json_decode($json);
Bitrix\Main\Diag\Debug::writeToFile($json, "status 2 " , '/statut_payment.txt');
$statused = [];

foreach($json as $index => $item)
{
    if($item->StatusCode == 1)
    {
        global $DB;
        $oid = $item->order_id;
        $DB->Query('update payments set UF_TO_1C = 1 where UF_ORDER_ID = ' . $oid);
        $statused[$oid] = 1;
    }
    else
        $statused[$oid] = 0;
}


echo json_encode($statused);
die();
