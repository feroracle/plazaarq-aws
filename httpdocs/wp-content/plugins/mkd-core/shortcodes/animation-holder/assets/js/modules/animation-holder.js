(function($) {
	'use strict';
	
	var animationHolder = {};
	mkd.modules.animationHolder = animationHolder;
	
	animationHolder.mkdInitAnimationHolder = mkdInitAnimationHolder;
	
	
	animationHolder.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitAnimationHolder();
	}
	
	/*
	 *	Init animation holder shortcode
	 */
	function mkdInitAnimationHolder(){
		var elements = $('.mkd-grow-in, .mkd-fade-in-down, .mkd-element-from-fade, .mkd-element-from-left, .mkd-element-from-right, .mkd-element-from-top, .mkd-element-from-bottom, .mkd-flip-in, .mkd-x-rotate, .mkd-z-rotate, .mkd-y-translate, .mkd-fade-in, .mkd-fade-in-left-x-rotate'),
			animationClass,
			animationData,
			animationDelay;
		
		if(elements.length){
			elements.each(function(){
				var thisElement = $(this);
				
				thisElement.appear(function() {
					animationData = thisElement.data('animation');
					animationDelay = parseInt(thisElement.data('animation-delay'));
					
					if(typeof animationData !== 'undefined' && animationData !== '') {
						animationClass = animationData;
						var newClass = animationClass+'-on';
						
						setTimeout(function(){
							thisElement.addClass(newClass);
						},animationDelay);
					}
				},{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			});
		}
	}
	
})(jQuery);