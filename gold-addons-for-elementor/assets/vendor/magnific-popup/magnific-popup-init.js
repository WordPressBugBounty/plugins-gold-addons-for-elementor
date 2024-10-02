(function($) {
    "use strict";

    /**
     * Initialize Portfolio Magnific Popup
     *
     * @since 1.0.0
     */
     var GoldAddonsMagnific = function($scope, $) {
        $('body').magnificPopup({
            delegate: 'a[data-class="ga-magnific"]',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    };

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsMagnific );
    } );

}(jQuery));
