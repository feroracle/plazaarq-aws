(function($) {
    "use strict";

    var searchFullscreen = {};
    mkd.modules.searchFullscreen = searchFullscreen;

    searchFullscreen.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdSearchFullscreen();
    }
	
	/**
	 * Init Search Types
	 */
	function mkdSearchFullscreen() {
        if ( mkd.body.hasClass( 'mkd-fullscreen-search' ) ) {

            var searchOpener = $('a.mkd-search-opener');

            if (searchOpener.length > 0) {

                var searchHolder = $('.mkd-fullscreen-search-holder'),
                    searchClose = $('.mkd-fullscreen-search-close');

                searchOpener.on('click', function (e) {
                    e.preventDefault();

                    if (searchHolder.hasClass('mkd-animate')) {
                        mkd.body.removeClass('mkd-fullscreen-search-opened mkd-search-fade-out');
                        mkd.body.removeClass('mkd-search-fade-in');
                        searchHolder.removeClass('mkd-animate');

                        setTimeout(function () {
                            searchHolder.find('.mkd-search-field').val('');
                            searchHolder.find('.mkd-search-field').blur();
                        }, 300);

                        mkd.modules.common.mkdEnableScroll();
                    } else {
                        mkd.body.addClass('mkd-fullscreen-search-opened mkd-search-fade-in');
                        mkd.body.removeClass('mkd-search-fade-out');
                        searchHolder.addClass('mkd-animate');

                        setTimeout(function () {
                            searchHolder.find('.mkd-search-field').focus();
                        }, 900);

                        mkd.modules.common.mkdDisableScroll();
                    }

                    searchClose.on('click', function (e) {
                        e.preventDefault();
                        mkd.body.removeClass('mkd-fullscreen-search-opened mkd-search-fade-in');
                        mkd.body.addClass('mkd-search-fade-out');
                        searchHolder.removeClass('mkd-animate');

                        setTimeout(function () {
                            searchHolder.find('.mkd-search-field').val('');
                            searchHolder.find('.mkd-search-field').blur();
                        }, 300);

                        mkd.modules.common.mkdEnableScroll();
                    });

                    //Close on click away
                    $(document).mouseup(function (e) {
                        var container = $(".mkd-form-holder-inner");

                        if (!container.is(e.target) && container.has(e.target).length === 0) {
                            e.preventDefault();
                            mkd.body.removeClass('mkd-fullscreen-search-opened mkd-search-fade-in');
                            mkd.body.addClass('mkd-search-fade-out');
                            searchHolder.removeClass('mkd-animate');

                            setTimeout(function () {
                                searchHolder.find('.mkd-search-field').val('');
                                searchHolder.find('.mkd-search-field').blur();
                            }, 300);

                            mkd.modules.common.mkdEnableScroll();
                        }
                    });

                    //Close on escape
                    $(document).keyup(function (e) {
                        if (e.keyCode == 27) { //KeyCode for ESC button is 27
                            mkd.body.removeClass('mkd-fullscreen-search-opened mkd-search-fade-in');
                            mkd.body.addClass('mkd-search-fade-out');
                            searchHolder.removeClass('mkd-animate');

                            setTimeout(function () {
                                searchHolder.find('.mkd-search-field').val('');
                                searchHolder.find('.mkd-search-field').blur();
                            }, 300);

                            mkd.modules.common.mkdEnableScroll();
                        }
                    });
                });

                //Text input focus change
                var inputSearchField = $('.mkd-fullscreen-search-holder .mkd-search-field'),
                    inputSearchLine = $('.mkd-fullscreen-search-holder .mkd-field-holder .mkd-line');

                inputSearchField.focus(function () {
                    inputSearchLine.css('width', '100%');
                });

                inputSearchField.blur(function () {
                    inputSearchLine.css('width', '0');
                });
            }
        }
	}

})(jQuery);
