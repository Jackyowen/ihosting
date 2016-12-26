
(function($){

    $.fn.invisible = function(){

        return this.each(function(){

            $(this).css("display", "none");

        });

    };
    $.fn.visible = function(){

        return this.each(function(){

            $(this).css("display", "block");

        });

    };

}(jQuery));

$(document).ready(function()
{
    var myTimer = undefined;
    var delayTime = 1500;
    var TldArray = ["com","net","info","org","biz","tv","co","in","us","am","me","cc","uk","ag","io","mobi"];
    var currentRequest = null;
    var zandcAjaxRequest = null;
    var zandcAjaxRequestSingleCheck = null;
    $(document).on("click keyup",".Search" ,function(e)
    {
        if ((e.which >= 1 && e.which <= 4) || (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 105) || e.which == 45 || e.which == 190 || e.which == 13 || e.which == 8 || e.which == 189 || e.which == 109 || e.which == 111 || e.which == 191)
        {
            var domain = search_validate($('#Search').val());
            var domain_length = domain.length;
            var the_char=domain.charAt(0);
            if(the_char === " " || domain.match(/^([-.@#$%^&*()=":';?></|!])/) || domain == "" || domain_length == 1)
            {
                $("#main_page").visible();
                $("#social-button").visible();
                $(".footer").removeClass("footer-hidden");
                $("#tld_list").invisible();
                $("#top-header-domain").invisible();
                $("#links").invisible();
            }
            else
            {
                $("#main_page").invisible();
                $("#social-button").invisible();
                $(".footer").addClass("footer-hidden");
                $("#tld_list").visible();
                $("#top-header-domain").visible();
                $("#links").visible();
                $('.suggesstions-list').css('height',$('.search-tld').css('height'));
                $(".btn-dmn").css({"background-color": "#C2C7CD"});
                $(".com-btn").css({"background-color": "#C2C7CD"});
                $('.btn-dmn').html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
                $('.com-btn').html('<div class="spinner main-tld-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
                $("#change-background").removeClass("main-tld-cont available").addClass("main-tld-cont is-loading");
                $("#change-background").removeClass("main-tld-cont not-available").addClass("main-tld-cont is-loading");
                $('.btn-dmn,.com-btn').attr('id', 'default');
                $('.InstantDomainShow').html(domain);
                var TotalDivWidth = $(".domain-name").width();
                var DomainWidth = $(".InstantDomainShow").width();
                var ExtWidth = $(".domain-ext").width();
                var ExtractWidth = TotalDivWidth-DomainWidth;
                if(ExtractWidth < ExtWidth)
                    $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                else
                    $(".domain-ext").css({"position": "relative", "padding": "0","top": "0", "background-color": "none"});
                var start = domain.indexOf(".");
                if(start != -1)
                {
                    var FirstPart = domain.substr(0,start);
                    var FindExtension = domain.substr(start+1,domain_length);
                }
                else
                {
                    var FirstPart = domain;
                    var FindExtension = "";
                }
                domain = FirstPart;
                if (jQuery.inArray(FindExtension, TldArray)!='-1') {
                    main_tld = FindExtension;
                    $('.live-domain-name').html(domain+"."+main_tld);
                } else {
                    var main_tld="com";
                    $('.live-domain-name').html(domain+"."+main_tld);
                }

                var tlds_args = Array();
                var tld_args_to_check = tlds_args;
                var instant_ajax_url = 'https://instantdomainsearch.com/all/';
                var first_tld='com';instant_ajax_url='https://instantdomainsearch.com/all/' + domain +'?&tldTags=popular';instant_ajax_url='https://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('select * from html where url="' + instant_ajax_url + '"') + '&format=json&callback=?';var price_args=Array();var whois_url='';whois_url='<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="http://who.is/whois/{domain_full}">';var who='WHOIS';var top_result_not_avai_html='<div id="change-background" class="com-rslt red-rslt">' +
                '<div class="wrapper">'+
                whois_url+
                '<div class="com-wrap">'+
                '<div class="com-wrap"><span class="live-domain-name">{domain_full}</span> <div id="top_WHOIS_domain" class="com-btn">WHOIS</div></div>'+
                '</div>'+
                '</a>'+
                '</div>'+
                '</div>';var top_result_avai_html='<div id="change-background" class="com-rslt green-rslt">'+
                '<div class="wrapper">'+
                '<a data-toggle="tooltip" data-placement="left" title="{domain_full}" id="top_domain_href" target="_blank" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">'+
                '<div class="com-wrap">'+
                '<div class="com-wrap"><span class="live-domain-name">{domain_full}</span> <div id="top_{tld}_domain" class="com-btn">{price}</div></div>'+
                '</div>'+
                '</a>'+
                '</div>'+
                '</div>';tlds_args.push('com');price_args['com']='Buy $ 2.99';tlds_args.push('net');price_args['net']='Buy $ 11.99';tlds_args.push('info');price_args['info']='Buy $ 2.99';tlds_args.push('org');price_args['org']='Buy $ 8.99';tlds_args.push('biz');price_args['biz']='Buy $ 7.99';tlds_args.push('tv');price_args['tv']='Buy $ 39.99';tlds_args.push('co');price_args['co']='Buy $ 12.99';tlds_args.push('in');price_args['in']='Buy $ 2.99';tlds_args.push('us');price_args['us']='Buy $ 3.99';tlds_args.push('am');price_args['am']='Buy $ 89.99';tlds_args.push('me');price_args['me']='Buy $ 9.99';tlds_args.push('cc');price_args['cc']='Buy $ 15.99';tlds_args.push('uk');price_args['uk']='Buy $ 6.99';tlds_args.push('ag');price_args['ag']='Buy $ 149.99';tlds_args.push('io');price_args['io']='Buy $ 59.99';tlds_args.push('mobi');price_args['mobi']='Buy $ 6.99';zandcAjaxRequest = $.ajax({
                url : instant_ajax_url,
                cache : true,
                dataType : 'html',
                statusCode : {
                    429 : function (response) {
                        console.log('Please try again');
                    }
                },
                beforeSend : function () {
                    if (zandcAjaxRequest != null) {
                        // console.log('Abort previous request');
                        zandcAjaxRequest.abort();
                    }
                    if (zandcAjaxRequestSingleCheck != null) {
                        // console.log('Abort previous single check request');
                        zandcAjaxRequestSingleCheck.abort();
                    }
                },
                success : function (response) {
                    //console.log(response);
                    var search_results = response;
                    var result_html    = '';
                    if ($.trim(search_results) != '') {
                        var results_txt_split = search_results.split("\n");
                        var count_results     = results_txt_split.length;
                        var i                 = 0;

                        $.each(results_txt_split, function () {
                            i++;
                            if ($.trim(this) != '' && i < count_results) {
                                var search_result_json = JSON.parse(this);
                                if (search_result_json['tld'] == tld_args_to_check[0] && search_result_json['label'] == domain) {
                                    if (search_result_json['isRegistered'] === true) {
                                        $('#change-background').replaceWith(top_result_not_avai_html.replace(/{domain_full}/g, search_result_json['label'] + '.' + search_result_json['tld']));
                                    }
                                    else{
                                        result_html = top_result_avai_html.replace(/{domain_full}/g, search_result_json['label'] + '.' + search_result_json['tld']);
                                        result_html = result_html.replace(/{domain}/g, search_result_json['label']);
                                        result_html = result_html.replace(/{tld}/g, search_result_json['tld']);
                                        result_html = result_html.replace(/{price}/g, price_args[search_result_json['tld']]);
                                        $('#change-background').replaceWith(result_html);
                                    }
                                    return false;
                                }
                            }
                        });
                        // console.log(first_search_results_json);

                        zandc_get_checking_results_html(search_results, domain, tld_args_to_check, '', price_args, ExtractWidth, ExtWidth );

                        //zandc_remove_item_of_array( search_result_json['tld'], tld_args_need_check );
                    }
                }
            });
                clearTimeout(myTimer);
                myTimer = window.setTimeout( function() {
                    domain = domain.substring(0,60);
                    $.ajax({
                        type:"POST",
                        url: "http://ddns.imwebstar.com/suggest.php",
                        cache : true,
                        data: {'domain':domain},
                        success: function(msg)
                        {
                            $('.suggesstions-list').css({'height':'100%'});
                            $('.suggesstions-list').html(msg);
                        },
                        error: function(msg) {

                        }
                    });
                    /*
                     $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain,'tld':main_tld,'tld1':'main_div'},
                     dataType: "json",
                     success: function(msg)
                     {
                     //$("#top-header-domain").html(msg[0]);
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    if(currentRequest != null)
                        currentRequest.abort();
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'com'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_com").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'net'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_net").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'info'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_info").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'org'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_org").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'biz'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_biz").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'tv'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_tv").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'co'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_co").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'in'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_in").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'us'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_us").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'am'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_am").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'me'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_me").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'cc'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_cc").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'uk'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_uk").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'ag'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_ag").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'io'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_io").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                    /*
                     currentRequest = $.ajax({
                     type:"POST",
                     url: "http://ddns.imwebstar.com/results.php",
                     cache : true,
                     data: {'domain':domain ,'tld':'mobi'},
                     dataType: "json",
                     success: function(msg)
                     {
                     $("#tab_mobi").html(msg[0]);
                     if(ExtractWidth < ExtWidth)
                     $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                     else
                     $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                     },
                     error: function(msg) {

                     }
                     });
                     */
                }, delayTime);
            }
        }
    });
});

function zandc_remove_item_of_array(item_need_remove, args) {
    args = jQuery.grep(args, function (value) {
        return value != item_need_remove;
    });

    return args;
}

function zandc_get_checking_results_html(search_results, domain, tld_args_to_check, country_detect_code, price_args, ExtractWidth, ExtWidth) {
    var results_txt_split        = search_results.split("\n");
    var results_html             = '';
    var tld_args_need_check      = tld_args_to_check; // Remaining tlds need check
    var tld_args_already_checked = Array();
    var i                        = 0;
    var count_result             = 0;
    var count_results            = results_txt_split.length;
    var is_country_code_checked  = $.trim(country_detect_code) == '';

    var whois_url='';whois_url='<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="http://who.is/whois/{domain_full}">';
    var avai_html = '<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" id="href_{tld}" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">'+
        '<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
        '<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
        '</div>'+
        '<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
        '<div id="tld_{tld}"  class="btn-dmn btn-green" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">{price}'+
        '</div>'+
        '</div>'+
        '</a>';

    var not_avai_html = whois_url +
        '<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
        '<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
        '</div>'+
        '<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
        '<div id="tld_whois" class="btn-dmn btn-red" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">WHOIS'+
        '</div>'+
        '</div>'+
        '</a>';

    $.each(results_txt_split, function () {
        i++;
        if ($.trim(this) != '') {
            var search_result_json = JSON.parse(this);
            if (search_result_json['label'] == domain && $.inArray(search_result_json['tld'], tld_args_to_check) > -1 && $.inArray(search_result_json['tld'], tld_args_already_checked) == -1) {
                if (search_result_json['isRegistered']) {
                    var not_avai_html_replaced = not_avai_html.replace(/{domain_full}/g, search_result_json['label'] + '.' + search_result_json['tld']);
                    not_avai_html_replaced = not_avai_html_replaced.replace(/{domain}/g, search_result_json['label']).replace(/{tld}/g, search_result_json['tld']);
                    $("#tab_" + search_result_json['tld'].replace('.', '')).html(not_avai_html_replaced);
                }
                else {
                    var avai_html_replaced = avai_html.replace(/{domain_full}/g, search_result_json['label'] + '.' + search_result_json['tld']);
                    avai_html_replaced = avai_html_replaced.replace(/{domain}/g, search_result_json['label']).replace(/{tld}/g, search_result_json['tld']);
                    avai_html_replaced = avai_html_replaced.replace(/{price}/g, price_args[search_result_json['tld']]);
                    $("#tab_" + search_result_json['tld'].replace('.', '')).html(avai_html_replaced);
                }
                if(ExtractWidth < ExtWidth) {
                    $(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
                }
                else {
                    $(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
                }

                tld_args_need_check = zandc_remove_item_of_array(search_result_json['tld'], tld_args_need_check);
                tld_args_already_checked.push(search_result_json['tld']);
            }
        }
    });

    if (tld_args_need_check.length > 0){
        var count_result = 0;
        for (i = 0; i < tld_args_need_check.length; i++) {
            if (count_result > 99) {
                break;
            }
            zandc_instant_check_domain(domain + '.' + tld_args_need_check[i], price_args);
            count_result++
        }
    }

}

function zandc_instant_check_domain(domain_name, price_args) {
    var domain_name_split   = domain_name.split('.');
    var instant_ajax_url    = 'https://instantdomainsearch.com/all/';
    var domain_tld          = 'com';
    var whois_link_html     = '';
    var integrate_link_html = '';

    if (typeof domain_name_split[1] === 'undefined' || typeof domain_name_split[1] === false) {
        instant_ajax_url += domain_name_split[0] + '?&partTld=' + domain_tld;
    }
    else {
        instant_ajax_url += domain_name_split[0] + '?&partTld=' + domain_name_split[1];
        domain_tld      = domain_name_split[1];
    }
    if (typeof domain_name_split[2] != 'undefined' && typeof domain_name_split[2] != false) { // sld
        instant_ajax_url += '.' + domain_name_split[2];
        domain_tld += '.' + domain_name_split[2];
    }

    instant_ajax_url='https://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('select * from html where url="' + instant_ajax_url + '"') + '&format=json&callback=?';

    var whois_url='';whois_url='<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="http://who.is/whois/{domain_full}">';
    var avai_html = '<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" id="href_{tld}" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">'+
        '<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
        '<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
        '</div>'+
        '<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
        '<div id="tld_{tld}"  class="btn-dmn btn-green" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">{price}'+
        '</div>'+
        '</div>'+
        '</a>';

    var not_avai_html = whois_url +
        '<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
        '<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
        '</div>'+
        '<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
        '<div id="tld_whois" class="btn-dmn btn-red" href="http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck={domain}.{tld}&checkAvail=1">WHOIS'+
        '</div>'+
        '</div>'+
        '</a>';

    var result_html = '';

    zandcAjaxRequestSingleCheck = $.ajax({
        url : instant_ajax_url,
        //type : 'GET',
        cache : true,
        dataType : 'html',
        success : function (response) {
            var search_results = response;

            if ($.trim(search_results) != '') {
                var results_txt_split = search_results.split("\n");

                var first_search_results_json = JSON.parse(results_txt_split[0]);

                if (first_search_results_json['label'] == 'undefined' || first_search_results_json['label'] == undefined) {
                    return false;
                }

                if (first_search_results_json['isRegistered'] === true) {
                    var not_avai_html_replaced = not_avai_html.replace(/{domain_full}/g, first_search_results_json['label'] + '.' + first_search_results_json['tld']);
                    not_avai_html_replaced = not_avai_html_replaced.replace(/{domain}/g, first_search_results_json['label']).replace(/{tld}/g, first_search_results_json['tld']);
                    $("#tab_" + first_search_results_json['tld'].replace('.', '')).html(not_avai_html_replaced);
                }
                else{
                    var avai_html_replaced = avai_html.replace(/{domain_full}/g, first_search_results_json['label'] + '.' + first_search_results_json['tld']);
                    avai_html_replaced = avai_html_replaced.replace(/{domain}/g, first_search_results_json['label']).replace(/{tld}/g, first_search_results_json['tld']);
                    avai_html_replaced = avai_html_replaced.replace(/{price}/g, price_args[first_search_results_json['tld']]);
                    $("#tab_" + first_search_results_json['tld'].replace('.', '')).html(avai_html_replaced);
                }

            }
            else {
                //thisWrapInner.find('.zan-dc-results-wrap .zan-dc-results').remove();
            }

        }
    });
}

function search_validate(val)
{
    var newClass;
    newClass =val;
    var intIndexOfMatch = newClass.indexOf("---");
    while (intIndexOfMatch != -1)
    {
        newClass = newClass.replace( "---", "--" )
        intIndexOfMatch = newClass.indexOf( "---" );
    }
    var intIndexOfMatch = newClass.indexOf(".-");
    while (intIndexOfMatch != -1)
    {
        newClass = newClass.replace( ".-", "" )
        intIndexOfMatch = newClass.indexOf( ".-" );
    }
    var intIndexOfMatch = newClass.indexOf("-.");
    while (intIndexOfMatch != -1)
    {
        newClass = newClass.replace( "-.", "" )
        intIndexOfMatch = newClass.indexOf( "-." );
    }
    newClass = newClass.replace(/\.+$|\-+$/g,"");
    newClass = newClass.replace ( /[^a-zA-Z0-9.-]/g, '');
    return newClass;
}
function affiliate_links_change(lastID)
{
    $.ajax({
        type:"POST",
        url: "http://ddns.imwebstar.com/includes/count_stats.php",
        data: {'affiliates_clicks':'1','affiliate_name':lastID},
        success: function(msg){
            $("#alert").html(msg);
        },
        error:function(){
        }

    });

    $(".tab").removeClass("active");

    $("#"+lastID).addClass('active');

    var domain = document.getElementById("Search").value;

    var valid_domain=search_validate(domain);

    if(lastID == "godaddy")
        godaddy_changes(lastID,valid_domain);
    else if(lastID == "iwant_my_name")
        iwantmyname_changes(lastID,valid_domain);
    else if(lastID == "media_temple")
        media_temple_changes(lastID,valid_domain);
    else if(lastID == "name_cheap")
        name_cheap_changes(lastID,valid_domain);
    else if(lastID == "one_one")
        one_one_changes(lastID,valid_domain);
    else if(lastID == "register")
        register_changes(lastID,valid_domain);
    else if(lastID == "united_domains")
        united_domains_changes(lastID,valid_domain);
    else if(lastID == "hover")
        hover_changes(lastID,valid_domain);

}
function godaddy_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 2.99');
    $("#href_com").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.com&checkAvail=1");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 11.99');
    $("#href_net").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.net&checkAvail=1");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 2.99');
    $("#href_info").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.info&checkAvail=1");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 8.99');
    $("#href_org").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.org&checkAvail=1");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 7.99');
    $("#href_biz").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.biz&checkAvail=1");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 39.99');
    $("#href_tv").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.tv&checkAvail=1");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 12.99');
    $("#href_co").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.co&checkAvail=1");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 2.99');
    $("#href_in").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.in&checkAvail=1");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 3.99');
    $("#href_us").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.us&checkAvail=1");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 89.99');
    $("#href_am").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.am&checkAvail=1");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 9.99');
    $("#href_me").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.me&checkAvail=1");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 15.99');
    $("#href_cc").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.cc&checkAvail=1");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy $ 6.99');
    $("#href_uk").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.uk&checkAvail=1");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy $ 149.99');
    $("#href_ag").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.ag&checkAvail=1");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 59.99');
    $("#href_io").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.io&checkAvail=1");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 6.99');
    $("#href_mobi").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.mobi&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
    $("#top_domain_href").attr("href", "http://www.dpbolvw.net/click-7753202-10388358?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.com&checkAvail=1");

}
function iwantmyname_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 19.5');
    $("#href_com").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".com%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 19.5');
    $("#href_net").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".net%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 19.9');
    $("#href_info").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".info%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 23.3');
    $("#href_org").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".org%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 29');
    $("#href_biz").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".biz%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 54');
    $("#href_tv").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".tv%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 29');
    $("#href_co").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".co%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 30');
    $("#href_in").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".in%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 29');
    $("#href_us").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".us%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 109');
    $("#href_am").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".am%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 34');
    $("#href_me").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".me%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 29');
    $("#href_cc").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".cc%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy $ 19');
    $("#href_uk").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".uk%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy $ 179');
    $("#href_ag").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".ag%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 69');
    $("#href_io").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".io%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 2.75');
    $("#href_mobi").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".mobi%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
    $("#top_domain_href").attr("href", "&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".com%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");

}
function media_temple_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 15');
    $("#href_com").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".com");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 15');
    $("#href_net").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".net");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 15');
    $("#href_info").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".info");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 15');
    $("#href_org").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".org");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 15');
    $("#href_biz").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".biz");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy');
    $("#href_tv").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".tv");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 29');
    $("#href_co").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".co");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy');
    $("#href_in").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".in");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy');
    $("#href_us").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".us");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy');
    $("#href_am").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".am");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 25');
    $("#href_me").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".me");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy');
    $("#href_cc").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".cc");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy');
    $("#href_uk").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".uk");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy');
    $("#href_ag").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".ag");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy');
    $("#href_io").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".io");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy');
    $("#href_mobi").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".mobi");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
    $("#top_domain_href").attr("href","https://ac.mediatemple.net/domainsearch/index.mt?domain=?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".com");

}
function name_cheap_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 10.69');
    $("#href_com").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".com");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 12.88');
    $("#href_net").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".net");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 10.47');
    $("#href_info").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".info");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 12.48');
    $("#href_org").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".org");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 11.88');
    $("#href_biz").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".biz");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 24.99');
    $("#href_tv").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".tv");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 8.88');
    $("#href_co").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".co");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 8.69');
    $("#href_in").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".in");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 8.48');
    $("#href_us").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".us");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 18.99');
    $("#href_am").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".am");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 8.99');
    $("#href_me").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".me");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 18.99');
    $("#href_cc").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".cc");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy $ 7.58');
    $("#href_uk").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".uk");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy');
    $("#href_ag").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".ag");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 32.88');
    $("#href_io").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".io");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 8.98');
    $("#href_mobi").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".mobi");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
    $("#top_domain_href").attr("href","http://www.anrdoezrs.net/click-7753202-11674393?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".com");

}
function one_one_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 10.99');
    $("#href_com").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=com&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 8.99');
    $("#href_net").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=net&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 2.99');
    $("#href_info").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=info&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 8.99');
    $("#href_org").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=org&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 16.99');
    $("#href_biz").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=biz&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 29.99');
    $("#href_tv").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=tv&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 6.99');
    $("#href_co").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=co&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 6.99');
    $("#href_in").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=in&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 14.99');
    $("#href_us").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=us&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 129.99');
    $("#href_am").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=am&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 9.99');
    $("#href_me").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=me&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 19.99');
    $("#href_cc").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=cc&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy');
    $("#href_uk").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=uk&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy');
    $("#href_ag").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=ag&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 34.99');
    $("#href_io").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=io&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 14.99');
    $("#href_mobi").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=mobi&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
    $("#top_domain_href").attr("href", "https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=.com&aid=10933941&pid=7756212&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");

}
function register_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 5');
    $("#href_com").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".com&searchPath=Default");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 5');
    $("#href_net").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".net&searchPath=Default");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 5');
    $("#href_info").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".info&searchPath=Default");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 5');
    $("#href_org").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".org&searchPath=Default");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 5');
    $("#href_biz").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".biz&searchPath=Default");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy');
    $("#href_tv").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".tv&searchPath=Default");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy');
    $("#href_co").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".co&searchPath=Default");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy');
    $("#href_in").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".in&searchPath=Default");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 5');
    $("#href_us").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".us&searchPath=Default");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy');
    $("#href_am").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".am&searchPath=Default");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy');
    $("#href_me").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".me&searchPath=Default");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy');
    $("#href_cc").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".cc&searchPath=Default");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy');
    $("#href_uk").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".uk&searchPath=Default");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy');
    $("#href_ag").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".ag&searchPath=Default");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy');
    $("#href_io").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".io&searchPath=Default");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy');
    $("#href_mobi").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".mobi&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
    $("#top_domain_href").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".com&searchPath=Default");

}
function united_domains_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 9.9');
    $("#href_com").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".com");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 14.9');
    $("#href_net").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".net");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 14.9');
    $("#href_info").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".info");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 14.9');
    $("#href_org").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".org");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 14.9');
    $("#href_biz").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".biz");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 29');
    $("#href_tv").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".tv");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 24.9');
    $("#href_co").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".co");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 14.9');
    $("#href_in").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".in");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 9.9');
    $("#href_us").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".us");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 79');
    $("#href_am").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".am");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 14.9');
    $("#href_me").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".me");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 14.9');
    $("#href_cc").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".cc");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy $ 9.9');
    $("#href_uk").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".uk");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy $ 99');
    $("#href_ag").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".ag");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 59');
    $("#href_io").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".io");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 14.9');
    $("#href_mobi").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".mobi");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
    $("#top_domain_href").attr("href","http://www.shareasale.com/r.cfm?B=869629&U=694243&M=65980&urllink=https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".com");

}
function hover_changes(lastID,domain)
{
    var suggesstedDomain;
    var suggesstedExt;
    $("#tld_com,#top_com_domain,#suggest_tld_com").html('Buy $ 12.99');
    $("#href_com").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".com");
    $("#tld_net,#top_net_domain,#suggest_tld_net").html('Buy $ 13.6');
    $("#href_net").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".net");
    $("#tld_info,#top_info_domain,#suggest_tld_info").html('Buy $ 12.4');
    $("#href_info").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".info");
    $("#tld_org,#top_org_domain,#suggest_tld_org").html('Buy $ 13.99');
    $("#href_org").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".org");
    $("#tld_biz,#top_biz_domain,#suggest_tld_biz").html('Buy $ 14.99');
    $("#href_biz").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".biz");
    $("#tld_tv,#top_tv_domain,#suggest_tld_tv").html('Buy $ 31.99');
    $("#href_tv").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".tv");
    $("#tld_co,#top_co_domain,#suggest_tld_co").html('Buy $ 25.99');
    $("#href_co").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".co");
    $("#tld_in,#top_in_domain,#suggest_tld_in").html('Buy $ 14.99');
    $("#href_in").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".in");
    $("#tld_us,#top_us_domain,#suggest_tld_us").html('Buy $ 14.99');
    $("#href_us").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".us");
    $("#tld_am,#top_am_domain,#suggest_tld_am").html('Buy $ 99.99');
    $("#href_am").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".am");
    $("#tld_me,#top_me_domain,#suggest_tld_me").html('Buy $ 14.99');
    $("#href_me").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".me");
    $("#tld_cc,#top_cc_domain,#suggest_tld_cc").html('Buy $ 29.99');
    $("#href_cc").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".cc");
    $("#tld_uk,#top_uk_domain,#suggest_tld_uk").html('Buy $ 9.99');
    $("#href_uk").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".uk");
    $("#tld_ag,#top_ag_domain,#suggest_tld_ag").html('Buy');
    $("#href_ag").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".ag");
    $("#tld_io,#top_io_domain,#suggest_tld_io").html('Buy $ 29.99');
    $("#href_io").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".io");
    $("#tld_mobi,#top_mobi_domain,#suggest_tld_mobi").html('Buy $ 15.99');
    $("#href_mobi").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".mobi");
    suggesstedDomain = document.getElementById("suggesstedDomain0").value;
    suggesstedExt = document.getElementById("suggesstedExt0").value;
    $("#suggest_href_0").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain1").value;
    suggesstedExt = document.getElementById("suggesstedExt1").value;
    $("#suggest_href_1").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain2").value;
    suggesstedExt = document.getElementById("suggesstedExt2").value;
    $("#suggest_href_2").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain3").value;
    suggesstedExt = document.getElementById("suggesstedExt3").value;
    $("#suggest_href_3").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain4").value;
    suggesstedExt = document.getElementById("suggesstedExt4").value;
    $("#suggest_href_4").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain5").value;
    suggesstedExt = document.getElementById("suggesstedExt5").value;
    $("#suggest_href_5").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain6").value;
    suggesstedExt = document.getElementById("suggesstedExt6").value;
    $("#suggest_href_6").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain7").value;
    suggesstedExt = document.getElementById("suggesstedExt7").value;
    $("#suggest_href_7").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain8").value;
    suggesstedExt = document.getElementById("suggesstedExt8").value;
    $("#suggest_href_8").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain9").value;
    suggesstedExt = document.getElementById("suggesstedExt9").value;
    $("#suggest_href_9").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain10").value;
    suggesstedExt = document.getElementById("suggesstedExt10").value;
    $("#suggest_href_10").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain11").value;
    suggesstedExt = document.getElementById("suggesstedExt11").value;
    $("#suggest_href_11").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain12").value;
    suggesstedExt = document.getElementById("suggesstedExt12").value;
    $("#suggest_href_12").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain13").value;
    suggesstedExt = document.getElementById("suggesstedExt13").value;
    $("#suggest_href_13").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain14").value;
    suggesstedExt = document.getElementById("suggesstedExt14").value;
    $("#suggest_href_14").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    suggesstedDomain = document.getElementById("suggesstedDomain15").value;
    suggesstedExt = document.getElementById("suggesstedExt15").value;
    $("#suggest_href_15").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ suggesstedDomain + "."+suggesstedExt);
    $("#top_domain_href").attr("href","https://hover.evyy.net/c/125102/154283/2799?p.domain="+ domain + ".com");
}
function capitalise(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
function change_pages(page,title,e)
{
    if (!e) e = window.event;
    if (!e.ctrlKey) {
        $("#main_page").visible();
        $("#social-button").visible();
        $("#tld_list").invisible();
        $("#top-header-domain").invisible();
        $("#links").invisible();
        $(".footer").removeClass("footer-hidden");
        var status_of_loader = '1';
        if(status_of_loader == 1)
            $('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
        document.getElementById('Search').value= '';
        if(page == 'home')
            document.title = capitalise("Domain Search");
        else
            document.title = capitalise(title);
        $(".page").removeClass("active");
        $("#"+page).addClass('active');
        if(page == 'home')
            window.history.pushState(title, capitalise(page)+ " Domain Search ","http://ddns.imwebstar.com");
        else
            window.history.pushState(title, capitalise(page)+ " Domain Search ","http://ddns.imwebstar.com/page/"+page);
        $.ajax({
            type:"POST",
            url: "http://ddns.imwebstar.com/page.php",
            data: {'page':page},
            dataType: "json",
            success: function(data)
            {
                $("#main_page").html(data['0']);
            }
        });
        return false;
    }
}
function contact_page(page,e)
{
    if (!e) e = window.event;
    if (!e.ctrlKey) {
        $("#main_page").visible();
        $("#social-button").visible();
        $("#tld_list").invisible();
        $("#top-header-domain").invisible();
        $("#links").invisible();
        $(".footer").removeClass("footer-hidden");
        var status_of_loader = '1';
        if(status_of_loader == 1)
            $('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
        document.getElementById('Search').value= '';
        document.title = capitalise('Contact Us');
        window.history.pushState("Contact Us", capitalise(page)+ " Domain Search ","http://ddns.imwebstar.com/"+page);
        $(".page").removeClass("active");
        $("#contact").addClass('active');
        $.ajax({
            type:"POST",
            url: "http://ddns.imwebstar.com/page.php",
            data: {'page':page},
            success: function(data)
            {
                $("#main_page").html(data);
            }
        });
        return false;
    }
}
function mailsend()
{
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var subject = document.getElementById('subject').value;
    var message_box = document.getElementById('message_box').value;
    var captcha_status = '1';
    if(captcha_status == 1)
    {
        var captcha_code = document.getElementById('captcha_code').value;
        var captcha_code2 = document.getElementById('captcha_code2').value;
    }
    else
    {
        var captcha_code = '';
        var captcha_code2 = '';
    }
    var status_of_loader = '1';
    if(status_of_loader == 1)
        $('#load-message').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
    $.ajax({
        type:"POST",
        url: "http://ddns.imwebstar.com/contact.php",
        data: {'name':name,'email':email,'subject':subject,'message_box':message_box,'captcha_code':captcha_code,'captcha_code2':captcha_code2},
        dataType: "json",
        success: function(data)
        {
            $('#load-message').html('');
            $("#replace-class").visible();
            if(data[1] == 'danger')
            {
                $("#replace-class").removeClass("alert alert-default alert-dismissable").addClass("alert alert-danger alert-dismissable");
                $("#replace-class").removeClass("alert alert-success alert-dismissable").addClass("alert alert-danger alert-dismissable");
                $("#alert-message").html(data[0]);
            }
            else if(data[1] == 'success')
            {
                $("#replace-class").removeClass("alert alert-default alert-dismissable").addClass("alert alert-success alert-dismissable");
                $("#replace-class").removeClass("alert alert-danger alert-dismissable").addClass("alert alert-success alert-dismissable");
                $("#alert-message").html(data[0]);
                $('input[type="text"]').val('');
                $('input[type="email"]').val('');
                $('#message_box').val('');
            }
        }
    });
}
function change_language(language,e)
{
    if (!e) e = window.event;
    if (!e.ctrlKey) {
        var currentLocation = window.location;
        $.ajax({
            type: "POST",
            url: "http://ddns.imwebstar.com/change_language.php",
            data: {language: language},
            cache: false,
            success: function(result)
            {
                window.location=currentLocation;
            }
        });
        return false;
    }
}
$(window).load(function(e) {
    $.ajax({
        type:"POST",
        url: "http://ddns.imwebstar.com/includes/count_stats.php",
        data: {'pageViews':'1'},
    });
});