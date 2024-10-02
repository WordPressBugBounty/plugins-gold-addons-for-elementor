(function($) {
    "use strict";

    /**
     * Initialize Portfolio Filter
     *
     * @since 1.0.0
     */
     var GoldAddonsPortfolioFilter = function($scope, $) {
        var Isotope = $scope.find('.ga-portfolio-nav').each(function(){
            $('.ga-portfolio-nav li').on('click', function(){
                var key = $(this).data('key');
                var category = $('.ga-isotope-item[data-category='+key+']');
                $(this).addClass('active').siblings().removeClass('active');
                $(category).fadeIn().siblings().hide();
                if( 'all' == key ) {
                    $('.ga-isotope-item[data-category]').fadeIn(); 
                }
            });
        });
    }
    
    /**
     * Portfolio Widget
     *
     * @since 1.0.0
     */
    var GoldAddonsPortfolio = function($scope, $) {
        var Portfolio = $scope.find('.goldaddons-portfolio').each(function(){
            $('div.ga-portfolio-item-trigger').on('click', function() {
                
                var id          = $(this).data('id'),
                    title       = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-thumb-info-inner').text(),
                    description_heading = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-portfolio-desc-heading').text(),
                    description = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-portfolio-description').text(),
                    hoverWrap   = [
                        '<span class="ga-thumb-info ga-thumb-info-lighten border-radius-0">',
                        '<span class="ga-thumb-info-wrapper border-radius-0"></span>',
                        '</span>'
                    ].join("");
                
                $('.goldaddons-portfolio-single').removeClass('ga-init ga-display-none').addClass('ga-loading');
                
                setTimeout(function(){
                    $('.goldaddons-portfolio-single').removeClass('ga-loading');
                }, 1000);
                
                $('.ga-portfolio-content-top h2').remove();
                
                $( '<h2>' + title + '</h2>' ).appendTo( '.ga-portfolio-item-trigger[data-id='+ id +'] .ga-portfolio-content-top' );
                
                // Multiple Images - Carousel
                if( $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-thumb-info-wrapper span').hasClass('goldaddons-carousel') ) { // Carousel
                    
                    // Unwrap and remove all previously appended images.
                    $('.goldaddons-portfolio-single .ga-left').find('img').each(function(){
                         $(this).unwrap().unwrap().unwrap().remove();
                    });
                    
                    // Clone images from Carousel to single preview mode.
                    $(this).find('.owl-item:not(.cloned) img').each(function(){
                        var src = $(this).attr('src');
                        var alt = $(this).attr('alt');
                        
                        // Show only first child from group images and display them in popover gallery.
                        $('<img src="'+ src +'" alt="'+ alt +'" />')
                            .appendTo('.goldaddons-portfolio-single .ga-left')
                            .wrap('<a href="" data-class="ga-magnific" data-mfp-src="'+ src +'" title="'+ alt +'">'+ hoverWrap +'</a>')
                            .parent('span')
                            .parent('span')
                            .parent('a')
                            .not(':first-child')
                            .hide();
                    });
                    
                } else { // NOT Carousel (Single Image)
                    
                    var src = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-thumb-info-wrapper img').attr("src");
                    var alt = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-thumb-info-wrapper img').attr("alt");
                    
                    // Unwrap and remove all previously appended images.
                    $('.goldaddons-portfolio-single .ga-left').find('img').each(function(){
                         $(this).unwrap().unwrap().unwrap().remove();
                    });
                    
                    // Append image to single preview mode and wrap it for magnific popup preview.
                    $('<img src="' + src + '" alt="'+ alt +'" />')
                        .appendTo('.goldaddons-portfolio-single .ga-left')
                        .wrap('<a href="" data-class="ga-magnific" data-mfp-src="'+ src +'" title="'+ alt +'">'+ hoverWrap +'</a>');
                }
                
                var single_details = $('.ga-portfolio-item-trigger[data-id='+ id +'] .ga-portfolio-single-details').html();
                
                // 1) Remove everything already added into ga-right.
                $('.goldaddons-portfolio-single .ga-right').empty();
                
                // 2) Add clicked portfolio details content.
                $(single_details).appendTo('.goldaddons-portfolio-single .ga-right');
                
                // Scroll to top once all things loaded.
                $('html, body').animate({scrollTop:$('#goldaddons-portfolio-single').offset().top - 50},500);
                
                return false;
            });
        });
    };
    

    $( window ).on( 'elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsPortfolioFilter );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', GoldAddonsPortfolio );
    } );

}(jQuery));
