<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Bitrix\Main\Diag\Debug::writeToFile(1, "start status " , '/test_status_order.txt');

$json = file_get_contents('php://input');
Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 1 " , '/test_status_order.txt');
$json = json_decode($json);

if(isset($json->id))
{
    $status = false;
    switch($json->Status)
    {
        case '000000001': $status =  'Знайшов дешевше'; break;
        case '000000002': $status =  'sp'; break;
        case '000000003': $status =  'ro'; break;
        case '000000004': $status =  'nm'; break;
        case '000000005': $status =  'no'; break;
        case '000000006': $status =  'відмова від отримання'; break;
        case '000000007': $status =  'D'; break;
        case '000000008': $status =  'дрібний брак'; break;
        case '000000009': $status =  'TR'; break;
        case '000000010': $status =  'nc'; break;
        case '000000011': $status =  'ts'; break;
        case '000000012': $status =  'zb'; break;
        case '000000013': $status =  'in'; break;
        case '-1': $status =  'P'; break;
        case '-2': $status =  'F'; break;
    }

    if($status)
        CSaleOrder::Update($json->id, array('STATUS_ID'=>$status));
}

Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 2 " , '/test_status_order.txt');

Bitrix\Main\Diag\Debug::writeToFile(var_export(file_get_contents('php://input'), 1), "status_order " , '/test_status_order.txt');
Bitrix\Main\Diag\Debug::writeToFile($json, "status_order 3 " , '/test_status_order.txt');


echo json_encode(['status'=>1]);
die();
