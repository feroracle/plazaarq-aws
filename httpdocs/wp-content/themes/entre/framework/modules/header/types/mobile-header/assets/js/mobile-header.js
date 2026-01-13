(function ($) {
	"use strict";
	
	var mobileHeader = {};
	mkd.modules.mobileHeader = mobileHeader;
	
	mobileHeader.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
		All functions to be called on $(document).ready() should be in this function
	*/
	function mkdOnDocumentReady() {
		mkdInitMobileNavigation();
		mkdMobileHeaderBehavior();
	}
	
	function mkdInitMobileNavigation() {
        var mobileHeader = $('.mkd-mobile-header'),
		    navigationOpener = $('.mkd-mobile-header .mkd-mobile-menu-opener'),
			navigationHolder = $('.mkd-mobile-header .mkd-mobile-nav'),
			dropdownOpener = $('.mkd-mobile-nav .mobile_arrow, .mkd-mobile-nav h6, .mkd-mobile-nav a.mkd-mobile-no-link'),
            mobileHeaderHeight = mobileHeader.length ? mobileHeader.height() : 0;
		
		//whole mobile menu opening / closing
		if (navigationOpener.length && navigationHolder.length) {
			navigationOpener.on('tap click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				
				if (navigationHolder.is(':visible')) {
					navigationHolder.slideUp(450, 'easeInOutQuint');
					navigationOpener.removeClass('mkd-mobile-menu-opened');
				} else {
					navigationHolder.slideDown(450, 'easeInOutQuint');
					navigationOpener.addClass('mkd-mobile-menu-opened');
				}
			});
		}

        //init scrollable menu
        var scrollHeight = navigationHolder.outerHeight() + mobileHeaderHeight > mkd.windowHeight - 100 ?  mkd.windowHeight - mobileHeaderHeight - 100 : navigationHolder.height();
        navigationHolder.height(scrollHeight);
        navigationHolder.perfectScrollbar({
            wheelSpeed: 0.6,
            suppressScrollX: true
        });

        //set height of popup holder on resize
        $(window).resize(function() {
            var scrollHeight = navigationHolder.outerHeight() + mobileHeaderHeight > mkd.windowHeight - 100 ?  mkd.windowHeight - mobileHeaderHeight - 100 : navigationHolder.height();
            navigationHolder.height(scrollHeight);
        });
		
        //dropdown opening / closing
        if (dropdownOpener.length) {
            dropdownOpener.each(function () {
                var thisItem = $(this);

                thisItem.on('tap click', function (e) {
                    var thisItemParent = thisItem.parent('li'),
                        thisItemParentSiblingsWithDrop = thisItemParent.siblings('.menu-item-has-children');

                    if (thisItemParent.hasClass('has_sub')) {
                        var submenu = thisItemParent.find('> ul.sub_menu');

                        if (submenu.is(':visible')) {
                            submenu.slideUp(450, 'easeInOutQuint');
                            thisItemParent.removeClass('mkd-opened');
                        } else {
                            thisItemParent.addClass('mkd-opened');

                            if (thisItemParentSiblingsWithDrop.length === 0) {
                                thisItemParent.find('.sub_menu').slideUp(400, 'easeInOutQuint', function () {
                                    submenu.slideDown(400, 'easeInOutQuint');
                                });
                            } else {
                                thisItemParent.siblings().removeClass('mkd-opened').find('.sub_menu').slideUp(400, 'easeInOutQuint', function () {
                                    submenu.slideDown(400, 'easeInOutQuint');
                                });
                            }
                        }
                    }
                });
            });
        }
		
		$('.mkd-mobile-nav a, .mkd-mobile-logo-wrapper a').on('click tap', function (e) {
			if ($(this).attr('href') !== 'http://#' && $(this).attr('href') !== '#') {
				navigationHolder.slideUp(450, 'easeInOutQuint');
				navigationOpener.removeClass("mkd-mobile-menu-opened");
			}
		});
	}
	
	function mkdMobileHeaderBehavior() {
		var mobileHeader = $('.mkd-mobile-header'),
			mobileMenuOpener = mobileHeader.find('.mkd-mobile-menu-opener'),
			mobileHeaderHeight = mobileHeader.length ? mobileHeader.outerHeight() : 0;
		
		if (mkd.body.hasClass('mkd-content-is-behind-header') && mobileHeaderHeight > 0 && mkd.windowWidth <= 1024) {
			$('.mkd-content').css('marginTop', -mobileHeaderHeight);
		}
		
		if (mkd.body.hasClass('mkd-sticky-up-mobile-header')) {
			var stickyAppearAmount,
				adminBar = $('#wpadminbar');
			
			var docYScroll1 = $(document).scrollTop();
			stickyAppearAmount = mobileHeaderHeight + mkdGlobalVars.vars.mkdAddForAdminBar;
			
			$(window).scroll(function () {
				var docYScroll2 = $(document).scrollTop();
				
				if (docYScroll2 > stickyAppearAmount) {
					mobileHeader.addClass('mkd-animate-mobile-header');
				} else {
					mobileHeader.removeClass('mkd-animate-mobile-header');
				}
				
				if ((docYScroll2 > docYScroll1 && docYScroll2 > stickyAppearAmount && !mobileMenuOpener.hasClass('mkd-mobile-menu-opened')) || (docYScroll2 < stickyAppearAmount)) {
					mobileHeader.removeClass('mobile-header-appear');
					mobileHeader.css('margin-bottom', 0);
					
					if (adminBar.length) {
						mobileHeader.find('.mkd-mobile-header-inner').css('top', 0);
					}
				} else {
					mobileHeader.addClass('mobile-header-appear');
					mobileHeader.css('margin-bottom', stickyAppearAmount);
				}
				
				docYScroll1 = $(document).scrollTop();
			});
		}
	}
	
})(jQuery);