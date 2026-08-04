<div class="top-block-wrapper">
    <?
    {
        global $DB;
        $cache = explode('/', $APPLICATION->GetCurPage());
        $cache = $cache[count($cache)-2];
        $isDetail = false;
        $is = $DB->Query('select * from b_iblock_element where CODE = \'' . $cache .' \' and IBLOCK_ID = 21 and ACTIVE = \'Y\'');
        if($is = $is->Fetch())
            $isDetail = true;
    }
    if(strpos($APPLICATION->GetCurPage(), '/catalog/') === false || $isDetail)
    {
        ?>
        <section class="intoppage page-top <?=strpos($APPLICATION -> GetCurPage(), '/sertificate/')   || strpos($APPLICATION -> GetCurPage(), '/ru/sertificate/') ? 'maxwidth-theme-custom' : 'maxwidth-theme'?> <?CMax::ShowPageProps('TITLE_CLASS');?>">
            <div class="topic">
                <div class="topic__inner">
                    <?=$APPLICATION->ShowViewContent('product_share')?>
                    <div class="topic__heading">
                        <h1 id="pagetitle th42"><?$APPLICATION->ShowTitle(false)?></h1><?$APPLICATION->ShowViewContent('more_text_title');?>
                    </div>
                </div>
            </div>
            <?$APPLICATION->ShowViewContent('section_bnr_h1_content');?>
            <div id="navigation" class="page_title_3">
                <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => SITE_ID,
                    "SHOW_SUBSECTIONS" => "N"
                ),
                                                 false
                );?>
            </div>
        </section>
        <?
    }
    ?>
</div>