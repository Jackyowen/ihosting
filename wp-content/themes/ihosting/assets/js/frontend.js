jQuery(document).ready(function ($) {

    "use strict";

    // Chosen
    if ($('.ihosting-select').length) {
        $('.ihosting-select').chosen({
            disable_search_threshold : 6
        });
    }

    // Add class "kt-adminbar"
    if ($('#wpadminbar').length) {
        $('#wpadminbar').addClass('kt-adminbar');
    }

    function kt_add_string_prefix(str, prefix) {
        return prefix + str;
    }

    // Sub menu outside
    $('.main-menu .sub-menu > li').hover(function (e) {
        if ($(this).find('.sub-menu').length) {
            var $first_sub_menu             = $(this).find('> .sub-menu');
            var first_sub_menu_offset_right = ($(window).width() - ($first_sub_menu.offset().left + $first_sub_menu.outerWidth()));
            if (first_sub_menu_offset_right <= 0) {
                $(this).find('.sub-menu').css({
                    'left' : 'auto',
                    'right' : '0',
                    'top' : '100%'
                });
            }
        }
    }, function (e) {
        if ($(this).find('.sub-menu').length) {
            var $sub_menu = $(this).find('.sub-menu');
            $sub_menu.css({
                'left' : '100%',
                'right' : 'auto',
                'top' : '0'
            });
        }
    });

    // Remove unwanted html
    $('.ihosting-remove-inner-content').remove();

    //SLIDE IMAGES PRODUCT
    if ($('.ts-infoproduct .images').length > 0) {
        // Remove unwanted html
        $('.ihosting-remove-inner-content').remove();
        $('.ts-infoproduct .images').owlCarousel({
            loop : false,
            items : 1,
            dots : true,
            nav : true,
            autoplay : false,
            navText : ['<span class="icon icon-arrows-slim-left"></span>', '<span class="icon icon-arrows-slim-right"></span>']
        });
    }

    //Height Cat title 
    $('.ts-shortcode-category').each(function () {
        var heightItem = $(this).find('.product-column1 .product-item').outerHeight();
        $(this).find('.product-catinfo').css("height", heightItem);
    });

    // Window Resized
    $(window).on("debouncedresize", function () {

        if ($('html').is('.mm-opened')) {
            $('.mm-opened .mm-close').trigger('click');
        }

    });

    // Window Scroll
    $(window).scroll(function () {
        kt_show_hide_back_to_top();
    });

    // Window Load
    $(window).load(function () {
        function getCurrentScroll() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }

        $('.section-about').each(function () {
            var heightL = $(this).find('.left-section').outerHeight();
            $(this).find('.right-section').css('height', heightL);
        });

        var widthW = $(window).width();
        //ZOOM IMAGE PRODUCT
        if (widthW > 1350) {

            $('.ts-infoproduct .left-infoproduct .images a.zoom').each(function () {
                var zoomParent = $('.product > .ts-infoproduct .left-infoproduct');
                $(this).easyZoom({
                    preload : '<p class="preloader">Loading the image</p>',
                    append : false,
                    parent : zoomParent
                });
            });

            $(document).on('change', 'form.cart select', function () {
                $('.ts-infoproduct .left-infoproduct .images a.zoom').each(function () {
                    var zoomParent = $('.product > .ts-infoproduct .left-infoproduct');
                    $(this).easyZoom({
                        preload : '<p class="preloader">Loading the image</p>',
                        append : false,
                        parent : zoomParent
                    });
                });
            });

        }

    });


    //HEIGHT ABOUT SECTION
    // $('.section-about').each(function () {
    //     var heightL = $(this).find('.left-section').outerHeight();
    //     $(this).find('.right-section').css('height', heightL);
    // });
    // $(window).on("debouncedresize", function () {
    //     setTimeout(function () {
    //         $('.section-about').each(function () {
    //             var heightL = $(this).find('.left-section').outerHeight();
    //             1
    //             $(this).find('.right-section').css('height', heightL);
    //         })
    //     }, 201);
    // });

    //SLIDE PRICE WIDGET
    $('.price_slider_wrapper').each(function () {
        var _min = $(this).find('.price_slider_amount input#min_price').data('min');
        var _max = $(this).find('.price_slider_amount input#max_price').data('max');

        $(this).find(".price_slider").slider({
            range : true,
            min : _min,
            max : _max,
            values : [30, 3450],
            slide : function (event, ui) {
                $(".price_label .from").text(ihosting['curency_symbol'] + ui.values[0]);
                $(".price_label .to").text(ihosting['curency_symbol'] + ui.values[1]);
            }
        });
        $(this).find(".price_label .from").text(ihosting['curency_symbol'] + $(".price_slider").slider("values", 0));
        $(this).find(".price_label .to").text(ihosting['curency_symbol'] + $(".price_slider").slider("values", 1));
    });

    //ACORDION SINGLE PRODUCT
    if ($('.woocommerce-tab-accordion').length) {
        $('.woocommerce-tab-accordion').each(function () {

            var $this        = $(this);
            var active_panel = parseInt($this.attr('data-active_panel'));

            $this.accordion({
                collapsible : true,
                header : "h6.tab-title",
                active : active_panel,
                heightStyle : "content"
            });
        });
    }


    //CATEGORIES GRID
    $('.grid-masonry').each(function () {
        var $isotopGrid = $(this);
        var layout_mode = $isotopGrid.attr('data-layoutmode');
        // Re-layout after images loaded
        $isotopGrid.isotope({
            resizable : false,
            itemSelector : '.grid',
            layoutMode : layout_mode,
            transitionDuration : '0.6s',
            packery : {
                gutter : 0
            },
        }).isotope('layout');

        // layout Isotope after each image loads
        $isotopGrid.imagesLoaded().progress(function () {
            $isotopGrid.isotope('layout');
        });
    });

    //BACK TO TOP
    $('.back-to-top').click(function () {
        $('html,body').animate({scrollTop : 0}, 800);
        return false;
    });

    function kt_show_hide_back_to_top() {
        var h = $(window).scrollTop();

        if (h > 100) {
            $('.back-to-top').addClass('lk-show');
        }
        else {
            $('.back-to-top').removeClass('lk-show');
        }

    }

    //POST SLIDE
    if ($('.ts-post-slide').length > 0) {
        // Remove unwanted html
        $('.ihosting-remove-inner-content').remove();
        $('.ts-post-slide').owlCarousel({
            loop : true,
            items : 1,
            dots : true,
            nav : true,
            autoplay : true,
            navText : ['<span class="icon icon-arrows-slim-left"></span>', '<span class="icon icon-arrows-slim-right"></span>']
        });
    }

    //PIE CHART
    $(".ts-chart").each(function () {
        var size       = $(this).attr('data-size'),
            barColor   = $(this).attr('data-barColor'),
            trackColor = $(this).attr('data-trackColor'),
            lineWidth  = $(this).attr('data-lineWidth');
        $(this).easyPieChart({
            easing : 'easeInOutQuad',
            barColor : barColor,
            animate : 2000,
            trackColor : trackColor,
            lineWidth : lineWidth,
            size : size,
            scaleColor : false,
            lineCap : 'square',
            onStep : function (from, to, percent) {
                $(this.el).find('.chart-percent').text(Math.round(percent) + '%');
            }
        });
        $(this).find('span').css({
            'line-height' : size + 'px',
            'color' : barColor,
        });
    });

    //FUNFACT
    $('.ts-funfact').each(function () {
        var count_element = $(this).find('.number').attr('data-number');
        if (count_element != '') {
            $(this).find('.number').countTo({
                from : 0,
                to : count_element,
                speed : 3000,
                refreshInterval : 50,
            })
        }
        ;
    });

    //SKILL BAR
    $('.item-skillbar').each(function () {
        var $percentSkill = $(this).attr('data-percent'),
            $bgSkill      = $(this).attr('data-bgskill');

        $(this).find('.skillbar-bar').animate({
            'width' : $percentSkill + '%'
        }, 6000);
        if ($bgSkill != '') {
            $(this).find('.skillbar-bar').css({
                'background-color' : $bgSkill
            });
        }
        ;
    });

    //ACORDION
    $(".ts-acordion-data").each(function() {
        var $this = $(this);
        var icon_header = $(this).attr('data-icon-header');
        var icon_active_header = $(this).attr('data-active');
        var active_tab = $(this).attr('data-tab');
        var icons = {
            header: "fa "+icon_header,
            activeHeader: "fa "+icon_active_header,
        };
        $(this).accordion({
            icons: icons,
            active:0,
            collapsible: true
        });
    });

    //SET WIDTH MEGAMENU
    $('.navigation-ihosting-2 .megamenu-menu-item').each(function () {
        var widthSubmenu = $(this).find('.sub-menu').attr('data-width');
        $(this).find('.sub-menu').css("min-width", widthSubmenu + 'px');
    });


    //LEFT SUBMENU
    ihosting_submenu_adjustments();

    //MENU DROPDOW 
    $('.navigation-ihosting .menu-item-has-children > a .caret').on('click', function (e) {

        var $this  = $(this);
        var thisLi = $this.closest('li');
        var thisUl = thisLi.closest('ul');
        var thisA  = $this.closest('a');

        if (thisLi.is('.sub-menu-open')) {
            thisLi.find('> .sub-menu').stop().slideUp('fast');
            thisLi.removeClass('sub-menu-open').find('> a').removeClass('active');
        }
        else {
            thisUl.find('> li.sub-menu-open > .sub-menu').stop().slideUp('fast');
            thisUl.find('> li.sub-menu-open').removeClass('sub-menu-open');
            thisUl.find('> li > a.active').removeClass('active');
            thisLi.find('> .sub-menu').stop().slideDown('fast');
            thisLi.addClass('sub-menu-open').find('> a').addClass('active');
        }

        e.preventDefault();
        e.stopPropagation();
    });

    $('.navigation-ihosting .menu-item-has-children > a').on('click', function (e) {

        var $this  = $(this);
        var thisLi = $this.closest('li');
        var thisUl = thisLi.closest('ul');
        var url    = $this.attr('href');

        if (typeof url == 'undefined' || typeof url == false) {
            url = '';
        }

        if ($.trim(url) == '' || $.trim(url) == '#') {
            if (thisLi.is('.sub-menu-open')) {
                thisLi.find('> .sub-menu').stop().slideUp('fast');
                thisLi.removeClass('sub-menu-open').find('> a').removeClass('active');
            }
            else {
                thisUl.find('> li.sub-menu-open > .sub-menu').stop().slideUp('fast');
                thisUl.find('> li.sub-menu-open').removeClass('sub-menu-open');
                thisUl.find('> li > a.active').removeClass('active');
                thisLi.find('> .sub-menu').stop().slideDown('fast');
                thisLi.addClass('sub-menu-open').find('> a').addClass('active');
            }

            e.preventDefault();
            e.stopPropagation();
        }

    });

    $(document).on('mouseover', '.navigation-ihosting.show_on_hover .menu-item-has-children > a', function (e) {

        var window_w = $(window).width();
        if (ihosting['is_mobile'] == 'true' || window_w < 768) {
            return false;
        }

        var $this  = $(this);
        var thisLi = $this.closest('li');
        var thisUl = $this.closest('ul');

        // if ( !thisLi.is('.sub-menu-open') && !thisUl.find('> li > .sub-menu').is('.animating') ) {  // Don't run effect if is animating 
        if (!thisLi.is('.sub-menu-open')) {
            thisUl.find('.sub-menu-open > a').removeClass('active');
            thisUl.find('.sub-menu-open > .sub-menu').addClass('animating').stop().slideUp('slow', function () {
                thisUl.find('.sub-menu').removeClass('animating');
            });
            thisUl.find('.sub-menu-open').removeClass('sub-menu-open');
            thisLi.addClass('sub-menu-open');
            thisLi.find('> a').addClass('active');
            thisLi.find('> .sub-menu').addClass('animating').stop().slideDown('slow', function () {
                thisUl.find('.sub-menu').removeClass('animating');
            });
        }
        e.preventDefault();
    });

    //ADMIN BAR
    if ($('#wpadminbar').length > 0) {
        $('body').addClass('ts-adminbar');
    }


    // =========================================================================

    function ihosting_create_event(event_name) {
        var evt = document.createEvent('UIEvents');
        evt.initUIEvent(event_name, true, false, window, 0);
        window.dispatchEvent(evt);
    }

    // Init masonry blog
    function ihosting_init_masonry() {
        $('.posts-masonry').each(function () {
            var masonryGrid = $(this);
            if (masonryGrid.hasClass('processing-masonry')) {
                return false;
            }
            masonryGrid.addClass('processing-masonry');
            masonryGrid.masonry({
                // options
                itemSelector : '.type-post',
            }).on('layoutComplete', function () {
                masonryGrid.removeClass('processing-masonry');
            });
        });
    }

    ihosting_init_masonry();

    var lk_window_resize_count = 0;
    $(window).on('resizeEnd', function () {
        lk_window_resize_count++;
        ihosting_init_masonry();

        setTimeout(function () {
            if (lk_window_resize_count <= 1) {
                //$(window).trigger('resize');
                ihosting_init_masonry();
            }
            else {
                lk_window_resize_count = 0;
            }
        }, 2000);
    });

    $(window).resize(function () {
        if (this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 500);
    });

    $(window).load(function () {

        $('.posts-masonry').removeClass('processing-masonry');
        ihosting_init_masonry();
    });


    // Load More Masonry
    $(document).on('click', '.blog-masonry-loadmore-btn', function (e) {

        var $this = $(this);

        if ($this.hasClass('locked') || $this.hasClass('no-more-post')) {
            return false;
        }

        var masonryContainer = $this.closest('.masonry-container');
        var masonryGrid      = masonryContainer.find('.posts-masonry');
        var except_post_ids  = Array();
        masonryGrid.find('.type-post').each(function () {
            var post_id = $(this).attr('id').replace('post-', '');
            except_post_ids.push(post_id);
        });
        var sidebar_pos = $this.attr('data-sidebar-pos');

        $this.addClass('locked').html('Loading...');

        var data = {
            action : 'ihosting_loadmore_masonry_via_ajax',
            except_post_ids : except_post_ids,
            sidebar_pos : sidebar_pos
        };

        $.post(ajaxurl, data, function (response) {

            var items = [];
            $.each(response['items'], function (index, item_html) {

                var $elem = $(item_html);
                masonryGrid.append($elem).masonry('appended', $elem);

            });

            // layout Masonry after each image loads
            masonryGrid.imagesLoaded().progress(function () {
                masonryGrid.masonry('layout');
            });

            $this.removeClass('locked').html(response['load_more_text']);

            if (response['nomore_post'] == 'yes') {
                $this.addClass('no-more-post');
            }

            //console.log(response);

        });

        e.preventDefault();

    });

    function ihosting_submenu_adjustments() {

        $(".navigation-ihosting-2 > ul > .menu-item-has-children").mouseenter(function () {
            if ($(this).children(".sub-menu").length > 0) {
                var submenu             = $(this).children(".sub-menu");
                var window_width        = parseInt($(window).outerWidth());
                var submenu_width       = parseInt(submenu.outerWidth());
                var submenu_offset_left = parseInt(submenu.offset().left);
                var submenu_adjust      = window_width - submenu_width - submenu_offset_left;

                if (submenu_adjust < 0) {
                    submenu.css("left", submenu_adjust - 30 + "px");
                }
            }
        });
    }

});