function load_mode_scroll(n) {
    console.log("ajax_load_btn is viewed");
    var t = n, i = t.closest(".container").find(".module-pagination .flex-direction-nav .flex-next").attr("href"),
        u = t.find(".more_text_ajax"), r = t.closest(".bottom_nav"), f = r.hasClass("mobile_slider"),
        e = t.closest(".animate-load-state").length;
    loadMore(i, !1)
}

function readyDOM(n) {
    document.readyState !== "loading" ? n() : document.addEventListener("DOMContentLoaded", n)
}

function openYandexMap(n) {
    var u = $(n), t, i, f, r;
    u.hasClass("closer") || (t = u.parents(".bx-yandex-view-layout"), i = t.find(".bx-yandex-map").attr("id"), window.openedYandexMapFrame = i, f = $('<div data-mapId="' + i + '"><\/div>'), $("div[data-mapId=" + i + "]").length || t.after(f), r = $('<div class="yandex-map__frame"><\/div>'), $("body .wrapper1").append(r), t.appendTo(r), t.find(".yandex-map__mobile-opener").addClass("closer"), window.map.container.fitToViewport())
}

function closeYandexMap() {
    var n = $(".yandex-map__frame"), t, i;
    n.length && (t = n.find(".bx-yandex-view-layout"), i = $("div[data-mapId=" + window.openedYandexMapFrame + "]"), t.appendTo(i), n.remove(), t.find(".yandex-map__mobile-opener").removeClass("closer"), window.map && window.map.container.fitToViewport())
}

function throttle(n, t) {
    let r, u, i;
    const f = function () {
        if (r) {
            u = this;
            i = arguments;
            return
        }
        r = !0;
        n.apply(this, arguments);
        setTimeout(function () {
            r = !1;
            i && (f.apply(u, i), u = i = null)
        }, t)
    };
    return f
}

function debounce(n, t) {
    return function (i) {
        var r = this.lastCall;
        this.lastCall = Date.now();
        r && this.lastCall - r <= t && clearTimeout(this.lastCallTimer);
        this.lastCallTimer = setTimeout(function () {
            n(i)
        }, t)
    }
}

function extendDepthObject(n, t) {
    var r = Object.assign({}, n);
    for (var i in t) r[i] = typeof t[i] == "object" ? extendDepthObject(r[i], t[i]) : t[i];
    return r
}

function touchMenu(n) {
    isMobile ? $(n).length && $(n).each(function () {
        var n = $(this);
        n.on("touchend", function (n) {
            var t = $(n.target).closest(".menu-item"), i;
            $(".menu.topest > li").removeClass("hover");
            $(".menu_top_block.catalog_block li").removeClass("hover");
            $(".bx-breadcrumb-item.drop").removeClass("hover");
            t.find(".dropdown-menu").length && !t.hasClass("hover") ? (n.preventDefault(), n.stopPropagation(), t.siblings().removeClass("hover"), t.addClass("hover"), $(".menu-row .dropdown-menu").css({
                display: "none",
                opacity: 0
            }), t.hasClass("menu-item") && t.closest(".dropdown-menu").css({
                display: "block",
                opacity: 1
            }), t.find("> .wrap > .dropdown-menu") ? t.find("> .wrap > .dropdown-menu").css({
                display: "block",
                opacity: 1
            }) : t.find("> .dropdown-menu") && t.find("> .dropdown-menu").css({
                display: "block",
                opacity: 1
            }), CheckTopVisibleMenu()) : (i = $(n.target).attr("href") ? $(n.target).attr("href") : $(n.target).closest("a").attr("href"), i && i !== "undefined" && (location.href = i))
        })
    }) : $(n).off()
}

function touchTopMenu(n) {
    isMobile ? $(n).length && $(n).each(function () {
        var n = $(this);
        n.on("touchend", function (n) {
            var t = $(n.target).closest("li"), i;
            $(".menu-item").removeClass("hover");
            $(".menu_top_block.catalog_block li").removeClass("hover");
            $(".bx-breadcrumb-item.drop").removeClass("hover");
            t.hasClass("more") && !t.hasClass("hover") ? (n.preventDefault(), n.stopPropagation(), t.siblings().removeClass("hover"), t.addClass("hover"), $(".menu.topest").css({overflow: "visible"})) : (i = $(n.target).attr("href") ? $(n.target).attr("href") : $(n.target).closest("a").attr("href"), i && i !== "undefined" && (location.href = i))
        })
    }) : $(n).off()
}

function touchLeftMenu(n) {
    isMobile ? $(n).length && $(n).each(function () {
        var n = $(this);
        n.on("touchend", function (n) {
            var t = $(n.target).closest("li"), i;
            $(".menu-item").removeClass("hover");
            $(".bx-breadcrumb-item.drop").removeClass("hover");
            $(".menu.topest > li").removeClass("hover");
            t.hasClass("has-child") && !t.hasClass("hover") ? (n.preventDefault(), n.stopPropagation(), t.siblings().removeClass("hover"), t.addClass("hover")) : (i = $(n.target).attr("href") ? $(n.target).attr("href") : $(n.target).closest("a").attr("href"), i && i !== "undefined" && (location.href = i))
        })
    }) : $(n).off()
}

function touchBreadcrumbs(n) {
    isMobile ? $(n).length && $(n).each(function () {
        var n = $(this);
        n.on("touchend", function (n) {
            var t = $(n.target).closest(".bx-breadcrumb-item"), i;
            $(".menu-item").removeClass("hover");
            $(".menu.topest > li").removeClass("hover");
            $(".menu_top_block.catalog_block li").removeClass("hover");
            t.hasClass("hover") ? (t.removeClass("hover"), i = $(n.target).attr("href") ? $(n.target).attr("href") : $(n.target).closest("a").attr("href"), i && i !== "undefined" && (location.href = i)) : (n.preventDefault(), n.stopPropagation(), t.siblings().removeClass("hover"), t.addClass("hover"))
        })
    }) : $(n).off()
}

function touchItemBlock() {
}

function touchBasket(n) {
    if (arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N") if ($(window).outerWidth() > 600) $(document).find(n).on("touchend", function (n) {
        $(this).parent().find(".basket_popup_wrapp").length && !$(this).hasClass("hover") && (n.preventDefault(), n.stopPropagation(), $(this).addClass("hover"), $(this).parent().find(".basket_popup_wrapp").slideDown())
    }); else $(n).off()
}

function showTotalSummItem(n) {
    if (arAsproOptions.THEME.SHOW_TOTAL_SUMM_TYPE == "ALWAYS" && arAsproOptions.THEME.SHOW_TOTAL_SUMM == "Y") {
        var t = "body ";
        typeof n == "string" && n == "Y" && (t = ".popup ");
        $(t + ".counter_wrapp .counter_block input.text").each(function () {
            var n = $(this), t;
            n.data("product") ? (t = n.data("product"), typeof window[t] == "object" ? window[t].setPriceAction("Y") : setPriceItem(n.closest(".main_item_wrapper"), n.val())) : setPriceItem(n.closest(".main_item_wrapper"), n.val())
        })
    }
}

function initFull() {
    touchItemBlock(".catalog_item a");
    InitOrderCustom();
    showTotalSummItem();
    basketActions();
    orderActions();
    checkMobileRegion()
}

function fileInputInit(n) {
    $("input[type=file]").uniform({fileButtonHtml: BX.message("JS_FILE_BUTTON_NAME"), fileDefaultHtml: n});
    $(document).on("change", "input[type=file]", function () {
        $(this).val() ? $(this).closest(".uploader").addClass("files_add") : $(this).closest(".uploader").removeClass("files_add")
    });
    $(".form .add_file").on("click", function () {
        var t = $(this).closest(".input").find("input[type=file]").length + 1;
        $(this).closest(".form-group").find(".input").append('<input type="file" id="POPUP_FILE" name="FILE_n' + t + '"   class="inputfile" value="" />');
        $("input[type=file]").uniform({fileButtonHtml: BX.message("JS_FILE_BUTTON_NAME"), fileDefaultHtml: n})
    });
    $(".form .add_file").on("click", function () {
        var t = $(this).closest(".input").find("input[type=file]").length + 1;
        $(this).closest(".form-group").find(".input").append('<input type="file" id="POPUP_FILE" name="FILE_n' + t + '"   class="inputfile" value="" />');
        $("input[type=file]").uniform({fileButtonHtml: BX.message("JS_FILE_BUTTON_NAME"), fileDefaultHtml: n})
    })
}

function declOfNum(n, t) {
    return n + " " + t[n % 100 > 4 && n % 100 < 20 ? 2 : [2, 0, 1, 1, 1, 2][Math.min(n % 10, 5)]]
}

function array_values_js(n) {
    var t = [], i = 0;
    for (key in n) t[i] = n[key], i++;
    return t
}

function initFavorite() {
    $.ajax({
        url: "/ajax/favorite.php", type: "post", dataType: "json", data: {}, success: function (n) {
            console.log(n);
            $cnt = 0;
            for (i in n.list) console.log(n.list[i]), $(".catalog-item-favorite a[data-id=" + n.list[i] + "]").addClass("active"), $cnt++;
            $(".favcounter .counter").text($cnt);
            $cnt ? $(".favcounter").addClass("empty") : $(".favcounter").removeClass("empty")
        }
    })
}

var basketTimeoutSlide, resizeEventTimer, clicked_tab, arAsproOptions, trimPrice, markProductRemoveBasket,
    markProductAddBasket, markProductDelay, markProductSubscribe, updateBottomIconsPanel, basketFly, basketTop,
    lastHash, hash, onLoadjqm, onHidejqm, jqmEd, reloadTopBasket, initCountdown, initCountdownTime,
    checkVerticalMobileFilter, oneClickBuy, oneClickBuyBasket, effects, effectName, arBasketAsproCounters, setPriceItem,
    getCurrentPrice, initAnimateLoad, showBasketShareBtn, showBasketHeadingBtn, isFrameDataReceived, timerResize,
    ignoreResize, onCaptchaVerifyinvisible, onCaptchaVerifynormal;
console.log("start main.js");
clicked_tab = 0;
typeof arAsproOptions == "undefined" && (arAsproOptions = {SITE_DIR: "/"}, $("body").data("site") !== undefined && (arAsproOptions.SITE_DIR = $("body").data("site")));
InitLazyLoad = function () {
};
$(document).on("change", ".uploader input[type=file]", function () {
    $(this).next().length && $(this).next().hasClass("resetfile") || $('<span class="resetfile"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"><path d="M1345.19,376.484l4.66,4.659a0.492,0.492,0,0,1,0,.707,0.5,0.5,0,0,1-.71,0l-4.66-4.659-4.65,4.659a0.5,0.5,0,0,1-.71,0,0.492,0.492,0,0,1,0-.707l4.66-4.659-4.66-4.659a0.492,0.492,0,0,1,0-.707,0.5,0.5,0,0,1,.71,0l4.65,4.659,4.66-4.659a0.5,0.5,0,0,1,.71,0,0.492,0.492,0,0,1,0,.707Z" transform="translate(-1339 -371)"/><\/svg><\/span>').insertAfter($(this))
});
$(document).on("click", ".uploader.files_add input[type=file] + .resetfile", function () {
    var n = $(this).prev();
    n.val("");
    $.uniform.update(n);
    $(this).remove()
});
$(document).on("click", ".top_block h3", function () {
    if (window.matchMedia("(max-width: 550px)").matches) {
        var t = $(this), n = t.siblings("a");
        n.length && n[0].click()
    }
});
$(document).on("click", ".bx-yandex-view-layout .yandex-map__mobile-opener", function () {
    $(this).hasClass("closer") ? closeYandexMap() : openYandexMap(this)
});
$(document).on("click", ".header-menu-close", function () {
    $(".header-menu-block ").removeClass("opened")
});
$(document).on("click", ".header-menu-burger", function () {
    $(this).parent().toggleClass("opened")
});
$(document).on("click", ".header-city-select-icon", function () {
    $(this).parent().toggleClass("opened")
});
$(document).on("click", ".header-search-icon", function () {
    $(".top-btn.inline-search-show").trigger("click")
});
$(document).on("click", ".header-city-select-active", function () {
    $(this).parent().toggleClass("opened")
});
$(document).on("click", ".header-menu-mobile-item-title", function () {
    $(this).parent().toggleClass("opened")
});
$(document).on("click", ".catalog-filters-mobile-opener", function () {
    $(".catalog-filters").toggleClass("opened")
});
$(document).on("click", ".catalog-filters-close", function () {
    $(".catalog-filters").toggleClass("opened")
});
$(document).on("click", ".order-list-toggler-bg", function () {
    $(this).parent().toggleClass("opened");
    $(this).parent().hasClass("opened") ? $(".order-list-mob-bg").slideDown() : $(".order-list-mob-bg").slideUp()
});
$(document).mouseup(function (n) {
    var t = $(".header-city-select-form");
    t.has(n.target).length === 0 && $(".header-city-select-form").removeClass("opened");
    t = $(".card-info-size-cont");
    t.has(n.target).length === 0 && $(".card-info-size-cont").removeClass("opened");
    t = $(".header-menu-block");
    t.has(n.target).length === 0 && $(".header-menu-block").removeClass("opened")
});
$(document).on("click", ".flex-control-nav.flex-control-js-click li a:not(.flex-active)", function (n) {
    var t = $(this), u = t.data("index") ? t.data("index") : t.closest("li").index(), i = "",
        f = t.closest(".items").find("> .item"), r = t.closest(".items").find(".item.active"),
        e = t.closest(".flex-control-nav").find(".flex-active");
    r.fadeOut(function () {
        r.removeClass("active");
        i = f.eq(u);
        i.length && i.fadeIn(function () {
            i.addClass("active")
        });
        t.addClass("flex-active");
        e.removeClass("flex-active")
    });
    n.preventDefault()
});
$(document).on("mouseenter", "#headerfixed .menu-item.wide_menu", function () {
    var n = $(this);
    setTimeout(function () {
        var t = n.find(".wrap > .dropdown-menu"), f = t[0].getBoundingClientRect(),
            r = document.getElementById("headerfixed").getBoundingClientRect(),
            u = document.documentElement.clientHeight, i;
        f.height + r.height > u ? (i = u - r.height, t.css({"max-height": i}), t.find(".menu-navigation").css({"max-height": i}), t.find(".customScrollbar").css({"max-height": i}), t.find(".menu-wrapper.menu-type-4 > li").css({"min-height": "auto"})) : (t.css({"max-height": ""}), t.find(".menu-navigation").css({"max-height": ""}), t.find(".customScrollbar").css({"max-height": ""}), t.find(".menu-wrapper.menu-type-4 > li").css({"min-height": ""}))
    }, 300)
});
if (BX.addCustomEvent("onAjaxSuccess", function (n) {
    if (typeof n == "object" && n !== null && typeof n.BASKET_REFRESHED !== undefined && n.BASKET_REFRESHED === !0) {
        var t = n.BASKET_DATA.BASKET_ITEMS_COUNT;
        reloadBasketCounters(t)
    }
}), funcDefined("parseUrlQuery") || (parseUrlQuery = function () {
    var r = {}, t, n, i;
    if (location.search) for (t = location.search.substr(1).split("&"), n = 0; n < t.length; n++) i = t[n].split("="), r[i[0]] = i[1];
    return r
}), !funcDefined("setLocationSKU")) {
    function n(n, t) {
        var f;
        t === undefined && (t = "oid");
        var r = parseUrlQuery(), e = 0, o = "", i = "", u = "";
        r[t] = n;
        for (f in r) parseInt(e) > 0 && (o = "&"), i = i + o + f + "=" + r[f], e++;
        i && (u = location.pathname + "?" + i + location.hash);
        try {
            history.replaceState(null, null, u);
            return
        } catch (s) {
        }
        location.hash = "#" + u.substr(1)
    }
}
if (funcDefined("ShowOverlay") || (ShowOverlay = function () {
    $('<div class="jqmOverlay waiting"><\/div>').appendTo("body")
}), funcDefined("HideOverlay") || (HideOverlay = function () {
    $(".jqmOverlay").detach()
}), funcDefined("trimPrice") || (trimPrice = function (n) {
    return n = n.split(" ").join(""), n.split("&nbsp;").join("")
}), funcDefined("pauseYmObserver") || (pauseYmObserver = function () {
    typeof MutationObserver == "function" && typeof MutationObserver.observers == "object" && typeof MutationObserver.observers.ym == "object" && (typeof pauseYmObserver.cnt == "undefined" && (pauseYmObserver.cnt = 0), ++pauseYmObserver.cnt, MutationObserver.observers.ym.paused || MutationObserver.observers.ym.pause())
}), funcDefined("resumeYmObserver") || (resumeYmObserver = function () {
    typeof MutationObserver == "function" && typeof MutationObserver.observers == "object" && typeof MutationObserver.observers.ym == "object" && (typeof pauseYmObserver.cnt == "undefined" && (pauseYmObserver.cnt = 1), pauseYmObserver.cnt -= pauseYmObserver.cnt > 0 ? 1 : 0, !pauseYmObserver.cnt && MutationObserver.observers.ym.paused && MutationObserver.observers.ym.resume())
}), funcDefined("markProductRemoveBasket") || (markProductRemoveBasket = function (n) {
    $(".in-cart[data-item=" + n + "]").hide();
    $(".to-cart[data-item=" + n + "]").show();
    $(".to-cart[data-item=" + n + "]").closest(".button_block").removeClass("wide");
    $(".to-cart[data-item=" + n + "]").closest(".counter_wrapp").find(".counter_block").show();
    $(".counter_block[data-item=" + n + "]").closest(".counter_block_inner").show();
    $(".counter_block[data-item=" + n + "]").show();
    $(".in-subscribe[data-item=" + n + "]").hide();
    $(".to-subscribe[data-item=" + n + "]").show();
    $(".wish_item[data-item=" + n + "] .value:not(.added)").show();
    $(".wish_item[data-item=" + n + "] .value.added").hide();
    $(".wish_item.to[data-item=" + n + "]").show();
    $(".wish_item.in[data-item=" + n + "]").hide();
    $(".banner_buttons.with_actions .wraps_buttons[data-id=" + n + "] .basket_item_add").removeClass("added");
    $(".banner_buttons.with_actions .wraps_buttons[data-id=" + n + "] .wish_item_add").removeClass("added");
    $("#headerfixed .but-cell .type_block").length && ($("#headerfixed .but-cell .type_block span").text(BX.message("MORE_INFO_SKU")), $("#headerfixed .but-cell .type_block .svg-inline-fw").remove())
}), funcDefined("markProductAddBasket") || (markProductAddBasket = function (n) {
    $(".to-cart[data-item=" + n + "]").hide();
    $(".to-cart[data-item=" + n + "]").closest(".counter_wrapp").find(".counter_block_inner").hide();
    $(".to-cart[data-item=" + n + "]").closest(".counter_wrapp").find(".counter_block").hide();
    $(".to-cart[data-item=" + n + "]").closest(".button_block").addClass("wide");
    $(".in-cart[data-item=" + n + "]").show();
    $(".wish_item[data-item=" + n + "] .value:not(.added)").show();
    $(".wish_item[data-item=" + n + "] .value.added").hide();
    $(".wish_item.to[data-item=" + n + "]").show();
    $(".wish_item.in[data-item=" + n + "]").hide();
    $(".banner_buttons.with_actions .wraps_buttons[data-id=" + n + "] .basket_item_add").addClass("added");
    $("#headerfixed .but-cell .type_block").length && $("#headerfixed .but-cell .type_block").html($(".in-cart[data-item=" + n + "]").html())
}), funcDefined("markProductDelay") || (markProductDelay = function (n) {
    $(".in-cart[data-item=" + n + "]").hide();
    $(".to-cart[data-item=" + n + "]").show();
    $(".to-cart[data-item=" + n + "]").closest(".counter_wrapp").find(".counter_block_inner").show();
    $(".to-cart[data-item=" + n + "]").closest(".counter_wrapp").find(".counter_block").show();
    $(".to-cart[data-item=" + n + "]").closest(".button_block").removeClass("wide");
    $(".wish_item[data-item=" + n + "] .value:not(.added)").hide();
    $(".wish_item[data-item=" + n + "] .value.added").css("display", "block");
    $(".wish_item.to[data-item=" + n + "]").hide();
    $(".wish_item.in[data-item=" + n + "]").show();
    $(".banner_buttons.with_actions .wraps_buttons[data-id=" + n + "] .wish_item_add").addClass("added");
    $("#headerfixed .but-cell .type_block").length && ($("#headerfixed .but-cell .type_block span").text(BX.message("MORE_INFO_SKU")), $("#headerfixed .but-cell .type_block .svg-inline-fw").remove())
}), funcDefined("markProductSubscribe") || (markProductSubscribe = function (n) {
    $(".to-subscribe[data-item=" + n + "]").hide();
    $(".in-subscribe[data-item=" + n + "]").css("display", "block")
}), funcDefined("updateBottomIconsPanel") || (updateBottomIconsPanel = function (n) {
    if (n && $(".bottom-icons-panel").length) {
        var t = "READY" in n || "BASKET_COUNT" in n,
            i = "READY" in n ? n.READY.COUNT : "BASKET_COUNT" in n ? n.BASKET_COUNT : 0,
            f = "READY" in n ? n.READY.TITLE : "BASKET_SUMM_TITLE" in n ? n.BASKET_SUMM_TITLE : "",
            e = "DELAY" in n || "DELAY_COUNT" in n,
            r = "DELAY" in n ? n.DELAY.COUNT : "DELAY_COUNT" in n ? n.DELAY_COUNT : 0,
            o = "DELAY" in n ? n.DELAY.TITLE : "DELAY_SUMM_TITLE" in n ? n.DELAY_SUMM_TITLE : "", s = "COMPARE" in n,
            u = "COMPARE" in n ? typeof n.COMPARE == "object" && "COUNT" in n.COMPARE ? n.COMPARE.COUNT : Object.keys(n.COMPARE).length : 0;
        t && (+i > 0 ? $(".bottom-icons-panel .basket.counter-state").removeClass("counter-state--empty") : $(".bottom-icons-panel .basket.counter-state").addClass("counter-state--empty"), $(".bottom-icons-panel .basket .counter-state__content-item-value").text(i), $(".bottom-icons-panel .basket").closest(".bottom-icons-panel__content-link").attr("title", $("<div/>").html(f).text()));
        e && t && (+r > 0 ? $(".bottom-icons-panel .delay.counter-state").removeClass("counter-state--empty") : $(".bottom-icons-panel .delay.counter-state").addClass("counter-state--empty"), $(".bottom-icons-panel .delay .counter-state__content-item-value").text(r), $(".bottom-icons-panel .delay").closest(".bottom-icons-panel__content-link").attr("title", $("<div/>").html(o).text()));
        s && (u > 0 ? $(".bottom-icons-panel .compare.counter-state").removeClass("counter-state--empty") : $(".bottom-icons-panel .compare.counter-state").addClass("counter-state--empty"), $(".bottom-icons-panel .compare .counter-state__content-item-value").text(u))
    }
}), funcDefined("basketFly") || (basketFly = function (n, t) {
    typeof obMaxPredictions == "object" && obMaxPredictions.updateAll();
    $.post(arAsproOptions.SITE_DIR + "ajax/basket_fly.php", "PARAMS=" + $("#basket_form").find("input#fly_basket_params").val(), $.proxy(function (i) {
        var r = $(".opener .basket_count").hasClass("small"), u = $(i).find(".basket_count").find(".items div").text();
        $("#basket_line .basket_fly").addClass("loaded").html(i);
        n == "refresh" && $("li[data-type=AnDelCanBuy]").trigger("click");
        typeof t == "undefined" || $("#basket_line .basket_fly").hasClass("loading") ? window.matchMedia("(min-width: 769px)").matches && (n == "open" ? r ? arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N" && $(".opener .basket_count").click() : ($(".opener .basket_count").removeClass("small"), $('.tabs_content.basket li[item-section="AnDelCanBuy"]').addClass("cur"), $('#basket_line ul.tabs li[item-section="AnDelCanBuy"]').addClass("cur"), $("#basket_line .basket_fly .opener > div:eq(0)").addClass("cur")) : n == "wish" ? r ? arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N" && $(".opener .wish_count").click() : ($(".opener .wish_count").removeClass("small"), $('.tabs_content.basket li[item-section="DelDelCanBuy"]').addClass("cur"), $('#basket_line ul.tabs li[item-section="DelDelCanBuy"]').addClass("cur")) : arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N" && $(".opener .basket_count").click()) : t === "SHOW" && window.matchMedia("(min-width: 769px)").matches && ($(".opener .basket_count").removeClass("small"), $('.tabs_content.basket li[item-section="AnDelCanBuy"]').addClass("cur"), $('#basket_line ul.tabs li[item-section="AnDelCanBuy"]').addClass("cur"), $("#basket_line .basket_fly .opener > div:eq(0)").addClass("cur"))
    }))
}), funcDefined("basketTop") || (basketTop = function (n, t) {
    if (n == "reload" && $(".basket_hover_block:hover").length && (t = $(".basket_hover_block:hover")), n == "open" && arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N" && (t = $("#headerfixed").hasClass("fixed") ? $("#headerfixed .basket_hover_block") : $(".top_basket .basket_hover_block")), t === undefined) return console.log("Undefined hoverBlock"), console.trace(), !1;
    if (n == "close" && t.length) return t.css({opacity: "", visibility: ""}), !0;
    t.removeClass("loaded");
    var u = t.find("div").length ? "false" : "true", i = $("#basket_form").find("input#fly_basket_params").val(),
        r = {firstTime: u};
    i !== undefined && (r.PARAMS = i);
    $.post(arAsproOptions.SITE_DIR + "ajax/showBasketHover.php", r, $.proxy(function (i) {
        var r = BX.processHTML(i);
        $("#headerfixed .basket_hover_block, .top_basket .basket_hover_block").html(r.HTML);
        BX.ajax.processScripts(r.SCRIPT);
        window.matchMedia("(min-width: 992px)").matches && (t.addClass("loaded"), n == "open" && arAsproOptions.THEME.SHOW_BASKET_ONADDTOCART !== "N" && (t = $("#headerfixed").hasClass("fixed") ? $("#headerfixed .basket_hover_block") : $(".top_basket .basket_hover_block"), t.css({
            opacity: "1",
            visibility: "visible"
        }), setTimeout(function () {
            t.css({opacity: "", visibility: ""})
        }, 2e3)))
    }))
}), lastHash = location.hash, "onhashchange" in window) {
    $(window).bind("hashchange", function () {
        var t = location.hash, r, i;
        t == "#delayed" ? $("#basket_toolbar_button_delayed").length && $("#basket_toolbar_button_delayed").trigger("click") : $("#basket_toolbar_button").length && $("#basket_toolbar_button").trigger("click");
        r = n(t, lastHash);
        lastHash = t;
        lastHash && ("scrollRestoration" in history && (history.scrollRestoration = "manual"), $('.ordered-block .tabs .nav a[href="' + lastHash + '"]').length && ($('.ordered-block .tabs .nav a[href="' + lastHash + '"]').trigger("click"), i = $(".ordered-block .tabs").offset(), $("html, body").animate({scrollTop: i.top - 90}, 400)))
    });

    function n(n, t) {
        for (var i = 0, r = Math.min(n.length, t.length); i < r; i++) if (n.charAt(0) != t.charAt(0)) break;
        for (n = n.substr(i), t = t.substr(i), i = 0, r = Math.min(n.length, t.length); i < r; i++) if (n.substr(-1) != t.substr(-1)) break;
        return [n, t]
    }
}
$(document).on("click", "#basket_toolbar_button", function () {
    lastHash && (location.hash = "cart")
});
$(document).on("click", "#basket_toolbar_button_delayed", function () {
    lastHash && (location.hash = "delayed")
});
location.hash && (hash = location.hash);
$(document).on("click", "#basket_line .basket_fly .opener > div.clicked", function () {
    function t(n) {
        $("#basket_line .basket_fly .tabs li").removeClass("cur");
        $("#basket_line .basket_fly .tabs_content li").removeClass("cur");
        $(n).is(".wish_count.empty") ? ($("#basket_line .basket_fly .tabs li").first().addClass("cur").siblings().removeClass("cur"), $("#basket_line .basket_fly .tabs_content li").first().addClass("cur").siblings().removeClass("cur")) : ($("#basket_line .basket_fly .tabs_content li[item-section=" + $(n).data("type") + "]").addClass("cur"), $("#basket_line .basket_fly .tabs li:eq(" + $(n).index() + ")").addClass("cur"));
        $("#basket_line .basket_fly .opener > div.clicked").removeClass("small");
        $("#basket_line .basket_fly .opener > div").siblings().removeClass("cur");
        $("#basket_line .basket_fly .opener > div:eq(" + $(n).index() + ")").addClass("cur")
    }

    if (!arAsproOptions.PAGES.BASKET_PAGE && window.matchMedia("(min-width: 769px)").matches) {
        var n = this;
        $(n).siblings().removeClass("cur");
        $(n).addClass("cur");
        parseInt($("#basket_line .basket_fly").css("right")) < 0 ? ($("#basket_line .basket_fly").stop().addClass("loading").animate({right: "0"}, 333, function () {
            $(n).closest(".basket_fly.loaded").length ? t(n) : $.ajax({
                url: arAsproOptions.SITE_DIR + "ajax/basket_fly.php",
                type: "post",
                success: function (i) {
                    $("#basket_line .basket_fly").removeClass("loading").addClass("loaded").html(i);
                    t(n)
                }
            })
        }), $("#basket_line .basket_fly").addClass("swiped")) : $(this).is(".wish_count:not(.empty)") && !$("#basket_line .basket_fly .basket_sort ul.tabs li.cur").is("[item-section=DelDelCanBuy]") ? ($("#basket_line .basket_fly .tabs li").removeClass("cur"), $("#basket_line .basket_fly .tabs_content li").removeClass("cur"), $("#basket_line .basket_fly .tabs_content li[item-section=" + $(this).data("type") + "]").addClass("cur"), $("#basket_line  .basket_fly .tabs li:eq(" + $(this).index() + ")").first().addClass("cur")) : $(this).is(".basket_count") && $("#basket_line .basket_fly .basket_sort ul.tabs li.cur").length && !$("#basket_line .basket_fly .basket_sort ul.tabs li.cur").is("[item-section=AnDelCanBuy]") ? ($("#basket_line .basket_fly .tabs li").removeClass("cur"), $("#basket_line .basket_fly .tabs_content li").removeClass("cur"), $("#basket_line  .basket_fly .tabs_content li:eq(" + $(this).index() + ")").addClass("cur"), $("#basket_line  .basket_fly .tabs li:eq(" + $(this).index() + ")").first().addClass("cur")) : ($("#basket_line .basket_fly").stop().animate({right: -$("#basket_line .basket_fly").outerWidth()}, 150), $("#basket_line .basket_fly .opener > div.clicked").addClass("small"), $("#basket_line .basket_fly").removeClass("swiped"), $("#basket_line .basket_fly .opener > div").removeClass("cur"))
    }
});
if (!funcDefined("clearViewedProduct")) {
    function n() {
        try {
            var t = arAsproOptions.SITE_ID, n = "MAX_VIEWED_ITEMS_" + t;
            typeof BX.localStorage != "undefined" && BX.localStorage.set(n, {}, 0);
            $.removeCookie(n, {path: "/", expires: 30})
        } catch (i) {
            console.error(i)
        }
    }
}
if (!funcDefined("setViewedProduct")) {
    function n(n, t) {
        var s, r, o;
        try {
            s = $.cookie.json;
            $.cookie.json = !0;
            var h = arAsproOptions.SITE_ID, f = "MAX_VIEWED_ITEMS_" + h;
            if (typeof BX.localStorage != "undefined" && typeof n != "undefined" && typeof t != "undefined") {
                var e = typeof t.PRODUCT_ID != "undefined" ? t.PRODUCT_ID : n,
                    i = BX.localStorage.get(f) ? BX.localStorage.get(f) : {}, u = $.cookie(f) ? $.cookie(f) : {}, c = 0;
                for (r in i) i[r].IS_LAST = !1, typeof u[r] == "undefined" && delete i[r];
                for (r in u) typeof i[r] == "undefined" && delete u[r];
                for (r in u) c++;
                typeof i[e] != "undefined" && i[e].ID != n && (delete i[e], delete u[e]);
                o = (new Date).getTime();
                t.ID = n;
                t.ACTIVE_FROM = o;
                t.IS_LAST = !0;
                i[e] = t;
                u[e] = [o.toString(), t.PICTURE_ID];
                $.cookie(f, u, {path: "/", expires: 30});
                BX.localStorage.set(f, i, 2592e3)
            }
        } catch (l) {
            console.error(l)
        } finally {
            $.cookie.json = s
        }
    }
}
if (!funcDefined("initSelects")) {
    function n(n) {
        var i = navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? !0 : !1, t;
        if (!i && !$("#bx-soa-order").length) {
            $(n).find(".wrapper1 select:visible").ikSelect({
                syntax: '<div class="ik_select_link"> \t\t\t\t\t\t<span class="ik_select_link_text"><\/span> \t\t\t\t\t\t<div class="trigger"><\/div> \t\t\t\t\t<\/div> \t\t\t\t\t<div class="ik_select_dropdown"> \t\t\t\t\t\t<div class="ik_select_list"> \t\t\t\t\t\t<\/div> \t\t\t\t\t<\/div>',
                dynamicWidth: !0,
                ddMaxHeight: 112,
                customClass: "common_select",
                onShow: function (n) {
                    n.$dropdown.css("top", parseFloat(n.$dropdown.css("top")) - 5 + "px");
                    n.$dropdown.outerWidth() < n.$link.outerWidth() && n.$dropdown.css("width", n.$link.outerWidth());
                    n.$dropdown.outerWidth() > n.$link.outerWidth() && n.$dropdown.css("width", n.$link.outerWidth());
                    var i = 0, t = 0;
                    n.$dropdown.css("left", n.$link.offset().left);
                    $(n.$listInnerUl).find("li").each(function () {
                        $(this).hasClass("ik_select_option_disabled") || (++i, t += $(this).outerHeight())
                    });
                    t < 112 ? n.$listInner.css("height", "auto") : n.$listInner.css("height", "112px");
                    n.$link.addClass("opened");
                    n.$listInner.addClass("scroller scrollblock");
                    $(".confirm_region").length && $(".confirm_region").remove()
                },
                onHide: function (n) {
                    n.$link.removeClass("opened")
                }
            });
            $(window).on("resize", function () {
                ignoreResize.push(!0);
                clearTimeout(t);
                t = setTimeout(function () {
                    var n = "";
                    (n = $(".common_select-link.opened + select").ikSelect().data("plugin_ikSelect")) && n.$dropdown.css("left", n.$link.offset().left + "px")
                }, 20);
                ignoreResize.pop()
            })
        }
    }
}
if (funcDefined("CheckTopMenuFullCatalogSubmenu") || (CheckTopMenuFullCatalogSubmenu = function () {
    var n, i, t;
    if ((!arAsproOptions.THEME || arAsproOptions.THEME.MENU_TYPE_VIEW == "HOVER") && (n = $(".left_block .menu_top_block"), n.length)) {
        i = n.parents(".wrap_menu");
        t = n.closest(".wrapper_inner").actual("width");
        t || (t = n.closest(".wraps").actual("width"));
        var o = n.hasClass("catalogfirst"), r = $(".left_block .menu_top_block:visible li.full"),
            f = n.actual("outerWidth"), u = 0, e = 0;
        i.length && (t = i.actual("outerWidth"), u = i.offset().left, e = u + t);
        $(".left_block .catalog_block.menu_top_block").length && $(".left_block .catalog_block.menu_top_block").is(":visible") && (r = $(".left_block .menu_top_block.catalog_block li.full"));
        r.each(function () {
            var n = $(this), i = n.find(">.dropdown");
            if (i.length && (i.css({width: t - f + "px"}), !isOnceInited && arAsproOptions.THEME.MENU_POSITION == "TOP")) n.on("mouseenter", function () {
                i.css("min-height", n.closest(".dropdown").actual("outerHeight") + "px")
            })
        })
    }
}), $.fn.getMaxHeights = function (n) {
    for (var t = this.map(function (t, i) {
        return $(i).css("height", ""), n == !0 ? $(i).actual("outerHeight") : $(i).actual("height")
    }).get(), i = 0, r = t.length; i < r; ++i) t[i] % 2 && --t[i];
    return Math.max.apply(this, t)
}, $.fn.equalizeHeights = function (n, t, i) {
    for (var h, a, f = [], c = [], u = 0, s = 0; u < this.length; s++) {
        var l = this[s], e = $(l), o = 0, r = 0;
        (u++, i.blockNull !== undefined && i.blockNull.class !== undefined && (e.hasClass(i.blockNull.class) || e.closest("." + i.blockNull.class).length)) || (c.push(this[s]), t !== !1 && (isMobile || (h = e.find(t), h.length && (o = parseInt(h[0].offsetHeight)))), o && (o += 12), e.css("height", ""), r = l.offsetHeight - o, i.minHeight !== !1 && (r < i.minHeight && (r += i.minHeight - r), window.matchMedia("(max-width: 520px)").matches && (r = 300), window.matchMedia("(max-width: 400px)").matches && (r = 200)), r || (r = 0), f.push(r))
    }
    for (u = 0, a = f.length; u < a; ++u) f[u] % 2 && --f[u];
    return $(c).height(Math.max.apply(this, f))
}, $.fn.getFloatWidth = function () {
    var n = 0, t;
    return $(this).length && (t = $(this)[0].getBoundingClientRect(), (n = t.width) || (n = t.right - t.left)), $(this).data("floatWidth", n), n
}, $.fn.sliceHeight = function (n) {
    function t(t) {
        var c = Object.keys(n.breakpoint), k = {}, y, o, u, p, w, r, f, h, e, a, b, v;
        if (c.length) for (y in c) window.matchMedia(c[y].toString()).matches && (k = n.breakpoint[c[y]]);
        var i = extendDepthObject(n, k),
            d = i.blockNull !== undefined && i.blockNull.class !== undefined ? i.blockNull.class : !1,
            nt = typeof i.row != "undefined" && i.row.length ? t.first().parents(i.row) : t.first().parents(".items"),
            s = "";
        if (typeof i.item != "undefined" && i.item.length) if (d) {
            if ($(i.item).each(function (n, t) {
                _element = $(t);
                _element.hasClass(d) || (s = _element)
            }), !s) return !1
        } else s = $(i.item).first(); else s = t.first().hasClass("item") ? t.first() : t.first().parents(".item");
        if ((typeof i.autoslicecount == "undefined" || i.autoslicecount !== !1) && (o = nt.getFloatWidth(), u = s.getFloatWidth(), o || (o = t.first().parents(".row").getFloatWidth()), u || (u = typeof i.item != "undefined" && i.item.length ? $(i.item + ":eq(1)").getFloatWidth() ? $(i.item + ":eq(1)").getFloatWidth() : $(i.item + ":eq(2)").getFloatWidth() : $(t[1]).getFloatWidth() ? $(t[1]).getFloatWidth() : $(t[2]).getFloatWidth()), u && i.fixWidth && (u -= i.fixWidth), u = parseInt(u * 100) / 100, o && u && (i.slice = Math.floor(o / u))), i.customSlice && (p = !1, i.length && (u = typeof i.item != "undefined" && i.item.length ? $(i.item).last().getFloatWidth() : t.last().hasClass("item") ? t.last().getFloatWidth() : t.last().parents(".item").getFloatWidth(), u && (i.sliceNext = Math.floor(o / u)), p = !0)), elements = [], i.classes !== undefined && i.classes.length) for (f = 0; f < i.classes.length; f++) e = $(i.item).find(i.classes[f]), elements.push(e);
        if (w = elements.push(t) - 1, i.mobile == !0 && window.matchMedia("(max-width: 500px)").matches) {
            for (r = 0; r < elements.length; r++) e = $(elements[r]), e.css({"line-height": "", height: ""});
            return
        }
        if (typeof i.typeResize == "undefined" || i.typeResize == !1) {
            if (i.slice) for (r = 0; r < elements.length; r++) if (i.currentRow) {
                var tt = t.index(i.currentItem), l = i.slice, g = Math.floor(tt / l),
                    e = $(elements[r].slice(g * l, g * l + l)), b = r == w ? i.classNull : !1;
                e.css({"line-height": "", height: ""});
                e.equalizeHeights(i.outer, b, i)
            } else for (f = 0; f < elements[r].length;) i.customSlice && i.sliceNext && p && f && (i.slice = i.sliceNext), h = i.slice, e = $(elements[r].slice(f, f + h)), i.blockNull !== undefined && i.blockNull.class !== undefined && (a = 0, e.each(function (n, t) {
                var r = $(t);
                (r.hasClass(i.blockNull.class) || r.closest("." + i.blockNull.class).length) && a++
            })), a && (h -= (i.blockNull.width - 1) * a), e = $(elements[r].slice(f, f + h)), e && (b = r == w ? i.classNull : !1, e.css({
                "line-height": "",
                height: ""
            }), e.equalizeHeights(i.outer, b, i)), f += h || 1;
            i.lineheight && (v = parseInt(i.lineheight), isNaN(v) && (v = 0), t.each(function () {
                $(this).css("line-height", $(this).actual("height") + v + "px")
            }))
        }
    }

    var n = $.extend({
        slice: null,
        sliceNext: null,
        outer: !1,
        lineheight: !1,
        autoslicecount: !0,
        classNull: !1,
        minHeight: !1,
        row: !1,
        item: !1,
        typeResize: !1,
        typeValue: !1,
        fixWidth: 0,
        resize: !0,
        mobile: !1,
        customSlice: !1,
        breakpoint: {},
        classes: []
    }, n), i = $(this);
    ignoreResize.push(!0);
    t(i);
    ignoreResize.pop();
    n.resize ? BX.addCustomEvent("onWindowResize", function () {
        try {
            ignoreResize.push(!0);
            t(i)
        } catch (n) {
        } finally {
            ignoreResize.pop()
        }
    }) : ignoreResize.length || t(i)
}, $.fn.sliceHeightNoResize = function (n) {
    function t(t) {
        var r, i, f, o, s, u, e;
        if (t.each(function () {
            $(this).css("line-height", "");
            $(this).css("height", "")
        }), n.mobile != !0 || !window.matchMedia("(max-width: 550px)").matches) {
            if ((typeof n.autoslicecount == "undefined" || n.autoslicecount !== !1) && (r = typeof n.row != "undefined" && n.row.length ? t.first().parents(n.row).getFloatWidth() : t.first().parents(".items").getFloatWidth(), i = typeof n.item != "undefined" && n.item.length ? $(n.item).first().getFloatWidth() : t.first().hasClass("item") ? t.first().getFloatWidth() : t.first().parents(".item").getFloatWidth(), r || (r = t.first().parents(".row").getFloatWidth()), i && n.fixWidth && (i -= n.fixWidth), r && i && (n.slice = Math.floor(r / i))), n.customSlice && (f = Object.keys(n.breakpoint), o = !1, f.length)) {
                i = typeof n.item != "undefined" && n.item.length ? $(n.item).last().getFloatWidth() : t.last().hasClass("item") ? t.last().getFloatWidth() : t.last().parents(".item").getFloatWidth();
                i && (n.sliceNext = Math.floor(r / i));
                for (s in f) window.matchMedia(f[s].toString()).matches && (o = !0, n.slice = n.breakpoint[f[s]])
            }
            if (typeof n.typeResize == "undefined" || n.typeResize == !1) {
                if (n.slice) for (u = 0; u < t.length; u += n.slice) n.customSlice && n.sliceNext && o && u && (n.slice = n.sliceNext), $(t.slice(u, u + n.slice)).equalizeHeights(n.outer, n.classNull, n.minHeight, n.typeResize, n.typeValue);
                n.lineheight && (e = parseInt(n.lineheight), isNaN(e) && (e = 0), t.each(function () {
                    $(this).css("line-height", $(this).actual("height") + e + "px")
                }))
            }
        }
    }

    var n = $.extend({
        slice: null,
        sliceNext: null,
        outer: !1,
        lineheight: !1,
        autoslicecount: !0,
        classNull: !1,
        minHeight: !1,
        row: !1,
        item: !1,
        typeResize: !1,
        typeValue: !1,
        fixWidth: 0,
        resize: !0,
        mobile: !1,
        customSlice: !1,
        breakpoint: {}
    }, n), i = $(this);
    ignoreResize.push(!0);
    t(i);
    ignoreResize.pop()
}, !funcDefined("initHoverBlock")) {
    function n() {
    }
}
if (!funcDefined("setStatusButton")) {
    function n() {
        if (funcDefined("setItemButtonStatus") || (setItemButtonStatus = function (n) {
            var i, t;
            if (n.BASKET) for (i in n.BASKET) t = n.BASKET[i], (typeof t == "number" || typeof t == "string") && ($(".to-cart[data-item=" + t + "]").hide(), $(".counter_block[data-item=" + t + "]").closest(".counter_block_inner").hide(), $(".counter_block[data-item=" + t + "]").hide(), $(".in-cart[data-item=" + t + "]").show(), $(".in-cart[data-item=" + t + "]").closest(".button_block").addClass("wide"));
            if (n.DELAY) for (i in n.DELAY) t = n.DELAY[i], (typeof t == "number" || typeof t == "string") && ($(".wish_item.to[data-item=" + t + "]").hide(), $(".wish_item.in[data-item=" + t + "]").show(), $(".wish_item[data-item=" + t + "]").find(".value.added").length && ($(".wish_item[data-item=" + t + "]").find(".value").hide(), $(".wish_item[data-item=" + t + "]").find(".value.added").show()));
            if (n.SUBSCRIBE) for (i in n.SUBSCRIBE) t = n.SUBSCRIBE[i], (typeof t == "number" || typeof t == "string") && ($(".to-subscribe[data-item=" + t + "]").hide(), $(".in-subscribe[data-item=" + t + "]").show());
            if (n.COMPARE) for (i in n.COMPARE) t = n.COMPARE[i], (typeof t == "number" || typeof t == "string") && ($(".compare_item.to[data-item=" + t + "]").hide(), $(".compare_item.in[data-item=" + t + "]").show(), $(".compare_item[data-item=" + t + "]").find(".value.added").length && ($(".compare_item[data-item=" + t + "]").find(".value").hide(), $(".compare_item[data-item=" + t + "]").find(".value.added").show()))
        }), Object.keys(arStatusBasketAspro).length) setItemButtonStatus(arStatusBasketAspro); else {
            if (typeof n == "undefined") {
                var n = {SITE_DIR: "/"};
                $("body").data("site") !== undefined && (n.SITE_DIR = $("body").data("site"))
            }
            $.ajax({
                url: n.SITE_DIR + "ajax/getAjaxBasket.php", type: "POST", success: function (n) {
                    arStatusBasketAspro = n;
                    setItemButtonStatus(arStatusBasketAspro)
                }
            })
        }
    }
}
if (funcDefined("onLoadjqm") || (onLoadjqm = function (n, t, i, r, u, f, e) {
    var c, a, l, v, y, p;
    if (t.c.noOverlay !== undefined && (t.c.noOverlay === undefined || t.c.noOverlay) || $("body").addClass("jqm-initied"), window.matchMedia("(min-width: 768px)").matches && $("body").addClass("swipeignore"), typeof $(t.t).data("ls") != " undefined" && $(t.t).data("ls")) {
        var h = $(t.t).data("ls"), s = 0, o = "";
        if ($(t.t).data("ls_timeout") && (s = $(t.t).data("ls_timeout")), s = s ? Date.now() + s * 1e3 : "", typeof localStorage != "undefined") {
            c = localStorage.getItem(h);
            try {
                o = JSON.parse(c)
            } catch (w) {
                o = c
            }
            o != null && localStorage.removeItem(h);
            o = {};
            o.VALUE = "Y";
            o.TIMESTAMP = s;
            localStorage.setItem(h, JSON.stringify(o))
        } else c = $.cookie(h), c || $.cookie(h, "Y", {expires: s});
        a = t.w.find(".marketing-popup").data("classes");
        a && t.w.addClass(a)
    }
    $.each($(t.t).get(0).attributes, function (n, i) {
        if (/^data\-autoload\-(.+)$/.test(i.nodeName)) {
            var u = i.nodeName.match(/^data\-autoload\-(.+)$/)[1], r = $('input[data-sid="' + u.toUpperCase() + '"]');
            r.val(BX.util.htmlspecialcharsback($(t.t).data("autoload-" + u))).attr("readonly", "readonly");
            r.closest(".form-group").addClass("input-filed");
            r.attr("title", r.val())
        }
    });
    t.w.hasClass("send_gift_frame") && (l = priceHtml = propsHtml = "", $(".offers_img a").length ? l = $(".offers_img a").html() : $(".product-detail-gallery__container .first_sku_picture").length ? l = "<img src=" + $(".product-detail-gallery__container link.first_sku_picture").attr("href") + " />" : $(".product-detail-gallery__container").length && (l = "<img src=" + $('.product-detail-gallery__container link[itemprop="image"]').attr("href") + " />"), $('.product-container *[itemprop="offers"]').length && ($(".sku-view").length ? $(".prices_block .price").length && (priceHtml = $(".prices_block .cost.prices").html().replace("id", "data-id")) : $(".prices_block .js_price_wrapper").length ? priceHtml = '<div class="with_matrix">' + $(".prices_block .js_price_wrapper").html() + "<\/div>" : $(".prices_block .with_matrix").length ? priceHtml = '<div class="with_matrix">' + $(".prices_block .with_matrix").html() + "<\/div>" : $(".prices_block .price_group.min").length ? priceHtml = $(".prices_block .price_group.min").html() : $(".prices_block .price_matrix_wrapper").length && (priceHtml = $(".prices_block .price_matrix_wrapper").html())), $(".buy_block .sku_props").length && (propsHtml = '<div class="props_item">', $(".buy_block .sku_props .bx_catalog_item_scu > div").each(function () {
        var f = $(this).find(".bx_item_section_name > span").html(), i = "", u = $(this).find(".ik_select_link_text"),
            r, n, t;
        u.length ? i = u.text() : (r = $(this).find("ul li.active"), n = r.find(" > i"), n.length && n.attr("title") ? (t = n.attr("title").split(":"), t = t.length ? t[1].trim() : n.attr("title"), i = t) : i = r.find(" > span").text());
        propsHtml += '<div class="prop_item"><span>' + f + '<span class="val">' + i + "<\/span><\/span><\/div>"
    }), propsHtml += "<\/div>"), $('<div class="custom_block"><div class="title">' + BX.message("POPUP_GIFT_TEXT") + '<\/div><div class="item_block"><table class="item_list"><tr><td class="image"><div>' + l + '<\/div><\/td><td class="text"><div class="name">' + $("h1").text() + "<\/div>" + priceHtml + propsHtml + "<\/td><\/tr><\/table><\/div><\/div>").prependTo(t.w.find(".form_body")));
    arAsproOptions.THEME.REGIONALITY_SEARCH_ROW == "Y" && (t.w.hasClass("city_chooser_frame ") || t.w.hasClass("city_chooser_small_frame")) && (t.w.addClass("small_popup_regions"), t.w.addClass("no_scroll"));
    n == "fast_view" && $(".smart-filter-filter").length && (v = '<div class="navigation-wrapper-fast-view"><div class="fast-view-nav prev colored_theme_hover_bg" data-fast-nav="prev"><i class="svg left"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="6.969" viewBox="0 0 12 6.969"><path id="Rounded_Rectangle_702_copy_24" data-name="Rounded Rectangle 702 copy 24" class="cls-1" d="M361.691,401.707a1,1,0,0,1-1.414,0L356,397.416l-4.306,4.291a1,1,0,0,1-1.414,0,0.991,0.991,0,0,1,0-1.406l5.016-5a1.006,1.006,0,0,1,1.415,0l4.984,5A0.989,0.989,0,0,1,361.691,401.707Z" transform="translate(-350 -395.031)"/><\/svg><\/i><\/div><div class="fast-view-nav next colored_theme_hover_bg" data-fast-nav="next"><i class="svg right"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="6.969" viewBox="0 0 12 6.969"><path id="Rounded_Rectangle_702_copy_24" data-name="Rounded Rectangle 702 copy 24" class="cls-1" d="M361.691,401.707a1,1,0,0,1-1.414,0L356,397.416l-4.306,4.291a1,1,0,0,1-1.414,0,0.991,0.991,0,0,1,0-1.406l5.016-5a1.006,1.006,0,0,1,1.415,0l4.984,5A0.989,0.989,0,0,1,361.691,401.707Z" transform="translate(-350 -395.031)"/><\/svg><\/i><\/div><\/div>', t.w.closest("#popup_iframe_wrapper").append(v));
    t.w.addClass("scrollblock");
    t.w.addClass("show").css({opacity: 1});
    t.c.noOverlay !== undefined && (t.c.noOverlay === undefined || t.c.noOverlay) || ($("body").css({
        overflow: "hidden",
        height: "100vh"
    }), t.w.closest("#popup_iframe_wrapper").css({"z-index": 3e3, display: "flex"}));
    y = {action: "loadForm"};
    BX.onCustomEvent("onCompleteAction", [y, $(t.t)[0]]);
    typeof i == "undefined" && (i = "");
    typeof r == "undefined" && (r = !1);
    p = $("." + n + "_frame").width();
    n == "order-popup-call" || (n == "order-button" ? $(".order-button_frame").find("div[product_name]").find("input").val(t.t.title).attr("readonly", "readonly").css({
        overflow: "hidden",
        "text-overflow": "ellipsis"
    }) : n == "basket_error" && ($(".basket_error_frame .pop-up-title").text(u), $(".basket_error_frame .ajax_text").html(i), window.matchMedia("(max-width: 991px)").matches && $("body").addClass("all_viewed"), f == "Y" && e && $("<div class='popup_button_basket_wr'><span class='popup_button_basket big_btn button' data-item=" + e.data("item") + "><span class='btn btn-default'>" + BX.message("ERROR_BASKET_BUTTON") + "<\/span><\/span><\/div>").insertAfter($(".basket_error_frame .ajax_text"))));
    $("." + n + "_frame").show()
}), funcDefined("onHidejqm") || (onHidejqm = function (n, t) {
    t.w.find(".one_click_buy_result_success").is(":visible") && n == "one_click_buy_basket" && (window.location.href = window.location.href);
    $(".xzoom-source").length && $(".xzoom-source").remove();
    $(".xzoom-preview").length && $(".xzoom-preview").remove();
    t.w.animate({opacity: 0}, 200, function () {
        if (t.w.hide(), t.w.empty(), t.o.remove(), t.w.removeClass("show"), $("body").css({
            overflow: "",
            height: ""
        }), t.w.closest("#popup_iframe_wrapper").find(".jqmOverlay").length || t.w.closest("#popup_iframe_wrapper").css({
            "z-index": "",
            display: ""
        }), window.matchMedia("(max-width: 991px)").matches && $("body").removeClass("all_viewed"), (!$(".jqmOverlay:not(.mobp)").length || $(".jqmOverlay.waiting").length) && $("body").removeClass("jqm-initied"), window.matchMedia("(min-width: 768px)").matches && $("body").removeClass("swipeignore"), n == "fast_view") {
            $(".fast_view_popup").remove();
            var i = t.w.closest("#popup_iframe_wrapper").find(".navigation-wrapper-fast-view");
            i.remove()
        }
    });
    window.b24form = !1
}), $.fn.jqmEx = function () {
    var n = $(this), t = n.data("name"), f, h;
    if (t.length && n.attr("disabled") != "disabled") {
        var i = "", r = "", e = "", o = {};
        typeof $.fn.jqmEx.counter == "undefined" ? $.fn.jqmEx.counter = 0 : ++$.fn.jqmEx.counter;
        $.each(n.get(0).attributes, function (t, i) {
            var u = i.nodeName, f = n.attr(u), s;
            u !== "onclick" && (e += "[" + u + '="' + f + '"]', o[u] = f);
            /^data\-param\-(.+)$/.test(u) && (s = u.match(/^data\-param\-(.+)$/)[1], r += s + "=" + f + "&")
        });
        var c = JSON.stringify(o), u = encodeURIComponent(c), s = arAsproOptions.SITE_DIR + "ajax/form.php";
        s += t == "auth" ? "?" + r + "auth=Y" : "?" + r + "data-trigger=" + u;
        n.closest("#fast_view_item").length && (i = "fast_view_popup");
        f = n.data("noOverlay") == "Y";
        h = f ? $('<div class="' + t + "_frame " + i + ' jqmWindow popup" data-popup="' + $.fn.jqmEx.counter + '" data-trigger="' + u + '"><\/div>').appendTo("body") : $('<div class="' + t + "_frame " + i + ' jqmWindow popup" data-popup="' + $.fn.jqmEx.counter + '" data-trigger="' + u + '"><\/div>').appendTo("#popup_iframe_wrapper");
        h.jqm({
            ajax: s, trigger: e, noOverlay: f, onLoad: function (n) {
                onLoadjqm(t, n)
            }, onHide: function (n) {
                onHidejqm(t, n)
            }
        })
    }
}, window.addEventListener("keydown", function (n) {
    n.keyCode == 27 && ($(".jqm-init.show").last().jqmHide(), $(".inline-search-block.show").length && ($(".inline-search-block").toggleClass("show"), $(".jqmOverlay.search").detach()), $(".mega_fixed_menu").fadeOut(animationTime))
}), !funcDefined("scroll_block")) {
    function n(n, t) {
        var i, r, u;
        n.length && (t !== undefined && t.length ? t.trigger("click") : ($(".prices_tab").addClass("active").siblings().removeClass("active"), $(".prices_tab .opener").length && !$(".prices_tab .opener .opened").length && (i = $(".prices_tab .opener").first(), i.find(".opener_icon").addClass("opened"), i.parents("tr").addClass("nb"), i.parents("tr").next(".offer_stores").find(".stores_block_wrap").slideDown(200))), r = n.offset().top, u = $("header").outerHeight(!0, !0), $("html,body").animate({scrollTop: r - 88}, 150))
    }
}
if (funcDefined("jqmEd") || (jqmEd = function (n, t, i, r, u, f, e, o) {
    return typeof r == "undefined" && (r = ""), typeof u == "undefined" && (u = !1), $("body #popup_iframe_wrapper").find("." + n + "_frame").remove(), $("body #popup_iframe_wrapper").append('<div class="' + n + '_frame jqmWindow popup"><\/div>'), typeof i == "undefined" ? $("." + n + "_frame").jqm({
        trigger: "." + n + "_frame.popup",
        onHide: function (t) {
            onHidejqm(n, t)
        },
        onLoad: function (t) {
            onLoadjqm(n, t, r, u)
        },
        ajax: arAsproOptions.SITE_DIR + "ajax/form.php?form_id=" + t + (r.length ? "&" + r : "")
    }) : (n == "enter" ? $("." + n + "_frame").jqm({
        trigger: i, onHide: function (t) {
            onHidejqm(n, t)
        }, onLoad: function (t) {
            onLoadjqm(n, t, r, u)
        }, ajax: arAsproOptions.SITE_DIR + "ajax/auth.php"
    }) : n == "basket_error" ? $("." + n + "_frame").jqm({
        trigger: i, onHide: function (t) {
            onHidejqm(n, t)
        }, onLoad: function (t) {
            onLoadjqm(n, t, r, u, f, e, o)
        }, ajax: arAsproOptions.SITE_DIR + "ajax/basket_error.php"
    }) : $("." + n + "_frame").jqm({
        trigger: i, onHide: function (t) {
            onHidejqm(n, t)
        }, onLoad: function (t) {
            onLoadjqm(n, t, r, u)
        }, ajax: arAsproOptions.SITE_DIR + "ajax/form.php?form_id=" + t + (r.length ? "&" + r : "")
    }), $(i).dblclick(function () {
        return !1
    })), !0
}), !funcDefined("replaceBasketPopup")) {
    function n(n) {
        typeof n != "undefined" && (n.w.hide(), n.o.hide())
    }
}
if (!funcDefined("waitLayer")) {
    function n(t, i) {
        typeof dataLayer != "undefined" && typeof i == "function" ? i() : setTimeout(function () {
            n(t, i)
        }, t)
    }
}
if (!funcDefined("checkCounters")) {
    function n(n) {
        return typeof n != "undefined" ? n == "google" && arAsproOptions.COUNTERS.GOOGLE_ECOMERCE == "Y" && arAsproOptions.COUNTERS.GOOGLE_COUNTER > 0 ? !0 : n == "yandex" && arAsproOptions.COUNTERS.YANDEX_ECOMERCE == "Y" && arAsproOptions.COUNTERS.YANDEX_COUNTER > 0 ? !0 : !1 : arAsproOptions.COUNTERS.YANDEX_ECOMERCE == "Y" && arAsproOptions.COUNTERS.YANDEX_COUNTER > 0 || arAsproOptions.COUNTERS.GOOGLE_ECOMERCE == "Y" && arAsproOptions.COUNTERS.GOOGLE_COUNTER > 0 ? !0 : !1
    }
}
if (!funcDefined("addBasketCounter")) {
    function n(n) {
        if (arAsproOptions.COUNTERS.USE_BASKET_GOALS !== "N") {
            var t = {goal: "goal_basket_add", params: {id: n}};
            BX.onCustomEvent("onCounterGoals", [t])
        }
        checkCounters() && $.ajax({
            url: arAsproOptions.SITE_DIR + "ajax/goals.php",
            dataType: "json",
            type: "POST",
            data: {ID: n},
            success: function (n) {
                !n || !n.ID || waitLayer(100, function () {
                    dataLayer.push({
                        event: arAsproOptions.COUNTERS.GOOGLE_EVENTS.ADD2BASKET,
                        ecommerce: {
                            currencyCode: n.CURRENCY,
                            add: {
                                products: [{
                                    id: n.ID,
                                    name: n.NAME,
                                    price: n.PRICE,
                                    brand: n.BRAND,
                                    category: n.CATEGORY,
                                    quantity: n.QUANTITY
                                },]
                            }
                        }
                    })
                })
            }
        })
    }
}
if (!funcDefined("purchaseCounter")) {
    function n(n, t, i) {
        checkCounters() && $.ajax({
            url: arAsproOptions.SITE_DIR + "ajax/goals.php",
            dataType: "json",
            type: "POST",
            data: {ORDER_ID: n, TYPE: t},
            success: function (n) {
                var u = [], r;
                if (n.ITEMS) for (r in n.ITEMS) u.push({
                    id: n.ITEMS[r].ID,
                    sku: n.ITEMS[r].ID,
                    name: n.ITEMS[r].NAME,
                    price: n.ITEMS[r].PRICE,
                    brand: n.ITEMS[r].BRAND,
                    category: n.ITEMS[r].CATEGORY,
                    quantity: n.ITEMS[r].QUANTITY
                });
                n.ID ? waitLayer(100, function () {
                    dataLayer.push({
                        event: arAsproOptions.COUNTERS.GOOGLE_EVENTS.PURCHASE,
                        ecommerce: d = {
                            purchase: {
                                actionField: {
                                    id: n.ACCOUNT_NUMBER,
                                    shipping: n.PRICE_DELIVERY,
                                    tax: n.TAX_VALUE,
                                    list: t,
                                    revenue: n.PRICE
                                }, products: u
                            }
                        }
                    });
                    typeof i != "undefined" && i(d)
                }) : typeof i != "undefined" && i()
            },
            error: function () {
                typeof i != "undefined" && i()
            }
        })
    }
}
if (!funcDefined("viewItemCounter")) {
    function n(n, t) {
        checkCounters() && $.ajax({
            url: arAsproOptions.SITE_DIR + "ajax/goals.php",
            dataType: "json",
            type: "POST",
            data: {PRODUCT_ID: n, PRICE_ID: t},
            success: function (n) {
                n.ID && waitLayer(100, function () {
                    dataLayer.push({
                        ecommerce: {
                            detail: {
                                products: [{
                                    id: n.ID,
                                    name: n.NAME,
                                    price: n.PRICE,
                                    brand: n.BRAND,
                                    category: n.CATEGORY
                                },]
                            }
                        }
                    })
                })
            }
        })
    }
}
if (!funcDefined("checkoutCounter")) {
    function n(n, t) {
        checkCounters("google") && $.ajax({
            url: arAsproOptions.SITE_DIR + "ajax/goals.php",
            dataType: "json",
            type: "POST",
            data: {BASKET: "Y"},
            success: function (i) {
                var u = [], r;
                if (i.ITEMS) for (r in i.ITEMS) u.push({
                    id: i.ITEMS[r].ID,
                    name: i.ITEMS[r].NAME,
                    price: i.ITEMS[r].PRICE,
                    brand: i.ITEMS[r].BRAND,
                    category: i.ITEMS[r].CATEGORY,
                    quantity: i.ITEMS[r].QUANTITY
                });
                u && waitLayer(100, function () {
                    dataLayer.push({
                        event: arAsproOptions.COUNTERS.GOOGLE_EVENTS.CHECKOUT_ORDER,
                        ecommerce: {checkout: {actionField: {step: n, option: t}, products: u}}
                    })
                })
            }
        })
    }
}
if (!funcDefined("delFromBasketCounter")) {
    function n(n, t) {
        checkCounters() && $.ajax({
            url: arAsproOptions.SITE_DIR + "ajax/goals.php",
            dataType: "json",
            type: "POST",
            data: {ID: n},
            success: function (n) {
                n.ID && waitLayer(100, function () {
                    dataLayer.push({
                        event: arAsproOptions.COUNTERS.GOOGLE_EVENTS.REMOVE_BASKET,
                        ecommerce: {remove: {products: [{id: n.ID, name: n.NAME, category: n.CATEGORY},]}}
                    });
                    typeof t == "function" && t()
                })
            }
        })
    }
}
if (!funcDefined("setHeightCompany")) {
    function n() {
        $(".md-50.img").height($(".md-50.big").outerHeight() - 35)
    }
}
if (!funcDefined("initSly")) {
    function n() {
    }
}
if (!funcDefined("createTableCompare")) {
    function n(n, t, i) {
        try {
            var r = n.clone().removeAttr("id").addClass("clone");
            i.length ? (i.remove(), t.html(""), t.html(r)) : t.append(r)
        } catch (u) {
        }
    }
}
if (funcDefined("fillBasketPropsExt") || (fillBasketPropsExt = function (n, t, i) {
    var u = 0, r = null, o = !1, f = {}, e = null;
    if (e = BX(i), !e && n.closest(".item").find(".basket_props_block").length && n.data("offers") !== "Y" && (e = n.closest(".item").find(".basket_props_block")[0]), !!e) {
        if (r = e.getElementsByTagName("select"), !!r && !!r.length) for (u = 0; u < r.length; u++) if (!r[u].disabled) switch (r[u].type.toLowerCase()) {
            case"select-one":
                f[r[u].name] = r[u].value;
                o = !0
        }
        if (r = e.getElementsByTagName("input"), !!r && !!r.length) for (u = 0; u < r.length; u++) if (!r[u].disabled) switch (r[u].type.toLowerCase()) {
            case"hidden":
                f[r[u].name] = r[u].value;
                o = !0;
                break;
            case"radio":
                r[u].checked && (f[r[u].name] = r[u].value, o = !0)
        }
    }
    return o || (f[t] = [], f[t][0] = 0), f
}), funcDefined("showBasketError") || (showBasketError = function (n, t, i, r, u) {
    var o = t ? t : BX.message("ERROR_BASKET_TITLE"), f = "N", e = "";
    typeof i !== undefined && (f = "Y");
    typeof r !== undefined && (e = r);
    $("body").append("<span class='add-error-bakset' style='display:none;'><\/span>");
    jqmEd("basket_error", "error-bakset", ".add-error-bakset", n, this, o, f, e);
    $("body .add-error-bakset").click();
    $("body .add-error-bakset").remove();
    typeof u == "function" && u()
}), CheckTopVisibleMenu = function (n) {
    var t = $(".dropdown-menu:visible");
    n !== undefined && t.push(n);
    t.length && t.each(function (n, t) {
        var i = $(t), u, r, l, o, s, a;
        if (i.find("a").css("white-space", ""), i.css("left", ""), i.css("right", ""), i.removeClass("toright"), u = i.offset().left, typeof u != "undefined") {
            r = i.parents(".mega-menu");
            r.length || (r = i.closest(".logo-row"));
            var v = r.outerWidth(), y = r.offset().left, f = y + v, h = i.parents(".toright").length > 0,
                e = i.parents(".dropdown-menu"), c = e.length > 0;
            if (c) var p = e.first().outerWidth(), w = e.first().offset().left, b = p + w;
            b + i.outerWidth() > f && i.find("a").css("white-space", "normal");
            l = i.outerWidth();
            o = u + l;
            (o > f || h) && (s = 0, s = f - o, c || h ? (i.css("left", "auto"), i.css("right", "100%"), i.addClass("toright")) : (a = parseInt(i.css("left")), i.css("left", a + s + "px")))
        }
    })
}, !funcDefined("isRealValue")) {
    function n(n) {
        return n && n !== "null" && n !== "undefined"
    }
}
if (!funcDefined("rightScroll")) {
    function n(n, t) {
        var i = BX("prop_" + n + "_" + t), r;
        i && (r = parseInt(i.style.marginLeft), r >= 0 && (i.style.marginLeft = r - 20 + "%"))
    }
}
if (!funcDefined("leftScroll")) {
    function n(n, t) {
        var i = BX("prop_" + n + "_" + t), r;
        i && (r = parseInt(i.style.marginLeft), r < 0 && (i.style.marginLeft = r + 20 + "%"))
    }
}
funcDefined("InitOrderCustom") || (InitOrderCustom = function () {
    $(".ps_logo img").wrap('<div class="image"><\/div>');
    $("#bx-soa-order .radio-inline").each(function () {
        $(this).find("input").attr("checked") == "checked" && $(this).addClass("checked")
    });
    $("#bx-soa-order .checkbox input[type=checkbox]").each(function () {
        $(this).attr("checked") == "checked" && $(this).parent().addClass("checked")
    });
    $("#bx-soa-order .bx-authform-starrequired").each(function () {
        var n = $(this).html();
        $(this).closest("label").append('<span class="bx-authform-starrequired"> ' + n + "<\/span>");
        $(this).detach()
    });
    $(".bx_ordercart_coupon").each(function () {
        $(this).find(".bad").length ? $(this).addClass("bad") : $(this).find(".good").length && $(this).addClass("good")
    })
});
funcDefined("InitLabelAnimation") || (InitLabelAnimation = function (n) {
    if ($(n).length) {
        $(n).find(".form-group").each(function () {
            $(this).find("input[type=text], textarea").length && !$(this).find(".dropdown-block").length && $(this).find("input[type=text], textarea").val() != "" && $(this).addClass("value_y")
        });
        $(document).on("click", n + " .form-group:not(.bx-soa-pp-field) label", function () {
            $(this).parent().find("input, textarea").focus()
        });
        $(document).on("focusout", n + " .form-group:not(.bx-soa-pp-field) input, " + n + " .form-group:not(.bx-soa-pp-field) textarea", function () {
            var n = $(this).val();
            n == "" || $(this).closest(".form-group").find(".dropdown-block").length || $(this).closest(".form-group").find("#profile_change").length ? $(this).closest(".form-group").removeClass("value_y") : $(this).closest(".form-group").addClass("value_y")
        });
        $(document).on("focus", n + " .form-group:not(.bx-soa-pp-field) input, " + n + " .form-group:not(.bx-soa-pp-field) textarea", function () {
            $(this).closest(".form-group").find(".dropdown-block").length || $(this).closest(".form-group").find("#profile_change").length || $(this).closest(".form-group").find("[name=PERSON_TYPE_OLD]").length || $(this).closest(".form-group").addClass("value_y")
        })
    }
});
checkPopupWidth = function () {
    $(".popup.show").each(function () {
        var n = $(this).actual("width");
        $(this).css({"margin-left": $(window).width() > n ? "-" + n / 2 + "px" : "-" + $(window).width() / 2 + "px"})
    })
};
checkCaptchaWidth = function () {
    $(".captcha-row").each(function () {
        var n = $(this).actual("width");
        $(this).hasClass("b") ? n > 320 && $(this).removeClass("b") : n <= 320 && $(this).addClass("b")
    })
};
checkFormWidth = function () {
    $(".form .form_left").each(function () {
        var n = $(this).parents(".form"), t = n.actual("width");
        n.hasClass("b") ? t > 417 && n.removeClass("b") : t <= 417 && n.addClass("b")
    })
};
checkFormControlWidth = function () {
    $(".form-control").each(function () {
        var t = $(this).actual("width"), i = $(this).find("label:not(.error) > span").actual("width"),
            n = $(this).find("label.error").actual("width");
        n > 0 ? $(this).hasClass("h") ? t > i + n + 5 && $(this).removeClass("h") : t <= i + n + 5 && $(this).addClass("h") : $(this).removeClass("h")
    })
};
scrollToTop = function () {
    if (arAsproOptions.THEME.SCROLLTOTOP_TYPE !== "NONE") {
        var n = !1;
        $("body").append($("<a />").addClass("scroll-to-top " + arAsproOptions.THEME.SCROLLTOTOP_TYPE + " " + arAsproOptions.THEME.SCROLLTOTOP_POSITION).attr({
            href: "#",
            id: "scrollToTop"
        }));
        arAsproOptions.THEME.SCROLLTOTOP_POSITION_BOTTOM && $("#scrollToTop").css("bottom", +arAsproOptions.THEME.SCROLLTOTOP_POSITION_BOTTOM + "px");
        arAsproOptions.THEME.SCROLLTOTOP_POSITION_RIGHT && $("#scrollToTop").css("right", +arAsproOptions.THEME.SCROLLTOTOP_POSITION_RIGHT + "px");
        $("#scrollToTop").click(function (n) {
            return n.preventDefault(), $("body, html").animate({scrollTop: 0}, 500), !1
        });
        $(window).scroll(function () {
            n || (n = !0, $(window).scrollTop() > 150 ? ($("#scrollToTop").stop(!0, !0).addClass("visible"), n = !1) : ($("#scrollToTop").stop(!0, !0).removeClass("visible"), n = !1), checkScrollToTop())
        })
    }
};
checkScrollToTop = function () {
    var n = arAsproOptions.THEME && arAsproOptions.THEME.SCROLLTOTOP_POSITION_BOTTOM ? +arAsproOptions.THEME.SCROLLTOTOP_POSITION_BOTTOM : 55;
    var i = $(window).scrollTop(), r = $(window).height(), t = 0;
    $("footer .footer-inner").length && (t = $("footer .footer-inner").offset().top);
    arAsproOptions.THEME && arAsproOptions.THEME.SCROLLTOTOP_POSITION == "CONTENT" && (warpperWidth = $("body > .wrapper > .wrapper_inner").width(), $("#scrollToTop").css("margin-left", Math.ceil(warpperWidth / 2) + 23));
    i + r > t ? $("#scrollToTop").css("bottom", Math.round(n + i + r - t) + "px") : parseInt($("#scrollToTop").css("bottom")) > n && $("#scrollToTop").css("bottom", Math.round(n))
};
CheckObjectsSizes = function () {
    $(".container iframe,.container object,.container video").each(function () {
        var n = $(this).attr("height"), t = $(this).attr("width");
        n && t && $(this).css("height", $(this).outerWidth() * n / t)
    })
};
funcDefined("reloadTopBasket") || (reloadTopBasket = function (n, t, i, r, u, f, e) {
    var o = {PARAMS: $("#top_basket_params").val(), ACTION: n};
    typeof f != "undefined" && f && (o.delete_top_item = "Y", o.delete_top_item_id = f.data("id"));
    $.post(arAsproOptions.SITE_DIR + "ajax/show_basket_actual.php", o, $.proxy(function (n) {
        $(t).html(n);
        getActualBasket("", "Compare", e);
        BX.onCustomEvent("onCompleteAction", [{action: "loadBasket"}])
    }))
});
CheckTabActive = function () {
    typeof clicked_tab && clicked_tab && window.matchMedia("(min-width: 768px)").matches && (clicked_tab--, $(".nav.nav-tabs li").each(function () {
        $(this).index() == clicked_tab && $(this).addClass("active")
    }), $(".catalog_detail .tab-content .tab-pane:eq(" + clicked_tab + ")").addClass("active"), $(".catalog_detail .tab-content .tab-pane .title-tab-heading").next().removeAttr("style"), clicked_tab = 0)
};
funcDefined("initCountdown") || (initCountdown = function () {
    $(".view_sale_block").length && $(".view_sale_block").each(function () {
        var n = $(this), i, t;
        (!n.hasClass("init-if-visible") || n.is(":visible")) && (i = n.find(".active_to").text(), t = new Date(i.replace(/(\d+)\.(\d+)\.(\d+)/, "$3/$2/$1")), n.hasClass("compact") ? n.find(".countdown").countdown({
            until: t,
            format: "dHMS",
            compact: !0,
            padZeroes: !0,
            layout: '{d<}<span class="days item">{dn}<div class="text">{dl}<\/div><\/span>{d>} <span class="hours item">{hn}<div class="text">{hl}<\/div><\/span> <span class="minutes item">{mn}<div class="text">{ml}<\/div><\/span> <span class="sec item">{sn}<div class="text">{sl}<\/div><\/span>'
        }, $.countdown.regionalOptions.ru) : n.find(".countdown").countdown({
            until: t,
            format: "dHMS",
            padZeroes: !0,
            layout: '{d<}<span class="days item">{dnn}<div class="text">{dl}<\/div><\/span>{d>} <span class="hours item">{hnn}<div class="text">{hl}<\/div><\/span> <span class="minutes item">{mnn}<div class="text">{ml}<\/div><\/span> <span class="sec item">{snn}<div class="text">{sl}<\/div><\/span>'
        }, $.countdown.regionalOptions.ru))
    })
});
funcDefined("initCountdownTime") || (initCountdownTime = function (n, t) {
    if (t) {
        var i = new Date(t.replace(/(\d+)\.(\d+)\.(\d+)/, "$3/$2/$1"));
        n.find(".countdown").countdown("destroy");
        n.hasClass("compact") ? n.find(".countdown").countdown({
            until: i,
            format: "dHM",
            compact: !0,
            padZeroes: !0,
            layout: '{d<}<span class="days item">{dn}<div class="text">{dl}<\/div><\/span>{d>} <span class="hours item">{hn}<div class="text">{hl}<\/div><\/span> <span class="minutes item">{mn}<div class="text">{ml}<\/div><\/span> <span class="sec item">{sn}<div class="text">{sl}<\/div><\/span>'
        }, $.countdown.regionalOptions.ru) : n.find(".countdown").countdown({
            until: i,
            format: "dHMS",
            padZeroes: !0,
            layout: '{d<}<span class="days item">{dnn}<div class="text">{dl}<\/div><\/span>{d>} <span class="hours item">{hnn}<div class="text">{hl}<\/div><\/span> <span class="minutes item">{mnn}<div class="text">{ml}<\/div><\/span> <span class="sec item">{snn}<div class="text">{sl}<\/div><\/span>'
        }, $.countdown.regionalOptions.ru);
        n.find(".view_sale_block").show()
    } else n.find(".view_sale_block").hide()
});
waitCounter = function (n, t, i) {
    var r = window["yaCounter" + n];
    typeof r == "object" ? typeof i == "function" && i() : setTimeout(function () {
        waitCounter(n, t, i)
    }, t)
};
var isOnceInited = insertFilter = !1, animationTime = 200, delayTime = 200, topMenuEnterTimer = !1,
    previewMode = window != window.top,
    isMobile = previewMode && window.matchMedia("(max-width:767px)").matches || window.matchMedia("(max-width:400px)").matches;
isMobile && (document.documentElement.className += " mobile");
previewMode && (document.documentElement.className += " previewMode");
navigator.userAgent.indexOf("Edge") != -1 && (document.documentElement.className += " bx-ie-edge");
funcDefined("checkVerticalMobileFilter") || (checkVerticalMobileFilter = function () {
});
funcDefined("oneClickBuy") || (oneClickBuy = function (n, t, i) {
    var r = "one_click_buy", e = 1, v = !1, u = $(i).closest(".buy_block").find(".to-cart"),
        y = $(i).closest("tr").find(".to-cart"), s;
    typeof i != "undefined" && (e = $(i).attr("data-quantity"), v = $(i).attr("data-props"));
    e < 0 && (e = 1);
    var h = u.data("props"), c = y.data("props"), o = "", l = "", a = "N", f = {}, p = u.data("iblockid"),
        w = u.attr("data-item");
    h ? o = h.split(";") : c && (o = c.split(";"));
    u.data("part_props") && (l = u.data("part_props"));
    u.data("add_props") && (a = u.data("add_props"));
    f = fillBasketPropsExt(u, "prop", u.data("bakset_div"));
    f.iblockID = p;
    f.part_props = l;
    f.add_props = a;
    f.props = JSON.stringify(o);
    f.item = w;
    f.ocb_item = "Y";
    isMobile ? (s = arAsproOptions.SITE_DIR + "form/", s += "?name=" + r + "&form_id=ocb&path=" + window.location.pathname + "&ELEMENT_ID=" + n + "&IBLOCK_ID=" + t + "&ELEMENT_QUANTITY=" + e + "&OFFER_PROPS=" + f.props, location.href = s) : $(i).hasClass("clicked") || ($(i).addClass("clicked"), $("body").find("." + r + "_frame").remove(), $("body").find("." + r + "_trigger").remove(), $("body #popup_iframe_wrapper").append('<div class="' + r + '_frame popup"><\/div>'), $("body #popup_iframe_wrapper").append('<div class="' + r + '_trigger"><\/div>'), $("." + r + "_frame").jqm({
        trigger: "." + r + "_trigger",
        onHide: function (n) {
            onHidejqm(r, n)
        },
        toTop: !1,
        onLoad: function (n) {
            onLoadjqm(r, n)
        },
        ajax: arAsproOptions.SITE_DIR + "ajax/one_click_buy.php?ELEMENT_ID=" + n + "&IBLOCK_ID=" + t + "&ELEMENT_QUANTITY=" + e + "&OFFER_PROPS=" + f.props
    }), $("." + r + "_trigger").click())
});
funcDefined("oneClickBuyBasket") || (oneClickBuyBasket = function () {
    if (name = "one_click_buy_basket", isMobile) {
        var n = arAsproOptions.SITE_DIR + "form/";
        n += "?name=" + name + "&form_id=ocb&path=" + window.location.pathname + "&buy_basket=y";
        location.href = n
    } else $(".fast_order").hasClass("clicked") || ($(".fast_order").addClass("clicked"), $("body").find("." + name + "_frame").remove(), $("body").find("." + name + "_trigger").remove(), $("body #popup_iframe_wrapper").append('<div class="' + name + '_frame popup"><\/div>'), $("body #popup_iframe_wrapper").append('<div class="' + name + '_trigger"><\/div>'), $("." + name + "_frame").jqm({
        trigger: "." + name + "_trigger",
        onHide: function (n) {
            onHidejqm(name, n)
        },
        onLoad: function (n) {
            onLoadjqm(name, n)
        },
        ajax: arAsproOptions.SITE_DIR + "ajax/one_click_buy_basket.php"
    }), $("." + name + "_trigger").click())
});
$(document).on("click", ".menu_top_block>li .more a", function () {
    $this = $(this);
    $this.parents(".dropdown").first().find(">.hidden").removeClass("hidden");
    $this.parent().addClass("hidden");
    setTimeout(function () {
        $this.parent().remove()
    }, 500)
});
$(document).on("mouseenter", ".menu_top_block.catalogfirst>li>.dropdown>li.full", function () {
    var n = $(this).find(">.dropdown");
    n.length && topMenuEnterTimer && (clearTimeout(topMenuEnterTimer), topMenuEnterTimer = !1)
});
$(document).on("mouseenter", ".menu_top_block>li:not(.full)", function () {
    var n = $(this).find(">.dropdown");
    if (n.length && !n.hasClass("visible")) {
        var r = $(this).parents(".menu"), t = r.parents(".wrap_menu"), u = t.actual("outerWidth"), f = t.offset().left,
            e = f + u, i = e - ($(this).offset().left + n.actual("outerWidth"));
        if (window.matchMedia("(min-width: 951px)").matches && $(this).hasClass("catalog") && ($(".banner_auto").hasClass("catalog_page") || $(".banner_auto").hasClass("front_page"))) return;
        i < 0 && n.css({left: i + "px"});
        n.stop().slideDown(animationTime, function () {
            n.css({height: "", overflow: "visible"})
        });
        $(this).on("mouseleave", function () {
            var t = setTimeout(function () {
                n.stop().slideUp(animationTime, function () {
                    n.css({left: ""})
                })
            }, delayTime);
            $(this).on("mouseenter", function () {
                t && (clearTimeout(t), t = !1)
            })
        })
    }
});
$(document).on("mouseenter", ".menu_top_block>li .dropdown>li", function () {
    var n = $(this), t = n.find(">.dropdown");
    if (t.length && (!n.parents(".full").length && !n.hasClass("full") || n.parents(".more").length)) {
        var f = n.parents(".menu"), u = f.parents(".wrap_menu"), r = [];
        topMenuEnterTimer = setTimeout(function () {
            var s = u.actual("outerWidth"), o = u.offset().left, h = o + s, c = n.parent(),
                f = c.hasClass("toleft") ? !0 : !1, i, e;
            f = f ? n.offset().left + n.actual("outerWidth") - t.actual("outerWidth") < o : n.offset().left + n.actual("outerWidth") + t.actual("outerWidth") > h;
            f ? n.find(">.dropdown").addClass("toleft").show() : n.find(">.dropdown").removeClass("toleft").show();
            i = t.offset().left;
            e = i + t.actual("outerWidth");
            n.parents(".dropdown").each(function () {
                var n = $(this), t = n.offset().left, u = t + n.actual("outerWidth");
                (t >= i && t < e - 1 || u > i + 1 && u <= e) && (r.push(n), n.find(">li>a").css({opacity: "0.1"}))
            })
        }, delayTime);
        n.unbind("mouseleave");
        n.on("mouseleave", function () {
            var t = setTimeout(function () {
                if (n.find(".dropdown").removeClass("toleft").hide(), r.length) for (i in r) r[i].find(">li>a").css({opacity: ""})
            }, delayTime);
            n.unbind("mouseenter");
            n.on("mouseenter", function () {
                t && (clearTimeout(t), t = !1)
            })
        })
    }
});
$(document).on("mouseenter", ".breadcrumbs .breadcrumbs__item, .hover-block .hover-block__item", function () {
    var n = $(this), t = n.find("> .breadcrumbs__dropdown-wrapper, > .hover-block__item-wrapper");
    t.velocity("stop").velocity("transition.slideUpIn", {duration: 300, delay: 100});
    n.one("mouseleave", function () {
        t.velocity("stop").velocity("fadeOut", {duration: 100})
    })
});
$(document).on("mouseenter", ".menu .mega-menu table td, .menu-row .mega-menu table td", function () {
    var i = $(this), n = i.find("> .wrap > .dropdown-menu"), t;
    i.hasClass("wide_menu") || (n.show(), CheckTopVisibleMenu());
    t = $(".wrapper1.dark-hover-overlay").length > 0;
    n.velocity("stop");
    n.css("opacity") != 0 ? (n.css("opacity", "1"), t && $(".shadow-block").css("opacity", "1")) : n.velocity("fadeIn", {
        begin: function () {
            InitMenuNavigationAim();
            CheckTopVisibleMenu()
        }, duration: 150, delay: 250, complete: function () {
            t && ($("body").addClass("menu-hovered"), $(".shadow-block").length || $('<div class="shadow-block"><\/div>').appendTo($("body")), $(".shadow-block").velocity("stop").velocity("fadeIn", 200));
            var n = $(".dropdown-menu.with_right_block .owl-carousel-hover");
            n.length && (n.removeClass("owl-carousel-hover").addClass("owl-carousel"), setTimeout(function () {
                InitOwlSlider();
                n.removeClass("loader_circle")
            }, 1))
        }
    });
    i.one("mouseleave", function () {
        n.velocity("stop").velocity("fadeOut", {
            duration: 50, delay: 300, complete: function () {
                t && $(".shadow-block").velocity("stop").velocity("fadeOut", {
                    duration: 200, complete: function () {
                        $("body").removeClass("menu-hovered")
                    }
                })
            }
        })
    })
});
$(document).on("mouseenter", ".menu-item:not(.wide_menu) .dropdown-menu .dropdown-submenu", function () {
    var t = $(this), n = t.find("> .dropdown-menu");
    n.velocity("stop");
    n.css("opacity") != 0 ? n.css("opacity", "1") : n.velocity("transition.fadeIn", {
        begin: function (n) {
            $(n).css("display", "block");
            CheckTopVisibleMenu()
        }, duration: 300, delay: 250
    });
    t.one("mouseleave", function () {
        n.velocity("stop").velocity("fadeOut", {duration: 150, delay: 300})
    })
});
/*if (typeof $.Velocity !== undefined && "RegisterEffect" in $.Velocity) {
    effects = {
        "transition.slideDownFullIn": {
            defaultDuration: 900,
            calls: [[{opacity: [1, 0], translateY: [0, "-100%"], translateZ: 0}]]
        },
        "transition.slideDownFullOut": {
            defaultDuration: 900,
            calls: [[{opacity: [.4, 1], translateY: ["-100%", 0], translateZ: 0}]]
        }
    };
    for (effectName in effects) effects.hasOwnProperty(effectName) && $.Velocity.RegisterEffect(effectName, effects[effectName])
}*/
getGridSize = function (n, t) {
    var i = 1;
    return window.matchMedia("(min-width: 1200px)").matches && (i = n[0], typeof t.data("lg_count") != "undefined" && t.data("lg_count") && $(".front.wide_page").length && (i = t.data("lg_count"))), window.matchMedia("(max-width: 1200px)").matches && (i = n[1]), window.matchMedia("(max-width: 992px)").matches && (i = n[2]), n[3] && window.matchMedia("(max-width: 600px)").matches && (i = n[3]), n[4] && window.matchMedia("(max-width: 400px)").matches && (i = n[4]), i
};
CheckFlexSlider = function () {
    $(".flexslider:not(.thmb)").each(function () {
        var n = $(this), i, t, r;
        typeof n.data("flexslider") != "undefined" && "vars" in n.data("flexslider") && (n.resize(), i = n.data("flexslider").vars.counts, typeof i != "undefined" && n.is(":visible") && (t = getGridSize(i, n), r = t != n.data("flexslider").vars.minItems || t != n.data("flexslider").vars.maxItems || t != n.data("flexslider").vars.move, r && (n.data("flexslider").vars.minItems = t, n.data("flexslider").vars.maxItems = t, n.data("flexslider").vars.move = t, n.flexslider(0), n.resize(), n.resize())))
    })
};
$.fn.mCustomScrollbarDeferred = function (n) {
    if ($(this).addClass("scroll-init"), !$(this).hasClass("destroyed")) {
        $(this).hover(function () {
            var t = $(this);
            t.hasClass("mCustomScrollbar") || $(this).hasClass("destroyed") || $(this).hasClass("mobile-scroll") || t.data("scrollTimer", setTimeout(function () {
                t.mCustomScrollbar(n);
                t.off("touchstart touchmove touchend mousewheel mouseenter mouseleave")
            }, 200))
        }, function () {
            clearTimeout($(this).data("scrollTimer"))
        });
        $(this).on("touchstart touchmove", function (t) {
            var u = $(this), r;
            if (u.hasClass("mCustomScrollbar") || $(this).hasClass("destroyed") || $(this).hasClass("mobile-scroll") || u.mCustomScrollbar(n), r = u.find(">.mCustomScrollBox>.mCSB_container"), r.length) {
                var i = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0], f = new Touch({
                    identifier: 42,
                    target: r[0],
                    clientX: i.clientX,
                    clientY: i.clientY,
                    screenX: i.screenX,
                    screenY: i.screenY,
                    pageX: i.pageX,
                    pageY: i.pageY,
                    radiusX: 1,
                    radiusY: 1
                }), e = new TouchEvent(t.type, {
                    cancelable: !0,
                    bubbles: !1,
                    composed: !0,
                    touches: [f],
                    targetTouches: [f],
                    changedTouches: [f]
                });
                r[0].dispatchEvent(e)
            }
        });
        $(this).on("touchend", function () {
            $(this).off("touchstart touchmove touchend mousewheel mouseenter mouseleave")
        });
        if ($.event.special.mousewheel) $(this).on("mousewheel", function () {
            var t = $(this);
            t.hasClass("mCustomScrollbar") || $(this).hasClass("destroyed") || $(this).hasClass("mobile-scroll") || (t.mCustomScrollbar(n), t.off("touchstart touchmove touchend mousewheel mouseenter mouseleave"))
        })
    }
};
InitScrollBar = function (n, t) {
    var i, f, u, r;
    i = typeof n == "undefined" ? $(".srollbar-custom:not(.mobile-scroll):not(.scroll-init)") : n.filter(":not(.scroll-init)");
    i.length && (i.addClass("scroll-init"), u = {
        mouseWheel: {
            scrollAmount: 150,
            preventDefault: !0
        }
    }, r = $.extend({}, u, f, i.data("plugin-options"), t), r.callbacks = {
        onScroll: function () {
            $(this).find(".mCSB_buttonLeft").hasClass("disabled") && $(this).find(".mCSB_buttonLeft").removeClass("disabled");
            $(this).find(".mCSB_buttonRight").hasClass("disabled") && $(this).find(".mCSB_buttonRight").removeClass("disabled")
        }, onTotalScrollBack: function () {
            $(this).find(".mCSB_buttonLeft").addClass("disabled")
        }, onTotalScroll: function () {
            $(this).find(".mCSB_buttonRight").addClass("disabled")
        }, onInit: function () {
            $(this).find(".mCSB_buttonLeft").addClass("disabled")
        }
    }, i.filter(":not(.scroll-deferred)").mCustomScrollbar(r), i.filter(".scroll-deferred").mCustomScrollbarDeferred(r))
};
InitCustomScrollBar = function (n) {
    var t, u, r, i;
    t = typeof n == "undefined" ? $(".scrollbar:not(.mobile-scroll):not(.scroll-init)") : n.filter(":not(.scroll-init)");
    t.length && (t.addClass("scroll-init"), r = {
        effect: "fadeIn",
        effectTime: 300,
        threshold: 0
    }, i = $.extend({}, r, u, t.data("plugin-options")), t.filter(":not(.scroll-deferred)").mCustomScrollbar(i), t.filter(".scroll-deferred").mCustomScrollbarDeferred(i))
};
InitFancyBox = function () {
    typeof $.fn.fancybox == "function" && $(".fancy").length && $(".fancy").fancybox({
        padding: [40, 40, 64, 40],
        openEffect: "fade",
        closeEffect: "fade",
        nextEffect: "fade",
        prevEffect: "fade",
        opacity: !0,
        tpl: {
            closeBtn: '<span title="' + BX.message("FANCY_CLOSE") + '" class="fancybox-item fancybox-close inline svg"><svg class="svg svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"><\/path><\/svg><\/span>',
            next: '<a title="' + BX.message("FANCY_NEXT") + '" class="fancybox-nav fancybox-next" href="javascript:;"><span><\/span><\/a>',
            prev: '<a title="' + BX.message("FANCY_PREV") + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span><\/span><\/a>'
        },
        touch: "enabled",
        buttons: ["close",],
        backFocus: !1,
        beforeShow: function () {
            var n, r, t, i, u;
            $(".cd-modal-bg").hasClass("is-visible") || BX.loadScript(arAsproOptions.SITE_TEMPLATE_PATH + "/js/aspro_animate_open_fancy.js", function () {
                var n = retrieveScale($(".cd-modal-bg"));
                $(".cd-modal-bg").show().addClass("is-visible").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                    animateLayer($(".cd-modal-bg"), n, !0)
                })
            });
            n = $(".company-block source.video-block");
            n.length && n.attr("src") == "#" && (r = n.closest("video"), t = r.clone(), t.find("source").attr("src", t.find("source").data("src")), n.attr("src", n.data("src")), t.insertAfter(r), t.siblings("video").remove());
            i = $(".company-block #company_video_iframe");
            i.length && (u = i.attr("data-src"), i.attr("src", u), i.attr("allow", "autoplay"))
        },
        afterShow: function () {
            $(".fancybox-overlay").css("opacity") == 0 && setTimeout(function () {
                $(".fancybox-overlay").css("opacity", 1);
                $("html").addClass("overflow_html")
            }, 200);
            $(".fancybox-nav").css("opacity", 0);
            setTimeout(function () {
                $(".fancybox-nav").css("opacity", 1)
            }, 150);
            $(".fancybox-inner #company_video").length ? setTimeout(function () {
                $(".fancybox-wrap video").resize();
                setTimeout(function () {
                    $(".fancybox-wrap").addClass("show_video");
                    document.getElementById("company_video").currentTime = 0;
                    document.getElementById("company_video").play()
                }, 300)
            }, 150) : $(".fancybox-wrap iframe").length && $(".fancybox-inner").height("100%")
        },
        beforeClose: function () {
            BX.loadScript(arAsproOptions.SITE_TEMPLATE_PATH + "/js/aspro_animate_open_fancy.js", function () {
                closeModal();
                $(".fancybox-overlay").fadeOut();
                $("#company_video").length && (document.getElementById("company_video").currentTime = 0);
                $("html").removeClass("overflow_html");
                var n = $(".company-block .video-block");
                n.length && $("#company_video_iframe").attr("src", "")
            })
        },
        onClosed: function () {
            $(".fancybox-wrap #company_video").length && document.getElementById("company_video").pause()
        }
    })
};
InitFancyBoxVideo = function () {
    typeof $.fn.fancybox == "function" && $(".video_link").length && $(".video_link").fancybox({
        type: "iframe",
        maxWidth: 800,
        maxHeight: 600,
        fitToView: !1,
        width: "70%",
        height: "70%",
        autoSize: !1,
        closeClick: !1,
        opacity: !0,
        tpl: {
            closeBtn: '<span title="' + BX.message("FANCY_CLOSE") + '" class="fancybox-item fancybox-close inline svg"><svg class="svg svg-close" width="14" height="14" viewBox="0 0 14 14"><path data-name="Rounded Rectangle 568 copy 16" d="M1009.4,953l5.32,5.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1008,954.4l-5.32,5.315a0.991,0.991,0,0,1-1.4-1.4L1006.6,953l-5.32-5.315a0.991,0.991,0,0,1,1.4-1.4l5.32,5.315,5.31-5.315a1,1,0,0,1,1.41,0,0.987,0.987,0,0,1,0,1.4Z" transform="translate(-1001 -946)"><\/path><\/svg><\/span>',
            next: '<a title="' + BX.message("FANCY_NEXT") + '" class="fancybox-nav fancybox-next" href="javascript:;"><span><\/span><\/a>',
            prev: '<a title="' + BX.message("FANCY_PREV") + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span><\/span><\/a>'
        },
        beforeShow: function () {
            $(".cd-modal-bg").hasClass("is-visible") || BX.loadScript(arAsproOptions.SITE_TEMPLATE_PATH + "/js/aspro_animate_open_fancy.js", function () {
                var n = retrieveScale($(".cd-modal-bg"));
                $(".cd-modal-bg").show().addClass("is-visible").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                    animateLayer($(".cd-modal-bg"), n, !0)
                })
            })
        },
        afterShow: function () {
            $(".fancybox-overlay").css("opacity") == 0 && setTimeout(function () {
                $(".fancybox-overlay").css("opacity", 1);
                $("html").addClass("overflow_html")
            }, 200);
            $(".fancybox-nav").css("opacity", 0);
            setTimeout(function () {
                $(".fancybox-nav").css("opacity", 1)
            }, 150);
            $(".fancybox-wrap iframe").length && $(".fancybox-inner").height("100%")
        },
        beforeClose: function () {
            BX.loadScript(arAsproOptions.SITE_TEMPLATE_PATH + "/js/aspro_animate_open_fancy.js", function () {
                closeModal();
                $(".fancybox-overlay").fadeOut();
                $("html").removeClass("overflow_html")
            })
        }
    })
};
InitStickySideBar = function (n, t) {
    var i = ".sticky-sidebar", u = ".wraps .wrapper_inner .container_inner .main-catalog-wrapper",
        r = ".wraps .wrapper_inner .container_inner";
    typeof n != "undefined" && (i = n);
    $(u).length && (r = u);
    typeof t != "undefined" && (r = t);
    $(i).length && arAsproOptions.THEME.STICKY_SIDEBAR != "N" && (typeof stickySidebar != "undefined" && window.stickySidebar.destroy(), window.stickySidebar = new StickySidebar(i, {
        topSpacing: 60,
        bottomSpacing: 20,
        containerSelector: r,
        resizeSensor: !0,
        innerWrapperSelector: ".sticky-sidebar__inner"
    }), $(".sticky-sidebar .sticky-sidebar__inner .banner img").length && $(".sticky-sidebar .sticky-sidebar__inner .banner img").load(function () {
        typeof stickySidebar != "undefined" && window.stickySidebar.updateSticky()
    }))
};
InitOwlSlider = function () {
    typeof $.fn.owlCarousel == "function" && $(".owl-carousel:not(.owl-loaded):not(.appear-block)").each(function () {
        var n = $(this), f,
            r = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6.969" viewBox="0 0 12 6.969"><path id="Rounded_Rectangle_702_copy_24" data-name="Rounded Rectangle 702 copy 24" class="cls-1" d="M361.691,401.707a1,1,0,0,1-1.414,0L356,397.416l-4.306,4.291a1,1,0,0,1-1.414,0,0.991,0.991,0,0,1,0-1.406l5.016-5a1.006,1.006,0,0,1,1.415,0l4.984,5A0.989,0.989,0,0,1,361.691,401.707Z" transform="translate(-350 -395.031)"/><\/svg>',
            e = {navText: ['<i class="svg left colored_theme_hover_text">' + r + "<\/i>", '<i class="svg right colored_theme_hover_text">' + r + "<\/i>",]},
            t = $.extend({}, e, f, n.data("plugin-options")), i, u;
        n.on("initialized.owl.carousel", function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSliderInitialized", [t]);
            $(n.target).removeClass("loading-state");
            $(n.target).find(".owl-item:first").addClass("current");
            $(n.target).hasClass("catalog_block") && typeof sliceItemBlockSlide == "function" && sliceItemBlockSlide();
            typeof stickySidebar != "undefined" && window.stickySidebar.updateSticky()
        });
        console.log("config owl");
        console.log(t);
        n.owlCarousel(t);
        n.on("change.owl.carousel", function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideChange", [t])
        });
        n.on("resized.owl.carousel", function () {
            typeof sliceItemBlockSlide == "function" && sliceItemBlockSlide({resize: !1})
        });
        n.on("changed.owl.carousel", function (n) {
            var f = {slider: n}, u, i, r, t;
            BX.onCustomEvent("onSlideChanged", [f]);
            if ($(n.target).data("pluginOptions") && ("index" in $(n.target).data("pluginOptions") && $(".switch-item-block").length && $(".switch-item-block__count-wrapper--big .switch-item-block__count-value").text(n.item.index + 1 + "/" + n.item.count), "relatedTo" in $(n.target).data("pluginOptions") && (u = $(n.target).data("pluginOptions").relatedTo, i = $(u), i.length && $(n.target).data("owl.carousel")))) {
                $(n.target).data("owl.carousel").loop ? (r = n.item.count - 1, t = Math.round(n.item.index - n.item.count / 2 - .5), t < 0 && (t = r), t > r && (t = 0)) : t = n.item.index;
                i.find(".owl-item").removeClass("current").eq(t).addClass("current");
                var e = i.find(".owl-item.active").length - 1, o = i.find(".owl-item.active").first().index(),
                    s = i.find(".owl-item.active").last().index();
                t > s && i.data("owl.carousel").to(t, 100, !0);
                t < o && i.data("owl.carousel").to(t - e, 100, !0)
            }
        });
        n.on("translated.owl.carousel", function () {
        });
        if ("clickTo" in t) {
            i = t.clickTo;
            u = "magnifier" in t;
            n.on("click", ".owl-item", function (n) {
                n.preventDefault();
                var t = $(this), r = t.index();
                if (u) {
                    const n = $(i).closest(".product-container");
                    if (n.find(".zoom_picture").length) {
                        const i = n.find(".zoom_picture");
                        i.attr("data-large", t.find(".product-detail-gallery__item").data("big"));
                        i.attr("xoriginal", t.find(".product-detail-gallery__item").data("big"));
                        i.attr("src", t.find(".product-detail-gallery__item img").attr("src"));
                        n.find(".product-detail-gallery__link").attr("href", t.find(".product-detail-gallery__item img").attr("src"))
                    }
                    t.siblings("").removeClass("current");
                    t.addClass("current")
                } else $(i).data("owl.carousel").to(r, 300, !0)
            })
        }
    })
};
InitFlexSlider = function () {
    typeof $.fn.flexslider == "function" && $(".flexslider:not(.thmb):not(.flexslider-init):not(.appear-block)").each(function () {
        var t = $(this), i, n = $.extend({}, {
            animationLoop: !1,
            controlNav: !1,
            keyboard: !1,
            pauseOnAction: !1,
            pauseInvisible: !1,
            directionNav: !0,
            useCSS: !1,
            animation: "slide"
        }, i, t.data("plugin-options"));
        !t.parent().hasClass("top_slider_wrapp") && t.is(":visible") && (typeof n.counts != "undefined" && n.direction !== "vertical" && (n.maxItems = getGridSize(n.counts, t), n.minItems = getGridSize(n.counts, t), n.itemWidth = 200), typeof n.move == "undefined" && (n.move = 1), n.start = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideInit", [t])
        }, n.after = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideComplete", [t])
        }, n.end = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideEnd", [t])
        }, t.flexslider(n).addClass("flexslider-init"), n.controlNav && t.addClass("flexslider-control-nav"), n.directionNav && t.addClass("flexslider-direction-nav"))
    })
};
InitFlexSliderByClass = function (n) {
    if (!n.hasClass("flexslider-init")) {
        var i = n, r, t = $.extend({}, {
            animationLoop: !1,
            controlNav: !1,
            keyboard: !1,
            pauseOnAction: !1,
            pauseInvisible: !1,
            directionNav: !0,
            useCSS: !1,
            animation: "slide"
        }, r, i.data("plugin-options"));
        !i.parent().hasClass("top_slider_wrapp") && i.is(":visible") && (typeof t.counts != "undefined" && t.direction !== "vertical" && (t.maxItems = getGridSize(t.counts, i), t.minItems = getGridSize(t.counts, i), t.itemWidth = 200), typeof t.move == "undefined" && (t.move = 1), t.start = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideInit", [t])
        }, t.after = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideComplete", [t])
        }, t.end = function (n) {
            var t = {slider: n};
            BX.onCustomEvent("onSlideEnd", [t])
        }, i.flexslider(t).addClass("flexslider-init"), t.controlNav && i.addClass("flexslider-control-nav"), t.directionNav && i.addClass("flexslider-direction-nav"))
    }
};
inIframe = function () {
    try {
        return window.self !== window.top
    } catch (n) {
        return !0
    }
};
InitZoomPict = function (n) {
    var t = $(".zoom_picture");
    if (typeof n != "undefined" && (t = n), t.length) {
        var i = t, r, u = $.extend({}, {
            title: !0,
            scroll: !1,
            Xoffset: 15,
            tint: "#333",
            defaultScale: -1
        }, r, i.data("plugin-options"));
        i.xzoom(u);
        t.on("mouseleave", function () {
            t.data("xzoom").movezoom(event)
        })
    }
};
arBasketAsproCounters = arStatusBasketAspro = arBasketPrices = {};
SetActualBasketFlyCounters = function (n) {
    arBasketAsproCounters.DEFAULT == !0 ? $.ajax({
        url: arAsproOptions.SITE_DIR + "ajax/basket_fly.php",
        type: "post",
        success: function (t) {
            $("#basket_line .basket_fly").removeClass("loaded").html(t);
            typeof n != "undefined" && $.ajax({
                type: "GET",
                url: arAsproOptions.SITE_DIR + "ajax/actualBasket.php",
                success: function (n) {
                    $(".js_ajax").length || $("body").append('<div class="js_ajax"><\/div>');
                    $(".js_ajax").html(n);
                    setBasketStatusBtn(!0)
                }
            })
        }
    }) : ($(".basket_fly .opener .basket_count .count").attr("class", "count" + (arBasketAsproCounters.READY.COUNT > 0 ? "" : " empty_items")).find(".items span").text(arBasketAsproCounters.READY.COUNT), $(".basket_fly .opener .basket_count + a").attr("href", arBasketAsproCounters.READY.HREF), $(".basket_fly .opener .basket_count").attr("title", $("<div/>").html(arBasketAsproCounters.READY.TITLE).text()).attr("class", "colored_theme_hover_text basket_count small clicked" + (arBasketAsproCounters.READY.COUNT > 0 ? "" : " empty")), $(".basket_fly .opener .wish_count .count").attr("class", "count" + (arBasketAsproCounters.DELAY.COUNT > 0 ? "" : " empty_items")).find(".items span").text(arBasketAsproCounters.DELAY.COUNT), $(".basket_fly .opener .wish_count + a").attr("href", arBasketAsproCounters.DELAY.HREF), $(".basket_fly .opener .wish_count").attr("title", $("<div/>").html(arBasketAsproCounters.DELAY.TITLE).text()).attr("class", "colored_theme_hover_text wish_count small clicked" + (arBasketAsproCounters.DELAY.COUNT > 0 ? "" : " empty")), $(".basket_fly .opener .compare_count .wraps_icon_block").attr("class", "wraps_icon_block compare" + (arBasketAsproCounters.COMPARE.COUNT > 0 ? "" : " empty_block")), $(".basket_fly .opener .compare_count .count").attr("class", "count" + (arBasketAsproCounters.COMPARE.COUNT > 0 ? "" : " empty_items")).find(".items span").text(arBasketAsproCounters.COMPARE.COUNT), $(".basket_fly .opener .compare_count + a").attr("href", arBasketAsproCounters.COMPARE.HREF), updateBottomIconsPanel(arBasketAsproCounters))
};
CheckHeaderFixed = function () {
    var l = $("header, body.simple_basket_mode #header").first(),
        i = $("#headerfixed, body.simple_basket_mode #header"), f = $("body.simple_basket_mode #header"), n, t;
    if (i.length && l.length) {
        var e = !1, a = i.actual("outerHeight"), v = l.actual("outerHeight"), h = v - a,
            b = $(".btn.btn-responsive-nav"), c = $("#panel:visible").actual("outerHeight"),
            y = $(".TOP_HEADER").first(), r = i.find("[data-nlo]"), p = !r.length, w;
        h <= 0 && (h = 0);
        y.length && (c += y.actual("outerHeight"));
        $(window).scroll(w = function () {
            var n = $(".product-item-detail-tabs-container-fixed"), o;
            if (window.matchMedia("(min-width:992px)").matches) {
                var t = $(window).scrollTop(), l = $(".search-wrapper .search-input:visible"),
                    s = $(".ordered-block .nav.nav-tabs"), u = !b.is(":visible");
                e || u && t > v + c && (p ? (e = !0, f.length && (headerSimpleHeight = f.actual("outerHeight"), f.closest(".header_wrap").css({"margin-top": headerSimpleHeight})), i.addClass("fixed"), $("nav.mega-menu.sliced.initied").removeClass("initied"), CheckTopMenuDotted()) : r.hasClass("nlo-loadings") || (r.addClass("nlo-loadings"), setTimeout(function () {
                    $.ajax({
                        data: {nlo: r.attr("data-nlo")}, success: function (n) {
                            pauseYmObserver();
                            p = !0;
                            r[0].insertAdjacentHTML("beforebegin", $.trim(n));
                            r.remove();
                            InitMenuNavigationAim();
                            w();
                            setTimeout(resumeYmObserver, 400)
                        }, error: function () {
                            r.removeClass("nlo-loadings")
                        }
                    })
                }, 300)));
                (e || !u) && (!u || t <= h + c) && (e = !1, i.removeClass("fixed"), f.length && f.closest(".header_wrap").css({"margin-top": ""}));
                n.length && s.length && (o = $(".ordered-block .nav.nav-tabs").offset(), t + a > o.top ? (n.css({top: i.actual("outerHeight") + 1}), n.addClass("fixed"), i.addClass("tabs-fixed")) : n.hasClass("fixed") && (n.removeAttr("style"), n.removeClass("fixed"), i.removeClass("tabs-fixed")))
            }
        })
    }
    if (n = $("body.simple_basket_mode .wrapper1.mfixed_Y #header"), t = n.length ? n : $(".wrapper1.mfixed_Y #mobileheader"), t.length && isMobile) {
        var o = !1, u = t.actual("outerHeight"), s = $("#panel:visible").actual("outerHeight"),
            k = $(".wrapper1").hasClass("mfixed_view_scroll_top");
        $(window).scroll(function () {
            var i = $(window).scrollTop();
            window.matchMedia("(max-width:991px)").matches ? k ? (i > startScroll ? $("#mobilePhone.show").length || (t.removeClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": ""})) : i > u + s ? (t.addClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": u})) : i <= u + s && (t.removeClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": ""})), startScroll = i) : o ? o && i <= u + s && (o = !1, t.removeClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": ""})) : i > u + s && (o = !0, t.addClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": u})) : (t.removeClass("fixed"), n.length && n.closest(".header_wrap").css({"margin-top": ""}))
        })
    }
};
CheckHeaderFixedMenu = function () {
    if (arAsproOptions.THEME && arAsproOptions.THEME.HEADER_FIXED == 2 && $("#headerfixed .js-nav").length && window.matchMedia("(min-width: 992px)").matches) {
        $("#headerfixed .js-nav").css("width", "0");
        var n = 0, t = $("#headerfixed .maxwidth-theme").actual("width"),
            i = $("#headerfixed .logo-row.v2 .menu-block").actual("outerWidth") - $("#headerfixed .logo-row.v2 .menu-block").actual("width");
        $("#headerfixed .logo-row.v2 > .inner-table-block").each(function () {
            $(this).hasClass("menu-block") || (n += $(this).actual("outerWidth"))
        });
        $("#headerfixed .js-nav").width(t - n - i)
    }
};
CheckSearchWidth = function () {
    if ($(".logo_and_menu-row .search_wrap").length) {
        var t = $(".logo_and_menu-row .search_wrap").position().left,
            n = $(".logo_and_menu-row .maxwidth-theme").width() - 2;
        width = 0;
        $(".logo_and_menu-row .subtop .search_wrap").length ? (n = $(".logo_and_menu-row .subtop").width() - 2, $(".logo_and_menu-row .subtop > .row >div >div").each(function () {
            if (!$(this).hasClass("search_wrap")) {
                var t = $(this).outerWidth();
                $(this).is(":visible") && $(this).height() || (t = 0);
                width = width ? width - t : n - t
            }
        }).promise().done(function () {
            $(".logo_and_menu-row .search_wrap.wide_search").length ? $(".logo_and_menu-row .search_wrap .search-block").outerWidth(width) : $(".logo_and_menu-row .search_wrap").outerWidth(width);
            $(".logo_and_menu-row .search_wrap").css({opacity: 1, visibility: "visible"})
        })) : $(".logo_and_menu-row .subbottom .search_wrap").length ? (n = $(".logo_and_menu-row .subbottom").width() - 2, $(".logo_and_menu-row .subbottom >div").each(function () {
            if (!$(this).hasClass("search_wrap")) {
                var t = $(this).outerWidth();
                $(this).is(":visible") && $(this).height() || (t = 0);
                width = width ? width - t : n - t
            }
        }).promise().done(function () {
            $(".logo_and_menu-row .search_wrap.wide_search").length ? $(".logo_and_menu-row .search_wrap .search-block").outerWidth(width) : $(".logo_and_menu-row .search_wrap").outerWidth(width);
            $(".logo_and_menu-row .search_wrap").css({opacity: 1, visibility: "visible"})
        })) : $(".logo_and_menu-row .maxwidth-theme > .row >div >div").each(function () {
            if (!$(this).hasClass("search_wrap")) {
                var t = $(this).outerWidth();
                $(this).is(":visible") && $(this).height() || (t = 0);
                width = width ? width - t : n - t
            }
        }).promise().done(function () {
            $(".logo_and_menu-row .search_wrap.wide_search").length ? $(".logo_and_menu-row .search_wrap .search-block").outerWidth(width) : $(".logo_and_menu-row .search_wrap").outerWidth(width);
            $(".logo_and_menu-row .search_wrap").css({opacity: 1, visibility: "visible"})
        })
    }
};
lazyLoadPagenBlock = function () {
    setTimeout(function () {
        $(".with-load-block .ajax_load_btn:not(.appear-block)").length && $(".with-load-block .ajax_load_btn:not(.appear-block)").appear(function () {
            var n = $(this);
            n.addClass("appear-block").trigger("click")
        }, {accX: 0, accY: 200})
    }, 200)
};
scrollPreviewBlock = function () {
    if (typeof $.cookie("scroll_block") != "undefined" && $.cookie("scroll_block")) {
        var n = $($.cookie("scroll_block"));
        n.length && $("body, html").animate({scrollTop: n.offset().top}, 500);
        $.cookie("scroll_block", null)
    }
};
scrollToBlock = function (n) {
    if ($(n).length) {
        var t = $(n).offset().top;
        typeof $(n).data("toggle") != "undefined" && $(n).click();
        typeof $(n).data("offset") != "undefined" && (t += $(n).data("offset"));
        $("body, html").animate({scrollTop: t}, 500)
    }
};
checkMenuLines = function () {
    if ($(".front_page .menu-row .left_border").length || $(".front_page .menu-row .right_border").length) {
        var n = $(".centered .menu-row .mega-menu table").length ? $(".centered .menu-row .mega-menu table").offset().left : 0,
            t = $("body").hasClass("with_decorate") && window.matchMedia("(min-width: 1100px)").matches ? 126 : 7;
        $(".menu-row .left_border, .menu-row .right_border").css("width", n - t)
    }
};
SetFixedAskBlock = function () {
    var u;
    if ($(".ask_a_question_wrapper").length) {
        var f = $(".ask_a_question_wrapper").offset(), t = 0, n = $(".ask_a_question_wrapper").find(".ask_a_question"),
            r = BX.pos(n[0]), e = r.bottom - r.top, i = $("#headerfixed").height() + 20;
        $("footer").length && (t = $("footer").offset().top);
        $(".banner.CONTENT_BOTTOM").length && (t = $(".banner.CONTENT_BOTTOM").offset().top);
        e + i + documentScrollTopLast + 130 > t ? (n.removeClass("fixed").css({
            top: "auto",
            width: "auto",
            bottom: 0
        }), n.parent().css("position", "static"), n.parent().parent().css("position", "static")) : (n.parent().removeAttr("style"), n.parent().parent().removeAttr("style"), documentScrollTopLast + i > f.top ? (u = $(".fixed_block_fix").width(), n.addClass("fixed").css({
            top: i,
            bottom: "auto"
        }), u && n.css({width: $(".fixed_block_fix").width()})) : n.removeClass("fixed").css({top: 0, width: "auto"}))
    }
};
MegaMenuFixed = function () {
    var t = 150, n = $(".mega_fixed_menu").find("[data-nlo]");
    $("header .burger, #headerfixed .burger").on("click", function () {
        n.length && (n.hasClass("nlo-loadings") || (n.addClass("nlo-loadings"), setTimeout(function () {
            $.ajax({
                data: {nlo: n.attr("data-nlo")}, success: function (t) {
                    n[0].insertAdjacentHTML("beforebegin", $.trim(t));
                    n.remove()
                }, error: function () {
                    n.removeClass("nlo-loadings")
                }
            })
        }, 300)));
        $(".mega_fixed_menu").fadeIn(t)
    });
    $(".mega_fixed_menu .svg.svg-close").on("click", function () {
        $(this).closest(".mega_fixed_menu").fadeOut(t)
    });
    $(".mega_fixed_menu .dropdown-menu .arrow").on("click", function (n) {
        n.preventDefault();
        n.stopPropagation();
        $(this).closest(".dropdown-submenu").find(".dropdown-menu").slideToggle(t);
        $(this).closest(".dropdown-submenu").addClass("opened")
    })
};
CheckPopupTop = function () {
};
AjaxClickLink = function (n) {
    var t = "", i = $(".js-load-wrapper"), r = $(".js-load-wrapper").find(".ajax_load"), e = "", f, u;
    url = "";
    "preventDefault" in n ? (n.preventDefault(), t = $(n.target).hasClass("js-load-link") ? $(n.target) : $(n.target).closest(".js-load-link")) : (t = $(n), e = "Y");
    i.length && (f = parseUrlQuery(), u = {
        ajax_get_filter: "Y",
        control_ajax: "Y"
    }, u.bitrix_include_areas = "N", "clear_cache" in f && f.clear_cache == "Y" && (u.clear_cache = "Y"), r.length ? r.addClass("loading-state") : i.addClass("loading-state"), t.data("url") && (url = t.data("url")), t.data("click_block") && $(t.data("click_block")).length && $(t.data("click_block")).data("url") && (url = $(t.data("click_block")).data("url")), e && (BX.PopupWindowManager.getCurrentPopup().close(), $(".bx_filter_select_popup ul li .sort_btn").removeClass("current"), t.addClass("current"), t.closest(".bx_filter_block").find(".bx_filter_select_text").text(t.text())), $(".bx_filter .bx_sort_filter .bx_filter_select_text").text(t.text()), $(".bx_filter .bx_sort_filter .bx_filter_select_popup ul li span.current").removeClass("current"), $(".bx_filter .bx_sort_filter .bx_filter_select_popup ul li").eq(t.parent().index()).find("span").addClass("current"), $.ajax({
        url: url,
        data: u,
        success: function (n) {
            i.html(n);
            r.length ? r.removeClass("loading-state") : i.removeClass("loading-state");
            initAnimateLoad();
            BX.onCustomEvent("onCompleteAction", [{action: "jsLoadBlock"}, t]);
            InitCustomScrollBar();
            InitScrollBar();
            window.FilterHelper !== undefined && (FilterHelper.resultDiv = $("#filter-helper"), FilterHelper.show())
        }
    }))
};
initCalculatePreview = function () {
    $(".calculate-delivery.with_preview:not(.inited)").each(function () {
        var t = $(this), n = t.find("span[data-event=jqm]"), i = t.find(".calculate-delivery-preview");
        t.addClass("inited");
        t.appear(function () {
            var u, f, r;
            n.length && (typeof window["calculate-delivery-preview-index"] == "undefined" ? window["calculate-delivery-preview-index"] = 1001 : ++window["calculate-delivery-preview-index"], u = n.attr("data-param-product_id") * 1, f = n.attr("data-param-quantity") * 1, u > 0 && (r = window["calculate-delivery-preview-index"], n.data({areaIndex: r}), $.ajax({
                url: arAsproOptions.SITE_DIR + "ajax/delivery.php",
                type: "POST",
                data: {is_preview: "Y", index: r, product_id: u, quantity: f},
                beforeSend: function () {
                    t.addClass("loadings")
                },
                success: function (t) {
                    var u = n.data("areaIndex");
                    typeof u != "undefined" && u == r && (n.hide(), i.html(t), i.find(".catalog-delivery-preview").length || (i.empty(), n.show()))
                },
                error: function () {
                },
                complete: function () {
                    var i = n.data("areaIndex");
                    typeof i != "undefined" && i == r && t.removeClass("loadings")
                }
            })))
        }, {accX: 0, accY: 0})
    })
};
funcDefined("setPriceItem") || (setPriceItem = function (n, t, i, r, u, f, e) {
    var c = n.find(".to-cart").attr("data-ratio"),
        s = typeof i != "undefined" && i ? i : n.find(".to-cart").attr("data-value"),
        h = n.find(".to-cart").attr("data-currency"),
        o = '<div class="total_summ" style="display:none;"><div>' + BX.message("TOTAL_SUMM_ITEM") + "<span><\/span><\/div><\/div>",
        a = n.find(".cost.prices"), v = typeof f != "undefined" && f == "Y", y = typeof e != "undefined" && e,
        p = n.find(".has_offer_prop").length ? "Y" : "N", l = typeof r != "undefined" && r;
    n.find(".counter_wrapp + .wrapp-one-click").length ? n.find(".wrapp-one-click .total_summ").length || u || $(o).appendTo(n.find(".counter_wrapp + .wrapp-one-click")) : n.find(".buy_block").length ? n.find(".buy_block .total_summ").length || u || $(o).appendTo(n.find(".buy_block")) : n.find(".counter_wrapp").length && (n.find(".counter_wrapp .total_summ").length || u || $(o).appendTo(n.find(".counter_wrapp:first")));
    n.find(".total_summ").length && (s && h ? 1 == t && c == t || typeof u != "undefined" && u && !l ? n.find(".total_summ").slideUp(50) : (n.find(".total_summ span").html(BX.Currency.currencyFormat(s * t, h, !0)), n.find(".total_summ").is(":hidden") && n.find(".total_summ").slideDown(100)) : n.find(".total_summ").slideUp(100))
});
funcDefined("getCurrentPrice") || (getCurrentPrice = function (n, t, i) {
    var r = BX.Currency.currencyFormat(n, t);
    return i.indexOf(r) >= 0 ? i.replace(r, '<span class="price_value">' + r + '<\/span><span class="price_currency">') + "<\/span>" : i
});
funcDefined("initAnimateLoad") || (initAnimateLoad = function () {
    $(".animate-load").click(function () {
        //jQuery.browser.mobile || $(this).parent().addClass("loadings")
    })
});
funcDefined("showBasketShareBtn") || (showBasketShareBtn = function () {
    var n, i, t, r, u, f;
    arAsproOptions.THEME.SHOW_SHARE_BASKET === "Y" && (document.querySelector(".basket-checkout-block-btns") || (n = document.querySelector(".basket-checkout-section-inner"), n && (i = BX.create({
        tag: "div",
        attrs: {"class": "basket-checkout-block basket-checkout-block-btns"},
        html: '<div class="basket-checkout-block-btns-wrap"><\/div>'
    }), BX.insertAfter(i, BX.lastChild(n)), t = i.querySelector(".basket-checkout-block-btns-wrap"), r = n.querySelector(".basket-checkout-block-btn"), r && t.appendChild(r), u = n.querySelector(".fastorder"), u && t.appendChild(u), $(".basket-btn-checkout").length && !$(".basket-btn-checkout").hasClass("disabled") && (f = BX.create({
        tag: "div",
        attrs: {
            "class": "basket-checkout-block basket-checkout-block-share colored_theme_hover_bg-block",
            title: arAsproOptions.THEME.EXPRESSION_FOR_SHARE_BASKET
        },
        html: '<span class="animate-load" data-event="jqm" data-param-form_id="share_basket" data-name="share_basket"><i class="svg colored_theme_hover_bg-el-svg"><svg class="svg svg-share" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"><path data-name="Ellipse 223 copy 8" d="M1613,203a2.967,2.967,0,0,1-1.86-.661l-3.22,2.01a2.689,2.689,0,0,1,0,1.3l3.22,2.01A2.961,2.961,0,0,1,1613,207a3,3,0,1,1-3,3,3.47,3.47,0,0,1,.07-0.651l-3.21-2.01a3,3,0,1,1,0-4.678l3.21-2.01A3.472,3.472,0,0,1,1610,200,3,3,0,1,1,1613,203Zm0,8a1,1,0,1,0-1-1A1,1,0,0,0,1613,211Zm-8-7a1,1,0,1,0,1,1A1,1,0,0,0,1605,204Zm8-5a1,1,0,1,0,1,1A1,1,0,0,0,1613,199Z" transform="translate(-1602 -197)" fill="#B8B8B8"><\/path><\/svg><\/i><span class="title">' + arAsproOptions.THEME.EXPRESSION_FOR_SHARE_BASKET + "<\/span><\/span>"
    }), t.appendChild(f), initAnimateLoad()))))
});
funcDefined("showBasketHeadingBtn") || (showBasketHeadingBtn = function () {
    var n, t, i;
    document.querySelector(".page-top h1") && (n = document.querySelector(".page-top .topic .topic__heading"), n && (arAsproOptions.THEME.SHOW_BASKET_PRINT === "Y" && (document.querySelector(".btn_basket_heading--print") || (t = BX.create({
        tag: "div",
        attrs: {
            "class": "btn_basket_heading btn_basket_heading--print print-link colored_theme_hover_bg-block",
            title: arAsproOptions.THEME.EXPRESSION_FOR_PRINT_PAGE
        },
        html: '<i class="svg colored_theme_hover_bg-el-svg"><svg class="svg svg-print" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Rectangle_665_copy_4" data-name="Rectangle 665 copy 4" class="cls-print" d="M1570,210h-2v3h-8v-3h-2a2,2,0,0,1-2-2v-5a2,2,0,0,1,2-2h2v-4h8v4h2a2,2,0,0,1,2,2v5A2,2,0,0,1,1570,210Zm-8,1h4v-4h-4v4Zm4-12h-4v2h4v-2Zm4,4h-12v5h2v-3h8v3h2v-5Z" transform="translate(-1556 -197)"><\/path><\/svg><\/i>'
    }), BX.insertBefore(t, n))), $(".basket-btn-checkout").length && !$(".basket-btn-checkout").hasClass("disabled") ? arAsproOptions.THEME.SHOW_DOWNLOAD_BASKET === "Y" && (document.querySelector(".btn_basket_heading--download") || (i = BX.create({
        tag: "div",
        attrs: {
            "class": "btn_basket_heading btn_basket_heading--with_title btn_basket_heading--download colored_theme_hover_bg-block",
            title: arAsproOptions.THEME.EXPRESSION_FOR_DOWNLOAD_BASKET
        },
        events: {
            click: BX.proxy(function (n) {
                n || (n = window.event);
                BX.PreventDefault(n);
                var t = n.target.closest(".btn_basket_heading");
                if (t) {
                    if (BX.hasClass(t, "loadings")) return;
                    BX.addClass(t, "loadings");
                    setTimeout(function () {
                        BX.removeClass(t, "loadings")
                    }, 2e3)
                }
                location.href = "/ajax/download_basket.php?params[type]=" + arAsproOptions.THEME.BASKET_FILE_DOWNLOAD_TEMPLATE
            }, this)
        },
        html: '<i class="svg colored_theme_hover_bg-el-svg"><svg class="svg" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 14H14L14 6H11H10V5V2H5V6H7H9V8V10V12H7H5V14ZM13.6716 4L12 2.32843V4H13.6716ZM6 8H7V10H6H5H3H2V8H3H5H6ZM3 6H2H0V8V10V12H2H3V14V16H5H14H16V14V4.32843C16 3.79799 15.7893 3.28929 15.4142 2.91421L13.0858 0.585786C12.7107 0.210714 12.202 0 11.6716 0H5H3V2V6Z" fill="#B8B8B8"/><\/svg><\/i><span class="title">' + arAsproOptions.THEME.EXPRESSION_FOR_DOWNLOAD_BASKET + "<\/span>"
    }), BX.insertBefore(i, n))) : (BX.remove(document.querySelector(".btn_basket_heading--send2email")), BX.remove(document.querySelector(".btn_basket_heading--download")))))
});
$(window).on("load", function () {
    CheckSearchWidth()
});
$(document).ready(function () {
    var e, r, l, o, n, u, y, a, t, s, h, i;
    if (MegaMenuFixed(), InitScrollBar(),
    arAsproOptions.PAGES.ORDER_PAGE && (e = parseUrlQuery(), "ORDER_ID" in e)) {
        if (r = e.ORDER_ID, arAsproOptions.COUNTERS.USE_FULLORDER_GOALS !== "N") {
            l = {goal: "goal_order_success", result: r};
            BX.onCustomEvent("onCounterGoals", [l])
        }
        if (checkCounters() && typeof localStorage != "undefined") {
            o = localStorage.getItem("gtm_e_" + r);
            n = "";
            try {
                n = JSON.parse(o)
            } catch (p) {
                n = o
            }
            typeof n == "object" && (window.dataLayer = window.dataLayer || [], dataLayer.push({
                event: arAsproOptions.COUNTERS.GOOGLE_EVENTS.PURCHASE,
                ecommerce: n
            }));
            typeof localStorage != "undefined" && localStorage.removeItem("gtm_e_" + r)
        }
    }
    u = !1;
    //typeof jQuery.browser == "object" ? u = jQuery.browser.safari : typeof browser == "object" && (u = browser.safari);
    u ? setTimeout(function () {
        $(window).resize();
        setTimeout(function () {
            CheckTopMenuPadding();
            CheckTopMenuOncePadding();
            CheckTopMenuDotted();
            CheckHeaderFixed();
            checkMenuLines();
            setTimeout(function () {
                $(window).scroll()
            }, 50)
        }, 50)
    }, 350) : (CheckTopMenuPadding(), CheckTopMenuOncePadding(), CheckTopMenuDotted(), CheckHeaderFixed(), checkMenuLines());
    window.matchMedia("(max-width: 767px)").matches && ($(".bx_filter .scrollbar").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .srollbar-custom").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .bx_filter_section form .bx_filter_parameters").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .mobile-scroll.scrollbar").length && $(".bx_filter .mobile-scroll.scrollbar").mCustomScrollbar("destroy"), $(".bx_filter .mobile-scroll.srollbar-custom").length && $(".bx_filter .mobile-scroll.srollbar-custom").mCustomScrollbar("destroy"));
    arAsproOptions.THEME.USE_DEBUG_GOALS === "Y" ? $.cookie("_ym_debug", 1, {path: "/"}) : $.cookie("_ym_debug", null, {path: "/"});
    $("#headerfixed .js-nav").length && (arAsproOptions.THEME.HEADER_FIXED == 2 && CheckHeaderFixedMenu(), setTimeout(function () {
        $("#headerfixed .js-nav").addClass("opacity1")
    }, 350));
    $(".instagram_ajax").length ? BX.addCustomEvent("onCompleteAction", function (n) {
        n.action === "instagrammLoaded" && scrollPreviewBlock()
    }) : scrollPreviewBlock();
    scrollToTop();
    checkVerticalMobileFilter();
    $("[data-scroll-block]").click(function () {
        var t = $(this), n;
        t.data("scrollBlock") && (n = $(t.data("scrollBlock")), n.length && scroll_block(n))
    });
    $.extend($.validator.messages, {
        required: BX.message("JS_REQUIRED"),
        email: BX.message("JS_FORMAT"),
        equalTo: BX.message("JS_PASSWORD_COPY"),
        minlength: BX.message("JS_PASSWORD_LENGTH"),
        remote: BX.message("JS_ERROR")
    });
    $.validator.addMethod("regexp", function (n, t, i) {
        var r = new RegExp(i);
        return this.optional(t) || r.test(n)
    }, BX.message("JS_FORMAT"));
    $.validator.addMethod("filesize", function (n, t, i) {
        return this.optional(t) || t.files[0].size <= i
    }, BX.message("JS_FILE_SIZE"));
    $.validator.addMethod("date", function (n) {
        var r = !1, u, t, i;
        return !n || n.length <= 0 ? r = !1 : (u = new RegExp("^([0-9]{4})(.)([0-9]{2})(.)([0-9]{2})$"), t = u.exec(n), t ? (i = new Date(t[1], t[3] - 1, t[5]), r = i.getMonth() == t[3] - 1 && i.getDate() == t[5] && i.getFullYear() == t[1]) : (u = new RegExp("^([0-9]{2})(.)([0-9]{2})(.)([0-9]{4})$"), t = u.exec(n), t && (i = new Date(t[5], t[3] - 1, t[1]), r = i.getMonth() == t[3] - 1 && i.getDate() == t[1] && i.getFullYear() == t[5]))), r
    }, BX.message("JS_DATE"));
    $.validator.addMethod("extension", function (n, t, i) {
        return i = typeof i == "string" ? i.replace(/,/g, "|") : "png|jpe?g|gif", this.optional(t) || n.match(new RegExp(".(" + i + ")$", "i"))
    }, BX.message("JS_FILE_EXT"));
    $.validator.addMethod("captcha", function (n, t) {
        return $.validator.methods.remote.call(this, n, t, {
            url: arAsproOptions.SITE_DIR + "ajax/check-captcha.php",
            type: "post",
            data: {
                captcha_word: n, captcha_sid: function () {
                    return $(t).closest("form").find('input[name="captcha_sid"]').val()
                }
            }
        })
    }, BX.message("JS_ERROR"));
    $.validator.addMethod("recaptcha", function (n, t) {
        var i = $(t).closest("form").find(".g-recaptcha").attr("data-widgetid");
        return typeof i != "undefined" ? grecaptcha.getResponse(i) != "" : !0
    }, BX.message("JS_RECAPTCHA_ERROR"));
    $.validator.addClassRules({
        confirm_password: {equalTo: 'input[name="REGISTER[PASSWORD]"]', minlength: 6},
        password: {minlength: 6},
        inputfile: {extension: arAsproOptions.THEME.VALIDATE_FILE_EXT, filesize: 5e6},
        captcha: {captcha: ""},
        recaptcha: {recaptcha: ""}
    });
    arAsproOptions.THEME.PHONE_MASK && $("input.phone").inputmask("mask", {mask: arAsproOptions.THEME.PHONE_MASK});
    initCalculatePreview();
    $("select.region").on("change", function () {
        var n = parseInt($(this).val());
        $("select.city").length && (n ? ($("select.city option").hide(), $("select.city option").prop("disabled", "disabled"), $("select.city option[data-parent_section=" + n + "]").prop("disabled", ""), $("select.city option:eq(0)").prop("disabled", ""), $("select.city").ikSelect("reset"), $("select.city option[data-parent_section=" + n + "]").show()) : $("select.city option").prop("disabled", "disabled"), $("select.city option:eq(0)").prop("disabled", ""), $("select.city").ikSelect("reset"))
    });
    $("select.city, select.region").on("change", function () {
        var n = $(this), t = parseInt(n.val());
        n.hasClass("region") && ($("select.city option:eq(0)").show(), $("select.city").val(0));
        (n.hasClass("region") && !t || n.hasClass("city")) && $.ajax({
            type: "POST",
            data: {ID: t}
        }).success(function (n) {
            var t = BX.processHTML(n);
            $(".ajax_items")[0].innerHTML = t.HTML;
            BX.ajax.processScripts(t.SCRIPT)
        })
    });
    $(document).on("mouseenter", ".section-gallery-wrapper .section-gallery-wrapper__item", function () {
        $(this).siblings().removeClass("_active");
        $(this).addClass("_active")
    });
    $(document).on("click", ".hint .icon", function (n) {
        var t = $(this).closest(".hint");
        t.hasClass("active") ? t.removeClass("active").find(".tooltip").slideUp(200) : (t.addClass("active"), t.find(".tooltip").slideDown(200), t.find(".tooltip_close").click(function (n) {
            n.stopPropagation();
            t.removeClass("active").find(".tooltip").slideUp(100)
        }));
        n.stopPropagation()
    });
    $(".mobile_regions .city_item").on("click", function (n) {
        n.preventDefault();
        var t = $(this);
        $.removeCookie("current_region");
        $.cookie("current_region", t.data("id"), {path: "/", domain: arAsproOptions.SITE_ADDRESS});
        location.href = t.attr("href")
    });
    y = this;
    a = 25;
    $("section.toggle > label").prepend($("<i />").addClass("fa fa-plus"));
    $("section.toggle > label").prepend($("<i />").addClass("fa fa-minus"));
    $("section.toggle.active > p").addClass("preview-active");
    $("section.toggle.active > div.toggle-content").slideDown(350, function () {
    });
    $("section.toggle > label").click(function (n) {
        var i = $(this).parent(), u = $(this).parents("div.toogle"), t = !1, o = u.hasClass("toogle-accordion"), f, e,
            r;
        o && typeof n.originalEvent != "undefined" && u.find("section.toggle.active > label").trigger("click");
        i.toggleClass("active");
        i.find("> p").get(0) && (t = i.find("> p"), f = t.css("height"), t.css("height", "auto"), e = t.css("height"), t.css("height", f));
        r = i.find("> div.toggle-content");
        i.hasClass("active") ? ($(t).animate({height: e}, 350, function () {
            $(this).addClass("preview-active")
        }), r.slideDown(350, function () {
        })) : ($(t).animate({height: a}, 350, function () {
            $(this).removeClass("preview-active")
        }), r.slideUp(350, function () {
        }))
    });
    typeof $.fn.footable == "function" && $(".tables-responsive .responsive").footable();
    $("a[rel=tooltip]").tooltip();
    $("span[data-toggle=tooltip]").tooltip();
    $(".toggle .more_items").on("click", function () {
        $(this).closest(".toggle").find(".collapsed").css("display", "inline-block").removeClass("collapsed");
        $(this).remove();
        typeof $(this).data("resize") != "undefined" && $(this).data("resize") && $(window).resize()
    });
    $(".toggle_menu .more_items").on("click", function () {
        $(this).closest(".toggle_menu").find(".collapsed").addClass("clicked_exp");
        $(this).remove()
    });
    $(document).on("keyup", ".search-input-div input", function (n) {
        var t = $(this).val();
        $(".search-input-div input:not(:focus").val(t);
        $(this).closest("#headerfixed").length && n.keyCode == 13 && $(".search form").submit()
    });
    $(document).on("click", ".search-button-div button", function () {
        $(this).closest("#headerfixed").length && $(".search form").submit()
    });
    $(".inline-search-show, .inline-search-hide").on("click", function () {
        CloseMobilePhone();
        typeof $(this).data("type_search") != "undefined" && $(this).data("type_search") == "fixed" && $(".inline-search-block").addClass("fixed");
        arAsproOptions.THEME.TYPE_SEARCH == "fixed" && $(".inline-search-block.fixed.big .search-input").focus();
        arAsproOptions.THEME.TYPE_SEARCH != "fixed" && $("#title-search-input").focus();
        $(".inline-search-block").toggleClass("show");
        $(".top-block").length && ($(".inline-search-block").hasClass("show") ? $(".inline-search-block").css("background", $(".top-block").css("background-color")) : $(".inline-search-block").css("background", "#fff"));
        arAsproOptions.THEME.TYPE_SEARCH == "fixed" && ($(".inline-search-block").hasClass("show") ? $('<div class="jqmOverlay search"><\/div>').appendTo("body") : ($("#title-search-input").blur(), $(".jqmOverlay").detach()))
    });
    $("html, body").on("mousedown", function (n) {
        var t, i;
        typeof n.target.className == "string" && n.target.className.indexOf("adm") < 0 && (n.stopPropagation(), t = $(n.target).closest(".title-search-result"), $(n.target).hasClass("inline-search-block") || $(n.target).hasClass("svg") || t.length || ($(".inline-search-block").removeClass("show"), $(".title-search-result").hide(), arAsproOptions.THEME.TYPE_SEARCH == "fixed" && $(".jqmOverlay.search").detach()), $("#mobilePhone").length && CloseMobilePhone(), $("#basket_line .basket_fly").length && parseInt($("#basket_line .basket_fly").css("right")) >= 0 && ($(n.target).closest(".basket_wrapp").length || ($("#basket_line .basket_fly").stop().animate({right: -$("#basket_line .basket_fly").outerWidth()}, 150), $("#basket_line .basket_fly .opener > div").removeClass("cur"), $("#basket_line .basket_fly").removeClass("swiped"))), isMobile && t.length && (location.href = t.attr("href")), $(n.target).closest(".js-info-block").length || $(n.target).closest(".js-show-info-block").length || ($(".js-show-info-block").removeClass("opened"), $(".js-info-block").fadeOut()), $(n.target).closest(".hint.active").length || $(".hint.active .icon").trigger("click"), i = $(n.target).attr("class"), (typeof i == "undefined" || i.indexOf("tooltip") < 0) && $(".tooltip-link").tooltip("hide"))
    });
    $(".inline-search-block").find("*").on("mousedown", function (n) {
        n.stopPropagation()
    });
    initAnimateLoad();
    $(document).on("change", "input#select_all_items", function () {
        var n = $(this), t = 0, u = n.closest(".complect_main_wrap").length, i, r;
        t = u ? n.closest(".complect_main_wrap").find(".catalog-block-view__item .counter_wrapp:not(.ce_cmp_visible) .button_block .to-cart").length : $(".table-view__item:not([data-product_type=3])").find(".button_block .to-cart").length;
        i = $(".table-view__item:not([data-product_type=3])").find(".item-icons .wish_item_button .wish_item.to").length;
        r = $(".table-view__item").length;
        n.is(":checked") ? (t != 0 && $(".opt_action:not([data-action=compare])").removeClass("no-action"), $(".opt_action[data-action=compare]").removeClass("no-action"), $(".opt_action").addClass("animate-load"), $(".opt_action .text").remove(), $('<div class="text">(<span>' + t + "<\/span>)<\/div>").appendTo($(".opt_action[data-action=buy]")), $('<div class="text muted">(<span>' + i + "<\/span>)<\/div>").appendTo($(".opt_action[data-action=wish]")), $('<div class="text muted">(<span>' + r + "<\/span>)<\/div>").appendTo($(".opt_action[data-action=compare]")), $('input[name="chec_item"]').prop("checked", "checked")) : ($(".opt_action").addClass("no-action"), $(".opt_action").removeClass("animate-load"), $(".opt_action .text").remove(), $('input[name="chec_item"]').removeAttr("checked"));
        n.closest(".complect_header_block").length && typeof setNewPriceComplect == "function" && setNewPriceComplect()
    });
    $(document).on("change", "input[name='chec_item']", function () {
        var n = $(this),
            t = n.closest(".table-view__item").find(".button_block .to-cart").length || n.closest(".catalog-block-view__item").find(".button_block .to-cart").length,
            i = n.closest(".main_item_wrapper").attr("data-product_type") == "3";
        n.is(":checked") ? $(".opt_action").each(function () {
            var n = $(this), r = n.attr("data-action") == "buy", f = n.attr("data-action") == "wish", u;
            if (i && (r || f) || r && !t) return !0;
            n.find(".text").length ? (u = parseInt(n.find(".text span").text()), n.find(".text span").text(++u)) : (n.removeClass("no-action"), n.addClass("animate-load"), $('<div class="text muted">(<span>1<\/span>)<\/div>').appendTo(n))
        }) : $(".opt_action").each(function () {
            var n = $(this), u = n.attr("data-action") == "buy", f = n.attr("data-action") == "wish", r;
            if (i && (u || f) || u && !t) return !0;
            n.find(".text").length && (r = parseInt(n.find(".text span").text()), --r, n.find(".text span").text(r), r || (n.addClass("no-action"), n.removeClass("animate-load"), n.find(".text").remove()))
        })
    });
    $(document).on("click", ".opt_action", function () {
        var t = $(this), i = t.data("action"),
            n = {type: "multiple", iblock_id: t.data("iblock_id"), action: i, items: {}};
        t.hasClass("no-action") || ($(".opt_action").addClass("no-action"), t.removeClass("no-action"), $(".table-view__item, .catalog-block-view__item").each(function () {
            var t = $(this), f = t.find(".button_block .to-cart").length,
                e = t.find('input[name="chec_item"]').is(":checked") && (f || i != "buy"),
                u = t.data("product_type") == "3" && t.find(".button_block .to-cart").length, r;
            e && (r = u ? t.find(".button_block .to-cart").data("item") : t.data("id"), n.items[r] = {}, n.items[r].id = r, n.items[r].product_type = t.data("product_type"), n.items[r].quantity = t.find('input[name="quantity"]').val(), u && (n.items[r].add_offer = "Y"))
        }), $.ajax({
            type: "POST",
            url: arAsproOptions.SITE_DIR + "ajax/item.php",
            data: n,
            dataType: "json",
            success: function (n) {
                "STATUS" in n && (n.STATUS !== "OK" && showBasketError(BX.message(n.MESSAGE) + " <br/>" + n.MESSAGE_EXT), $(".header-cart.fly").length ? (arBasketAsproCounters.DEFAULT = !0, SetActualBasketFlyCounters(!0)) : $("#ajax_basket").length ? reloadTopBasket("add", $("#ajax_basket"), 200, 5e3, "N", "", !0) : reloadBasketCounters("", !0));
                t.parent().removeClass("loadings");
                $(".opt_action").removeClass("no-action")
            }
        }))
    });
    if (setTimeout(function () {
        $('.with-opt-buy input[name="chec_item"], .with-opt-buy input[name="select_all_items"]').length && $('.with-opt-buy input[name="chec_item"], .with-opt-buy input[name="select_all_items"]').prop("checked", !1)
    }, 1), isMobile) {
        $(document).on("click", '*[data-event="jqm"]', function (n) {
            var t, i, e, o;
            if (n.preventDefault(), n.stopPropagation(), t = $(this), i = t.data("name"), window.matchMedia("(min-width:768px)").matches || typeof t.data("no-mobile") != "undefinde" && t.data("no-mobile") == "Y") return $(this).hasClass("clicked") || ($(this).addClass("clicked"), $(this).jqmEx(), $(this).trigger("click")), !1;
            if (i.length) {
                var r = arAsproOptions.SITE_DIR + "form/", u = "", f = {};
                $.each(t.get(0).attributes, function (n, i) {
                    var r = i.nodeName, e = t.attr(r), o;
                    f[r] = e;
                    /^data\-param\-(.+)$/.test(r) && (o = r.match(/^data\-param\-(.+)$/)[1], u += o + "=" + e + "&")
                });
                e = JSON.stringify(f);
                o = encodeURIComponent(e);
                r += "?name=" + i + "&" + u + "data-trigger=" + o;
                previewMode && t.attr("href") !== undefined && (r = t.attr("href"));
                location.href = r
            }
        });
        $(".fancybox").removeClass("fancybox")
    } else $(document).on("click", '*[data-event="jqm"]', function (n) {
        var t, i, e, o;
        if (n.preventDefault(), n.stopPropagation(), t = $(this), i = t.data("name"), previewMode && (i.length && i == "auth" || window.matchMedia("(max-width:400px)").matches)) {
            var r = arAsproOptions.SITE_DIR + "form/", u = "", f = {};
            $.each(t.get(0).attributes, function (n, i) {
                var r = i.nodeName, e = t.attr(r), o;
                f[r] = e;
                /^data\-param\-(.+)$/.test(r) && (o = r.match(/^data\-param\-(.+)$/)[1], u += o + "=" + e + "&")
            });
            e = JSON.stringify(f);
            o = encodeURIComponent(e);
            r += "?name=" + i + "&" + u + "data-trigger=" + o;
            t.attr("href") !== undefined && (r = t.attr("href"));
            location.href = r
        } else $(this).hasClass("clicked") || ($(this).addClass("clicked"), $(this).jqmEx(), $(this).trigger("click"));
        return !1
    });
    BX.addCustomEvent("onCompleteAction", function (n, t) {
        try {
            if (n.action === "loadForm") $(t).parent().removeClass("loadings"), $(t).removeClass("clicked"), $(t).hasClass("one_click_buy_trigger") ? ($(".wrapp_one_click > span").removeClass("clicked"), $(".one_click").removeClass("clicked")) : $(t).hasClass("one_click_buy_basket_trigger") && $(".fast_order").removeClass("clicked"); else if (n.action === "loadBasket") $(".basket-link.basket").attr("title", $("<div/>").html(arBasketPrices.BASKET_SUMM_TITLE).text()), $(".basket-link.delay").attr("title", $("<div/>").html(arBasketPrices.DELAY_SUMM_TITLE).text()), arBasketPrices.BASKET_COUNT > 0 ? ($(".basket-link.basket").addClass("basket-count"), $(".basket-link.basket .count").removeClass("empted"), $(".basket-link.basket .prices").length && $(".basket-link.basket .prices").html(arBasketPrices.BASKET_SUMM)) : ($(".basket-link.basket").removeClass("basket-count"), $(".basket-link.basket .count").addClass("empted"), $(".basket-link.basket .prices").length && $(".basket-link.basket .prices").html(arBasketPrices.BASKET_SUMM_TITLE_SMALL)), $(".basket-link.basket .count").text(arBasketPrices.BASKET_COUNT), arBasketPrices.DELAY_COUNT > 0 ? ($(".basket-link.delay").addClass("basket-count"), $(".basket-link.delay .count").removeClass("empted")) : ($(".basket-link.delay").removeClass("basket-count"), $(".basket-link.delay .count").addClass("empted")), $(".basket-link.delay .count").text(arBasketPrices.DELAY_COUNT), updateBottomIconsPanel(arBasketPrices); else if (n.action === "loadActualBasketCompare") {
                var i = Object.keys(arBasketAspro.COMPARE).length;
                i > 0 ? ($(".basket-link.compare").addClass("basket-count"), $(".basket-link.compare .count").removeClass("empted"), $("#compare_fly").length && $("#compare_fly").removeClass("empty_block")) : ($(".basket-link.compare").removeClass("basket-count"), $(".basket-link.compare .count").addClass("empted"), $("#compare_fly").length && $("#compare_fly").addClass("empty_block"));
                $(".basket-link.compare .count").text(i);
                updateBottomIconsPanel(arBasketAspro)
            } else n.action === "loadRSS" || n.action === "ajaxContentLoaded" || n.action === "jsLoadBlock" && (initCountdown(), setStatusButton(), InitFlexSlider(), setTimeout(function () {
                InitOwlSlider()
            }, 200), InitFancyBox(), checkLinkedArticles(), checkLinkedBlocks(".linked-banners-list"), lazyLoadPagenBlock(), typeof stickySidebar != "undefined" && window.stickySidebar.updateSticky())
        } catch (r) {
            console.error(r)
        }
    });
    $(".banners-small .item.normal-block").length && $(".banners-small .item.normal-block").sliceHeight();
    $(".teasers .item").length && $(".teasers .item").sliceHeight();
    $(".wrap-portfolio-front .row.items > div").length && $(".wrap-portfolio-front .row.items > div").sliceHeight({
        row: ".row.items",
        item: ".item1"
    });
    $("img").removeAttr("draggable");
    $(".title-tab-heading").on("click", function () {
        var n = $(this).parent(), i = $(this).next(), r = n.hasClass("media_review"), t, u, f, e;
        clicked_tab = n.index() + 1;
        n.siblings().removeClass("active");
        $(".nav.nav-tabs li").removeClass("active");
        n.hasClass("active") ? r ? $("#reviews_content").slideUp(200, function () {
            n.removeClass("active")
        }) : i.slideUp(200, function () {
            n.removeClass("active")
        }) : (n.addClass("active"), r ? $("#reviews_content").slideDown() : ($(".tabs_section + #reviews_content").length && $(".tabs_section + #reviews_content").slideUp(), i.slideDown(), typeof n.attr("id") != "undefined" && n.attr("id") == "descr" && (t = $(".galerys-block"), t.length && (u = t.find(".big_slider").length, f = u ? t.find(".big_slider") : t.find(".small_slider"), InitFlexSlider(), e = setInterval(function () {
            f.find(".slides .item").attr("style").indexOf("height") === -1 ? $(window).resize() : clearInterval(e)
        }, 100)))))
    });
    InitFlexSlider();
    InitOwlSlider();
    InitStickySideBar();
    InitFancyBox();
    InitFancyBoxVideo();
    setTimeout(function () {
        InitTopestMenuGummi();
        isOnceInited = !0
    }, 50);
    InitZoomPict();
    $(document).on("click", ".captcha_reload", function (n) {
        var t = $(this).parents(".captcha-row");
        n.preventDefault();
        $.ajax({url: arAsproOptions.SITE_DIR + "ajax/captcha.php"}).done(function (n) {
            t.find("input[name=captcha_sid],input[name=captcha_code]").val(n);
            t.find("img").attr("src", "/bitrix/tools/captcha.php?captcha_sid=" + n);
            t.find("input[name=captcha_word]").val("").removeClass("error");
            t.find(".captcha_input").removeClass("error").find(".error").remove()
        })
    });
    arAsproOptions.PAGES.BASKET_PAGE ? showBasketHeadingBtn() : arAsproOptions.THEME.PRINT_BUTTON === "Y" && setTimeout(function () {
        var n = document.querySelector(".period_wrapper.in-detail-news1 .period_wrapper_inner") ? document.querySelector(".detail-news1 .period_wrapper .period_wrapper_inner") : document.querySelector(".page-top .topic .topic__heading") ? document.querySelector(".page-top .topic .topic__heading") : null,
            t;
        n && (t = BX.create({
            tag: "div",
            attrs: {
                "class": "print-link colored_theme_hover_bg-block",
                title: arAsproOptions.THEME.EXPRESSION_FOR_PRINT_PAGE
            },
            html: '<i class="svg colored_theme_hover_bg-el-svg"><svg class="svg svg-print" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Rectangle_665_copy_4" data-name="Rectangle 665 copy 4" class="cls-print" d="M1570,210h-2v3h-8v-3h-2a2,2,0,0,1-2-2v-5a2,2,0,0,1,2-2h2v-4h8v4h2a2,2,0,0,1,2,2v5A2,2,0,0,1,1570,210Zm-8,1h4v-4h-4v4Zm4-12h-4v2h4v-2Zm4,4h-12v5h2v-3h8v3h2v-5Z" transform="translate(-1556 -197)"><\/path><\/svg><\/i>'
        }), BX.insertBefore(t, n))
    }, 150);
    $(document).on("click", ".print-link", function () {
        window.print()
    });
    $(".head-block .item-link").on("click", function () {
        var n = $(this);
        n.siblings().removeClass("active");
        n.addClass("active")
    });
    $("table.table").each(function () {
        var i = $(this), n = i.find("thead tr th"), t;
        n.length || (n = i.find("thead tr td"));
        n.length && (t = 0, i.find("tbody tr td").each(function () {
            t > n.length - 1 && (t = 0);
            $('<div class="th-mobile">' + n[t].textContent + "<\/div>").appendTo($(this));
            t++
        }))
    });
    window.matchMedia("(min-width: 768px)").matches && $(".wrapper_middle_menu.wrap_menu").removeClass("mobile");
    window.matchMedia("(max-width: 767px)").matches && $(".wrapper_middle_menu.wrap_menu").addClass("mobile");
    $(".menu_top_block .v_bottom a").on("click", function (n) {
        $(n.target).hasClass("toggle_block") && n.preventDefault()
    });
    $(".menu_top_block .v_bottom a .toggle_block").click(function () {
        var n = $(this), t = n.closest(".has-child").find("> .dropdown"), i = t.is(":visible"),
            r = i ? "slideUp" : "slideDown";
        n.hasClass("clicked") || (n.addClass("clicked"), t.velocity("stop").velocity(r, {
            duration: 150,
            begin: function () {
                n.toggleClass("closed")
            },
            complete: function () {
                n.removeClass("clicked");
                typeof stickySidebar != "undefined" && window.stickySidebar.updateSticky()
            }
        }));
        $(this).closest(".has-child").toggleClass("opened")
    });
    $(document).on("click", ".show_props", function () {
        $(this).prev().stop().slideToggle(333);
        $(this).find(".char_title").toggleClass("opened")
    });
    $(".see_more").on("click", function (n) {
        n.preventDefault();
        var t = $(this).is(".see_more") ? $(this) : $(this).parents(".see_more").first(),
            i = t.find("> a").length ? t.find("> a") : t, r = t.parent().find("> .d");
        return t.hasClass("open") ? (i.text(BX.message("CATALOG_VIEW_MORE")), t.removeClass("open"), r.hide()) : (i.text(BX.message("CATALOG_VIEW_LESS")), t.addClass("open"), r.show()), !1
    });
    $(".button.faq_button").click(function (n) {
        n.preventDefault();
        $(this).toggleClass("opened");
        $(".faq_ask .form").slideToggle()
    });
    $(".staff.list .staff_section .staff_section_title a").click(function (n) {
        n.preventDefault();
        $(this).parents(".staff_section").toggleClass("opened");
        $(this).parents(".staff_section").find(".staff_section_items").stop().slideToggle(600);
        $(this).parents(".staff_section_title").find(".opener_icon").toggleClass("opened")
    });
    $(".jobs_wrapp .item .name").click(function () {
        $(this).closest(".item").toggleClass("opened");
        $(this).closest(".item").find(".description_wrapp").stop().slideToggle(600);
        $(this).closest(".item").find(".opener_icon").toggleClass("opened")
    });
    $(".faq.list .item .q a").on("click", function (n) {
        n.preventDefault();
        $(this).parents(".item").toggleClass("opened");
        $(this).parents(".item").find(".a").stop().slideToggle();
        $(this).parents(".item").find(".q .opener_icon").toggleClass("opened")
    });
    $(".opener_icon").click(function (n) {
        n.preventDefault();
        $(this).parent().find("a").trigger("click")
    });
    $(".dotdot").dotdotdot();
    $(".more_block span").on("click", function () {
        var n = $(".catalog_detail .tabs_section").offset();
        $("html, body").animate({scrollTop: n.top - 43}, 400)
    });
    $(document).on("click", ".counter_block:not(.basket) .plus", function () {
        if ((!$(this).parents(".basket_wrapp").length || $(this).parents(".services_in_basket").length) && $(this).parent().data("offers") != "Y") {
            var n = $(this).parents(".counter_block_wr").length;
            input = $(this).parents(".counter_block").find("input[type=text]");
            tmp_ratio = n ? $(this).parents("tr").first().find("td.buy .to-cart").data("ratio") : $(this).parents(".counter_wrapp").find(".to-cart").data("ratio");
            isDblQuantity = n ? $(this).parents("tr").first().find("td.buy .to-cart").data("float_ratio") : $(this).parents(".counter_wrapp").find(".to-cart").data("float_ratio");
            ratio = isDblQuantity ? parseFloat(tmp_ratio) : parseInt(tmp_ratio, 10);
            max_value = "";
            currentValue = input.val();
            isDblQuantity && (ratio = Math.round(ratio * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor);
            curValue = isDblQuantity ? parseFloat(currentValue) : parseInt(currentValue, 10);
            curValue += ratio;
            isDblQuantity && (curValue = Math.round(curValue * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor);
            parseFloat($(this).data("max")) > 0 ? input.val() < $(this).data("max") && (curValue <= $(this).data("max") && input.val(curValue), input.change()) : (input.val(curValue), input.change())
        }
    });
    $(document).on("click", ".counter_block:not(.basket) .minus", function () {
        if ((!$(this).parents(".basket_wrapp").length || $(this).parents(".services_in_basket").length) && $(this).parent().data("offers") != "Y") {
            var n = $(this).parents(".counter_block_wr").length;
            input = $(this).parents(".counter_block").find("input[type=text]");
            tmp_ratio = n ? $(this).parents("tr").first().find("td.buy .to-cart").data("ratio") : $(this).parents(".counter_wrapp").find(".to-cart").data("ratio");
            isDblQuantity = n ? $(this).parents("tr").first().find("td.buy .to-cart").data("float_ratio") : $(this).parents(".counter_wrapp").find(".to-cart").data("float_ratio");
            ratio = isDblQuantity ? parseFloat(tmp_ratio) : parseInt(tmp_ratio, 10);
            max_value = "";
            currentValue = input.val();
            isDblQuantity && (ratio = Math.round(ratio * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor);
            curValue = isDblQuantity ? parseFloat(currentValue) : parseInt(currentValue, 10);
            curValue -= ratio;
            isDblQuantity && (curValue = Math.round(curValue * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor);
            const t = parseFloat($(this).parents(".counter_block").find(".minus").data("min"));
            t && (ratio = t);
            parseFloat($(this).parents(".counter_block").find(".plus").data("max")) > 0 ? currentValue > ratio && (curValue < ratio ? input.val(ratio) : input.val(curValue), input.change()) : (curValue > ratio ? input.val(curValue) : ratio ? input.val(ratio) : currentValue > 1 && input.val(curValue), input.change())
        }
    });
    $(".counter_block input[type=text]").numeric({allow: "."});
    $(document).on("focus", ".counter_block input[type=text]", function () {
        $(this).addClass("focus")
    });
    $(document).on("blur", ".counter_block input[type=text]", function () {
        $(this).removeClass("focus")
    });
    t = !1;
    $(document).on("change", ".counter_block input[type=text]", function () {
        var r, o;
        if (!$(this).parents(".basket_wrapp").length) {
            var n = $(this).val(),
                u = $(this).parents(".counter_wrapp").find(".to-cart").data("ratio") ? $(this).parents(".counter_wrapp").find(".to-cart").data("ratio") : $(this).parents("tr").first().find("td.buy .to-cart").data("ratio"),
                f = $(this).parents(".counter_wrapp").find(".to-cart").data("float_ratio") ? $(this).parents(".counter_wrapp").find(".to-cart").data("float_ratio") : $(this).parents("tr").first().find("td.buy .to-cart").data("float_ratio"),
                i = f ? parseFloat(u) : parseInt(u, 10), e = n % i;
            f && (i = Math.round(i * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor, Math.round(e * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor == i && (e = 0));
            $(this).hasClass("focus") && (intCount = Math.round(Math.round(n * arAsproOptions.JS_ITEM_CLICK.precisionFactor / i) / arAsproOptions.JS_ITEM_CLICK.precisionFactor) || 1, n = intCount <= 1 ? i : intCount * i, n = Math.round(n * arAsproOptions.JS_ITEM_CLICK.precisionFactor) / arAsproOptions.JS_ITEM_CLICK.precisionFactor);
            parseFloat($(this).parents(".counter_block").find(".plus").data("max")) > 0 && n > parseFloat($(this).parents(".counter_block").find(".plus").data("max")) && (n = parseFloat($(this).parents(".counter_block").find(".plus").data("max")));
            parseFloat($(this).parents(".counter_block").find(".minus").data("min")) > 0 && n < parseFloat($(this).parents(".counter_block").find(".minus").data("min")) && (n = parseFloat($(this).parents(".counter_block").find(".minus").data("min")));
            n < i ? n = i : parseFloat(n) || (n = 1);
            $(this).parents(".counter_block").parent().parent().find(".to-cart").attr("data-quantity", n);
            $(this).parents(".counter_block").parent().parent().parent().find(".one_click").attr("data-quantity", n);
            $(this).parents(".counter_block").parent().parent().parent().parent().find(".one_click").attr("data-quantity", n);
            $(this).parents(".catalog_item_wrapp").find(".inner_wrap.TYPE_1 .one_click").attr("data-quantity", n);
            $(this).val(n);
            r = $(this).closest(".item").length ? $(this).closest(".item").find(".calculate-delivery") : $(this).closest(".catalog_detail").find(".calculate-delivery");
            r.length && r.each(function () {
                var i = $(this).find("span[data-event=jqm]").first(), r;
                if (i.length) {
                    r = i.clone();
                    r.attr("data-param-quantity", n).removeClass("clicked");
                    r.insertAfter(i).on("click", function () {
                        //jQuery.browser.mobile || $(this).parent().addClass("loadings")
                    });
                    i.remove()
                }
                $(this).hasClass("with_preview") && ($(this).removeClass("inited"), t && clearTimeout(t), t = setTimeout(function () {
                    initCalculatePreview();
                    t = !1
                }, 1e3))
            });
            o = {type: "change", params: {id: $(this), value: n}};
            BX.onCustomEvent("onCounterProductAction", [o]);
            $(this).closest(".complect-block").length && typeof setNewPriceComplect == "function" && setNewPriceComplect()
        }
    });
    BX.addCustomEvent("onCounterProductAction", function (n) {
        typeof n != "object" && (n = {type: "undefined"});
        try {
            if (typeof n.type != "undefined" && !n.params.id.closest(".gifts").length) {
                var t = n.params.id.data("product");
                n.params.id.closest(".has_offer_prop").length && (typeof obSkuQuantys == "undefined" && (window.obSkuQuantys = {}), window.obSkuQuantys[n.params.id.closest(".offer_buy_block").find(".to-cart").data("item")] = n.params.value);
                typeof window[t] == "object" ? (t == "obOffers" ? setPriceAction("", "", "Y") : window[t].setPriceAction("Y"), $(".detail_page").length && setNewHeader()) : n.params.id.length && n.params.id.closest(".main_item_wrapper").length && arAsproOptions.THEME.SHOW_TOTAL_SUMM == "Y" && setPriceItem(n.params.id.closest(".main_item_wrapper"), n.params.value);
                BX.onCustomEvent("onCounterProductActionResize")
            }
        } catch (i) {
            console.error(i)
        }
    });
    $(document).on("mouseenter", ".wrap_icon.top_basket, #headerfixed .basket-link.basket", function () {
        var t = $(this), i = t.closest("header, #headerfixed"), n = i.find(".basket_hover_block");
        n.hasClass("loaded") || basketTop("", n)
    });
    $(document).on("click", ".wrap_icon.wrap_basket.top_basket, #headerfixed .basket-link.basket", function (n) {
        var t = $(this);
        isMobile && (t.hasClass("clicked") || (n.preventDefault(), t.addClass("clicked"), setTimeout(function () {
            t.removeClass("clicked")
        }, 3e3)))
    });
    $(document).on("mouseenter", "#basket_line .basket_normal:not(.empty_cart):not(.bcart) .basket_block ", function () {
        $(this).closest(".basket_normal").find(".popup").addClass("block");
        $(this).closest(".basket_normal").find(".basket_popup_wrapp").stop(!0, !0).slideDown(150)
    });
    $(document).on("mouseleave", "#basket_line .basket_normal .basket_block ", function () {
        var n = $(this);
        $(this).closest(".basket_normal").find(".basket_popup_wrapp").stop(!0, !0).slideUp(150, function () {
            n.closest(".basket_normal").find(".popup").removeClass("block")
        })
    });
    $(document).on("click", ".popup_button_basket", function () {
        var n = $(".to-cart[data-item=" + $(this).data("item") + "]"), o = n.attr("data-quantity"), e, i;
        o || ($val = 1);
        var s = n.data("props"), h = "", c = "", l = "N", t = {}, y = n.data("iblockid"), u = n.data("offers"), f = "",
            a = "", r = n.attr("data-item");
        u != "Y" ? u = "N" : a = n.closest(".prices_tab").find(".bx_sku_props input").val();
        s && (h = s.split(";"));
        n.data("part_props") && (c = n.data("part_props"));
        n.data("add_props") && (l = n.data("add_props"));
        $(".rid_item").length ? f = $(".rid_item").data("rid") : n.data("rid") && (f = n.data("rid"));
        t = fillBasketPropsExt(n, "prop", "bx_ajax_text");
        t.quantity = o;
        t.add_item = "Y";
        t.rid = f;
        t.offers = u;
        t.iblockID = y;
        t.part_props = c;
        t.add_props = l;
        t.props = JSON.stringify(h);
        t.item = r;
        t.basket_props = a;
        var p = n.closest(".product-action").length || n.closest("#headerfixed.with-product"),
            v = n.closest(".list-offers").length, w = n.closest(".buy_services_wrap").length;
        !w && (p || v) && (e = [], e = v ? n.closest(".product-container").find('.buy_services_wrap .services-item [name="buy_switch_services"]:checked') : $(".product-container").find('.buy_services_wrap[data-parent_product="' + r + '"] .services-item [name="buy_switch_services"]:checked'), i = [], e.each(function () {
            var t = $(this), n = t.closest(".services-item").find(".to-cart");
            i[n.data("item")] = {};
            i[n.data("item")].id = n.data("item");
            i[n.data("item")].quantity = n.attr("data-quantity");
            i[n.data("item")].iblock_id = n.data("iblockid")
        }), i = array_values_js(i), t.services = i);
        $.ajax({
            type: "POST",
            url: arAsproOptions.SITE_DIR + "ajax/item.php",
            data: t,
            dataType: "json",
            success: function (i) {
                $(".basket_error_frame").jqmHide();
                "STATUS" in i ? (getActualBasket(t.iblockID), i.STATUS === "OK" ? (n.hide(), n.closest(".counter_wrapp").find(".counter_block_inner").hide(), n.closest(".counter_wrapp").find(".counter_block").hide(), n.parents("tr").find(".counter_block_wr .counter_block").hide(), n.closest(".button_block").addClass("wide"), n.parent().find(".in-cart").show(), addBasketCounter(r), $(".wish_item[data-item=" + r + "]").find(".value").show(), $(".wish_item[data-item=" + r + "]").find(".value.added").hide(), $("#ajax_basket").length && reloadTopBasket("add", $("#ajax_basket"), 200, 5e3, "Y"), $("#basket_line .basket_fly").length && (n.closest(".fast_view_frame").length || window.matchMedia("(max-width: 767px)").matches ? basketFly("open", "N") : basketFly("open"))) : showBasketError(BX.message(i.MESSAGE))) : showBasketError(BX.message("CATALOG_PARTIAL_BASKET_PROPERTIES_ERROR"))
            }
        })
    });
    $(document).on("click", ".to-cart:not(.read_more), .basket_item_add", function (n) {
        var t, e, c, u, g, l, o;
        if (n.preventDefault(), t = $(this), !t.hasClass("clicked")) {
            t.addClass("clicked");
            var f = $(this).attr("data-quantity"), a = $(this).data("props"), v = "", y = "", p = "N", r = {},
                nt = $(this).data("iblockid"), s = $(this).data("offers"), h = "", w = !1, b = "",
                i = $(this).attr("data-item");
            t.closest(".but-cell").length && $('.counter_block[data-item="' + i + '"]').length && (f = $('.counter_block[data-item="' + i + '"] input').val());
            t.closest(".banner_buttons.with_actions").length && (e = t.closest(".wraps_buttons"), i = e.data("id"), w = !0);
            f || (f = 1);
            s != "Y" ? s = "N" : b = $(this).closest(".prices_tab").find(".bx_sku_props input").val();
            a && (v = a.split(";"));
            $(this).data("part_props") && (y = $(this).data("part_props"));
            $(this).data("add_props") && (p = $(this).data("add_props"));
            $(".rid_item").length ? h = $(".rid_item").data("rid") : $(this).data("rid") && (h = $(this).data("rid"));
            r = fillBasketPropsExt(t, "prop", t.data("bakset_div"));
            r.quantity = f;
            r.add_item = "Y";
            r.rid = h;
            r.offers = s;
            r.iblockID = nt;
            r.part_props = y;
            r.add_props = p;
            r.props = JSON.stringify(v);
            r.item = i;
            r.basket_props = b;
            var tt = t.closest(".product-action").length || t.closest("#headerfixed.with-product"),
                k = t.closest(".list-offers").length, d = t.closest(".buy_services_wrap").length;
            if (!d && (tt || k) && (c = [], c = k ? t.closest(".product-container").find('.buy_services_wrap .services-item [name="buy_switch_services"]:checked') : $(".product-container").find('.buy_services_wrap[data-parent_product="' + i + '"] .services-item [name="buy_switch_services"]:checked'), u = [], c.each(function () {
                var t = $(this), n = t.closest(".services-item").find(".to-cart");
                u[n.data("item")] = {};
                u[n.data("item")].id = n.data("item");
                u[n.data("item")].quantity = n.attr("data-quantity");
                u[n.data("item")].iblock_id = n.data("iblockid")
            }), u = array_values_js(u), r.services = u), g = $(this).closest(".buy_services_wrap"), d && (l = g.attr("data-parent_product"), r["prop[BUY_PRODUCT_PROP]"] = l, r["prop[ASPRO_BUY_PRODUCT_ID]"] = l), w) {
                if (t.hasClass("added")) return location.href = t.data("href"), !1;
                t.attr("title", t.data("title2"));
                t.toggleClass("added");
                e.find(".wish_item_add").length && e.find(".wish_item_add").removeClass("added")
            }
            t.data("empty_props") == "N" ? (o = $("#" + t.data("bakset_div")).html(), !o && t.closest(".item").find(".basket_props_block").length && (o = t.closest(".item").find(".basket_props_block").html()), showBasketError(o, BX.message("ERROR_BASKET_PROP_TITLE"), "Y", t), BX.addCustomEvent("onCompleteAction", function (n) {
                if (!n.ignoreSelf) BX.onCustomEvent("onCompleteAction", [{action: "loadForm", ignoreSelf: !0}, t[0]])
            })) : $.ajax({
                type: "POST",
                url: arAsproOptions.SITE_DIR + "ajax/item.php",
                data: r,
                dataType: "json",
                success: function (n) {
                    var u, f;
                    getActualBasket(r.iblockID);
                    u = {action: "loadForm"};
                    BX.onCustomEvent("onCompleteAction", [u, t[0]]);
                    arStatusBasketAspro = {};
                    n !== null ? "STATUS" in n ? (n.MESSAGE_EXT === null && (n.MESSAGE_EXT = ""), n.STATUS === "OK" ? ($(".to-cart[data-item=" + i + "]").hide(), $(".to-cart[data-item=" + i + "]").closest(".counter_wrapp").find(".counter_block_inner").hide(), $(".to-cart[data-item=" + i + "]").closest(".counter_wrapp").find(".counter_block").hide(), $(".to-cart[data-item=" + i + "]").parents("tr").find(".counter_block_wr .counter_block").hide(), $(".to-cart[data-item=" + i + "]").closest(".button_block").addClass("wide"), $(".in-cart[data-item=" + i + "]").show(), addBasketCounter(i), $(".wish_item[data-item=" + i + "]").find(".value").show(), $(".wish_item[data-item=" + i + "]").find(".value.added").hide(), $(".wish_item.to[data-item=" + i + "]").show(), $(".wish_item.in[data-item=" + i + "]").hide(), $("#ajax_basket").length && reloadTopBasket("add", $("#ajax_basket"), 200, 5e3, "Y"), $("#basket_line .basket_fly").length && (t.closest(".services_in_basket").length && !window.matchMedia("(max-width: 767px)").matches ? basketFly("open", "SHOW") : t.closest(".fast_view_frame").length || window.matchMedia("(max-width: 767px)").matches || $("#basket_line .basket_fly.loaded").length ? basketFly("open", "N") : basketFly("open")), t.closest(".services_in_basket_page").length && BX.Sale.BasketComponent.sendRequest("refreshAjax", {
                        fullRecalculation: "Y",
                        otherParams: {param: "N"}
                    }), $(".top_basket").length && basketTop("open", $(".top_basket").find(".basket_hover_block")), $("#headerfixed .wproducts .ajax_load .btn").length && t.closest(".product-action").length && t.next(".in-cart").length && (f = '<span class="buy_block"><span class="btn btn-default btn-sm slide_offer more type_block">' + t.next(".in-cart").html() + "<\/span><\/span>", $("#headerfixed .wproducts .ajax_load .item-buttons .but-cell").html(f))) : showBasketError(BX.message(n.MESSAGE) + " <br/>" + n.MESSAGE_EXT)) : showBasketError(BX.message("CATALOG_PARTIAL_BASKET_PROPERTIES_ERROR")) : ($(".to-cart[data-item=" + i + "]").hide(), $(".to-cart[data-item=" + i + "]").closest(".counter_wrapp").find(".counter_block_inner").hide(), $(".to-cart[data-item=" + i + "]").closest(".counter_wrapp").find(".counter_block").hide(), $(".to-cart[data-item=" + i + "]").parents("tr").find(".counter_block_wr .counter_block").hide(), $(".to-cart[data-item=" + i + "]").closest(".button_block").addClass("wide"), $(".in-cart[data-item=" + i + "]").show(), addBasketCounter(i), $(".wish_item[data-item=" + i + "]").find(".value").show(), $(".wish_item[data-item=" + i + "]").find(".value.added").hide(), $("#ajax_basket").length && reloadTopBasket("add", $("#ajax_basket"), 200, 5e3, "Y"), $("#basket_line .basket_fly").length && (t.closest(".fast_view_frame").length || window.matchMedia("(max-width: 767px)").matches || $("#basket_line .basket_fly.loaded").length ? basketFly("open", "N") : basketFly("open")))
                }
            })
        }
    });
    $(document).on("click", ".to-subscribe", function (n) {
        var t, i, r;
        n.preventDefault();
        t = $(this);
        t.hasClass("clicked") || (t.addClass("clicked"), $(this).is(".auth") ? $(this).hasClass("nsubsc") ? ($(this).jqmEx(), $(this).trigger("click")) : location.href = arAsproOptions.SITE_DIR + "auth/?backurl=" + location.pathname : (i = $(this).attr("data-item"), r = $(this).attr("data-iblockid"), $(".to-subscribe[data-item=" + i + "]").hide(), $(".to-subscribe[data-item=" + i + "]").parent().find(".in-subscribe").show(), $.get(arAsproOptions.SITE_DIR + "ajax/item.php?item=" + i + "&subscribe_item=Y", $.proxy(function () {
            arStatusBasketAspro = {};
            getActualBasket(r)
        })), t.removeClass("clicked")))
    });
    $(document).on("click", ".in-subscribe", function (n) {
        n.preventDefault();
        var t = $(this).attr("data-item"), i = $(this).attr("data-iblockid");
        $(".in-subscribe[data-item=" + t + "]").hide();
        $(".in-subscribe[data-item=" + t + "]").parent().find(".to-subscribe").removeClass("clicked");
        $(".in-subscribe[data-item=" + t + "]").parent().find(".to-subscribe").show();
        $.get(arAsproOptions.SITE_DIR + "ajax/item.php?item=" + t + "&subscribe_item=Y", $.proxy(function () {
            getActualBasket(i);
            arStatusBasketAspro = {}
        }))
    });
    $(document).on("click", ".wish_item, .wish_item_add", function (n) {
        var u;
        n.preventDefault();
        var f = $(this).attr("data-quantity"), i = $(this), e = $(this).data("offers"), s = $(this).data("iblock"),
            h = $(this).data("props"), c = "", r = !1, t = $(this).attr("data-item"), o = $(this).attr("data-item");
        i.closest(".banner_buttons.with_actions").length && (u = i.closest(".wraps_buttons"), t = o = u.data("id"), r = !0);
        i.hasClass("clicked") || (i.addClass("clicked"), f || (f = 1), e != "Y" && (e = "N"), h && (c = h.split(";")), $(this).hasClass("text") ? $(this).hasClass("added") ? ($(".wish_item[data-item=" + t + "]").removeClass("added"), $(".wish_item[data-item=" + t + "]").find(".value").show(), $(".wish_item[data-item=" + t + "]").find(".value.added").hide(), $(".wish_item.to[data-item=" + t + "]").show(), $(".wish_item.in[data-item=" + t + "]").hide(), $(".like_icons").each(function () {
            $(this).find(".wish_item_button").length && ($(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').removeClass("added"), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').find(".value").show(), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').find(".value.added").hide())
        })) : ($(".wish_item[data-item=" + t + "]").addClass("added"), $(".wish_item[data-item=" + t + "]").find(".value").hide(), $(".wish_item[data-item=" + t + "]").find(".value.added").css("display", "block"), $(".wish_item.to[data-item=" + t + "]").hide(), $(".wish_item.in[data-item=" + t + "]").show(), $(".like_icons").each(function () {
            $(this).find(".wish_item_button").length && ($(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').addClass("added"), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').find(".value").hide(), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"]').find(".value.added").show())
        })) : $(this).hasClass("added") ? (r || ($(this).hide(), $(this).closest(".wish_item_button").find(".to").show()), $(".like_icons").each(function () {
            $(this).find('.wish_item.text[data-item="' + t + '"]').length && ($(this).find('.wish_item.text[data-item="' + t + '"]').removeClass("added"), $(this).find('.wish_item.text[data-item="' + t + '"]').find(".value").show(), $(this).find('.wish_item.text[data-item="' + t + '"]').find(".value.added").hide());
            $(this).find(".wish_item_button").length && ($(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"].to').show(), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"].in').hide())
        })) : (r || ($(this).hide(), $(this).closest(".wish_item_button").find(".in").addClass("added").show()), $(".like_icons").each(function () {
            $(this).find('.wish_item.text[data-item="' + t + '"]').length && ($(this).find('.wish_item.text[data-item="' + t + '"]').addClass("added"), $(this).find('.wish_item.text[data-item="' + t + '"]').find(".value").hide(), $(this).find('.wish_item.text[data-item="' + t + '"]').find(".value.added").css({display: "block"}));
            $(this).find(".wish_item_button").length && ($(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"].to').hide(), $(this).find(".wish_item_button").find('.wish_item[data-item="' + t + '"].in').show())
        })), $(".in-cart[data-item=" + t + "]").hide(), $(".to-cart[data-item=" + t + "]").removeClass("clicked"), $(".to-cart[data-item=" + t + "]").parent().removeClass("wide"), $(".counter_block[data-item=" + t + "]").closest(".counter_wrapp").find(".to-order").length || ($(".to-cart[data-item=" + t + "]").show(), $(".counter_block[data-item=" + t + "]").closest(".counter_block_inner").show(), $(".counter_block[data-item=" + t + "]").show()), r && (i.toggleClass("added"), i.hasClass("added") ? i.attr("title", i.data("title2")) : i.attr("title", i.data("title")), u.find(".basket_item_add").length && u.find(".basket_item_add").removeClass("added")), $(this).closest(".module-cart").size() || $.ajax({
            type: "GET",
            url: arAsproOptions.SITE_DIR + "ajax/item.php",
            data: "item=" + o + "&quantity=" + f + "&wish_item=Y&offers=" + e + "&iblockID=" + s + "&props=" + JSON.stringify(c),
            dataType: "json",
            success: function (n) {
                if (getActualBasket(s), arStatusBasketAspro = {}, n !== null) if (n.MESSAGE_EXT === null && (n.MESSAGE_EXT = ""), "STATUS" in n) if (n.STATUS === "OK") {
                    if (arAsproOptions.COUNTERS.USE_BASKET_GOALS !== "N") {
                        var t = {goal: "goal_wish_add", params: {id: o}};
                        BX.onCustomEvent("onCounterGoals", [t])
                    }
                    $("#ajax_basket").length && reloadTopBasket("wish", $("#ajax_basket"), 200, 5e3, "N");
                    $("#basket_line .basket_fly").length && (i.closest(".fast_view_frame").length || window.matchMedia("(max-width: 767px)").matches || $("#basket_line .basket_fly.loaded").length ? basketFly("wish", "N") : basketFly("wish"))
                } else showBasketError(BX.message(n.MESSAGE) + " <br/>" + n.MESSAGE_EXT, BX.message("ERROR_ADD_DELAY_ITEM")); else showBasketError(BX.message(n.MESSAGE) + " <br/>" + n.MESSAGE_EXT, BX.message("ERROR_ADD_DELAY_ITEM")); else $("#ajax_basket").length && reloadTopBasket("wish", $("#ajax_basket"), 200, 5e3, "N"), $("#basket_line .basket_fly").length && (i.closest(".fast_view_frame").length || window.matchMedia("(max-width: 767px)").matches || $("#basket_line .basket_fly.loaded").length ? basketFly("wish", "N") : basketFly("wish"));
                i.removeClass("clicked")
            }
        }))
    });
    $(document).on("click", ".item_main_info .item_slider .flex-direction-nav li span", function () {
        $(".inner_slider .slides_block").length && ($(this).parent().hasClass("flex-nav-next") ? $(".inner_slider .slides_block li.current").next().click() : $(".inner_slider .slides_block li.current").prev().click())
    });
    $(document).on("click", ".compare_item, .compare_item_add", function (n) {
        var f;
        n.preventDefault();
        var t = $(this).attr("data-item"), r = $(this).attr("data-iblock"), u = !1, i = $(this);
        i.closest(".banner_buttons.with_actions").length && (f = i.closest(".wraps_buttons"), t = f.data("id"), r = f.data("iblockid"), u = !0, i.toggleClass("added"), i.hasClass("added") ? i.attr("title", i.data("title2")) : i.attr("title", i.data("title")));
        i.hasClass("clicked") || (i.addClass("clicked"), $(this).hasClass("text") ? $(this).hasClass("added") ? ($(".compare_item[data-item=" + t + "]").removeClass("added"), $(".compare_item[data-item=" + t + "]").find(".value").show(), $(".compare_item[data-item=" + t + "]").find(".value.added").hide(), $(".like_icons").each(function () {
            $(this).find(".compare_item_button").length && ($(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').removeClass("added"), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').find(".value").show(), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').find(".value.added").hide())
        })) : ($(".compare_item[data-item=" + t + "]").addClass("added"), $(".compare_item[data-item=" + t + "]").find(".value").hide(), $(".compare_item[data-item=" + t + "]").find(".value.added").css("display", "block"), $(".like_icons").each(function () {
            $(this).find(".compare_item_button").length && ($(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').addClass("added"), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').find(".value.added").show(), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"]').find(".value").hide())
        })) : $(this).hasClass("added") ? (u || ($(this).hide(), $(this).closest(".compare_item_button").find(".to").show()), $(".like_icons").each(function () {
            $(this).find('.compare_item.text[data-item="' + t + '"]').length && ($(this).find('.compare_item.text[data-item="' + t + '"]').removeClass("added"), $(this).find('.compare_item.text[data-item="' + t + '"]').find(".value").show(), $(this).find('.compare_item.text[data-item="' + t + '"]').find(".value.added").hide());
            $(this).find(".compare_item_button").length && ($(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"].in').hide(), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"].to').show())
        })) : (u || ($(this).hide(), $(this).closest(".compare_item_button").find(".in").show()), $(".like_icons").each(function () {
            $(this).find('.compare_item.text[data-item="' + t + '"]').length && ($(this).find('.compare_item.text[data-item="' + t + '"]').addClass("added"), $(this).find('.compare_item.text[data-item="' + t + '"]').find(".value").hide(), $(this).find('.compare_item.text[data-item="' + t + '"]').find(".value.added").css({display: "block"}));
            $(this).find(".compare_item_button").length && ($(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"].to').hide(), $(this).find(".compare_item_button").find('.compare_item[data-item="' + t + '"].in').show())
        })), $.get(arAsproOptions.SITE_DIR + "ajax/item.php?item=" + t + "&compare_item=Y&iblock_id=" + r, $.proxy(function () {
            getActualBasket(r, "Compare");
            arStatusBasketAspro = {};
            $("#compare_fly").length && jsAjaxUtil.InsertDataToNode(arAsproOptions.SITE_DIR + "ajax/show_compare_preview_fly.php", "compare_fly", !1);
            i.removeClass("clicked")
        })))
    });
    $(document).on("click", ".tabs>li", function () {
        var f = $(this).parent(), t, r, u;
        if (!$(this).hasClass("active")) {
            var i = $(this).index(),
                e = $(this).closest(".top_block").find(".slider_navigation").find(">li:eq(" + i + ")"),
                n = $(this).closest(".top_block").siblings(".tabs_content").find(">li:eq(" + i + ")");
            $(this).addClass("active").addClass("cur").siblings().removeClass("active").removeClass("cur");
            n.addClass("cur").siblings().removeClass("cur");
            e.addClass("cur").siblings().removeClass("cur");
            f.hasClass("ajax") && ($(this).hasClass("clicked") ? (t = n.closest(".content_wrapper_block"), t.length && (r = n.find(".bottom_nav .module-pagination").length > 0, r ? t.removeClass("without-border") : t.addClass("without-borded"))) : ($.ajax({
                url: arAsproOptions.SITE_DIR + "include/mainpage/comp_catalog_ajax.php",
                type: "POST",
                data: {
                    AJAX_POST: "Y",
                    FILTER_HIT_PROP: $(this).data("code"),
                    AJAX_PARAMS: $(this).closest(".tab_slider_wrapp").find(".request-data").data("value"),
                    GLOBAL_FILTER: n.data("filter")
                }
            }).success(function (t) {
                var i, r;
                n.find(".tabs_slider").html(t);
                i = n.closest(".content_wrapper_block");
                i.length && (r = n.find(".bottom_nav .module-pagination").length > 0, r ? i.removeClass("without-border") : i.addClass("without-borded"));
                setTimeout(function () {
                    n.addClass("opacity1")
                }, 100);
                initCountdown()
            }), $(this).addClass("clicked")));
            u = {index: i, target: $(this)};
            BX.onCustomEvent("clickedTabsLi", [u])
        }
    });
    $(".search_block .icon").on("click", function () {
        var n = $(this);
        $(this).hasClass("open") ? ($(this).closest(".center_block").find(".search_middle_block").removeClass("active"), $(this).removeClass("open"), $(this).closest(".center_block").find(".search_middle_block").find(".noborder").hide()) : (setTimeout(function () {
            n.closest(".center_block").find(".search_middle_block").find(".noborder").show()
        }, 100), $(this).closest(".center_block").find(".search_middle_block").addClass("active"), $(this).addClass("open"))
    });
    $(document).on("click", ".no_goods .button", function () {
        $(".bx_filter .smartfilter .bx_filter_search_reset").trigger("click")
    });
    $(document).on("click", ".js-load-link", function (n) {
        AjaxClickLink(n)
    });
    $(document).on("click", ".svg-inline-bottom_nav-icon", function () {
        $(this).next().trigger("click")
    });
    $(document).on("click", ".ajax_load_btn", function () {
        console.log("ajax_load_btn is clicked");
        var n = $(this),
            t = n.closest(".container").find(".module-pagination .flex-direction-nav .flex-next").attr("href"),
            r = n.find(".more_text_ajax"), i = n.closest(".bottom_nav"), u = i.hasClass("mobile_slider"),
            f = n.closest(".animate-load-state").length;
        loadMore(t, !1)
    });
    $(document).on("mouseenter", ".form .votes_block.with-text .item-rating", function () {
        var n = $(this), t = n.index(), r = n.data("rating_value"), i = n.data("message");
        $(this).addClass("filed");
        n.siblings().each(function () {
            $(this).index() <= t ? $(this).addClass("filed") : $(this).removeClass("filed")
        });
        n.closest(".votes_block").find(".rating_message").text(i)
    });
    $(document).on("mouseleave", ".form .votes_block.with-text", function () {
        var n = $(this), t = n.data("rating"), i = n.closest(".votes_block").find(".rating_message").data("message");
        n.find(".item-rating").each(function () {
            $(this).index() < t && t !== undefined ? $(this).addClass("filed") : $(this).removeClass("filed")
        });
        n.closest(".votes_block").find(".rating_message").text(i)
    });
    $(document).on("click", ".form .votes_block.with-text .item-rating", function () {
        var n = $(this), r = n.closest(".votes_block").data("rating"), t = n.index() + 1, i = n.data("message");
        n.closest(".votes_block").data("rating", t);
        n.closest(".form-control").find("input[name=RATING]").length ? n.closest(".form-control").find("input[name=RATING]").val(t) : n.closest(".form-control").find("input[data-sid=RATING]").val(t);
        n.closest(".votes_block").find(".rating_message").data("message", i)
    });
    $(document).on("click", ".bx_ordercart_order_table_container .control > a, .basket-item-actions-remove, a[data-entity=basket-item-remove-delayed]", function () {
        $.removeCookie("click_basket", {path: "/"});
        $.cookie("click_basket", "Y", {path: "/"})
    });
    $(document).on("click", ".bx_compare .tabs-head li", function () {
        var n = $(this).find(".sortbutton").data("href");
        BX.showWait(BX("bx_catalog_compare_block"));
        $.ajax({
            url: n, data: {ajax_action: "Y"}, success: function (t) {
                history.pushState(null, null, n);
                $("#bx_catalog_compare_block").html(t);
                BX.closeWait()
            }
        })
    });
    $(document).on({
        mouseover: function (n) {
            var t = $(this), i = t.closest("tbody").index() + 1, r = t.index() + 1;
            s = $(n.delegateTarget).find(".data_table_props").children(":nth-child(" + i + ")").children(":nth-child(" + r + ")").addClass("hovered")
        }, mouseleave: function () {
            s && s.removeClass("hovered")
        }
    }, ".bx_compare .data_table_props tbody>tr");
    $(document).on("click", ".fancy_zoom", function (n) {
        n.preventDefault();
        var t = [], i = 0;
        ($(this).closest(".product-detail-gallery__container").find(".product-detail-gallery__thmb-container .product-detail-gallery__item").each(function () {
            var n = {};
            n = {src: $(this).data("big")};
            $(this).parent().hasClass("current") && (i = $(this).parent().index());
            t.push(n)
        }), t.length || t.push({src: $(this).closest(".product-detail-gallery__container").find(".zoom_picture").data("xoriginal")}), typeof $.fn.fancybox == "function") && $.fancybox.open(t, {
            loop: !1,
            buttons: ["close",]
        }, i)
    });
    $(".tabs_section .tabs-head li").on("click", function () {
        $(this).is(".current") || ($(".tabs_section .tabs-head li").removeClass("current"), $(this).addClass("current"), $(".tabs_section ul.tabs_content li").removeClass("current"), $(this).attr("id") == "product_reviews_tab" ? ($(".shadow.common").hide(), $("#reviews_content").show()) : ($(".shadow.common").show(), $("#reviews_content").hide(), $(".tabs_section ul.tabs_content > li:eq(" + $(this).index() + ")").addClass("current")))
    });
    setTimeout(function () {
        $(".jobs_wrapp .item:first .name tr").trigger("click")
    }, 300);
    $(".choise").on("click", function () {
        var n = $(this);
        typeof n.attr("data-block") != "undefined" && ($(n.attr("data-block")).closest(".tab-pane").length ? ($('.ordered-block a[href="#' + $(n.attr("data-block")).closest(".tab-pane").attr("id") + '"]').click(), n.data("block", ".ordered-block.tabs-block"), $(n.data("block")).data("offset", -100)) : $(n.data("block")).data("offset", -100), scrollToBlock(n.data("block")))
    });
    $(document).on("click", ".buy_block .slide_offer", function () {
        scroll_block($(".js-offers-scroll"))
    });
    $(".share  > .share_wrapp .text").on("click", function () {
        var n = $(this).parent().find(".shares");
        n.is(":visible") || $(this).closest(".share.top").length || $("#content").css("z-index", 3);
        n.fadeToggle(100, function () {
            n.is(":visible") || $("#content").css("z-index", 2)
        })
    });
    $("html, body").on("mousedown", function (n) {
        typeof n.target.className == "string" && n.target.className.indexOf("adm") < 0 && (n.stopPropagation(), $("div.shares").fadeOut(100, function () {
            $("#content").css("z-index", 2);
            $(".price_txt .share_wrapp").removeClass("opened")
        }), $(".search_middle_block").removeClass("active_wide"))
    });
    $(".share_wrapp").find("*").on("mousedown", function (n) {
        n.stopPropagation()
    });
    $(".price_txt .share_wrapp .text").click(function () {
        $(this).parent().toggleClass("opened");
        $(this).parent().find(".shares").fadeToggle()
    });
    $(document).on("click", ".reviews-collapse-link", function () {
        $(".reviews-reply-form").slideToggle()
    });
    $(".panel-collapse").on("hidden.bs.collapse", function () {
        $(this).parent().toggleClass("opened")
    });
    $(".panel-collapse").on("show.bs.collapse", function () {
        $(this).parent().toggleClass("opened")
    });
    $(".accordion-head").on("click", function (n) {
        n.preventDefault();
        $(this).next().hasClass("collapsing") || ($(this).toggleClass("accordion-open"), $(this).toggleClass("accordion-close"))
    });
    if ($("[data-appear-progress-animation]").each(function () {
        var n = $(this);
        n.appear(function () {
            var t = n.attr("data-appear-animation-delay") ? n.attr("data-appear-animation-delay") : 1;
            t > 1 && n.css("animation-delay", t + "ms");
            n.addClass(n.attr("data-appear-animation"));
            setTimeout(function () {
                n.animate({width: n.attr("data-appear-progress-animation")}, 1500, "easeOutQuad", function () {
                    n.find(".progress-bar-tooltip").animate({opacity: 1}, 500, "easeOutQuad")
                })
            }, t)
        }, {accX: 0, accY: -50})
    }), initCountdown(), $(".item.animated-block").length && $(".item.animated-block").appear(function () {
        var n = $(this);
        n.addClass(n.data("animation")).addClass("visible")
    }, {accX: 0, accY: 150}), $(".appear-block").length && $(".appear-block").appear(function () {
        var n = $(this);
        n.removeClass("appear-block");
        CheckFlexSlider();
        InitFlexSlider();
        InitOwlSlider()
    }, {accX: 0, accY: 150}), $(".js-load-block").length) {
        h = parseUrlQuery();
        i = !1;
        "clear_cache" in h && h.clear_cache == "Y" && (i = !0);
        var f = [], c = !0, v = function () {
            var n, t, i;
            if (c && f.length) {
                c = !1;
                n = f.pop();
                n.content = $.trim(n.content);
                n.content.indexOf("/bitrix/js/main/core/core_window.") !== -1 && BX.WindowManager && (n.content = n.content.replace(/<script src="\/bitrix\/js\/main\/core\/core_window\.[^>]*><\/script>/gm, ""));
                n.content.indexOf("/bitrix/js/currency/core_currency.") !== -1 && typeof BX.Currency == "object" && BX.Currency.defaultFormat && (n.content = n.content.replace(/<script src="\/bitrix\/js\/currency\/core_currency\.[^>]*><\/script>/gm, ""));
                n.content.indexOf("/bitrix/js/main/pageobject/pageobject.") !== -1 && BX.PageObject && (n.content = n.content.replace(/<script src="\/bitrix\/js\/main\/pageobject\/pageobject\.[^>]*><\/script>/gm, ""));
                n.content.indexOf("/bitrix/js/main/polyfill/promise/js/promise.") !== -1 && typeof Promise != "undefined" && window.Promise.toString().indexOf("[native code]") !== -1 && (n.content = n.content.replace(/<script src="\/bitrix\/js\/main\/polyfill\/promise\/js\/promise\.[^>]*><\/script>/gm, ""));
                t = BX.processHTML(n.content);
                pauseYmObserver();
                n.block.removeAttr("data-file").removeClass("loader_circle");
                n.block.data("appendTo") ? n.block.find(n.block.data("appendTo"))[0].innerHTML = t.HTML : n.block.find('> div[id*="bx_incl_"]').length ? n.block.find('> div[id*="bx_incl_"]')[0].innerHTML = t.HTML : n.block[0].innerHTML = t.HTML;
                BX.ajax.processScripts(t.SCRIPT);
                i = {action: "jsLoadBlock"};
                BX.onCustomEvent("onCompleteAction", [i, n.block]);
                setTimeout(resumeYmObserver, 500);
                c = !0;
                v()
            }
        };
        $(".js-load-block").appear(function () {
            var n = $(this), t;
            n.data("file") && (t = i ? "?clear_cache=Y" : "", n.data("block") && (n.data("file").indexOf("?") !== -1 ? (i && (t = t.slice(1)), t += "&BLOCK=" + n.data("block")) : t += (i ? "&" : "?") + "BLOCK=" + n.data("block")), $.get(n.data("file") + t).done(function (t) {
                f.push({block: n, content: t});
                f.length == 1 && setTimeout(v, 100)
            }))
        }, {accX: 0, accY: isMobile ? 300 : 150})
    }
    $(document).on("click", ".js-show-info-block", function (n) {
        var t, i, r, u, f, e;
        window.matchMedia("(max-width: 500px)").matches || (t = $(this), n.stopPropagation(), $(".js-info-block").fadeOut(), t.hasClass("opened") ? $(".js-show-info-block").removeClass("opened") : ($(".js-show-info-block").removeClass("opened"), t.addClass("opened")), t.siblings(".js-info-block").length ? t.hasClass("opened") ? (t.siblings(".js-info-block").find(".more-btn a").attr("href", t.closest(".item_info").find("a").attr("href")), t.siblings(".js-info-block").fadeIn(), InitScrollBar()) : t.siblings(".js-info-block").fadeOut() : (i = t.closest(".sa_block").data("fields"), i = i == "null" || i === undefined ? "" : i, r = t.closest(".sa_block").data("user-fields"), r = r == "null" || r === undefined ? "" : r, u = parseUrlQuery(), f = "", "clear_cache" in u && u.clear_cache == "Y" && (f += "?clear_cache=Y"), e = {
            ajax: "Y",
            ELEMENT_ID: t.data("id"),
            FIELDS: i,
            USER_FIELDS: r,
            STORES: t.closest(".sa_block").data("stores") || ""
        }, t.addClass("loadings"), $.post(arAsproOptions.SITE_DIR + "ajax/productStoreAmountCompact.php" + f, e).done(function (n) {
            t.removeClass("loadings");
            $(n).appendTo(t.closest(".sa_block"));
            t.siblings(".js-info-block").find(".more-btn a").attr("href", t.closest(".item_info").find("a").attr("href"));
            InitScrollBar();
            BX.onCustomEvent("onCompleteAction", [{action: "jsShowStores"}, t])
        })))
    });
    $(document).on("click", ".js-info-block .svg-inline-close", function () {
        $(".js-show-info-block").removeClass("opened");
        $(this).closest(".js-info-block").fadeOut()
    });
    $(".menu.adaptive").on("click", function () {
        $(this).toggleClass("opened");
        $(this).hasClass("opened") ? $(".mobile_menu").toggleClass("opened").slideDown() : $(".mobile_menu").toggleClass("opened").slideUp()
    });
    $(".mobile_menu .has-child >a").on("click", function (n) {
        var t = $(this).parent();
        n.preventDefault();
        t.toggleClass("opened");
        t.find(".dropdown").slideToggle()
    });
    $(".mobile_menu .search-input-div input").on("keyup", function (n) {
        var t = $(this).val();
        $(".center_block .stitle_form input").val(t);
        n.keyCode == 13 && $(".center_block .stitle_form form").submit()
    });
    $(".center_block .stitle_form input").on("keyup", function (n) {
        var t = $(this).val();
        $(".mobile_menu .search-input-div input").val(t);
        n.keyCode == 13 && $(".center_block .stitle_form form").submit()
    });
    $(".mobile_menu .search-button-div button").on("click", function (n) {
        n.preventDefault();
        var t = $(this).parents().find("input").val();
        $(".center_block .stitle_form input").val(t);
        $(".center_block .stitle_form form").submit()
    });
    $(document).on("click", ".mega-menu .dropdown-menu", function (n) {
        n.stopPropagation()
    });
    $(document).on("click", ".mega-menu .dropdown-toggle.more-items", function (n) {
        n.preventDefault()
    });
    $(document).on("mouseenter", ".table-menu .dropdown,.table-menu .dropdown-submenu,.table-menu .dropdown-toggle", function () {
    });
    $(document).on("mouseenter", "#headerfixed .table-menu .dropdown-menu .dropdown-submenu", function () {
        setTimeout(function () {
            CheckTopVisibleMenu()
        }, 275)
    });
    $(".mega-menu .search-item .search-icon, .menu-row #title-search .fa-close").on("click", function (n) {
        n.preventDefault();
        $(".menu-row #title-search").toggleClass("hide")
    });
    $(".mega-menu ul.nav .search input").on("keyup", function (n) {
        var t = $(this).val();
        $(".menu-row > .search input").val(t);
        n.keyCode == 13 && $(".menu-row > .search form").submit()
    });
    $(".menu-row > .search input").on("keyup", function (n) {
        var t = $(this).val();
        $(".mega-menu ul.nav .search input").val(t);
        n.keyCode == 13 && $(".menu-row > .search form").submit()
    });
    $(".mega-menu ul.nav .search button").on("click", function (n) {
        n.preventDefault();
        var t = $(this).parents(".search").find("input").val();
        $(".menu-and-search .search input").val(t);
        $(".menu-row > .search form").submit()
    });
    $(".btn.btn-add").on("click", function () {
        $.ajax({
            type: "GET", url: arAsproOptions.SITE_DIR + "ajax/clearBasket.php", success: function () {
            }
        })
    });
    $(".sort_display a").on("click", function () {
        $(this).siblings().removeClass("current");
        $(this).addClass("current")
    });
    $(".sale-order-detail-payment-options-methods-info-change-link").on("click", function () {
        $(this).closest(".sale-order-detail-payment-options-methods-info").addClass("opened").siblings().addClass("opened")
    });
    $(document).on("click", ".expand_block", function () {
        togglePropBlock($(this))
    });
    document.addEventListener("touchend", function (n) {
        if ($(n.target).closest(".menu-item").length || $(n.target).hasClass("menu-item") || ($(".menu-row .dropdown-menu").css({
            display: "none",
            opacity: 0
        }), $(".menu-item").removeClass("hover"), $(".bx-breadcrumb-item.drop").removeClass("hover")), $(n.target).closest(".menu.topest").length || ($(".menu.topest").css({overflow: "hidden"}), $(".menu.topest > li").removeClass("hover")), $(n.target).closest(".full.has-child").length || $(".menu_top_block.catalog_block li").removeClass("hover"), $(n.target).closest(".basket_block").length || ($(".basket_block .link").removeClass("hover"), $(".basket_block .basket_popup_wrapp").slideUp()), !$(n.target).closest(".catalog_item").length) {
            var t = $(".tab:visible").attr("data-unhover") * 1;
            $(".tab:visible").stop().animate({height: t}, 100);
            $(".tab:visible").find(".catalog_item").removeClass("hover");
            $(".tab:visible").find(".catalog_item .buttons_block").stop().fadeOut(233);
            $(".catalog_block").length && ($(".catalog_block").find(".catalog_item_wrapp").removeClass("hover"), $(".catalog_block").find(".catalog_item").removeClass("hover"))
        }
    }, !1);
    touchMenu(".menu-row .menu-item");
    touchTopMenu(".menu.topest li");
    touchLeftMenu(".menu_top_block:not(.in-search) li.full");
    touchBreadcrumbs(".bx-breadcrumb-item.drop");
    $(document).on("keyup", ".coupon .input_coupon input", function () {
        $(this).val().length ? ($(this).removeClass("error"), $(this).closest(".input_coupon").find(".error").remove()) : ($(this).addClass("error"), $("<label class='error'>" + BX.message("INPUT_COUPON") + "<\/label>").insertBefore($(this)))
    });
    showPhoneMask("input[autocomplete=tel]");
    BX.addCustomEvent(window, "onAjaxSuccessFilter", function () {
        setBasketStatusBtn();
        checkLinkedArticles();
        checkLinkedBlocks(".linked-banners-list")
    });
    $(document).on("click", ".block_container .items .item.initied", function () {
        var n = $(this), i = n.data("id"), t = 200;
        n.closest(".items").fadeOut(t, function () {
            n.closest(".block_container").find(".detail_items").fadeIn(t);
            n.closest(".block_container").find(".detail_items .item[data-id=" + i + "]").fadeIn(t);
            var r = n.data("coordinates").split(",");
            typeof map != "undefined" && map.setCenter([r[0], r[1]], 15)
        })
    });
    $(document).on("click", ".block_container .top-close", function () {
        var n = $(this).closest(".block_container").find(".detail_items .item:visible"), t = 200;
        n.fadeOut(t);
        n.closest(".block_container").find(".detail_items").fadeOut(t, function () {
            n.closest(".block_container").find(".items").fadeIn(t);
            typeof map != "undefined" && typeof clusterer != "undefined" && map.setBounds(clusterer.getBounds(), {zoomMargin: 40})
        })
    });
    BX.addCustomEvent(window, "onAjaxSuccess", function (n) {
        n != "OK" && (InitOrderCustom(), showPhoneMask("input[autocomplete=tel]"), $(".bx_filter").length && (window.matchMedia("(min-width: 768px)").matches ? ($(".bx_filter .scrollbar").removeClass("mobile-scroll"), $(".bx_filter .srollbar-custom").removeClass("mobile-scroll"), $(".bx_filter .bx_filter_section form .bx_filter_parameters").removeClass("mobile-scroll"), InitScrollBar(), InitCustomScrollBar()) : ($(".bx_filter .scrollbar").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .srollbar-custom").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .bx_filter_section form .bx_filter_parameters").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .mobile-scroll.scrollbar").length && $(".bx_filter .mobile-scroll.scrollbar").mCustomScrollbar("destroy"), $(".bx_filter .mobile-scroll.srollbar-custom").length && $(".bx_filter .mobile-scroll.srollbar-custom").mCustomScrollbar("destroy"))), $(".catalog_detail").length && !$(".fast_view_frame").length && ($(".bx_filter").remove(), InitFlexSlider(), InitOwlSlider()), arAsproOptions.PAGES.CATALOG_PAGE && (initCountdown(), typeof stickySidebar != "undefined" && window.stickySidebar.updateSticky()), arAsproOptions.PAGES.ORDER_PAGE && orderActions(n), n && typeof n == "object" && "action" in n && n.action === "ajaxContentLoadedTab" && lazyLoadPagenBlock(), InitStickySideBar())
    });
    BX.addCustomEvent(window, "OnBasketChange", function () {
        if (arAsproOptions.PAGES.BASKET_PAGE) {
            var n = 0, t = "";
            typeof BX.Sale != "undefined" ? typeof BX.Sale.BasketComponent != "undefined" && (n = BX.Sale.BasketComponent.result.allSum, t = BX.message("JS_BASKET_COUNT_TITLE").replace("SUMM", n)) : (n = $("#allSum_FORMATED").html().replace(/&nbsp;/g, " "), t = BX.message("JS_BASKET_COUNT_TITLE").replace("SUMM", n));
            $(".js-basket-block .wrap .prices").length && $(".js-basket-block .wrap .prices").html(n);
            $("a.basket-link.basket").length && $("a.basket-link.basket").attr("title", t);
            $(".basket_fly .opener .basket_count").length && $(".basket_fly .opener .basket_count").attr("title", t)
        }
    })
});
funcDefined("setBasketStatusBtn") || (setBasketStatusBtn = function (n) {
    var r = typeof n !== undefined, i, t;
    if (typeof arBasketAspro != "undefined") {
        if ("BASKET" in arBasketAspro && arBasketAspro.BASKET) for (t in arBasketAspro.BASKET) $(".to-cart[data-item=" + t + "]").hide(), $(".counter_block[data-item=" + t + "]").closest(".counter_block_inner").hide(), $(".counter_block[data-item=" + t + "]").hide(), $(".in-cart[data-item=" + t + "]").show(), $(".in-cart[data-item=" + t + "]").closest(".button_block").addClass("wide"), $(".wish_item.to[data-item=" + t + "]").show(), $(".wish_item.in[data-item=" + t + "]").hide(), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .basket_item_add").length && ($(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .basket_item_add").addClass("added"), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .basket_item_add").attr("title", $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .basket_item_add").data("title2")));
        if ("SERVICES" in arBasketAspro && ($needFillServices = $(".buy_services_wrap[data-parent_product]").length, arBasketAspro.SERVICES && $needFillServices)) for (t in arBasketAspro.SERVICES) i = $(".buy_services_wrap[data-parent_product=" + arBasketAspro.SERVICES[t].link_id + "] .services-item[data-item_id=" + arBasketAspro.SERVICES[t].item_id + "]"), i.find('input[name="buy_switch_services"]').prop("checked", !0), i.find('.counter_block input[name="quantity"]').val(arBasketAspro.SERVICES[t].quantity), i.addClass("services_on");
        if ("DELAY" in arBasketAspro && arBasketAspro.DELAY) for (t in arBasketAspro.DELAY) $(".wish_item.to[data-item=" + t + "]").hide(), $(".wish_item.in[data-item=" + t + "]").show(), $(".wish_item[data-item=" + t + "]").find(".value.added").length && ($(".wish_item[data-item=" + t + "]").find(".value").hide(), $(".wish_item[data-item=" + t + "]").find(".value.added").css("display", "block")), $(".in-cart[data-item=" + t + "]").hide(), $(".to-cart[data-item=" + t + "]").show(), $(".to-cart[data-item=" + t + "]").closest(".counter_wrapp").find(".counter_block_inner").show(), $(".to-cart[data-item=" + t + "]").closest(".counter_wrapp").find(".counter_block").show(), $(".to-cart[data-item=" + t + "]").closest(".button_block").removeClass("wide"), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .wish_item_add").length && ($(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .wish_item_add").addClass("added"), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .wish_item_add").attr("title", $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .wish_item_add").data("title2")));
        if ("SUBSCRIBE" in arBasketAspro && arBasketAspro.SUBSCRIBE) for (t in arBasketAspro.SUBSCRIBE) $(".to-subscribe[data-item=" + t + "]").hide(), $(".in-subscribe[data-item=" + t + "]").show();
        if ("COMPARE" in arBasketAspro && arBasketAspro.COMPARE) for (t in arBasketAspro.COMPARE) $(".compare_item.to[data-item=" + t + "]").hide(), $(".compare_item.in[data-item=" + t + "]").show(), $(".compare_item[data-item=" + t + "]").find(".value.added").length && ($(".compare_item[data-item=" + t + "]").find(".value").hide(), $(".compare_item[data-item=" + t + "]").find(".value.added").css("display", "block")), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .compare_item_add").length && ($(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .compare_item_add").addClass("added"), $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .compare_item_add").attr("title", $(".banner_buttons.with_actions .wraps_buttons[data-id=" + t + "] .compare_item_add").data("title2")))
    }
});
funcDefined("togglePropBlock") || (togglePropBlock = function (n) {
    var t = n.closest(".bx_filter_parameters_box_container").find(".hidden_values");
    t.length && (n.hasClass("inner_text") || n.hasClass("expand_block")) && (t.is(":visible") ? (n.text(BX.message("FILTER_EXPAND_VALUES")), t.hide()) : (n.text(BX.message("FILTER_HIDE_VALUES")), t.show()))
});
funcDefined("showPhoneMask") || (showPhoneMask = function (n) {
    $(n).inputmask("mask", {mask: arAsproOptions.THEME.PHONE_MASK, showMaskOnHover: !1})
});
funcDefined("getActualBasket") || (getActualBasket = function (n, t, i) {
    var r = "";
    typeof n != "undefined" && n && (r = {iblockID: n});
    $.ajax({
        type: "GET", url: arAsproOptions.SITE_DIR + "ajax/actualBasket.php", data: r, success: function (n) {
            if ($(".js_ajax").length || $("body").append('<div class="js_ajax"><\/div>'), $(".js_ajax").html(n), typeof i != "undefined" && setBasketStatusBtn(!0), typeof t !== undefined) {
                var r = {action: "loadActualBasket" + t};
                BX.onCustomEvent("onCompleteAction", [r])
            }
        }
    })
});
funcDefined("reloadBasketCounters") || (reloadBasketCounters = function (n, t) {
    n ? $(".basket-link.basket .count, .wraps_icon_block.basket .count .items > span").text(n) : $.ajax({
        type: "GET",
        url: arAsproOptions.SITE_DIR + "ajax/actualBasket.php",
        data: "",
        success: function (n) {
            $(".js_ajax").length || $("body").append('<div class="js_ajax"><\/div>');
            $(".js_ajax").html(n);
            var i = typeof arBasketAspro.SERVICES != "undefined" ? Object.keys(arBasketAspro.SERVICES).length : 0;
            $(".basket-link.basket .count, .wraps_icon_block.basket .count .items > span").text(Object.keys(arBasketAspro.BASKET).length + i);
            $(".basket-link.delay .count, .wraps_icon_block.delay .count .items > span").text(Object.keys(arBasketAspro.DELAY).length);
            $(".basket-link.compare .count, .wraps_icon_block.compare .count .items > span").text(Object.keys(arBasketAspro.COMPARE).length);
            typeof t != "undefined" && setBasketStatusBtn(!0)
        }
    })
});
checkMobileRegion = function () {
    $(".confirm_region").length && ($(".top_mobile_region").length || $('<div class="top_mobile_region"><div class="confirm_wrapper"><div class="confirm_region"><\/div><\/div><\/div>').insertBefore($("#mobileheader")), $(".top_mobile_region .confirm_region").html($(".confirm_region").html()))
};
funcDefined("orderActions") || (orderActions = function (n) {
    var e, s, w, h, v, o, r, t, u, f, c, l, a;
    if (arAsproOptions.PAGES.ORDER_PAGE) {
        if ($("#bx-soa-order input[autocomplete=tel]").length) {
            for (e = 0; e < BX.Sale.OrderAjaxComponent.result.ORDER_PROP.properties.length; ++e) BX.Sale.OrderAjaxComponent.result.ORDER_PROP.properties[e].IS_PHONE == "Y" && (s = BX.Sale.OrderAjaxComponent.result.ORDER_PROP.properties[e]);
            if (typeof BX.Sale.OrderAjaxComponent != "undefined" && typeof BX.Sale.OrderAjaxComponent == "object" && typeof s == "object" && s) {
                BX.Sale.OrderAjaxComponent.validatePhone = function (n, t) {
                    var f;
                    if (!n || !t) return [];
                    var r = n.value, i = [], e = BX.util.htmlspecialchars(t.NAME),
                        u = BX.message("SOA_FIELD") + ' "' + e + '"';
                    if (t.REQUIRED == "Y" && r.length == 0 && i.push(u + " " + BX.message("SOA_REQUIRED")), t.IS_PHONE == "Y" && r.length > 0) {
                        function t(n, t, i) {
                            var r = new RegExp(i);
                            return r.test(n)
                        }

                        console.log(arAsproOptions.THEME.VALIDATE_PHONE_MASK);
                        f = t($(n).val(), $(n), arAsproOptions.THEME.VALIDATE_PHONE_MASK);
                        f || i.push(u + " " + BX.message("JS_FORMAT_ORDER"))
                    }
                    return i
                };
                BX.Sale.OrderAjaxComponent.getValidationDataPhone = function (n, t) {
                    var i = {}, r;
                    switch (n.TYPE) {
                        case"STRING":
                            if (i.action = "blur", i.func = BX.delegate(function (t, i) {
                                return this.validatePhone(t, n, i)
                            }, this), r = t.querySelectorAll("input[type=tel]"), $(r).length) {
                                i.inputs = r;
                                break
                            }
                    }
                    return i
                };
                BX.Sale.OrderAjaxComponent.bindValidationPhone = function (n, t) {
                    if (this.validation.properties && this.validation.properties[n]) {
                        var f = this.validation.properties[n], i = this.getValidationDataPhone(f, t), r, u;
                        if (i && i.inputs && i.action) for (r = 0; r < $(i.inputs).length; r++) if (BX.type.isElementNode(i.inputs[r])) BX.bind(i.inputs[r], i.action, BX.delegate(function () {
                            this.isValidProperty(i)
                        }, this)); else for (u = 0; u < $(i.inputs[r]).length; u++) BX.bind(i.inputs[r][u], i.action, BX.delegate(function () {
                            this.isValidProperty(i)
                        }, this))
                    }
                };
                BX.Sale.OrderAjaxComponent.isValidPropertiesBlock = function (n) {
                    if (!this.options.propertyValidation) return [];
                    for (var u = this.orderBlockNode.querySelectorAll(".bx-soa-customer-field[data-property-id-row]"), f = [], e, i, o, r, t = 0; t < u.length; t++) (e = u[t].getAttribute("data-property-id-row"), n && this.locations[e]) || (i = u[t].querySelector(".soa-property-container"), i && (o = this.validation.properties[e], r = this.getValidationData(o, i), dataPhone = this.getValidationDataPhone(o, i), r = $.extend({}, r, dataPhone), f = f.concat(this.isValidProperty(r, !0))));
                    return f
                };
                var i = $("input[autocomplete=tel]"), b = i[0].outerHTML, y = i.val(),
                    p = i[0].outerHTML.replace('type="text"', 'type="tel" value="' + y + '"');
                $(i).length < 2 && (i.hide(), $(p).insertAfter(i));
                showPhoneMask("input[autocomplete=tel][type=tel]");
                $("input[autocomplete=tel][type=tel]").on("blur", function () {
                    var n = $(this), t = n.val();
                    n.parent().find("input[autocomplete=tel][type=text]").val(t)
                });
                BX.Sale.OrderAjaxComponent.bindValidationPhone(s.ID, $("input[autocomplete=tel]").parent()[0])
            }
        }
        if ($(".bx-soa-cart-total").length) {
            if ($(".change_basket").length || $(".bx-soa-cart-total").prepend('<div class="change_basket">' + BX.message("BASKET_CHANGE_TITLE") + '<a href="' + arAsproOptions.SITE_DIR + 'basket/" class="change_link">' + BX.message("BASKET_CHANGE_LINK") + "<\/a><\/div>"), typeof BX.Sale.OrderAjaxComponent == "object") {
                if (arAsproOptions.COUNTERS.USE_FULLORDER_GOALS !== "N" && typeof BX.Sale.OrderAjaxComponent.reachgoalbegin == "undefined") {
                    BX.Sale.OrderAjaxComponent.reachgoalbegin = !0;
                    w = {goal: "goal_order_begin"};
                    BX.onCustomEvent("onCounterGoals", [w])
                }
                if (BX.Sale.OrderAjaxComponent.hasOwnProperty("params") && ($(".bx-soa-cart-total .change_link").attr("href", BX.Sale.OrderAjaxComponent.params.PATH_TO_BASKET), arAsproOptions.PRICES.MIN_PRICE && arAsproOptions.PRICES.MIN_PRICE > Number(BX.Sale.OrderAjaxComponent.result.TOTAL.ORDER_PRICE) && ($('<div class="fademask_ext"><\/div>').appendTo($("body")), location.href = BX.Sale.OrderAjaxComponent.params.PATH_TO_BASKET)), $("#bx-soa-auth").length && !$("#bx-soa-auth .redisigned").length && ($('input[name="USER_LOGIN"]').length && (t = $('input[name="USER_LOGIN"]').closest(".bx-authform-formgroup-container").find(".bx-authform-label-container"), t.find(".bx-authform-starrequired").length || t.html(t.html() + '<span class="bx-authform-starrequired"> *<\/span>')), $('input[name="USER_PASSWORD"]').length && (t = $('input[name="USER_PASSWORD"]').closest(".bx-authform-formgroup-container").find(".bx-authform-label-container"), t.find(".bx-authform-starrequired").length || t.html(t.html() + '<span class="bx-authform-starrequired"> *<\/span>')), $('input[name="USER_REMEMBER"]').length && (t = $('input[name="USER_REMEMBER"]').attr("id", "ORDER_AUTH_USER_REMEMBER").closest("label").attr("for", "ORDER_AUTH_USER_REMEMBER"), r = $('input[name="USER_REMEMBER"]').attr("id", "ORDER_AUTH_USER_REMEMBER").wrap('<div id="trem_"><\/div>').parent().html(), $("#trem_").remove(), t.html(t.text()), $(r).insertBefore(t).closest(".bx-authform-formgroup-container").addClass("filter"), r = $("#bx-soa-auth .bx-authform>a").addClass("pull-right").addClass("forgot").wrap('<div id="trem_"><\/div>').parent().html(), $("#trem_").remove(), $(r).insertAfter(t.closest(".checkbox"))), $("#bx-soa-auth .bx-soa-reg-block .btn").removeClass("btn-default").removeClass("btn-lg").addClass("transparent").addClass("btn-lg").text(BX.message("ORDER_REGISTER_BUTTON")), $("#bx-soa-auth").append('<div class="redisigned hidden><\/div>')), $(".bx-soa-section-content.reg").length && !$(".bx-soa-section-content.reg .redisigned").length) {
                    if (h = !1, arAsproOptions.THEME.LOGIN_EQUAL_EMAIL === "Y" && (h = !0, $('input[name="NEW_LOGIN"]').length && $('input[name="NEW_LOGIN"]').closest(".bx-authform-formgroup-container").hide()), arAsproOptions.THEME.PERSONAL_ONEFIO === "Y" && (h = !0, $('input[name="NEW_NAME"]').length && $('input[name="NEW_NAME"]').closest(".bx-authform-formgroup-container").find(".bx-authform-label-container").html(BX.message("ORDER_FIO_LABEL") + '<span class="bx-authform-starrequired"> *<\/span>'), $('input[name="NEW_LAST_NAME"]').length && ($('input[name="NEW_LAST_NAME"]').closest(".bx-authform-formgroup-container").hide(), $('input[name="NEW_LAST_NAME"]').val(" "))), h && (v = $("#do_register~input[type=submit]"), v.length)) {
                        BX.unbindAll(v[0]);
                        $(document).on("click", "#do_register~input[type=submit]", function (n) {
                            if (n.preventDefault(), n.stopImmediatePropagation(), arAsproOptions.THEME.LOGIN_EQUAL_EMAIL === "Y") {
                                var t = BX.findChild(BX("bx-soa-auth"), {attribute: {name: "NEW_EMAIL"}}, !0, !1),
                                    i = BX.findChild(BX("bx-soa-auth"), {attribute: {name: "NEW_LOGIN"}}, !0, !1);
                                i && t && (i.value = t.value)
                            }
                            BX("do_register").value = "Y";
                            BX.Sale.OrderAjaxComponent.sendRequest("showAuthForm")
                        })
                    }
                    if (o = $(".bx-soa-section-content.reg").find(".bx-captcha"), o.length && (o.addClass("captcha_image"), o.append('<div class="captcha_reload"><\/div>'), o.closest(".bx-authform-formgroup-container").addClass("captcha-row").find("input[name=captcha_word]").closest(".bx-authform-input-container").addClass("captcha_input")), $("input[name=NEW_NAME]").length && $("input[name=NEW_LAST_NAME]").length && arAsproOptions.THEME.PERSONAL_ONEFIO !== "Y" && ($("input[name=NEW_NAME]").closest(".bx-authform-formgroup-container.col-md-6").length || ($("input[name=NEW_NAME],input[name=NEW_LAST_NAME]").closest(".bx-authform-formgroup-container").addClass("col-md-6"), r = $("input[name=NEW_LAST_NAME]").closest(".bx-authform-formgroup-container").wrap('<div id="trem_"><\/div>').parent().html(), $("#trem_").remove(), $(r).insertAfter($("input[name=NEW_NAME]").closest(".bx-authform-formgroup-container").wrap('<div class="row"><\/div>')))), $("input[name=NEW_EMAIL]").length && $("input[name=PHONE_NUMBER]").length && ($("input[name=PHONE_NUMBER]").closest(".bx-authform-formgroup-container.col-md-6").length || ($("input[name=NEW_EMAIL],input[name=PHONE_NUMBER]").closest(".bx-authform-formgroup-container").addClass("col-md-6"), r = $("input[name=PHONE_NUMBER]").closest(".bx-authform-formgroup-container").wrap('<div id="trem_"><\/div>').parent().html(), $("#trem_").remove(), $(r).insertAfter($("input[name=NEW_EMAIL]").closest(".bx-authform-formgroup-container").wrap('<div class="row"><\/div>')))), $("input[name=NEW_PASSWORD]").length && $("input[name=NEW_PASSWORD_CONFIRM]").length && ($("input[name=NEW_PASSWORD]").closest(".bx-authform-formgroup-container.col-md-6").length || ($("input[name=NEW_PASSWORD],input[name=NEW_PASSWORD_CONFIRM]").closest(".bx-authform-formgroup-container").addClass("col-md-6"), r = $("input[name=NEW_PASSWORD_CONFIRM]").closest(".bx-authform-formgroup-container").wrap('<div id="trem_"><\/div>').parent().html(), $("#trem_").remove(), $(r).insertAfter($("input[name=NEW_PASSWORD]").closest(".bx-authform-formgroup-container").wrap('<div class="row"><\/div>')))), $("input[name=PHONE_NUMBER]").length) {
                        var i = $("input[name=PHONE_NUMBER]"), b = i[0].outerHTML, y = i.val(),
                            p = i[0].outerHTML.replace('type="text"', 'type="tel" value="' + y + '"');
                        if ($(i).length < 2) {
                            i.hide();
                            $(p).insertAfter(i);
                            showPhoneMask("input[name=PHONE_NUMBER][type=tel]");
                            $("input[name=PHONE_NUMBER][type=tel]").on("blur", function () {
                                var n = $(this), t = n.val();
                                n.parent().find("input[name=PHONE_NUMBER][type=text]").val(t)
                            });
                            t = $("input[name=PHONE_NUMBER][type=tel]").closest(".bx-authform-formgroup-container").find(".bx-authform-label-container");
                            t.html(BX.message("ORDER_PHONE_LABEL") + (t.find(".bx-authform-starrequired").length ? '<span class="bx-authform-starrequired"> *<\/span>' : ""))
                        }
                    }
                    $(".bx-soa-section-content.reg").append('<div class="redisigned hidden><\/div>')
                }
                if (u = arAsproOptions.THEME.SHOW_LICENCE == "Y", f = arAsproOptions.THEME.SHOW_OFFER == "Y", $(".bx-soa-cart-total-line-total").length && (u || f)) {
                    if (typeof n == "undefined" && (BX.Sale.OrderAjaxComponent.state_licence = arAsproOptions.THEME.LICENCE_CHECKED == "Y" ? "checked" : "", BX.Sale.OrderAjaxComponent.state_offer = arAsproOptions.THEME.OFFER_CHECKED == "Y" ? "checked" : ""), !$(".licence_block.filter").length && u || !$(".offer_block.filter").length && f) {
                        if ($('<div class="form"><div class="license_order_wrap"><\/div><\/div>').insertBefore($("#bx-soa-orderSave")), !$(".licence_block.filter").length && u && $('<div class="licence_block filter label_block onoff"><label data-for="licenses_order" class="hidden error">' + BX.message("JS_REQUIRED_LICENSES") + '<\/label><input type="checkbox" name="licenses_order" required ' + BX.Sale.OrderAjaxComponent.state_licence + ' value="Y"><label data-for="licenses_order" class="license">' + BX.message("LICENSES_TEXT") + "<\/label><\/div>").appendTo($(".license_order_wrap")), !$(".offer_block.filter").length && f && $('<div class="offer_block filter label_block onoff"><label data-for="offer_order" class="hidden error">' + BX.message("JS_REQUIRED_OFFER") + '<\/label><input type="checkbox" name="offer_order" required ' + BX.Sale.OrderAjaxComponent.state_offer + ' value="Y"><label data-for="offer_order" class="offer_pub">' + BX.message("OFFER_TEXT") + "<\/label><\/div>").appendTo($(".license_order_wrap")), u) $(document).on("click", ".bx-soa .licence_block label.license", function () {
                            var n = $(this).data("for");
                            $(".bx-soa .licence_block label.error").addClass("hidden");
                            $("input[name=" + n + "]").prop("checked") ? ($("input[name=" + n + "]").prop("checked", ""), BX.Sale.OrderAjaxComponent.state_licence = "") : ($("input[name=" + n + "]").prop("checked", "checked"), BX.Sale.OrderAjaxComponent.state_licence = "checked")
                        });
                        if (f) $(document).on("click", ".bx-soa .offer_block label.offer_pub", function () {
                            var n = $(this).data("for");
                            $(".bx-soa .offer_block label.error").addClass("hidden");
                            $("input[name=" + n + "]").prop("checked") ? ($("input[name=" + n + "]").prop("checked", ""), BX.Sale.OrderAjaxComponent.state_offer = "") : ($("input[name=" + n + "]").prop("checked", "checked"), BX.Sale.OrderAjaxComponent.state_offer = "checked")
                        });
                        $(document).on("click", ".lic_condition a", function () {
                            if (BX.hasClass(BX("bx-soa-order"), "orderform--v1")) BX.Sale.OrderAjaxComponent.isValidForm() && BX.Sale.OrderAjaxComponent.animateScrollTo($(".licence_block, .offer_block")[0], 800, 50); else {
                                var n = BX.Sale.OrderAjaxComponent.isValidPropertiesBlock().length;
                                BX.Sale.OrderAjaxComponent.activeSectionId && n || BX.Sale.OrderAjaxComponent.animateScrollTo($(".licence_block, .offer_block")[0], 800, 50)
                            }
                        })
                    }
                    $("#bx-soa-orderSave, .bx-soa-cart-total-button-container").addClass("lic_condition");
                    typeof BX.Sale.OrderAjaxComponent.oldClickOrderSaveAction == "undefined" && typeof BX.Sale.OrderAjaxComponent.clickOrderSaveAction != "undefined" && (BX.Sale.OrderAjaxComponent.oldClickOrderSaveAction = BX.Sale.OrderAjaxComponent.clickOrderSaveAction, BX.Sale.OrderAjaxComponent.clickOrderSaveAction = function (n) {
                        ($('input[name="licenses_order"]').prop("checked") || !u) && ($('input[name="offer_order"]').prop("checked") || !f) ? ($(".bx-soa .licence_block label.error").addClass("hidden"), $(".bx-soa .offer_block label.error").addClass("hidden"), BX.Sale.OrderAjaxComponent.isValidForm() && (typeof BX.Sale.OrderAjaxComponent.allowOrderSave == "function" && BX.Sale.OrderAjaxComponent.allowOrderSave(), typeof BX.Sale.OrderAjaxComponent.doSaveAction == "function" ? BX.Sale.OrderAjaxComponent.doSaveAction() : BX.Sale.OrderAjaxComponent.oldClickOrderSaveAction(n))) : ($('input[name="licenses_order"]').prop("checked") || $(".bx-soa .licence_block label.error").removeClass("hidden"), $('input[name="offer_order"]').prop("checked") || $(".bx-soa .offer_block label.error").removeClass("hidden"))
                    }, BX.Sale.OrderAjaxComponent.orderSaveBlockNode.querySelector(".checkbox") && typeof browser == "object" && ("msie" in browser && browser.msie ? $(BX.Sale.OrderAjaxComponent.orderSaveBlockNode.querySelector(".checkbox")).remove() : BX.Sale.OrderAjaxComponent.orderSaveBlockNode.querySelector(".checkbox").remove()), BX.unbindAll(BX.Sale.OrderAjaxComponent.totalInfoBlockNode.querySelector("a.btn-order-save")), BX.unbindAll(BX.Sale.OrderAjaxComponent.mobileTotalBlockNode.querySelector("a.btn-order-save")), BX.unbindAll(BX.Sale.OrderAjaxComponent.orderSaveBlockNode.querySelector("a")), BX.bind(BX.Sale.OrderAjaxComponent.totalInfoBlockNode.querySelector("a.btn-order-save"), "click", BX.proxy(BX.Sale.OrderAjaxComponent.clickOrderSaveAction, BX.Sale.OrderAjaxComponent)), BX.bind(BX.Sale.OrderAjaxComponent.mobileTotalBlockNode.querySelector("a.btn-order-save"), "click", BX.proxy(BX.Sale.OrderAjaxComponent.clickOrderSaveAction, BX.Sale.OrderAjaxComponent)), BX.bind(BX.Sale.OrderAjaxComponent.orderSaveBlockNode.querySelector("a"), "click", BX.proxy(BX.Sale.OrderAjaxComponent.clickOrderSaveAction, BX.Sale.OrderAjaxComponent)))
                }
                if ($(window).scroll(), checkCounters() && typeof BX.Sale.OrderAjaxComponent.oldSaveOrder == "undefined" && (c = typeof BX.Sale.OrderAjaxComponent.saveOrder != "undefined" ? "saveOrder" : "saveOrderWithJson", typeof BX.Sale.OrderAjaxComponent[c] != "undefined" && (BX.Sale.OrderAjaxComponent.oldSaveOrder = BX.Sale.OrderAjaxComponent[c], BX.Sale.OrderAjaxComponent[c] = function (n) {
                    var t = BX.parseJSON(n);
                    t && t.order ? t.order.SHOW_AUTH ? BX.Sale.OrderAjaxComponent.oldSaveOrder(n) : t.order.REDIRECT_URL && t.order.REDIRECT_URL.length && (!t.order.ERROR || BX.util.object_keys(t.order.ERROR).length < 1) ? (arMatch = t.order.REDIRECT_URL.match(/ORDER_ID\=[^&=]*/g)) && arMatch.length && (_id = arMatch[0].replace(/ORDER_ID\=/g, "", arMatch[0])) ? $.ajax({
                        url: arAsproOptions.SITE_DIR + "ajax/check_order.php",
                        dataType: "json",
                        type: "POST",
                        data: {ID: _id},
                        success: function (t) {
                            parseInt(t) ? purchaseCounter(parseInt(t), BX.message("FULL_ORDER"), function (t) {
                                typeof localStorage != "undefined" && typeof t == "object" && localStorage.setItem("gtm_e_" + _id, JSON.stringify(t));
                                BX.Sale.OrderAjaxComponent.oldSaveOrder(n)
                            }) : BX.Sale.OrderAjaxComponent.oldSaveOrder(n)
                        },
                        error: function () {
                            BX.Sale.OrderAjaxComponent.oldSaveOrder(n)
                        }
                    }) : BX.Sale.OrderAjaxComponent.oldSaveOrder(n) : BX.Sale.OrderAjaxComponent.oldSaveOrder(n) : BX.Sale.OrderAjaxComponent.oldSaveOrder(n)
                })), $("#bx-soa-order-form .captcha-row").length && window.asproRecaptcha && window.asproRecaptcha.key && window.asproRecaptcha.params.recaptchaSize == "invisible" && ($("#bx-soa-order-form .captcha-row").addClass("invisible"), asproRecaptcha.params.recaptchaLogoShow === "n" && $("#bx-soa-order-form .captcha-row").addClass("logo_captcha_n")), $("#bx-soa-order-form .captcha-row.invisible").length && typeof BX.Sale.OrderAjaxComponent.oldSendRequest == "undefined" && typeof BX.Sale.OrderAjaxComponent.sendRequest != "undefined") {
                    BX.Sale.OrderAjaxComponent.oldSendRequest = BX.Sale.OrderAjaxComponent.sendRequest;
                    BX.Sale.OrderAjaxComponent.sendRequest = function (n, t) {
                        var i = !0, r;
                        $("#bx-soa-order-form .captcha-row.invisible").length && window.renderRecaptchaById && window.asproRecaptcha && window.asproRecaptcha.key && window.asproRecaptcha.params.recaptchaSize == "invisible" && (r = BX("bx-soa-order-form"), $(r).find(".g-recaptcha").length && ($(r).find(".g-recaptcha-response").val() ? i = !0 : typeof grecaptcha != "undefined" ? (grecaptcha.execute($(r).find(".g-recaptcha").data("widgetid")), i = !1) : i = !1));
                        i ? BX.Sale.OrderAjaxComponent.oldSendRequest(n, t) : (l = n, a = t)
                    };
                    $(document).on("submit", "#bx-soa-order-form", function (n) {
                        n.preventDefault();
                        (typeof l != "undefined" || typeof a != "undefined") && (BX.Sale.OrderAjaxComponent.sendRequest(l, a), l = undefined, a = undefined)
                    })
                }
            }
            $(".bx-ui-sls-quick-locations.quick-locations").on("click", function () {
                $(this).siblings().removeClass("active");
                $(this).addClass("active")
            })
        }
    }
});
funcDefined("basketActions") || (basketActions = function () {
    var t, i, n;
    if (arAsproOptions.PAGES.BASKET_PAGE) {
        if (checkMinPrice(), typeof BX.Sale != "undefined" && typeof BX.Sale == "object" && typeof BX.Sale.BasketComponent != "undefined" && typeof BX.Sale.BasketComponent == "object") $(document).on("click", ".basket-item-actions-remove", function () {
            var n = $(this).closest(".basket-items-list-item-container").data("id");
            delFromBasketCounter(BX.Sale.BasketComponent.items[n].PRODUCT_ID)
        });
        if (location.hash && (t = location.hash.substring(1), $("#basket_toolbar_button_" + t).length && $("#basket_toolbar_button_" + t).trigger("click"), $('.basket-items-list-header-filter a[data-filter="' + t + '"]').length && $('.basket-items-list-header-filter a[data-filter="' + t + '"]')[0].click()), i = '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"><path id="Rounded_Rectangle_568_copy_13" data-name="Rounded Rectangle 568 copy 13" class="cls-1" d="M1615.4,589l2.32,2.315a0.987,0.987,0,0,1,0,1.4,1,1,0,0,1-1.41,0L1614,590.4l-2.31,2.315a1,1,0,0,1-1.41,0,0.987,0.987,0,0,1,0-1.4L1612.6,589l-2.32-2.314a0.989,0.989,0,0,1,0-1.4,1,1,0,0,1,1.41,0l2.31,2.315,2.31-2.315a1,1,0,0,1,1.41,0,0.989,0.989,0,0,1,0,1.4Z" transform="translate(-1610 -585)"/><\/svg>', $(".bx_sort_container").append('<div class="top_control basket_action"><span style="opacity:0;" class="delete_all colored_theme_hover_text remove_all_basket">' + i + BX.message("BASKET_CLEAR_ALL_BUTTON") + "<\/span><\/div>"), $(".basket-items-list-header-filter").length) {
            $(".basket-items-list-header-filter").append('<div class="top_control basket_action"><span style="opacity:1;" class="delete_all colored_theme_hover_text remove_all_basket">' + i + BX.message("BASKET_CLEAR_ALL_BUTTON") + "<\/span><\/div>");
            n = $(".basket-items-list-header-filter > a.active").index();
            n == 3 && (n = 2);
            $(".basket-items-list-header-filter > a.active").data("filter") == "all" && (n = "all");
            $(".basket-items-list-header-filter .top_control .delete_all").data("type", n);
            $(".basket-items-list-header-filter > a").on("click", function () {
                var n = $(this).index();
                n == 3 && (n = 2);
                $(this).data("filter") == "all" && (n = "all");
                $(".basket-items-list-header-filter .top_control .delete_all").data("type", n)
            })
        } else {
            n = $(".bx_sort_container a.current").index();
            $(".bx_sort_container .top_control .delete_all").data("type", n);
            $(".bx_ordercart > div:eq(" + n + ") table tbody tr td.item").length && $(".bx_sort_container .top_control .delete_all").css("opacity", 1);
            $(".bx_ordercart .bx_ordercart_coupon #coupon").wrap('<div class="input"><\/div>');
            $(".bx_sort_container > a").on("click", function () {
                var n = $(this).index();
                $(".bx_sort_container .top_control .delete_all").data("type", n);
                $(".bx_ordercart > div:eq(" + n + ") table tbody tr td.item").length ? $(".bx_sort_container .top_control .delete_all").css("opacity", 1) : $(".bx_sort_container .top_control .delete_all").css("opacity", 0)
            })
        }
        $(".basket_print").on("click", function () {
            window.print()
        });
        $(".delete_all").on("click", function () {
            if (arAsproOptions.COUNTERS.USE_BASKET_GOALS !== "N") {
                var n = {goal: "goal_basket_clear", params: {type: $(this).data("type")}};
                BX.onCustomEvent("onCounterGoals", [n])
            }
            $.post(arAsproOptions.SITE_DIR + "ajax/action_basket.php", "TYPE=" + $(this).data("type") + "&CLEAR_ALL=Y", $.proxy(function () {
                location.reload()
            }))
        });
        $(".bx_item_list_section .bx_catalog_item").sliceHeight({row: ".bx_item_list_slide", item: ".bx_catalog_item"});
        BX.addCustomEvent("onAjaxSuccess", function (n) {
            checkMinPrice();
            var t = $.trim($("#warning_message").text());
            $("#basket_items_list .error_text").detach();
            t != "" && ($("#warning_message").hide().text(""), $("#basket_items_list").prepend('<div class="error_text">' + t + "<\/div>"));
            typeof n == "object" && "BASKET_DATA" in n && ($("#ajax_basket").length && reloadTopBasket("add", $("#ajax_basket"), 200, 5e3, "Y"), $("#basket_line .basket_fly").length && basketFly("open", "N"))
        });
        $(document).on("click", ".bx_ordercart_order_pay_center .checkout, .basket-checkout-section-inner .basket-btn-checkout", function () {
            checkCounters("google") && checkoutCounter(1, "start order")
        })
    }
});
funcDefined("checkMinPrice") || (checkMinPrice = function () {
    var t, n, i;
    arAsproOptions.PAGES.BASKET_PAGE && (t = 0, n = 0, $("#allSum_FORMATED").length && (t = $("#allSum_FORMATED").text().replace(/[^0-9\.,]/g, ""), n = parseFloat(t), $("#basket_items").length && (n = 0, $("#basket_items tr").each(function () {
        typeof $(this).data("item-price") != "undefined" && $(this).data("item-price") && (n += $(this).data("item-price") * $(this).find("#QUANTITY_INPUT_" + $(this).attr("id")).val())
    })), $(".catalog_back").length || $(".bx_ordercart_order_pay_center").prepend('<a href="' + arAsproOptions.PAGES.CATALOG_PAGE_URL + '" class="catalog_back btn btn-default btn-lg white grey">' + BX.message("BASKET_CONTINUE_BUTTON") + "<\/a>")), arAsproOptions.THEME.SHOW_ONECLICKBUY_ON_BASKET_PAGE == "Y" && $(".basket-coupon-section").addClass("smallest"), typeof BX.Sale != "undefined" && typeof BX.Sale.BasketComponent != "undefined" && typeof BX.Sale.BasketComponent.result != "undefined" && (n = BX.Sale.BasketComponent.result.allSum), arAsproOptions.PRICES.MIN_PRICE ? arAsproOptions.PRICES.MIN_PRICE > n ? (i = '<i class="svg  svg-inline-price colored_theme_svg" aria-hidden="true"><svg id="Group_278_copy" data-name="Group 278 copy" xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38"><path id="Ellipse_305_copy_2" data-name="Ellipse 305 copy 2" class="clswm-1" d="M1851,561a19,19,0,1,1,19-19A19,19,0,0,1,1851,561Zm0-36a17,17,0,1,0,17,17A17,17,0,0,0,1851,525Zm3.97,10.375-0.03.266c-0.01.062-.02,0.127-0.03,0.188l-0.94,7.515h0a2.988,2.988,0,0,1-5.94,0H1848l-0.91-7.525c-0.01-.041-0.01-0.086-0.02-0.128l-0.04-.316h0.01c-0.01-.125-0.04-0.246-0.04-0.375a4,4,0,0,1,8,0c0,0.129-.03.25-0.04,0.375h0.01ZM1851,533a2,2,0,0,0-2,2,1.723,1.723,0,0,0,.06.456L1850,543a1,1,0,0,0,2,0l0.94-7.544A1.723,1.723,0,0,0,1853,535,2,2,0,0,0,1851,533Zm0,14a3,3,0,1,1-3,3A3,3,0,0,1,1851,547Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,1851,551Z" transform="translate(-1832 -523)"><\/path>  <path class="clswm-2 op-cls" d="M1853,543l-1,1h-2l-1-1-1-8,1-2,1-1h2l1,1,1,2Zm-1,5,1,1v2l-1,1h-2l-1-1v-2l1-1h2Z" transform="translate(-1832 -523)"><\/path><\/svg><\/i>', $(".oneclickbuy.fast_order").length && $(".oneclickbuy.fast_order").remove(), $(".basket-checkout-container").length ? $(".icon_error_wrapper").length || $(".basket-checkout-block.basket-checkout-block-btn").html('<div class="icon_error_wrapper"><div class="icon_error_block">' + i + BX.message("MIN_ORDER_PRICE_TEXT").replace("#PRICE#", jsPriceFormat(arAsproOptions.PRICES.MIN_PRICE)) + "<\/div><\/div>") : ($(".icon_error_wrapper").length || typeof jsPriceFormat == "undefined" || $(".bx_ordercart_order_pay_center").prepend('<div class="icon_error_wrapper"><div class="icon_error_block">' + i + BX.message("MIN_ORDER_PRICE_TEXT").replace("#PRICE#", jsPriceFormat(arAsproOptions.PRICES.MIN_PRICE)) + "<\/div><\/div>"), $(".bx_ordercart_order_pay .checkout").length && $(".bx_ordercart_order_pay .checkout").remove())) : ($(".icon_error_wrapper").length && $(".icon_error_wrapper").remove(), $(".basket-checkout-container").length ? $(".oneclickbuy.fast_order").length || arAsproOptions.THEME.SHOW_ONECLICKBUY_ON_BASKET_PAGE != "Y" || $(".basket-btn-checkout.disabled").length || $(".basket-checkout-section-inner").append('<div class="fastorder"><span class="oneclickbuy btn btn-lg fast_order btn-transparent-border-color" onclick="oneClickBuyBasket()">' + BX.message("BASKET_QUICK_ORDER_BUTTON") + "<\/span><\/div>") : ($(".bx_ordercart_order_pay .checkout").length ? $(".bx_ordercart .bx_ordercart_order_pay .checkout").css("opacity", "1") : $(".bx_ordercart_order_pay_center").append('<a href="javascript:void(0)" onclick="checkOut();" class="checkout" style="opacity: 1;">' + BX.message("BASKET_ORDER_BUTTON") + "<\/a>"), $(".oneclickbuy.fast_order").length || arAsproOptions.THEME.SHOW_ONECLICKBUY_ON_BASKET_PAGE != "Y" || $(".bx_ordercart_order_pay_center").append('<span class="oneclickbuy btn btn-lg fast_order btn-transparent-border-color" onclick="oneClickBuyBasket()">' + BX.message("BASKET_QUICK_ORDER_BUTTON") + "<\/span>"))) : $(".basket-checkout-container").length ? $(".oneclickbuy.fast_order").length || arAsproOptions.THEME.SHOW_ONECLICKBUY_ON_BASKET_PAGE != "Y" || $(".basket-btn-checkout.disabled").length || $(".basket-checkout-section-inner").append('<div class="fastorder"><span class="oneclickbuy btn btn-lg fast_order btn-transparent-border-color" onclick="oneClickBuyBasket()">' + BX.message("BASKET_QUICK_ORDER_BUTTON") + "<\/span><\/div>") : ($(".bx_ordercart .bx_ordercart_order_pay .checkout").css("opacity", "1"), $(".oneclickbuy.fast_order").length || arAsproOptions.THEME.SHOW_ONECLICKBUY_ON_BASKET_PAGE != "Y" || $(".bx_ordercart_order_pay_center").append('<span class="oneclickbuy btn btn-lg fast_order btn-transparent-border-color" onclick="oneClickBuyBasket()">' + BX.message("BASKET_QUICK_ORDER_BUTTON") + "<\/span>")), showBasketShareBtn(), showBasketHeadingBtn(), $("#basket-root .basket-checkout-container .basket-checkout-section .basket-checkout-block .basket-btn-checkout"), $("#basket-root .basket-checkout-container").addClass("visible"))
});
isFrameDataReceived = !1;
typeof frameCacheVars != "undefined" ? (BX.addCustomEvent(window, "onFrameDataRequestFail", function (n) {
    console.log(n)
}), BX.addCustomEvent("onFrameDataReceivedBefore", function () {
    pauseYmObserver()
}), BX.addCustomEvent("onFrameDataReceived", function () {
    var t, n, i;
    initFull();
    CheckTopMenuPadding();
    CheckTopMenuOncePadding();
    CheckTopMenuDotted();
    CheckSearchWidth();
    checkLinkedArticles();
    checkLinkedBlocks(".linked-banners-list");
    $(".logo-row.v2").length && ($(window).resize(), setTimeout(function () {
        CheckTopMenuDotted()
    }, 100));
    funcDefined("setNewHeader") && (typeof BX == "object" && (BX.message("TYPE_SKU") != "TYPE_1" || BX.message("HAS_SKU_PROPS") != "Y") ? setNewHeader() : (t = $(".bx_catalog_item_scu[id]"), t.length && (n = "ob" + t.attr("id").replace("_skudiv", ""), n && window[n] !== undefined && (i = window[n].offers[window[n].offerNum], i !== undefined && setNewHeader(i)))));
    setTimeout(resumeYmObserver, 400);
    isFrameDataReceived = !0
})) : $(document).ready(initFull);
funcDefined("setHeightBlockSlider") || (setHeightBlockSlider = function () {
    var u, i, t, n, r;
    $(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").equalize({children: ".item-title"});
    $(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").equalize({children: ".item_info"});
    $(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").equalize({children: ".catalog_item"});
    u = $(document).find(".specials.tab_slider_wrapp").outerWidth();
    i = $(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").length;
    i <= 1 ? ($(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").css("height", ""), t = 0, $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur .tabs_slider li .footer_button").length && ($(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur .tabs_slider li .footer_button").css("height", "auto"), t = $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur .tabs_slider li .footer_button").height(), $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur .tabs_slider li .footer_button").css("height", "")), n = $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur").height() * 1, r = n + t + 50, $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur").attr("data-unhover", n), $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur").attr("data-hover", r), $(document).find(".specials.tab_slider_wrapp .tabs_content").height(n), $(document).find(".specials.tab_slider_wrapp .tabs_content .tab.cur .flex-viewport").height(n)) : $(document).find(".specials.tab_slider_wrapp .tabs_content > li.cur").each(function () {
        var n = $(this), i, t, r;
        n.css("height", "");
        i = 0;
        n.find(".tabs_slider li .footer_button").length && (n.find(".tabs_slider li .footer_button").css("height", "auto"), i = n.find(".tabs_slider li .footer_button").height(), n.find(".tabs_slider li .footer_button").css("height", ""));
        t = n.height() * 1;
        r = t + i + 50;
        n.attr("data-unhover", t);
        n.attr("data-hover", r);
        n.parent().height(t);
        n.find(".flex-viewport").height(t)
    })
});
funcDefined("checkTopFilter") || (checkTopFilter = function () {
});
funcDefined("checkStickyFooter") || (checkStickyFooter = function () {
    try {
        ignoreResize.push(!0);
        $("#content").css("min-height", "");
        var n = $("#content").offset().top, t = n + $("#content").outerHeight();
        $("footer").length && (footerOffset = $("footer").offset().top);
        $("#content").css("min-height", $(window).height() - n - (0 - t) - $("footer").outerHeight() + "px");
        ignoreResize.pop()
    } catch (i) {
        console.error(i)
    }
});
funcDefined("checkLinkedArticles") || (checkLinkedArticles = function () {
    var s, u, f, h;
    try {
        if ($(".linked-blog-list.content .item-views").length) {
            var i = $(".linked-blog-list").data("mobile_row"), r = $(".linked-blog-list").data("desktop_row"),
                t = $(".ajax_load .js_append"), l = t.getFloatWidth(), a = t.find("> .item:eq(0)").getFloatWidth(),
                c = t.find("> .item").length, e = Math.floor(l / a), n = Math.floor(c / e), o = !1;
            window.matchMedia("(max-width: 767px)").matches ? (!i && r && (i = r), i && i <= n && (n = e * i, o = !0)) : r && r <= n && (n = e * r, o = !0);
            o || (n = c);
            s = ".linked-blog-list";
            u = t.find(s);
            u.length ? ($(u).insertAfter(t.find("> .item:eq(" + (n - 1) + ")")), setTimeout(function () {
                $(u).addClass("visible")
            }, 0)) : (f = $(s).clone(), h = f.find(".owl-carousel-wait"), f.insertAfter(t.find("> .item:eq(" + (n - 1) + ")")), h.removeClass("owl-carousel-wait").addClass("owl-carousel"), setTimeout(function () {
                f.addClass("visible");
                InitOwlSlider();
                h.removeClass("loader_circle")
            }, 1))
        }
    } catch (v) {
        console.error(v)
    }
});
funcDefined("checkLinkedBlocks") || (checkLinkedBlocks = function (n) {
    var f, e, h;
    n || (n = ".linked-banners-list");
    try {
        if ($(n + ".content div").length) {
            var r = $(n).data("mobile_row"), u = $(n).data("desktop_row"), i = $(".ajax_load .js_append"),
                l = i.getFloatWidth(), a = i.find("> .item:eq(0)").getFloatWidth(), c = i.find("> .item").length,
                o = Math.floor(l / a), t = Math.floor(c / o), s = !1;
            window.matchMedia("(max-width: 767px)").matches ? (!r && u && (r = u), r && r <= t && (t = o * r, s = !0)) : u && u <= t && (t = o * u, s = !0);
            s || (t = c);
            f = i.find(n);
            f.length ? ($(f).insertAfter(i.find("> .item:eq(" + (t - 1) + ")")), setTimeout(function () {
                $(f).addClass("visible")
            }, 0)) : (e = $(n).clone(), h = e.find(".owl-carousel-wait"), e.insertAfter(i.find("> .item:eq(" + (t - 1) + ")")), h.removeClass("owl-carousel-wait").addClass("owl-carousel"), setTimeout(function () {
                e.addClass("visible");
                InitOwlSlider();
                h.removeClass("loader_circle")
            }, 1))
        }
    } catch (v) {
        console.error(v)
    }
});
timerResize = !1;
ignoreResize = [];
$(window).resize(function () {
    CheckPopupTop();
    checkLinkedArticles();
    checkLinkedBlocks(".linked-banners-list");
    ignoreResize.length || (timerResize && (clearTimeout(timerResize), timerResize = !1), timerResize = setTimeout(function () {
        BX.onCustomEvent("onWindowResize", !1)
    }, 50))
});
var timerScroll = !1, ignoreScroll = [], documentScrollTopLast = $(document).scrollTop(), startScroll = 0;
$(window).scroll(function () {
    CheckPopupTop();
    documentScrollTopLast = $(document).scrollTop();
    SetFixedAskBlock();
    ignoreScroll.length || (timerScroll && (clearTimeout(timerScroll), timerScroll = !1), timerScroll = setTimeout(function () {
        BX.onCustomEvent("onWindowScroll", !1)
    }, 50))
});
BX.addCustomEvent("onWindowResize", function () {
    try {
        ignoreResize.push(!0);
        CheckTopMenuPadding();
        CheckTopMenuOncePadding();
        CheckSearchWidth();
        CheckTabActive();
        CheckTopMenuFullCatalogSubmenu();
        CheckHeaderFixedMenu();
        window.matchMedia("(min-width:768px)").matches && closeYandexMap();
        CheckTopMenuDotted();
        $("nav.mega-menu.sliced").length && $("nav.mega-menu.sliced").removeClass("initied");
        CheckTopVisibleMenu();
        checkScrollToTop();
        CheckObjectsSizes();
        CheckFlexSlider();
        initSly();
        typeof checkMobilePhone == "function" && checkMobilePhone();
        checkTopFilter();
        typeof checkMobileFilter == "function" && checkMobileFilter();
        arAsproOptions.THEME && arAsproOptions.THEME.COMPACT_FOOTER_MOBILE == "Y" && (window.matchMedia("(max-width:767px)").matches ? ($("footer").addClass("mobile"), $(".bottom-menu .items>.wrap_compact_mobile").addClass("accordion-body collapse"), $(".bottom-menu .items>.item.childs").attr("data-toggle", "collapse")) : ($("footer").removeClass("mobile"), $(".bottom-menu .items>.wrap_compact_mobile").removeClass("accordion-body collapse"), $(".bottom-menu .items>.item.childs").removeAttr("data-toggle")));
        typeof stickySidebar != "undefined" && (window.matchMedia("(max-width: 991px)").matches ? window.stickySidebar.destroy() : window.stickySidebar.bindEvents());
        $(".flexslider.wsmooth").length && $(".flexslider.wsmooth").each(function () {
            $(this).data("flexslider").smoothHeight()
        });
        window.matchMedia("(min-width: 767px)").matches && $(".wrapper_middle_menu.wrap_menu").removeClass("mobile");
        window.matchMedia("(max-width: 767px)").matches && $(".wrapper_middle_menu.wrap_menu").addClass("mobile");
        $("#basket_form").length && $(window).outerWidth() <= 600 && $("#basket_form .tabs_content.basket > li.cur td").each(function () {
            $(this).css("width", "")
        });
        $(".bx_filter_section .bx_filter_select_container").each(function () {
            var n = $(this).closest(".bx_filter_parameters_box").attr("property_id");
            $("#smartFilterDropDown" + n).length && $("#smartFilterDropDown" + n).css("max-width", $(this).width())
        });
        window.matchMedia("(min-width: 768px)").matches ? ($(".bx_filter .scrollbar").removeClass("mobile-scroll"), $(".bx_filter .srollbar-custom").removeClass("mobile-scroll"), $(".bx_filter .bx_filter_section form .bx_filter_parameters").removeClass("mobile-scroll"), InitScrollBar(), InitCustomScrollBar()) : ($(".bx_filter .scrollbar").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .srollbar-custom").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .bx_filter_section form .bx_filter_parameters").addClass("mobile-scroll").removeClass("scroll-init"), $(".bx_filter .mobile-scroll.scrollbar").length && $(".bx_filter .mobile-scroll.scrollbar").mCustomScrollbar("destroy"), $(".bx_filter .mobile-scroll.srollbar-custom").length && $(".bx_filter .mobile-scroll.srollbar-custom").mCustomScrollbar("destroy"))
    } catch (n) {
        console.log("before error");
        console.log(n)
    } finally {
        ignoreResize.pop()
    }
});
BX.addCustomEvent("onWindowScroll", function () {
    try {
        ignoreScroll.push(!0)
    } catch (n) {
    } finally {
        ignoreScroll.pop()
    }
});
BX.addCustomEvent("onSlideInit", function (n) {
    var t;
    try {
        if (ignoreResize.push(!0), n && (t = n.slider, t)) {
            t.hasClass("small-gallery") && $(window).resize();
            t.find(".item").removeClass("current");
            var i = t.find(".item.flex-active-slide"), r = i.attr("id"), u = t.find(".flex-direction-nav");
            i.addClass("current");
            t.find(".visible").css("opacity", "1");
            t.find(".height0").css("height", "auto");
            i.hasClass("shown") && t.find(".item.clone[id=" + r + "_clone]").addClass("shown");
            i.addClass("shown")
        }
    } catch (f) {
    } finally {
        ignoreResize.pop()
    }
});
BX.addCustomEvent("onCounterGoals", function (n) {
    if (arAsproOptions.THEME.YA_GOALS == "Y" && arAsproOptions.THEME.YA_COUNTER_ID) {
        var t = arAsproOptions.THEME.YA_COUNTER_ID;
        if (t = parseInt(t), typeof n != "object" && (n = {goal: "undefined"}), typeof n.goal != "string" && (n.goal = "undefined"), t) try {
            waitCounter(t, 50, function () {
                var i = window["yaCounter" + t];
                typeof i == "object" && i.reachGoal(n.goal)
            })
        } catch (i) {
            console.error(i)
        } else console.info("Bad counter id!", t)
    }
});
onCaptchaVerifyinvisible = function (n) {
    $(".g-recaptcha:last").each(function () {
        var t = $(this).attr("data-widgetid");
        typeof t != "undefined" && n && ($(this).closest("form").find(".g-recaptcha-response").val() || $(this).closest("form").find(".g-recaptcha-response").val(n), $("iframe[src*=recaptcha]").length && $("iframe[src*=recaptcha]").each(function () {
            var n = $(this).parent().parent();
            n.hasClass("grecaptcha-badge") || n.css("width", "100%")
        }), $(this).closest("form").submit())
    })
};
onCaptchaVerifynormal = function () {
    $(".g-recaptcha").each(function () {
        var n = $(this).attr("data-widgetid");
        typeof n != "undefined" && grecaptcha.getResponse(n) != "" && $(this).closest("form").find(".recaptcha").valid()
    })
};
BX.addCustomEvent("onSubmitForm", function (n) {
    try {
        if (!window.renderRecaptchaById || !window.asproRecaptcha || !window.asproRecaptcha.key) return n.form.submit(), $(n.form).closest(".form").addClass("sending"), !0;
        if (window.asproRecaptcha.params.recaptchaSize == "invisible" && $(n.form).find(".g-recaptcha").length) {
            if ($(n.form).find(".g-recaptcha-response").val()) return n.form.submit(), $(n.form).closest(".form").addClass("sending"), !0;
            if (typeof grecaptcha != "undefined") grecaptcha.execute($(n.form).find(".g-recaptcha").data("widgetid")); else return !1
        } else return n.form.submit(), $(n.form).closest(".form").addClass("sending"), !0
    } catch (t) {
        return console.error(t), !0
    }
});
$(document).on("click", ".catalog_reviews_extended span.dropdown-select__list-link", function () {
    var t = $(this), n = t.data("review_sort_ajax"), i = t.closest("[id^=comp_]");
    containerId = i.attr("id");
    containerId !== undefined && containerId && (n.containerId = containerId);
    n !== undefined && (i.addClass("blur"), $.ajax({
        type: "post", data: n, success: function (n) {
            $("#reviews_sort_continer").html(n)
        }
    }))
});
$(document).on("click", ".rating_vote:not(.disable)", function () {
    var t = $(this), i = t.data("action"), n = t.closest(".rating-vote"), r = n.data("comment_id"),
        u = n.data("user_id"), f = n.data("ajax_url");
    $.ajax({
        url: f, dataType: "json", data: {commentId: r, action: i, userId: u}, success: function (i) {
            i.LIKE !== undefined && t.siblings(".rating-vote-result.like").text(i.LIKE);
            i.DISLIKE !== undefined && t.siblings(".rating-vote-result.dislike").text(i.DISLIKE);
            i.SET_ACTIVE_LIKE !== undefined && n.find(".rating_vote.plus").toggleClass("active");
            i.SET_ACTIVE_DISLIKE !== undefined && n.find(".rating_vote.minus").toggleClass("active")
        }
    })
});
$(document).ready(function () {
    $(".catalog-category-cont").length && $(window).width() < 767 && $(".catalog-category-cont").slick({
        dots: !0,
        arrows: !1,
        infinite: !1,
        slidesToShow: 6,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1230,
            settings: {slidesToShow: 5, slidesToScroll: 1, infinite: !1, dots: !0}
        }, {breakpoint: 1024, settings: {slidesToShow: 4, slidesToScroll: 1, infinite: !1, dots: !0}}, {
            breakpoint: 767,
            settings: {slidesToShow: 3, slidesToScroll: 1}
        }, {breakpoint: 576, settings: {slidesToShow: 2, slidesToScroll: 1}}]
    });
    $(document).mouseup(function (n) {
        var t = $(".catalog-filter-cont:not(.catalog-filter-cont-opener)");
        t.has(n.target).length === 0 && $(".catalog-filter-cont:not(.catalog-filter-cont-opener)").removeClass("opened")
    });
    $(".catalog-filter-name").on("click", function () {
        $(this).parents(".catalog-filter-cont").hasClass("opened") ? $(this).parents(".catalog-filter-cont").removeClass("opened") : ($(".catalog-filter-cont:not(.catalog-filter-cont-opener)").removeClass("opened"), $(this).parents(".catalog-filter-cont").toggleClass("opened"))
    });
    $(".reviews-add-comment-btn").on("click", function () {
        return $(".reviews-form").toggleClass("opened"), !1
    });
    $(".new-card-size-guide").on("click", function () {
    });
    $(".card-info-size-close").on("click", function () {
        $(".card-info-size-cont").removeClass("opened")
    });
    $(".card-tabs-mobile-item-title").on("click", function () {
        $(this).parent().toggleClass("opened")
    });
    $(".main-googs-list").slick({
        dots: !1,
        arrows: !0,
        infinite: !1,
        slidesToShow: 4,
        slidesToScroll: 1,
        touchMove: !1,
        responsive: [{
            breakpoint: 1024,
            settings: {slidesToShow: 3, slidesToScroll: 1, infinite: !1, dots: !1}
        }, {breakpoint: 992, settings: {slidesToShow: 3, slidesToScroll: 1}}, {breakpoint: 767, settings: "unslick"}]
    });
    $(".catalog-item-img-slider").slick({dots: !1, arrows: !0, infinite: !0, slidesToShow: 1, slidesToScroll: 1});
    $(".catalog-item-img-slider.no-slick").slick("unslick");
    $(".card-big-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: !1,
        asNavFor: ".card-small-slider",
        infinite: !1,
        dots: !1,
        responsive: [{
            breakpoint: 1024,
            settings: {slidesToShow: 1, slidesToScroll: 1, infinite: !1, dots: !1}
        }, {breakpoint: 992, settings: {slidesToShow: 1, slidesToScroll: 1}}, {
            breakpoint: 576,
            settings: {slidesToShow: 1, slidesToScroll: 1, dots: !0}
        }]
    });
    $(".card-small-slider").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: ".card-big-slider",
        vertical: !0,
        dots: !0,
        infinite: !1,
        arrows: !1,
        focusOnSelect: !0,
        centerPadding: "0px",
        responsive: [{
            breakpoint: 1230,
            settings: {slidesToShow: 3, slidesToScroll: 1, infinite: !1, vertical: !0, dots: !0}
        }, {breakpoint: 992, settings: {slidesToShow: 4, slidesToScroll: 1}}, {
            breakpoint: 767,
            settings: {slidesToShow: 3, slidesToScroll: 1}
        }, {breakpoint: 576, settings: "unslick"}]
    });
    $(".fancybox").fancybox()
});
$(document).ready(function () {
    initFavorite();
    console.log("before function");
    $(document).on("click", ".catalog-item-favorite a", function () {
        return $id = $(this).attr("data-id"), $obj = $(this), $.ajax({
            url: "/ajax/favorite.php?t=" + (new Date).getTime(),
            type: "post",
            dataType: "json",
            data: {id: $id},
            xhrFields: {withCredentials: !0},
            success: function (n) {
                console.log(n);
                n.result == "removed" ? $($obj).removeClass("active") : $($obj).addClass("active");
                $(".favcounter .counter").text(n.cnt);
                n.cnt && n.cnt != "0" && n.cnt != 0 ? $(".favcounter").addClass("empty") : $(".favcounter").removeClass("empty")
            }
        }), !1
    })
});