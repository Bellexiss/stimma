<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>


<div class="project-cont">
    <?
    foreach ($arResult['ITEMS'] as $index => $arItem)
    {
        $bImage = isset($arItem['FIELDS']['PREVIEW_PICTURE']) && strlen($arItem['PREVIEW_PICTURE']['SRC']);
        $imageSrc = ($bImage ? $arItem['PREVIEW_PICTURE']['SRC'] : false);
        $name = LANGUAGE_ID =='ua'&&$arItem['PROPERTIES']['NAME_UA']['VALUE']?$arItem['PROPERTIES']['NAME_UA']['VALUE']:$arItem['NAME'];
        $shortText = LANGUAGE_ID =='ua'&&$arItem['PROPERTIES']['BNR_DOP_TEXT_UA']['VALUE']?$arItem['PROPERTIES']['BNR_DOP_TEXT_UA']['VALUE']:$arItem['PREVIEW_TEXT'];
        $detailUrl = $arItem['PROPERTIES']['LINK']['VALUE'] ? $arItem['PROPERTIES']['LINK']['VALUE'] : $arItem['DETAIL_PAGE_URL'];
        ?>
        <div class="project-block">
            <div class="project-wrapper">
                <div class="project-info">
                    <a href="<?=$detailUrl?>" class="project-name">
                        <?=$name?>
                    </a>
                    <div class="project-text">
                        <?=$shortText?>
                    </div>
                    <div class="project-btn">
                        <a href="<?=$detailUrl?>" class="info-btn">
                            Детальніше
                            <span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
                        </a>
                    </div>
                </div>
                <div class="project-img">
                    <a href="<?=$detailUrl?>">
                        <img src="<?=$imageSrc?>">
                    </a>
                </div>
            </div>
        </div>
        <?
    }
    ?>
    <?/*
    <div class="project-block">
        <div class="project-wrapper">
            <div class="project-info">
                <a href="#" class="project-name">
                    Розіграш до колекції VOLIA
                </a>
                <div class="project-text">
                    У межах виходу колекції VOLIA ми провели особливий розіграш, який поєднав мистецтво, моду та доброту. Розігрувалась унікальна картина художника Михайла Коробкова, створена спеціально для цієї колекції.
                </div>
                <div class="project-btn">
                    <a href="#" class="info-btn">
                        Детальніше
                        <span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
                    </a>
                </div>
            </div>
            <div class="project-img">
                <a href="#">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/progectimg1.png">
                </a>
            </div>
        </div>
    </div>
    <div class="project-block">
        <div class="project-wrapper">
            <div class="project-info">
                <a href="#" class="project-name">
                    Благодійна ініціатива від Tabletochki та Stimma
                </a>
                <div class="project-text">
                    Ми створили унікальні шпарпетки, щоб нагадати про можливість підтримки. Кожна пара шкарпеток- допомога найменшим.
                </div>
                <div class="project-btn">
                    <a href="#" class="info-btn">
                        Детальніше
                        <span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
                    </a>
                </div>
            </div>
            <div class="project-img">
                <a href="#">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/progectimg2.png">
                </a>
            </div>
        </div>
    </div>
    <div class="project-block">
        <div class="project-wrapper">
            <div class="project-info">
                <a href="#" class="project-name">
                    Незалежні 33: Маніфест STIMMA
                </a>
                <div class="project-text">
                    З нагоди 33-ї річниці Незалежності України бренд одягу STIMMA презентує проєкт “Незалежні 33”, присвячений силі та впевненості українських жінок.
                </div>
                <div class="project-btn">
                    <a href="#" class="info-btn">
                        Детальніше
                        <span class="icon">
	        						<svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g >
										<path d="M9.41846 5.50003C9.41846 5.69717 9.33635 5.89429 9.17246 6.04459L4.01268 10.7743C3.68445 11.0752 3.15229 11.0752 2.8242 10.7743C2.4961 10.4736 2.4961 9.98587 2.8242 9.68498L7.38986 5.50003L2.82435 1.31506C2.49626 1.01419 2.49626 0.526517 2.82435 0.225789C3.15245 -0.0752306 3.68461 -0.0752306 4.01284 0.225789L9.17262 4.95547C9.33653 5.10584 9.41846 5.30296 9.41846 5.50003Z" fill="currentcolor"/>
										</g>
									</svg>
	        					</span>
                    </a>
                </div>
            </div>
            <div class="project-img">
                <a href="#">
                    <img src="/bitrix/templates/stimma_new/images/imgnew/progectimg3.png">
                </a>
            </div>
        </div>
    </div>
    */?>
</div>


