<?php
include "../../config/config.php";

include "../../includes/functions.php";

if(!isset($_SESSION)) session_start();
?>

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
	var TldArray = <?php echo json_encode($_SESSION['TldArray']); ?>;
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
					var main_tld="<?php echo $_SESSION['main_tld'];?>";
					$('.live-domain-name').html(domain+"."+main_tld);
				}

				var tlds_args = Array();
				var tld_args_to_check = tlds_args;
				var instant_ajax_url = 'https://instantdomainsearch.com/all/';
				<?php
					$tlds_args = isset( $_SESSION['TldArray'] ) ? (array) $_SESSION['TldArray'] : array();
					if (!empty($tlds_args)) {
						echo "var first_tld='" . $tlds_args[0] . "';";
						echo "instant_ajax_url='https://instantdomainsearch.com/all/' + domain +'?&tldTags=popular';"; // Check first TLD
                        echo "instant_ajax_url='https://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('select * from html where url=\"' + instant_ajax_url + '\"') + '&format=json';"; // Check first TLD
						//echo "var affiliate_url='" . return_affiliate_url('{domain}', '{tld}') . "';";
						echo "var price_args=Array();";
						echo "var whois_url='';";
						$whois_link = str_replace('{domain}', '{domain_full}', $_SESSION['whois_link']);
						if ($_SESSION['whoisStatus'] == 1) {
							echo 'whois_url=\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="'.$whois_link.'">\';';
						}
						else{
							echo 'whois_url=\'<a style="cursor:pointer" data-toggle="tooltip" data-placement="left" title="{domain_full}">\';';
						}
						$who = '';
						if($_SESSION['whoisStatus'] == 1) {
							$who = $_SESSION['WhoIs'];
						}
						else {
							$who = $_SESSION['notavailable'];
						}
						echo "var who='" . $who . "';";

						echo 'var top_result_not_avai_html=\'<div id="change-background" class="com-rslt red-rslt">\' +
								\'<div class="wrapper">\'+
									whois_url+
										\'<div class="com-wrap">\'+
											\'<div class="com-wrap"><span class="live-domain-name">{domain_full}</span> <div id="top_' . $who . '_domain" class="com-btn">' . $who . '</div></div>\'+
										\'</div>\'+
									\'</a>\'+
								\'</div>\'+
							\'</div>\';';
						//echo "console.log(top_result_not_avai_html);";

						echo 'var top_result_avai_html=\'<div id="change-background" class="com-rslt green-rslt">\'+
									\'<div class="wrapper">\'+
										\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}" id="top_domain_href" target="_blank" href="' . return_affiliate_url('{domain}', '{tld}') . '">\'+
											\'<div class="com-wrap">\'+
												\'<div class="com-wrap"><span class="live-domain-name">{domain_full}</span> <div id="top_{tld}_domain" class="com-btn">{price}</div></div>\'+
											\'</div>\'+
										\'</a>\'+
									\'</div>\'+
								\'</div>\';';

						//echo "console.log(affiliate_url);";
						foreach ($tlds_args as $tld) {
							echo 'tlds_args.push(\'' . $tld . '\');';
							//echo 'price_args.push(\'' . $_SESSION[$tld] . '\');';
							echo 'price_args[\'' . $tld . '\']=\'' . convert_currency($_SESSION[$tld]) . '\';';
						}
						//echo "console.log(whois_url);";
						$instant_check_js = "zandcAjaxRequest = $.ajax({
							url : instant_ajax_url,
		                    cache : true,
		                    dataType : 'json',
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
		                        // console.log(response);
		                        var search_results = response['query']['results']['body'];
                                var result_html    = '';
                                if ($.trim(search_results) != '') {
                                    if ($.type(search_results) == 'object') {
                                        search_results = search_results['content'];
                                    }
                                    var results_txt_split = search_results.split(\"\\n\");
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
						});";

						echo $instant_check_js;
					}
				?>

				clearTimeout(myTimer);
				myTimer = window.setTimeout( function() {
					domain = domain.substring(0,60);
					$.ajax({
							type:"POST",
							url: "<?php echo rootpath();?>/suggest.php",
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
							url: "<?php echo rootpath();?>/results.php",
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
					<?php
					$i = 0;
					$countArray = count($_SESSION['TldArray']);
					while($i < $countArray)
					{
					$tld = $_SESSION['TldArray'][$i];
					?>
					/*
					currentRequest = $.ajax({
						type:"POST",
						url: "<?php echo rootpath();?>/results.php",
						cache : true,
						data: {'domain':domain ,'tld':'<?php echo $tld?>'},
						dataType: "json",
						success: function(msg)
						{
							$("#tab_<?php echo str_replace('.', '', $tld);?>").html(msg[0]);
							if(ExtractWidth < ExtWidth)
								$(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
							else
								$(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
						},
						error: function(msg) {

						}
					});
						*/
					<?php
					$i++;
					}
					?>
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

	<?php
		$who = '';
		if($_SESSION['whoisStatus'] == 1) {
			$who = $_SESSION['WhoIs'];
		}
		else {
			$who = $_SESSION['notavailable'];
		}
		echo "var whois_url='';";
		$whois_link = str_replace('{domain}', '{domain_full}', $_SESSION['whois_link']);
		if ($_SESSION['whoisStatus'] == 1) {
			echo 'whois_url=\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="'.$whois_link.'">\';';
		}
		else{
			echo 'whois_url=\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}">\';';
		}
	?>

	var avai_html = '<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" id="href_{tld}" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>">'+
						'<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
							'<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
						'</div>'+
						'<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
							'<div id="tld_{tld}"  class="btn-dmn btn-green" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>">{price}'+
						'</div>'+
						'</div>'+
					'</a>';

	var not_avai_html = whois_url +
						'<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
							'<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
						'</div>'+
						'<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
							'<div id="tld_whois" class="btn-dmn btn-red" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>"><?php echo $who; ?>'+
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
    instant_ajax_url='https://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('select * from html where url="' + instant_ajax_url + '"') + '&format=json';

	<?php
		$who = '';
		if($_SESSION['whoisStatus'] == 1) {
			$who = $_SESSION['WhoIs'];
		}
		else {
			$who = $_SESSION['notavailable'];
		}
		echo "var whois_url='';";
		$whois_link = str_replace('{domain}', '{domain_full}', $_SESSION['whois_link']);
		if ($_SESSION['whoisStatus'] == 1) {
			echo 'whois_url=\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" href="'.$whois_link.'">\';';
		}
		else{
			echo 'whois_url=\'<a data-toggle="tooltip" data-placement="left" title="{domain_full}">\';';
		}
	?>

	var avai_html = '<a data-toggle="tooltip" data-placement="left" title="{domain_full}" target="_blank" id="href_{tld}" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>">'+
						'<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
							'<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
						'</div>'+
						'<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
							'<div id="tld_{tld}"  class="btn-dmn btn-green" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>">{price}'+
						'</div>'+
						'</div>'+
					'</a>';

	var not_avai_html = whois_url +
						'<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">'+
							'<span class="InstantDomainShow">{domain}</span><span class="domain-ext">.{tld}</span>'+
						'</div>'+
						'<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">'+
							'<div id="tld_whois" class="btn-dmn btn-red" href="<?php echo return_affiliate_url('{domain}', '{tld}'); ?>"><?php echo $who; ?>'+
							'</div>'+
						'</div>'+
						'</a>';

    var result_html = '';

    zandcAjaxRequestSingleCheck = $.ajax({
        url : instant_ajax_url,
        //type : 'GET',
        cache : true,
        dataType : 'json',
        success : function (response) {
            //var search_results = response;
            var search_results = response['query']['results']['body'];

            if ($.trim(search_results) != '') {
                if ($.type(search_results) == 'object') {
                    search_results = search_results['content'];
                }
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
		url: "<?php echo rootpath();?>/includes/count_stats.php",
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
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'godaddy_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.<?php echo $ext;?>&checkAvail=1");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.<?php echo $_SESSION['main_tld'];?>&checkAvail=1");

}
function iwantmyname_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'iwant_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".<?php echo $ext;?>%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".<?php echo $_SESSION['main_tld'];?>%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");

}
function media_temple_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'media_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['media_url'];?>?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".<?php echo $ext; ?>");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['media_url'];?>?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+suggesstedDomain+"."+suggesstedExt);
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['media_url'];?>?sid=1673601704.1419598115&url=https://ac.mediatemple.net/domainsearch/index.mt?domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");

}
function name_cheap_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'namecheap_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".<?php echo $ext; ?>");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);
		<?php
		$c++;
	}
	?>
    $("#top_domain_href").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");

}
function one_one_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'one_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=<?php echo $ext; ?>&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=.<?php echo $_SESSION['main_tld'];?>&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");

}
function register_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'register_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['register_url'];?>http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".<?php echo $ext; ?>&searchPath=Default");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['register_url'];?>http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ suggesstedDomain + "."+suggesstedExt+"&searchPath=Default");
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['register_url'];?>http://www.register.com/domain/search/wizard.rcmx?searchDomainName="+ domain + ".<?php echo $_SESSION['main_tld'];?>&searchPath=Default");

}
function united_domains_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'united_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['united_url'];?>https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".<?php echo $ext; ?>");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['united_url'];?>https://www.uniteddomains.com/domain/searchresult/?domain="+ suggesstedDomain + "."+suggesstedExt);
		<?php
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['united_url'];?>https://www.uniteddomains.com/domain/searchresult/?domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");

}
function hover_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'hover_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ domain + ".<?php echo $ext; ?>");
		<?php
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ suggesstedDomain + "."+suggesstedExt);
		<?php
		$c++;
	}
	?>
    $("#top_domain_href").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");
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
		var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
		if(status_of_loader == 1)
			$('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
		document.getElementById('Search').value= '';
		if(page == 'home')
			document.title = capitalise("<?php echo str_replace(array('"'), '', get_title());?>");
		else
			document.title = capitalise(title);
		$(".page").removeClass("active");
		$("#"+page).addClass('active');
		if(page == 'home')
			window.history.pushState(title, capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>");
		else
			window.history.pushState(title, capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>/page/"+page);
		$.ajax({
			type:"POST",
			url: "<?php echo rootpath()?>/page.php",
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
		var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
		if(status_of_loader == 1)
			$('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
		document.getElementById('Search').value= '';
		document.title = capitalise('Contact Us');
		window.history.pushState("Contact Us", capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>/"+page);
		$(".page").removeClass("active");
		$("#contact").addClass('active');
		$.ajax({
			type:"POST",
			url: "<?php echo rootpath()?>/page.php",
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
	var captcha_status = '<?php echo($_SESSION['contact_captcha_status']); ?>';
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
	var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
	if(status_of_loader == 1)
    $('#load-message').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
	$.ajax({
		type:"POST",
		url: "<?php echo rootpath()?>/contact.php",
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
			url: "<?php echo rootpath()?>/change_language.php",
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
		url: "<?php echo rootpath();?>/includes/count_stats.php",
		data: {'pageViews':'1'},
	});
	<?php
	if (!isset($_SESSION['uniqueHit'])) { ?>
		$.ajax({
			type:"POST",
			url: "<?php echo rootpath();?>/includes/count_stats.php",
			data: {'uniqueHits':'1'},
		});
	<?php } ?>
});