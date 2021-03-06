! function(a) {
    "use strict";
    window.themeFrontCore = {
        initialize: function() {
            var b = this;
            a(document).ready(function() {
                b.build(), b.events()
            })
        },
        build: function() {
            this.setupDocumentClasses(), this.initPreloader(), this.wrapFormInputs(), this.loadSVG(), this.setupHeader(), this.setupFullHeightSections(), this.setupAnimations(), this.setupParallax(), this.setupVideoBG(), this.setupSlider(), this.setupHeroSections(), this.setupMenu(), this.setupPostFormats(), this.setupCarousels(), this.setupTabs(), this.setupPricing(), this.setupFooter(), this.setupOnePage(), this.setupGoTop(), this.setupVideos(), this.setupPortfolio(), this.setupLightbox(), this.bindContactForm()
        },
        events: function() {
            var b = this;
            a(window).resize(function() {
                b.setupHeroSections(), b.setupFooter(), b.setupFullHeightSections()
            }), a("#skip-intro").click(function() {
                return a("html, body").animate({
                    scrollTop: a("#content").offset().top - 80
                }, 800), !1
            }), a(".reply-link").click(function() {
                return a("html, body").animate({
                    scrollTop: a("#comment-form").offset().top
                }, 2e3), !1
            }), a(".form-builder-submit").each(function() {
                a(this).on("click", function() {
                    return a(this).parents("form").submit(), !1
                })
            })
        },
        initPreloader: function() {
            var b = this;
            a("#preloader-inner").length && (a("#preloader-inner.ball-pulse").html(b.createPreloaderDivs(3)), a("#preloader-inner.ball-grid-pulse").html(b.createPreloaderDivs(9)), a("#preloader-inner.ball-clip-rotate").html(b.createPreloaderDivs(1)), a("#preloader-inner.ball-clip-rotate-pulse").html(b.createPreloaderDivs(2)), a("#preloader-inner.square-spin").html(b.createPreloaderDivs(1)), a("#preloader-inner.ball-clip-rotate-multiple").html(b.createPreloaderDivs(2)), a("#preloader-inner.ball-pulse-rise").html(b.createPreloaderDivs(5)), a("#preloader-inner.ball-rotate").html(b.createPreloaderDivs(1)), a("#preloader-inner.cube-transition").html(b.createPreloaderDivs(2)), a("#preloader-inner.ball-zig-zag").html(b.createPreloaderDivs(2)), a("#preloader-inner.ball-zig-zag-deflect").html(b.createPreloaderDivs(2)), a("#preloader-inner.ball-triangle-path").html(b.createPreloaderDivs(3)), a("#preloader-inner.ball-scale").html(b.createPreloaderDivs(1)), a("#preloader-inner.line-scale").html(b.createPreloaderDivs(5)), a("#preloader-inner.line-scale-party").html(b.createPreloaderDivs(4)), a("#preloader-inner.ball-scale-multiple").html(b.createPreloaderDivs(3)), a("#preloader-inner.ball-pulse-sync").html(b.createPreloaderDivs(3)), a("#preloader-inner.ball-beat").html(b.createPreloaderDivs(3)), a("#preloader-inner.line-scale-pulse-out").html(b.createPreloaderDivs(5)), a("#preloader-inner.line-scale-pulse-out-rapid").html(b.createPreloaderDivs(5)), a("#preloader-inner.ball-scale-ripple").html(b.createPreloaderDivs(1)), a("#preloader-inner.ball-scale-ripple-multiple").html(b.createPreloaderDivs(3)), a("#preloader-inner.ball-spin-fade-loader").html(b.createPreloaderDivs(8)), a("#preloader-inner.line-spin-fade-loader").html(b.createPreloaderDivs(8)), a("#preloader-inner.triangle-skew-spin").html(b.createPreloaderDivs(1)), a("#preloader-inner.pacman").html(b.createPreloaderDivs(5)), a("#preloader-inner.ball-grid-beat").html(b.createPreloaderDivs(9)), a("#preloader-inner.semi-circle-spin").html(b.createPreloaderDivs(1))), a(window).load(function() {
                a("body.preloader").length && (a("body").waitForImages({
                    waitForAll: !0,
                    finished: function() {
                        a("#preloader").fadeOut(1200, function() {
                            a("body.preloader").removeClass("preloader"), a(this).remove()
                        })
                    }
                }), a(".ie7, .ie8, .ie9, .ie10").length && (a("#preloader").remove(), a("body").removeClass("preloader")))
            })
        },
        setupDocumentClasses: function() {
            if (a("html").removeClass("no-js"), (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.platform)) && a("html").addClass("mobile"), navigator.userAgent.indexOf("Safari") != -1 && navigator.userAgent.indexOf("Mac") != -1 && navigator.userAgent.indexOf("Chrome") == -1 && a("html").addClass("mac"), "Microsoft Internet Explorer" == navigator.appName) {
                var c = navigator.userAgent,
                    d = new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");
                if (null != d.exec(c)) {
                    var e = parseInt(RegExp.$1);
                    a("html").addClass("ie" + e)
                }
            }
        },
        wrapFormInputs: function() {
            var b = a("input[type=text], input[type=number], input[type=password], input[type=email], input[type=search], input[type=tel], input[type=url], textarea, select").not("#wpl-theme-switcher-box select");
            b.wrap('<div class="input-wrapper"></div>'), b.focus(function() {
                a(this).parents(".input-wrapper").addClass("hovered")
            }), b.focusout(function() {
                a(this).parents(".input-wrapper").removeClass("hovered")
            })
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
        setupHeader: function() {
            a(".fixed-header #header, .transparent-header #header").headroom({
                offset: 200,
                tolerance: 0,
                classes: {
                    initial: "animated",
                    pinned: "headroom--pinned",
                    unpinned: "headroom--unpinned"
                }
            })
        },
        setupSlider: function() {
            a(".skip-slider").click(function() {
                return a("html, body").animate({
                    scrollTop: a(window).height()
                }, 800), !1
            })
        },
        setupFullHeightSections: function() {
            var b = a(window).height();
            a(".full-height").css("min-height", b + "px")
        },
        setupAnimations: function() {
            var b = new WOW({
                boxClass: "wow",
                animateClass: "animated",
                offset: 0,
                mobile: !0,
                live: !0,
                callback: function(b) {
                    var c = a(b);
                    c.hasClass("animationNuminate") && c.each(function() {
                        var b = a(this),
                            c = b.data("to");
                        b.numinate({
                            format: "%counter%",
                            from: 1,
                            to: c,
                            runningInterval: 2e3,
                            stepUnit: 5
                        })
                    })
                }
            });
            b.init()
        },
        setupParallax: function() {
            a(".parallax-section").each(function() {
                a(this).parallax({
                    zIndex: 10
                })
            })
        },
        setupVideoBG: function() {
            var b = this;
            a(".video-bg-section").each(function() {
                var c = a(this).data("video-id"),
                    d = b.stringToBoolean(a(this).data("video-mute")),
                    e = b.stringToBoolean(a(this).data("video-pause-scroll"));
                a(this).YTPlayer({
                    videoId: c,
                    mute: d,
                    pauseOnScroll: e
                })
            })
        },
        setupHeroSections: function() {
            var b = a("#hero");
            if (b.length) {
                var d = (b.height(), b.find(".intro-text")),
                    e = d.height();
                d.css("margin-top", "-" + e / 2 + "px")
            }
        },
        setupMenu: function() {
            var b = a("#header-nav");
            b.dlmenu({
                backLabel: b.data("back-label")
            })
        },
        setupPostFormats: function() {
            a(".format-chat .post-excerpt p, .single #content article.format-chat p").each(function() {
                var b = a(this).text().split(" ");
                a(this).html("<strong>" + b.shift() + "</strong> " + b.join(" "))
            })
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
        setupTabs: function() {
            a(".services").each(function() {
                var b = a(this),
                    c = b.next(".services-pagination").find(".tab-link");
                c.click(function() {
                    var d = a(this).attr("href"),
                        e = a(d);
                    b.find(".service-item").hide().removeClass("selected");
                    e.data("image");
                    return e.fadeIn(300, function() {
                        e.addClass("selected"), a("html, body").animate({
                            scrollTop: e.offset().top - 20
                        }, 800)
                    }), c.removeClass("selected"), a(this).addClass("selected"), !1
                })
            })
        },
        setupPricing: function() {
            a("ul.pricing-table > li:first").addClass("first"), a("ul.pricing-table > li:last").addClass("last")
        },
        setupFooter: function() {
            if (a(window).width() < 992) a("div.section").last().css("margin-bottom", "0px");
            else if (a("body").hasClass("parallax-footer") && a(window).width() >= 992) {
                var c = a("#footer");
                c.waitForImages({
                    waitForAll: !0,
                    finished: function() {
                        a("#content-wrapper").css("margin-bottom", c.height() + "px")
                    }
                })
            }
        },
        setupOnePage: function() {
            if (a("body.one-page").length) {
                var c = a("#header-nav").data("scroll-offset"),
                    d = a("#header-nav").data("scroll-speed"),
                    e = a("#header-nav").data("scroll-easing");
                e = "" == e ? "easeOutBack" : e, a("body.one-page #header-menu").singlePageNav({
                    currentClass: "current-link",
                    updateHash: !0,
                    offset: c,
                    speed: d,
                    filter: ":not(.external)",
                    easing: e
                })
            }
        },
        setupGoTop: function() {
            a("body").hasClass("go-top") && a.scrollUp({
                scrollName: "scrollUp",
                topDistance: "1000",
                topSpeed: 100,
                animation: "slide",
                animationInSpeed: 500,
                animationOutSpeed: 500,
                scrollText: "",
                activeOverlay: !1
            })
        },
        setupVideos: function() {
            var b = a(".lazy-video");
            b.each(function() {
                a(this).lazyYT()
            }), a("body.single article.format-video iframe").each(function() {
                a(this).parents("p").addClass("responsive-video-contaner")
            })
        },
        setupPortfolio: function() {
            var b = this;
            a(".portfolio").each(function() {
                var c = a(this),
                    d = c.find(".portfolio-gallery"),
                    e = d.data("row-height"),
                    f = d.data("row-min-height");
                d.justifiedGallery({
                    sizeRangeSuffixes: {},
                    rowHeight: e,
                    maxRowHeight: f,
                    margins: 0,
                    captionSettings: {
                        visibleOpacity: .9,
                        animationDuration: 300,
                        nonVisibleOpacity: 0
                    },
                    captions: !0
                });
                c.find(".portfolio-header .filters a").bind("click touchstart", function() {
                    c.find(".portfolio-header .filters a").removeClass("selected"), a(this).addClass("selected");
                    var b = a(this).data("filter");
                    return d.justifiedGallery({
                        filter: b
                    }), !1
                }), c.find(".portfolio-load-more").on("click", function() {
                    var c = a(this),
                        e = c.find("i.icon"),
                        f = c.data();
                    return a.ajax({
                        url: wprotoEngineVars.ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "load_more_portfolio_posts",
                            data: f,
                            type: "json"
                        },
                        beforeSend: function() {
                            e.addClass("rotating")
                        },
                        success: function(a) {
                            e.removeClass("rotating"), "add" == a.answer && (d.append(a.html), d.justifiedGallery("norewind"), c.data("nextpage", a.next_page), b.setupLightbox()), b.stringToBoolean(a.hide_more) && c.remove()
                        }
                    }), !1
                })
            })
        },
        setupLightbox: function() {
            a("body.single article.format-image img").each(function() {
                a(this).parents("a").addClass("lightbox")
            }), a(".lightbox").length && a(".lightbox").nivoLightbox({
                effect: "fadeScale"
            })
        },
        bindContactForm: function() {
            window.fwForm && fwForm.initAjaxSubmit({
                selector: "form.fw_form_fw_form"
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