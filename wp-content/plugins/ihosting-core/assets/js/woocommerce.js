jQuery(document).ready(function ($) {

    "use strict";

    function kt_throttle(f, delay) {
        var timer = null;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = window.setTimeout(function () {
                    f.apply(context, args);
                },
                delay || 800);
        };
    }

    // Products search suggestion
    $(document).on('keyup', '.woocommerce-product-search input[name=s]', kt_throttle(function (event) {
        var $this            = $(this);
        var thisForm         = $this.closest('.woocommerce-product-search');
        var search_key       = $this.val();
        var product_cat_slug = '';
        if (thisForm.find('select[name=product_cat]').length) {
            product_cat_slug = thisForm.find('select[name=product_cat]').val();
        }

        if ($.trim(search_key) == '') {
            return false;
        }

        thisForm.addClass('searching');
        if (!thisForm.find('.spinner').length) {
            thisForm.append('<i class="spinner fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>');
        }

        var data = {
            action : 'ihosting_core_products_search_suggestion_via_ajax',
            search_key : search_key,
            product_cat_slug : product_cat_slug
        };

        $.post(ajaxurl, data, function (response) {
            if (thisForm.find('.search-input-wrap .products-suggestion-list').length) {
                thisForm.find('.search-input-wrap .products-suggestion-list').remove();
            }
            thisForm.find('.search-input-wrap').append(response['html']);
            thisForm.removeClass('searching');
        });
    }));

    $(document).on('focus click', '.woocommerce-product-search input[name=s]', function () {
        var $this    = $(this);
        var thisForm = $this.closest('.woocommerce-product-search');
        thisForm.find('.products-suggestion-list').css({
            'display' : 'block'
        });
    });

    $('.woocommerce-product-search').mouseleave(function () {
        $(this).find('.products-suggestion-list').css({
            'display' : 'none'
        });
    });

    $(document).click(function (e) {

        // check that your clicked
        // element has no id=info
        // and is not child of info
        if (!$(e.target).is('.woocommerce-product-search') && !$(e.target).closest('.woocommerce-product-search').length) {
            $('.woocommerce-product-search .products-suggestion-list').css({
                'display' : 'none'
            });
        }
    });

    // Switch products view mode
    $(document).on('click', '.shop-display-mode .display-mode', function (e) {
        var $this = $(this);
        if ($this.is('.active')) {
            return false;
        }
        var cur_mode = $('.shop-display-mode .display-mode.active').attr('data-mode');
        var new_mode = $this.attr('data-mode');

        $('.shop-display-mode .display-mode').removeClass('active');
        $this.addClass('active');
        $('.kt-products-' + cur_mode + '-wrap').addClass('kt-products-' + new_mode + '-wrap').removeClass('kt-products-' + cur_mode + '-wrap');

        e.preventDefault();
    });

    // Color chosen dropdown to box selection
    function ihosting_color_select_to_box() {
        $('.select-attr-pa_color').each(function () {
            var $this     = $(this);
            var thisWrap  = $this.parent();
            var cur_color = $('option:selected', this).attr('data-pa_color');
            var html      = '';

            if (thisWrap.find('#box-list-for-' + $this.attr('id')).length) {
                if (thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-color-attr[data-val="' + $this.val() + '"]').length) {
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-color-attr').removeClass('selected-color selected');
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-color-attr[data-val="' + $this.val() + '"]').addClass('selected-color selected');
                }
                else {
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-color-attr').removeClass('selected-color selected');
                    var new_attr_color = '<a href="#" data-val="' + $this.attr('value') + '" data-pa_color="' + cur_color + '" class="selected-color selected ' + color_attr_class + '" style="background-color: ' + cur_color + ';" title="' + $this.val() + '"><span class="screen-reader-text">Color ' + $this.val() + '</span></a>';
                    thisWrap.find('#box-list-for-' + $this.attr('id')).append(new_attr_color);
                }
                ihosting_update_disable_product_attrs();
                return;
            }

            $this.find('option').each(function () {
                var color            = $(this).attr('data-pa_color');
                var color_attr_class = 'product-color-attr product-box-attr';
                color_attr_class += color == cur_color ? ' selected-color selected' : '';
                if (color.toLowerCase() == 'white' || color.toLowerCase() == '#fff' || color.toLowerCase() == '#ffffff') {
                    color_attr_class += ' color-white';
                }
                if ($.trim(color) != '') {
                    color_attr_class += ' has-color';
                    html += '<a href="#" data-val="' + $(this).attr('value') + '" data-pa_color="' + color + '" class="' + color_attr_class + '" style="background-color: ' + color + ';" title="' + $(this).attr('value') + '"><span class="screen-reader-text">Color ' + $(this).attr('value') + '</span></a>';
                }
                else {
                    color_attr_class += ' no-color';
                    html += '<a href="#" data-val="' + $(this).attr('value') + '" data-pa_color="' + color + '" class="' + color_attr_class + '" title="' + $(this).attr('value') + '"><span class="screen-reader-text">No color</span></a>';
                }
            });

            if ($.trim(html) != '') {
                html = '<div id="box-list-for-' + $this.attr('id') + '" data-for-id="' + $this.attr('id') + '" class="color-box-list kt-product-attr-box-list">' + html + '</div>';
            }
            thisWrap.find('#box-list-for-' + $this.attr('id')).remove();
            $this.after(html);
        });
    }

    ihosting_color_select_to_box();

    // Size chosen dropdown to box selection
    function ihosting_size_select_to_box() {
        $('.select-attr-pa_size').each(function () {
            var $this    = $(this);
            var thisWrap = $this.parent();
            var cur_size = $('option:selected', this).attr('data-pa_size');
            var html     = '';

            if (thisWrap.find('#box-list-for-' + $this.attr('id')).length) {
                if (thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-size-attr[data-val="' + $this.val() + '"]').length) {
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-size-attr').removeClass('selected-size selected');
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-size-attr[data-val="' + $this.val() + '"]').addClass('selected-size selected');
                }
                else {
                    thisWrap.find('#box-list-for-' + $this.attr('id') + ' .product-size-attr').removeClass('selected-size selected');
                    var new_attr_size = '<a href="#" data-val="' + $this.attr('value') + '" data-pa_size="' + cur_size + '" class="selected-size selected ' + size_attr_class + '" title="' + cur_size + '"><span class="pa_size-text">' + cur_size + '</span></a>';
                    thisWrap.find('#box-list-for-' + $this.attr('id')).append(new_attr_size);
                }
                ihosting_update_disable_product_attrs();
                return;
            }

            $this.find('option').each(function () {
                var size            = $(this).attr('data-pa_size');
                var size_attr_class = 'product-size-attr product-box-attr';
                size_attr_class += size == cur_size ? ' selected-size selected' : '';
                if ($.trim(size) != '') {
                    size_attr_class += ' has-size';
                    html += '<a href="#" data-val="' + $(this).attr('value') + '" data-pa_size="' + size + '" class="' + size_attr_class + '" title="' + size + '"><span class="pa_size-text">' + size + '</span></a>';
                }
                else {
                    size_attr_class += ' no-size';
                    html += '<a href="#" data-val="' + $(this).attr('value') + '" data-pa_size="' + size + '" class="' + size_attr_class + '" title="' + size + '"><span class="pa_size-text"> - </span></a>';
                }
            });

            if ($.trim(html) != '') {
                html = '<div id="box-list-for-' + $this.attr('id') + '" data-for-id="' + $this.attr('id') + '" class="size-box-list kt-product-attr-box-list">' + html + '</div>';
            }
            thisWrap.find('#box-list-for-' + $this.attr('id')).remove();
            $this.after(html);
        });
    }

    ihosting_size_select_to_box();

    function ihosting_color_box_cart() {
        $('.variation .kt-variation-color').each(function () {
            var $this      = $(this);
            var this_color = $this.attr('data-additional_attr');

            if (typeof this_color == 'undefined' || typeof this_color === false) {
                this_color = 'transparent';
            }

            $this.css({
                'border-color' : this_color,
                'background-color' : this_color
            });

            if (this_color.toLowerCase() == 'white' || this_color.toLowerCase() == '#fff' || this_color.toLowerCase() == '#ffffff') {
                $this.addClass('color-white');
            }

        });
    }

    ihosting_color_box_cart();

    // Cart responsive table
    function ihosting_cart_responsive_table() {
        var ww = window.innerWidth;
        if (ww <= 767) {
            $('.shop_table_responsive.cart').each(function () {
                var thisTable = $(this);
                thisTable.find('tbody tr td').each(function () {
                    var this_td_title = $(this).attr('data-title');
                    if (typeof this_td_title != 'undefined' && typeof this_td_title != false) {
                        var this_td_title_html = '<h6 class="cart-table-responsive-title hidden-sm hidden-md hidden-lg">' + this_td_title + '</h6>';
                        if (!$(this).find('.cart-table-responsive-title').length && !$(this).is('.product-remove')) {
                            $(this).prepend(this_td_title_html);
                        }
                        if ($(this).is('.product-remove')) {
                            $(this).find('.remove').addClass('kt-remove-cart-item-mobile button').html(this_td_title);
                        }
                    }
                });
            });
        }
        else {
            $('.shop_table_responsive.cart').each(function () {
                var thisTable = $(this);
                thisTable.find('.remove').removeClass('button');
            });
        }
    }

    ihosting_cart_responsive_table();

    // Shipping to different address checkbox markup
    function ihosting_shipping_diff_address_cb_markup() {
        if (!$('#ship-to-different-address .input-checkbox').length) {
            return false;
        }
        $('#ship-to-different-address .input-checkbox').addClass('hide'); // Hide default checkbox

        $('#ship-to-different-address .input-checkbox').each(function () {
            if ($(this).is(':checked')) {
                $(this).closest('#ship-to-different-address').addClass('is-checked');
            }
            else {
                $(this).closest('#ship-to-different-address').removeClass('is-checked');
            }
        });

    }

    ihosting_shipping_diff_address_cb_markup();
    $(document).on('change', '#ship-to-different-address .input-checkbox', function () {
        ihosting_shipping_diff_address_cb_markup();
    });

    // Payment methods radio buttons markup
    function ihosting_payment_methods_radio_btns_markup() {
        if (!$('.wc_payment_methods').length) {
            return false;
        }
        $('.wc_payment_methods .input-radio').addClass('hide'); // Hide default checkbox
        $('.wc_payment_methods').find('.wc_payment_method').removeClass('is-checked');

        $('.wc_payment_methods .input-radio').each(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.wc_payment_method').addClass('is-checked');
            }
            else {
                $(this).closest('.wc_payment_method').removeClass('is-checked');
            }
        });

    }

    ihosting_payment_methods_radio_btns_markup();

    $(document).on('change', '.wc_payment_methods .wc_payment_method .input-radio', function (e) {
        ihosting_payment_methods_radio_btns_markup();
    });

    function ihosting_update_disable_product_attrs() {
        $('.product .variations_form .variations select').each(function () {
            var $this   = $(this);
            var this_id = $this.attr('id');
            $('#box-list-for-' + this_id + ' a').addClass('disabled');
            $this.find('option').each(function () {
                $('#box-list-for-' + this_id + ' a[data-val="' + $(this).attr('value') + '"]').removeClass('disabled');
            });
        });
    }

    // Trigger update variations values
    function ihosting_update_variation_values() {
        if ($('.product .variations_form').length) {
            $('.product .variations_form .variations select').trigger('focusin');
            if ($('.product .variations_form .variations select.select-attr-pa_color').length) {
                $('.product .variations_form .variations select.select-attr-pa_color').trigger('focusin');
            }
            //$('.product .variations_form').trigger('woocommerce_update_variation_values');
        }
    }

    $(document).on('change', '.product .variations_form .variations select', function (e) {
        var $this    = $(this);
        var thisForm = $this.closest('form');
        if (!$this.is('.select-attr-pa_color') && thisForm.find('.select-attr-pa_color').length) {
            thisForm.find('.select-attr-pa_color').trigger('focusin');
        }
        //ihosting_update_disable_product_attrs();
    });

    $(document).on('mouseenter', '.kt-product-attr-box-list .product-box-attr', function (e) {
        var $this          = $(this);
        var thisWrap       = $this.closest('.kt-product-attr-box-list');
        var real_select_id = thisWrap.attr('data-for-id');

        $('#' + real_select_id).trigger('focusin');

        e.preventDefault();
    });

    // Choose product attribute via box list
    $(document).on('click', '.kt-product-attr-box-list .product-box-attr', function (e) {
        var $this          = $(this);
        var thisWrap       = $this.closest('.kt-product-attr-box-list');
        var thisForm       = $this.closest('form');
        var real_select_id = thisWrap.attr('data-for-id');
        var real_cur_val   = $('#' + real_select_id).val();
        var new_val        = $this.attr('data-val');

        $('#' + real_select_id).trigger('click');

        if ($this.is('.disabled')) {
            return false;
        }

        $('#' + real_select_id).val(new_val).trigger('change');

        e.preventDefault();
    });

    $(document).on('woocommerce_variation_has_changed', '.product .variations_form', function () {
        ihosting_color_select_to_box();
        ihosting_size_select_to_box();
    });

    $(document).on('woocommerce_update_variation_values', '.product .variations_form', function () {
        ihosting_color_select_to_box();
        ihosting_size_select_to_box();
    });

    // Zoom product images
    function ihosting_zoom_product_images() {
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
    }

    ihosting_zoom_product_images();

    // Hidden empty taxonomy on products filter widget
    function ihosting_hidden_empty_tax_on_products_filter() {
        $('.woof_list input[type=radio][disabled], .woof_list input[type=checkbox][disabled]').each(function () {
            $(this).closest('li').addClass('hidden');
        });
    }

    ihosting_hidden_empty_tax_on_products_filter();

    // Update products color filter widget
    function ihosting_update_products_color_filter() {
        $('.woof_list input[name="pa_color"], .woof_list input[data-tax="pa_color"]').addClass('hidden');
        $('.woof_list input[name="pa_color"], .woof_list input[data-tax="pa_color"]').each(function () {
            var $this     = $(this);
            var this_type = $this.attr('type');
            var thisLi    = $this.closest('li');
            var this_slug = $this.attr('data-slug');

            if ($this.is(':checked')) {
                thisLi.addClass('checked-color');
            }

            if (typeof this_slug == 'undefined' || typeof this_slug === false) {
                this_slug = $this.attr('name');
            }

            if (typeof this_slug != 'undefined' && typeof this_slug != false) {
                var this_color = ihosting['product_color_info'][this_slug];
                $this.attr('data-color', this_color);
                if (!thisLi.find('.color-filter').length) {
                    thisLi.prepend('<span class="color-filter color-filter-type-' + this_type + '" style="background-color: ' + this_color + '"></span>');
                }
            }

        });
    }

    ihosting_update_products_color_filter();


    // Reinit some important things after ajax
    $(document).ajaxComplete(function (event, xhr, settings) {

        // if (ihosting['is_yith_quickview_premium'] == 'yes') {
        //     $.fn.yith_wcqv_init();
        // }
        // else {
        //     // For Quick View free version
        //     $.fn.yith_quick_view();
        // }

        // Update ordering if there is no orderby filter exist
        if ($('.woof_results_by_ajax_shortcode').length && !$('.woof_results_by_ajax_shortcode .woof_products_top_panel a[data-tax="orderby"]').length) {
            $('.woocommerce-ordering select[name="orderby"] option:first-child').attr("selected", "selected");
            $('.woocommerce-ordering .ihosting-select').each(function () {
                $(this).trigger("chosen:updated");
            });
        }

        // Make sure current products view mode will not be changed after ajax load
        if ($('.shop-display-mode').length) {
            var cur_shop_view_mode = $('.shop-display-mode .display-mode.active').attr('data-mode');
            var loaded_mode        = 'grid';
            if (typeof cur_shop_view_mode == 'undefined' || typeof cur_shop_view_mode === false) {
                cur_shop_view_mode = 'grid';
            }
            if (!$('.kt-products-' + cur_shop_view_mode + '-wrap').length) {
                loaded_mode = cur_shop_view_mode == 'list' ? 'grid' : 'list';
                $('.kt-products-' + loaded_mode + '-wrap').addClass('kt-products-' + cur_shop_view_mode + '-wrap').removeClass('kt-products-' + loaded_mode + '-wrap');
            }
        }

        // Update color select box
        ihosting_color_select_to_box();
        ihosting_size_select_to_box();

        // Update variation color box
        ihosting_color_box_cart();

        // Update payment methods radio buttons markup
        ihosting_payment_methods_radio_btns_markup();

        // Update hidden empty taxonomy on products filter widget
        ihosting_hidden_empty_tax_on_products_filter();

        // Update products color filter widget
        ihosting_update_products_color_filter();

        // $(document).on('click', 'a[data-tax="orderby"]', function () {
        //     $('.woocommerce-ordering select[name="orderby"] option:first-child').attr("selected", "selected");
        //     $('.woocommerce-ordering .ihosting-select').each(function () {
        //         $(this).trigger("chosen:updated");
        //     });
        // });

    });

    // Updatesome info after added to cart
    $(document).on('added_to_cart', function () {

        if ($('.cart-count-hidden').length) {
            var total_items   = $('.cart-count-hidden').val();
            var cart_subtotal = $('.mini-cart-content .total .amount').html();
            $('.mini-cart-content .count .number-of-items, .cart-link .count').html(total_items);
            $('.cart-link .subtotal .amount').html(cart_subtotal);
        }

        if ($('body').is('.single-product')) {
            $('.summary.entry-summary .add_to_cart_button').removeClass('added');
        }

    });

    // When change product quantity on single product page
    $(document).on('change', '.summary.entry-summary .quantity input[name="quantity"]', function () {
        var $this           = $(this);
        var thisSummaryWrap = $this.closest('.entry-summary');
        var thisVal         = $this.val();

        thisSummaryWrap.find('.add_to_cart_button').attr('data-quantity', thisVal);

    });


    // Single product add to cart via ajax (chua dc)
    $(document).on('submit', '.summary.entry-summary_bak form.cart', function () {

        // AJAX add to cart request
        var $thisForm    = $(this);
        var addToCartBtn = $thisForm.find('.single_add_to_cart_button');

        var can_submit_add_to_cart_via_ajax = true;

        var data = {};

        if ($thisForm.find('.variations_button').length) {
            can_submit_add_to_cart_via_ajax = !$thisForm.find('.variations_button').is(':hidden');

            var variation_data = {};
            $thisForm.find('.variations .value select').each(function () {
                var attr_name             = $(this).attr('data-attribute_name');
                var attr_val              = $(this).val();
                variation_data[attr_name] = attr_val;
            });

            data = {
                action : 'woocommerce_add_to_cart_variable_rc',
                quantity : $thisForm.find('input[name="quantity"]').val(),
                product_id : $thisForm.find('input[name="product_id"]').val(),
                variation_id : $thisForm.find('input[name="variation_id"]').val(),
                variation : variation_data
            };
        }
        else {
            data = {
                quantity : $thisForm.find('input[name="quantity"]').val(),
                product_id : $thisForm.find('input[name="add-to-cart"]').val()
            };
        }

        if (can_submit_add_to_cart_via_ajax) {

            addToCartBtn.removeClass('added');
            addToCartBtn.addClass('loading');

            // Trigger event
            $(document.body).trigger('adding_to_cart', [addToCartBtn, data]);

            // Ajax action
            $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'), data, function (response) {

                if (!response) {
                    return;
                }

                var this_page = window.location.toString();

                this_page = this_page.replace('add-to-cart', 'added-to-cart');

                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                }

                // Redirect to cart option
                if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {

                    window.location = wc_add_to_cart_params.cart_url;
                    return;

                } else {

                    addToCartBtn.removeClass('loading');

                    var fragments = response.fragments;
                    var cart_hash = response.cart_hash;

                    // Block fragments class
                    if (fragments) {
                        $.each(fragments, function (key) {
                            $(key).addClass('updating');
                        });
                    }

                    // Block widgets and fragments
                    $('.shop_table.cart, .updating, .cart_totals').fadeTo('400', '0.6').block({
                        message : null,
                        overlayCSS : {
                            opacity : 0.6
                        }
                    });

                    // Changes button classes
                    addToCartBtn.addClass('added');

                    // View cart text
                    if (!wc_add_to_cart_params.is_cart && addToCartBtn.parent().find('.added_to_cart').size() === 0) {
                        addToCartBtn.after(' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
                            wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>');
                    }

                    // Replace fragments
                    if (fragments) {
                        $.each(fragments, function (key, value) {
                            $(key).replaceWith(value);
                        });
                    }

                    // Unblock
                    $('.widget_shopping_cart, .updating').stop(true).css('opacity', '1').unblock();

                    // Cart page elements
                    $('.shop_table.cart').load(this_page + ' .shop_table.cart:eq(0) > *', function () {

                        $('.shop_table.cart').stop(true).css('opacity', '1').unblock();

                        $(document.body).trigger('cart_page_refreshed');
                    });

                    $('.cart_totals').load(this_page + ' .cart_totals:eq(0) > *', function () {
                        $('.cart_totals').stop(true).css('opacity', '1').unblock();
                    });

                    // Trigger event so themes can refresh other areas
                    $(document.body).trigger('added_to_cart', [fragments, cart_hash, addToCartBtn]);
                }
            });

            return false;

        }

    });


    // Update
    $(document).on('change', 'form.cart select', function () {
        $(this).closest('form.cart').find('select').trigger('chosen:updated');
    });

    // Update input quantity
    $(document).on('click', '.quantity .plus', function (e) {
        var $this    = $(this);
        var thisWrap = $this.closest('.quantity');
        var min_val  = parseInt(thisWrap.find('input.qty').attr('min'));
        var max_val  = parseInt(thisWrap.find('input.qty').attr('max'));
        var cur_val  = parseInt(thisWrap.find('input.qty').val());

        if (isNaN(min_val)) {
            min_val = 1;
        }
        if (isNaN(max_val)) {
            max_val = 99999;
        }
        if (isNaN(cur_val)) {
            cur_val = min_val;
        }
        if (cur_val + 1 <= max_val) {
            thisWrap.find('input.qty').val(cur_val + 1);
        }

        e.preventDefault();
    });
    $(document).on('click', '.quantity .minus', function (e) {
        var $this    = $(this);
        var thisWrap = $this.closest('.quantity');
        var min_val  = parseInt(thisWrap.find('input.qty').attr('min'));
        var max_val  = parseInt(thisWrap.find('input.qty').attr('max'));
        var cur_val  = parseInt(thisWrap.find('input.qty').val());

        if (isNaN(min_val)) {
            min_val = 1;
        }
        if (isNaN(max_val)) {
            max_val = 99999;
        }
        if (isNaN(cur_val)) {
            cur_val = min_val;
        }
        if (cur_val - 1 >= min_val) {
            thisWrap.find('input.qty').val(cur_val - 1);
        }

        e.preventDefault();
    });

    // Product image clickable - added from iHosting Core 1.2.3 (iHosting them 1.1.3)
    $(document).on('click', '.product-img-clickable', function (e) {

        var $this       = $(this);
        var thisProduct = $this.closest('.product');
        if ($this.closest('.product-item').length) {
            thisProduct = $this.closest('.product-item');
        }
        var product_link = thisProduct.find('.ts-viewdetail').attr('href');

        if (typeof product_link != 'undefined' && typeof product_link != false) {
            if (!$(e.target).is('.ts-product-button') && !$(e.target).is('a')) {
                if ($.trim(product_link) != '' && $.trim(product_link) != '#') {
                    window.location.href = product_link;
                }
            }
        }

        e.preventDefault();
        e.stopPropagation();

    });

    // Chosen State checkout
    //$(document).on('change', '.woocommerce-billing-fields #billing_country', function(){
//        
//        //$('#billing_state_field .chosen-container').remove();
//        if ($('#billing_state_field select').length) {
//            $('#billing_state_field select').chosen('destroy');
//            $('#billing_state_field select').chosen();
//        }
//        else{
//            $('#billing_state_field .chosen-container').remove();
//        }
//         
//    });
    //$(window).load(function(){
//        if ($('.state_select').length) {
//            $('.state_select').chosen('destroy');
//        }
//    });

    // Window resize
    $(window).on('debouncedresize', function () {
        ihosting_cart_responsive_table();
    });

    // On all loaded
    $(window).load(function () {
        ihosting_color_select_to_box();
        ihosting_size_select_to_box();
        ihosting_update_variation_values();
    });

});