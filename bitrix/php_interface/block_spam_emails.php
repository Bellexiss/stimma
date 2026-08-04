<?php
// Получить список заблокированных email
function getBlockedEmails() {
    $raw = COption::GetOptionString("main", "blocked_spam_emails", "");
    return array_filter(array_map("trim", explode(",", $raw)));
}

// Сохранить список
function saveBlockedEmails($emails = []) {
    $emails = array_unique(array_map("strtolower", array_map("trim", $emails)));
    COption::SetOptionString("main", "blocked_spam_emails", implode(",", $emails));
}

// Проверка email перед оформлением заказа
function blockSpamEmailCheck(&$arFields) {
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/spam_check.log", var_export($arFields, true), FILE_APPEND);
    $blocked = getBlockedEmails();

    // Проверим ORDER_PROP
    if (!empty($arFields['ORDER_PROP'])) {
        foreach ($arFields['ORDER_PROP'] as $propId => $value) {
            // Получаем код свойства по ID
            $res = CSaleOrderProps::GetByID($propId);
            if ($res && strtolower($res['CODE']) === 'EMAIL') {
                $email = strtolower(trim($value));
                if (in_array($email, $blocked)) {
                    global $APPLICATION;
                    $APPLICATION->ThrowException("Оформление заказа с этим email запрещено.");
                    return false;
                }
            }
        }
    }

    // На случай, если всё ещё используется старый формат PROPS
    if (!empty($arFields['PROPS']) && is_array($arFields['PROPS'])) {
        foreach ($arFields['PROPS'] as $prop) {
            if ($prop['CODE'] === 'EMAIL') {
                $email = strtolower(trim($prop['VALUE']));
                if (in_array($email, $blocked)) {
                    global $APPLICATION;
                    $APPLICATION->ThrowException("Оформление заказа с этим email запрещено.");
                    return false;
                }
            }
        }
    }
}
