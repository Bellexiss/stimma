$(document).ready(function()
{
    const $photos = $('.claude_photo').filter(':visible');

    if ($photos.length) {
        const randomIndex = Math.floor(Math.random() * $photos.length);
        const $randomPhoto = $photos.eq(randomIndex);

        console.log('$randomPhoto');
        console.log($randomPhoto);

        $($randomPhoto).append('<img class="current_claude_photo buy_product" data-id="47170" src="/bitrix/templates/stimma_new/images/claude/claude'+window.numberClaude+'.png">');
    }
});