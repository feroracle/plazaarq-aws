(function($) {
    "use strict";

    var headerExpanding = {};
    mkd.modules.headerExpanding = headerExpanding;

	headerExpanding.mkdOnDocumentReady = mkdOnDocumentReady;
	headerExpanding.mkdOnWindowLoad = mkdOnWindowLoad;
	headerExpanding.mkdOnWindowResize = mkdOnWindowResize;
	headerExpanding.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    $(window).scroll(mkdOnWindowScroll);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdExpandingMenu();
    }

    /* 
        All functions to be called on $(window).load() should be in this function
    */
    function mkdOnWindowLoad() {
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function mkdOnWindowResize() {
    }

    /* 
        All functions to be called on $(window).scroll() should be in this function
    */
    function mkdOnWindowScroll() {
    }

	/**
	 * Init Expanding Menu
	 */
	function mkdExpandingMenu() {

		if ($('a.mkd-expanding-menu-opener').length) {

			var expandingMenuOpener = $( 'a.mkd-expanding-menu-opener');

			// Open expanding menu
			expandingMenuOpener.on('click',function(e){
				e.preventDefault();

				if (!expandingMenuOpener.hasClass('mkd-fm-opened')) {
					expandingMenuOpener.addClass('mkd-fm-opened');
					mkd.body.addClass('mkd-expanding-menu-opened');
					$(document).keyup(function(e){
						if (e.keyCode == 27 ) {
							expandingMenuOpener.removeClass('mkd-fm-opened');
							mkd.body.removeClass('mkd-expanding-menu-opened');
						}
					});
				} else {
					expandingMenuOpener.removeClass('mkd-fm-opened');
					mkd.body.removeClass('mkd-expanding-menu-opened');
				}
			});
		}
	}

})(jQuery);