<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$templateData['TEMPLATE_THEME'].'/style.css');
	$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$templateData['TEMPLATE_THEME'].'/style.css', true);
}

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;

	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

if (isset($templateData['JS_OBJ']))
{
	?>
	<script>
		BX.ready(BX.defer(function(){
			if (!!window.<?=$templateData['JS_OBJ']?>)
			{
				window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
			}
		}));
	</script>

	<?
	// check compared state
	if ($arParams['DISPLAY_COMPARE'])
	{
		$compared = false;
		$comparedIds = array();
		$item = $templateData['ITEM'];

		if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]))
		{
			if (!empty($item['JS_OFFERS']))
			{
				foreach ($item['JS_OFFERS'] as $key => $offer)
				{
					if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
					{
						if ($key == $item['OFFERS_SELECTED'])
						{
							$compared = true;
						}

						$comparedIds[] = $offer['ID'];
					}
				}
			}
			elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
			{
				$compared = true;
			}
		}

		if ($templateData['JS_OBJ'])
		{
			?>
			<script>
				BX.ready(BX.defer(function(){
					if (!!window.<?=$templateData['JS_OBJ']?>)
					{
						window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

						<? if (!empty($comparedIds)): ?>
						window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
						<? endif ?>
					}
				}));
			</script>
			<?
		}
	}

	// select target offer
	$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	$offerNum = false;
	$offerId = (int)$this->request->get('OFFER_ID');
	$offerCode = $this->request->get('OFFER_CODE');

	if ($offerId > 0 && !empty($templateData['OFFER_IDS']) && is_array($templateData['OFFER_IDS']))
	{
		$offerNum = array_search($offerId, $templateData['OFFER_IDS']);
	}
	elseif (!empty($offerCode) && !empty($templateData['OFFER_CODES']) && is_array($templateData['OFFER_CODES']))
	{
		$offerNum = array_search($offerCode, $templateData['OFFER_CODES']);
	}

	if (!empty($offerNum))
	{
		?>
		<script>
			BX.ready(function(){
				if (!!window.<?=$templateData['JS_OBJ']?>)
				{
					window.<?=$templateData['JS_OBJ']?>.setOffer(<?=$offerNum?>);
				}
			});
		</script>
		<?
	}
}

$_SESSION['VIEWED'][$arResult['ID']] = $arResult['ID'];
$ua = LANGUAGE_ID == 'ua';
//if(LANGUAGE_ID == 'ua')
{
    $url = (!$ua ? '/ru' : '').'/catalog/';
    $nav = CIBlockSection::GetNavChain(false, $arResult['IBLOCK_SECTION_ID']);
    while($record = $nav->Fetch())
    {
        $section = CIBlockSection::GetList([], ['ID' => $record['ID'], 'IBLOCK_ID' => 21],false, ['ID','IBLOCK_ID','CODE', 'UF_*', 'NAME']) -> Fetch();
        $name = $ua ? $section['UF_NAME_UA'] : $section['NAME'];
        $url .= $section['CODE'].'/';

        $APPLICATION -> AddChainItem($name, $url);
    }
    $name = $ua ? $arResult['PROPERTIES']['NAME_UA']['VALUE'] : $arResult['NAME'];
    $APPLICATION -> AddChainItem($name, '');

}
global $dataSeoElement;

if(LANGUAGE_ID == 'ru')
{
    $dataSeoElement = $APPLICATION->IncludeComponent(
        "dwstroy:dwstroy.seo.element",
        "",
        Array(
            "ELEMENT_ID" => $arResult['ID'], //Ид товара(элемента) инфоблока
            "IBLOCK_ID" => $arParams['IBLOCK_ID'], //Ид инфоблока
            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'], //Код типа инфоблока
            "LANG_ID" => LANGUAGE_ID, //Код вкладки
            "SET_BROWSER_TITLE" => "Y", //Установить title
            "SET_META_DESCRIPTION" => "Y", //Установить description
            "SET_META_KEYWORDS" => "Y", //Установить keywords
            "SET_TITLE" => "Y", //Установить h1
            "TYPE" => "1" // Если домен равен ID вкладки
        )
    );
}
else
    $dataSeoElement = $arResult['IPROPERTY_VALUES'];

