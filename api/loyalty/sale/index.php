<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

// Загружаем модули Bitrix
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');
CModule::IncludeModule('highloadblock');  // Обязательно подключаем модуль Highloadblock

global $DB;

// Получаем данные из запроса
$products = file_get_contents('php://input');
$products = json_decode($products);

// Логируем запрос для отладки (если нужно)
Bitrix\Main\Diag\Debug::writeToFile((array)$products, "start get order", '/log_1c/___sale_kasta_quantity.txt');

$dateEnd = $products->DateEND; // Получаем DateEND из запроса

// Сохраняем в COption DateEND (в первый раз сохраняем, далее можем только проверять)
COption::SetOptionString('my_module', 'sale_date_end', $dateEnd);

// Получаем сохранённое значение DateEND из COption
$savedDateEnd = COption::GetOptionString('my_module', 'sale_date_end', '');

// Преобразуем в DateTime для корректного сравнения
$dateStart = new DateTime($products->dateStart);
$savedDateEnd = new DateTime($savedDateEnd);

// Логика для первого запуска или обновления
// Проверяем, существует ли сохранённая дата начала (если нет, это первый запуск)
$savedDateStart = COption::GetOptionString('my_module', 'sale_date_start', '');

// Если сохранённой даты начала нет, то это первый запуск
if (empty($savedDateStart)) {
    // Сохраняем текущую дату начала как сохранённую
    COption::SetOptionString('my_module', 'sale_date_start', $products->dateStart);
}

// Проверяем, если текущая дата начала больше сохранённой, то записываем данные в Highload-блок
if ($dateStart > new DateTime($savedDateStart)) {
    // Сохраняем данные в Highload-блок
    saveToHighloadBlock($products->Sales);

    // После успешной записи данных обновляем сохранённую дату начала
    COption::SetOptionString('my_module', 'sale_date_start', $products->dateStart);
}

function saveToHighloadBlock($sales)
{
    global $DB;
    // Получаем объект Highload-блока
    $hlblock = HighloadBlockTable::getList([
        //'filter' => ['=TABLE_NAME' => 'HLBLOCK_19']
        'filter' => ['=ID' => 19]  // Используем ID блока
    ])->fetch();

    if (!$hlblock) {
        Bitrix\Main\Diag\Debug::writeToFile('Highload block not found', 'Error:', '/log_1c/___sale_kasta_quantity.txt');
        return;  // Если блок не найден, выходим из функции
    }

    $entity = HighloadBlockTable::compileEntity($hlblock);

    if (!$entity) {
        Bitrix\Main\Diag\Debug::writeToFile('Failed to compile entity', 'Error:', '/log_1c/___sale_kasta_quantity.txt');
        return;  // Если не получилось скомпилировать сущность, выходим из функции
    }

    // Логируем успешную компиляцию
    Bitrix\Main\Diag\Debug::writeToFile('Highload block compiled successfully', 'Success:', '/log_1c/___sale_kasta_quantity.txt');

    // Для каждого объекта из Sales сохраняем данные
    foreach ($sales as $sale)
    {
        $find = $DB->Query('select * from sale_kasta where UF_CHECK_NUMBER = \'' . $sale->checkNumber .'\'')->Fetch();

        if(!$find || !isset($find['ID']))
        {
            $dateX = DateTime::createFromFormat('Ymd\THis', $sale->date);
            $timestamp = $dateX->getTimestamp();
            $data = [
                'UF_PRODUCT'     => $sale->product,
                'UF_XML_ID'      => $sale->xml_id,
                'UF_QUANTITY'    => $sale->quantity,
                'UF_SUM'         => $sale->sum,
                'UF_WAREHOUSE'   => $sale->Warehouse,
                'UF_DATE_X'      => $timestamp,
                'UF_CHECK_NUMBER'=> $sale->checkNumber,
            ];

            // Логируем данные, которые будем записывать
            Bitrix\Main\Diag\Debug::writeToFile((array)$data, 'Data to save:', '/log_1c/___sale_kasta_quantity.txt');

            // Добавляем запись в Highload-блок
            $entityDataClass = $entity->getDataClass();
            $result = $entityDataClass::add($data);

            // Логируем результат добавления
            if ($result->isSuccess()) {
                Bitrix\Main\Diag\Debug::writeToFile('Data saved successfully', 'Success:', '/log_1c/___sale_kasta_quantity.txt');
            } else {
                Bitrix\Main\Diag\Debug::writeToFile('Failed to save data: ' . implode(', ', $result->getErrorMessages()), 'Error:', '/log_1c/___sale_kasta_quantity.txt');
            }
        }

    }
}
?>
