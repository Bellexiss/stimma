<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $DB;

$ua = strpos($_REQUEST['url'], '/ru/') === false;
$name = trim($_REQUEST['name']);

$sql = 'select * from ukrposhta_cities where ID = '.$_REQUEST['cityID'];
$items = $itemsUkrPoshta = [];
if($res = $DB -> Query($sql) -> Fetch())
{
    //$sql = 'select * from np_posts where UF_LON > 0 and UF_LAT > 0 and UF_CITY_REF_ID = \''.$res['UF_REF_ID'].'\' and UF_ACTIVE = \'1\' and (UF_TYPE = \'841339c7-591a-42e2-8233-7a0a00f0ed6f\')';
    $sql = 'select * from ukrposhta_posts where UF_CITY_ID = \''.$res['UF_CITY_ID'].'\' and UF_ACTIVE = \'1\'';
    $posts = $DB -> Query($sql);
    while ($record = $posts -> Fetch())
    {
        $items['list_vid'][$record['ID']] = $record['UF_POSTINDEX'] . ', ' . $record['UF_ADDRESS'];
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
