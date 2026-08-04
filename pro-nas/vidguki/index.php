<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На даній сторінці кожен бажаючий може залишити відгук про наш товар і роботі магазину! Так само кожен бажаючий може тут залишити свої рекомендації, ідеї та побажання щодо продукції, що випускається. &nbsp;");
$APPLICATION->SetPageProperty("title", "Відгуки &ndash; STIMMA");
$APPLICATION->SetTitle("ВІДГУКИ");
?>
    <div class="info-page">
        <div class="info-page-tabs info-page-tabs-main">
            <?/*$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "page_info_menu",
                array(
                    "COMPONENT_TEMPLATE" => "page_info_menu",
                    "ROOT_MENU_TYPE" => "info_menu",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ),
                false
            );*/?>
            <div class="tab-content" style="max-width: inherit">
                <div class="tab-pane fade active in" id="stab1-b">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "vidguki.php",
                            "AREA_FILE_RECURSIVE" => "N",
                            "EDIT_MODE" => "html",
                        ),
                        false,
                        Array('HIDE_ICONS' => 'N')
                    );?>
                    <?
                    if($USER -> IsAuthorized())
                    {
                        ?>
                        <div class="reviews-cont">
                            <div class="reviews-add-comment">
                                <a href="#" class="reviews-add-comment-btn">
                                    Додати відгук
                                </a>
                            </div>
                            <div class="reviews-form">
                                <form>
                                    <input type="hidden" name="reviews-id-product" value="<?=$arResult['ID']?>">
                                    <div class="form-group group2">
                                        <div class="form-wrap">
                                            <div class="form-wrap-title">
                                                Ваше ім'я
                                                <span class="required">*</span>
                                            </div>
                                            <input type="text" name="name">
                                        </div>
                                        <div class="form-wrap">
                                            <div class="form-wrap-title">
                                                E-mail
                                            </div>
                                            <input type="text" name="email">
                                        </div>
                                    </div>
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            Ваша оцінка
                                        </div>
                                        <div class="wrap-stars-cont">
                                            <div class="star-block">
                                                <input id="star5" name="star" type="radio" value="5">
                                                <label for="star5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </label>
                                                <input id="star4" name="star" type="radio" value="4">
                                                <label for="star4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </label>
                                                <input id="star3" name="star" type="radio" value="3">
                                                <label for="star3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </label>
                                                <input id="star2" name="star" type="radio" value="2">
                                                <label for="star2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </label>
                                                <input id="star1" name="star" type="radio" value="1">
                                                <label for="star1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24">
                                                        <defs></defs>
                                                        <path data-name="Shape 921 copy 8" class="cls-1" d="M461.929,5200H472l-7.845,5.88L467,5215l-8.481-4.86L450,5215l2.79-9.13h0L445,5200h10.055l3.464-8.99Z" transform="translate(-445 -5191)"></path>
                                                    </svg>
                                                </label>
                                            </div>
                                            <div class="star-rating">
                                                Без оцінки
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-wrap">
                                        <div class="form-wrap-title">
                                            Коментар
                                        </div>
                                        <textarea name="comment"></textarea>
                                    </div>
                                    <div class="fort-wrap-btn-block">
                                        <button type="submit" name="send_review" class="fort-wrap-btn">ОПУБЛІКУВАТИ ВІДГУК</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function()
                            {
                                $(document).on('click', '[name=send_review]', function()
                                {
                                    form = $(this).closest('form').serialize();
                                    $.ajax({
                                        url: '/ajax/new/reviews.php',
                                        data: form,
                                        type: 'POST',
                                        dataType:'json'
                                    }).done(function(html)
                                    {

                                        $('.reviews-cont').text('Дякуємо. Ваш відгук збережений. Після модерації він буде опублікований.')
                                        $('.reviews-cont').css('text-align', 'center');
                                        $('.reviews-cont').css('color', '#3D441D');
                                    });

                                    return false;
                                });
                            });
                        </script>
                        <?
                    }
                    else
                    {
                        ?>
                    <div class="reviews-cont">
                        <div class="reviews-add-comment">
                        <a style="color:#8B0000;" rel="nofollow" title="<?=LANGUAGE_ID == 'ua' ? 'Мій кабінет' : 'Мой кабинет'?>" class="personal-link dark-color animate-load" data-event="jqm" data-param-type="auth" data-param-backurl="/" data-name="auth" href="/personal/">
                            Увійти, щоб залишити відгук
                        </a>
                        </div>
                    </div>
                        <?
                    }
                    ?>

                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "front_review2",
                        array(
                            "SHOW_DETAIL_LINK" => "N",
                            "NOT_SLIDER" => "Y",
                            "TITLE" => "Наше портфоліо",
                            "SUB_TITLE" => "Останні рішення",
                            "ACTIVE_DATE_FORMAT" => "j F Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array(
                                0 => "DETAIL_TEXT",
                                1 => "",
                            ),
                            "FILTER_NAME" => "f_block",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "35",
                            "IBLOCK_TYPE" => "",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "5",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Новости",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array(
                                0 => "PRICE",
                                1 => "",
                            ),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "SORT",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N",
                            "COMPONENT_TEMPLATE" => "last_ _portfolio_solutions"
                        ),
                        false
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="card-main-tabs-mobile">
            <div class="card-tabs-mobile-item">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "vidguki.php",
                        "AREA_FILE_RECURSIVE" => "N",
                        "EDIT_MODE" => "html",
                    ),
                    false,
                    Array('HIDE_ICONS' => 'N')
                );?>
            </div>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>