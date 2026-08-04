<?php
namespace Local\Sale;

use Bitrix\Main\Loader;

class CondBasketCategoryCombo
{
    public static function CheckBasket( $arParams)
    {
        $arParams['SQLS'] = [];
        if (!isset($arParams["BASKET"]) || !is_array($arParams["BASKET"])) {
            return $arParams["BASKET"];
        }

        Loader::includeModule("iblock");
        Loader::includeModule("catalog");

        $percent = 20;
        $hasTopItems = [];
        $hasBottomItems = [];
        $ifTopBottomItems = [];
        $otherItems = [];
        $hasTop = false;
        $hasBottom = false;
        $hasTopBottom = false;
        $totalQty = 0;

        $sTop = [
            404,
            509,
            370,
            353,
            508,
            409,
            369,
            1266,
            406,
            1182,
            367,
            424,
            392,
            368,
            389,
            401,
            371,
            372,
            403,
            400,
            512,
            399,
            507];
        $sBottom = [
            379,
            1257,
            1256,
            378,
            419,
            452,
            382,
            395,
            381,
            398,
            376];
        $skipIds = [
            1286,
            411,
            407,
            1290,
            1277,
            410,
            413];
        $usedCategories = [];

        $ifTopBottom = [
            405,
            1275,
            1262,
            1170,
            375,
            377,
            394,
            1276
        ];

        $map = [];
        foreach ($arParams["BASKET"] as $key => $basketItem) {
            $map[$basketItem['id']] = $key;
            if( !empty($basketItem['data']['DISCOUNT_PRICE']) || $basketItem['data']['PRICE_TYPE_ID'] == 2 ){
                continue;
            }
            $productId = (int)$basketItem['data']['PRODUCT_ID'];

            if ($productId <= 0) { continue; }

            $sectionIds = self::getProductSections($productId);

            if( array_intersect($sectionIds, $sTop) ){

                if (!$hasTop) {
                    $hasTop = true;
                    $usedCategories = array_merge($usedCategories, array_intersect($sectionIds, $sBottom));
                }else if( !$hasTopBottom){
                    if( empty(array_intersect($sectionIds, $usedCategories)) ){
                        $hasTopBottom = true;
                    }
                }
                $hasTopItems[] = $basketItem['id'];
                $totalQty += (float)$basketItem['data']['QUANTITY'];
            }else if(array_intersect($sectionIds, $sBottom)){
                if (!$hasBottom) {
                    $hasBottom = true;
                    $usedCategories = array_merge($usedCategories, array_intersect($sectionIds, $sBottom));
                }else if( !$hasTopBottom){
                    if( empty(array_intersect($sectionIds, $usedCategories)) ){
                        $hasTopBottom = true;
                    }

                }
                $hasBottomItems[] = $basketItem['id'];
                $totalQty += (float)$basketItem['data']['QUANTITY'];
            }else if( array_intersect($sectionIds, $ifTopBottom) ){
                $ifTopBottomItems[] = $basketItem['id'];
            }if( empty(array_intersect($sectionIds, $skipIds)) ){
                $otherItems[] = $basketItem['id'];
            }
        }

        if( ($hasTop && $hasBottom && ($hasTopBottom || !empty($ifTopBottomItems))/* && $totalQty >= 3*/) ){
            $allItems = array_unique(array_merge($hasTopItems, $hasBottomItems, $otherItems, $ifTopBottomItems));
            foreach ($allItems as $item){
                $key = $map[$item];
                $basketItem = $arParams["BASKET"][$key];
                $arParams["BASKET"][$key]['data']['PRICE'] = $basketItem['data']['PRICE']*(1-$percent/100);
                $arParams['SQLS'][] = 'update b_sale_basket set PRICE = '.$arParams["BASKET"][$key]['data']['PRICE'].' where ID = ' . $item;
            }
            $arParams['IS_ACTION_08']=true;
        }

        return $arParams;
    }


    protected static function getProductSections($productId)
    {
        static $cache = [];

        if (isset($cache[$productId])) {
            return $cache[$productId];
        }

        $ids = [];

        $parent = \CCatalogSku::GetProductInfo($productId);
        $elementId = $parent['ID'] ?? $productId;

        $candidates = [$productId];
        if ($elementId !== $productId) {
            $candidates[] = $elementId;
        }

        foreach ($candidates as $eid) {
            $res = \CIBlockElement::GetElementGroups($eid, true, ["ID"]);
            while ($row = $res->Fetch()) {
                $ids[(int)$row["ID"]] = (int)$row["ID"];
            }
        }

        return $cache[$productId] = array_values($ids);
    }
}
