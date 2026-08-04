<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Особистий кабінет");
?>

	<?if(isset($_GET['newstimma'])  || NEW_STIMMA)
    {
        global $DB,$USER;
        $ru=LANGUAGE_ID=='ru'?'/ru':'';
        if(!$USER->IsAuthorized())
        {
            include $_SERVER['DOCUMENT_ROOT'].$ru.'/auth/auth.php';
        }
        else
        {
            $oIds=$orders=$products=$orderStatus=$mainProducts=$colors=[];

            $res=$DB->Query('select * from max_color_reference');
            while ($record = $res->Fetch())
                $colors[$record['UF_XML_ID']]=$record;

            $res=$DB->Query('select * from b_sale_status_lang');
            while ($record = $res->Fetch())
                $orderStatus[$record['STATUS_ID']][$record['LID']]=$record['NAME'];

            $res=$DB->Query('select * from b_sale_order where USER_ID='.$USER->GetID(). ' order by ID desc');

            while ($record =$res->Fetch())
            {
                $orders[$record['ID']]=$record;
                $oIds[]=$record['ID'];
            }

            if(!empty($oIds))
            {
                $res=$DB->Query('select * from b_sale_basket where ORDER_ID in ('.implode(',',$oIds).')');
                while ($record =$res->Fetch())
                {
                    $orders[$record['ORDER_ID']]['BASKET'][$record['ID']]=$record;
                    $products[$record['PRODUCT_ID']]=$record['PRODUCT_ID'];
                }
            }
            if(!empty($products))
            {
                $res=CIBlockElement::GetList(array(),array('IBLOCK_ID'=>25, 'ID'=>$products));
                while ($record =$res->GetNextElement())
                {
                    $fields=$record->GetFields();
                    $properties=$record->GetProperties();
                    $products[$fields['ID']]=$fields;
                    $products[$fields['ID']]['PROPERTIES']=$properties;
                    $mainProducts[$properties['CML2_LINK']['VALUE']]=$properties['CML2_LINK']['VALUE'];
                }
            }
            if(!empty($mainProducts))
            {
                $res=CIBlockElement::GetList(array(),array('ID'=>$mainProducts));
                while ($record =$res->GetNextElement())
                {
                    $fields=$record->GetFields();
                    $properties=$record->GetProperties();
                    $mainProducts[$fields['ID']]=$fields;
                    $mainProducts[$fields['ID']]['PROPERTIES']=$properties;
                }
            }

            ?>
            <div class="breadcrumbs-cont">
                <div class="wrapper">
                    <div class="breadcrumbs-block">
                        <a href="/" class="breadcrumb-item">
                            STIMMA
                        </a>
                        <span class="breadcrumb-sep">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3.99998C5 4.09298 4.95927 4.18607 4.87792 4.25707L0.711272 7.89343C0.548461 8.03552 0.284816 8.03552 0.122109 7.89343C-0.0405988 7.75134 -0.0407029 7.52125 0.122109 7.37925L3.99417 3.99998L0.122108 0.620715C-0.0407032 0.478625 -0.0407032 0.248534 0.122108 0.106534C0.28492 -0.0354662 0.548564 -0.0355568 0.711272 0.106533L4.87792 3.74289C4.95927 3.81389 5 3.90698 5 3.99998Z" fill="currentcolor"></path>
                        </svg>
                    </span>
                        <span class="breadcrumb-item">
                        <?=LANGUAGE_ID=='ua'?'Особистий кабінет':'Личный кабинет'?>
                    </span>
                    </div>
                </div>
            </div>

            <div class="personal-page">
                <div class="wrapper">
                    <div class="personal-cont">
                        <?include '../left_menu.php'?>


                        <div class="personal-content">


                            <div class="personal-content-block">
                                <div class="personal-content-title-block">
                                    <div class="personal-content-title">
                                        <?=LANGUAGE_ID=='ua'?'Мої замовлення':'Мои заказы'?>
                                    </div>
                                </div>
                                <div class="personal-order-cont">
                                    <?
                                    foreach ($orders as $index => $order)
                                    {
                                        ?>
                                        <div class="personal-order-element">
                                            <div class="personal-order-info-block">
                                                <div class="personal-order-name-block">
                                                    <div class="personal-order-name">
                                                        <?=LANGUAGE_ID=='ua'?'Замовлення':'Заказ'?>: <span>#<?=$order['ID']?></span>, <?=date('d.m.Y H:i:s', strtotime($order['DATE_INSERT']))?>
                                                    </div>
                                                    <?/*<div class="personal-order-status">
                                                        <?=$orderStatus[$order['STATUS_ID']][LANGUAGE_ID]?>
                                                    </div>*/?>
                                                </div>
                                                <div class="personal-order-total-block">
                                                    <div class="personal-order-total-title">
                                                        Всього
                                                    </div>
                                                    <div class="personal-order-total">
                                                        <?=FormatCurrency($order['PRICE'], 'UAH')?> ₴
                                                    </div>
                                                </div>
                                                <div class="personal-order-preview-block">
                                                    <div class="personal-order-preview">
                                                        <?
                                                        foreach ($order['BASKET'] as $item)
                                                        {
                                                            $pid=$item['PRODUCT_ID'];
                                                            $img = $mainProducts[$products[$pid]['PROPERTIES']['CML2_LINK']['VALUE']]['PROPERTIES']['PHOTO_GALLERY']["VALUE"][0];
                                                            //$img=CFile::GetFileArray($img)['SRC'];
                                                            $img = CFile::ResizeImageGet($img, array('width'=>65, 'height'=>95), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];

                                                            ?>
                                                            <div class="personal-order-preview-item">
                                                                <img src="<?=$img?>">
                                                            </div>
                                                            <?
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="personal-order-arrow">
                                                        <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.00004 11C8.79079 11 8.58133 10.9104 8.42158 10.7314L0.239778 1.5648C-0.079926 1.20661 -0.079926 0.626596 0.239778 0.268639C0.559482 -0.0893172 1.07719 -0.0895464 1.39669 0.268639L9.00004 8.78718L16.6034 0.268639C16.9231 -0.0895464 17.4408 -0.0895464 17.7603 0.268639C18.0798 0.626825 18.08 1.20684 17.7603 1.5648L9.57849 10.7314C9.41874 10.9104 9.20929 11 9.00004 11Z" fill="currentcolor"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="personal-order-dropdown">
                                                <div class="personal-order-item-list">
                                                    <?
                                                    foreach ($order['BASKET'] as $item)
                                                    {
                                                        $pid=$item['PRODUCT_ID'];
                                                        $img = $mainProducts[$products[$pid]['PROPERTIES']['CML2_LINK']['VALUE']]['PROPERTIES']['PHOTO_GALLERY']["VALUE"][0];
                                                        //$img=CFile::GetFileArray($img)['SRC'];
                                                        $img = CFile::ResizeImageGet($img, array('width'=>150, 'height'=>230), BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'];
                                                        ?>
                                                        <div class="personal-order-item-block">
                                                            <div class="personal-order-item">
                                                                <div class="personal-order-item-img">
                                                                    <a href="#">
                                                                        <img src="<?=$img?>">
                                                                    </a>
                                                                </div>
                                                                <div class="personal-order-item-info-block">
                                                                    <div class="personal-order-item-info">
                                                                        <div class="personal-order-item-prop-block">
                                                                            <a href="#" class="personal-order-item-name">
                                                                                <?=LANGUAGE_ID=='ua'?$products[$pid]['PROPERTIES']['NAME_UA']['VALUE']:$products[$pid]['NAME']?>
                                                                            </a>
                                                                            <div class="personal-order-item-prop-cont">
                                                                                <div class="personal-order-item-prop">
                                                                                    <div class="personal-order-item-size">
                                                                                        Розмір:
                                                                                        <span><?=$products[$pid]['PROPERTIES']['RAZMER']['VALUE']?></span>
                                                                                    </div>
                                                                                    <div class="personal-order-item-color">
                                                                                        Колір:
                                                                                        <span style="background: <?=$colors[$products[$pid]['PROPERTIES']['COLOR_REF']['VALUE'][0]]['UF_COLOR_CODE']?>;"> </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="personal-order-item-price-block">
                                                                            <div class="personal-order-item-price">
                                                                                <?=FormatCurrency($item['PRICE']*$item['QUANTITY'], 'UAH')?> ₴
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <?
        }

        ?>


    <?}else{?>

		<?
		global $USER;

		if(!$USER->isAuthorized()){
			LocalRedirect(SITE_DIR.'auth/');
		}
		else{

			if($APPLICATION->GetCurPage() == '/personal/orders/')
			{
				global $DB;
				$DB->Query('update b_sale_order set LID = \''.SITE_ID.'\' where USER_ID = '.$USER->GetID());
			}

			//LocalRedirect(SITE_DIR.'personal/personal-data');?>
			<?
			if(strpos($APPLICATION->GetCurPage(),'/personal/loyalty/') === false)
			{
				?>
				<?$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.section",
				"main",
				array(
					"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
						0 => "0",
					),
					"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
					"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
					"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
						0 => "100",
						1 => "200",
						2 => "500",
						3 => "1000",
						4 => "5000",
						5 => "",
					),
					"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "A",
					"CHECK_RIGHTS_PRIVATE" => "N",
					"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
					"CUSTOM_PAGES" => "",
					"CUSTOM_SELECT_PROPS" => array(
					),
					"NAV_TEMPLATE" => "",
					"ORDER_HISTORIC_STATUSES" => array(
						0 => "P",
						1 => "F",
					),
					"PATH_TO_BASKET" => "/basket/",
					"PATH_TO_CATALOG" => "/catalog/",
					"PATH_TO_CONTACT" => "/contacts",
					"PATH_TO_PAYMENT" => "/order/payment/",
					//"PATH_TO_LOYALTY" => "/personal/loyalty/",
					"PER_PAGE" => "20",
					"PROP_1" => array(
					),
					"PROP_2" => array(
					),
					"SAVE_IN_SESSION" => "Y",
					"SEF_FOLDER" => "/personal/",
					"SEF_MODE" => "Y",
					"SEND_INFO_PRIVATE" => "N",
					"SET_TITLE" => "Y",
					"SHOW_ACCOUNT_COMPONENT" => "Y",
					"SHOW_ACCOUNT_PAGE" => "N",
					"SHOW_ACCOUNT_PAY_COMPONENT" => "N",
					"SHOW_BASKET_PAGE" => "N",
					"SHOW_CONTACT_PAGE" => "N",
					"SHOW_ORDER_PAGE" => "Y",
					"SHOW_PRIVATE_PAGE" => "Y",
					"SHOW_PROFILE_PAGE" => "N",
					"SHOW_SUBSCRIBE_PAGE" => "N",
					"USER_PROPERTY_PRIVATE" => "",
					"USE_AJAX_LOCATIONS_PROFILE" => "N",
					"COMPONENT_TEMPLATE" => "main",
					"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"ORDER_HIDE_USER_INFO" => array(
						0 => "0",
					),
					"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
						0 => "0",
					),
					"ORDER_DEFAULT_SORT" => "STATUS",
					"ALLOW_INNER" => "N",
					"ONLY_INNER_FULL" => "N",
					"ORDERS_PER_PAGE" => "20",
					"PROFILES_PER_PAGE" => "20",
					"MAIN_CHAIN_NAME" => "Мой кабинет",
					"SEF_URL_TEMPLATES" => array(
						"index" => "index.php",
						"orders" => "orders/",
						"account" => "account/",
						//"loyalty" => "loyalty/",
						"subscribe" => "subscribe/",
						"profile" => "profiles/",
						"profile_detail" => "profiles/#ID#",
						"private" => "private/",
						"order_detail" => "order/#ID#/",
						"order_cancel" => "cancel/#ID#",
					)
				),
				false
			);?>
				<?
			}

			?>

		<?}?>

<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>