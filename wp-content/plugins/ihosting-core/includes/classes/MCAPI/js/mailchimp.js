 (function($){
    "use strict"; // Start of use strict
    $(document).ready(function() {

        $(document).on('click','.submit-newsletter',function(e){

            var thisWrap = $(this).closest('.newsletter-form-wrap');

            if (thisWrap.hasClass('processing')) {
                return false;
            }
            var email           = thisWrap.find('input[name="email"]').val();

            var data = {
                action : 'kutetheme_ovic_submit_mailchimp_via_ajax',
                email : email
            }

            thisWrap.addClass('processing');
            thisWrap.find('.return-message').remove();

            $.post(kt_ajax_fontend.ajaxurl, data, function (response) {
                console.log(response);
                if ($.trim(response['success']) == 'yes') {

                    thisWrap.append('<p class="return-message bg-success">' + response['message'] + '</p>');
                    thisWrap.find('input[name="email"]').val('');
                }
                else {
                    thisWrap.append('<p class="return-message bg-danger">' + response['message'] + '</p>');
                }

                thisWrap.removeClass('processing');

            });
            return false;
        })
    });

})(jQuery); // End of use strict