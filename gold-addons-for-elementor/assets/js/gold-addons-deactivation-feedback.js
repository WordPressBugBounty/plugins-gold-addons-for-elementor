(function( $ ) {
	'use strict';
	
	$(document).ready(function($) {

        $(document).on("click", "#deactivate-gold-addons-for-elementor", function(event) {
            if(!gold_addons_deactivation_obj.deactivation_data_sent) {
                event.preventDefault();
                $('body').addClass("disable-body-scroll");
                $("#gold-addons-deactivation-feedback-modal-container").show();
            }
        });

        $(document).on("click", "#gold-addons-deactivation-feedback-modal-x img", function() {
            $('body').removeClass("disable-body-scroll");
            $("#gold-addons-deactivation-feedback-modal-container").hide();
        });

        $(document).on("click", "#send-gold-addons-deactivation-feedback-btn", function() {

            if(!gold_addons_deactivation_obj.deactivation_data_sent) {
                const theButton = $(this);

                $("#gold-addons-spinner").show();
                theButton.addClass('btn-disabled').attr("disabled", "disabled");

                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: gold_addons_deactivation_obj.url,
                        data: {
                            action: 'goldaddons_send_deactivation_data',
                            nonce: gold_addons_deactivation_obj.nonce,
                            reason: $("#gold-addons-deactivation-feedback-reason").val(),
                            message: $("#gold-addons-deactivation-feedback-message").val()
                        }
                    }).done(function(response) {
                        //
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //
                    }).always(function() {
                        $("#gold-addons-spinner").hide();
                        theButton.removeClass('btn-disabled').removeAttr('disabled');
                        $('body').removeClass("disable-body-scroll");
                        $("#gold-addons-deactivation-feedback-modal-container").hide();
                        location.reload();
                    });
                }, 1000);
            }

        });

	});

})( jQuery );