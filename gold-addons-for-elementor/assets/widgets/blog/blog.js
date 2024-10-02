(function($) {
    "use strict";

     /**
     * Initialize Infinite Scroll
     *
     * @since 1.0.3
     */
      var GoldAddonsBlog = function($scope, $) {
        var InfiniteScroll = $scope.find('.gold-addons-blog').each(function(i){
            var defaults = {
                path: '.ga-infinite a.next',
                append: '.ga-blog-entry',
                status: '.ga-posts-load-status'
            }, data = {};
            
            // If infinite scroll via button click enabled.
            if( $('#ga-infinite-load-more-btn').hasClass('ga-infinite-load-more-btn') ) {
                var data = { 
                    button: '.ga-infinite-load-more-btn', // Load posts on button click.
                    scrollThreshold: false // Disable loading on scroll.
                }; 
            }
            
            $.extend( data, defaults );
            
            if( $('#goldaddons-pagination').hasClass('ga-infinite') ) {
                if ( $('#ga-blog-posts').hasClass( 'ga-blog-layout-grid' ) ) {
                    $('.ga-blog-layout-grid').infiniteScroll(data);
                } else {
                    $('.ga-infinite-wrapper').infiniteScroll(data);
                }
            }
        });
    };

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsBlog );
    } );

}(jQuery));
