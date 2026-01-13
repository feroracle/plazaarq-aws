(function($) {
    'use strict';
	
	var parallaxDropShadowImageSection = {};
	mkd.modules.parallaxDropShadowImageSection = parallaxDropShadowImageSection;

    parallaxDropShadowImageSection.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {
        mkdParallaxShadow();
	}


    function mkdParallaxShadow() {
        var parallaxIntances = $('.mkd-pdsis-has-parallax-scroll .mkd-parallax-dsis-shadow-holder');

        if (parallaxIntances.length && !mkd.htmlEl.hasClass('touch')) {
            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
        }
    }


})(jQuery);