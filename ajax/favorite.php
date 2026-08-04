<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

header('Cache-Control: no-cache');
global $DB,$USER;

CModule::IncludeModule('sale');
if(!$USER -> IsAuthorized())
    $fuserID = Bitrix\Sale\Fuser::getId();
else
    $fuserID = 'u-'.$USER -> GetID();


if($_POST['id'])
{
    $res = $DB->Query('select * from b_iblock_element where ID = ' . $_POST['id'])->Fetch();
    if($res['IBLOCK_ID'] == 25)
        $_POST['id'] = $DB->Query('select * from b_iblock_element_property where IBLOCK_ELEMENT_ID = ' . $_POST['id'] . ' and IBLOCK_PROPERTY_ID = 390')->Fetch()['VALUE'];
}

if(!isset($_SESSION['FAVORITE']))
    $_SESSION['FAVORITE'] = [];

$res = $DB -> Query('select * from favorite where UF_FUSER_ID = \'' . $fuserID.'\'');
while ($record = $res -> Fetch())
    $_SESSION['FAVORITE'][$record['UF_PRODUCT_ID']] = $record['UF_PRODUCT_ID'];

$json = ['result' => 'nothing'];

if($_POST['id'])
{
    if(isset($_SESSION['FAVORITE'][$_POST['id']]))
    {
        unset($_SESSION['FAVORITE'][$_POST['id']]);
        $json['result'] = 'removed';
        $DB->Query('delete from favorite where UF_PRODUCT_ID = ' . $_POST['id'] . ' and UF_FUSER_ID = \''.$fuserID.'\'');
    }
    else
    {
        $_SESSION['FAVORITE'][$_POST['id']] = $_POST['id'];
        $json['result'] = 'added';
        $DB -> Query('insert into favorite (UF_PRODUCT_ID,UF_FUSER_ID) values ('.$_POST['id'].', \''.$fuserID.'\')');
    }
}

if(!isset($_SESSION['UNIC']))$_SESSION['UNIC'] = uniqid();

$json['list'] = $_SESSION['FAVORITE'];
$json['cnt'] = intval(count($_SESSION['FAVORITE']));
//$json['sess_id'] = session_id();
$json['sale_id'] = Bitrix\Sale\Fuser::getId();
$json['unic'] = $_SESSION['UNIC'];
$json['fuserid'] = $fuserID;
echo json_encode($json);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
