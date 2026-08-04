<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;

$ua = strpos($_REQUEST['url'], '/ru/') === false;

$name = trim($_REQUEST['name']);
/*if(strpos($name, "'") !== false)
{
    $name = explode("'",$name);
    $sql = 'select * from np_cities_new where 
                            (UF_NAME_UA like \'%'.$name[0].'%\' or UF_NAME_RU like \'%'.$name[0].'%\')
                            and
                            (UF_NAME_UA like \'%'.$name[1].'%\' or UF_NAME_RU like \'%'.$name[1].'%\')
                            limit 7';

}
else*/
    $sql = 'select * from np_cities_new where UF_SEARCH_UA like \''.$name.'%\' or UF_SEARCH_RU like \''.$name.'%\'  OR UF_NAME_UA like \''.$name.'%\' or UF_NAME_RU like \''.$name.'%\' limit 15';    //$sql = 'select * from np_cities_new ';

$res = $DB -> Query($sql);/*while ($record = $res -> Fetch()){	echo "<pre>";print_R($record);echo "</pre><br>";}*/
$items = [];
while ($record = $res -> Fetch())
{
    $value = $ua ? $record['UF_NAME_UA'] : $record['UF_NAME_RU'];
    $items['results'][] = array('id' => $record['ID'], 'text' => $value);
}


if(empty($items['results']))
    $items['results'][] = array('id' => 0, 'text' => 'Місто не знайдене');


echo json_encode($items);
