<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

http_response_code(503); // важно для SEO
?>

<!DOCTYPE html>
<html>
<head>
    <title>Сайт временно недоступен</title>
    <meta charset="utf-8">
</head>
<body style="text-align:center; padding-top:100px;">
<h1>Сайт тимчасово не працює</h1>
<p>Ми вже працюємо над оновленням і зовсім скоро повернемось</p>
</body>
</html>