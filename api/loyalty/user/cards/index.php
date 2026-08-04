<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Diag\Debug;

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
CModule::IncludeModule('main');
// Получаем и декодируем JSON
$jsonInput = file_get_contents('php://input');
$userList = json_decode($jsonInput);
Bitrix\Main\Diag\Debug::writeToFile((array)$userList, "user list", '/log_1c/___user_list.txt');


// Нормализация телефона
function normalizePhoneCustom($phone) {
    $digits = preg_replace('/\D/', '', $phone);
    if (strlen($digits) === 10 && $digits[0] === '0') {
        return '38' . $digits;
    } elseif (strlen($digits) === 12 && strpos($digits, '38') === 0) {
        return $digits;
    }
    return '';
}

$updated = 0;
$skipped = 0;
$notFound = 0;
$total = 0;
$user = new CUser;

foreach ($userList as $userItem)
{
    global $DB;
    $total++;

    if (!isset($userItem->phone) || !isset($userItem->xml_id))
        continue;

    $rawPhone = $userItem->phone;
    $normalizedPhone = \Bitrix\Main\UserPhoneAuthTable::normalizePhoneNumber($rawPhone);

    //$normalizedPhone = normalizePhoneCustom($rawPhone);
    if (!$normalizedPhone)
        continue;

    $xml_id = $userItem->xml_id;
    $lastName = $userItem->last_Name ?? '';
    $datebirthday = $userItem->datebirthday;

    $datebirthdayFormatted = false;
    if (!empty($datebirthday)) {
        $timestamp = strtotime(substr($datebirthday, 0, 8));
        if ($timestamp !== false) {
            $datebirthdayFormatted = \Bitrix\Main\Type\Date::createFromTimestamp($timestamp)->format("d.m.Y");
        }
    }

    // Поиск по UF_PHONE_CLEAN
    /*$rsUsers = CUser::GetList(
        $by = "ID",
        $order = "ASC",
        ["UF_PHONE_CLEAN" => $normalizedPhone],
        ["SELECT" => ["ID", "XML_ID", "PERSONAL_BIRTHDAY"]]
    );*/

    $rsUsers = $DB->Query('select * from b_user where PERSONAL_PHONE = \''.$normalizedPhone.'\'');
    if ($arUser = $rsUsers->Fetch())
    {
        // Пропускаем, если XML_ID уже заполнен
        /*if (!empty($arUser["XML_ID"]))
        {
            $skipped++;
            continue;
        }*/

        $updateFields = ["XML_ID" => $xml_id];

        if ($datebirthdayFormatted) {
            $updateFields["PERSONAL_BIRTHDAY"] = $datebirthdayFormatted;
        }

        $res = $user->Update($arUser["ID"], $updateFields);

        if ($res) {
            $updated++;
            Debug::writeToFile(
                [
                    "user_id" => $arUser['ID'],
                    "name" => $lastName,
                    "phone" => $normalizedPhone,
                    "xml_id" => $xml_id,
                    "birthday" => $datebirthdayFormatted
                ],
                "user_updated",
                '/log_1c/update_user_cards.txt'
            );
        } else {
            Debug::writeToFile("Update error: " . $user->LAST_ERROR, "update_error", '/log_1c/___user_cards.txt');
        }

    }
    else
    {
        $notFound++;
        Debug::writeToFile([
            "name" => $lastName,
            "input_phone" => $rawPhone,
            "normalized_phone" => $normalizedPhone,
            "xml_id" => $xml_id
        ], "no_user_found", '/log_1c/no_user_cards.txt');

        $email = str_replace('+','',$normalizedPhone);
        $email .= '@stimma.com.ua';
        $code = rand(100000,999999);

        $arFields = Array(
            "NAME"              => $lastName,
            //"LAST_NAME"         => "Иванов",
            "EMAIL"             => $email,
            "LOGIN"             => $normalizedPhone,
            "ACTIVE"            => "Y",
            "PASSWORD"          => $code,
            "CONFIRM_PASSWORD"  => $code,
            "PERSONAL_PHONE"    => $normalizedPhone,
            'UF_PHONE_CODE'   => $code
        );

        $ID = $user->Add($arFields);

        Debug::writeToFile([
            "id" => $ID,
            "name" => $lastName,
            "input_phone" => $rawPhone,
            "normalized_phone" => $normalizedPhone,
            "xml_id" => $xml_id
        ], "no_user_found", '/log_1c/added_user_cards.txt');
    }
}