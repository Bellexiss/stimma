<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Diag\Debug;

// Подключение модуля
CModule::IncludeModule('main');

// Нормализация телефона (только цифры, формат: 380XXXXXXXXX)
function normalizePhoneCustom($phone) {
    $digits = preg_replace('/\D/', '', $phone);

    if (strlen($digits) === 10 && $digits[0] === '0') {
        return '38' . $digits;
    } elseif (strlen($digits) === 12 && strpos($digits, '38') === 0) {
        return $digits;
    }

    return ''; // Возврат пустой строки, если невалидный номер
}

// Получаем всех активных пользователей с телефонами
$rsUsers = CUser::GetList(
    $by = "ID",
    $order = "ASC",
    ["ACTIVE" => "Y"],
    ["SELECT" => ["ID", "PERSONAL_PHONE", "PERSONAL_MOBILE", "UF_PHONE_CLEAN"]]
);

$updated = 0;
$skipped = 0;
$total = 0;

while ($arUser = $rsUsers->Fetch()) {
    $total++;

    // Пропускаем, если поле уже заполнено
    if (!empty($arUser["UF_PHONE_CLEAN"])) {
        $skipped++;
        continue;
    }

    // Проверяем оба номера (основной и мобильный)
    $phones = [$arUser["PERSONAL_PHONE"], $arUser["PERSONAL_MOBILE"]];
    $normalized = '';

    foreach ($phones as $phone) {
        $normalizedCandidate = normalizePhoneCustom($phone);
        if ($normalizedCandidate) {
            $normalized = $normalizedCandidate;
            break;
        }
    }

    if ($normalized) {
        $user = new CUser;
        $res = $user->Update($arUser['ID'], ['UF_PHONE_CLEAN' => $normalized]);

        if ($res) {
            $updated++;
        } else {
            Debug::writeToFile([
                'USER_ID' => $arUser['ID'],
                'ERROR' => $user->LAST_ERROR
            ], "update_error", "/log_1c/normalize_phones_errors.txt");
        }
    }
}

// Результаты
echo "✅ Обработка завершена\n";
echo "Всего пользователей: $total\n";
echo "Обновлено: $updated\n";
echo "Пропущено (уже заполнено): $skipped\n";
