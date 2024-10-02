(function( $ ) {
	'use strict';
	
	$(document).ready(function($) {

        sendActivationData();

        /**
		 * Send activation data
		 * 
		 * @since 1.2.5
		 */
        function sendActivationData() {
            if(gold_addons_activation_obj.activation_data_sent) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: gold_addons_activation_obj.url,
                data: {
                    action: 'goldaddons_send_activation_data',
                    nonce: gold_addons_activation_obj.nonce
                }
            }).done(function(response) {
                //
            }).fail(function(jqXHR, textStatus, errorThrown) {
                //
            }).always(function() {
                //
            });
        }

	});

})( jQuery );