<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

global $DB;

$stims = file_get_contents('php://input');
$stims = json_decode($stims);

$stims = (array)$stims;

Bitrix\Main\Diag\Debug::writeToFile($stims, "start get order " , '/log_1c/___1c_stims_history.txt');
file_put_contents($_SERVER['DOCUMENT_ROOT'].'___1c_stims_history.php','<?$stims='.var_export($stims,true).';');

//stims_history
foreach ($stims['bonuses'] as $index => $bonus)
{
    if($bonus->checkNumber)
    {
        $find = $DB->Query('select * from stims_history where UF_CHECK_NUMBER = \'' . $bonus->checkNumber .'\'')->Fetch();

        if(!$find || !isset($find['ID']))
        {
            $date = DateTime::createFromFormat('Ymd\THis', $bonus->date);
            $timestamp = $date->getTimestamp();
            $DB->Query('insert into stims_history 
            (UF_DATE_X,UF_XML_ID,UF_SUM_INCOME,UF_EXPENDITURE,UF_SUM_INCOME_TEMP,UF_SUM_EXPENDITURE_TEMP,UF_CHECK_NUMBER)
            values 
            (
             '.$timestamp.',
            \''.$bonus->xml_id.'\',
            \''.$bonus->sumIncome.'\',
            \''.$bonus->sumExpenditure.'\',
            \''.$bonus->sumIncomeTemp.'\',
            \''.$bonus->sumExpenditureTemp.'\',
            \''.$bonus->checkNumber.'\'
            )'
            );
        }

    }
}





