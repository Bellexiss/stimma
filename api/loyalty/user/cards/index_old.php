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

if (!is_array($userList)) {
    Debug::writeToFile($jsonInput, "Invalid JSON", '/log_1c/error_user_cards.txt');
    exit;
}

// Функция нормализации телефона
function normalizePhone($phone)
{
    $digits = preg_replace('/\D/', '', $phone);
    if (strlen($digits) === 10 && $digits[0] === '0') {
        return '38' . $digits;
    } elseif (strlen($digits) === 12 && strpos($digits, '38') === 0) {
        return $digits;
    }
    return $digits; // fallback
}

// Обрабатываем каждый объект из массива
foreach ($userList as $userItem) {
    if (!isset($userItem->phone) || !isset($userItem->xml_id)) {
        continue; // пропуск, если не хватает данных
    }

    $rawPhone = $userItem->phone;
    $normalizedJsonPhone = normalizePhone($rawPhone);
    $xml_id = $userItem->xml_id;
    $lastName = $userItem->last_Name ?? '';
    $datebirthday = $userItem->datebirthday;

    // Подготовка даты
    if (!empty($datebirthday)) {
        $datebirthdayFormatted = \Bitrix\Main\Type\Date::createFromTimestamp(
            strtotime(substr($datebirthday, 0, 8))
        )->format("d.m.Y");
    } else {
        $datebirthdayFormatted = false;
    }

    $userFound = false;

    // Ищем пользователей
    $rsUsers = \CUser::GetList(
        $by = "ID",
        $order = "ASC",
        ["ACTIVE" => "Y"],
        ["SELECT" => ["ID", "PERSONAL_PHONE", "PERSONAL_MOBILE", "XML_ID", "PERSONAL_BIRTHDAY"]]
    );

    while ($arUser = $rsUsers->Fetch()) {
        $phones = [$arUser["PERSONAL_PHONE"], $arUser["PERSONAL_MOBILE"]];

        foreach ($phones as $storedPhone) {
            $normalizedStoredPhone = normalizePhone($storedPhone);

            if ($normalizedStoredPhone === $normalizedJsonPhone) {
                // Совпадение найдено
                $user = new \CUser;

                $updateFields = ["XML_ID" => $xml_id];
                if ($datebirthdayFormatted) {
                    $updateFields["PERSONAL_BIRTHDAY"] = $datebirthdayFormatted;
                }

                $res = $user->Update($arUser["ID"], $updateFields);

                if ($res) {
                    Debug::writeToFile("Updated user ID: " . $arUser["ID"] . " (" . $lastName . ")", "user updated", '/log_1c/___user_cards.txt');
                } else {
                    Debug::writeToFile("Update error: " . $user->LAST_ERROR, "update error", '/log_1c/___user_cards.txt');
                }

                $userFound = true;
                break 2; // выйти из обоих циклов
            }
        }
    }

    if (!$userFound) {
        Debug::writeToFile([
            "name" => $lastName,
            "input_phone" => $rawPhone,
            "normalized_phone" => $normalizedJsonPhone,
            "xml_id" => $xml_id
        ], "no user found", '/log_1c/no_user_cards.txt');
    }
}