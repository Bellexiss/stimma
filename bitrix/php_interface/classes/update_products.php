<?
/*todo bs_m_2 {created and added this file}*/

CModule::IncludeModule('highloadblock');
CModule::IncludeModule('iblock');

/**
 * Class prom
 * $mode - icml
 */

class prods
{
    private static $_instance = null;
    private $linkIcml = 'https://www.stimma.com.ua/wp-content/plugins/saphali-export-yml2/export.yml';
    private $mode = 'icml';
    private $step = 1;
    private $timeout = 50;

    #settings
    private $upd_name = true,
            $upd_price = true,
            $upd_qty = true,
            $upd_category = true,
            $upd_img = true,
            $upd_props = true;

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
    public function run()
    {
        if($this -> step == 1)
            $this -> getFeed();
        if($this -> step == 2)
            $this -> checkAllPArams();
        if($this -> step == 3)
            $this -> checkCategories();
        if($this -> step == 4)
            $this -> checkOffers();
    }

    public function setSettings($settings)
    {
        if($settings['name']) $this -> upd_name = true; else $this -> upd_name = false;
        if($settings['price']) $this -> upd_price = true; else $this -> upd_price = false;
        if($settings['qty']) $this -> upd_qty = true; else $this -> upd_qty = false;
        if($settings['category']) $this -> upd_category = true; else $this -> upd_category = false;
        if($settings['img']) $this -> upd_img = true; else $this -> upd_img = false;
        if($settings['props']) $this -> upd_props = true; else $this -> upd_props = false;
    }

    public function setMode($mode)
    {
        $this -> mode = $mode;
    }

    public function setStep($step)
    {
        $this -> step = $step;
    }

    #private functions
    private function getFeed()
    {
        if($this -> mode == 'icml')
            $link = $this -> linkIcml;

        $xml = simplexml_load_file($link);

        $shop = $xml -> shop;
        $xml_currencies = $shop -> currencies;
        $xml_categories = $shop -> categories;
        $xml_offers = $shop -> offers;

        $currencies = $categories = $offers = $allPArams = $byParams = [];
        $i = 0;
        foreach ($xml_currencies -> currency as $index => $xml_currency)
        {
            foreach ($xml_currency -> attributes() as $indexAttr => $attribute)
            {
                //if($indexAttr == 'id') $id = trim((string)$attribute -> $i[0]);
                //if($indexAttr == 'rate') $rate = trim((string)$attribute -> $i[0]);
                if($indexAttr == 'id') $id = trim((string)$attribute);
                if($indexAttr == 'rate') $rate = trim((string)$attribute);
            }
            $currencies[$id] = $rate;
        }
        foreach ($xml_categories -> category as $index => $xml_category)
        {
            $id = $parent = '';
            foreach ($xml_category -> attributes() as $indexAttr => $attribute)
            {
                //if($indexAttr == 'id') $id = trim((string)$attribute -> $i[0]);
                //if($indexAttr == 'parentId') $parent = trim((string)$attribute -> $i[0]);
                if($indexAttr == 'id') $id = trim((string)$attribute);
                if($indexAttr == 'parentId') $parent = trim((string)$attribute);
            }

            //$categories[$id] = ['name' => trim((string)$xml_category -> $i)];
            $categories[$id] = ['name' => trim((string)$xml_category)];
            if($parent) $categories[$id]['parent'] = $parent;
        }
        foreach ($xml_offers -> offer as $index => $xml_offer)
        {
            $offer = [];
            foreach ($xml_offer -> attributes() as $indexAttr => $attribute)
            {
                //if($indexAttr == 'productId')$offer['productId'] = trim((string)$attribute -> $i[0]);
                //if($indexAttr == 'id')$offer['id'] = trim((string)$attribute -> $i[0]);
                if($indexAttr == 'available')$offer['available'] = trim((string)$attribute);
                if($indexAttr == 'id')$offer['id'] = trim((string)$attribute);
            }

            $offer['name'] = trim((string)$xml_offer -> name);
            $offer['category'] = trim((string)$xml_offer -> categoryId);
            $offer['picture'] = trim((string)$xml_offer -> picture);
            $offer['price'] = trim((string)$xml_offer -> price);
            $offer['old_price'] = trim((string)$xml_offer -> oldprice);
            $offer['vendorCode'] = trim((string)$xml_offer -> vendorCode);
            $offer['vendor'] = trim((string)$xml_offer -> vendor);
            $offer['currencyId'] = trim((string)$xml_offer -> currencyId);
            $offer['description'] = trim((string)$xml_offer -> description);
            $offer['country'] = trim((string)$xml_offer -> country);

            $params = [];
            foreach ($xml_offer -> param as $indexParam => $item)
            {
                $param_name = '';
                foreach ($item -> attributes() as $indexAttr => $attribute)
                {
                    //if($indexAttr == 'name')$param_name = trim((string)$attribute -> $i[0]);
                    if($indexAttr == 'name')$param_name = trim((string)$attribute);
                }
                if($param_name)
                {
                    $item = trim($item);
                    $code_param = strtoupper(CUtil::translit($param_name, 'ru', ["replace_space"=>"_","replace_other"=>"_"]));
                    $params[$code_param] = $item;
                    if(!isset($allPArams[$code_param]))
                        $allPArams[$code_param] = ['name' => $param_name];
                    $allPArams[$code_param]['values'][$item] = $item;

                    $byParams[$offer['vendorCode']][$code_param][$item] = $item;
                }
            }
            if(!empty($params))
                $offer['params'] = $params;

            $offers[$offer['vendorCode']]['offers'][$offer['id']] = $offer;

        }
        // Вивод свойств для ТП
        foreach ($byParams as $model => $byParam)
        {
            foreach ($byParam as $code => $values)
                if(count($values) == 1) unset($byParams[$model][$code]);
            if(empty($byParams[$model])) unset($byParams[$model]);
        }
        $forTP = [];
        foreach ($byParams as $model => $byParam)
            foreach ($byParam as $code => $values)
                $forTP[$code] = $code;

        /*?><pre><?=print_r($categories, 1)?></pre><?
        ?><pre><?=print_r($allPArams, 1)?></pre><?
        ?><pre><?=print_r($offers, 1)?></pre><?
        ?><pre><?=print_r($forTP, 1)?></pre><?
        die();*/

        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/categories.php', '<?$categories='.var_export($categories, 1).';?>');
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/all_params.php', '<?$allParams='.var_export($allPArams, 1).';?>');
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/offers.php', '<?$offers='.var_export($offers, 1).';?>');
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/for_tp.php', '<?$for_tp='.var_export($forTP, 1).';?>');

        // up step

        //$bsiblock = bs_iblock::getInstance();
        //$propsList = $bsiblock -> getPropertyList('CODE', 2);
    }

    private function checkAllPArams()
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/classes/bs_iblock.php';

        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/all_params.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/for_tp.php';
?><pre><?=print_r($for_tp, 1)?></pre><?

        $bsiblock = bs_iblock::getInstance();

        $bsiblock -> setOption('cxml_id', true);

        $propsListCatalog = $bsiblock -> getPropertyList('CODE', 21);
        $propsListOffers = $bsiblock -> getPropertyList('CODE', 25);

        foreach ($allParams as $code => $allParam)
        {
            $code = trim($code);
            if ($code == 'TSVET' || $code == 'COLOR_REF')
            {
                $allParams['COLOR_REF'] = $allParam;
                if($propsListOffers['COLOR_REF']['PROPERTY_TYPE'] == 'S' && !empty($propsListOffers['COLOR_REF']['USER_TYPE_SETTINGS']['TABLE_NAME']))
                {
                    foreach ($allParam['values'] as $index => $value)
                    {
                        $result = $bsiblock -> addRecordHL($propsListOffers['COLOR_REF']['USER_TYPE_SETTINGS']['TABLE_NAME'], $value);
                        $allParams[$code]['values'][$index] = $result -> getResultID();
                    }
                }
                if($code == 'TSVET')
                    continue;
                    //unset($allParams[$code]);
            }

            if (isset($for_tp[$code]) && !isset($propsListOffers[$code]))
                echo $code . ' Не существует как свойство в ТОРГОВЫХ<br>';
            elseif(!isset($propsListCatalog[$code]) && !isset($for_tp[$code]))
                echo $code . ' Не существует как свойство<br>';
            else
            {
                if(isset($for_tp[$code]) && $propsListOffers[$code]['PROPERTY_TYPE'] == 'L')
                {
                    foreach ($allParam['values'] as $index => $value)
                    {
                        $result = $bsiblock -> add_enum($propsListOffers[$code]['ID'], $value);
                        $allParams[$code]['values'][$index] = $result -> getResultID();
                    }
                }
                elseif($propsListCatalog[$code]['PROPERTY_TYPE'] == 'L' && !isset($for_tp[$code]))
                {
                    foreach ($allParam['values'] as $index => $value)
                    {
                        $result = $bsiblock -> add_enum($propsListCatalog[$code]['ID'], $value);
                        $allParams[$code]['values'][$index] = $result -> getResultID();
                    }
                }
            }
        }

        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/all_params.php', '<?$allParams='.var_export($allParams, 1).';?>');
        die('die -> '.__FILE__.':'.__LINE__);
    }

    private function checkCategories()
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/categories.php';

        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => 2,'ACTIVE'=>'Y'], false, ['ID','IBLOCK_ID','NAME','UF_*']);
        $sections = [];
        while ($section = $res -> Fetch())
        {
            if(!$section['UF_XML_ID']) continue;
            $sections[$section['UF_XML_ID']] = $section['ID'];
        }

        $bs = new CIBlockSection;
        foreach ($categories as $ident => $category)
        {
            if(!isset($sections[$ident]))
            {
                $arFields = Array(
                    //"IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID,
                    "IBLOCK_ID" => 21,
                    "NAME" => $category['name'],
                    "SORT" => 500,
                    "UF_XML_ID" => $ident,
                    "CODE" =>  CUtil::translit($category['name'], 'ru', ["replace_space"=>"","replace_other"=>""]),
                );
                if($category['parent'] && isset($sections[$category['parent']]))
                    $arFields['IBLOCK_SECTION_ID'] = $sections[$category['parent']];

                $ID = $bs->Add($arFields);
                $res = ($ID>0);

                if(!$res)
                    echo $bs->LAST_ERROR . ' ' . $category['name'];
                else
                {
                    $sections[$ident] = $ID;
                    $categories[$ident]['id'] = $ID;
                }
            }
            else
                $categories[$ident]['id'] = $sections[$ident];
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/categories.php', '<?$categories='.var_export($categories, 1).';?>');
    }

    private function checkOffers()
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/offers.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/categories.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/all_params.php';
        $cnt = 0;
        $el = new CIBlockElement;

        $start = date('d.m.Y H:i:s');
        $allOffers = [];
        foreach ($offers as $index => $items)
        {
            //$product_id = $this -> findProduct($items['productId']);
            $arLoadProductArray = ['IBLOCK_ID' => 2];

            $arLoadProductArray['NAME'] = trim($items['name']);
            $arLoadProductArray['CODE'] = CUtil::translit($items['name'], 'ru', ["replace_space"=>"","replace_other"=>""]);
            $arLoadProductArray['IBLOCK_SECTION_ID'] = $categories[$items['category']]['id'];
            if($this -> upd_props) $arLoadProductArray['PROPERTY_VALUES'] = $items['params'];
            //if($this -> upd_img && $items['picture'] && !empty($items['picture'])) $arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray($items['picture']);
            //if($this -> upd_img && $items['picture'] && !empty($items['picture'])) $arLoadProductArray['PREVIEW_PICTURE'] = CFile::MakeFileArray($items['picture']);

            $arLoadProductArray['PROPERTY_VALUES']['PRODUCT_ID'] = $items['productId'];
            $arLoadProductArray['PROPERTY_VALUES']['PID'] = $items['id'];

            /*
            if ($product_id > 0)
            {
                $props = $arLoadProductArray['PROPERTY_VALUES'];
                unset($arLoadProductArray['PROPERTY_VALUES']);
                $el -> Update($product_id, $arLoadProductArray);
                foreach ($props as $code => $value)
                {
                    CIBlockElement::SetPropertyValuesEx($product_id, false, array($code => $value));
                }

                $PRODUCT_ID = $product_id;
                $PRICE_TYPE_ID = 1;

                $arFields = Array(
                    "PRODUCT_ID" => $PRODUCT_ID,
                    "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
                    "PRICE" => $items['price'],
                    "CURRENCY" => "UAH",
                );

                $res = CPrice::GetList(
                    array(),
                    array(
                        "PRODUCT_ID" => $PRODUCT_ID,
                        "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
                    )
                );

                if ($arr = $res->Fetch())
                    CPrice::Update($arr["ID"], $arFields);
                else
                    CPrice::Add($arFields);

                CCatalogProduct::Update($product_id, ['AVAILABLE' => $items['quantity_in_stock'] > 0 ? 'Y' : 'N', 'QUANTITY' => $items['quantity_in_stock']]);
                // Обновление цены и остатков от настроек
            }
            else
            {
                if($product_id = $el->Add($arLoadProductArray))
                {
                    CCatalogProduct::Add([
                                             'ID' => $product_id,
                                             'AVAILABLE' => $items['quantity_in_stock'] > 0 ? 'Y' : 'N',
                                             'QUANTITY' => $items['quantity_in_stock'],
                                         ]);

                    $PRODUCT_ID = $product_id;
                    $PRICE_TYPE_ID = 1;

                    $arFields = Array(
                        "PRODUCT_ID" => $PRODUCT_ID,
                        "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
                        "PRICE" => $items['price'],
                        "CURRENCY" => "UAH",
                    );

                    $res = CPrice::GetList(
                        array(),
                        array(
                            "PRODUCT_ID" => $PRODUCT_ID,
                            "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
                        )
                    );

                    if ($arr = $res->Fetch())
                        CPrice::Update($arr["ID"], $arFields);
                    else
                        CPrice::Add($arFields);
                    echo "New ID: ".$product_id;
                }
                else
                    echo "Error: ".$el->LAST_ERROR;


            }
            */

            if(!empty($items['offers']))
            {
                //if($product_id > 0)
                {
                    foreach ($items['offers'] as $indexOffer => $offer)
                    {
                        $arLoadProductArray = ['IBLOCK_ID' => 3];

                        $arLoadProductArray['NAME'] = trim($offer['name']);
                        $arLoadProductArray['CODE'] = CUtil::translit($offer['name'], 'ru', ["replace_space"=>"","replace_other"=>""]);
                        $arLoadProductArray['IBLOCK_SECTION_ID'] = false;
                        if($this -> upd_props) $arLoadProductArray['PROPERTY_VALUES'] = $offer['params'];
                        //if($this -> upd_img && $offer['picture'] && !empty($offer['picture'])) $arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray($offer['picture']);
                        //if($this -> upd_img && $offer['picture'] && !empty($offer['picture'])) $arLoadProductArray['PREVIEW_PICTURE'] = CFile::MakeFileArray($offer['picture']);

                        $arLoadProductArray['PROPERTY_VALUES']['CML2_LINK'] = $product_id;
                        $arLoadProductArray['PROPERTY_VALUES']['PRODUCT_ID'] = $offer['productId'];
                        $arLoadProductArray['PROPERTY_VALUES']['PID'] = $offer['id'];

                        //$sku = $this -> findSku($offer['id']);

                        $allOffers[] = $offer;

                        /*
                        if ($sku > 0)
                        {
                            $props = $arLoadProductArray['PROPERTY_VALUES'];
                            unset($arLoadProductArray['PROPERTY_VALUES']);
                            $el -> Update($sku, $arLoadProductArray);
                            foreach ($props as $code => $value)
                            {
                                CIBlockElement::SetPropertyValuesEx($sku, false, array($code => $value));
                            }

                            $PRODUCT_ID = $sku;
                            $PRICE_TYPE_ID = 1;

                            $arFields = Array(
                                "PRODUCT_ID" => $PRODUCT_ID,
                                "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
                                "PRICE" => $offer['price'],
                                "CURRENCY" => "UAH",
                            );

                            $res = CPrice::GetList(
                                array(),
                                array(
                                    "PRODUCT_ID" => $PRODUCT_ID,
                                    "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
                                )
                            );

                            if ($arr = $res->Fetch())
                                CPrice::Update($arr["ID"], $arFields);
                            else
                                CPrice::Add($arFields);

                            CCatalogProduct::Update($sku, ['AVAILABLE' => $offer['quantity_in_stock'] > 0 ? 'Y' : 'N', 'QUANTITY' => $offer['quantity_in_stock']]);
                            // Обновление цены и остатков от настроек
                        }
                        else
                        {
                            if($sku = $el->Add($arLoadProductArray))
                            {
                                CCatalogProduct::Add([
                                                         'ID' => $sku,
                                                         'AVAILABLE' => $offer['quantity_in_stock'] > 0 ? 'Y' : 'N',
                                                         'QUANTITY' => $offer['quantity_in_stock'],
                                                     ]);

                                $PRODUCT_ID = $sku;
                                $PRICE_TYPE_ID = 1;

                                $arFields = Array(
                                    "PRODUCT_ID" => $PRODUCT_ID,
                                    "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
                                    "PRICE" => $offer['price'],
                                    "CURRENCY" => "UAH",
                                );

                                $res = CPrice::GetList(
                                    array(),
                                    array(
                                        "PRODUCT_ID" => $PRODUCT_ID,
                                        "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
                                    )
                                );

                                if ($arr = $res->Fetch())
                                    CPrice::Update($arr["ID"], $arFields);
                                else
                                    CPrice::Add($arFields);

                                echo "New ID: ".$sku;
                            }
                            else
                                echo "Error SKU: ".$el->LAST_ERROR;
                        }
                        */

                    }
                }
            }
            unset($offers[$index]);

            $end = date('d.m.Y H:i:s');

            /*
            if($end - $start >= 50)
            {
                file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/upd_prods/offers.php', '<?$offers='.var_export($offers, 1).';?>');

                ?>
                <script>
                    function sayHi() {
                        location.href='/cron/update_prom.php';
                    }
                    setTimeout(sayHi, 300);
                </script>
                <?
                ?><pre><?=print_r(count($offers), 1)?></pre><?

                die();
            }
            */


        }
        ?>
        <table>
            <tr>
                <td>ID</td>
                <td>Назва ру</td>
                <td>Назва укр</td>
                <td>Раздел</td>
                <td>Модель</td>
                <td>Цена со скидкой</td>
                <td>Цена</td>
                <td>Фото</td>
                <td>Описание</td>
                <td>Подборка</td>
                <td>Размер</td>
                <td>Стили</td>
                <td>Состав</td>
                <td>Принт</td>
                <td>Возраст</td>
                <td>Материал</td>
            </tr>
        <?
        foreach ($allOffers as $index => $allOFfer)
        {
            ?>
            <tr>
                <td></td>
                <td><?=$allOFfer['name']?></td>
                <td></td>
                <td></td>
                <td><?=$allOFfer['vendorCode']?></td>
                <td><?=$allOFfer['price']?></td>
                <td><?=$allOFfer['old_price']?></td>
                <td><?=$allOFfer['picture']?></td>
                <td><?=$allOFfer['description']?></td>
                <td></td>
                <td><?=$allOFfer['params']['RAZMER']?></td>
                <td></td>
                <td><?=$allOFfer['params']['SOSTAV']?></td>
                <td></td>
                <td></td>
                <td><?=$allOFfer['params']['MATERAIL']?></td>
                <td><?=$allOFfer['params']['TSVET']?></td>
                <td><?=$allOFfer['params']['VID']?></td>
            </tr>
            <?
        }
        ?></table><?
        die('2');
    }

    private function findProduct($product_id)
    {
        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 2, 'PROPERTY_PID' => $product_id]);
        if ($record = $res -> Fetch())
            return $record['ID'];
        else
            return false;
    }

    private function findSku($product_id)
    {
        $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 3, 'PROPERTY_PID' => $product_id]);
        if ($record = $res -> Fetch())
            return $record['ID'];
        else
            return false;
    }
}
?>