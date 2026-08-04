<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?if ($arResult['ITEMS']) {
    $sections = array();

    foreach($arResult['ITEMS'] as &$arItem) {
        if( !isset($sections[ $arItem['IBLOCK_SECTION_ID'] ]) ) {
            $res = CIBlockSection::GetNavChain($arParams['IBLOCK_ID'], $arItem['IBLOCK_SECTION_ID'], array('ID', 'NAME','UF_*'));
            while($section = $res->Fetch()) {
                $sss = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $section['ID']], false, ['ID','IBLOCK_ID', 'NAME', 'UF_*']) -> Fetch();
                if($sss['UF_NAME_UA']) $section['NAME'] = $sss['UF_NAME_UA'];
                $sections[ $arItem['IBLOCK_SECTION_ID'] ] .= $section['NAME'].($section['ID'] == $arItem['IBLOCK_SECTION_ID'] ? '' : '&nbsp;&nbsp;<span>&mdash;</span>&nbsp;&nbsp;');
            }
        }
        
        $arItem['SECTION_PATH'] = $sections[ $arItem['IBLOCK_SECTION_ID'] ];
    }
    unset($arItem);

}?>