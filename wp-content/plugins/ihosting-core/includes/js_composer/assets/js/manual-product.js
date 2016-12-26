jQuery(document).ready(function($) {
    /*
    var data = {
        'action': 'load_list_product',
        'whatever': 1234
    };

    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajaxurl, data, function(response) {
        alert('Got this from the server: ' + response);
    });
    */
});
!function($) {
    $( ".manual-products" ).sortable();
    /*var $info = $("#dialog-product-list");
    $info.dialog({
        'dialogClass'   : 'wp-dialog',
        'modal'         : true,
        'autoOpen'      : false,
        'closeOnEscape' : true,
        'buttons'       : {
            "Close": function() {
                $(this).dialog('close');
            }
        }
    });*/
    var data = {
        'action': 'load_list_product',
        'whatever': 1234
    };
    $(".kt-open-dialog-product-list").click(function(event) {
        var edata = $(this).data();//, current = $("#layout-"+data.param_name+" .kt-layout-value").val();
        event.preventDefault();
        $("#kt-dialog-product-list-"+edata.param_name).dialog({
            title:  edata.title,
            dialogClass:'no-titlebar',
            width: 800,
            height: 300,
            modal:true,
        });
        /*jQuery.post(ajaxurl, data, function(response) {
            $(".kt-dialog-content").html(response);

            $(".dialog-product-list").dialog({
                title:  $(this).data('title'),
                dialogClass:'no-close',
                width: 600,
                height: 400,
                modal:true,
            });
        });*/
        //$info.dialog('open');

    });
    $(".kt-dialog-product-list-close").click(function(e){
        event.preventDefault();
        var edata = $(this).data();
        $("#kt-dialog-product-list-"+edata.param_name).dialog('destroy');
    });
    $(".filter-submit").click(function(e){
        loadProductList(1);
    });

    $(document).on('click', '.delete-manual', function(e){
        e.preventDefault();
        $(this).closest('li').remove();
    })
    function loadProductList(page){
        var data = {
            'action': 'load_list_product',
            'whatever': 1234,
            'page':page,
            'category':$("#filter-category :selected").val(),
            'keyword':$("#filter-keyword").val(),
        };
        $.post(ajaxurl, data, function(response) {
            $("#kt-list-products").html(response.products);
            $("#kt-pagination").html(response.pagination);
        });
    }
}(window.jQuery);
