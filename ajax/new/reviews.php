<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$ua = strpos($_REQUEST['url'], '/ru/') === false;

$success = 0;
//if(isset($_POST['reviews-id-product']))
{
    CModule::IncludeModule('iblock');
    /*if(intval($_POST['reviews-id-product']) <= 0)
    {
        $text = $ua ? 'Помилка відгуку.' : 'Ошибка отзыва.';
        include_once $_SERVER['DOCUMENT_ROOT'].'/ajax/targets/tnks.php';
        die();
    }*/
    $sections = [];

    if($_POST['reviews-id-product'] > 0)
    {
        $productSection = CIBlockElement::GetByID($_POST['reviews-id-product']) -> Fetch()['IBLOCK_SECTION_ID'];
        $section = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 35, 'UF_PRODUCT' => $_POST['reviews-id-product']), false, array('ID'));
        if(!$section = $section -> Fetch())
        {
            $product = CIBlockElement::GetByID($_POST['reviews-id-product']) -> Fetch();
            $bs = new CIBlockSection;
            $section = $bs -> Add([
                                      "ACTIVE" => 'Y',
                                      "IBLOCK_ID" => 35,
                                      "NAME" => $product['NAME'],
                                      'UF_PRODUCT' => $_POST['reviews-id-product'],
                                  ]
            );
        }
        else
            $section = $section['ID'];

        $nav = CIBlockSection::GetNavChain(21,$productSection);
        while($record = $nav->GetNext())
            $sections[] = $record['ID'];

        if(!$sections)
            $sections = [];
    }
    else
        $section = false;


    //if(!$section)
    //    $success = 0;

    global $USER;

    $arFields = [
            'NAME' => $_POST['name'],
            'PREVIEW_TEXT'=> $_POST['comment'],
            'IBLOCK_ID' => 35,
            'ACTIVE' => 'N',
            'IBLOCK_SECTION_ID' => $section
    ];



    $props = [
            'RATING' => $_POST['star'],
            'USER_ID' => $USER -> GetID(),
            'SECTIONS' => $sections,
            'EMAIL' => $_POST['email'],
    ];

    $arFields['PROPERTY_VALUES'] = $props;

    $el = new CIBlockElement;
    $ID = $el -> Add($arFields);
    if($ID > 0)
        $success = 1;
    else
        $success = 0;
}

echo json_encode(['success' => $success]);
?>