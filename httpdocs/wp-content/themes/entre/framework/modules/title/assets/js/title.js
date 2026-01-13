(function($) {
    "use strict";

    var title = {};
    mkd.modules.title = title;

    title.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdParallaxTitle();
    }

    /*
     **	Title image with parallax effect
     */
	function mkdParallaxTitle() {
		var parallaxBackground = $('.mkd-title-holder.mkd-bg-parallax');
		
		if (parallaxBackground.length > 0 && mkd.windowWidth > 1024) {
			var parallaxBackgroundWithZoomOut = parallaxBackground.hasClass('mkd-bg-parallax-zoom-out'),
				titleHeight = parseInt(parallaxBackground.data('height')),
				imageWidth = parseInt(parallaxBackground.data('background-width')),
				parallaxRate = titleHeight / 10000 * 7,
				parallaxYPos = -(mkd.scroll * parallaxRate),
				adminBarHeight = mkdGlobalVars.vars.mkdAddForAdminBar;
			
			parallaxBackground.css({'background-position': 'center ' + (parallaxYPos + adminBarHeight) + 'px'});
			
			if (parallaxBackgroundWithZoomOut) {
				parallaxBackground.css({'background-size': imageWidth - mkd.scroll + 'px auto'});
			}
			
			//set position of background on window scroll
			$(window).scroll(function () {
				parallaxYPos = -(mkd.scroll * parallaxRate);
				parallaxBackground.css({'background-position': 'center ' + (parallaxYPos + adminBarHeight) + 'px'});
				
				if (parallaxBackgroundWithZoomOut) {
					parallaxBackground.css({'background-size': imageWidth - mkd.scroll + 'px auto'});
				}
			});
		}
	}

})(jQuery);
