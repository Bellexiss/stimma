<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule('iblock');



global $USER;
if (!$USER -> IsAdmin())
{
    die('You dont have access to this page.');
}
if(!empty($_POST))
{
    unset($_POST['save']);
    foreach ($_POST as $code => $values)
    {
        $values['name_ua'] = trim($values['name_ua']);
        if (!$values['name_ua']) unset($_POST[$code]['name_ua']);
        if($values['values'])
        {
            foreach ($values['values'] as $xml_id => $value)
            {
                $value = trim($value);
                if(!$value) unset($_POST[$code]['values'][$xml_id]);
            }
            if(empty($_POST[$code]['values'])) unset($_POST[$code]['values']);
        }

        if(empty($_POST[$code])) unset($_POST[$code]);

    }

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php', '<?$name_ua='.var_export($_POST, 1).';?>');
    LocalRedirect('/translate/');
    exit();
}
//$name_ua
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php'))
    require_once $_SERVER['DOCUMENT_ROOT'].'/upload/name_ua.php';
$arProps = [];
$res = CIBlockProperty::GetList(['SORT' => 'asc'], ['IBLOCK_ID' => 25, 'ACTIVE' => 'Y']);

while ($record = $res -> GetNext())
{
    $arProps[$record['CODE']] = [
            'id' => $record['ID'],
            'name' => $record['NAME'],
            'name_ua' => $name_ua[$record['CODE']]['name_ua'] ? $name_ua[$record['CODE']]['name_ua'] : '',
            'code' => $record['CODE'],
            'type' => $record['PROPERTY_TYPE'],
            'u_setting' => $record['USER_TYPE_SETTINGS'],
            'fill' => true,
    ];

    if($record['PROPERTY_TYPE'] == 'L')
    {
        $res2 = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 25, 'CODE' => $record['CODE']]);
        $isUa = true;
        while ($list = $res2 -> Fetch())
        {
            $nua = $name_ua[$record['CODE']]['values'][$list['XML_ID']] ? $name_ua[$record['CODE']]['values'][$list['XML_ID']] : '';
            if(!$nua) $isUa = false;
            $arProps[$record['CODE']]['values'][$list['XML_ID']] = [
                    'id' => $list['ID'],
                    'name' => $list['VALUE'],
                    'name_ua' => $nua,
                    'xml_id' => $list['XML_ID']
            ];
        }
        if(!$isUa)$arProps[$record['CODE']]['fill'] = false;
    }
}

?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <form action="/translate/" method="post">
        <input type="submit" value="Сохранить" name="save">
        <div>
            <table style="width: 20%;float: left"><tr><td></td></tr></table>
            <table class="list" style="width: 60%;float: left">
                <?
                foreach ($arProps as $index => $arItem)
                {
                    $nameUA = $arItem['name_ua'] ? ' / '.$arItem['name_ua'] : '';
                    $color = 'white';
                    if($arItem['name_ua'] && $arItem['fill']) $color = 'lime';
                    elseif($arItem['name_ua'] && !$arItem['fill']) $color = 'yellow';
                    elseif(!$arItem['name_ua'] && $arItem['fill']) $color = 'yellow';
                    elseif(!$arItem['name_ua'] && !$arItem['fill']) $color = '#ff000075';
                    ?>
                    <tr class="first">
                        <td style="background-color: <?=$color?>;"><?=$arItem['name']?><?=$nameUA?></td>
                    </tr>
                    <tr class="second" style="display:none">
                        <td>
                            <table class="values" style="width: 100%;">
                                <tr><td>
                                        Название UA: <input name="<?=$arItem['code']?>[name_ua]" value="<?=$arItem['name_ua'] ? $arItem['name_ua'] : ''?>" type="text">
                                    </td></tr>
                            </table>
                        <?
                        if($arItem['values'])
                        {
                            ?>
                            <table class="values" style="width: 100%;">
                            <tr>
                                <td>RU</td>
                                <td>UA</td>
                            </tr>
                            <?
                            foreach ($arItem['values'] as $indexVal => $value)
                            {
                                ?>
                                <tr>
                                    <td class="ru_name" style="width: 50%;"><?=$value['name']?></td>
                                    <td class="ua_name" style="width: 50%;"><input name="<?=$arItem['code']?>[values][<?=$value['xml_id']?>]" value="<?=$value['name_ua'] ? $value['name_ua'] : ''?>" type="text"></td>
                                </tr>
                                <?
                            }
                            ?></table><?
                        }
                        ?>
                        </td>
                    </tr>
                    <?
                }
                ?>
            </table>
            <table style="width: 20%;float: left"><tr><td></td></tr></table>
        </div>
    </form>
<div style="clear:both"></div>
    <script>
        $(document).ready(function()
        {
            $(document).on('click', 'table.list tr.first td', function()
            {
                $('table.list tr td').removeClass('active');
                $(this).addClass('active');
                $('tr.second').hide();
                $(this).closest('tr').next('tr').show();
            });
        });
    </script>
    <style>
        table.list tr td{cursor:pointer;text-align: center;}
        table.list tr td.active{color:red;}
        table.values{border:1px solid black;}
        table.values tr td.ru_name{text-align: right;}
        table.values tr td.ua_name{text-align: left;}
    </style>
<?
?>