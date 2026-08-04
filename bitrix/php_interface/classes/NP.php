<?
/*todo bs_m_2 {created and added this file}*/

CModule::IncludeModule('highloadblock');
CModule::IncludeModule('iblock');

/**
 * Class prom
 * $mode - icml
 */

class NP
{
    private static $_instance = null;

    private $apiKey = '81cceaa2342420ad9413bc0ecf1e507e';
    private $url = 'https://api.novaposhta.ua/v2.0/json/';

    private function __construct()
    {
        // приватный конструктор ограничивает реализацию getInstance ()
    }

    protected function __clone()
    {
        // ограничивает клонирование объекта
    }

    static public function getInstance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    #public functions
    public function updateCities()
    {
        // todo це має оновлюватися хочаби раз в місяць
        global $DB;
echo '1';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_cities.txt', '1');
        $sendData = '{"apiKey":"'.$this -> apiKey.'","modelName":"Address","calledMethod":"getCities"}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this -> url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
        echo '2';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_cities.txt', '2');
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);

        $relation = [
            'Description' => 'UF_NAME_UA',
            'DescriptionRu' => 'UF_NAME_RU',
            'Ref' => 'UF_REF_ID',
            'Area' => 'UF_AREA',
            'SettlementType' => 'UF_S_TYPE',
            'CityID' => 'UF_CITY_ID',
            'SettlementTypeDescription' => 'UF_S_UA',
            'SettlementTypeDescriptionRu' => 'UF_S_RU',
            'AreaDescription' => 'UF_AREA_UA',
            'AreaDescriptionRu' => 'UF_AREA_RU',
        ];
        echo '3';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_cities.txt', '3');
        $items = $response -> data;

        $exists = [];
        $res = $DB -> Query('select * from np_cities_new');
        while ($record = $res -> Fetch())
            $exists[$record['UF_REF_ID']] = $record;

        $DB -> Query('update np_cities_new set UF_ACTIVE = 0');
        echo '4';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_cities.txt', '4');
        foreach ($items as $index => $item)
        {
            $ref = $item -> Ref;
            $array = [];
            foreach ($item as $code => $value)
            {
                if(!isset($relation[$code]))
                    continue;

                $array[$relation[$code]] = "'".addslashes($value)."'";
            }
            $array['UF_ACTIVE'] = "'1'";
            if(!empty($array))
            {
                if(isset($exists[$ref]))
                {
                    $set = [];
                    foreach ($array as $ufCode => $ufValue)
                        $set[] = $ufCode.'='.$ufValue;
                    $sql = 'update np_cities_new set '.implode(',', $set).' where ID = '.$exists[$ref]['ID'];
                }
                else
                {
                    $sql = 'insert into np_cities_new ('.implode(',', array_keys($array)).') values ('.implode(',', $array).')';
                }

                $DB -> Query($sql);
            }
        }
        echo '5';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_cities.txt', '5');
    }

    public function updatePostList()
    {
        // todo це має оновлюватися хочаби раз в місяць
        global $DB;
        echo '11';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', '11');
        $sendData = '{"apiKey":"'.$this -> apiKey.'","modelName":"Address","calledMethod":"getWarehouses"}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this -> url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
        echo '22';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', '22');
        $response = curl_exec($ch);
        $response = json_decode($response);

        curl_close($ch);

        $relation = [
            'ShortAddress' => 'UF_SHORT_ADRESS_UA',
            'ShortAddressRu' => 'UF_SHORT_ADRESS_RU',
            'Phone' => 'UF_PHONE',
            'TypeOfWarehouse' => 'UF_TYPE',
            'Ref' => 'UF_REF_ID',
            'Number' => 'UF_NUMBER',
            'CityRef' => 'UF_CITY_REF_ID',
            'Longitude' => 'UF_LON',
            'Latitude' => 'UF_LAT',
            'Schedule' => 'UF_SCHEULDE',
            'WarehouseStatus' => 'UF_STATUS',
        ];

        $items = $response -> data;
        echo '33';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', '33');
        $exists = [];
        $res = $DB -> Query('select * from np_posts_new');
        while ($record = $res -> Fetch())
            $exists[$record['UF_REF_ID']] = $record;

        $DB -> Query('update np_posts_new set UF_ACTIVE = 0');
        echo '44';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', '44');
        foreach ($items as $index => $item)
        {
            $ref = $item -> Ref;
            $array = [];
            foreach ($item as $code => $value)
            {
                if(!isset($relation[$code]))
                    continue;

                if($code == 'Schedule')
                {
                    $value = 'Пн-Пт '.$value -> Monday.'<br>
                                    Сб '.$value -> Saturday.'<br>
                                    Вс '.$value -> Sunday.'<br>';
                    //$value = implode(';', $value);
                    $value = '';
                }

                $array[$relation[$code]] = "'".addslashes($value)."'";
            }
            $array['UF_ACTIVE'] = "'1'";
            $array['UF_DATE_UPD'] = "'".date('d.m.Y H:i:s')."'";
            if(!empty($array))
            {
                if(isset($exists[$ref]))
                {
                    $set = [];
                    foreach ($array as $ufCode => $ufValue)
                        $set[] = $ufCode.'='.$ufValue;
                    $sql = 'update np_posts_new set '.implode(',', $set).' where ID = '.$exists[$ref]['ID'];
                }
                else
                {
                    echo 'insert ';
                    $sql = 'insert into np_posts_new ('.implode(',', array_keys($array)).') values ('.implode(',', $array).')';
                }

                $DB -> Query($sql);
            }
        }
        echo '55';
        //file_put_contents('/home/stimma/www/stimma.com.ua/update_np_posts.txt', '55');
    }
    #private functions

    #additional functions
}


?>