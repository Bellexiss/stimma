<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/qr/php/qrcode.php'); // путь к библиотеке
// Данные для QR-кода

$qr = QRCode::getMinimumQRCode("https://google.com", QR_ERROR_CORRECT_LEVEL_L);

$im = $qr->createImage(10, 4);

header("Content-type: image/png");
imagepng($im, $_SERVER['DOCUMENT_ROOT'].'/upload/qr/qr2.png');

imagedestroy($im);
//generateYMLCatalog();
die();

/*
require_once $_SERVER['DOCUMENT_ROOT'] . '/test2/phpQuery.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/test2/functions.php';

$urls = [
    'https://freelancehunt.com/projects'
];
foreach($urls as $index => $url)
{
    ?><pre><?=print_r($url, 1)?></pre><?
    $html = getContent($url);
    $doc = \phpQuery::newDocument($html);

    $pList = $doc->find('table.project-list');
    ?><pre><?=print_r(pq($pList)->html(), 1)?></pre><?

    foreach($pList->find('tr.featured') as $project)
    {
        $published = pq($project)->attr('data-published');
        $link = pq($project)->find('a.visitable ')->attr('href');
        $name = pq($project)->find('a.visitable ')->text();
        $previewText = pq($project)->find('p')->text();

        echo '--------<br>';
        ?><pre><?=print_r($published, 1)?></pre><?
        ?><pre><?=print_r($link, 1)?></pre><?
        ?><pre><?=print_r($name, 1)?></pre><?
        ?><pre><?=print_r($previewText, 1)?></pre><?
    }

    echo 'item end<br>';
}

die();*/

global $DB;

$res = $DB->Query('select * from b_sale_discount_coupon where DESCRIPTION like \'%for registration%\'');
?>
<table>
    <tr>
        <td>EMAIL</td>
        <td>COUPON</td>
    </tr>
<?
while ($record = $res->Fetch())
{
    preg_match('/(\d+)/', $record['DESCRIPTION'], $matches);

    $email = '';
    if($matches[1] > 0)
    {
        $user = $DB->Query('select * from b_user where ID = '.$matches[1])->Fetch();
        $email = $user['EMAIL'];
    }

    ?>
    <tr>
        <td><?=$record['COUPON']?></td>
        <td><?=$email?></td>
    </tr>
    <?
}
?></table><?
//b_catalog_discount_coupon
	//b_sale_discount_coupon
	//b_sale_order_coupons
