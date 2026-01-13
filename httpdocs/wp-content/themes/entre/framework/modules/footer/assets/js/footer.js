(function ($) {
	"use strict";
	
	var footer = {};
	mkd.modules.footer = footer;
	
	footer.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	 
	function mkdOnWindowLoad() {
		uncoveringFooter();
	}
	
	function uncoveringFooter() {
		var uncoverFooter = $('body:not(.error404) .mkd-footer-uncover');

		if (uncoverFooter.length && !mkd.htmlEl.hasClass('touch')) {

			var footer = $('footer'),
				footerHeight = footer.outerHeight(),
				content = $('.mkd-content');
			
			var uncoveringCalcs = function () {
				content.css('margin-bottom', footerHeight);
				footer.css('height', footerHeight);
			};
			
			//set
			uncoveringCalcs();
			
			$(window).resize(function () {
				//recalc
				footerHeight = footer.outerHeight();
				uncoveringCalcs();
			});
		}
	}
	
})(jQuery);