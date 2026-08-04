<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $DB;

$input = json_decode(file_get_contents('php://input'), true);
$post = $_POST;

/*$botToken = '7515142533:AAEXnqvbyGE4aDzSaW3q3nelSpW2MdZh7fk'; // Замените на свой токен
$webhookUrl = 'https://www.stimma.com.ua/api/tg/start_bot/'; // Замените на свой HTTPS URL
$url = "https://api.telegram.org/bot{$botToken}/setWebhook?url=" . urlencode($webhookUrl);
// Выполняем запрос
$response = file_get_contents($url);
// Проверяем результат
if($response !== false)
{
    echo "Webhook установлен: $response";
}
else
{
    echo "Ошибка при установке вебхука.";
}
die();*/

Bitrix\Main\Diag\Debug::writeToFile($input, "content" , '/___tg_bot.txt');

function clear($text)
{
    $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8'); // исправляет битые символы
    $text = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $text);
    $text = preg_replace('/[\xF0-\xF7][\x80-\xBF]{0,3}/u', '', $text);

    $text = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $text); // смайлы
    $text = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $text); // символы и пиктограммы
    $text = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $text); // транспорт и символы
    $text = preg_replace('/[\x{1F1E6}-\x{1F1FF}]/u', '', $text); // флаги
    $text = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $text);   // разное
    $text = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $text);   // стрелки, символы

    // Удаление zero-width joiners, modifiers и других спецсимволов
    $text = preg_replace('/[\x{200D}\x{FE0F}]/u', '', $text);
    $text = str_replace('\xF0\x9F\x91\xA9\xF0\x9F', '', $text);

    return $text;
}

function sendMessage($chat_id, $text)
{
    $token = '7515142533:AAEXnqvbyGE4aDzSaW3q3nelSpW2MdZh7fk';
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $postData = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Ошибка: ' . curl_error($ch);
    }
    curl_close($ch);

    Bitrix\Main\Diag\Debug::writeToFile($response, "response send message" , '/___tg_bot.txt');

    return $response;

    /*$data = [
        'chat_id' => $chat_id,
        'text' => $text,
    ];
    file_get_contents($url . '?' . http_build_query($data));
    file_get_contents('https://api.telegram.org/7515142533:AAEXnqvbyGE4aDzSaW3q3nelSpW2MdZh7fk/sendMessage?chat_id=160831010&text=asdadasdasd&parse_mode=html&disable_web_page_preview=true');*/
}


$token = '7515142533:AAEXnqvbyGE4aDzSaW3q3nelSpW2MdZh7fk';

if(isset($input['message']['entities'][0]['type']) && $input['message']['entities'][0]['type'] == 'bot_command' && strpos($input['message']['text'], '/start') === 0)
{
    $text = $input['message']['text'];
    $chat_id = $input['message']['chat']['id'];
    $username = $input['message']['from']['username'] ?? '';

    Bitrix\Main\Diag\Debug::writeToFile('1', "before find 1" , '/___tg_bot.txt');

    $findUser = $DB->Query('select * from bot_register where UF_CHAT_ID = \'' . $chat_id .' \'');


    if($findUser = $findUser->Fetch())
    {
        Bitrix\Main\Diag\Debug::writeToFile('1', "finded 1" , '/___tg_bot.txt');
        $text = '
            Привіт знову! 👋
Ми вже бачилися 😊 Ваша реєстрація у STIMMA активна, а всі акції – у нашому каналі.

<a href="https://t.me/stimmacomua">👉 Дивитися пропозиції</a>
        ';
        sendMessage($chat_id, $text);
    }
    else
    {
        Bitrix\Main\Diag\Debug::writeToFile('1', "not finded 1" , '/___tg_bot.txt');
        $shopId = trim(str_replace('/start', '', $text));

        // Отправляем на сайт
        $data = [
            'telegram_id' => $chat_id,
            'username' => $username,
            'shop_id' => $shopId,
        ];

        $date = date('d.m.Y H:i:s');
        $dateX = strtotime($date);

        if(!$shopId)
            $DB->Query('insert into bot_register (UF_DATE_X,UF_DATE,UF_CHAT_ID) values ('.$dateX.', \''.$date.'\', '.$chat_id.')');
        else
            $DB->Query('insert into bot_register (UF_DATE_X,UF_DATE,UF_CHAT_ID,UF_SHOP_ID) values ('.$dateX.', \''.$date.'\', '.$chat_id.',\''.$shopId.'\')');

        $text = '
Вітаємо у STIMMA! 🎉

Щоб отримувати персональні знижки та першими дізнаватися про акції й новинки, поділіться, будь ласка, своїм номером телефону.
Це потрібно, щоб ми могли ідентифікувати вас у нашій системі та гарантувати доступ до всіх привілеїв.
    ';

        // Ответ пользователю
        //sendMessage($chat_id, $text);

        # Показуємо кнопку шарінгу телефону
        $url = "https://api.telegram.org/bot$token/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode([
                                              'keyboard' => [[
                                                                 [
                                                                     'text' => '📱 Відправити телефон',
                                                                     'request_contact' => true
                                                                 ]
                                                             ]],
                                              'resize_keyboard' => true,
                                              'one_time_keyboard' => true
                                          ])
        ];

        file_get_contents($url . '?' . http_build_query($data));
    }


}
elseif (isset($input['message']['contact']))
{
    $contact = $input['message']['contact'];
    $date = date('d.m.Y H:i:s');
    $dateX = strtotime($date);

    $findUser = $DB->Query('select * from bot_register where UF_CHAT_ID = \'' . $contact['user_id'] .' \'');

    if($findUser = $findUser->Fetch())
    {
        if(!$findUser['UF_PHONE'])
        {
            $DB->Query('update bot_register set UF_PHONE = \''.$contact['phone_number'].'\', UF_NAME = \''.$contact['first_name'].'\' where ID = ' . $findUser['ID']);

            $text = '
Дякуємо, що приєдналися до STIMMA!


Для отримання персональної знижки перейдіть у наш Telegram-канал, 
<a href="https://t.me/stimmacomua">👉 Перейти до каналу</a>

Приємних покупок! 💛
        ';
            sendMessage($contact['user_id'], $text);
        }
        elseif ($findUser['UF_PHONE'])
        {
            $text = '
            Привіт знову! 👋
Ми вже бачилися 😊 Ваша реєстрація у STIMMA активна, а всі акції – у нашому каналі.

<a href="https://t.me/stimmacomua">👉 Дивитися пропозиції</a>
        ';
            sendMessage($contact['user_id'], $text);
        }

    }
    else
    {
        Bitrix\Main\Diag\Debug::writeToFile('1', "error bot_telegram" , '/___tg_bot.txt');
    }
}




