jQuery(document).ready(function ($) {
    "use strict";


    // Count down (coming soon mode) for admin
    // Coming Soon Countdown
    $('.ihosting-countdown-wrap').each(function () {
        var $this             = $(this);
        var countdown_to_date = $this.attr('data-countdown');

        if (typeof countdown_to_date == 'undefined' || typeof countdown_to_date == false) {
            var cd_class = $this.attr('class');
            if ($.trim(cd_class) != '') {
                cd_class = cd_class.split('ihosting-cms-date_');
                if (typeof cd_class[1] != 'undefined' && typeof cd_class[1] != false) {
                    countdown_to_date = cd_class[1];
                }
                console.log(cd_class);
            }
        }

        if (typeof countdown_to_date != 'undefined' && typeof countdown_to_date != false) {
            if ($this.hasClass('countdown-admin-menu')) { // For admin login
                $this.find('a').countdown(countdown_to_date, function (event) {
                    $this.find('a').html(
                        event.strftime(ihosting['html']['countdown_admin_menu'])
                    );
                });
            }
            else {
                $this.countdown(countdown_to_date, function (event) {
                    $this.html(
                        event.strftime(ihosting['html']['countdown'])
                    );
                });
            }
        }

    });

    // Color Picker
    $('.kt-color-picker').each(function () {
        var $this     = $(this);
        var cur_color = $this.val();
        $this.spectrum({
            color : cur_color,
            flat : false,
            showInput : true,
            showInitial : true,
            allowEmpty : true,
            showAlpha : true,
            // disabled: bool,
            // localStorageKey: string,
            showPalette : true,
            // showPaletteOnly: false,
            // togglePaletteOnly: true,
            showSelectionPalette : true,
            clickoutFiresChange : true,
            // cancelText: string,
            // chooseText: string,
            // togglePaletteMoreText: string,
            // togglePaletteLessText: string,
            // containerClassName: string,
            // replacerClassName: string,
            preferredFormat : 'rgb',
            // maxSelectionSize: int,
            // palette: [[string]],
            selectionPalette : ['rgba(0, 0, 0, 0.4)', '#eec15b'],
            move : function (color) {
                //$this.css('background-color',color.toRgbString());
                $this.val(color.toRgbString());
            }
        });
    });

    // Menu item edit image icon picker
    $(document).on('click', '.field-icon-img-url .icon-img-list a', function (e) {

        var $this    = $(this);
        var thisWrap = $this.closest('.field-icon-img-url');
        var img_url  = $this.find('img').attr('src');

        if (typeof img_url != 'undefined' && typeof img_url != false) {
            thisWrap.find('input[type=text]').val(img_url);
            thisWrap.find('.icon-img-list a').removeClass('active');
            $this.addClass('active');
        }

        e.preventDefault();
    });

    // Posttype metas dependency
    var ihostingPosttypeMetasdepConfig = {
        1 : {
            'selector' : '.img-header-layout-wrap-1', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_1',
            'indent' : true
        },
        2 : {
            'selector' : '.img-header-layout-wrap-2', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_2',
            'indent' : true
        },
        3 : {
            'selector' : '.img-header-layout-wrap-3', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_3',
            'indent' : true
        },
        4 : {
            'selector' : '.cmb2-id--ihosting-header-logo-style-1', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_1',
            'indent' : true
        },
        5 : {
            'selector' : '.cmb2-id--ihosting-header-logo-style-2', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_2',
            'indent' : true
        },
        6 : {
            'selector' : '.cmb2-id--ihosting-header-logo-style-3', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '=',
            'value' : 'style_3',
            'indent' : true
        },
        7 : {
            'selector' : '.cmb2-id--ihosting-header-desc', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : 'in',
            'value' : 'style_1, style_3',
            'indent' : true
        },
        8 : {
            'selector' : '#_ihosting_header_contact_info_group_repeat', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '!=',
            'value' : 'global',
            'indent' : true
        },
        9 : {
            'selector' : '.cmb2-id--ihosting-show-header-login-link, .cmb2-id--ihosting-show-header-lang-switcher', // Selectors dependency on "dep"
            'dep' : '#_ihosting_header_layout',
            'compare' : '!=',
            'value' : 'global',
            'indent' : true
        },

        // Banner/Heading/Breadcrumb
        10 : {
            'selector' : '.cmb2-id--ihosting-heading-color', // Selectors dependency on "dep"
            'dep' : '#_ihosting_show_heading',
            'compare' : '=',
            'value' : 'show',
            'indent' : true
        },
        11 : {
            'selector' : '.cmb2-id--ihosting-breadcrumb-color', // Selectors dependency on "dep"
            'dep' : '#_ihosting_show_breadcrumb',
            'compare' : '=',
            'value' : 'show',
            'indent' : true
        },
        12 : {
            'selector' : '.cmb2-id--ihosting-banner-bg-color, .cmb2-id--ihosting-banner-bg-img, .cmb2-id--ihosting-banner-bg-repeat, ' +
            '.cmb2-id--ihosting-banner-bg-attachment, .cmb2-id--ihosting-banner-bg-align, .cmb2-id--ihosting-banner-height', // Selectors dependency on "dep"
            'dep' : '#_ihosting_show_banner',
            'compare' : '=',
            'value' : 'show',
            'indent' : true
        },

        // Footer
        29 : {
            'selector' : '.cmb2-id--ihosting-footer-bg-color, .cmb2-id--ihosting-footer-layout, .cmb2-id--ihosting-footer-enable-bottom, .cmb2-id--ihosting-footer-bottom-text, .cmb2-id--ihosting-footer-bottom-imgs', // Selectors dependency on "dep"
            'dep' : '#_ihosting_enable_custom_footer',
            'compare' : '=',
            'value' : 'custom',
            'indent' : true
        },
        30 : {
            'selector' : '.cmb2-id--ihosting-footer-bottom-text, .cmb2-id--ihosting-footer-bottom-imgs', // Selectors dependency on "dep"
            'dep' : '#_ihosting_footer_enable_bottom',
            'compare' : '=',
            'value' : 'enable',
            'indent2' : true
        }

    };

    function ihosting_page_update_display_dep_metas() {

        $.each(ihostingPosttypeMetasdepConfig, function (i, val) {

            // For repeatable field
            if ($(val['selector']).is('.cmb-repeatable-group')) {
                $(val['selector']).closest('.cmb-repeat-group-wrap').addClass((val['selector'] + '_wrap').replace('#', '').replace('.', ''));
                val['selector'] = (val['selector'] + '_wrap').replace('#', '.');
            }

            var compare = val['compare'] == '' ? '=' : val['compare'];
            var indent  = false;
            var indent2 = false;
            var indent3 = false;
            if (val.hasOwnProperty('indent')) {
                indent = val['indent'];
            }
            if (val.hasOwnProperty('indent2')) {
                indent2 = val['indent2'];
            }
            if (val.hasOwnProperty('indent3')) {
                indent3 = val['indent3'];
            }

            if (indent) {
                $(val['selector']).css({'padding-left' : '4%'});
            }
            if (indent2) {
                $(val['selector']).css({'padding-left' : '7%'});
            }
            if (indent3) {
                $(val['selector']).css({'padding-left' : '10%'});
            }

            switch (compare) {

                case '=':
                    if ($(val['dep']).val() != val['value']) {
                        $(val['selector']).css({'display' : 'none'});
                    }
                    else {
                        $(val['selector']).css({'display' : ''});
                    }
                    break;

                case 'checked':
                    if ($(val['dep']).is(':checked') && $(val['dep']).val() == val['value']) {
                        $(val['selector']).css({'display' : ''});
                    }
                    else {
                        $(val['selector']).css({'display' : 'none'});
                    }
                    break;

                case '!=':
                case '<>':
                    if ($(val['dep']).val() == val['value']) {
                        $(val['selector']).css({'display' : 'none'});
                    }
                    else {
                        $(val['selector']).css({'display' : ''});
                    }
                    break;

                case 'in':

                    if (val['value'].indexOf($(val['dep']).val() + ',') >= 0 || val['value'].indexOf(', ' + $(val['dep']).val()) >= 0 || val['value'].indexOf(',' + $(val['dep']).val()) >= 0) {
                        $(val['selector']).css({'display' : ''});
                    }
                    else {
                        $(val['selector']).css({'display' : 'none'});
                    }
                    break;
            }

            // Check dependency on parrent
            if ($(val['dep']).closest('.rwmb-field, *[class^="cmb-type-"], *[class*=" cmb-type-"]').is(':hidden')) {
                $(val['selector']).css({'display' : 'none'});
            }
            else {
            }
        });

    }

    function ihosting_init_dep_metas() {
        ihosting_page_update_display_dep_metas();
        $.each(ihostingPosttypeMetasdepConfig, function (i, val) {
            $(document).on('change', val['dep'], function () {
                ihosting_page_update_display_dep_metas();
            });
        });
    }

    ihosting_init_dep_metas();

});