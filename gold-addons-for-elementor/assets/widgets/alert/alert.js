(function($) {
    "use strict";

    /**
     * Initialize Alerts
     *
     * @since 1.1.2
     */
     var GoldAddonsAlert = function($scope, $) {
        var Alert = $scope.find('.ga-alert').each(function(i){
            $(this).find('.ga-close').on('click', function(){
                $(this).parent('.ga-alert').fadeOut(); 
            });
        });
    };

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsAlert );
    } );

}(jQuery));
