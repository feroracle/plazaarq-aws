(function($) {
	'use strict';
	
	$(document).ready(function(){
		mkdParallaxPtfText();
	});
	
	/**
	 * Parallax Pft text
	 * @type {Function}
	 */

	function mkdParallaxPtfText() {
	    var parallaxLists = $('.mkd-prod-cats-holder.mkd-parallax-items');

	    if (parallaxLists.length && !mkd.htmlEl.hasClass('touch')) {
	        parallaxLists.each(function(){
	            var parallaxList = $(this),
	                categories = parallaxList.find('.mkd-prod-cat'),
	                yOffset = parallaxList.attr('data-y-axis-translation');

	            categories.each(function(){
	                var category = $(this),
	                    categoryHeight = category.outerHeight(),
	                    categoryInner = category.find('.mkd-prod-cat-inner'),
	                    categoryInnerHeight = categoryInner.height(),
	                    delta = Math.floor(Math.random()*(yOffset-yOffset/2+1)+yOffset/2);

	                var dataParallax = '{"y":'+delta+', "smoothness":20}';
	                categoryInner.attr('data-parallax', dataParallax);
	            });
	        });

	        setTimeout(function(){
	            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
	        }, 100); //wait for calcs
	    }
	}
	
})(jQuery);