(function($){
    $(document).ready(function(){
        'use strict';

        //   wow
        new WOW().init();
        // end wow

        // Jquery Carousel
        function ihosting_init_owl_carousel() {

            $('.ihosting-owl-carousel').each(function () {

                var $this = $(this),
                    $loop = $this.attr('data-loop') == 'yes',
                    $numberItem = parseInt($this.attr('data-number')),
                    $Nav = $this.attr('data-navcontrol') == 'yes',
                    $Dots = $this.attr('data-dots') == 'yes',
                    $autoplay = $this.attr('data-autoplay') == 'yes',
                    $autoplayTimeout = parseInt($this.attr('data-autoplaytimeout')),
                    $marginItem = parseInt($this.attr('data-margin')),
                    $rtl = $this.attr('data-rtl') == 'yes',
                    $autoHeight = $this.attr('data-autoheight') == 'yes',
                    $resNumber = {
                        0: {
                            items: 1
                        }
                    }; // Responsive Settings

                $numberItem = (isNaN($numberItem)) ? 1 : $numberItem;
                $autoplayTimeout = (isNaN($autoplayTimeout)) ? 6000 : $autoplayTimeout;
                $marginItem = (isNaN($marginItem)) ? 0 : $marginItem;

                if (!$this.is('.owl-carousel')) {
                    $this.addClass('owl-carousel');
                }

                //console.log($Nav);

                switch ($numberItem) {

                    case 1 :
                        $resNumber = {
                            0: {
                                items: 1
                            }
                        }
                        break;

                    case 2 :
                        $resNumber = {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            992: {
                                items: $numberItem
                            }
                        }
                        break;

                    case 3 :
                    case 4 :
                        $resNumber = {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            992: {
                                items: 3
                            },
                            1200: {
                                items: $numberItem
                            }
                        }
                        break;

                    default : // $numberItem > 4
                        $resNumber = {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 2
                            },
                            768: {
                                items: 3
                            },
                            992: {
                                items: 3
                            },
                            1200: {
                                items: 4
                            },
                            1500: {
                                items: 5
                            },
                            1800: {
                                items: $numberItem
                            }
                        }
                        break;
                } // Endswitch


                $(this).owlCarousel({
                    items: $numberItem,
                    loop: $loop,
                    nav: $Nav,
                    navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                    navContainer: false,
                    dots: $Dots,
                    autoplay: $autoplay,
                    autoplayTimeout: $autoplayTimeout,
                    autoHeight: $autoHeight,
                    margin: $marginItem,
                    //responsiveClass:true,
                    rtl: $rtl,
                    responsive: $resNumber,
                    autoplayHoverPause: true,

                    //center: true,
                    onRefreshed: function () {
                        var total_active = $this.find('.owl-item.active').length;
                        var i = 0;

                        $this.find('.owl-item').removeClass('active-first active-last');
                        $this.find('.owl-item.active').each(function () {
                            i++;
                            if (i == 1) {
                                $(this).addClass('active-first');
                            }
                            if (i == total_active) {
                                $(this).addClass('active-last');
                            }
                        });
                    },
                    onTranslated: function () {
                        var total_active = $this.find('.owl-item.active').length;
                        var i = 0;

                        $this.find('.owl-item').removeClass('active-first active-last');
                        $this.find('.owl-item.active').each(function () {
                            i++;
                            if (i == 1) {
                                $(this).addClass('active-first');
                            }
                            if (i == total_active) {
                                $(this).addClass('active-last');
                            }
                        });
                    },
                    onResized: function () {
                        //essence_set_equal_columns();
                    }
                });

            });
        }
        if($('.product-thumbs').length){
            ihosting_init_owl_carousel();
        }
        $(window).load(function(){
            ihosting_init_owl_carousel();
        });

        // click menu responsive
        $('.navbar-toggle').on('click', function () {
            $('.header-bottom-right').toggleClass('show-menu');
            $('.icon-cart').removeClass('sub-menu-open');
            $('.icon-search').removeClass('sub-menu-open');
        })

        //hover icon cart menu
        $('.icon-cart').hover(function () {
            if ($('.icon-cart li').hasClass('mini_cart_item')) {
                $('.no-item').hide();
                $('.header-element-content').show();
            }
            else {
                $('.no-item').show();
                $('.header-element-content').hide();
            }
        })

        //click account menu
        $('.menu-checkout-select').on('click', function (e) {
            $('.annoucement-asolute').toggle();
        })

        //click categories list-grid
        $('.icon-grid-categories').on('click', function () {
            if ($('.categories-page').hasClass('categories-grid')) {
                $('.categories-page').removeClass('categories-list');
            }else {
                $('.categories-page').removeClass('categories-list');
                $('.categories-page').addClass('categories-grid');
            }
        })

        $('.icon-list-categories').on('click', function () {
            if ($('.categories-page').hasClass('categories-list')) {
                $('.categories-page').removeClass('categories-grid');
            }else {
                $('.categories-page').removeClass('categories-grid');
                $('.categories-page').addClass('categories-list');
            }
        })
        // click + scroll chat online
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            var footer_bottom_h = $('.footer-bottom').outerHeight();
            var body_h = $('body').outerHeight();
            if($(window).width()> 991){
                if (scroll < (body_h + footer_bottom_h - screen.height)) {
                    $('.box-chat-online').css('bottom', 0);
                } else {
                    $('.box-chat-online').css('bottom', footer_bottom_h);
                }

            }
            else {
                $('.box-chat-online').css('bottom', 0);
            }
        });
        $('.click-chat').on('click', function () {
            $('.form-online').show();
        });
        $('.click-hidden').on('click', function () {
            $('.form-online').hide();
        });

        //menu sticky
        if($(window).width()>767){
            $(window).scroll(function () {
                var scroll = $(window).scrollTop();
                var header_top_h = $('.header-top').outerHeight();

                if (scroll > header_top_h) {
                    $('.header-bottom').addClass('menu-fixed');
                } else {
                    $('.header-bottom').removeClass('menu-fixed');
                }
            });
        };

        // EQUAL ELEM
        function ihosting_equal_elems() {
            $('.equal-container').each(function () {
                var $this = $(this);
                if ($this.find('.equal-elem').length) {
                    $this.find('.equal-elem').css({
                        'height': 'auto'
                    });
                    var elem_height = 0;
                    $this.find('.equal-elem').each(function () {
                        var this_elem_h = $(this).height();
                        if (elem_height < this_elem_h) {
                            elem_height = this_elem_h;
                        }
                    });
                    $this.find('.equal-elem').height(elem_height);
                }
            });
        }
        ihosting_equal_elems();
        // END EQUAL ELEM
        $(window).on('debouncedresize', function () {
            ihosting_equal_elems();
        });

        $(window).load(function () {
            ihosting_equal_elems();
        });

        //FUNFACT
        $('.ts-funfact').appear(function() {
            var count_element = $('.funfact-number', this).html();
            $(".funfact-number", this).countTo({
                from: 0,
                to: count_element,
                speed: 2500,
                refreshInterval: 50,
            });
        });

        /* -- Price Filter */
        $( '#slider-range' ).slider({
            range: true,
            min: 1,
            max: 200,
            values: [ 50, 150 ],
            slide: function( event, ui ) {
                $( '#amount' ).html( '$' + ui.values[ 0 ] )
                $( '#amount2' ).html( '$' + ui.values[ 1 ] );
            }
        });
        $( '#amount' ).html( '$' + $( '#slider-range' ).slider( 'values', 0 ) );
        $( '#amount2' ).html( ' $' + $(  '#slider-range' ).slider( 'values', 1 ) );

        //responsive menu
        if(   ($(window).width()< 1205)   ){
            $( '.main-menu li.menu-item-has-children').append( "<span class='ts-caret'><span class='fa fa-caret-down'></span></span>" );
            $('.menu-item-has-children .ts-caret').on('click',function(e){
                var $this = $(this);
                var thisLi = $this.closest('li');
                var thisUl = thisLi.closest('ul');
                $('.country-dropdown').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                if ( thisLi.is('.sub-menu-open') ) {
                    thisLi.find('> .sub-menu').stop().slideUp('fast');
                    thisLi.find('> .mega-menu').stop().slideUp('fast');
                    thisLi.removeClass('sub-menu-open').find('> a').removeClass('active');
                }
                else{
                    thisUl.find('> li.sub-menu-open > .sub-menu').stop().slideUp('fast');
                    thisUl.find('> li.sub-menu-open').removeClass('sub-menu-open');
                    thisUl.find('> li > a.active').removeClass('active');
                    thisLi.find('> .sub-menu').stop().slideDown('fast');
                    thisLi.find('> .mega-menu').stop().slideDown('fast');
                    thisLi.addClass('sub-menu-open').find('> a').addClass('active');
                }
                e.preventDefault();
                e.stopPropagation();
            });
            $('.icon-country').on('click',function(c) {
                $('.country-dropdown').toggleClass('sub-menu-open');
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                c.preventDefault();
                c.stopPropagation();
            });
            $('.icon-search').on('click',function(s) {
                $('.icon-search').toggleClass('sub-menu-open');
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.country-dropdown').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                $('.header-bottom-right').removeClass('show-menu');
                s.preventDefault();
                s.stopPropagation();
            });
            $('.icon-cart').on('click',function(i) {
                $('.icon-cart').toggleClass('sub-menu-open');
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.country-dropdown').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
                $('.header-bottom-right').removeClass('show-menu');
                i.preventDefault();
                i.stopPropagation();
            });
            $('.site-main').on('click',function(i) {
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
                $('.country-dropdown').removeClass('sub-menu-open');
            });
            $('.header-top').on('click',function(i) {
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
            });
            $('.header-bottom-left').on('click',function(i) {
                $('.menu-item-has-children').removeClass('sub-menu-open');
                $('.icon-cart').removeClass('sub-menu-open');
                $('.icon-search').removeClass('sub-menu-open');
                $('.country-dropdown').removeClass('sub-menu-open');
            });
        };

    });
}(jQuery));