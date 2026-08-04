<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$res = $DB->Query('select * from payments where UF_TO_1C != 1 || UF_TO_1C is null');
//$res = $DB->Query('select * from payments where 1');
// todo: Костыль для Включения / Выключения ФОП
$setting_fop = COption::GetOptionString("my_module", "setting_fop", "Y");

$result = [];
while ($record = $res->Fetch())
{
    if($record['UF_ORDER_ID']>0)
    {
        $smchId = '';
        if(!empty($record['UF_DATA']) && strpos($record['UF_DATA'], '<status>5</status>') !== false)
        {
            preg_match('/<amount>(.*?)<\/amount>/',$record['UF_DATA'],$matches);
            preg_match('/<timestamp>(.*)<\/timestamp>/',$record['UF_DATA'],$matches2);
            // smch_id — определяет тип платежа (предоплата или полная оплата)

            $xmlData = $record['UF_DATA']; // или напрямую XML-строка

            $xml = new SimpleXMLElement($xmlData);
            $smchId = (string)$xml->transactions->transaction->smch_id;
            //PR($smchId);  
            if($smchId == 15740){
                $rs = 'UA803052990000026001016022063';
            }elseif($smchId == 15283){
                $rs = 'UA823052990000026005046018753';
            }
            elseif($smchId == 16924){
                $rs = 'UA823052990000026008046009242';
            }
            elseif($smchId == 16932)
            {
                $rs = 'UA313052990000026001046004772';
            }
            elseif($smchId == 18597)
            {
                $rs = 'UA663052990000026002036015242';
            }
            /*if($setting_fop != 'Y'){
                $rs = 'UA803052990000026001016022063';
            }*/
            $result[] = [
                'order_id' => $record['UF_ORDER_ID'],
                'amount'=>preg_replace('/\D/','',$matches[1])/100,
                'create_at' => $matches2[1],
                'rs' => $rs
            ];
        }
    }
    else
    {
        $xmlData = $record['UF_DATA']; // или напрямую XML-строка

        $xml = new SimpleXMLElement($xmlData);
        $smchId = (string)$xml->transactions->transaction->smch_id;
        preg_match('/<timestamp>(.*)<\/timestamp>/',$record['UF_DATA'],$matches2);
        //PR($smchId);
        if($smchId == 15740){
            $rs = 'UA803052990000026001016022063';
        }elseif($smchId == 15283){
            $rs = 'UA823052990000026005046018753';
        }
        elseif($smchId == 16924){
            $rs = 'UA823052990000026008046009242';
        }
        elseif($smchId == 16932)
        {
            $rs = 'UA313052990000026001046004772';
        }
        elseif($smchId == 18597)
        {
            $rs = 'UA663052990000026002036015242';
        }
        /*if($setting_fop != 'Y'){
            $rs = 'UA803052990000026001016022063';
        }*/
        $result[] = [
            'order_id' => $record['UF_ORDER_ID'],
            'amount'=>$record['UF_AMOUNT']/100,
            'create_at' => $matches2[1],
            'rs' => $rs,
            'desc' => $record['UF_DESC'],
        ];
    }


}

echo json_encode($result);

