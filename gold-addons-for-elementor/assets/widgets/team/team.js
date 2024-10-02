(function($) {
    "use strict";

    /**
     * Initialize Team Widget
     *
     * @since 1.0.1
     */
     var GoldAddonsTeam = function($scope, $) {
        var Button = $scope.find('.ga-social-button');
        Button.tooltip();
    };

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsTeam );
    } );

}(jQuery));
