(function($) {
    "use strict";

    var stickyHeader = {};
    mkd.modules.stickyHeader = stickyHeader;
	
	stickyHeader.isStickyVisible = false;
	stickyHeader.stickyAppearAmount = 0;
	stickyHeader.behaviour = '';
	
	stickyHeader.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    if(mkd.windowWidth > 1024) {
		    mkdHeaderBehaviour();
	    }
    }

    /*
     **	Show/Hide sticky header on window scroll
     */
    function mkdHeaderBehaviour() {
        var header = $('.mkd-page-header'),
	        stickyHeader = $('.mkd-sticky-header'),
            fixedHeaderWrapper = $('.mkd-fixed-wrapper'),
	        fixedMenuArea = fixedHeaderWrapper.children('.mkd-menu-area'),
	        fixedMenuAreaHeight = fixedMenuArea.outerHeight(),
            sliderHolder = $('.mkd-slider'),
            revSliderHeight = sliderHolder.length ? sliderHolder.outerHeight() : 0,
	        stickyAppearAmount,
	        headerAppear;
        
        var headerMenuAreaOffset = fixedHeaderWrapper.length ? fixedHeaderWrapper.offset().top - mkdGlobalVars.vars.mkdAddForAdminBar : 0;

        switch(true) {
            // sticky header that will be shown when user scrolls up
            case mkd.body.hasClass('mkd-sticky-header-on-scroll-up'):
                mkd.modules.stickyHeader.behaviour = 'mkd-sticky-header-on-scroll-up';
                var docYScroll1 = $(document).scrollTop();
                stickyAppearAmount = parseInt(mkdGlobalVars.vars.mkdTopBarHeight) + parseInt(mkdGlobalVars.vars.mkdLogoAreaHeight) + parseInt(mkdGlobalVars.vars.mkdMenuAreaHeight) + parseInt(mkdGlobalVars.vars.mkdStickyHeaderHeight);
	            
                headerAppear = function(){
                    var docYScroll2 = $(document).scrollTop();
					
                    if((docYScroll2 > docYScroll1 && docYScroll2 > stickyAppearAmount) || (docYScroll2 < stickyAppearAmount)) {
                        mkd.modules.stickyHeader.isStickyVisible = false;
                        stickyHeader.removeClass('header-appear').find('.mkd-main-menu .second').removeClass('mkd-drop-down-start');
                        mkd.body.removeClass('mkd-sticky-header-appear');
                    } else {
                        mkd.modules.stickyHeader.isStickyVisible = true;
                        stickyHeader.addClass('header-appear');
	                    mkd.body.addClass('mkd-sticky-header-appear');
                    }

                    docYScroll1 = $(document).scrollTop();
                };
                headerAppear();

                $(window).scroll(function() {
                    headerAppear();
                });

                break;

            // sticky header that will be shown when user scrolls both up and down
            case mkd.body.hasClass('mkd-sticky-header-on-scroll-down-up'):
                mkd.modules.stickyHeader.behaviour = 'mkd-sticky-header-on-scroll-down-up';

                if(mkdPerPageVars.vars.mkdStickyScrollAmount !== 0){
                    mkd.modules.stickyHeader.stickyAppearAmount = parseInt(mkdPerPageVars.vars.mkdStickyScrollAmount);
                } else {
                    mkd.modules.stickyHeader.stickyAppearAmount = parseInt(mkdGlobalVars.vars.mkdTopBarHeight) + parseInt(mkdGlobalVars.vars.mkdLogoAreaHeight) + parseInt(mkdGlobalVars.vars.mkdMenuAreaHeight) + parseInt(revSliderHeight);
                }

                headerAppear = function(){
                    if(mkd.scroll < mkd.modules.stickyHeader.stickyAppearAmount) {
                        mkd.modules.stickyHeader.isStickyVisible = false;
                        stickyHeader.removeClass('header-appear').find('.mkd-main-menu .second').removeClass('mkd-drop-down-start');
	                    mkd.body.removeClass('mkd-sticky-header-appear');
                    }else{
                        mkd.modules.stickyHeader.isStickyVisible = true;
                        stickyHeader.addClass('header-appear');
	                    mkd.body.addClass('mkd-sticky-header-appear');
                    }
                };

                headerAppear();

                $(window).scroll(function() {
                    headerAppear();
                });

                break;

            // on scroll down, part of header will be sticky
            case mkd.body.hasClass('mkd-fixed-on-scroll'):
                mkd.modules.stickyHeader.behaviour = 'mkd-fixed-on-scroll';
                var headerFixed = function(){
	
	                if(mkd.scroll <= headerMenuAreaOffset) {
		                fixedHeaderWrapper.removeClass('fixed');
		                mkd.body.removeClass('mkd-fixed-header-appear');
		                fixedMenuArea.css({'height': fixedMenuAreaHeight + 'px'});
		                header.css('margin-bottom', '0');
	                } else {
		                fixedHeaderWrapper.addClass('fixed');
		                mkd.body.addClass('mkd-fixed-header-appear');
		                fixedMenuArea.css({'height': (fixedMenuAreaHeight - 30) + 'px'});
		                header.css('margin-bottom', (fixedMenuAreaHeight - 30) + 'px');
	                }
                };

                headerFixed();

                $(window).scroll(function() {
                    headerFixed();
                });

                break;
        }
    }

})(jQuery);