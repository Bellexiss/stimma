<?php

/**
 * @param             $url           URL запроса
 * @param string      $referer       URL источника откуда пришли на страницу
 * @param null        $postdata      Данные для передачи
 * @param bool|string $cookieFile
 *
 * @return mixed HTML
 */
function getContent($url, $referer = FALSE, $postdata = NULL, $cookieFile = FALSE) //проблема с сохранением куки
{
    if (!$cookieFile)
    {
        $cookieFile = __DIR__ . '/tmp/cookie.txt';
    }

    if (!$referer)
    {
        $referer = 'https://www.google.com.ua/search';
    }

//    xpre($cookieFile);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);                        // или без этого, а сразу $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);       //Данные полученные в результате запроса сохраняются в пеерменную
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       //если сервер возвращает редирект - следовать

    //content
//    curl_setopt($ch, CURLOPT_HEADER, true);               //получить заголовки http пакетов в ту же переменную
//    curl_setopt($ch, CURLOPT_NOBODY, true);               //не получать тело документа

    // различные заголовки
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array (
//                                          'X-Requested-With: XMLHttpRequest',
//                                          'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
//                                          )
//  );
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36');
    curl_setopt($ch, CURLOPT_REFERER, $referer);


    //https
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);      //отключает проверки (для https) (написано, что это плохо)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);      //отключает проверки (для https)

    //cookies
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);           //сохранение куки, полученных от сервера, в файл
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);          //передача сохранённых куки на сервер
    //curl_setopt($ch, CURLOPT_COOKIESESSION, true);                    //вкл/откл сессионных куки

    //прокси. тут же можно указать отладочный прокси, но скрипт нужно запустить на локальном хосте, а не на удалённом (или поднять доступный с инета отладочный прокси)
//    curl_setopt($ch, CURLOPT_PROXY, '94.158.70.97:1080');          //прокси, если нужно
//    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4); //тип прокси, http, socks4, socks5 итд

    // таймауты
    curl_setopt($ch, CURLOPT_TIMEOUT, 9);                   //таймаут выполнения cURL функции
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);            //таймаут установки соединения

    if ($postdata)
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $html = curl_exec($ch); //выполнить запрос
    curl_close($ch);
//    xpre($html);
    /*
    if ($html == NULL) {
        $html = "Ошибка: ".curl_errno($ch) . " - " . curl_error($ch);
    }else{
        return $html;
    } */

    return $html;

}


function saveProp($elemID, $prop, $value)
{
    $ELEMENT_ID = $elemID;
    $PROPERTY_CODE = $prop;
    $PROPERTY_VALUE = $value;

    CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
}

function LogUpdate($text, $vid, $idVid, $element)
{
    CModule::IncludeModule('highloadblock');

    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(9)->fetch();
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $arAdd = [
        'UF_TIME' => date('d.m.Y H:i:s'),
        'UF_TEXT' => $text,
        'UF_VID' => $vid . ' (' . $idVid . ')',
        'UF_ELEMENT' => $element,
        'UF_ID_ELEMENT' => $element
    ];

    $entity_data_class::add($arAdd);
}


/**
 * @param string $url     линк на список новостей
 * @param string $referer линк-откуда пришли
 *
 * @return array Массив анонсов новостей с сылками
 */
function parseNewsList($url, $referer)
{
    $html = getContent($url, $referer);

    $doc = phpQuery::newDocument($html);
//    $newsList = $doc->find('.gtab.list')->html();

    $arParseData = array();
    $count = 0;
    foreach ($doc->find('.gtab.list tr') as $record)
    {
        $record = pq($record);  //преобразовать в объект phpQuery

        if ($record->find('.bhead a')->text() == '')  // пропускаем рекламные блоки
        {
            continue;
        }
        $arParseData[$count]['title'] = $record->find('.bhead a')->text();
        $arParseData[$count]['image'] = $record->find('.h92')->attr('src');
        $arParseData[$count]['date'] = $record->find('.bdate')->text();
        $arParseData[$count]['text'] = $record->find('.btxt')->text();
        $arParseData[$count]['link'] = $record->find('.bhead a')->attr('href');

        $count++;
    }

    return $arParseData;
}

/**
 * @param array  $links   Массив ссылок на страницы с новостями
 * @param string $referer линк-откуда пришли
 *
 * @return array Массив новостей
 */
function parseNews(array $links, $referer)
{
    $arNews = array();
    $count = 0;
    foreach ($links as $link)
    {
        $html = getContent($link, $referer);
        $doc = phpQuery::newDocument($html);

        $arNews[$count]['date'] = date("d.m.Y", strtotime($doc->find('.article time')->attr('datetime')) . ' ' . date('H:i:s')); //конверт в формат d.m.Y для Битрикс
        $arNews[$count]['title'] = $doc->find('.article .heading')->text();
        $arNews[$count]['link'] = $link;
        $arNews[$count]['image'] = 'https://' . ltrim($doc->find('.article .topimg img')->attr('src'), '/');

        $text = $doc->find('.article')->html();
        $pattern = '~<(p|ul)>(.+?)</\1>~is';
        preg_match_all($pattern, $text, $matches);
        foreach ($matches[0] as $num => $text)//&$text)
        {
//            $arNews[$count]['text'][$num] = strip_tags(preg_replace("~<a href=[^>]*>(.*?)<\/a>~is", "\$1", $text), '<p><ul><li><ol><br><hr><b><strong><em><i><s><u>');
            $arNews[$count]['text'][$num] = strip_tags($text, '<p><ul><li><ol><br><hr><b><strong><em><i><s><u>');
//            $text = strip_tags(preg_replace("~<a href=[^>]*>(.*?)<\/a>~is", "\$1", $text), '<p><ul><li><ol><br><hr><b><strong><em><i><s><u>');
            /*//        $text = preg_replace("~<!-- google_ad_section_start -->(.*?)<!-- google_ad_section_end -->~is", "", $text);
            //        $arNews[$count]['text'][$num] = $text;*/
        }
//        $arNews[$count]['text'] = $matches[0];
//        unset($text);
        $count++;
    }

    return $arNews;
}

/*$curl_errno = array(
    1  => "CURLE_UNSUPPORTED_PROTOCOL",
    2  => "CURLE_FAILED_INIT",
    3  => "CURLE_URL_MALFORMAT",
    4  => "CURLE_URL_MALFORMAT_USER",
    5  => "CURLE_COULDNT_RESOLVE_PROXY",
    6  => "CURLE_COULDNT_RESOLVE_HOST",
    7  => "CURLE_COULDNT_CONNECT",
    8  => "CURLE_FTP_WEIRD_SERVER_REPLY",
    9  => "CURLE_FTP_ACCESS_DENIED",
    10 => "CURLE_FTP_USER_PASSWORD_INCORRECT",
    11 => "CURLE_FTP_WEIRD_PASS_REPLY",
    12 => "CURLE_FTP_WEIRD_USER_REPLY",
    13 => "CURLE_FTP_WEIRD_PASV_REPLY",
    14 => "CURLE_FTP_WEIRD_227_FORMAT",
    15 => "CURLE_FTP_CANT_GET_HOST",
    16 => "CURLE_FTP_CANT_RECONNECT",
    17 => "CURLE_FTP_COULDNT_SET_BINARY",
    18 => "CURLE_FTP_PARTIAL_FILE or CURLE_PARTIAL_FILE",
    19 => "CURLE_FTP_COULDNT_RETR_FILE",
    20 => "CURLE_FTP_WRITE_ERROR",
    21 => "CURLE_FTP_QUOTE_ERROR",
    22 => "CURLE_HTTP_NOT_FOUND or CURLE_HTTP_RETURNED_ERROR",
    23 => "CURLE_WRITE_ERROR",
    24 => "CURLE_MALFORMAT_USER",
    25 => "CURLE_FTP_COULDNT_STOR_FILE",
    26 => "CURLE_READ_ERROR",
    27 => "CURLE_OUT_OF_MEMORY",
    28 => "CURLE_OPERATION_TIMEDOUT or CURLE_OPERATION_TIMEOUTED",
    29 => "CURLE_FTP_COULDNT_SET_ASCII",
    30 => "CURLE_FTP_PORT_FAILED",
    31 => "CURLE_FTP_COULDNT_USE_REST",
    32 => "CURLE_FTP_COULDNT_GET_SIZE",
    33 => "CURLE_HTTP_RANGE_ERROR",
    34 => "CURLE_HTTP_POST_ERROR",
    35 => "CURLE_SSL_CONNECT_ERROR",
    36 => "CURLE_BAD_DOWNLOAD_RESUME or CURLE_FTP_BAD_DOWNLOAD_RESUME",
    37 => "CURLE_FILE_COULDNT_READ_FILE",
    38 => "CURLE_LDAP_CANNOT_BIND",
    39 => "CURLE_LDAP_SEARCH_FAILED",
    40 => "CURLE_LIBRARY_NOT_FOUND",
    41 => "CURLE_FUNCTION_NOT_FOUND",
    42 => "CURLE_ABORTED_BY_CALLBACK",
    43 => "CURLE_BAD_FUNCTION_ARGUMENT",
    44 => "CURLE_BAD_CALLING_ORDER",
    45 => "CURLE_HTTP_PORT_FAILED",
    46 => "CURLE_BAD_PASSWORD_ENTERED",
    47 => "CURLE_TOO_MANY_REDIRECTS",
    48 => "CURLE_UNKNOWN_TELNET_OPTION",
    49 => "CURLE_TELNET_OPTION_SYNTAX",
    50 => "CURLE_OBSOLETE",
    51 => "CURLE_SSL_PEER_CERTIFICATE",
    52 => "CURLE_GOT_NOTHING",
    53 => "CURLE_SSL_ENGINE_NOTFOUND",
    54 => "CURLE_SSL_ENGINE_SETFAILED",
    55 => "CURLE_SEND_ERROR",
    56 => "CURLE_RECV_ERROR",
    57 => "CURLE_SHARE_IN_USE",
    58 => "CURLE_SSL_CERTPROBLEM",
    59 => "CURLE_SSL_CIPHER",
    60 => "CURLE_SSL_CACERT",
    61 => "CURLE_BAD_CONTENT_ENCODING",
    62 => "CURLE_LDAP_INVALID_URL",
    63 => "CURLE_FILESIZE_EXCEEDED",
    64 => "CURLE_FTP_SSL_FAILED",
    79 => "CURLE_SSH"
);*/
