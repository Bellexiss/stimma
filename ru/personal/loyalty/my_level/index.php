<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мій рівень");
//$APPLICATION->SetTitle("Оплата заказа");

$defaultLoyalityEl = [
        1 => 46176,
        2 => 46177,
        3 => 46178,
        4 => 46179,
];

global $USER;
use Bitrix\Main\Loader;
use Bitrix\Sale\Internals\DiscountCouponTable;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
if ($USER->IsAuthorized()) {
    $userId = $USER->GetID();
    $rsUser = CUser::GetByID($userId);
    $arUser = $rsUser->Fetch();
    // Получение значения пользовательского поля
    $loyaltyGroup = $arUser['UF_LOYALTY_GROUP'];
    if (!empty($loyaltyGroup)) {
        $rsEnum = CUserFieldEnum::GetList([], [
            "ID" => $loyaltyGroup
        ]);
        if ($arEnum = $rsEnum->GetNext()) {
            //PR($arEnum['XML_ID']);
            $UserLoyaltyGroup = $arEnum['XML_ID'];
        }
    }
if(!$UserLoyaltyGroup){
		$UserLoyaltyGroup = 1;
}
    if(!$UserLoyaltyGroup){
		ShowError("У вас еще нет уровня");
    }else{
        // Подготавливаем выборку
        $arFilter = ["IBLOCK_ID" => 54, "ID" => $defaultLoyalityEl[$UserLoyaltyGroup], "ACTIVE" => "Y"];
        $arSelect = ["*"];
        // Получаем данные элемента
        $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        if ($ob = $res->GetNextElement()) {
            $props = $ob->GetProperties();
            //PR($props);
            $arResult['CURRENT'] = $ob->GetFields();
            $arResult['CURRENT']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['CURRENT']["PREVIEW_PICTURE"]);
            $arResult['CURRENT']['PROPERTIES'] = $props;
        }
        if($UserLoyaltyGroup < 4){

            // Подготавливаем выборку
            $arFilter = ["IBLOCK_ID" => 54, "ID" => $defaultLoyalityEl[$UserLoyaltyGroup+1], "ACTIVE" => "Y"];
            // Получаем данные элемента
            $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
            if ($ob = $res->GetNextElement()) {
                $props = $ob->GetProperties();
                //PR($props);
                $arResult['NEXT'] = $ob->GetFields();
                $arResult['NEXT']['PREVIEW_PICTURE'] = CFile::GetPath($arResult['NEXT']["PREVIEW_PICTURE"]);
                $arResult['NEXT']['PROPERTIES'] = $props;
            }
        }
        //PR($arResult['NEXT']);
        // ID HL-блока
        $HL_ID = 22;
        $hlblock = HL\HighloadBlockTable::getById($HL_ID)->fetch();
        // Подключаем сущность HL блока
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();

        // Теперь ищем записи по UF_XML_ID = XML_ID пользователя
        $filter = ['UF_XML_ID' => $arUser['XML_ID']];
        $result = $entityClass::getList([
            'select' => ['*'],
            'filter' => $filter,
            'order'  => ['UF_DATE' => 'DESC'], // например, по дате
        ]);
        $totalAccrued = 0;     // Нараховані стімзи
        $totalPending = 0;
        while ($row = $result->fetch()) {
            $date = new DateTime($row['UF_DATE']);
            $now = new DateTime();
            $diffDays = $now->diff($date)->days;
            $isOlderThan14 = $now > $date && $diffDays >= 14;

            // Подсчет общей суммы
            if ($isOlderThan14) {
                $totalAccrued += floatval($row['UF_SUM']);
            } else {
                $totalPending += floatval($row['UF_SUM']);
            }
        }
        //PR($arResult);
?>

    <div class="personal_wrapper loyalty_block">

        <div class="sss-rangs-table-cont sss-rangs-table-cont-history">
            <div class="sss-rangs-title action-title" style="<?=(empty($arResult['NEXT']) ? 'max-width:100%':'')?> margin-bottom: 100px;">
                <span class="sss-rangs-block-title">Вау, оце так рівень 😍  Ти — <?=$arResult['CURRENT']['NAME']?></span>
            </div>
            <div class="sss-rangs-table sss-rangs-table-history">
                <table>
                    <tbody>
                        <tr>
                            <th style="<?=(!empty($arResult['NEXT']) ? 'width:300px':'')?>">
                            </th>
                            <th style="<?=(empty($arResult['NEXT']) ? 'width:300px':'')?>">
                                <div class="sss-rangs-block active" >
                                    <div class="sss-rangs-block-img">
                                        <img src="<?=$arResult['CURRENT']['PREVIEW_PICTURE']?>">
                                    </div>
                                    <div class="sss-rangs-block-info">
                                        <div class="sss-rangs-block-title"><?=$arResult['CURRENT']['NAME']?></div>
                                    </div>
                                </div>
                            </th>
                            <?if(!empty($arResult['NEXT'])):?>
                            <th>
                                <div class="sss-rangs-block" >
                                    <div class="sss-rangs-block-img">
                                        <img src="<?=$arResult['NEXT']['PREVIEW_PICTURE']?>">
                                    </div>
                                    <div class="sss-rangs-block-info">
                                        <div class="sss-rangs-block-title"><?=$arResult['NEXT']['NAME']?></div>
                                    </div>
                                </div>
                            </th>
                            <?endif;?>
                        </tr>
                        <?if(!empty($arResult['NEXT'])):?>
                        <tr>

                            <td class="align-top">До наступного рівня</td>
                            <td colspan="2">
                                <!--todo: Тут нужено в прогресбар вывести свойство минимум из CURRENT и минимум из NEXT. Когда будет история заказов можно высчитывать в шкалу процесс-->
                                <?
                                $minPrice = $arResult['NEXT']['PROPERTIES']['MIN_PRICE']['VALUE'];

                                $percent = ($totalAccrued / $minPrice) * 100;
                                $percent = round($percent, 2); // округляем до двух знаков после запятой
                                ?>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: <?=$percent?>%;"></div>
                                    <div class="progress-text"><?=$totalAccrued?> / <?=$minPrice?></div>
                                </div>
                                <br>
                                <br>
                                <p>Щоб отримати ще більше бенефітів — персональних знижок, унікальних доступів та інших приємностей — переходь на наступний рівень. <br> До нього залишилося лише <?=$minPrice-$totalAccrued?> грн.</p>
                            </td>
                        </tr>
                        <?/*
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <p>Мої персональні знижки</p>
                            </td>
                        </tr>
                        <?foreach($arResult['CURRENT']['PROPERTIES'] as $prop):
                                if(in_array($prop['CODE'] ,['ICON_CSV','DIAPAZON_PRICE','MIN_PRICE','MAX_PRICE'])) continue;
                                ?>
                            <tr>
                                <td><?=$prop['NAME']?></td>
                                <td colspan="2">
                                    <?if($prop['PROPERTY_TYPE']=='S'):?>
                                    <div class="sss-rang-td-text">
                                        <?=$prop['VALUE']?>
                                    </div>
                                <?else:?>
                                        <div class="sss-rang-icon">
                                            <?if($prop['VALUE_XML_ID'] == 'Y'):?>
                                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_712)">
                                                        <rect x="2.84473" y="2.82373" width="30" height="30" rx="15" fill="#FEF7E7"/>
                                                    </g>
                                                    <path d="M17.4353 24.3003L7.47852 14.3672C7.36914 14.2578 7.31445 14.1172 7.31445 13.9453C7.31445 13.7735 7.36914 13.6328 7.47852 13.5235L8.3457 12.6797C8.45508 12.5547 8.5918 12.4922 8.75586 12.4922C8.91992 12.4922 9.06445 12.5547 9.18945 12.6797L17.8572 21.3472L35.2807 3.92368C35.4057 3.79868 35.5502 3.73618 35.7143 3.73618C35.8783 3.73618 36.0151 3.79868 36.1244 3.92368L36.9916 4.76743C37.101 4.87681 37.1557 5.01743 37.1557 5.18931C37.1557 5.36118 37.101 5.50181 36.9916 5.61118L18.2791 24.3003C18.1697 24.4253 18.0291 24.4878 17.8572 24.4878C17.6853 24.4878 17.5447 24.4253 17.4353 24.3003Z" fill="#330D2F"/>
                                                    <defs>
                                                        <filter id="filter0_d_381_712" x="0.644727" y="0.623731" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                            <feOffset dx="2" dy="2"/>
                                                            <feGaussianBlur stdDeviation="2.1"/>
                                                            <feComposite in2="hardAlpha" operator="out"/>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"/>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_712"/>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_712" result="shape"/>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            <?endif;?>
                                        </div>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?endforeach;*/?>
                        <?endif;?>
                    </tbody>
                </table>


            </div>
                
                <div class="sss-rangs-title action-title" style="<?=(empty($arResult['NEXT']) ? 'max-width:100%':'')?>">
                    <div class="sss-rangs-block-title">Мої персональні знижки:</div>
                </div>
                
            
            <?
            Loader::includeModule('sale');

            $userId = $USER->GetID(); // ID пользователя

            $couponsRes = DiscountCouponTable::getList([
                'filter' => ['=USER_ID' => $userId],
                'select' => ['*']
            ]);

            while ($coupon = $couponsRes->fetch()) {
                //PR($coupon);
                $arCoupons[] = $coupon;
            }

            foreach($arCoupons as $coupon):?>
                <?if($coupon['DISCOUNT_ID'] == 43):?>
                        <?if($coupon['ACTIVE'] == 'N'):?>
                            <b>✨ Твоя знижка –10% чекає на тебе!</b>
                            Зроби покупку вже сьогодні.<br>
                            Промокод активується на 15-ий день після першої покупки та буде діяти 90 днів на неакційні товари від STIMMA
                        <?else:?>
                        <?php
                        $daysText = "Дата завершення дії купону невідома";

                        // Проверяем, что ACTIVE_TO — это объект Bitrix\Main\Type\DateTime
                        if (!empty($coupon['ACTIVE_TO']) && $coupon['ACTIVE_TO'] instanceof \Bitrix\Main\Type\DateTime) {
                            // Преобразуем Bitrix\Main\Type\DateTime в стандартный \DateTime
                            $activeToObj = new \DateTime($coupon['ACTIVE_TO']->format('Y-m-d H:i:s'), new \DateTimeZone('Europe/Kiev'));

                            // Текущая дата
                            $now = new \DateTime('now', new \DateTimeZone('Europe/Kiev'));

                            // Разница в днях
                            $interval = $now->diff($activeToObj);
                            $daysLeft = (int)$interval->format('%r%a');

                            if ($daysLeft < 0) {
                                $daysText = "⛔️ Срок дії купону минув";
                            } else {
                                $daysText = "Залишилося {$daysLeft} днів";
                            }
                        }
                        ?>

                        <b>🎉 Вітаємо! Твій промокод –10% активовано!</b>
                        <b><?=$coupon['COUPON']?> - Дата завершення дії купону <?=date('d.m.Y', strtotime($coupon['ACTIVE_TO']))?></b>
                        Використай його на будь-які неакційні товари STIMMA протягом 90 днів.<br>
                        Не відкладайте обновки — час дії обмежений. <?= $daysText; ?>
                        <?//PR($coupon); ?>
                        <?endif;?>
                <?endif;?>
            <?endforeach?>
        </div>
        <div class="sss-rangs-cont">


            <!--Моб версия-->
            <?/*
            <div class="sss-rangs-slider-cont">
                <div class="sss-rangs-slider-title-cont">
                    <div class="sss-rangs-slider-title action-title">
                        Рівні лояльності            </div>
                    <div class="sss-rangs-slider-controls">
                        <button class="sss-rangs-slider-left slick-arrow slick-disabled" aria-disabled="true" style="display: block;">
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00488329 5.00099C0.00673151 5.22819 0.0880914 5.44767 0.234864 5.62111C0.254864 5.65111 0.264913 5.68095 0.284913 5.71095H0.294922L4.32483 9.70094C4.41411 9.79568 4.52184 9.87127 4.64136 9.92286C4.76087 9.97446 4.88972 10.001 5.0199 10.001C5.15007 10.001 5.2788 9.97446 5.39832 9.92286C5.51783 9.87127 5.62556 9.79568 5.71484 9.70094C5.89777 9.51184 6 9.2592 6 8.99611C6 8.73301 5.89777 8.48013 5.71484 8.29103L2.3949 5.00099L5.69482 1.68092C5.87739 1.49463 5.9791 1.244 5.97778 0.983167C5.97647 0.722338 5.8723 0.472535 5.68787 0.288099C5.50343 0.103662 5.25363 -0.000623136 4.9928 -0.00194049C4.73197 -0.00325784 4.48121 0.0984547 4.29492 0.281018L0.31482 4.27101C0.306543 4.27996 0.296354 4.28683 0.284913 4.29103C0.104192 4.48316 0.00395632 4.73722 0.00488329 5.00099Z" fill="black"></path>
                            </svg>
                        </button>
                        <button class="sss-rangs-slider-right slick-arrow" style="display: block;" aria-disabled="false">
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99512 5.00099C5.99327 5.22819 5.91191 5.44767 5.76514 5.62111C5.74514 5.65111 5.73509 5.68095 5.71509 5.71095H5.70508L1.67517 9.70094C1.58589 9.79568 1.47816 9.87127 1.35864 9.92286C1.23913 9.97446 1.11028 10.001 0.980102 10.001C0.849926 10.001 0.721201 9.97446 0.601685 9.92286C0.482168 9.87127 0.374437 9.79568 0.285156 9.70094C0.102233 9.51184 0 9.2592 0 8.99611C0 8.73301 0.102233 8.48013 0.285156 8.29103L3.6051 5.00099L0.305176 1.68092C0.122612 1.49463 0.0208994 1.244 0.0222168 0.983167C0.0235341 0.722338 0.127698 0.472535 0.312134 0.288099C0.49657 0.103662 0.746373 -0.000623136 1.0072 -0.00194049C1.26803 -0.00325784 1.51879 0.0984547 1.70508 0.281018L5.68518 4.27101C5.69346 4.27996 5.70365 4.28683 5.71509 4.29103C5.89581 4.48316 5.99604 4.73722 5.99512 5.00099Z" fill="black"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="sss-rangs-slider slick-initialized slick-slider">
                    <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 3740px; transform: translate3d(0px, 0px, 0px);"><div class="sss-rangs-slider-item slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" style="width: 935px;" tabindex="0">
                                <div class="sss-rangs-item">
                                    <div class="sss-rangs-block">
                                        <div class="sss-rangs-block-img">
                                            <img src="/upload/iblock/378/cnfnslt8641ff5enft7020vkwkb51oz6.png">
                                        </div>
                                        <div class="sss-rangs-block-info">
                                            <div class="sss-rangs-block-title">
                                                Зірка                            </div>
                                            <div class="sss-rangs-block-price">
                                                0 - 4999 грн                            </div>
                                        </div>
                                    </div>
                                    <div class="sss-rang-list">
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Можливість накопичувати та витрачати стімзи                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Участь у челенджах                             </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Вітальна знижка                            </div>
                                            <div class="sss-rang-list-value">
                                                10%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижка до дня народження                            </div>
                                            <div class="sss-rang-list-value">
                                                10%                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="sss-rangs-slider-item slick-slide slick-active" data-slick-index="1" aria-hidden="false" style="width: 935px;" tabindex="0">
                                <div class="sss-rangs-item">
                                    <div class="sss-rangs-block">
                                        <div class="sss-rangs-block-img">
                                            <img src="/upload/iblock/536/hdy0n2zh6v7b93prmjysun0hqki3gmcy.png">
                                        </div>
                                        <div class="sss-rangs-block-info">
                                            <div class="sss-rangs-block-title">
                                                Діва                            </div>
                                            <div class="sss-rangs-block-price">
                                                5000 - 9999 грн                            </div>
                                        </div>
                                    </div>
                                    <div class="sss-rang-list">
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Можливість накопичувати та витрачати стімзи                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Участь у челенджах                             </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Вітальна знижка                            </div>
                                            <div class="sss-rang-list-value">
                                                10%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижка до дня народження                            </div>
                                            <div class="sss-rang-list-value">
                                                15%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до обмежених у часі акцій                            </div>
                                            <div class="sss-rang-list-value">
                                                речі зі знижкою 10%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Безоплатна доставка замовлення від 1500 грн                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до ексклюзивних колаборацій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до лімітованих колекцій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="sss-rangs-slider-item slick-slide" data-slick-index="2" aria-hidden="true" style="width: 935px;" tabindex="-1">
                                <div class="sss-rangs-item">
                                    <div class="sss-rangs-block">
                                        <div class="sss-rangs-block-img">
                                            <img src="/upload/iblock/929/1bzqzyf239by1g3g23l57ovutml7q0w9.png">
                                        </div>
                                        <div class="sss-rangs-block-info">
                                            <div class="sss-rangs-block-title">
                                                Ікона стилю                            </div>
                                            <div class="sss-rangs-block-price">
                                                10000–19999 грн                            </div>
                                        </div>
                                    </div>
                                    <div class="sss-rang-list">
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Можливість накопичувати та витрачати стімзи                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Участь у челенджах                             </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Вітальна знижка                            </div>
                                            <div class="sss-rang-list-value">
                                                10%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижка до дня народження                            </div>
                                            <div class="sss-rang-list-value">
                                                18%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до обмежених у часі акцій                            </div>
                                            <div class="sss-rang-list-value">
                                                речі зі знижкою 15%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Безоплатна доставка замовлення від 1500 грн                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до ексклюзивних колаборацій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до лімітованих колекцій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижки чи сертифікати на послуги стиліста                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="sss-rangs-slider-item slick-slide" data-slick-index="3" aria-hidden="true" style="width: 935px;" tabindex="-1">
                                <div class="sss-rangs-item">
                                    <div class="sss-rangs-block">
                                        <div class="sss-rangs-block-img">
                                            <img src="/upload/iblock/87e/objywtzrg4x0jrtu0ae72c30zc7e35oe.png">
                                        </div>
                                        <div class="sss-rangs-block-info">
                                            <div class="sss-rangs-block-title">
                                                Богиня                            </div>
                                            <div class="sss-rangs-block-price">
                                                20000+ грн                            </div>
                                        </div>
                                    </div>
                                    <div class="sss-rang-list">
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Можливість накопичувати та витрачати стімзи                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Участь у челенджах                             </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Вітальна знижка                            </div>
                                            <div class="sss-rang-list-value">
                                                10%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижка до дня народження                            </div>
                                            <div class="sss-rang-list-value">
                                                20%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до обмежених у часі акцій                            </div>
                                            <div class="sss-rang-list-value">
                                                речі зі знижкою 20%                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Безоплатна доставка замовлення від 1500 грн                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до ексклюзивних колаборацій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Унікальний доступ до лімітованих колекцій                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Знижки чи сертифікати на послуги стиліста                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="sss-rang-list-item">
                                            <div class="sss-rang-list-key">
                                                Запрошення на закриті фешн-івенти                            </div>
                                            <div class="sss-rang-list-value">
                                                <svg width="39" height="40" viewBox="0 0 39 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_381_682)">
                                                        <rect x="2.68945" y="3" width="30" height="30" rx="15" fill="#FEF7E7"></rect>
                                                    </g>
                                                    <path d="M17.2801 24.4765L7.32324 14.5435C7.21387 14.4341 7.15918 14.2935 7.15918 14.1216C7.15918 13.9497 7.21387 13.8091 7.32324 13.6997L8.19043 12.856C8.2998 12.731 8.43652 12.6685 8.60059 12.6685C8.76465 12.6685 8.90918 12.731 9.03418 12.856L17.7019 21.5234L35.1254 4.09995C35.2504 3.97495 35.3949 3.91245 35.559 3.91245C35.7231 3.91245 35.8598 3.97495 35.9692 4.09995L36.8363 4.9437C36.9457 5.05308 37.0004 5.1937 37.0004 5.36558C37.0004 5.53745 36.9457 5.67808 36.8363 5.78745L18.1238 24.4765C18.0144 24.6015 17.8738 24.664 17.7019 24.664C17.5301 24.664 17.3894 24.6015 17.2801 24.4765Z" fill="#330D2F"></path>
                                                    <defs>
                                                        <filter id="filter0_d_381_682" x="0.489453" y="0.8" width="38.4" height="38.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                                            <feOffset dx="2" dy="2"></feOffset>
                                                            <feGaussianBlur stdDeviation="2.1"></feGaussianBlur>
                                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0.2 0 0 0 0 0.0509804 0 0 0 0 0.184314 0 0 0 0.46 0"></feColorMatrix>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_381_682"></feBlend>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_381_682" result="shape"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div></div></div>



                </div>
            </div>
            */?>
        </div>
    </div>
        <?
    }
}
?>
    <style>
        .progress-container {
            position: relative;
            background-color: #e0e0e0;
            border-radius: 20px;
            height: 25px;
            width: 100%;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
        }

        .progress-bar {
            background: linear-gradient(90deg, #a4c639, #6b8e23);
            height: 100%;
            width: 0;
            transition: width 0.5s ease-in-out;
            border-radius: 20px 0 0 20px;
        }

        .progress-text {
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            height: 100%;
            line-height: 25px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
    </style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>