<?
define('NNED_AUTH',true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Особистий кабінет");
?>

	<?if(isset($_GET['newstimma']) || true || NEW_STIMMA )
    {

        global $USER;
        $ru=LANGUAGE_ID=='ru'?'/ru':'';
        if(!$USER->IsAuthorized())
        {
            include $_SERVER['DOCUMENT_ROOT'].$ru.'/auth/auth.php';
        }
        else
        {
            $user=$USER->GetByID($USER->GetID())->Fetch();
            $ru=LANGUAGE_ID=='ru'?'/ru':'';
           
            $result = GetBalance($user['XML_ID']);

            $balance = $result['response']['Balance'];
            //$balance=1234;

            if($balance>=0 && $balance<=4999) {$id=46176;$next=46177;}
            elseif($balance>=5000 && $balance<=9999) {$id=46177;$next=46178;}
            elseif($balance>=10000 && $balance<=19999) {$id=46178;$next=46179;}
            elseif($balance>=20000) {$id=46179;$next=0;}

            $item = CIBlockElement::GetByID($id)->GetNextElement();
            $fields = $item->GetFields();
            $properties = $item->GetProperties();

            if($next)
            {
                $itemNext = CIBlockElement::GetByID($next)->GetNextElement();
                $fieldsNext = $itemNext->GetFields();
                $propertiesNext = $itemNext->GetProperties();
            }
            if(!$next) $percent=100;
            else $percent=round(($balance/$propertiesNext['MAX_PRICE']['VALUE'])*100,0);

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
                        Особистий кабінет
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
                                        Бонусний рахунок
                                    </div>
                                    <a href="<?=$ru?>/sama_sobi/" class="personal-title-link">
                                        Дізнайся свої переваги
                                    </a>
                                </div>
                                <div class="personal-bonus-cont">
                                    <div class="personal-bonus-lvl">
                                        <div class="personal-bonus-lvl-type">
                                            <?
                                            //if($balance>4999)
                                            {
                                                ?>
                                                <div class="personal-bonus-lvl-item">
                                                    <div class="personal-bonus-lvl-img">
                                                        <img src="/bitrix/templates/stimma_new/images/imgnew/personallvl1.png">
                                                    </div>
                                                    <div class="personal-bonus-lvl-name">
                                                        <?=$fields['NAME']?>
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>

                                            <?
                                            if($fieldsNext['ID'])
                                            {
                                                ?>
                                                <div class="personal-bonus-lvl-item">
                                                    <div class="personal-bonus-lvl-name">
                                                        <?=$fieldsNext['NAME']?>
                                                    </div>
                                                    <div class="personal-bonus-lvl-img">
                                                        <img src="/bitrix/templates/stimma_new/images/imgnew/personallvl2.png">
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>

                                        </div>
                                        <div class="personal-bonus-progress-bar">
                                            <div class="personal-bonus-progress-line" style="width: <?=$percent?>%;">

                                            </div>
                                            <div class="personal-bonus-progress-info">
		    								<span class="current">
		    									<?=$balance?>
		    								</span>
                                                <?
                                                if($fieldsNext['ID'])
                                                {
                                                    ?>
                                                    /
                                                    <span class="target">
		    									<?=$properties['MAX_PRICE']['VALUE']?> ₴
		    								</span>
                                                    <?
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="personal-bonus-text-block">
                                            <div class="personal-bonus-text">
                                                Щоб отримати ще більше бенефітів - персональних знижок, унікальних доступів та інших приємностей - переходь на наступний рівень.
                                                <br> До нього залишилося лише ще придбати товари на суму <?=$properties['MAX_PRICE']['VALUE']-$balance+1?> грн. <?/*до 13.11.2025*/?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="personal-bonus-history">
                                        <div class="personal-bonus-history-title-block">
                                            <div class="personal-bonus-history-title">
                                                Мій трекер стімзів
                                            </div>
                                            <div class="personal-bonus-history-text-block">
                                                <div class="personal-bonus-history-text">
                                                    Тут ти можешь побачити повну історію нарахувань твоїх стімзів
                                                </div>
                                                <div class="personal-bonus-history-count">
                                                    Кількість моїх стімзів: <span><?=$balance?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?/*
                                    <div class="personal-table-block">
                                        <div class="personal-table-responsive">
                                            <table>
                                                <tr>
                                                    <th>
                                                        Дата
                                                    </th>
                                                    <th>
                                                        Нарахування/<br> витрати стімзів
                                                    </th>
                                                    <th>
                                                        Тип дії
                                                    </th>
                                                    <th>
                                                        Статус
                                                    </th>
                                                    <th>
                                                        Сума витрат
                                                    </th>
                                                    <th>
                                                        Сума накопичень <br> стімзів
                                                    </th>
                                                    <th>
                                                        Магазин де <br> була купівля
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        25.01.2025
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        500
                                                    </td>
                                                    <td>
                                                        3 000
                                                    </td>
                                                    <td>
                                                        м.Хмельницький <br>
                                                        вул. Проскурівська, 21/31
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        25.01.2025
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum
                                                    </td>
                                                    <td>
                                                        500
                                                    </td>
                                                    <td>
                                                        3 000
                                                    </td>
                                                    <td>
                                                        м.Хмельницький <br>
                                                        вул. Проскурівська, 21/31
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    */?>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-bottom-links">
                                <a href="<?=$ru?>/catalog/bonusna_shafa/" class="info-btn info-btn-black">
                                    товари за бонуси
                                </a>
                                <div class="personal-bottom-text">
                                    Дізнатись більше про умови програми лояльності можна <a href="<?=$ru?>/sama_sobi/">тут</a>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <?
        }

        ?>




    <?
    }
    ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>