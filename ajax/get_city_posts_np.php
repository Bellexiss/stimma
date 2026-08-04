<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;

$ua = strpos($_REQUEST['url'], '/ru/') === false;
$name = trim($_REQUEST['name']);

function numericKeySort($a, $b) {
    return $a - $b;
}

$sql = 'select * from np_cities_new where ID = '.$_REQUEST['cityID'];

$items = $itemsUkrPoshta = [];
if($res = $DB -> Query($sql) -> Fetch())
{
    //$sql = 'select * from np_posts where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and UF_ACTIVE = \'1\' and (UF_TYPE = \'841339c7-591a-42e2-8233-7a0a00f0ed6f\')';
    $sql = 'select * from np_posts_new where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and UF_ACTIVE = \'1\' and (UF_TYPE = \'841339c7-591a-42e2-8233-7a0a00f0ed6f\' or UF_TYPE = \'f9316480-5f2d-425d-bc2c-ac7cd29decf0\' or UF_TYPE = \'9a68df70-0267-42a8-bb5c-37f427e36ee4\') order by UF_TYPE asc';
    $sql = 'select * from np_posts_new where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and (UF_TYPE = \'841339c7-591a-42e2-8233-7a0a00f0ed6f\' or UF_TYPE = \'f9316480-5f2d-425d-bc2c-ac7cd29decf0\' or UF_TYPE = \'9a68df70-0267-42a8-bb5c-37f427e36ee4\') order by UF_TYPE asc';

    if(isset($_GET['type']) &&$_GET['type'] == 'viddilennya')
        $sql ='select * from np_posts_new where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and (UF_TYPE = \'9a68df70-0267-42a8-bb5c-37f427e36ee4\' or UF_TYPE = \'841339c7-591a-42e2-8233-7a0a00f0ed6f\') order by UF_TYPE asc';
    elseif(isset($_GET['type']) &&$_GET['type'] == 'pochtomat')
        $sql ='select * from np_posts_new where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and (UF_TYPE = \'f9316480-5f2d-425d-bc2c-ac7cd29decf0\') order by UF_TYPE asc';

    $posts = $DB -> Query($sql);
    $records = $lists = [];
    while ($record = $posts -> Fetch())
    {
        $records[intval($record['UF_NUMBER'])] = $record;
        //$lists[$record['UF_TYPE']][intval($record['UF_NUMBER'])] = $record;
        //$records[intval($record['UF_NUMBER'])] = $ua ? '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_UA'] : '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_RU'];
    }
    //asort($records);
    uksort($records, 'numericKeySort');



    //while ($record = $posts -> Fetch())
    foreach($records as $index => $record)
    {
        //if($record['UF_TYPE'] == '841339c7-591a-42e2-8233-7a0a00f0ed6f')
            $items['list_vid'][$record['ID']] = $ua ? '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_UA'] : '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_RU'];
        //elseif ($record['UF_TYPE'] == 'f9316480-5f2d-425d-bc2c-ac7cd29decf0')
        //    $items['list_vid_pocht'][$record['ID']] = $ua ? '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_UA'] : '№'.$record['UF_NUMBER'].' ' .$record['UF_SHORT_ADRESS_RU'];
    }
}

ob_start();
?><option value="-1"><?=$ua ? 'Виберіть відділення' : 'Выберите отделение'?></option><?
foreach ($items['list_vid'] as $id => $item)
{
    ?>
    <option  value="<?=$id?>"><?=$item?></option>
    <?
}
$html = ob_get_clean();

$items['html_vid'] = $html;

echo json_encode($items);
