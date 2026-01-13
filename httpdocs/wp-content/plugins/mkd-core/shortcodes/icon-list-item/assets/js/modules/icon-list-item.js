(function($) {
	'use strict';
	
	var iconListItem = {};
	mkd.modules.iconListItem = iconListItem;
	
	iconListItem.mkdInitIconList = mkdInitIconList;
	
	
	iconListItem.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitIconList().init();
	}
	
	/**
	 * Button object that initializes icon list with animation
	 * @type {Function}
	 */
	var mkdInitIconList = function() {
		var iconList = $('.mkd-animate-list');
		
		/**
		 * Initializes icon list animation
		 * @param list current slider
		 */
		var iconListInit = function(list) {
			setTimeout(function(){
				list.appear(function(){
					list.addClass('mkd-appeared');
				},{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			},30);
		};
		
		return {
			init: function() {
				if(iconList.length) {
					iconList.each(function() {
						iconListInit($(this));
					});
				}
			}
		};
	};
	
})(jQuery);