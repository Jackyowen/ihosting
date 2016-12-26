function whmcsBridgeSync(type,init) {
	jQuery(document).ready(function($) {
		if (init == 1) jQuery('#whmcsbridgesync').html('Starting ...');
		var data = {
			'action': 'whmcs_bridge_sso_sync',
			'init': init,
			'type': type
		};
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#whmcsbridgesync').html('Processed '+response);

			if (!isNaN(response) && (response > 0))
                whmcsBridgeSync(type,0);
			else if (response == 0)
                jQuery('#whmcsbridgesync').html('Synchronisation completed!');
            else
                jQuery('#whmcsbridgesync').html('A problem occurred during sync: ' + response);
		});
	});
}

function whmcsBridgeCheck() {
    jQuery(document).ready(function($) {
        var data = {
            'action': 'whmcs_bridge_sso_check'
        };
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#whmcs-check').html(response);
        });
    });
}