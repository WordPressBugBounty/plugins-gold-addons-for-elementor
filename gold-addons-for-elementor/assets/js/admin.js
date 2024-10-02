(function($) {
    "use strict"
    
    $( document ).ready( function() {
        var $activateGoldAddons = $('#goldaddons-register');

        
        $activateGoldAddons.on('click', function(e){
            var $btnLoader = $(this);
            var $license_key_input = $(document).find('input[name="goldaddons[key]"]');
            var $license_key = $license_key_input.val().replace(/\s/g, '');
            var data = {
                action: 'gold_addons_activate',
                license_key: $license_key
            };

            // Check if input contains invalid characters
            if (!/^[a-zA-Z0-9]+$/.test($license_key)) {
                $license_key_input.addClass('border-warning');
                $('.ga-card-body').find('.alert-warning').fadeOut();
                $('.ga-nav').after('<div class="alert alert-warning"><i class="fe-icon-info"></i> Only numbers an alphabet characters allowed!</div>');
                return; // Stop further execution
            } else {
                $license_key_input.removeClass('border-warning'); // Remove the class if it was previously added
            }

            $btnLoader.attr('disabled', 'disabled');
            $btnLoader.find('i').removeClass('hidden');

            $('.ga-card-body').find('.alert-warning').fadeOut();

            if ($license_key.length) {
                $('.ga-card-body').find('.alert-notice').fadeOut();
            }

            $.post( _GoldAddons.ajax_url, data, function( response ) {
                console.log(response);

                if (response && response.data && response.data.error_message) {
                    $('.ga-nav').after('<div class="alert alert-warning"><i class="fe-icon-info"></i> '+ response.data.error_message +'</div>');
                }

                if (response && response.success && response.data && response.data.licenseKey && response.data.activationData && response.data.activationData.token) {
                    const expiresAt = new Date(response.data.expiresAt);
                    const remainingTime = expiresAt - new Date();
                    const remainingDays = Math.ceil(remainingTime / (1000 * 60 * 60 * 24));
                    const message = `Your license will expire in ${remainingDays} day(s).`;

                    $('.ga-card-body').find('.alert-success').fadeOut();
                    $('.ga-nav').after('<div class="alert alert-success"><i class="fe-icon-info"></i> License is activated! ' + message);
                }

                $btnLoader.removeAttr('disabled');
                $btnLoader.find('i').addClass('hidden');
            });
        });
    } );
    
}(jQuery));
