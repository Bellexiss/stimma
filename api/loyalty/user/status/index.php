<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Engine\Contract\Controllerable;

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
CModule::IncludeModule('main');

// Получаем JSON из входящего запроса
$input = file_get_contents('php://input');
$input = (array)$input;

Bitrix\Main\Diag\Debug::writeToFile((array)$input, "start get order", '/log_1c/___user_status.txt');

// Путь к JSON-файлу
//$input = $_SERVER["DOCUMENT_ROOT"] . "/api/loyalty/user/status/s.json";

// Проверка файла
/*if (!file_exists($input)) {
    Debug::writeToFile("File not found: $input", "file_error", '/log_1c/error_user_cards.txt');
    exit("JSON file not found");
}*/
//$input = file_get_contents($input);
//$data = json_decode($input, true); // true для получения ассоциативного массива

/*if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    die();
}*/

// Перебираем каждый элемент
foreach ($input as $entry) {
    $cardUID = trim($entry->CardUID ?? '');
    $statusXmlId = trim((string)($entry->StatusID ?? ''));

    if (!$cardUID || !$statusXmlId) {
        continue;
    }

    switch ($statusXmlId)
    {
        case 1 : $statusXmlId = 27; break;
        case 2 : $statusXmlId = 28; break;
        case 3 : $statusXmlId = 29; break;
        case 4 : $statusXmlId = 30; break;
    }

    // Найти пользователя по XML_ID = CardUID
    $rsUser = CUser::GetList(
        ($by = "id"),
        ($order = "asc"),
        ["XML_ID" => $cardUID],
        ['FIELDS' => ['ID']]
    );

    if ($arUser = $rsUser->Fetch()) {
        $userID = $arUser['ID'];
        // Найти ID элемента списка по XML_ID
        $rsEnum = CUserFieldEnum::GetList([], [
            "USER_FIELD_NAME" => "UF_LOYALTY_GROUP",
            "XML_ID" => $statusXmlId
        ]);

        if ($arEnum = $rsEnum->GetNext()) {
            $enumId = $arEnum['ID'];
            // Обновить пользователя
            $user = new CUser;
            if (!$user->Update($userID, [
                "UF_LOYALTY_GROUP" => $enumId
            ])) {
                // Логируем ошибку
                AddMessage2Log("Ошибка обновления пользователя ID {$userID}: " . $user->LAST_ERROR, "loyalty_update");

                // Или можно вывести ошибку
                echo json_encode([
                    "error" => "User update failed",
                    "user_id" => $userID,
                    "last_error" => $user->LAST_ERROR
                ]);
            }
        }
    }
}

echo json_encode(["status" => "ok"]);
?>
