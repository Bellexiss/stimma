$(document).ready(function()
{
    if(window.innerWidth > 576)
{
    $('.mobile_main_video').remove();
    $('.desctop_main_video').slick({dots: false,speed:1000,autoplay: true,autoplaySpeed:2000,pauseOnFocus:false,pauseOnHover:false});
}
    else
{
    $('.desctop_main_video').remove();
    $('.mobile_main_video').slick({dots: false,speed:1000,autoplay: true,autoplaySpeed:2000,pauseOnFocus:false,pauseOnHover:false});
}
})
