<?
$_SERVER['DOCUMENT_ROOT'] = '/home/stimma/www/stimma.com.ua/public_html';
//mail('company703@gmail.com', 'np_posts.php', var_export($_SERVER, 1));
//file_put_contents('/home/stimma/www/stimma.com.ua/public_html/update_log.txt', var_export($_SERVER, 1));

require("/home/stimma/www/stimma.com.ua/public_html/bitrix/modules/main/include/prolog_before.php");

//Bitrix\Main\Diag\Debug::writeToFile('START', "debug_b24 " , '/update_np_posts.txt');
//file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', 'START');
require '/home/stimma/www/stimma.com.ua/public_html/bitrix/php_interface/classes/NP.php';

$np = NP::getInstance();
$np -> updatePostList();
//$np -> updateCities();
die();