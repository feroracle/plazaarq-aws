(function($) {
    "use strict";

    var sidearea = {};
    mkd.modules.sidearea = sidearea;

    sidearea.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdSideArea();
	    mkdSideAreaScroll();
    }
	
	/**
	 * Show/hide side area
	 */
	function mkdSideArea() {
		var wrapper = $('.mkd-wrapper'),
			sideMenuButtonOpen = $('a.mkd-side-menu-button-opener'),
			cssClass = 'mkd-right-side-menu-opened';
		
		wrapper.prepend('<div class="mkd-cover"/>');
		
		$('a.mkd-side-menu-button-opener, a.mkd-close-side-menu').on('click',  function(e) {
			e.preventDefault();
			
			if(!sideMenuButtonOpen.hasClass('opened')) {
				sideMenuButtonOpen.addClass('opened');
				mkd.body.addClass(cssClass);
				
				$('.mkd-wrapper .mkd-cover').on('click', function() {
					mkd.body.removeClass('mkd-right-side-menu-opened');
					sideMenuButtonOpen.removeClass('opened');
				});
				
				var currentScroll = $(window).scrollTop();
				$(window).scroll(function() {
					if(Math.abs(mkd.scroll - currentScroll) > 400){
						mkd.body.removeClass(cssClass);
						sideMenuButtonOpen.removeClass('opened');
					}
				});
			} else {
				sideMenuButtonOpen.removeClass('opened');
				mkd.body.removeClass(cssClass);
			}
		});
	}
	
	/*
	 **  Smooth scroll functionality for Side Area
	 */
	function mkdSideAreaScroll(){
		var sideMenu = $('.mkd-side-menu');
		
		if(sideMenu.length){
            sideMenu.perfectScrollbar({
                wheelSpeed: 0.6,
                suppressScrollX: true
            });
		}
	}

})(jQuery);
