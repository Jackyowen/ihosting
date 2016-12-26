(function($){
    "use strict"; // Start of use strict
     $(document).on('keyup','input.kt_wcajs_input',function(){
    	var keyword = $(this).val();
        var min_char = 3;
        if( typeof(kt_wcajs_fontend.kt_wcajs_min_char) != 'undefined'){
            min_char = kt_wcajs_fontend.kt_wcajs_min_char;
        }
    	if( keyword.length < min_char ){
    		return false;
    	}
		var data = {
            action : 'kt_ajax_search_products',
            keyword:keyword
        }
        var t = $(this);
        var wapper = t.closest('.kt_wcajs');
        t.addClass('loading');
        $(wapper).find('.kt_wcajs_result').html('');
        $.post(kt_wcajs_fontend.ajaxurl, data, function (response) {
        	$(wapper).find('.kt_wcajs_result').show();
           	$(wapper).find('.kt_wcajs_result').html(response);
           	t.removeClass('loading');
        });
    })

     $(document).on('click','.product-item-ajax-serach',function(){
     	var url = $(this).data('url');
     	window.location.replace(url);
     })
 })(jQuery); // End of use strict