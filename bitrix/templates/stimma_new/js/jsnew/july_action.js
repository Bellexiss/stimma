$(document).ready(function()
{
    const $photos = $('.claude_photo').filter(':visible');

    if ($photos.length) {
        const randomIndex = Math.floor(Math.random() * $photos.length);
        const $randomPhoto = $photos.eq(randomIndex);

        console.log('$randomPhoto');
        console.log($randomPhoto);



        if(!window.user_id)
            $($randomPhoto).append('<img class="current_claude_photo isnoauth" src="/bitrix/templates/stimma_new/images/claude/claude'+window.numberClaude+'.png">');
        else if(!window.isBanka)
            $($randomPhoto).append('<img class="current_claude_photo buy_product" data-id="47170" src="/bitrix/templates/stimma_new/images/claude/claude'+window.numberClaude+'.png">');
        else
            $($randomPhoto).append('<img class="current_claude_photo isbanka" src="/bitrix/templates/stimma_new/images/claude/claude'+window.numberClaude+'.png">');
            //$($randomPhoto).append('<img class="current_claude_photo buy_product" data-id="47170" src="/bitrix/templates/stimma_new/images/claude/claude'+window.numberClaude+'.png">');
    }

    $(document).on('click','.isbanka',function()
    {
        $('.show_banka_mess').trigger('click');
        return false;
    });
    $(document).on('click','.isnoauth',function()
    {
        $('.show_banka_mess_no').trigger('click');
        return false;
    });
    $(document).on('click','.current_claude_photo.buy_product',function()
    {
        $(this).removeClass('buy_product').addClass('isbanka');
    });
});