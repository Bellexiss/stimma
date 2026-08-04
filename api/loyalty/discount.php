<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog")) {
    die("Не удалось подключить модули");
}

$fields = [
    "LID" => "s1",
    "NAME" => "Акция: скидка 1000 грн от 6000",
    "ACTIVE" => "Y",
    "PRIORITY" => 100,
    "SORT" => 100,
    "LAST_DISCOUNT" => "Y",
    "LAST_LEVEL_DISCOUNT" => "Y",
    "EXECUTE_MODULE" => "all",
    "USER_GROUPS" => [2], // Группа "все пользователи"
    "USE_COUPONS" => "N",
    "CONDITIONS" => serialize([
        "CLASS_ID" => "CondGroup",
        "DATA" => ["All" => "AND", "True" => "True"],
        "CHILDREN" => [
            [
                "CLASS_ID" => "CondBsktAmtGroup",
                "DATA" => [
                    "logic" => "CondBsktAmtGe",
                    "Value" => 6000
                ]
            ]
        ]
    ]),
    "ACTIONS" => serialize([
        "CLASS_ID" => "CondGroup",
        "DATA" => ["All" => "AND", "True" => "True"],
        "CHILDREN" => [
            [
                "CLASS_ID" => "ActSaleBsktGrp",
                "DATA" => [
                    "Type" => "Discount",
                    "Value" => 1000,
                    "Unit" => "CurAll", // "CurAll" — фиксированная сумма, "Perc" — процент
                    "All" => "AND",
                    "True" => "True",
                    "Max" => 0
                ],
                "CHILDREN" => [
                    [
                        "CLASS_ID" => "CondCtrlBasketFields",
                        "DATA" => [
                            "logic" => "Equal",
                            "field" => "PRICE",
                            "Value" => "Min"
                        ]
                    ]
                ]
            ]
        ]
    ])
];

$discountId = CSaleDiscount::Add($fields);

if ($discountId) {
    echo "Скидка создана. ID: $discountId";
} else {
    global $APPLICATION;
    echo "Ошибка: " . $APPLICATION->GetException()->GetString();
}
