<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


// google_chat_action.php

header('Content-Type: application/json; charset=utf-8');

$input = file_get_contents('php://input');

$input = '{
    "Id": "14a62b5f-b8eb-11f1-b185-bdc5481eee0f",
    "file": "https://stimma.ua/coupon.png",
    "text": "Погодження оплати:\nРемонт \/ будівництво \nЗа дзеркала зг-но рахунка \nСумма135 400 грн",
    "fileName": "14a62b5f-b8eb-11f1-b185-bdc5481eee0f.png"
}';

$event = json_decode($input, true);

if (!is_array($event)) {
    http_response_code(400);
    echo json_encode(['text' => 'Некорректный JSON']);
    exit;
}

// Название действия может приходить в разных полях
// в зависимости от формата события Google Chat.
$function = $event['commonEventObject']['parameters']['function']
            ?? $event['action']['actionMethodName']
               ?? $event['common']['invokedFunction']
                  ?? '';

$params = $event['commonEventObject']['parameters']
          ?? $event['action']['parameters']
             ?? [];

function array_is_list(array $arr): bool
{
    $i = 0;
    foreach ($arr as $k => $v) {
        if ($k !== $i++) {
            return false;
        }
    }
    return true;
}

if (is_array($params) && array_is_list($params))
{
    $converted = [];

    foreach ($params as $item) {
        if (isset($item['key'])) {
            $converted[$item['key']] = $item['value'] ?? '';
        }
    }

    $params = $converted;
}

$requestId = $params['request_id'] ?? '';
$decision = $params['decision'] ?? '';

if (!in_array($function, ['acceptRequest', 'rejectRequest'], true)) {
    http_response_code(400);
    echo json_encode(['text' => 'Неизвестное действие']);
    exit;
}

if ($requestId === '') {
    http_response_code(400);
    echo json_encode(['text' => 'Не указан ID заявки']);
    exit;
}

if ($function === 'acceptRequest') {
    $decision = 'accepted';
} elseif ($function === 'rejectRequest') {
    $decision = 'rejected';
}

// Папка должна быть доступна PHP для записи
$logFile = __DIR__ . '/google_chat_decisions.jsonl';

$record = [
    'request_id' => $requestId,
    'decision' => $decision,
    'user' => $event['user']['name']
              ?? $event['commonEventObject']['user']['name']
                 ?? null,
    'time' => date('c')
];

$result = file_put_contents(
    $logFile,
    json_encode(
        $record,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    ) . PHP_EOL,
    FILE_APPEND | LOCK_EX
);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['text' => 'Не удалось сохранить решение']);
    exit;
}

// Ответ Google Chat должен быть JSON.
echo json_encode([
                     'text' => $decision === 'accepted'
                         ? 'Заявка принята.'
                         : 'Заявка отклонена.'
                 ], JSON_UNESCAPED_UNICODE);
