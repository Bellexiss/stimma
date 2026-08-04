<?
CModule::IncludeModule('highloadblock');
CModule::IncludeModule('iblock');

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
/**
 * Class bs_iblock
 *
 * @prefixes_in_options
 * $g - generate
 * $c - check
 *
 * @options
 * $gxml_id - Генерировать ли xml_id при различных операциях добавления новых значений или элементов
 * $cxml_id - Проверять ли xml_id на уникальность перед добавлением при различных операциях
 */

class bs_iblock
{
    private static $_instance = null;

    private $arResult = [];

    #options
    private $gxml_id = true,
            $cxml_id = false;

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
    public function setOption($option, $value)
    {
        $this -> $option = $value;
    }

    public function getResult()
    {
        return $this -> arResult['success'];
    }

    public function getResultMessage()
    {
        return $this -> arResult['msg'];
    }

    public function getLastAction()
    {
        return $this -> arResult['last_action'];
    }

    public function getResultID()
    {
        return $this -> arResult['id'];
    }

    /* @return object this & success - boolean result of add enum*/
    public function add_enum($property_id, $value, $xml_id = '', $sort = 500, $def = 'N')
    {
        $this -> resetResult();
        $this -> arResult['last_action'][] = 'add_enum';

        if(intval($property_id) <= 0)
        {
            $this -> arResult['success'] = false;
            $this -> arResult['msg'][] = '#3 ID свойства должно быть цифрой';

            return $this;
        }

        $value = trim($value);
        $sort = intval($sort);

        if(empty($xml_id) && $this -> gxml_id)
            $xml_id = !empty($value) ? CUtil::translit($value, 'ru', ["replace_space"=>"","replace_other"=>""]) : 'g'.uniqid();

        $ibpenum = new \CIBlockPropertyEnum();

        $error = false;
        if($this -> cxml_id)
        {
            $this -> arResult['last_action'][] = 'check xml_id before add';
            $check = $ibpenum -> GetList([],['XML_ID' => $xml_id, 'PROPERTY_ID' => $property_id]);
            if($check = $check -> Fetch())
            {
                $this -> arResult['success'] = false;
                $this -> arResult['msg'][] = '#2 Указанный XML_ID существует';
                $this -> arResult['id'] = $check['ID'];
                $error = true;
            }
        }

        if(!$error)
        {
            $add = [
                'PROPERTY_ID' => $property_id,
                'VALUE' => $value,
                'DEF' => $def,
                'SORT' => $sort,
                'XML_ID' => $xml_id,
            ];

            $this -> arResult['last_action'][] = 'add enum';
            $valueId = $ibpenum->Add($add);
            if ((int) $valueId < 0)
            {
                $this -> arResult['success'] = false;
                $this -> arResult['msg'][] = '#1 Невозмжоно добавить значение';
            }
            else
            {
                $this -> arResult['success'] = true;
                $this -> arResult['id'] = $valueId;
            }
        }

        return $this;
    }

    public function addRecordHL($table_name, $value, $xml_id='', $sort = 500, $fields = [])
    {
        $this -> resetResult();
        $this -> arResult['last_action'][] = 'addRecordHL';

        $value = trim($value);

        $hlblock = HLBT::getList(['filter' => ['=TABLE_NAME' => $table_name]]);

        if(!$hlblock = $hlblock -> fetch())
        {
            $this -> arResult['success'] = false;
            $this -> arResult['msg'][] = '#3 Не удалось получить HL по имени';
            $this -> arResult['last_action'][] = 'get HL by name';
            return $this;
        }

        $entity = HLBT::compileEntity($hlblock);
        $edc = $entity->getDataClass();

        if(empty($xml_id) && $this -> gxml_id)
            $xml_id = !empty($value) ? CUtil::translit($value, 'ru', ["replace_space"=>"","replace_other"=>""]) : 'g'.uniqid();

        $error = false;

        if($this -> cxml_id)
        {
            $this -> arResult['last_action'][] = 'check xml_id before add';

            $check = $edc::getList(['filter' => ['UF_XML_ID' => $xml_id]]);

            if($check = $check -> fetch())
            {
                $this -> arResult['success'] = false;
                $this -> arResult['msg'][] = '#2 Указанный XML_ID существует';
                $this -> arResult['id'] = $check['ID'];
                $error = true;
            }
        }

        if (!$error)
        {
            $this -> arResult['last_action'][] = 'add record in hl';
            $res = $edc::add(['UF_NAME' => $value, 'UF_XML_ID' => $xml_id, 'UF_SORT' => $sort]);
            if($res -> isSuccess())
            {
                $this -> arResult['success'] = true;
                $this -> arResult['id'] = $res -> getId();
            }
            else
            {
                $this -> arResult['success'] = false;
                $this -> arResult['msg'][] = '#4 Ошибка добавления элемента в HL';
            }
        }

        return $this;
    }

    /**
    * @by: ID&CODE
    * @return array of properties
    */
    public function getPropertyList($by = 'CODE', $iblock_id = false, $code = false, $id = false)
    {
        if($by != 'CODE' || $by != 'ID') $by = 'CODE';

        $this -> resetResult();
        $this -> arResult['last_action'][] = 'getPropertyList';

        $filter = [];
        if($iblock_id) $filter['IBLOCK_ID'] = $iblock_id;
        if($code) $filter['CODE'] = $code;
        if($id) $filter['ID'] = $id;

        $res = CIBlockProperty::GetList([], $filter);

        $return = [];
        while ($record = $res -> Fetch())
            $return[$record[$by]] = $record;

        $this -> arResult['success'] = true;

        return $return;
    }

    #private functions
    private function resetResult()
    {
        $this -> arResult['success'] = -1;
        $this -> arResult['msg'][] = '#0 Не было никаких действий';
        $this -> arResult['last_action'] = [];
    }
}
?>