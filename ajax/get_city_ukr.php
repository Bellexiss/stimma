<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;

$ua = strpos($_REQUEST['url'], '/ru/') === false;
$name = trim($_REQUEST['name']);

$sql = 'select * from ukrposhta_cities where UF_CITY_UA like \''.$name.'%\' limit 700';

$res = $DB -> Query($sql);
$items = [];
while ($record = $res -> Fetch())
{
    $items['results'][] = array('id' => $record['ID'], 'text' => $record['UF_CITYTYPE_UA'].', ' . $record['UF_CITY_UA'] .', ' . $record['UF_DISTRICT_UA'] . ' р-н.'.', ' . $record['UF_REGION_UA'] . ' обл.');
}


if(empty($items['results']))
    $items['results'][] = array('id' => 0, 'text' => 'Місто не знайдене');


echo json_encode($items);
