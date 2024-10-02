(function($) {
    "use strict";

     /**
     * Initialize Owl Carousel
     *
     * @since 1.0.0
     */
      var GoldAddonsCarousel = function($scope, $) {
        var ImageCarousel = $scope.find('.goldaddons-carousel:not(.owl-loaded)').each(function(i){
            var defaults = { 'navText': false },
                data = $(this).data('owl-carousel');
            
            // Portfolio Data Setup
            if( ! data ) {
               var data = {
                   items: 1,
                   margin: 20,
                   autoplay: true,
                   autoplayTimeout: 3000,
                   loop: true
               };
            }
            
            $.extend( data, defaults );
          
            $(this).owlCarousel(data);
        });
    };

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsCarousel );
    } );

}(jQuery));
