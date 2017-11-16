! function(a) {
    "use strict";
    window.themeFrontCore = {
        initialize: function() {
            var b = this;
            a(document).ready(function() {
                b.build()
            })
        },
        build: function() {
            this.loadSVG(), this.setupFullHeightSections(), this.setupCarousels()
        },
        loadSVG: function() {
            a("img.image-svg").each(function() {
                var b = a(this),
                    c = b.attr("id"),
                    d = b.attr("class"),
                    e = b.attr("src"),
                    f = e.replace(/^.*\./, "");
                f = f.toLowerCase(), "svg" == f && a.get(e, function(e) {
                    var f = a(e).find("svg");
                    "undefined" != typeof c && (f = f.attr("id", c)), "undefined" != typeof d && (f = f.attr("class", d + " replaced-svg")), f = f.removeAttr("xmlns:a"), !f.attr("viewBox") && f.attr("height") && f.attr("width") && f.attr("viewBox", "0 0 " + f.attr("height") + " " + f.attr("width")), b.replaceWith(f)
                }, "xml")
            })
        },
        setupFullHeightSections: function() {
            var b = a(window).height();
            a(".full-height").css("min-height", b + "px")
        },
        setupCarousels: function() {
            var b = this;
            a(".news-carousel").swiper({
                loop: !0,
                pagination: ".swiper-pagination",
                freeMode: !0,
                spaceBetween: 30,
                slidesPerView: "auto",
                paginationClickable: !0
            }), a(".screenshots-carousel").swiper({
                loop: !0,
                spaceBetween: 0,
                centeredSlides: !0,
                slidesPerView: "auto"
            }), a(".owl-carousel").owlCarousel({
                items: 1,
                navigation: !0,
                navigationText: ["", ""],
                singleItem: !0,
                autoHeight: !0,
                transitionStyle: "fade",
                direction: a("body").hasClass("rtl") ? "rtl" : "ltr"
            }), setInterval(function() {
                a(".owl-carousel").each(function() {
                    a(this).data("owlCarousel").updateVars()
                })
            }, 1500), a(".shortcode-team-members").each(function() {
                b.preloadImages([a(this).find("div.item:first").data("bg")]);
                var c = a(this).attr("id");
                a(this).parents(".fw-main-row:first").css("background-image", "url(" + a(this).find("div.item:first").data("bg") + ")").css("transition", "0.3s");
                var d = a(this).find(".items").owlCarousel({
                    items: 1,
                    singleItem: !0,
                    transitionStyle: "fade",
                    direction: a("body").hasClass("rtl") ? "rtl" : "ltr",
                    afterAction: function(b) {
                        var d = b.find(".item").eq(this.owl.currentItem).data("bg");
                        b.parents(".fw-main-row:first").css("background-image", "url(" + d + ")");
                        a("#" + c + " .team-pagination a").removeClass("current"), a("#" + c + " .team-pagination a").eq(this.owl.currentItem).addClass("current")
                    }
                }).data("owlCarousel");
                a("#" + c + " .team-pagination a").click(function() {
                    var b = a("#" + c + " .team-pagination a").index(a(this));
                    return d.goTo(b), !1
                })
            })
        },
        isValidEmailAddress: function(a) {
            var b = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return b.test(a)
        },
        preloadImages: function(b) {
            a(b).each(function() {
                a("<img/>")[0].src = this
            })
        },
        createPreloaderDivs: function(a) {
            var b = [],
                c = 0;
            for (c = 1; c <= a; c++) b.push("<div></div>");
            return b
        },
        stringToBoolean: function(a) {
            switch (a) {
                case "true":
                case "yes":
                case "1":
                    return !0;
                case "false":
                case "no":
                case "0":
                case null:
                    return !1;
                default:
                    return Boolean(a)
            }
        }
    }, window.themeFrontCore.initialize()
}(window.jQuery);