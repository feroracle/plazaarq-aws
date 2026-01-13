(function ($) {
	'use strict';
	
	var imageTooltip = {};
	mkd.modules.imageTooltip = imageTooltip;
	
	imageTooltip.mkdImageTooltipInit = mkdImageTooltipInit;
	
	
	imageTooltip.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdImageTooltipInit();
        mkdBorderAnimation();
	}
	
	
	/*
	 * Init Image Tooltip shortcode
	 */
	function mkdImageTooltipInit() {
		var holder = $('.mkd-image-tooltip');
		
		if (holder.length) {
			holder.each(function () {
				$(this).tooltip({
				    animation: true,
				    html: true
				});
			});
		}
	}

    /**
     * Inti portfolio shortcode on appear
     */
    function mkdBorderAnimation() {
        var holder = $('.mkd-image-tooltip .mkd-image-tooltip-border');

        if(holder.length) {
            holder.each(function(){
                var thisHolder = $(this);

                thisHolder.appear(function(){
                    thisHolder.addClass('mkd-tooltip-appeared');
                },{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
            });
        }
    }
	
})(jQuery);