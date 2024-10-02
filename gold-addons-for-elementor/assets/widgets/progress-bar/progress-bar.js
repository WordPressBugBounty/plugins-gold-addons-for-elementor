(function ($) {
    $(window).on('elementor/frontend/init', function () {

        // Handles the progress bar widget based on its type
        function handleProgressBar($scope, trigger) {
            var $container = $scope;
            if ($container.length === 0) {
                console.error("No .gold-addons-progressbar-container found in $scope.");
                return;
            }

            if (elementorFrontend.isEditMode()) {
                var settings = $container.find('.gold-addons-progressbar-container').data("settings");
            } else {
                var settings = $container.data("settings");
            }

            if (!settings) {
                console.error("Settings are not defined for ", $container);
                return;
            }

            var length = settings.progress_length;
            var speed = settings.speed;
            var type = settings.type;
            var mScroll = settings.mScroll;

            if (type === "line") {
                handleLineProgressBar($container, settings, length, speed, mScroll);
            } else if (type === "circle" || type === "half-circle") {
                handleCircleProgressBar($container, settings, length, speed, type, mScroll);
            } else {
                handleDotProgressBar($container, settings, length, trigger);
            }
        }

        // Handles line type progress bars
        function handleLineProgressBar($container, settings, length, speed, mScroll) {
            var $bar = $container.find(".gold-addons-progressbar-bar");
            if (settings.gradient) {
                $bar.css("background", "linear-gradient(-45deg, " + settings.gradient + ")");
            }

            if (mScroll !== 'yes') {
                $bar.animate({ width: length + "%" }, speed);
            }
        }

        // Handles circle and half-circle type progress bars
        function handleCircleProgressBar($container, settings, length, speed, type, mScroll) {
            length = Math.min(length, 100);
            var degreesFactor = 1.8 * (elementorFrontend.config.is_rtl ? -1 : 1);

            if (mScroll !== 'yes') {
                $container.find(".gold-addons-progressbar-hf-circle-progress").css({
                    transform: "rotate(" + length * degreesFactor + "deg)"
                });
            }

            $container.prop('counter', 0).animate({ counter: length }, {
                duration: speed,
                easing: 'linear',
                step: function (counter) {
                    var rotate = counter * 3.6;
                    if (mScroll !== 'yes') {
                        $container.find(".gold-addons-progressbar-right-label").text(Math.ceil(counter) + "%");
                        $container.find(".gold-addons-progressbar-circle-left").css('transform', "rotate(" + rotate + "deg)");
                    }

                    if (type === "circle" && rotate > 180) {
                        $container.find(".gold-addons-progressbar-circle").css({
                            '-webkit-clip-path': 'inset(0)',
                            'clip-path': 'inset(0)'
                        });
                        $container.find(".gold-addons-progressbar-circle-right").css('visibility', 'visible');
                    }
                }
            });
        }

        // Handles dot type progress bars
        function handleDotProgressBar($container, settings, length, trigger) {
            var $bar = $container.find(".gold-addons-progressbar-bar-wrap");
        
            if ($bar.length === 0) {
                console.error("No .gold-addons-progressbar-bar-wrap found in $container.");
                return;
            }
        
            var width = $container.outerWidth();
            var dotSize = settings.dot || 25;
            var dotSpacing = settings.spacing || 10;
            var numberOfCircles = Math.ceil(width / (dotSize + dotSpacing));
            var circlesToFill = numberOfCircles * (length / 100);
            var numberOfTotalFill = Math.floor(circlesToFill);
            var fillPercent = 100 * (circlesToFill - numberOfTotalFill);
        
            // Debugging output
            //console.log("Container Width:", width);
            //console.log("Dot Size:", dotSize);
            //console.log("Dot Spacing:", dotSpacing);
            //console.log("Number of Circles:", numberOfCircles);
            //console.log("Circles to Fill:", circlesToFill);
            //console.log("Number of Total Fill:", numberOfTotalFill);
            //console.log("Fill Percent:", fillPercent);
        
            // Update attributes
            $bar.attr({
                'data-circles': numberOfCircles,
                'data-total-fill': numberOfTotalFill,
                'data-partial-fill': fillPercent
            });
        
            // Clear existing segments
            $bar.empty();
        
            for (var i = 0; i < numberOfCircles; i++) {
                var className = "progress-segment";
                var innerHTML = (i < numberOfTotalFill) || (i === numberOfTotalFill) ? "<div class='segment-inner'></div>" : '';
                $bar.append("<div class='" + className + "'>" + innerHTML + "</div>");
            }
        
            // Debugging output
            //console.log("Dot segments appended:", $bar.find(".progress-segment").length);
        
            // Delay animation for editor mode
            if (trigger === "frontend") {
                setTimeout(function () {
                    handleDotProgressAnimation($container);
                }, 100); // Adjust delay as needed
            } else {
                handleDotProgressAnimation($container);
            }
        }        

        // Handles the animation for dots in progress bars
        function handleDotProgressAnimation($container) {
            if (elementorFrontend.isEditMode()) {
                var $container = $container.find('.gold-addons-progressbar-container');
            }
            var $bar = $container.find(".gold-addons-progressbar-bar-wrap");
            var data = $bar.data();
            var speed = $container.data("settings").speed;
            var increment = 0;
            function animateDot(inc) {
                var $dot = $bar.find(".progress-segment").eq(inc);
                var dotWidth = (inc === data.totalFill) ? data.partialFill : 100;
        
                //console.log("Animating dot", inc, "with width", dotWidth);
        
                $dot.find(".segment-inner").animate({ width: dotWidth + '%' }, speed / data.circles, function () {
                    increment++;
                    if (increment <= data.totalFill) {
                        animateDot(increment);
                    }
                });
            }
        
            animateDot(increment);
        }

        // Creates and sets up the IntersectionObserver
        function createIntersectionObserver() {
            var options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var $scope = $(entry.target);
                        handleProgressBar($scope);
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            $('.gold-addons-progressbar-container').each(function () {
                observer.observe(this);
            });
        }

        // Initialize handlers for both edit mode and frontend mode
        function initHandlers() {
            if (elementorFrontend.isEditMode()) {
                // In edit mode, use Elementor's "frontend/element_ready" hook for initialization
                elementorFrontend.hooks.addAction("frontend/element_ready/gold-addons-progress-bar.default", function ($scope) {
                    setTimeout(function () {
                        handleProgressBar($scope, "frontend");
                    }, 100); // Short delay to ensure elements are rendered
                });
            } else {
                // In frontend mode, use the Intersection Observer
                createIntersectionObserver();
            }
        }

        // Run initialization
        initHandlers();

    });
})(jQuery);
