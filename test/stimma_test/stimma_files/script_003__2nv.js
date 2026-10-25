$(document).ready(function () {

    if($(".custom-select").length > 0){
        $(".custom-select").select2();
    }


     if ($(".card-big-slider-img-zoom").length > 0) {

  function resetMobileZoom() {
    if (window.innerWidth < 768) {
      $(".card-big-slider-img-zoom img").css({
        transform: "scale(1)",
        "transform-origin": "center center"
      });
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    const zoomContainers = document.querySelectorAll(".card-big-slider-img-zoom");

    zoomContainers.forEach(function(el) {
      init_zoom(el);
    });

    resetMobileZoom();
  });

  $(function(){

    // DESKTOP ZOOM
    $(".card-big-slider-img-zoom").on("mousemove", function(e){

      if (window.innerWidth < 768) return;

      let $img = $(this).find("img");
      let offset = $(this).offset();

      let x = (e.pageX - offset.left) / $(this).width() * 100;
      let y = (e.pageY - offset.top) / $(this).height() * 100;

      $img.css({
        "transform-origin": x + "% " + y + "%",
        "transform": "scale(2)"
      });

    }).on("mouseleave", function(){

      if (window.innerWidth < 768) return;

      $(this).find("img").css({
        transform: "scale(1)",
        "transform-origin": "center center"
      });
    });


    // MOBILE PINCH ZOOM
    let startDist = 0;

    $(".card-big-slider-img-zoom").on("touchstart", function(e){

      if (e.originalEvent.touches.length === 2) {

        let t = e.originalEvent.touches;

        startDist = Math.hypot(
          t[0].pageX - t[1].pageX,
          t[0].pageY - t[1].pageY
        );

      }

    });

    $(".card-big-slider-img-zoom").on("touchmove", function(e){

      if (e.originalEvent.touches.length === 2) {

        e.preventDefault();

        let $container = $(this);
        let $img = $container.find("img");

        let t = e.originalEvent.touches;

        let dist = Math.hypot(
          t[0].pageX - t[1].pageX,
          t[0].pageY - t[1].pageY
        );

        let scale = dist / startDist;
        scale = Math.max(1, Math.min(scale, 3));

        let centerX = (t[0].pageX + t[1].pageX) / 2;
        let centerY = (t[0].pageY + t[1].pageY) / 2;

        let offset = $container.offset();

        let x = (centerX - offset.left) / $container.width() * 100;
        let y = (centerY - offset.top) / $container.height() * 100;

        $img.css({
          "transform-origin": x + "% " + y + "%",
          "transform": "scale(" + scale + ")"
        });

      }

    });

    function resetZoom(el) {
      $(el).find("img").css({
        transform: "scale(1)",
        "transform-origin": "center center"
      });
    }

    $(".card-big-slider-img-zoom").on("touchend touchcancel", function(){
      resetZoom(this);
    });

  });

  // RESET при resize
  $(window).on("resize", function () {
    resetMobileZoom();
  });

  // 👉 якщо використовуєш Slick — розкоментуй і підстав свій клас
  
  $('.card-big-slider').on('afterChange', function(){
    resetMobileZoom();
  });
  

}

	$(document).mouseup(function (e) {
	    var container = $(".language-block");
	    if (container.has(e.target).length === 0){
	        $('.language-block').removeClass('opened');
	    }

	});

	$(document).on("click", ".language-current", function () {
	  $(this).parent().toggleClass('opened');
	});


     $('.personal-menu-trigger').on('click', function (e) {
      e.preventDefault();
      $('.personal-menu-cont').toggleClass("opened");
      $('header').toggleClass("personal-opened");
    });

    $(document).on('click', function (e) {
      if (
        !$(e.target).closest('.personal-menu-trigger').length &&
        !$(e.target).closest('.personal-menu-cont').length
      ) {
        $('.personal-menu-cont').removeClass("opened");
        $('header').removeClass("personal-opened");
      }
    });

    $(window).on('scroll', function () {
      const $header = $('.main-header-pos');

      if ($(window).scrollTop() > 0) { 
        $header.addClass('white-header');
      } else {
        $header.removeClass('white-header');
      }
    });

     $('.header-accordion-toogler').on('click', function(e){

        e.preventDefault();

        let block = $(this).closest('.header-accordion-block');
        let dropdown = block.find('.header-accordion-dropdown');

        // якщо вже відкритий — закриваємо
        if(dropdown.is(':hidden')){
            
            // закриваємо всі
            $('.header-accordion-dropdown').slideUp(200);

            dropdown.stop(true,true).slideDown(200);

        }else{
            dropdown.stop(true,true).slideUp(200);
        }

});


     $('.header-menu-item-icon-dropdown').on('click', function(e){

            e.preventDefault();

            let block = $(this).closest('.header-menu-item');
            let dropdown = block.find('.header-menu-item-dropdown-cont');

            // якщо вже відкритий — закриваємо
            if(dropdown.is(':hidden')){
                
                $(".header-menu-item").removeClass("opened");
                $('.header-menu-item-dropdown-cont').slideUp(200);

                block.addClass("opened")
                dropdown.stop(true,true).slideDown(200);

            }else{
                $(".header-menu-item").removeClass("opened");
                dropdown.stop(true,true).slideUp(200);
            }

    });


    $(document).on("click", ".city-map-item-title", function () {
        if ($(this).hasClass("opened")) {
              $(this).toggleClass('opened');
              $(this).next().slideToggle();
        }else{
              $(".city-map-item-dropdown").slideUp();
              $(".city-map-item-title").removeClass("opened");
              $(this).toggleClass('opened');
              $(this).next().slideToggle();
        }
    });

    $(document).on("click", ".chat-btn-dropdown-close", function () {
        $(".chat-btn-dropdown").removeClass("opened");
    });

    $(document).on("click", ".personal-order-info-block", function () {
              $(this).toggleClass('opened');
              $(this).next().slideToggle();
        
    });


    if ($("#trigger-link-order").length) {
        document.getElementById('trigger-link-order').addEventListener('click', function(e) {
          e.preventDefault();

          const widgetBtn = document.querySelector('.b24-widget-button-inner-item.b24-widget-button-icon-animation');
          if (widgetBtn) {
            widgetBtn.click();
          }
        });
      
    }

    $(document).on('click', '.header-basket-add-remove', function()
    {
        $(".header-basket-add-block").removeClass("opened");
    })

    $(document).on('click', '.password-swap', function () {
      const $wrapper = $(this).closest('.password-input');
      const $input = $wrapper.find('input');

      const isPassword = $input.attr('type') === 'password';

      $input.attr('type', isPassword ? 'text' : 'password');
      $(this).toggleClass('active', isPassword);
    });

    $(document).on("click", ".catalog-grid-btn", function () {
        if ($(this).hasClass("rectangle")) {
          $(".catalog-grid-btn").removeClass("active");
          $(".catalog-grid").addClass("rectangle");
          $(this).addClass("active");
          setTimeout(function() {
              $('.catalog-item-img-slider').slick('setPosition');
          }, 100);
        }else{
          $(".catalog-grid-btn").removeClass("active");
          $(".catalog-grid").removeClass("rectangle");
          $(this).addClass("active");
          setTimeout(function() {
              $('.catalog-item-img-slider').slick('setPosition');
          }, 100);
        }
    });

	function bindMenuLogic() {

        // Скидаємо всі попередні обробники
        $('.header-menu-link.dropdown').off('click.mobile');
        $('.header-menu-semi-back').off('click.mobile');

        if ($(window).width() < 700) {

            // Мобільна логіка
            $('.header-menu-link.dropdown').on('click.mobile', function (e) {
                e.preventDefault(); // вимикаємо перехід тільки на мобільному
                const parentItem = $(this).closest('.header-menu-item');
                parentItem.addClass('opened');
            });

            $('.header-menu-semi-back').on('click.mobile', function () {
                const parentItem = $(this).closest('.header-menu-item');
                parentItem.removeClass('opened');
            });
        }
    }

    
    bindMenuLogic();

    
    $(window).on('resize', function () {
        bindMenuLogic();
    });


    $('.main-banner-slider').slick({
          dots: true,
          infinite: true,
          autoplay: true,
          arrows: false,
          autoplaySpeed: 17000,
          speed: 600,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1000,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            }
          ]
        });

    $('.main-banner-slider').on('init', function(event, slick) {
      $(this).slick('slickSetOption', 'autoplaySpeed', 17000, true);
    });

    $('.main-banner-slider').on('afterChange', function(event, slick, currentSlide) {
        if (currentSlide === 0) {
          $(this).slick('slickSetOption', 'autoplaySpeed', 17000, true);
        } else {
          $(this).slick('slickSetOption', 'autoplaySpeed', 3000, true);
        }
      });

    /*$('.goods-slider').slick({
          dots: false,
          infinite: true,
          arrows: true,
          prevArrow: `
          <button class=" prev">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
            </svg>
          </button>`,
        nextArrow: `
          <button class=" next">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
            </svg>
          </button>`,
          slidesToShow: 4,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1000,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                dots: false
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false
              }
            }
          ]
        });*/

    function SliderNoMobile() {
      $('.goods-slider').each(function () {
        var $slider = $(this);

        if ($(window).width() > 1000) {
          if (!$slider.hasClass('slick-initialized')) {
            $slider.slick({
              dots: false,
              infinite: false,
              arrows: true,
              prevArrow: `
              <button class=" prev">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                </svg>
              </button>`,
            nextArrow: `
              <button class=" next">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                </svg>
              </button>`,
              slidesToShow: 4,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1000,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                  }
                }
              ]
            });
          }
        } else {
          if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
            $dots.empty(); 
          }
        }
      });
    }

    SliderNoMobile();

    $(window).on('resize', SliderNoMobile);


    $('.catalog-item-img-slider:not(.slider-off)').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        prevArrow: `
          <button class=" prev">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
            </svg>
          </button>`,
        nextArrow: `
          <button class=" next">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
            </svg>
          </button>`,
          responsive: [
            {
              breakpoint: 600,
              settings: {
                arrows: false
              }
            }
          ]
      });

    $(window).on('load', function () {
      $('.your-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: true
      });
    });


     $('.card-big-slider').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: true,
        infinite: false,
        prevArrow: `
          <button class=" prev">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
            </svg>
          </button>`,
        nextArrow: `
          <button class=" next">
            <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
            </svg>
          </button>`,
        asNavFor: '.card-little-slider',
        responsive: [
            {
              breakpoint: 1600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 1000,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            }
          ]
      });

      $('.card-little-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.card-big-slider',
        dots: false,
        vertical: true,
        infinite: false,
        arrows: true,
        prevArrow: `
          <button class=" prev">
            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8.99996 -7.86808e-07C9.20921 -7.68515e-07 9.41867 0.0814564 9.57842 0.244164L17.7602 8.57746C18.0799 8.90308 18.0799 9.43037 17.7602 9.75578C17.4405 10.0812 16.9228 10.0814 16.6033 9.75578L8.99996 2.01166L1.39661 9.75578C1.0769 10.0814 0.5592 10.0814 0.2397 9.75578C-0.0797996 9.43016 -0.0800036 8.90287 0.2397 8.57745L8.42151 0.244164C8.58126 0.0814563 8.79071 -8.05101e-07 8.99996 -7.86808e-07Z" fill="currentcolor"/>
            </svg>
          </button>`,
        nextArrow: `
          <button class=" next">
            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9.00004 10C8.79079 10 8.58133 9.91854 8.42158 9.75584L0.239778 1.42254C-0.0799262 1.09692 -0.0799261 0.569632 0.239778 0.244218C0.559482 -0.0811974 1.07719 -0.0814056 1.39669 0.244218L9.00004 7.98835L16.6034 0.24422C16.9231 -0.0814029 17.4408 -0.0814028 17.7603 0.244221C18.0798 0.569844 18.08 1.09713 17.7603 1.42255L9.57849 9.75584C9.41874 9.91854 9.20929 10 9.00004 10Z" fill="currentcolor"/>
            </svg>
          </button>`,
        focusOnSelect: true,
        responsive: [
            {
              breakpoint: 1000,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false
              }
            }
          ]
      });


    new Swiper(".look-list-cont", {
      slidesPerView: "auto",
      freeMode: true,
      scrollbar: {
        el: '.swiper-scrollbar',
        draggable: true,
      }
    });

    /*new Swiper('.marquee-swiper', {
      slidesPerView: 'auto',
      loop: true,
      speed: 8000, 
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
      },
      allowTouchMove: false,
    });*/


      const instaSwiper = new Swiper('.instagram-foto-slider', {
        slidesPerView: 'auto',
        loop: true,
        loopAdditionalSlides: 12,

        speed: 10000,
        autoplay: {
          delay: 0,
          disableOnInteraction: false,
        },

        freeMode: {
          enabled: true,
          momentum: false,
        },

        allowTouchMove: false,

        observer: true,
        observeParents: true,

        on: {
          resize(swiper) {
            swiper.loopDestroy();
            swiper.loopCreate();
            swiper.update();
          }
        }
      });


      if(document.getElementById('look-dop-modal'))
      {
          const LookModal = document.getElementById('look-dop-modal')
          LookModal.addEventListener('shown.bs.modal', event => {
              $('.look-dop-slider').slick({
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  arrows: true,
                  infinite: false,
                  prevArrow: `
            <button class=" prev">
              <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
              </svg>
            </button>`,
                  nextArrow: `
            <button class=" next">
              <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
              </svg>
            </button>`

              });

              /*function initLookDopScroll() {
                  const $container = $('.look-dop-item-list');
                  const $leftBtn = $('.look-dop-control-left');
                  const $rightBtn = $('.look-dop-control-right');

                  if (!$container.length) return;

                  // Якщо екран великий, ховаємо кнопки (або додайте no-available, якщо вони теж мають просто сіріти)
                  if ($(window).width() >= 600) {
                      $leftBtn.hide();
                      $rightBtn.hide();
                      return;
                  } else {
                      // Показуємо кнопки назад, якщо користувач повернувся з десктопного розміру на мобільний
                      $leftBtn.show();
                      $rightBtn.show();
                  }

                  const canScroll = $container[0].scrollWidth > $container[0].clientWidth;

                  if (!canScroll) {
                      $leftBtn.addClass("no-available");
                      $rightBtn.addClass("no-available");
                      return;
                  }

                  function updateButtons() {
                      const scrollLeft = $container.scrollLeft();
                      const maxScroll = $container[0].scrollWidth - $container[0].clientWidth;

                      // Додаємо клас, якщо умова НЕ виконується (тобто скролити не можна)
                      $leftBtn.toggleClass("no-available", scrollLeft <= 0);
                      $rightBtn.toggleClass("no-available", scrollLeft >= maxScroll - 1);
                  }

                  updateButtons();

                  $container.off('scroll.lookdop').on('scroll.lookdop', updateButtons);

                  $leftBtn.off('click.lookdop').on('click.lookdop', function () {
                      if ($(this).hasClass('no-available')) return; // Блокуємо клік, якщо кнопка неактивна
                      $container[0].scrollBy({
                          left: -$container[0].clientWidth,
                          behavior: 'smooth'
                          
                      });
                  });

                  $rightBtn.off('click.lookdop').on('click.lookdop', function () {
                      if ($(this).hasClass('no-available')) return; // Блокуємо клік, якщо кнопка неактивна
                      $container[0].scrollBy({
                          left: $container[0].clientWidth,
                          behavior: 'smooth'
                      });
                  });
              }

              initLookDopScroll();

              $(window).on('resize', initLookDopScroll);*/

                

          });
      }



       $('.look-modal').each(function () {

        const $modal = $(this);

        $modal.on('shown.bs.modal', function () {

            const $slider = $modal.find('.look-modal-slider');

            if ($slider.length && !$slider.hasClass('slick-initialized')) {

                $slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    infinite: false,
                    prevArrow: `
                        <button class="prev">
                      <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                      </svg>
                      </button>`,
                    nextArrow: `
                        <button class="next">
                        <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                        </svg>
                        </button>`
                });

                // фікс кривої ширини
                setTimeout(() => {
                    $slider.slick('setPosition');
                }, 100);
            }

        });

    });


      const $slider = $('.search-goods-ex-slider');
      const breakpoint = 1000;

      function handleSlick() {
        const width = $(window).width();

        if (width > breakpoint) {
          if (!$slider.hasClass('slick-initialized')) {
            $slider.slick({
              slidesToShow: 6,
              slidesToScroll: 1,
              infinite: false,
              dots: false,
              arrows: true,
              prevArrow: `
              <button class=" prev">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                </svg>
              </button>`,
            nextArrow: `
              <button class=" next">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                </svg>
              </button>`,
                responsive: [
                {
                  breakpoint: 1600,
                  settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    dots: false
                  }
                },
                {
                  breakpoint: 1300,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    dots: false
                  }
                }
          ]
            });
          }
        } else {
          if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
          }
        }
      }

      handleSlick();

      $(window).on('resize', handleSlick);

      $('.catalog-goods-views-slider').slick({
              slidesToShow: 6,
              slidesToScroll: 1,
              infinite: false,
              dots: false,
              arrows: true,
              prevArrow: `
              <button class=" prev">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.363506 14.7L12.8632 27.1998C13.3122 27.7241 14.1013 27.7852 14.6257 27.3361C15.15 26.8871 15.2111 26.098 14.762 25.5736C14.7201 25.5248 14.6745 25.4791 14.6257 25.4373L4.26339 15.0625L53.7501 15.0625C54.4403 15.0625 55 14.5028 55 13.8124C55 13.1221 54.4403 12.5625 53.7501 12.5625L4.26339 12.5625L14.6257 2.20024C15.15 1.75122 15.2111 0.962116 14.762 0.437799C14.3129 -0.0865173 13.5239 -0.147638 12.9995 0.301485C12.9507 0.343378 12.905 0.388924 12.8632 0.437799L0.3634 12.9376C-0.121174 13.425 -0.12117 14.2124 0.363506 14.7Z" fill="currentcolor"/>
                </svg>
              </button>`,
            nextArrow: `
              <button class=" next">
                <svg width="55" height="28" viewBox="0 0 55 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M54.6365 12.9368L42.1368 0.436946C41.6878 -0.087371 40.8987 -0.148493 40.3743 0.30063C39.85 0.749646 39.7889 1.53875 40.238 2.06307C40.2799 2.11195 40.3255 2.1576 40.3743 2.19939L50.7366 12.5742H1.24994C0.559658 12.5742 0 13.1339 0 13.8243C0 14.5147 0.559658 15.0742 1.24994 15.0742H50.7366L40.3743 25.4365C39.85 25.8855 39.7889 26.6746 40.238 27.1989C40.6871 27.7232 41.4761 27.7844 42.0005 27.3352C42.0493 27.2933 42.095 27.2478 42.1368 27.1989L54.6366 14.6991C55.1212 14.2117 55.1212 13.4243 54.6365 12.9368Z" fill="currentcolor"/>
                </svg>
              </button>`,
                responsive: [
                {
                  breakpoint: 1600,
                  settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    dots: false
                  }
                },
                {
                  breakpoint: 1300,
                  settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    dots: false
                  }
                },
                {
                  breakpoint: 1000,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false
                  }
                }
          ]
            });


      function mobileOnlySlider() {
      $('.sama-sobi-loyalty-cont').each(function () {
        var $wrap = $(this);
        var $slider = $wrap.find('.sama-sobi-loyalty-block');
        var $dots = $wrap.find('.slider-dots');

        if ($(window).width() < 600) {
          if (!$slider.hasClass('slick-initialized')) {
            $slider.slick({
              slidesToShow: 1,
              arrows: true,
              dots: true,
              infinite:false,
              appendDots: $dots,
              prevArrow: $wrap.find('.slider-prev'),
              nextArrow: $wrap.find('.slider-next'),

              customPaging: function (slider, i) {
                return `<button type="button">
                          ${i + 1}/${slider.slideCount}
                        </button>`;
              }
            });
          }
        } else {
          if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
            $dots.empty(); // чистимо доти після unslick
          }
        }
      });
    }

    mobileOnlySlider();

    $(window).on('resize', mobileOnlySlider);



    $('.seo_block_toggler').on('click', function() {
      const $box = $('.seo_block .seo_text');
      const startHeight = 165; 
      
      const fullHeight = $box[0].scrollHeight;

      if ($box.height() === startHeight) {
        $('.seo_block').addClass("block-opened");
        $box.stop().animate({ height: fullHeight }, 400, function() {
          $box.css('height', 'auto'); 
        });
      } else {
        $('.seo_block').removeClass("block-opened");
        $box.css('height', $box.height()); 
        
        $box.stop().animate({ height: startHeight }, 400);
      }
    });


              const $track = $('.main-advantages-block'); // Переконайся, що клас вказано вірно
              
              if (!$track.length) return; // Захист, якщо елемента немає на сторінці

              // Зберігаємо початковий чистий HTML
              const originalHTML = $track.html();
              
              let isCloned = false;
              let singleWidth = 0;

              function updateState() {
                // window.innerWidth точно збігається з CSS @media (max-width: 999px)
                const isMobile = window.innerWidth < 1000;

                if (isMobile) {
                  // Якщо менше 1000px і клон ще не створено
                  if (!isCloned) {
                    $track.append(originalHTML);
                    isCloned = true;
                  }
                  // Рахуємо ширину одного блоку (загальна ширина / 2)
                  singleWidth = $track.outerWidth() / 2;
                } else {
                  // Якщо 1000px і більше — прибираємо клон і скидаємо трансформацію
                  if (isCloned) {
                    $track.html(originalHTML);
                    isCloned = false;
                  }
                  $track.css('transform', '');
                }
              }

              // Запускаємо перевірку одразу після побудови DOM
              updateState();

              // Перераховуємо після повного завантаження стилів і картинок (для точної ширини)
              $(window).on('load resize', function() {
                updateState();
              });

              // Логіка скролу
              $(window).on('scroll', function() {
                if (window.innerWidth < 1000 && singleWidth > 0) {
                  let scrollTop = $(window).scrollTop();
                  
                  // Коефіцієнт 0.5 визначає швидкість руху
                  let moveX = (scrollTop * 0.5) % singleWidth;

                  $track.css('transform', 'translateX(-' + moveX + 'px)');
                }
              });

  
});