<?
#print_r($_SERVER);
$_SERVER['DOCUMENT_ROOT'] = '/home/stimma/www/stimma.ua/public_html';
//file_put_contents('/home/stimma/www/stimma.ua/update_log.txt', var_export($_SERVER, 1));
require("/home/stimma/www/stimma.ua/public_html/bitrix/modules/main/include/prolog_before.php");

//file_put_contents('/home/stimma/www/stimma.ua/update_np_cities.txt', 'START');

require '/home/stimma/www/stimma.ua/public_html/bitrix/php_interface/classes/NP.php';

$np = NP::getInstance();
//$np -> updatePostList();
$np -> updateCities();
die();