$(document).ready(function()
{
    $(document).on('click','[name=send_account_info]',function()
    {
        var email = $('[name=USER_LOGIN]').val();
        var code = $('[name=USER_CODE]').val();
        var pass = $('[name=USER_PASS]').val();
        var repeat_pass = $('[name=USER_REPEAT_PASS]').val();

        $('.dop_text').html('');

        $.ajax({
            url: '/ajax/new/send_reset_pass.php',
            dataType: "json",
            type: "POST",
            data: {email:email,code:code,pass:pass,repeat_pass:repeat_pass},
            success: function(response)
            {
                $('.dop_text').html(response.msg);
                if(response.status == 1)
                {
                    if(response.action == 'send')
                        $('form#forgotpasswd-page-form').text('Код для відновлення паролю та інструкції вислані на ваш email');
                    else if(response.action == 'reset')
                        $('form#forgotpasswd-page-form').text('Пароль змінено успішно.');
                    //$('.set_code').show();
                    //$('.set_pass').show();
                    //$('.set_repeat_pass').show();
                }
                else
                {

                }
            },
        });

        return false;
    });
})