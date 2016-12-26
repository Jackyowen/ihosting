jQuery(document).ready(function($) {
    'use strict';

    //Post settings
    function post_format_setting() {

        if ($('#post-format-image').is(':checked')) {
            $('#ihostingfashion_post_metas').fadeIn();
            $('.cmb_id_ihostingfashion_image_gallery').hide();
            $('.cmb_id_ihostingfashion_post_image').fadeIn();
            $('.cmb_id_ihostingfashion_post_video_embed').hide();
            $('.cmb_id_ihostingfashion_post_audio_embed').hide();

        } else if ($('#post-format-gallery').is(':checked')) {
            $('#ihostingfashion_post_metas').fadeIn();
            $('.cmb_id_ihostingfashion_image_gallery').fadeIn();
            $('.cmb_id_ihostingfashion_post_image').hide();
            $('.cmb_id_ihostingfashion_post_video_embed').hide();
            $('.cmb_id_ihostingfashion_post_audio_embed').hide();

        } else if ($('#post-format-video').is(':checked')) {
            $('#ihostingfashion_post_metas').fadeIn();
            $('.cmb_id_ihostingfashion_image_gallery').hide();
            $('.cmb_id_ihostingfashion_post_image').hide();
            $('.cmb_id_ihostingfashion_post_video_embed').fadeIn();
            $('.cmb_id_ihostingfashion_post_audio_embed').hide();

        } else if ($('#post-format-audio').is(':checked')) {
            $('#ihostingfashion_post_metas').fadeIn();
            $('.cmb_id_ihostingfashion_image_gallery').hide();
            $('.cmb_id_ihostingfashion_post_image').hide();
            $('.cmb_id_ihostingfashion_post_video_embed').hide();
            $('.cmb_id_ihostingfashion_post_audio_embed').fadeIn();

        } else {
            $('#ihostingfashion_post_metas').hide();
        }
    }
    post_format_setting();

    var select_type = $('#post_formats_select input');

    $(this).change(function() {
        post_format_setting();
    });

    // Portfolio settings
    function portfolio_setting() {
        var select_type = $('#ihostingfashion_portfolio_type option');

        var portfolio_standard = $('.cmb_id_ihostingfashion_portfolio_standard');
        var portfolio_slider = $('.cmb_id_ihostingfashion_portfolio_slider');
        var portfolio_image = $('.cmb_id_ihostingfashion_portfolio_image');
        var portfolio_video = $('.cmb_id_ihostingfashion_portfolio_video');
        var portfolio_soundcloud = $('.cmb_id_ihostingfashion_portfolio_soundcloud');
        var portfolio_video_urls = $('.cmb_id_ihostingfashion_portfolio_video_urls');
        var portfolio_audio_urls = $('.cmb_id_ihostingfashion_portfolio_audio_urls');
        var portfolio_image_audio_bg = $('.cmb_id_ihostingfashion_portfolio_image_audio_bg');

        select_type.each(function() {

            if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'standard')) {
                portfolio_slider.hide();
                portfolio_image.hide();
                portfolio_video.hide();
                portfolio_soundcloud.hide();
                portfolio_video_urls.hide();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'video')) {
                portfolio_slider.hide();
                portfolio_image.hide();
                portfolio_video.fadeIn();
                portfolio_soundcloud.hide();
                portfolio_video_urls.hide();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'image')) {
                portfolio_slider.hide();
                portfolio_image.fadeIn();
                portfolio_video.hide();
                portfolio_soundcloud.hide();
                portfolio_video_urls.hide();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'slider')) {
                portfolio_slider.fadeIn();
                portfolio_image.hide();
                portfolio_video.hide();
                portfolio_soundcloud.hide();
                portfolio_video_urls.hide();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'soundcloud')) {
                portfolio_slider.hide();
                portfolio_image.hide();
                portfolio_video.hide();
                portfolio_soundcloud.fadeIn();
                portfolio_video_urls.hide();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'audio-url')) {
                portfolio_slider.hide();
                portfolio_image.hide();
                portfolio_video.hide();
                portfolio_soundcloud.hide();
                portfolio_video_urls.hide();
                portfolio_audio_urls.fadeIn();
                portfolio_image_audio_bg.fadeIn();
            } else if (($(this).attr('selected') == 'selected') && ($(this).attr('value') == 'video-url')) {
                portfolio_slider.hide();
                portfolio_image.hide();
                portfolio_video.hide();
                portfolio_soundcloud.hide();
                portfolio_video_urls.fadeIn();
                portfolio_audio_urls.hide();
                portfolio_image_audio_bg.hide();
            }
        });
    }
    portfolio_setting();

    var select_type = $('#ihostingfashion_portfolio_type');

    $(this).change(function() {
        portfolio_setting();
    });


    function time_line_format_setting () {
        var select_time_line = $('#ihostingfashion_time_line_class option');

        select_time_line.each(function() {

            if ($(this).attr('selected') == 'selected' ){
                var select_time_line_val = $(this).val();
                $('.cmb_id_ihostingfashion_time_line_class .cmb_metabox_description').html('<span class="icofont '+select_time_line_val+'" style="font-size:30px;color:#C69C6D;"></span>');
            }
                 
        });
    }
    time_line_format_setting();

    var select_type = $('#ihostingfashion_time_line_class');

    $(this).change(function() {
        time_line_format_setting();
    });

    
    function services_format_setting () {
        var select_services = $('#ihostingfashion_services_class option');

        select_services.each(function() {

            if ($(this).attr('selected') == 'selected' ){
                var select_services_val = $(this).val();
                $('.cmb_id_ihostingfashion_services_class .cmb_metabox_description').html('<span class="icofont '+select_services_val+'" style="font-size:30px;color:#C69C6D;"></span>');
            }
                 
        });
    }
    services_format_setting();

    var select_type = $('#ihostingfashion_services_class');

    $(this).change(function() {
        services_format_setting();
    });


});