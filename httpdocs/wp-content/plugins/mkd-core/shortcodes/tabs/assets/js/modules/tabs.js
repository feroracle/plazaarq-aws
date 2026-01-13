(function($) {
	'use strict';
	
	var tabs = {};
	mkd.modules.tabs = tabs;
	
	tabs.mkdInitTabs = mkdInitTabs;
	
	
	tabs.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitTabs();
        mkdInitBorderTab();
	}
	
	/*
	 **	Init tabs shortcode
	 */
	function mkdInitTabs(){
		var tabs = $('.mkd-tabs');
		
		if(tabs.length){
			tabs.each(function(){
				var thisTabs = $(this);
				
				thisTabs.children('.mkd-tab-container').each(function(index){
					index = index + 1;
					var that = $(this),
						link = that.attr('id'),
						navItem = that.parent().find('.mkd-tabs-nav li:nth-child('+index+') a'),
						navLink = navItem.attr('href');
					
					link = '#'+link;

					if(link.indexOf(navLink) > -1) {
						navItem.attr('href',link);
					}
				});
				
				thisTabs.tabs();

                $('.mkd-tabs a.mkd-external-link').off('click');
			});
		}
	}

    /**
     * Inti process shortcode on appear
     */
    function mkdInitBorderTab() {
        var holder = $('.mkd-tabs.mkd-tabs-simple .mkd-tabs-nav li a');

        if(holder.length) {
            holder.each(function(){
                var thisHolder = $(this);

                thisHolder.appear(function(){
                    thisHolder.addClass('mkd-border-appeared');
                },{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
            });
        }
    }

})(jQuery);