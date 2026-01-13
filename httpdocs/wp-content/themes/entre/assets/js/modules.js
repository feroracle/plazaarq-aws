(function($) {
    "use strict";

    window.mkd = {};
    mkd.modules = {};

    mkd.scroll = 0;
    mkd.window = $(window);
    mkd.document = $(document);
    mkd.windowWidth = $(window).width();
    mkd.windowHeight = $(window).height();
    mkd.body = $('body');
    mkd.html = $('html, body');
    mkd.htmlEl = $('html');
    mkd.menuDropdownHeightSet = false;
    mkd.defaultHeaderStyle = '';
    mkd.minVideoWidth = 1500;
    mkd.videoWidthOriginal = 1280;
    mkd.videoHeightOriginal = 720;
    mkd.videoRatio = 1.61;

    mkd.mkdOnDocumentReady = mkdOnDocumentReady;
    mkd.mkdOnWindowLoad = mkdOnWindowLoad;
    mkd.mkdOnWindowResize = mkdOnWindowResize;
    mkd.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    $(window).scroll(mkdOnWindowScroll);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkd.scroll = $(window).scrollTop();

        //set global variable for header style which we will use in various functions
        if(mkd.body.hasClass('mkd-dark-header')){ mkd.defaultHeaderStyle = 'mkd-dark-header';}
        if(mkd.body.hasClass('mkd-light-header')){ mkd.defaultHeaderStyle = 'mkd-light-header';}
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
        mkd.windowWidth = $(window).width();
        mkd.windowHeight = $(window).height();
    }

    /* 
        All functions to be called on $(window).scroll() should be in this function
    */
    function mkdOnWindowScroll() {
        mkd.scroll = $(window).scrollTop();
    }

    //set boxed layout width variable for various calculations

    switch(true){
        case mkd.body.hasClass('mkd-grid-1300'):
            mkd.boxedLayoutWidth = 1350;
            break;
        case mkd.body.hasClass('mkd-grid-1200'):
            mkd.boxedLayoutWidth = 1250;
            break;
        case mkd.body.hasClass('mkd-grid-1000'):
            mkd.boxedLayoutWidth = 1050;
            break;
        case mkd.body.hasClass('mkd-grid-800'):
            mkd.boxedLayoutWidth = 850;
            break;
        default :
            mkd.boxedLayoutWidth = 1150;
            break;
    }

})(jQuery);
(function($) {
	"use strict";

    var common = {};
    mkd.modules.common = common;

    common.mkdFluidVideo = mkdFluidVideo;
    common.mkdEnableScroll = mkdEnableScroll;
    common.mkdDisableScroll = mkdDisableScroll;
    common.mkdOwlSlider = mkdOwlSlider;
    common.mkdInitParallax = mkdInitParallax;
    common.mkdInitSelfHostedVideoPlayer = mkdInitSelfHostedVideoPlayer;
    common.mkdSelfHostedVideoSize = mkdSelfHostedVideoSize;
    common.mkdPrettyPhoto = mkdPrettyPhoto;
	common.mkdStickySidebarWidget = mkdStickySidebarWidget;
    common.getLoadMoreData = getLoadMoreData;
    common.setLoadMoreAjaxData = setLoadMoreAjaxData;

    common.mkdOnDocumentReady = mkdOnDocumentReady;
    common.mkdOnWindowLoad = mkdOnWindowLoad;
    common.mkdOnWindowResize = mkdOnWindowResize;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdIconWithHover().init();
	    mkdDisableSmoothScrollForMac();
	    mkdInitAnchor().init();
	    mkdInitBackToTop();
	    mkdBackButtonShowHide();
	    mkdInitSelfHostedVideoPlayer();
	    mkdSelfHostedVideoSize();
	    mkdFluidVideo();
	    mkdOwlSlider();
	    mkdPreloadBackgrounds();
	    mkdPrettyPhoto();
	    mkdSearchPostTypeWidget();
        mkdSmoothTransition();
    }

    /* 
        All functions to be called on $(window).load() should be in this function
    */
    function mkdOnWindowLoad() {
	    mkdInitParallax();
	    mkdStickySidebarWidget().init();
        mkdParallaxElements();
        mkdUncoverSliderSection();
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function mkdOnWindowResize() {
        mkdSelfHostedVideoSize();
    }
	
	/*
	 ** Disable smooth scroll for mac if smooth scroll is enabled
	 */
	function mkdDisableSmoothScrollForMac() {
		var os = navigator.appVersion.toLowerCase();
		
		if (os.indexOf('mac') > -1 && mkd.body.hasClass('mkd-smooth-scroll')) {
			mkd.body.removeClass('mkd-smooth-scroll');
		}
	}
	
	function mkdDisableScroll() {
		if (window.addEventListener) {
			window.addEventListener('wheel', mkdWheel, {passive: false} );
		}
		
		//window.onmousewheel = document.onmousewheel = mkdWheel;
		document.onkeydown = mkdKeydown;
	}
	
	function mkdEnableScroll() {
		if (window.removeEventListener) {
			window.removeEventListener('wheel', mkdWheel, {passive: false} );
		}
		
		window.onmousewheel = document.onmousewheel = document.onkeydown = null;
	}
	
	function mkdWheel(e) {
		mkdPreventDefaultValue(e);
	}
	
	function mkdKeydown(e) {
		var keys = [37, 38, 39, 40];
		
		for (var i = keys.length; i--;) {
			if (e.keyCode === keys[i]) {
				mkdPreventDefaultValue(e);
				return;
			}
		}
	}
	
	function mkdPreventDefaultValue(e) {
		e = e || window.event;
		if (e.preventDefault) {
			e.preventDefault();
		}
		e.returnValue = false;
	}
	
	/*
	 **	Anchor functionality
	 */
	var mkdInitAnchor = function() {
		/**
		 * Set active state on clicked anchor
		 * @param anchor, clicked anchor
		 */
		var setActiveState = function(anchor){
			var headers = $('.mkd-main-menu, .mkd-mobile-nav, .mkd-fullscreen-menu');
			
			headers.each(function(){
				var currentHeader = $(this);
				
				if (anchor.parents(currentHeader).length) {
					currentHeader.find('.mkd-active-item').removeClass('mkd-active-item');
					anchor.parent().addClass('mkd-active-item');
					
					currentHeader.find('a').removeClass('current');
					anchor.addClass('current');
				}
			});
		};
		
		/**
		 * Check anchor active state on scroll
		 */
		var checkActiveStateOnScroll = function(){
			var anchorData = $('[data-mkd-anchor]'),
				anchorElement,
				siteURL = window.location.href.split('#')[0];
			
			if (siteURL.substr(-1) !== '/') {
				siteURL += '/';
			}
			
			anchorData.waypoint( function(direction) {
				if(direction === 'down') {
					if ($(this.element).length > 0) {
						anchorElement = $(this.element).data("mkd-anchor");
					} else {
						anchorElement = $(this).data("mkd-anchor");
					}
				
					setActiveState($("a[href='"+siteURL+"#"+anchorElement+"']"));
				}
			}, { offset: '50%' });
			
			anchorData.waypoint( function(direction) {
				if(direction === 'up') {
					if ($(this.element).length > 0) {
						anchorElement = $(this.element).data("mkd-anchor");
					} else {
						anchorElement = $(this).data("mkd-anchor");
					}
					
					setActiveState($("a[href='"+siteURL+"#"+anchorElement+"']"));
				}
			}, { offset: function(){
				return -($(this.element).outerHeight() - 150);
			} });
		};
		
		/**
		 * Check anchor active state on load
		 */
		var checkActiveStateOnLoad = function(){
			var hash = window.location.hash.split('#')[1];
			
			if(hash !== "" && $('[data-mkd-anchor="'+hash+'"]').length > 0){
				anchorClickOnLoad(hash);
			}
		};
		
		/**
		 * Handle anchor on load
		 */
		var anchorClickOnLoad = function ($this) {
			var scrollAmount,
				anchor = $('.mkd-main-menu a, .mkd-mobile-nav a, .mkd-fullscreen-menu a'),
				hash = $this,
				anchorData = hash !== '' ? $('[data-mkd-anchor="' + hash + '"]') : '';
			
			if (hash !== '' && anchorData.length > 0) {
				var anchoredElementOffset = anchorData.offset().top;
				scrollAmount = anchoredElementOffset - headerHeightToSubtract(anchoredElementOffset) - mkdGlobalVars.vars.mkdAddForAdminBar;
				
				if(anchor.length) {
					anchor.each(function(){
						var thisAnchor = $(this);
						
						if(thisAnchor.attr('href').indexOf(hash) > -1) {
							setActiveState(thisAnchor);
						}
					});
				}
				
				mkd.html.stop().animate({
					scrollTop: Math.round(scrollAmount)
				}, 1000, function () {
					//change hash tag in url
					if (history.pushState) {
						history.pushState(null, '', '#' + hash);
					}
				});
				
				return false;
			}
		};
		
		/**
		 * Calculate header height to be substract from scroll amount
		 * @param anchoredElementOffset, anchorded element offset
		 */
		var headerHeightToSubtract = function (anchoredElementOffset) {
			
			if (mkd.modules.stickyHeader.behaviour === 'mkd-sticky-header-on-scroll-down-up') {
				mkd.modules.stickyHeader.isStickyVisible = (anchoredElementOffset > mkd.modules.header.stickyAppearAmount);
			}
			
			if (mkd.modules.stickyHeader.behaviour === 'mkd-sticky-header-on-scroll-up') {
				if ((anchoredElementOffset > mkd.scroll)) {
					mkd.modules.stickyHeader.isStickyVisible = false;
				}
			}
			
			var headerHeight = mkd.modules.stickyHeader.isStickyVisible ? mkdGlobalVars.vars.mkdStickyHeaderTransparencyHeight : mkdPerPageVars.vars.mkdHeaderTransparencyHeight;
			
			if (mkd.windowWidth < 1025) {
				headerHeight = 0;
			}
			
			return headerHeight;
		};
		
		/**
		 * Handle anchor click
		 */
		var anchorClick = function () {
			mkd.document.on("click", ".mkd-main-menu a, .mkd-fullscreen-menu a, .mkd-btn, .mkd-anchor, .mkd-mobile-nav a", function () {
				var scrollAmount,
					anchor = $(this),
					hash = anchor.prop("hash").split('#')[1],
					anchorData = hash !== '' ? $('[data-mkd-anchor="' + hash + '"]') : '';
				
				if (hash !== '' && anchorData.length > 0) {
					var anchoredElementOffset = anchorData.offset().top;
					scrollAmount = anchoredElementOffset - headerHeightToSubtract(anchoredElementOffset) - mkdGlobalVars.vars.mkdAddForAdminBar;
					
					setActiveState(anchor);
					
					mkd.html.stop().animate({
						scrollTop: Math.round(scrollAmount)
					}, 1000, function () {
						//change hash tag in url
						if (history.pushState) {
							history.pushState(null, '', '#' + hash);
						}
					});
					
					return false;
				}
			});
		};
		
		return {
			init: function () {
				if ($('[data-mkd-anchor]').length) {
					anchorClick();
					checkActiveStateOnScroll();
					
					$(window).on('load', function () {
						checkActiveStateOnLoad();
					});
				}
			}
		};
	};
	
	function mkdInitBackToTop() {
		var backToTopButton = $('#mkd-back-to-top');
		backToTopButton.on('click', function (e) {
			e.preventDefault();
			mkd.html.animate({scrollTop: 0}, mkd.window.scrollTop() / 5, 'linear');
		});
	}
	
	function mkdBackButtonShowHide() {
		mkd.window.scroll(function () {
			var b = $(this).scrollTop(),
				c = $(this).height(),
				d;
			
			if (b > 0) {
				d = b + c / 2;
			} else {
				d = 1;
			}
			
			if (d < 1e3) {
				mkdToTopButton('off');
			} else {
				mkdToTopButton('on');
			}
		});
	}
	
	function mkdToTopButton(a) {
		var b = $("#mkd-back-to-top");
		b.removeClass('off on');
		if (a === 'on') {
			b.addClass('on');
		} else {
			b.addClass('off');
		}
	}
	
	function mkdInitSelfHostedVideoPlayer() {
		var players = $('.mkd-self-hosted-video');
		
		if (players.length) {
			players.mediaelementplayer({
				audioWidth: '100%'
			});
		}
	}
	
	function mkdSelfHostedVideoSize(){
		var selfVideoHolder = $('.mkd-self-hosted-video-holder .mkd-video-wrap');
		
		if(selfVideoHolder.length) {
			selfVideoHolder.each(function(){
				var thisVideo = $(this),
					videoWidth = thisVideo.closest('.mkd-self-hosted-video-holder').outerWidth(),
					videoHeight = videoWidth / mkd.videoRatio;
				
				if(navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/)){
					thisVideo.parent().width(videoWidth);
					thisVideo.parent().height(videoHeight);
				}
				
				thisVideo.width(videoWidth);
				thisVideo.height(videoHeight);
				
				thisVideo.find('video, .mejs-overlay, .mejs-poster').width(videoWidth);
				thisVideo.find('video, .mejs-overlay, .mejs-poster').height(videoHeight);
			});
		}
	}
	
	function mkdFluidVideo() {
        fluidvids.init({
			selector: ['iframe'],
			players: ['www.youtube.com', 'player.vimeo.com']
		});
	}
	
	function mkdSmoothTransition() {

		if (mkd.body.hasClass('mkd-smooth-page-transitions')) {

			//check for preload animation
			if (mkd.body.hasClass('mkd-smooth-page-transitions-preloader')) {
				var loader = $('body > .mkd-smooth-transition-loader.mkd-mimic-ajax'),
                    revSlider = $('#mkd-main-rev-holder .rev_slider');
				loader.fadeOut(500);

                if (revSlider.length) {
                    revSlider.on('bind', 'revolution.slide.onchange', function(e, data){
                        loader.fadeOut(500);
                    });
                } else {
                    $(window).on('load', function(){
                        loader.fadeOut(500);

                        $(window).on('bind', 'pageshow', function (event) {
                            if (event.originalEvent.persisted) {
                                loader.fadeOut(500);
                            }
                        });
                    });
                }
			}

			// if back button is pressed, than reload page to avoid state where content is on display:none
            window.addEventListener( "pageshow", function ( event ) {
                var historyPath = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
                if ( historyPath ) {
                    $('.mkd-wrapper-inner').show();
                }
            });

			//check for fade out animation
			if (mkd.body.hasClass('mkd-smooth-page-transitions-fadeout')) {
				var linkItem = $('a');
				
				linkItem.on('click', function (e) {
					var a = $(this);

					if ((a.parents('.mkd-shopping-cart-dropdown').length || a.parent('.product-remove').length) && a.hasClass('remove')) {
						return;
					}

					if (
						e.which === 1 && // check if the left mouse button has been pressed
						a.attr('href').indexOf(window.location.host) >= 0 && // check if the link is to the same domain
						(typeof a.data('rel') === 'undefined') && //Not pretty photo link
						(typeof a.attr('rel') === 'undefined') && //Not VC pretty photo link
                        (!a.hasClass('lightbox-active')) && //Not lightbox plugin active
						(typeof a.attr('target') === 'undefined' || a.attr('target') === '_self') && // check if the link opens in the same window
						(a.attr('href').split('#')[0] !== window.location.href.split('#')[0]) // check if it is an anchor aiming for a different page
					) {
						e.preventDefault();
						$('.mkd-wrapper-inner').fadeOut(1000, function () {
							window.location = a.attr('href');
						});
					}
				});
			}
		}
	}
	
	/*
	 *	Preload background images for elements that have 'mkd-preload-background' class
	 */
	function mkdPreloadBackgrounds(){
		var preloadBackHolder = $('.mkd-preload-background');
		
		if(preloadBackHolder.length) {
			preloadBackHolder.each(function() {
				var preloadBackground = $(this);
				
				if(preloadBackground.css('background-image') !== '' && preloadBackground.css('background-image') !== 'none') {
					var bgUrl = preloadBackground.attr('style');
					
					bgUrl = bgUrl.match(/url\(["']?([^'")]+)['"]?\)/);
					bgUrl = bgUrl ? bgUrl[1] : "";
					
					if (bgUrl) {
						var backImg = new Image();
						backImg.src = bgUrl;
						$(backImg).load(function(){
							preloadBackground.removeClass('mkd-preload-background');
						});
					}
				} else {
					$(window).on('load', function(){ preloadBackground.removeClass('mkd-preload-background'); }); //make sure that mkd-preload-background class is removed from elements with forced background none in css
				}
			});
		}
	}
	
	function mkdPrettyPhoto() {
		/*jshint multistr: true */
		var markupWhole = '<div class="pp_pic_holder"> \
                        <div class="ppt">&nbsp;</div> \
                        <div class="pp_top"> \
                            <div class="pp_left"></div> \
                            <div class="pp_middle"></div> \
                            <div class="pp_right"></div> \
                        </div> \
                        <div class="pp_content_container"> \
                            <div class="pp_left"> \
                            <div class="pp_right"> \
                                <div class="pp_content"> \
                                    <div class="pp_loaderIcon"></div> \
                                    <div class="pp_fade"> \
                                        <a href="#" class="pp_expand" title="Expand the image">Expand</a> \
                                        <div class="pp_hoverContainer"> \
                                            <a class="pp_next" href="#"><span class="fa fa-angle-right"></span></a> \
                                            <a class="pp_previous" href="#"><span class="fa fa-angle-left"></span></a> \
                                        </div> \
                                        <div id="pp_full_res"></div> \
                                        <div class="pp_details"> \
                                            <div class="pp_nav"> \
                                                <a href="#" class="pp_arrow_previous">Previous</a> \
                                                <p class="currentTextHolder">0/0</p> \
                                                <a href="#" class="pp_arrow_next">Next</a> \
                                            </div> \
                                            <p class="pp_description"></p> \
                                            {pp_social} \
                                            <a class="pp_close" href="#">Close</a> \
                                        </div> \
                                    </div> \
                                </div> \
                            </div> \
                            </div> \
                        </div> \
                        <div class="pp_bottom"> \
                            <div class="pp_left"></div> \
                            <div class="pp_middle"></div> \
                            <div class="pp_right"></div> \
                        </div> \
                    </div> \
                    <div class="pp_overlay"></div>';
		
		$("a[data-rel^='prettyPhoto']").prettyPhoto({
			hook: 'data-rel',
			animation_speed: 'normal', /* fast/slow/normal */
			slideshow: false, /* false OR interval time in ms */
			autoplay_slideshow: false, /* true/false */
			opacity: 0.80, /* Value between 0 and 1 */
			show_title: true, /* true/false */
			allow_resize: true, /* Resize the photos bigger than viewport. true/false */
			horizontal_padding: 0,
			default_width: 960,
			default_height: 540,
			counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
			wmode: 'opaque', /* Set the flash wmode attribute */
			autoplay: true, /* Automatically start videos: True/False */
			modal: false, /* If set to true, only the close button will close the window */
			overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
			keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
			deeplinking: false,
			custom_markup: '',
			social_tools: false,
			markup: markupWhole
		});
	}

    function mkdSearchPostTypeWidget() {
        var searchPostTypeHolder = $('.mkd-search-post-type');

        if (searchPostTypeHolder.length) {
            searchPostTypeHolder.each(function () {
                var thisSearch = $(this),
                    searchField = thisSearch.find('.mkd-post-type-search-field'),
                    resultsHolder = thisSearch.siblings('.mkd-post-type-search-results'),
                    searchLoading = thisSearch.find('.mkd-search-loading'),
                    searchIcon = thisSearch.find('.mkd-search-icon');

                searchLoading.addClass('mkd-hidden');

                var postType = thisSearch.data('post-type'),
                    keyPressTimeout;

                searchField.on('keyup paste', function() {
                    var field = $(this);
                    field.attr('autocomplete','off');
                    searchLoading.removeClass('mkd-hidden');
                    searchIcon.addClass('mkd-hidden');
                    clearTimeout(keyPressTimeout);

                    keyPressTimeout = setTimeout( function() {
                        var searchTerm = field.val();
                        
                        if(searchTerm.length < 3) {
                            resultsHolder.html('');
                            resultsHolder.fadeOut();
                            searchLoading.addClass('mkd-hidden');
                            searchIcon.removeClass('mkd-hidden');
                        } else {
                            var ajaxData = {
                                action: 'entre_mikado_search_post_types',
                                term: searchTerm,
                                postType: postType
                            };

                            $.ajax({
                                type: 'POST',
                                data: ajaxData,
                                url: mkdGlobalVars.vars.mkdAjaxUrl,
                                success: function (data) {
                                    var response = JSON.parse(data);
                                    if (response.status === 'success') {
                                        searchLoading.addClass('mkd-hidden');
                                        searchIcon.removeClass('mkd-hidden');
                                        resultsHolder.html(response.data.html);
                                        resultsHolder.fadeIn();
                                    }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    console.log("Status: " + textStatus);
                                    console.log("Error: " + errorThrown);
                                    searchLoading.addClass('mkd-hidden');
                                    searchIcon.removeClass('mkd-hidden');
                                    resultsHolder.fadeOut();
                                }
                            });
                        }
                    }, 500);
                });

                searchField.on('focusout', function () {
                    searchLoading.addClass('mkd-hidden');
                    searchIcon.removeClass('mkd-hidden');
                    resultsHolder.fadeOut();
                });
            });
        }
    }
	
	/**
	 * Initializes load more data params
	 * @param container with defined data params
	 * return array
	 */
	function getLoadMoreData(container){
		var dataList = container.data(),
			returnValue = {};
		
		for (var property in dataList) {
			if (dataList.hasOwnProperty(property)) {
				if (typeof dataList[property] !== 'undefined' && dataList[property] !== false) {
					returnValue[property] = dataList[property];
				}
			}
		}
		
		return returnValue;
	}
	
	/**
	 * Sets load more data params for ajax function
	 * @param container with defined data params
	 * @param action with defined action name
	 * return array
	 */
	function setLoadMoreAjaxData(container, action) {
		var returnValue = {
			action: action
		};
		
		for (var property in container) {
			if (container.hasOwnProperty(property)) {
				
				if (typeof container[property] !== 'undefined' && container[property] !== false) {
					returnValue[property] = container[property];
				}
			}
		}
		
		return returnValue;
	}
	
	/**
	 * Object that represents icon with hover data
	 * @returns {{init: Function}} function that initializes icon's functionality
	 */
	var mkdIconWithHover = function() {
		//get all icons on page
		var icons = $('.mkd-icon-has-hover');
		
		/**
		 * Function that triggers icon hover color functionality
		 */
		var iconHoverColor = function(icon) {
			if(typeof icon.data('hover-color') !== 'undefined') {
				var changeIconColor = function(event) {
					event.data.icon.css('color', event.data.color);
				};
				
				var hoverColor = icon.data('hover-color'),
					originalColor = icon.css('color');
				
				if(hoverColor !== '') {
					icon.on('mouseenter', {icon: icon, color: hoverColor}, changeIconColor);
					icon.on('mouseleave', {icon: icon, color: originalColor}, changeIconColor);
				}
			}
		};
		
		return {
			init: function() {
				if(icons.length) {
					icons.each(function() {
						iconHoverColor($(this));
					});
				}
			}
		};
	};
	
	/*
	 ** Init parallax
	 */
	function mkdInitParallax(){
		var parallaxHolder = $('.mkd-parallax-row-holder');
		
		if(parallaxHolder.length){
			parallaxHolder.each(function() {
				var parallaxElement = $(this),
					image = parallaxElement.data('parallax-bg-image'),
					speed = parallaxElement.data('parallax-bg-speed') * 0.4,
					height = 0;
				
				if (typeof parallaxElement.data('parallax-bg-height') !== 'undefined' && parallaxElement.data('parallax-bg-height') !== false) {
					height = parseInt(parallaxElement.data('parallax-bg-height'));
				}
				
				parallaxElement.css({'background-image': 'url('+image+')'});
				
				if(height > 0) {
					parallaxElement.css({'min-height': height+'px', 'height': height+'px'});
				}
				
				parallaxElement.parallax('50%', speed);
			});
		}
	}
	
	/*
	 **  Init sticky sidebar widget
	 */
	function mkdStickySidebarWidget(){
		var sswHolder = $('.mkd-widget-sticky-sidebar'),
			headerHolder = $('.mkd-page-header'),
			headerHeight = headerHolder.length ? headerHolder.outerHeight() : 0,
			widgetTopOffset = 0,
			widgetTopPosition = 0,
			sidebarHeight = 0,
			sidebarWidth = 0,
			objectsCollection = [];
		
		function addObjectItems() {
			if (sswHolder.length) {
				sswHolder.each(function () {
					var thisSswHolder = $(this),
						mainSidebarHolder = thisSswHolder.parents('aside.mkd-sidebar'),
						widgetiseSidebarHolder = thisSswHolder.parents('.wpb_widgetised_column'),
						sidebarHolder = '',
						sidebarHolderHeight = 0;
					
					widgetTopOffset = thisSswHolder.offset().top;
					widgetTopPosition = thisSswHolder.position().top;
					sidebarHeight = 0;
					sidebarWidth = 0;
					
					if (mainSidebarHolder.length) {
						sidebarHeight = mainSidebarHolder.outerHeight();
						sidebarWidth = mainSidebarHolder.outerWidth();
						sidebarHolder = mainSidebarHolder;
						sidebarHolderHeight = mainSidebarHolder.parent().parent().outerHeight();
						
						var blogHolder = mainSidebarHolder.parent().parent().find('.mkd-blog-holder');
						if (blogHolder.length) {
							sidebarHolderHeight -= parseInt(blogHolder.css('marginBottom'));
						}
					} else if (widgetiseSidebarHolder.length) {
						sidebarHeight = widgetiseSidebarHolder.outerHeight();
						sidebarWidth = widgetiseSidebarHolder.outerWidth();
						sidebarHolder = widgetiseSidebarHolder;
						sidebarHolderHeight = widgetiseSidebarHolder.parents('.vc_row').outerHeight();
					}
					
					objectsCollection.push({
						'object': thisSswHolder,
						'offset': widgetTopOffset,
						'position': widgetTopPosition,
						'height': sidebarHeight,
						'width': sidebarWidth,
						'sidebarHolder': sidebarHolder,
						'sidebarHolderHeight': sidebarHolderHeight
					});
				});
			}
		}
		
		function initStickySidebarWidget() {
			
			if (objectsCollection.length) {
				$.each(objectsCollection, function (i) {
					var thisSswHolder = objectsCollection[i]['object'],
						thisWidgetTopOffset = objectsCollection[i]['offset'],
						thisWidgetTopPosition = objectsCollection[i]['position'],
						thisSidebarHeight = objectsCollection[i]['height'],
						thisSidebarWidth = objectsCollection[i]['width'],
						thisSidebarHolder = objectsCollection[i]['sidebarHolder'],
						thisSidebarHolderHeight = objectsCollection[i]['sidebarHolderHeight'];
					
					if (mkd.body.hasClass('mkd-fixed-on-scroll')) {
						var fixedHeader = $('.mkd-fixed-wrapper.fixed');
						
						if (fixedHeader.length) {
							headerHeight = fixedHeader.outerHeight() + mkdGlobalVars.vars.mkdAddForAdminBar;
						}
					} else if (mkd.body.hasClass('mkd-no-behavior')) {
						headerHeight = mkdGlobalVars.vars.mkdAddForAdminBar;
					}
					
					if (mkd.windowWidth > 1024 && thisSidebarHolder.length) {
						var sidebarPosition = -(thisWidgetTopPosition - headerHeight),
							sidebarHeight = thisSidebarHeight - thisWidgetTopPosition - 40; // 40 is bottom margin of widget holder
						
						//move sidebar up when hits the end of section row
						var rowSectionEndInViewport = thisSidebarHolderHeight + thisWidgetTopOffset - headerHeight - thisWidgetTopPosition - mkdGlobalVars.vars.mkdTopBarHeight;
						
						if ((mkd.scroll >= thisWidgetTopOffset - headerHeight) && thisSidebarHeight < thisSidebarHolderHeight) {
							if (thisSidebarHolder.hasClass('mkd-sticky-sidebar-appeared')) {
								thisSidebarHolder.css({'top': sidebarPosition + 'px'});
							} else {
								thisSidebarHolder.addClass('mkd-sticky-sidebar-appeared').css({
									'position': 'fixed',
									'top': sidebarPosition + 'px',
									'width': thisSidebarWidth,
									'margin-top': '-10px'
								}).animate({'margin-top': '0'}, 200);
							}
							
							if (mkd.scroll + sidebarHeight >= rowSectionEndInViewport) {
								var absBottomPosition = thisSidebarHolderHeight - sidebarHeight + sidebarPosition - headerHeight;
								
								thisSidebarHolder.css({
									'position': 'absolute',
									'top': absBottomPosition + 'px'
								});
							} else {
								if (thisSidebarHolder.hasClass('mkd-sticky-sidebar-appeared')) {
									thisSidebarHolder.css({
										'position': 'fixed',
										'top': sidebarPosition + 'px'
									});
								}
							}
						} else {
							thisSidebarHolder.removeClass('mkd-sticky-sidebar-appeared').css({
								'position': 'relative',
								'top': '0',
								'width': 'auto'
							});
						}
					} else {
						thisSidebarHolder.removeClass('mkd-sticky-sidebar-appeared').css({
							'position': 'relative',
							'top': '0',
							'width': 'auto'
						});
					}
				});
			}
		}
		
		return {
			init: function () {
				addObjectItems();
				initStickySidebarWidget();
				
				$(window).scroll(function () {
					initStickySidebarWidget();
				});
			},
			reInit: initStickySidebarWidget
		};
	}

    /**
     * Init Owl Carousel
     */
    function mkdOwlSlider() {
        var sliders = $('.mkd-owl-slider');

        if (sliders.length) {
            sliders.each(function(){
                var slider = $(this),
                    owlSlider = $(this),
	                slideItemsNumber = slider.children().length,
	                numberOfItems = 1,
	                loop = true,
	                autoplay = true,
	                autoplayHoverPause = true,
	                sliderSpeed = 5000,
	                sliderSpeedAnimation = 600,
	                margin = 0,
	                responsiveMargin = 0,
	                responsiveMargin1 = 0,
	                stagePadding = 0,
	                stagePaddingEnabled = false,
	                center = false,
	                autoWidth = false,
	                animateInClass = false, // keyframe css animation
	                animateOutClass = false, // keyframe css animation
	                navigation = true,
	                pagination = false,
	                thumbnail = false,
                    navText = [
			            '<span class="mkd-prev-icon arrow_left"></span>',
			            '<span class="mkd-next-icon arrow_right"></span>'
		            ],
                    thumbnailSlider,
                    sliderIsTestimonials = !!slider.hasClass('mkd-testimonials'),
                    sliderIsTIgSlider = !!slider.hasClass('mkd-ig-slider'),
	                sliderIsPortfolio = !!slider.hasClass('mkd-pl-is-slider'),
	                sliderDataHolder = sliderIsPortfolio ? slider.parent() : slider;  // this is condition for portfolio slider

                if (typeof sliderDataHolder.data('slider-animate-in') !== 'undefined' && sliderDataHolder.data('slider-animate-in') !== false) {
                    animateInClass = sliderDataHolder.data('slider-animate-in');
                }
                if (typeof sliderDataHolder.data('slider-animate-out') !== 'undefined' && sliderDataHolder.data('slider-animate-out') !== false) {
                    animateOutClass = sliderDataHolder.data('slider-animate-out');
                }

                if (sliderIsTestimonials) {
                    animateOutClass = 'slideOutUp';
                    animateInClass = 'slideInUp';
                    navText = [
                        '<span class="mkd-prev-icon arrow_down"></span>',
                        '<span class="mkd-next-icon arrow_up"></span>'
                    ];
                }

                if (sliderIsTIgSlider && slider.parent().hasClass('mkd-ig-slider-type')) {
                    animateOutClass = 'fadeOutUp';
                    animateInClass = 'fadeInUp';
                    navText = [
                        '<span class="mkd-prev-icon arrow_down"></span>',
                        '<span class="mkd-next-icon arrow_up"></span>'
                    ];
                }

	            if(sliderIsTIgSlider && slider.parent().hasClass('mkd-ig-carousel-type') && slider.data('fullscreen-carousel') === 'yes') {
	            	 autoplayHoverPause = false;
	            	 var holder = $('.mkd-image-gallery');
	            	 var topOffset = holder.offset().top,
                     passepartoutHeight = mkd.body.hasClass('mkd-paspartu-enabled') ? parseInt( $('.mkd-wrapper').css('padding-top'), 10 ) : 0;

                     holder.css('height', mkd.windowHeight - topOffset - passepartoutHeight);
                     holder.addClass('mkd-fullscreen-carousel');
	            }
	
	            if (typeof slider.data('number-of-items') !== 'undefined' && slider.data('number-of-items') !== false && !sliderIsPortfolio) {
		            numberOfItems = slider.data('number-of-items');
	            }
	            if (typeof sliderDataHolder.data('number-of-columns') !== 'undefined' && sliderDataHolder.data('number-of-columns') !== false && sliderIsPortfolio) {
		            numberOfItems = sliderDataHolder.data('number-of-columns');
	            }
	            if (sliderDataHolder.data('enable-loop') === 'no') {
                    loop = false;
	            }
	            if (sliderDataHolder.data('enable-autoplay') === 'no') {
		            autoplay = false;
	            }
	            if (sliderDataHolder.data('enable-autoplay-hover-pause') === 'no') {
		            autoplayHoverPause = false;
	            }
	            if (typeof sliderDataHolder.data('slider-speed') !== 'undefined' && sliderDataHolder.data('slider-speed') !== false) {
		            sliderSpeed = sliderDataHolder.data('slider-speed');
	            }
	            if (typeof sliderDataHolder.data('slider-speed-animation') !== 'undefined' && sliderDataHolder.data('slider-speed-animation') !== false) {
		            sliderSpeedAnimation = sliderDataHolder.data('slider-speed-animation');
	            }
	            if (typeof sliderDataHolder.data('slider-margin') !== 'undefined' && sliderDataHolder.data('slider-margin') !== false) {
		            if (sliderDataHolder.data('slider-margin') === 'no') {
			            margin = 0;
		            } else {
			            margin = sliderDataHolder.data('slider-margin');
		            }
	            } else {
		            if(slider.parent().hasClass('mkd-huge-space')) {
			            margin = 60;
		            } else if (slider.parent().hasClass('mkd-large-space')) {
			            margin = 50;
		            } else if (slider.parent().hasClass('mkd-medium-space')) {
			            margin = 40;
		            } else if (slider.parent().hasClass('mkd-normal-space')) {
			            margin = 30;
		            } else if (slider.parent().hasClass('mkd-small-space')) {
			            margin = 20;
		            } else if (slider.parent().hasClass('mkd-tiny-space')) {
			            margin = 10;
		            }
	            }
	            if (sliderDataHolder.data('slider-padding') === 'yes') {
		            stagePaddingEnabled = true;
		            stagePadding = parseInt(slider.outerWidth() * 0.28);
		            margin = 50;
	            }
	            if (sliderDataHolder.data('enable-center') === 'yes') {
		            center = true;
	            }
	            if (sliderDataHolder.data('enable-auto-width') === 'yes') {
		            autoWidth = true;
	            }
	            if (sliderDataHolder.data('enable-navigation') === 'no') {
		            navigation = false;
	            }
	            if (sliderDataHolder.data('enable-pagination') === 'yes') {
		            pagination = true;
	            }

	            if (sliderDataHolder.data('enable-thumbnail') === 'yes') {
                    thumbnail = true;
	            }
	            
	            if(navigation && pagination) {
		            slider.addClass('mkd-slider-has-both-nav');
	            }
	
	            if (slideItemsNumber <= 1) {
		            loop       = false;
		            autoplay   = false;
		            navigation = false;
		            pagination = false;
	            }
	
	            var responsiveNumberOfItems1 = 1,
		            responsiveNumberOfItems2 = 2,
		            responsiveNumberOfItems3 = 3,
		            responsiveNumberOfItems4 = numberOfItems;
	
	            if (numberOfItems < 3) {
		            responsiveNumberOfItems2 = numberOfItems;
		            responsiveNumberOfItems3 = numberOfItems;
	            }
	
	            if (numberOfItems > 4) {
		            responsiveNumberOfItems4 = 4;
	            }
	
	            if (stagePaddingEnabled || margin > 30) {
		            responsiveMargin = 20;
		            responsiveMargin1 = 30;
	            }
	
	            if (margin > 0 && margin <= 30) {
		            responsiveMargin = margin;
		            responsiveMargin1 = margin;
	            }
	
	            slider.waitForImages(function () {
		            owlSlider = slider.owlCarousel({
			            items: numberOfItems,
			            loop: loop,
			            autoplay: autoplay,
			            autoplayHoverPause: autoplayHoverPause,
			            autoplayTimeout: sliderSpeed,
			            smartSpeed: sliderSpeedAnimation,
			            margin: margin,
			            stagePadding: stagePadding,
			            center: center,
			            autoWidth: autoWidth,
			            animateIn: animateInClass,
			            animateOut: animateOutClass,
			            dots: pagination,
			            nav: navigation,
			            navText: navText,
			            responsive: {
				            0: {
					            items: responsiveNumberOfItems1,
					            margin: responsiveMargin,
					            stagePadding: 0,
					            center: false,
					            autoWidth: false
				            },
				            681: {
					            items: responsiveNumberOfItems2,
					            margin: responsiveMargin1
				            },
				            769: {
					            items: responsiveNumberOfItems3,
					            margin: responsiveMargin1
				            },
				            1025: {
					            items: responsiveNumberOfItems4
				            },
				            1281: {
					            items: numberOfItems
				            }
			            },
			            onInitialize: function () {
				            slider.css('visibility', 'visible');
				            mkdInitParallax();
			            },
			            onDrag: function (e) {
				            if (mkd.body.hasClass('mkd-smooth-page-transitions-fadeout')) {
					            var sliderIsMoving = e.isTrigger > 0;
					
					            if (sliderIsMoving) {
						            slider.addClass('mkd-slider-is-moving');
					            }
				            }
			            },
			            onDragged: function () {
				            if (mkd.body.hasClass('mkd-smooth-page-transitions-fadeout') && slider.hasClass('mkd-slider-is-moving')) {
					
					            setTimeout(function () {
						            slider.removeClass('mkd-slider-is-moving');
					            }, 500);
				            }
			            },
                        onTranslate: function (e) {
							$(e.target).addClass('mkd-pointer-on');
                        },
                        onTranslated: function (e) {
                            $(e.target).removeClass('mkd-pointer-on');
                        }
		            });
	            });

                if(thumbnail) {
                    thumbnailSlider = slider.parent().find('.mkd-slider-thumbnail');

                    var numberOfThumbnails = parseInt(thumbnailSlider.data('thumbnail-count'));
                    var numberOfThumbnailsClass = '';

                    switch (numberOfThumbnails % 6) {
                        case 2 :
                            numberOfThumbnailsClass = 'two';
                            break;
                        case 3 :
                            numberOfThumbnailsClass = 'three';
                            break;
                        case 4 :
                            numberOfThumbnailsClass = 'four';
                            break;
                        case 5 :
                            numberOfThumbnailsClass = 'five';
                            break;
                        case 0 :
                            numberOfThumbnailsClass = 'six';
                            break;
                        default :
                            numberOfThumbnailsClass = '';
                            break;
                    }

                    if(numberOfThumbnailsClass !== '') {
                        thumbnailSlider.addClass('mkd-slider-columns-' + numberOfThumbnailsClass)
                    }

                    thumbnailSlider.find('.mkd-slider-thumbnail-item').on('click', function () {
                        owlSlider.trigger('to.owl.carousel', [$(this).index(), sliderSpeedAnimation]);
                    });
                }
            });
        }
    }

    function mkdParallaxElements() {
        var parallaxIntances = $('.mkd-pl-has-parallax-scroll, .mkd-parallax-holder');

        if (parallaxIntances.length && !mkd.htmlEl.hasClass('touch')) {
            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
        }
    }
	
	function mkdUncoverSliderSection() {
		var holder = $('body.mkd-uncovering-slider-section');
		
		if (holder.length && mkd.windowWidth > 1024) {
			mkdDisableScroll();
			
			var slider = holder.find('.mkd-slider'),
				sliderHeight = slider.outerHeight(),
				content = holder.find('.mkd-content .mkd-content-inner > .mkd-full-width, .mkd-content .mkd-content-inner > .mkd-container'),
				contentHeight = content.outerHeight(),
				footer = holder.find('.mkd-page-footer'),
				footerHeight = footer.length ? footer.outerHeight() : 0;
			
			holder.addClass('mkd-uss-init');
			slider.css('marginBottom', (contentHeight + footerHeight));
			
			$(window).scroll(function () {
				var scroll = mkd.scroll;
				
				if (scroll >= sliderHeight) {
					holder.removeClass('mkd-uss-init');
				} else {
					holder.addClass('mkd-uss-init');
				}
			});

            slider.waitForImages(function(){
                setTimeout(function () {
                    mkdEnableScroll();
                    content.css('visibility', 'visible');
                    footer.css('visibility', 'visible');
                }, 800);
			});
		}
	}

})(jQuery);
(function($) {
    'use strict';

    var like = {};
    
    like.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /**
    *  All functions to be called on $(document).ready() should be in this function
    **/
    function mkdOnDocumentReady() {
        mkdLikes();
    }

    function mkdLikes() {
        $(document).on('click','.mkd-like', function() {
            var likeLink = $(this),
                id = likeLink.attr('id'),
                type;

            if ( likeLink.hasClass('liked') ) {
                return false;
            }

            if (typeof likeLink.data('type') !== 'undefined') {
                type = likeLink.data('type');
            }

            var dataToPass = {
                action: 'entre_mikado_like',
                likes_id: id,
                type: type
            };

            var like = $.post(mkdGlobalVars.vars.mkdAjaxUrl, dataToPass, function( data ) {
                likeLink.html(data).addClass('liked').attr('title', 'You already like this!');
            });

            return false;
        });
    }
    
})(jQuery);
(function($) {
    "use strict";

    var blogListSC = {};
    mkd.modules.blogListSC = blogListSC;

    blogListSC.mkdOnDocumentReady = mkdOnDocumentReady;
    blogListSC.mkdOnWindowLoad = mkdOnWindowLoad;
    blogListSC.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).scroll(mkdOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitBlogListMasonry();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function mkdOnWindowLoad() {
        mkdInitBlogListShortcodePagination().init();
    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function mkdOnWindowScroll() {
        mkdInitBlogListShortcodePagination().scroll();
    }

    /**
     * Init blog list shortcode masonry layout
     */
    function mkdInitBlogListMasonry() {
        var holder = $('.mkd-blog-list-holder.mkd-bl-masonry');

        if(holder.length){
            holder.each(function(){
                var thisHolder = $(this),
                    masonry = thisHolder.find('.mkd-blog-list');

                masonry.waitForImages(function() {
                    masonry.isotope({
                        layoutMode: 'packery',
                        itemSelector: '.mkd-bl-item',
                        percentPosition: true,
                        packery: {
                            gutter: '.mkd-bl-grid-gutter',
                            columnWidth: '.mkd-bl-grid-sizer'
                        }
                    });

                    masonry.css('opacity', '1');
                });
            });
        }
    }

    /**
     * Init blog list shortcode pagination functions
     */
    function mkdInitBlogListShortcodePagination(){
        var holder = $('.mkd-blog-list-holder');

        var initStandardPagination = function(thisHolder) {
            var standardLink = thisHolder.find('.mkd-bl-standard-pagination li');

            if(standardLink.length) {
                standardLink.each(function(){
                    var thisLink = $(this).children('a'),
                        pagedLink = 1;

                    thisLink.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (typeof thisLink.data('paged') !== 'undefined' && thisLink.data('paged') !== false) {
                            pagedLink = thisLink.data('paged');
                        }

                        initMainPagFunctionality(thisHolder, pagedLink);
                    });
                });
            }
        };

        var initLoadMorePagination = function(thisHolder) {
            var loadMoreButton = thisHolder.find('.mkd-blog-pag-load-more a');

            loadMoreButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                initMainPagFunctionality(thisHolder);
            });
        };

        var initInifiteScrollPagination = function(thisHolder) {
            var blogListHeight = thisHolder.outerHeight(),
                blogListTopOffest = thisHolder.offset().top,
                blogListPosition = blogListHeight + blogListTopOffest - mkdGlobalVars.vars.mkdAddForAdminBar;

            if(!thisHolder.hasClass('mkd-bl-pag-infinite-scroll-started') && mkd.scroll + mkd.windowHeight > blogListPosition) {
                initMainPagFunctionality(thisHolder);
            }
        };

        var initMainPagFunctionality = function(thisHolder, pagedLink) {
            var thisHolderInner = thisHolder.find('.mkd-blog-list'),
                nextPage,
                maxNumPages;

            if (typeof thisHolder.data('max-num-pages') !== 'undefined' && thisHolder.data('max-num-pages') !== false) {
                maxNumPages = thisHolder.data('max-num-pages');
            }

            if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                thisHolder.data('next-page', pagedLink);
            }

            if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                thisHolder.addClass('mkd-bl-pag-infinite-scroll-started');
            }

            var loadMoreDatta = mkd.modules.common.getLoadMoreData(thisHolder),
                loadingItem = thisHolder.find('.mkd-blog-pag-loading');

            nextPage = loadMoreDatta.nextPage;

            if(nextPage <= maxNumPages){
                if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                    loadingItem.addClass('mkd-showing mkd-standard-pag-trigger');
                    thisHolder.addClass('mkd-bl-pag-standard-shortcodes-animate');
                } else {
                    loadingItem.addClass('mkd-showing');
                }

                var ajaxData = mkd.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'entre_mikado_blog_shortcode_load_more');

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: mkdGlobalVars.vars.mkdAjaxUrl,
                    success: function (data) {
                        if(!thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            nextPage++;
                        }

                        thisHolder.data('next-page', nextPage);

                        var response = $.parseJSON(data),
                            responseHtml =  response.html;

                        if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            mkdInitStandardPaginationLinkChanges(thisHolder, maxNumPages, nextPage);

                            thisHolder.waitForImages(function(){
                                if(thisHolder.hasClass('mkd-bl-masonry')){
                                    mkdInitHtmlIsotopeNewContent(thisHolder, thisHolderInner, loadingItem, responseHtml);
                                } else {
                                    mkdInitHtmlGalleryNewContent(thisHolder, thisHolderInner, loadingItem, responseHtml);

                                    if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                                        mkd.modules.common.mkdStickySidebarWidget().reInit();
                                    }
                                }
                            });
                        } else {
                            thisHolder.waitForImages(function(){
                                if(thisHolder.hasClass('mkd-bl-masonry')){
                                    mkdInitAppendIsotopeNewContent(thisHolderInner, loadingItem, responseHtml);
                                } else {
                                    mkdInitAppendGalleryNewContent(thisHolderInner, loadingItem, responseHtml);

                                    if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                                        mkd.modules.common.mkdStickySidebarWidget().reInit();
                                    }
                                }
                            });
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll-started')) {
                            thisHolder.removeClass('mkd-bl-pag-infinite-scroll-started');
                        }
                    }
                });
            }

            if(nextPage === maxNumPages){
                thisHolder.find('.mkd-blog-pag-load-more').hide();
            }
        };

        var mkdInitStandardPaginationLinkChanges = function(thisHolder, maxNumPages, nextPage) {
            var standardPagHolder = thisHolder.find('.mkd-bl-standard-pagination'),
                standardPagNumericItem = standardPagHolder.find('li.mkd-bl-pag-number'),
                standardPagPrevItem = standardPagHolder.find('li.mkd-bl-pag-prev a'),
                standardPagNextItem = standardPagHolder.find('li.mkd-bl-pag-next a');

            standardPagNumericItem.removeClass('mkd-bl-pag-active');
            standardPagNumericItem.eq(nextPage-1).addClass('mkd-bl-pag-active');

            standardPagPrevItem.data('paged', nextPage-1);
            standardPagNextItem.data('paged', nextPage+1);

            if(nextPage > 1) {
                standardPagPrevItem.css({'opacity': '1'});
            } else {
                standardPagPrevItem.css({'opacity': '0'});
            }

            if(nextPage === maxNumPages) {
                standardPagNextItem.css({'opacity': '0'});
            } else {
                standardPagNextItem.css({'opacity': '1'});
            }
        };

        var mkdInitHtmlIsotopeNewContent = function(thisHolder, thisHolderInner, loadingItem, responseHtml) {
            thisHolderInner.html(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
            loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
            thisHolder.removeClass('mkd-bl-pag-standard-shortcodes-animate');

            setTimeout(function() {
                thisHolderInner.isotope('layout');

                if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                    mkd.modules.common.mkdStickySidebarWidget().reInit();
                }
            }, 600);
        };

        var mkdInitHtmlGalleryNewContent = function(thisHolder, thisHolderInner, loadingItem, responseHtml) {
            loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
            thisHolder.removeClass('mkd-bl-pag-standard-shortcodes-animate');
            thisHolderInner.html(responseHtml);
        };

        var mkdInitAppendIsotopeNewContent = function(thisHolderInner, loadingItem, responseHtml) {
            thisHolderInner.append(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
            loadingItem.removeClass('mkd-showing');

            setTimeout(function() {
                thisHolderInner.isotope('layout');

                if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                    mkd.modules.common.mkdStickySidebarWidget().reInit();
                }
            }, 600);
        };

        var mkdInitAppendGalleryNewContent = function(thisHolderInner, loadingItem, responseHtml) {
            loadingItem.removeClass('mkd-showing');
            thisHolderInner.append(responseHtml);
        };

        return {
            init: function() {
                if(holder.length) {
                    holder.each(function() {
                        var thisHolder = $(this);

                        if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            initStandardPagination(thisHolder);
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-load-more')) {
                            initLoadMorePagination(thisHolder);
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisHolder);
                        }
                    });
                }
            },
            scroll: function() {
                if(holder.length) {
                    holder.each(function() {
                        var thisHolder = $(this);

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisHolder);
                        }
                    });
                }
            }
        };
    }

})(jQuery);
(function($) {
    "use strict";

    var blogMasonryGallery = {};
    mkd.modules.blogMasonryGallery = blogMasonryGallery;

    blogMasonryGallery.mkdOnDocumentReady = mkdOnDocumentReady;
    blogMasonryGallery.mkdOnWindowLoad = mkdOnWindowLoad;
    blogMasonryGallery.mkdOnWindowResize = mkdOnWindowResize;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitBlogMasonryGallery();
        mkdInitBlogMasonryGalleryAppearLoadMore();
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
        mkdInitBlogMasonryGallery();
    }

    /**
     *  Init Blog Masonry Gallery
     *
     *  Function that sets equal height of articles on blog masonry gallery list
     */
    function mkdInitBlogMasonryGallery(){
        var portList = $('.mkd-blog-holder.mkd-blog-masonry-gallery');

        if(portList.length){
            portList.each(function(){
                var thisPortList = $(this),
                    masonry = thisPortList.children('.mkd-blog-holder-inner'),
                    size = thisPortList.find('.mkd-blog-masonry-grid-sizer').width();
                
                mkdResizeBlogMasonryItems(size, thisPortList);

                masonry.isotope({
                    layoutMode: 'packery',
                    itemSelector: 'article',
                    percentPosition: true,
                    packery: {
                        gutter: '.mkd-blog-masonry-grid-gutter',
                        columnWidth: '.mkd-blog-masonry-grid-sizer'
                    }
                });
                
                setTimeout(function () {
                    mkd.modules.common.mkdInitParallax();
                }, 600);

                masonry.css('opacity', '1');
            });
        }
    }

    /**
     * Init Resize Blog Items
     */
    function mkdResizeBlogMasonryItems(size,container){
        if(container.hasClass('mkd-pl-images-fixed')) {
            var padding = parseInt(container.find('article').css('padding-left')),
                defaultMasonryItem = container.find('.mkd-post-size-default'),
                largeWidthMasonryItem = container.find('.mkd-post-size-large-width'),
                largeHeightMasonryItem = container.find('.mkd-post-size-large-height'),
                largeWidthHeightMasonryItem = container.find('.mkd-post-size-large-width-height');

            if (mkd.windowWidth > 680) {
                defaultMasonryItem.css('height', size - 2 * padding);
                largeHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthMasonryItem.css('height', size - 2 * padding);
            } else {
                defaultMasonryItem.css('height', size);
                largeHeightMasonryItem.css('height', size);
                largeWidthHeightMasonryItem.css('height', size);
                largeWidthMasonryItem.css('height', Math.round(size / 2));
            }
        }
    }

    function mkdInitBlogMasonryGalleryAppearLoadMore() {
        $( document.body ).on( 'blog_list_load_more_trigger', function() {
            mkdInitBlogMasonryGalleryAppear();
        });
    }

})(jQuery);
(function($) {
	"use strict";

    var blog = {};
    mkd.modules.blog = blog;

    blog.mkdOnDocumentReady = mkdOnDocumentReady;
    blog.mkdOnWindowLoad = mkdOnWindowLoad;
    blog.mkdOnWindowResize = mkdOnWindowResize;
    blog.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    $(window).scroll(mkdOnWindowScroll);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkdInitAudioPlayer();
        mkdInitBlogMasonry();
    }

    /* 
        All functions to be called on $(window).load() should be in this function
    */
    function mkdOnWindowLoad() {
	    mkdInitBlogPagination().init();
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function mkdOnWindowResize() {
        mkdInitBlogMasonry();
    }

    /* 
        All functions to be called on $(window).scroll() should be in this function
    */
    function mkdOnWindowScroll() {
	    mkdInitBlogPagination().scroll();
    }

    /**
    * Init audio player for Blog list and single pages
    */
    function mkdInitAudioPlayer() {
        var players = $('audio.mkd-blog-audio');

        players.mediaelementplayer({
            audioWidth: '100%'
        });
    }

    /**
     * Init Resize Blog Items
     */
    function mkdResizeBlogItems(size,container){

        if(container.hasClass('mkd-masonry-images-fixed')) {
            var padding = parseInt(container.find('article').css('padding-left')),
                defaultMasonryItem = container.find('.mkd-post-size-default'),
                largeWidthMasonryItem = container.find('.mkd-post-size-large-width'),
                largeHeightMasonryItem = container.find('.mkd-post-size-large-height'),
                largeWidthHeightMasonryItem = container.find('.mkd-post-size-large-width-height');

			if (mkd.windowWidth > 680) {
				defaultMasonryItem.css('height', size - 2 * padding);
				largeHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
				largeWidthHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
				largeWidthMasonryItem.css('height', size - 2 * padding);
			} else {
				defaultMasonryItem.css('height', size);
				largeHeightMasonryItem.css('height', size);
				largeWidthHeightMasonryItem.css('height', size);
				largeWidthMasonryItem.css('height', Math.round(size / 2));
			}
        }
    }

    /**
    * Init Blog Masonry Layout
    */
    function mkdInitBlogMasonry() {
	    var holder = $('.mkd-blog-holder.mkd-blog-type-masonry');
	
	    if(holder.length){
		    holder.each(function(){
			    var thisHolder = $(this),
				    masonry = thisHolder.children('.mkd-blog-holder-inner'),
                    size = thisHolder.find('.mkd-blog-masonry-grid-sizer').width();
			    
                mkdResizeBlogItems(size, thisHolder);
                
			    masonry.waitForImages(function() {
				    masonry.isotope({
					    layoutMode: 'packery',
					    itemSelector: 'article',
					    percentPosition: true,
					    packery: {
						    gutter: '.mkd-blog-masonry-grid-gutter',
						    columnWidth: '.mkd-blog-masonry-grid-sizer'
					    }
				    });
                    masonry.css('opacity', '1');
				
				    setTimeout(function() {
					    masonry.isotope('layout');
				    }, 800);
                });
		    });
	    }
    }
	
	/**
	 * Initializes blog pagination functions
	 */
	function mkdInitBlogPagination(){
		var holder = $('.mkd-blog-holder');
		
		var initLoadMorePagination = function(thisHolder) {
			var loadMoreButton = thisHolder.find('.mkd-blog-pag-load-more a');
			
			loadMoreButton.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				initMainPagFunctionality(thisHolder);
			});
		};
		
		var initInifiteScrollPagination = function(thisHolder) {
			var blogListHeight = thisHolder.outerHeight(),
				blogListTopOffest = thisHolder.offset().top,
				blogListPosition = blogListHeight + blogListTopOffest - mkdGlobalVars.vars.mkdAddForAdminBar;
			
			if(!thisHolder.hasClass('mkd-blog-pagination-infinite-scroll-started') && mkd.scroll + mkd.windowHeight > blogListPosition) {
				initMainPagFunctionality(thisHolder);
			}
		};
		
		var initMainPagFunctionality = function(thisHolder) {
			var thisHolderInner = thisHolder.children('.mkd-blog-holder-inner'),
				nextPage,
				maxNumPages;
			
			if (typeof thisHolder.data('max-num-pages') !== 'undefined' && thisHolder.data('max-num-pages') !== false) {
				maxNumPages = thisHolder.data('max-num-pages');
			}
			
			if(thisHolder.hasClass('mkd-blog-pagination-infinite-scroll')) {
				thisHolder.addClass('mkd-blog-pagination-infinite-scroll-started');
			}
			
			var loadMoreDatta = mkd.modules.common.getLoadMoreData(thisHolder),
				loadingItem = thisHolder.find('.mkd-blog-pag-loading');
			
			nextPage = loadMoreDatta.nextPage;
			
			if(nextPage <= maxNumPages){
				loadingItem.addClass('mkd-showing');
				
				var ajaxData = mkd.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'entre_mikado_blog_load_more');
				
				$.ajax({
					type: 'POST',
					data: ajaxData,
					url: mkdGlobalVars.vars.mkdAjaxUrl,
					success: function (data) {
						nextPage++;
						
						thisHolder.data('next-page', nextPage);

						var response = $.parseJSON(data),
							responseHtml =  response.html;

						thisHolder.waitForImages(function(){
							if(thisHolder.hasClass('mkd-blog-type-masonry')){
								mkdInitAppendIsotopeNewContent(thisHolderInner, loadingItem, responseHtml);
                                mkdResizeBlogItems(thisHolderInner.find('.mkd-blog-masonry-grid-sizer').width(), thisHolder);
							} else {
								mkdInitAppendGalleryNewContent(thisHolderInner, loadingItem, responseHtml);
							}
							
							setTimeout(function() {
								mkdInitAudioPlayer();
								mkd.modules.common.mkdOwlSlider();
								mkd.modules.common.mkdFluidVideo();
                                mkd.modules.common.mkdInitSelfHostedVideoPlayer();
                                mkd.modules.common.mkdSelfHostedVideoSize();
								
								if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
									mkd.modules.common.mkdStickySidebarWidget().reInit();
								}

                                // Trigger event.
                                $( document.body ).trigger( 'blog_list_load_more_trigger' );

							}, 400);
						});
						
						if(thisHolder.hasClass('mkd-blog-pagination-infinite-scroll-started')) {
							thisHolder.removeClass('mkd-blog-pagination-infinite-scroll-started');
						}
					}
				});
			}
			
			if(nextPage === maxNumPages){
				thisHolder.find('.mkd-blog-pag-load-more').hide();
			}
		};
		
		var mkdInitAppendIsotopeNewContent = function(thisHolderInner, loadingItem, responseHtml) {
			thisHolderInner.append(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
			loadingItem.removeClass('mkd-showing');
			
			setTimeout(function() {
				thisHolderInner.isotope('layout');
			}, 600);
		};
		
		var mkdInitAppendGalleryNewContent = function(thisHolderInner, loadingItem, responseHtml) {
			loadingItem.removeClass('mkd-showing');
			thisHolderInner.append(responseHtml);
		};
		
		return {
			init: function() {
				if(holder.length) {
					holder.each(function() {
						var thisHolder = $(this);
						
						if(thisHolder.hasClass('mkd-blog-pagination-load-more')) {
							initLoadMorePagination(thisHolder);
						}
						
						if(thisHolder.hasClass('mkd-blog-pagination-infinite-scroll')) {
							initInifiteScrollPagination(thisHolder);
						}
					});
				}
			},
			scroll: function() {
				if(holder.length) {
					holder.each(function() {
						var thisHolder = $(this);
						
						if(thisHolder.hasClass('mkd-blog-pagination-infinite-scroll')) {
							initInifiteScrollPagination(thisHolder);
						}
					});
				}
			}
		};
	}

})(jQuery);
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
(function($) {
	"use strict";
	
	var header = {};
	mkd.modules.header = header;
	
	header.mkdSetDropDownMenuPosition     = mkdSetDropDownMenuPosition;
	header.mkdSetDropDownWideMenuPosition = mkdSetDropDownWideMenuPosition;
	
	header.mkdOnDocumentReady = mkdOnDocumentReady;
	header.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(document).ready(mkdOnDocumentReady);
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdSetDropDownMenuPosition();
		mkdDropDownMenu();
	}
	
	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {
		mkdSetDropDownWideMenuPosition();
	}
	
	/**
	 * Set dropdown position
	 */
	function mkdSetDropDownMenuPosition() {
		var menuItems = $('.mkd-drop-down > ul > li.narrow.menu-item-has-children');
		
		if (menuItems.length) {
			menuItems.each(function (i) {
				var thisItem = $(this),
					menuItemPosition = thisItem.offset().left,
					dropdownHolder = thisItem.find('.second'),
					dropdownMenuItem = dropdownHolder.find('.inner ul'),
					dropdownMenuWidth = dropdownMenuItem.outerWidth(),
					menuItemFromLeft = mkd.windowWidth - menuItemPosition;
				
				if (mkd.body.hasClass('mkd-boxed')) {
					menuItemFromLeft = mkd.boxedLayoutWidth - (menuItemPosition - (mkd.windowWidth - mkd.boxedLayoutWidth ) / 2);
				}
				
				var dropDownMenuFromLeft; //has to stay undefined beacuse 'dropDownMenuFromLeft < dropdownMenuWidth' condition will be true
				
				if (thisItem.find('li.sub').length > 0) {
					dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
				}
				
				dropdownHolder.removeClass('right');
				dropdownMenuItem.removeClass('right');
				if (menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth) {
					dropdownHolder.addClass('right');
					dropdownMenuItem.addClass('right');
				}
			});
		}
	}
	
	/**
	 * Set dropdown wide position
	 */
	function mkdSetDropDownWideMenuPosition(){
		var menuItems = $(".mkd-drop-down > ul > li.wide");
		
		if(menuItems.length) {
			menuItems.each( function(i) {
				var menuItemSubMenu = $(menuItems[i]).find('.second');
				
				if(menuItemSubMenu.length && !menuItemSubMenu.hasClass('left_position') && !menuItemSubMenu.hasClass('right_position')) {
					menuItemSubMenu.css('left', 0);
					
					var left_position = menuItemSubMenu.offset().left;
					
					if(mkd.body.hasClass('mkd-boxed')) {
						var boxedWidth = $('.mkd-boxed .mkd-wrapper .mkd-wrapper-inner').outerWidth();
						left_position = left_position - (mkd.windowWidth - boxedWidth) / 2;
						
						menuItemSubMenu.css('left', -left_position);
						menuItemSubMenu.css('width', boxedWidth);
					} else {
						menuItemSubMenu.css('left', -left_position);
						menuItemSubMenu.css('width', mkd.windowWidth);
					}
				}
			});
		}
	}
	
	function mkdDropDownMenu() {
		var menu_items = $('.mkd-drop-down > ul > li');
		
		menu_items.each(function(i) {
			if($(menu_items[i]).find('.second').length > 0) {
				var thisItem = $(menu_items[i]),
					dropDownSecondDiv = thisItem.find('.second');
				
				if(thisItem.hasClass('wide')) {
					//set columns to be same height - start
					var tallest = 0,
						dropDownSecondItem = $(this).find('.second > .inner > ul > li');
					
					dropDownSecondItem.each(function() {
						var thisHeight = $(this).height();
						if(thisHeight > tallest) {
							tallest = thisHeight;
						}
					});
					
					dropDownSecondItem.css('height', ''); // delete old inline css - via resize
					dropDownSecondItem.height(tallest);
					//set columns to be same height - end
				}
				
				if(!mkd.menuDropdownHeightSet) {
					thisItem.data('original_height', dropDownSecondDiv.height() + 'px');
					dropDownSecondDiv.height(0);
				}
				
				if(navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
					thisItem.on("touchstart mouseenter", function() {
						dropDownSecondDiv.css({
							'height': thisItem.data('original_height'),
							'overflow': 'visible',
							'visibility': 'visible',
							'opacity': '1'
						});
					}).on("mouseleave", function() {
						dropDownSecondDiv.css({
							'height': '0px',
							'overflow': 'hidden',
							'visibility': 'hidden',
							'opacity': '0'
						});
					});
				} else {
					if(mkd.body.hasClass('mkd-dropdown-animate-height')) {
                        var config = {
                            interval: 0,
                            over: function() {
                                dropDownSecondDiv.css({
                                    'visibility': 'visible',
                                    'height': '0px',
                                    'opacity': '0'
                                });
                                dropDownSecondDiv.stop().animate({
                                    'height': thisItem.data('original_height'),
                                    opacity: 1
                                }, 300, function() {
                                    dropDownSecondDiv.css('overflow', 'visible');
                                });
                            },
                            timeout: 150,
                            out: function() {
                                dropDownSecondDiv.stop().animate({
                                    'height': '0px'
                                }, 150, function() {
                                    dropDownSecondDiv.css({
                                        'overflow': 'hidden',
                                        'visibility': 'hidden'
                                    });
                                });
                            }
                        };
                        thisItem.hoverIntent(config);
                    } else {
                        var config = {
                            interval: 0,
                            over: function() {
                                setTimeout(function() {
                                    dropDownSecondDiv.addClass('mkd-drop-down-start');
                                    dropDownSecondDiv.stop().css({'height': thisItem.data('original_height')});
                                }, 150);
                            },
                            timeout: 150,
                            out: function() {
                                dropDownSecondDiv.stop().css({'height': '0px'});
                                dropDownSecondDiv.removeClass('mkd-drop-down-start');
                            }
                        };
                        thisItem.hoverIntent(config);
                    }
				}
			}
		});
		
		$('.mkd-drop-down ul li.wide ul li a').on('click', function(e) {
			if (e.which == 1){
				var $this = $(this);
				setTimeout(function() {
					$this.mouseleave();
				}, 500);
			}
		});
		
		mkd.menuDropdownHeightSet = true;
	}
	
})(jQuery);

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

(function($) {
    "use strict";

    var title = {};
    mkd.modules.title = title;

    title.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
	    mkdParallaxTitle();
    }

    /*
     **	Title image with parallax effect
     */
	function mkdParallaxTitle() {
		var parallaxBackground = $('.mkd-title-holder.mkd-bg-parallax');
		
		if (parallaxBackground.length > 0 && mkd.windowWidth > 1024) {
			var parallaxBackgroundWithZoomOut = parallaxBackground.hasClass('mkd-bg-parallax-zoom-out'),
				titleHeight = parseInt(parallaxBackground.data('height')),
				imageWidth = parseInt(parallaxBackground.data('background-width')),
				parallaxRate = titleHeight / 10000 * 7,
				parallaxYPos = -(mkd.scroll * parallaxRate),
				adminBarHeight = mkdGlobalVars.vars.mkdAddForAdminBar;
			
			parallaxBackground.css({'background-position': 'center ' + (parallaxYPos + adminBarHeight) + 'px'});
			
			if (parallaxBackgroundWithZoomOut) {
				parallaxBackground.css({'background-size': imageWidth - mkd.scroll + 'px auto'});
			}
			
			//set position of background on window scroll
			$(window).scroll(function () {
				parallaxYPos = -(mkd.scroll * parallaxRate);
				parallaxBackground.css({'background-position': 'center ' + (parallaxYPos + adminBarHeight) + 'px'});
				
				if (parallaxBackgroundWithZoomOut) {
					parallaxBackground.css({'background-size': imageWidth - mkd.scroll + 'px auto'});
				}
			});
		}
	}

})(jQuery);

(function($) {
    'use strict';

    var woocommerce = {};
    mkd.modules.woocommerce = woocommerce;

    woocommerce.mkdOnDocumentReady = mkdOnDocumentReady;
    woocommerce.mkdOnWindowLoad = mkdOnWindowLoad;
    woocommerce.mkdOnWindowResize = mkdOnWindowResize;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkdInitQuantityButtons();
        mkdInitSelect2();
	    mkdInitSingleProductLightbox();
	    mkdPrevNextpagination();
	    mkdSetWooCategoriesHeight();
	    mkdParallaxPtfText();
	    mkdProductCarouselNavPosition();
	    mkdDropdownCartScroll();
        mkdDropdownCart();
    }

    /* 
        All functions to be called on $(window).load() should be in this function
    */
    function mkdOnWindowLoad() {
        mkdInitProductListMasonryShortcode();
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function mkdOnWindowResize() {
        mkdInitProductListMasonryShortcode();
        mkdSetWooCategoriesHeight();
    }
	
    /*
    ** Init quantity buttons to increase/decrease products for cart
    */
	function mkdInitQuantityButtons() {
		$(document).on('click', '.mkd-quantity-minus, .mkd-quantity-plus', function (e) {
			e.stopPropagation();
			
			var button = $(this),
				inputField = button.siblings('.mkd-quantity-input'),
				step = parseFloat(inputField.data('step')),
				max = parseFloat(inputField.data('max')),
				minus = false,
				inputValue = parseFloat(inputField.val()),
				newInputValue;
			
			if (button.hasClass('mkd-quantity-minus')) {
				minus = true;
			}
			
			if (minus) {
				newInputValue = inputValue - step;
				if (newInputValue >= 1) {
					inputField.val(newInputValue);
				} else {
					inputField.val(0);
				}
			} else {
				newInputValue = inputValue + step;
				if (max === undefined) {
					inputField.val(newInputValue);
				} else {
					if (newInputValue >= max) {
						inputField.val(max);
					} else {
						inputField.val(newInputValue);
					}
				}
			}
			
			inputField.trigger('change');
		});
	}

    /*
    ** Init select2 script for select html dropdowns
    */
	function mkdInitSelect2() {
		var orderByDropDown = $('.woocommerce-ordering .orderby');
		if (orderByDropDown.length) {
			orderByDropDown.select2({
				minimumResultsForSearch: Infinity
			});
		}
		
		var variableProducts = $('.mkd-woocommerce-page .mkd-content .variations td.value select');
		if (variableProducts.length) {
			variableProducts.select2();
		}
		
		var shippingCountryCalc = $('#calc_shipping_country');
		if (shippingCountryCalc.length) {
			shippingCountryCalc.select2();
		}
		
		var shippingStateCalc = $('.cart-collaterals .shipping select#calc_shipping_state');
		if (shippingStateCalc.length) {
			shippingStateCalc.select2();
		}
	}
	
	/*
	 ** Init Product Single Pretty Photo attributes
	 */
	function mkdInitSingleProductLightbox() {
		var item = $('.mkd-woo-single-page.mkd-woo-single-has-pretty-photo .images .woocommerce-product-gallery__image');
		
		if(item.length) {
			item.children('a').attr('data-rel', 'prettyPhoto[woo_single_pretty_photo]');
			
			if (typeof mkd.modules.common.mkdPrettyPhoto === "function") {
				mkd.modules.common.mkdPrettyPhoto();
			}
		}
	}
	
	/*
	 ** Init Product List Masonry Shortcode Layout
	 */
	function mkdInitProductListMasonryShortcode() {
		var container = $('.mkd-pl-holder.mkd-masonry-layout .mkd-pl-outer');
		
		if (container.length) {
			container.each(function () {
				var thisContainer = $(this);
				
				thisContainer.waitForImages(function () {
					thisContainer.isotope({
						itemSelector: '.mkd-pli',
						resizable: false,
						masonry: {
							columnWidth: '.mkd-pl-sizer',
							gutter: '.mkd-pl-gutter'
						}
					});
					
					setTimeout(function () {
						if (typeof mkd.modules.common.mkdInitParallax === "function") {
							mkd.modules.common.mkdInitParallax();
						}
					}, 1000);
					
					thisContainer.isotope('layout').css('opacity', 1);
				});
			});
		}
	}

	function mkdPrevNextpagination() {
		$('.woocommerce-pagination .page-numbers li a.prev').parent().addClass('prev');
		$('.woocommerce-pagination .page-numbers li a.next').parent().addClass('next');
	}

	function mkdSetWooCategoriesHeight() {

        var holder = $('.mkd-floating-prod-cats-holder');

        if(holder.length){
            holder.each(function () {

                var thisHolder = $(this),
                items = thisHolder.find('.mkd-floating-prod-cat'),
                imageHeight = thisHolder.find('.mkd-floating-cat-image');

                if(items.length){
                    var height = imageHeight.height();
                    if(typeof height !== 'undefined' && height !== '' && height !=='undefined'){
                        items.height(height);
                        items.addClass('show');
                    }
                }

            });
        }
	}

	/**
	 * Parallax Pft text
	 * @type {Function}
	 */

	function mkdParallaxPtfText() {
	    var parallaxLists = $('.mkd-prod-cats-holder.mkd-parallax-items');


	    if (parallaxLists.length && !mkd.htmlEl.hasClass('touch')) {
	        parallaxLists.each(function(){

	            var parallaxList = $(this),
	                categories = parallaxList.find('.mkd-prod-cat'),
	                yOffset = parallaxList.attr('data-y-axis-translation'),
	                negative = false;

	            if (yOffset < 0) {
	                negative = true;
	            }

	            categories.each(function(){
	                var category = $(this),
	                    categoryHeight = category.outerHeight(),
	                    categoryInner = category.find('.mkd-prod-cat-inner'),
	                    categoryInnerHeight = categoryInner.height(),
	                    delta = yOffset;

	                if (negative) {
	                     delta = -delta;
	                }

	                var dataParallax = '{"y":'+delta+', "smoothness":20}';
	                categoryInner.attr('data-parallax', dataParallax);
	            });
	        });

	        setTimeout(function(){
	            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
	        }, 100); //wait for calcs
	    }
	}

	function  mkdProductCarouselNavPosition() {
		setTimeout(function(){ 
			var textHolderHeight = $('.mkd-plc-holder .mkd-plc-text-wrapper').outerHeight(true);
    	    var HolderHeight = $('.mkd-plc-holder').height();
    	    var NavPosition = (HolderHeight - textHolderHeight)/2 + 'px';
    	    var NavItems = $('.mkd-plc-holder .mkd-owl-slider .owl-nav .owl-prev,.mkd-plc-holder .mkd-owl-slider .owl-nav .owl-next');

    	    $(NavItems).css({ top: NavPosition })

		}, 100);
	}

	$( document ).ajaxComplete(function() {
	   mkdDropdownCart();
	});

	/**
	 * Show/hide dropdown cart
	 */
	function mkdDropdownCart() {
		var wrapper = $('.mkd-wrapper'),
			dropdownCartOpen = $('a.mkd-header-cart'),
			cssClass = 'mkd-shopping-cart-dropdown-opened';

		var initDropDownCartLogic = function (item) {
			if(!item.hasClass('opened')) {
				item.addClass('opened');
				mkd.body.addClass(cssClass);
				
				var currentScroll = $(window).scrollTop();
				$(window).scroll(function() {
					if(Math.abs(mkd.scroll - currentScroll) > 400){
						mkd.body.removeClass(cssClass);
						item.removeClass('opened');
					}
				});
			} else {
				item.removeClass('opened');
				mkd.body.removeClass(cssClass);
			}
		}
		
		if (dropdownCartOpen.length) {
			dropdownCartOpen.each(function(){
				var thisItem = $(this),
					closeIcon = $('.mkd-header-cart-close');

				wrapper.prepend('<div class="mkd-cover"/>');

				thisItem.on('click', function(e) {
					e.preventDefault();
					
					var item = $(this);

					initDropDownCartLogic(item);

					$('.mkd-wrapper .mkd-cover').on('click', function() {
						mkd.body.removeClass('mkd-shopping-cart-dropdown-opened');
						item.removeClass('opened');
					});
				});

				closeIcon.on('click', function(){
					initDropDownCartLogic(thisItem);
				});
			});
		}
	}
	
	/*
	 **  Smooth scroll functionality for dropdown cart
	 */
	function mkdDropdownCartScroll(){
		var dropdownCart = $('.mkd-shopping-cart-dropdown');
		
		if(dropdownCart.length){
            dropdownCart.perfectScrollbar({
                wheelSpeed: 0.6,
                suppressScrollX: true
            });
		}
	}

})(jQuery);
(function($) {
    "use strict";

    var blogListSC = {};
    mkd.modules.blogListSC = blogListSC;

    blogListSC.mkdOnDocumentReady = mkdOnDocumentReady;
    blogListSC.mkdOnWindowLoad = mkdOnWindowLoad;
    blogListSC.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).scroll(mkdOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitBlogListMasonry();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function mkdOnWindowLoad() {
        mkdInitBlogListShortcodePagination().init();
    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function mkdOnWindowScroll() {
        mkdInitBlogListShortcodePagination().scroll();
    }

    /**
     * Init blog list shortcode masonry layout
     */
    function mkdInitBlogListMasonry() {
        var holder = $('.mkd-blog-list-holder.mkd-bl-masonry');

        if(holder.length){
            holder.each(function(){
                var thisHolder = $(this),
                    masonry = thisHolder.find('.mkd-blog-list');

                masonry.waitForImages(function() {
                    masonry.isotope({
                        layoutMode: 'packery',
                        itemSelector: '.mkd-bl-item',
                        percentPosition: true,
                        packery: {
                            gutter: '.mkd-bl-grid-gutter',
                            columnWidth: '.mkd-bl-grid-sizer'
                        }
                    });

                    masonry.css('opacity', '1');
                });
            });
        }
    }

    /**
     * Init blog list shortcode pagination functions
     */
    function mkdInitBlogListShortcodePagination(){
        var holder = $('.mkd-blog-list-holder');

        var initStandardPagination = function(thisHolder) {
            var standardLink = thisHolder.find('.mkd-bl-standard-pagination li');

            if(standardLink.length) {
                standardLink.each(function(){
                    var thisLink = $(this).children('a'),
                        pagedLink = 1;

                    thisLink.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (typeof thisLink.data('paged') !== 'undefined' && thisLink.data('paged') !== false) {
                            pagedLink = thisLink.data('paged');
                        }

                        initMainPagFunctionality(thisHolder, pagedLink);
                    });
                });
            }
        };

        var initLoadMorePagination = function(thisHolder) {
            var loadMoreButton = thisHolder.find('.mkd-blog-pag-load-more a');

            loadMoreButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                initMainPagFunctionality(thisHolder);
            });
        };

        var initInifiteScrollPagination = function(thisHolder) {
            var blogListHeight = thisHolder.outerHeight(),
                blogListTopOffest = thisHolder.offset().top,
                blogListPosition = blogListHeight + blogListTopOffest - mkdGlobalVars.vars.mkdAddForAdminBar;

            if(!thisHolder.hasClass('mkd-bl-pag-infinite-scroll-started') && mkd.scroll + mkd.windowHeight > blogListPosition) {
                initMainPagFunctionality(thisHolder);
            }
        };

        var initMainPagFunctionality = function(thisHolder, pagedLink) {
            var thisHolderInner = thisHolder.find('.mkd-blog-list'),
                nextPage,
                maxNumPages;

            if (typeof thisHolder.data('max-num-pages') !== 'undefined' && thisHolder.data('max-num-pages') !== false) {
                maxNumPages = thisHolder.data('max-num-pages');
            }

            if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                thisHolder.data('next-page', pagedLink);
            }

            if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                thisHolder.addClass('mkd-bl-pag-infinite-scroll-started');
            }

            var loadMoreDatta = mkd.modules.common.getLoadMoreData(thisHolder),
                loadingItem = thisHolder.find('.mkd-blog-pag-loading');

            nextPage = loadMoreDatta.nextPage;

            if(nextPage <= maxNumPages){
                if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                    loadingItem.addClass('mkd-showing mkd-standard-pag-trigger');
                    thisHolder.addClass('mkd-bl-pag-standard-shortcodes-animate');
                } else {
                    loadingItem.addClass('mkd-showing');
                }

                var ajaxData = mkd.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'entre_mikado_blog_shortcode_load_more');

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: mkdGlobalVars.vars.mkdAjaxUrl,
                    success: function (data) {
                        if(!thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            nextPage++;
                        }

                        thisHolder.data('next-page', nextPage);

                        var response = $.parseJSON(data),
                            responseHtml =  response.html;

                        if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            mkdInitStandardPaginationLinkChanges(thisHolder, maxNumPages, nextPage);

                            thisHolder.waitForImages(function(){
                                if(thisHolder.hasClass('mkd-bl-masonry')){
                                    mkdInitHtmlIsotopeNewContent(thisHolder, thisHolderInner, loadingItem, responseHtml);
                                } else {
                                    mkdInitHtmlGalleryNewContent(thisHolder, thisHolderInner, loadingItem, responseHtml);

                                    if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                                        mkd.modules.common.mkdStickySidebarWidget().reInit();
                                    }
                                }
                            });
                        } else {
                            thisHolder.waitForImages(function(){
                                if(thisHolder.hasClass('mkd-bl-masonry')){
                                    mkdInitAppendIsotopeNewContent(thisHolderInner, loadingItem, responseHtml);
                                } else {
                                    mkdInitAppendGalleryNewContent(thisHolderInner, loadingItem, responseHtml);

                                    if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                                        mkd.modules.common.mkdStickySidebarWidget().reInit();
                                    }
                                }
                            });
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll-started')) {
                            thisHolder.removeClass('mkd-bl-pag-infinite-scroll-started');
                        }
                    }
                });
            }

            if(nextPage === maxNumPages){
                thisHolder.find('.mkd-blog-pag-load-more').hide();
            }
        };

        var mkdInitStandardPaginationLinkChanges = function(thisHolder, maxNumPages, nextPage) {
            var standardPagHolder = thisHolder.find('.mkd-bl-standard-pagination'),
                standardPagNumericItem = standardPagHolder.find('li.mkd-bl-pag-number'),
                standardPagPrevItem = standardPagHolder.find('li.mkd-bl-pag-prev a'),
                standardPagNextItem = standardPagHolder.find('li.mkd-bl-pag-next a');

            standardPagNumericItem.removeClass('mkd-bl-pag-active');
            standardPagNumericItem.eq(nextPage-1).addClass('mkd-bl-pag-active');

            standardPagPrevItem.data('paged', nextPage-1);
            standardPagNextItem.data('paged', nextPage+1);

            if(nextPage > 1) {
                standardPagPrevItem.css({'opacity': '1'});
            } else {
                standardPagPrevItem.css({'opacity': '0'});
            }

            if(nextPage === maxNumPages) {
                standardPagNextItem.css({'opacity': '0'});
            } else {
                standardPagNextItem.css({'opacity': '1'});
            }
        };

        var mkdInitHtmlIsotopeNewContent = function(thisHolder, thisHolderInner, loadingItem, responseHtml) {
            thisHolderInner.html(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
            loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
            thisHolder.removeClass('mkd-bl-pag-standard-shortcodes-animate');

            setTimeout(function() {
                thisHolderInner.isotope('layout');

                if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                    mkd.modules.common.mkdStickySidebarWidget().reInit();
                }
            }, 600);
        };

        var mkdInitHtmlGalleryNewContent = function(thisHolder, thisHolderInner, loadingItem, responseHtml) {
            loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
            thisHolder.removeClass('mkd-bl-pag-standard-shortcodes-animate');
            thisHolderInner.html(responseHtml);
        };

        var mkdInitAppendIsotopeNewContent = function(thisHolderInner, loadingItem, responseHtml) {
            thisHolderInner.append(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
            loadingItem.removeClass('mkd-showing');

            setTimeout(function() {
                thisHolderInner.isotope('layout');

                if (typeof mkd.modules.common.mkdStickySidebarWidget === 'function') {
                    mkd.modules.common.mkdStickySidebarWidget().reInit();
                }
            }, 600);
        };

        var mkdInitAppendGalleryNewContent = function(thisHolderInner, loadingItem, responseHtml) {
            loadingItem.removeClass('mkd-showing');
            thisHolderInner.append(responseHtml);
        };

        return {
            init: function() {
                if(holder.length) {
                    holder.each(function() {
                        var thisHolder = $(this);

                        if(thisHolder.hasClass('mkd-bl-pag-standard-shortcodes')) {
                            initStandardPagination(thisHolder);
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-load-more')) {
                            initLoadMorePagination(thisHolder);
                        }

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisHolder);
                        }
                    });
                }
            },
            scroll: function() {
                if(holder.length) {
                    holder.each(function() {
                        var thisHolder = $(this);

                        if(thisHolder.hasClass('mkd-bl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisHolder);
                        }
                    });
                }
            }
        };
    }

})(jQuery);
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
(function($) {
    "use strict";

    var headerMinimal = {};
    mkd.modules.headerMinimal = headerMinimal;
	
	headerMinimal.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkdFullscreenMenu();
    }

    /**
     * Init Fullscreen Menu
     */
    function mkdFullscreenMenu() {
	    var popupMenuOpener = $( 'a.mkd-fullscreen-menu-opener');
	    
        if (popupMenuOpener.length) {
            var popupMenuHolderOuter = $(".mkd-fullscreen-menu-holder-outer"),
                cssClass,
            //Flags for type of animation
                fadeRight = false,
                fadeTop = false,
            //Widgets
                widgetAboveNav = $('.mkd-fullscreen-above-menu-widget-holder'),
                widgetBelowNav = $('.mkd-fullscreen-below-menu-widget-holder'),
            //Menu
                menuItems = $('.mkd-fullscreen-menu-holder-outer nav > ul > li > a'),
                menuItemWithChild =  $('.mkd-fullscreen-menu > ul li.has_sub > a'),
                menuItemWithoutChild = $('.mkd-fullscreen-menu ul li:not(.has_sub) a');

            //set height of popup holder on resize
            $(window).resize(function() {
                popupMenuHolderOuter.height(mkd.windowHeight);
            });

            if (mkd.body.hasClass('mkd-fade-push-text-right')) {
                cssClass = 'mkd-push-nav-right';
                fadeRight = true;
            } else if (mkd.body.hasClass('mkd-fade-push-text-top')) {
                cssClass = 'mkd-push-text-top';
                fadeTop = true;
            }

            //Appearing animation
            if (fadeRight || fadeTop) {
                if (widgetAboveNav.length) {
                    widgetAboveNav.children().css({
                        '-webkit-animation-delay' : 0 + 'ms',
                        '-moz-animation-delay' : 0 + 'ms',
                        'animation-delay' : 0 + 'ms'
                    });
                }
                menuItems.each(function(i) {
                    $(this).css({
                        '-webkit-animation-delay': (i+1) * 70 + 'ms',
                        '-moz-animation-delay': (i+1) * 70 + 'ms',
                        'animation-delay': (i+1) * 70 + 'ms'
                    });
                });
                if (widgetBelowNav.length) {
                    widgetBelowNav.children().css({
                        '-webkit-animation-delay' : (menuItems.length + 1)*70 + 'ms',
                        '-moz-animation-delay' : (menuItems.length + 1)*70 + 'ms',
                        'animation-delay' : (menuItems.length + 1)*70 + 'ms'
                    });
                }
            }

            // Open popup menu
            popupMenuOpener.on('click',function(e){
                e.preventDefault();

                if (!popupMenuOpener.hasClass('mkd-fm-opened')) {
                    popupMenuOpener.addClass('mkd-fm-opened');
                    mkd.body.removeClass('mkd-fullscreen-fade-out').addClass('mkd-fullscreen-menu-opened mkd-fullscreen-fade-in');
                    mkd.body.removeClass(cssClass);
                    mkd.modules.common.mkdDisableScroll();
                    
                    $(document).keyup(function(e){
                        if (e.keyCode == 27 ) {
                            popupMenuOpener.removeClass('mkd-fm-opened');
                            mkd.body.removeClass('mkd-fullscreen-menu-opened mkd-fullscreen-fade-in').addClass('mkd-fullscreen-fade-out');
                            mkd.body.addClass(cssClass);
                            mkd.modules.common.mkdEnableScroll();

                            $("nav.mkd-fullscreen-menu ul.sub_menu").slideUp(200);
                        }
                    });
                } else {
                    popupMenuOpener.removeClass('mkd-fm-opened');
                    mkd.body.removeClass('mkd-fullscreen-menu-opened mkd-fullscreen-fade-in').addClass('mkd-fullscreen-fade-out');
                    mkd.body.addClass(cssClass);
                    mkd.modules.common.mkdEnableScroll();

                    $("nav.mkd-fullscreen-menu ul.sub_menu").slideUp(200);
                }
            });

            //logic for open sub menus in popup menu
            menuItemWithChild.on('tap click', function(e) {
                e.preventDefault();

                var thisItem = $(this),
	                thisItemParent = thisItem.parent(),
					thisItemParentSiblingsWithDrop = thisItemParent.siblings('.menu-item-has-children');

                if (thisItemParent.hasClass('has_sub')) {
	                var submenu = thisItemParent.find('> ul.sub_menu');
	
	                if (submenu.is(':visible')) {
		                submenu.slideUp(650, 'easeInOutQuint');
		                thisItemParent.removeClass('open_sub');
	                } else {
		                thisItemParent.addClass('open_sub');
		
		                if(thisItemParentSiblingsWithDrop.length === 0) {
			                submenu.slideDown(600, 'easeInOutQuint');
		                } else {
							thisItemParent.closest('li.menu-item').siblings().find('.menu-item').removeClass('open_sub');
			                thisItemParent.siblings().removeClass('open_sub').find('.sub_menu').slideUp(600, 'easeInOutQuint', function() {
				                submenu.slideDown(600, 'easeInOutQuint');
			                });
		                }
	                }
                }
                
                return false;
            });

            //if link has no submenu and if it's not dead, than open that link
            menuItemWithoutChild.on('click', function (e) {
                if(($(this).attr('href') !== "http://#") && ($(this).attr('href') !== "#")){
                    if (e.which == 1) {
                        popupMenuOpener.removeClass('mkd-fm-opened');
                        mkd.body.removeClass('mkd-fullscreen-menu-opened');
                        mkd.body.removeClass('mkd-fullscreen-fade-in').addClass('mkd-fullscreen-fade-out');
                        mkd.body.addClass(cssClass);
                        $("nav.mkd-fullscreen-menu ul.sub_menu").slideUp(200);
                        mkd.modules.common.mkdEnableScroll();
                    }
                } else {
                    return false;
                }
            });
        }
    }

})(jQuery);
(function($) {
    "use strict";

    var headerVertical = {};
    mkd.modules.headerVertical = headerVertical;
	
	headerVertical.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkdVerticalMenu().init();
    }

    /**
     * Function object that represents vertical menu area.
     * @returns {{init: Function}}
     */
    var mkdVerticalMenu = function() {
	    var verticalMenuObject = $('.mkd-vertical-menu-area');

	    /**
	     * Checks if vertical area is scrollable (if it has mkd-with-scroll class)
	     *
	     * @returns {bool}
	     */
	    var verticalAreaScrollable = function () {
		    return verticalMenuObject.hasClass('mkd-with-scroll');
	    };
	
	    /**
	     * Initialzes navigation functionality. It checks navigation type data attribute and calls proper functions
	     */
	    var initNavigation = function () {
		    var verticalNavObject = verticalMenuObject.find('.mkd-vertical-menu');
		
		    dropdownClickToggle();
		
		    /**
		     * Initializes click toggle navigation type. Works the same for touch and no-touch devices
		     */
		    function dropdownClickToggle() {
			    var menuItems = verticalNavObject.find('ul li.menu-item-has-children');
			
			    menuItems.each(function () {
				    var elementToExpand = $(this).find(' > .second, > ul');
				    var menuItem = this;
				    var dropdownOpener = $(this).find('> a');
				    var slideUpSpeed = 'fast';
				    var slideDownSpeed = 'slow';
				
				    dropdownOpener.on('click tap', function (e) {
					    e.preventDefault();
					    e.stopPropagation();
					
					    if (elementToExpand.is(':visible')) {
						    $(menuItem).removeClass('open');
						    elementToExpand.slideUp(slideUpSpeed);
					    } else if (dropdownOpener.parent().parent().children().hasClass('open') && dropdownOpener.parent().parent().parent().hasClass('mkd-vertical-menu')) {
						    $(this).parent().parent().children().removeClass('open');
						    $(this).parent().parent().children().find(' > .second').slideUp(slideUpSpeed);
						
						    $(menuItem).addClass('open');
						    elementToExpand.slideDown(slideDownSpeed);
					    } else {
						
						    if (!$(this).parents('li').hasClass('open')) {
							    menuItems.removeClass('open');
							    menuItems.find(' > .second, > ul').slideUp(slideUpSpeed);
						    }
						
						    if ($(this).parent().parent().children().hasClass('open')) {
							    $(this).parent().parent().children().removeClass('open');
							    $(this).parent().parent().children().find(' > .second, > ul').slideUp(slideUpSpeed);
						    }
						
						    $(menuItem).addClass('open');
						    elementToExpand.slideDown(slideDownSpeed);
					    }
				    });
			    });
		    }
	    };

        /**
         * Initializes scrolling in vertical area. It checks if vertical area is scrollable before doing so
         */
        var initVerticalAreaScroll = function() {
            if(verticalAreaScrollable()) {
                verticalMenuObject.perfectScrollbar({
                    wheelSpeed: 0.6,
                    suppressScrollX: true
                });
            }
        };

        var initHiddenVerticalArea = function() {
            var verticalLogo = $('.mkd-vertical-area-bottom-logo');
            var verticalMenuOpener = verticalMenuObject.find('.mkd-vertical-area-opener');
            var scrollPosition = 0;

            verticalMenuOpener.on('click tap', function() {
                if(isVerticalAreaOpen()) {
                    closeVerticalArea();
                } else {
                    openVerticalArea();
                }
            });

            $(window).scroll(function() {
                if(Math.abs($(window).scrollTop() - scrollPosition) > 400){
                    closeVerticalArea();
                }
            });

            /**
             * Closes vertical menu area by removing 'active' class on that element
             */
            function closeVerticalArea() {
                verticalMenuObject.removeClass('active');

                if(verticalLogo.length) {
                    verticalLogo.removeClass('active');
                }
            }

            /**
             * Opens vertical menu area by adding 'active' class on that element
             */
            function openVerticalArea() {
                verticalMenuObject.addClass('active');

                if(verticalLogo.length) {
                    verticalLogo.addClass('active');
                }
                scrollPosition = $(window).scrollTop();
            }

            function isVerticalAreaOpen() {
                return verticalMenuObject.hasClass('active');
            }
        };

        return {
            /**
             * Calls all necessary functionality for vertical menu area if vertical area object is valid
             */
            init: function() {
                if(verticalMenuObject.length) {
                    initNavigation();
                    initVerticalAreaScroll();

                    if(mkd.body.hasClass('mkd-header-vertical-closed')) {
                        initHiddenVerticalArea();
                    }
                }
            }
        };
    };

})(jQuery);
(function($) {
    "use strict";

    var headerVerticalSliding = {};
    mkd.modules.headerVerticalSliding = headerVerticalSliding;
	
	headerVerticalSliding.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function mkdOnDocumentReady() {
        mkdVerticalSlidingMenu().init();
    }

    /**
     * Function object that represents vertical menu area.
     * @returns {{init: Function}}
     */
    var mkdVerticalSlidingMenu = function() {
	    var verticalMenuObject = $('.mkd-header-vertical-sliding .mkd-vertical-menu-area');
	
	    var initNavigation = function () {
		    var varticalMenuOpener = verticalMenuObject.find('.mkd-vertical-menu-opener a'),
			    verticalMenuNavHolder = verticalMenuObject.find('.mkd-vertical-menu-nav-holder-outer'),
			    menuItemWithChild = verticalMenuObject.find('.mkd-fullscreen-menu > ul li.has_sub > a'),
			    menuItemWithoutChild = verticalMenuObject.find('.mkd-fullscreen-menu ul li:not(.has_sub) a');
		
		    //set height of vertical menu holder and initialize perfectScrollbar
		    verticalMenuNavHolder.height(mkd.windowHeight);
            verticalMenuNavHolder.perfectScrollbar({
                wheelSpeed: 0.6,
                suppressScrollX: true
            });
		
		    //set height of vertical menu holder on resize
		    $(window).resize(function () {
			    verticalMenuNavHolder.height(mkd.windowHeight);
		    });
		
		    varticalMenuOpener.on('click', function (e) {
			    e.preventDefault();
			
			    if (!verticalMenuNavHolder.hasClass('active')) {
				    verticalMenuNavHolder.addClass('active');
				    verticalMenuObject.addClass('opened');
				    if (!mkd.body.hasClass('page-template-full_screen-php')) {
					    mkd.modules.common.mkdDisableScroll();
				    }
			    } else {
				    verticalMenuNavHolder.removeClass('active');
				    verticalMenuObject.removeClass('opened');
				    if (!mkd.body.hasClass('page-template-full_screen-php')) {
					    mkd.modules.common.mkdEnableScroll();
				    }
			    }
		    });
		
		    $('.mkd-content').on('click', function () {
			    if (verticalMenuNavHolder.hasClass('active')) {
				    verticalMenuNavHolder.removeClass('active');
				    verticalMenuObject.removeClass('opened');
				    if (!mkd.body.hasClass('page-template-full_screen-php')) {
					    mkd.modules.common.mkdEnableScroll();
				    }
			    }
		    });
		
		    //logic for open sub menus in popup menu
		    menuItemWithChild.on('tap click', function (e) {
			    e.preventDefault();
			
			    if ($(this).parent().hasClass('has_sub')) {
				    var submenu = $(this).parent().find('> ul.sub_menu');
				    
				    if (submenu.is(':visible')) {
					    submenu.slideUp(200);
					    $(this).parent().removeClass('open_sub');
				    } else {
					    if ($(this).parent().siblings().hasClass('open_sub')) {
						    $(this).parent().siblings().each(function () {
							    var sibling = $(this);
							    if (sibling.hasClass('open_sub')) {
								    var openedUl = sibling.find('> ul.sub_menu');
								    openedUl.slideUp(200);
								    sibling.removeClass('open_sub');
							    }
							    if (sibling.find('.open_sub')) {
								    var openedUlUl = sibling.find('.open_sub').find('> ul.sub_menu');
								    openedUlUl.slideUp(200);
								    sibling.find('.open_sub').removeClass('open_sub');
							    }
						    });
					    }
					
					    $(this).parent().addClass('open_sub');
					    submenu.slideDown(200);
				    }
			    }
			    return false;
		    });
		
	    };
	
	    return {
		    /**
		     * Calls all necessary functionality for vertical menu area if vertical area object is valid
		     */
		    init: function () {
			    if (verticalMenuObject.length) {
				    initNavigation();
				
			    }
		    }
	    };
    };

})(jQuery);
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

(function($) {
	'use strict';
	
	$(document).ready(function(){
        mkdParallaxElements();
	});
	
	/**
	 * Parallax Pft text
	 * @type {Function}
	 */

	function mkdParallaxElements() {
	    var parallaxLists = $('.mkd-floating-prod-cats-holder.mkd-parallax-items');

	    if (parallaxLists.length && !mkd.htmlEl.hasClass('touch')) {
	        parallaxLists.each(function(){
	            var parallaxList = $(this),
	                categories = parallaxList.find('.mkd-floating-prod-cat'),
	                yOffset = parallaxList.attr('data-y-axis-translation');

	            categories.each(function(){
	                var category = $(this),
	                    categoryHeight = category.outerHeight(),
	                    categoryInner = category.find('.mkd-floating-cat-wrapper'),
	                    categoryInnerHeight = categoryInner.height(),
	                    delta = Math.floor(Math.random()*(yOffset-yOffset/2+1)+yOffset/2);

	                var dataParallax = '{"y":'+delta+', "smoothness":20}';
	                categoryInner.attr('data-parallax', dataParallax);
	            });
	        });

	        setTimeout(function(){
	            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
	        }, 100); //wait for calcs
	    }
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	$(document).ready(function(){
		mkdParallaxPtfText();
	});
	
	/**
	 * Parallax Pft text
	 * @type {Function}
	 */

	function mkdParallaxPtfText() {
	    var parallaxLists = $('.mkd-prod-cats-holder.mkd-parallax-items');

	    if (parallaxLists.length && !mkd.htmlEl.hasClass('touch')) {
	        parallaxLists.each(function(){
	            var parallaxList = $(this),
	                categories = parallaxList.find('.mkd-prod-cat'),
	                yOffset = parallaxList.attr('data-y-axis-translation');

	            categories.each(function(){
	                var category = $(this),
	                    categoryHeight = category.outerHeight(),
	                    categoryInner = category.find('.mkd-prod-cat-inner'),
	                    categoryInnerHeight = categoryInner.height(),
	                    delta = Math.floor(Math.random()*(yOffset-yOffset/2+1)+yOffset/2);

	                var dataParallax = '{"y":'+delta+', "smoothness":20}';
	                categoryInner.attr('data-parallax', dataParallax);
	            });
	        });

	        setTimeout(function(){
	            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
	        }, 100); //wait for calcs
	    }
	}
	
})(jQuery);
(function($) {
    "use strict";

    var blogMasonryGallery = {};
    mkd.modules.blogMasonryGallery = blogMasonryGallery;

    blogMasonryGallery.mkdOnDocumentReady = mkdOnDocumentReady;
    blogMasonryGallery.mkdOnWindowLoad = mkdOnWindowLoad;
    blogMasonryGallery.mkdOnWindowResize = mkdOnWindowResize;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitBlogMasonryGallery();
        mkdInitBlogMasonryGalleryAppearLoadMore();
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
        mkdInitBlogMasonryGallery();
    }

    /**
     *  Init Blog Masonry Gallery
     *
     *  Function that sets equal height of articles on blog masonry gallery list
     */
    function mkdInitBlogMasonryGallery(){
        var portList = $('.mkd-blog-holder.mkd-blog-masonry-gallery');

        if(portList.length){
            portList.each(function(){
                var thisPortList = $(this),
                    masonry = thisPortList.children('.mkd-blog-holder-inner'),
                    size = thisPortList.find('.mkd-blog-masonry-grid-sizer').width();
                
                mkdResizeBlogMasonryItems(size, thisPortList);

                masonry.isotope({
                    layoutMode: 'packery',
                    itemSelector: 'article',
                    percentPosition: true,
                    packery: {
                        gutter: '.mkd-blog-masonry-grid-gutter',
                        columnWidth: '.mkd-blog-masonry-grid-sizer'
                    }
                });
                
                setTimeout(function () {
                    mkd.modules.common.mkdInitParallax();
                }, 600);

                masonry.css('opacity', '1');
            });
        }
    }

    /**
     * Init Resize Blog Items
     */
    function mkdResizeBlogMasonryItems(size,container){
        if(container.hasClass('mkd-pl-images-fixed')) {
            var padding = parseInt(container.find('article').css('padding-left')),
                defaultMasonryItem = container.find('.mkd-post-size-default'),
                largeWidthMasonryItem = container.find('.mkd-post-size-large-width'),
                largeHeightMasonryItem = container.find('.mkd-post-size-large-height'),
                largeWidthHeightMasonryItem = container.find('.mkd-post-size-large-width-height');

            if (mkd.windowWidth > 680) {
                defaultMasonryItem.css('height', size - 2 * padding);
                largeHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthMasonryItem.css('height', size - 2 * padding);
            } else {
                defaultMasonryItem.css('height', size);
                largeHeightMasonryItem.css('height', size);
                largeWidthHeightMasonryItem.css('height', size);
                largeWidthMasonryItem.css('height', Math.round(size / 2));
            }
        }
    }

    function mkdInitBlogMasonryGalleryAppearLoadMore() {
        $( document.body ).on( 'blog_list_load_more_trigger', function() {
            mkdInitBlogMasonryGalleryAppear();
        });
    }

})(jQuery);
(function($) {
    'use strict';

    var portfolio = {};
    mkd.modules.portfolio = portfolio;

    portfolio.mkdOnWindowLoad = mkdOnWindowLoad;

    $(window).on('load', mkdOnWindowLoad);

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function mkdOnWindowLoad() {
        initPortfolioSingleMasonry();
        mkdPortfolioSingleFollow().init();
    }
	
	var mkdPortfolioSingleFollow = function() {
		var info = $('.mkd-follow-portfolio-info .mkd-portfolio-single-holder .mkd-ps-info-sticky-holder');
		
		if (info.length) {
			var infoHolder = info.parent(),
				infoHolderOffset = infoHolder.offset().top,
				infoHolderHeight = infoHolder.height(),
				mediaHolder = $('.mkd-ps-image-holder'),
				mediaHolderHeight = mediaHolder.height(),
				header = $('.header-appear, .mkd-fixed-wrapper'),
				headerHeight = (header.length) ? header.height() : 0;
		}
		
		var infoHolderPosition = function() {
			if(info.length) {
				if (mediaHolderHeight > infoHolderHeight) {
					if(mkd.scroll > infoHolderOffset) {
						var marginTop = mkd.scroll - infoHolderOffset + mkdGlobalVars.vars.mkdAddForAdminBar + headerHeight;
						// if scroll is initially positioned below mediaHolderHeight
						if(marginTop + infoHolderHeight > mediaHolderHeight){
							marginTop = mediaHolderHeight - infoHolderHeight;
						}
						info.stop().animate({
							marginTop: marginTop
						});
					}
				}
			}
		};
		
		var recalculateInfoHolderPosition = function() {
			if (info.length) {
				if(mediaHolderHeight > infoHolderHeight) {
					if(mkd.scroll > infoHolderOffset) {
						
						if(mkd.scroll + headerHeight + mkdGlobalVars.vars.mkdAddForAdminBar + infoHolderHeight + 50 < infoHolderOffset + mediaHolderHeight) { //50 to prevent mispositioning
							
							//Calculate header height if header appears
							if ($('.header-appear, .mkd-fixed-wrapper').length) {
								headerHeight = $('.header-appear, .mkd-fixed-wrapper').height();
							}
							info.stop().animate({
								marginTop: (mkd.scroll - infoHolderOffset + mkdGlobalVars.vars.mkdAddForAdminBar + headerHeight)
							});
							//Reset header height
							headerHeight = 0;
						}
						else{
							info.stop().animate({
								marginTop: mediaHolderHeight - infoHolderHeight
							});
						}
					} else {
						info.stop().animate({
							marginTop: 0
						});
					}
				}
			}
		};
		
		return {
			init : function() {
				infoHolderPosition();
				$(window).scroll(function(){
					recalculateInfoHolderPosition();
				});
			}
		};
	};
	
	function initPortfolioSingleMasonry(){
		var masonryHolder = $('.mkd-portfolio-single-holder .mkd-ps-masonry-images'),
			masonry = masonryHolder.children();
		
		if(masonry.length){
            masonry.isotope({
                layoutMode: 'packery',
                itemSelector: '.mkd-ps-image',
                percentPosition: true,
                packery: {
                    gutter: '.mkd-ps-grid-gutter',
                    columnWidth: '.mkd-ps-grid-sizer'
                }
            });

            masonry.css('opacity', '1');
		}
	}

})(jQuery);
(function($) {
    'use strict';
	
	var accordions = {};
	mkd.modules.accordions = accordions;
	
	accordions.mkdInitAccordions = mkdInitAccordions;
	
	
	accordions.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitAccordions();
	}
	
	/**
	 * Init accordions shortcode
	 */
	function mkdInitAccordions(){
		var accordion = $('.mkd-accordion-holder');
		
		if(accordion.length){
			accordion.each(function(){
				var thisAccordion = $(this);

				if(thisAccordion.hasClass('mkd-accordion')){
					thisAccordion.accordion({
						animate: "swing",
						collapsible: true,
						active: 0,
						icons: "",
						heightStyle: "content"
					});
				}

				if(thisAccordion.hasClass('mkd-toggle')){
					var toggleAccordion = $(this),
						toggleAccordionTitle = toggleAccordion.find('.mkd-accordion-title'),
						toggleAccordionContent = toggleAccordionTitle.next();

					toggleAccordion.addClass("accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset");
					toggleAccordionTitle.addClass("ui-accordion-header ui-state-default ui-corner-top ui-corner-bottom");
					toggleAccordionContent.addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").hide();

					toggleAccordionTitle.each(function(){
						var thisTitle = $(this);
						
						thisTitle.on('mouseenter mouseleave', function(){
							thisTitle.toggleClass("ui-state-hover");
						});

						thisTitle.on('click',function(){
							thisTitle.toggleClass('ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom');
							thisTitle.next().toggleClass('ui-accordion-content-active').slideToggle(400);
						});
					});
				}
			});
		}
	}

})(jQuery);
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
(function($) {
	'use strict';
	
	var button = {};
	mkd.modules.button = button;
	
	button.mkdButton = mkdButton;
	
	
	button.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdButton().init();
	}
	
	/**
	 * Button object that initializes whole button functionality
	 * @type {Function}
	 */
	var mkdButton = function() {
		//all buttons on the page
		var buttons = $('.mkd-btn');
		
		/**
		 * Initializes button hover color
		 * @param button current button
		 */
		var buttonHoverColor = function(button) {
			if(typeof button.data('hover-color') !== 'undefined') {
				var changeButtonColor = function(event) {
					event.data.button.css('color', event.data.color);
				};
				
				var originalColor = button.css('color');
				var hoverColor = button.data('hover-color');
				
				button.on('mouseenter', { button: button, color: hoverColor }, changeButtonColor);
				button.on('mouseleave', { button: button, color: originalColor }, changeButtonColor);
			}
		};
		
		/**
		 * Initializes button hover background color
		 * @param button current button
		 */
		var buttonHoverBgColor = function(button) {
			if(typeof button.data('hover-bg-color') !== 'undefined') {
				var changeButtonBg = function(event) {
					event.data.button.css('background-color', event.data.color);
				};
				
				var originalBgColor = button.css('background-color');
				var hoverBgColor = button.data('hover-bg-color');
				
				button.on('mouseenter', { button: button, color: hoverBgColor }, changeButtonBg);
				button.on('mouseleave', { button: button, color: originalBgColor }, changeButtonBg);
			}
		};
		
		/**
		 * Initializes button border color
		 * @param button
		 */
		var buttonHoverBorderColor = function(button) {
			if(typeof button.data('hover-border-color') !== 'undefined') {
				var changeBorderColor = function(event) {
					event.data.button.css('border-color', event.data.color);
				};
				
				var originalBorderColor = button.css('borderTopColor'); //take one of the four sides
				var hoverBorderColor = button.data('hover-border-color');
				
				button.on('mouseenter', { button: button, color: hoverBorderColor }, changeBorderColor);
				button.on('mouseleave', { button: button, color: originalBorderColor }, changeBorderColor);
			}
		};
		
		return {
			init: function() {
				if(buttons.length) {
					buttons.each(function() {
						buttonHoverColor($(this));
						buttonHoverBgColor($(this));
						buttonHoverBorderColor($(this));
					});
				}
			}
		};
	};
	
})(jQuery);
(function($) {
	'use strict';
	
	var countdown = {};
	mkd.modules.countdown = countdown;
	
	countdown.mkdInitCountdown = mkdInitCountdown;
	
	
	countdown.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitCountdown();
	}
	
	/**
	 * Countdown Shortcode
	 */
	function mkdInitCountdown() {
		var countdowns = $('.mkd-countdown'),
			date = new Date(),
			currentMonth = date.getMonth(),
			currentYear = date.getFullYear(),
			year,
			month,
			day,
			hour,
			minute,
			timezone,
			monthLabel,
			dayLabel,
			hourLabel,
			minuteLabel,
			secondLabel;
		
		if (countdowns.length) {
			countdowns.each(function(){
				//Find countdown elements by id-s
				var countdownId = $(this).attr('id'),
					countdown = $('#'+countdownId),
					digitFontSize,
					labelFontSize;
				
				//Get data for countdown
				year = countdown.data('year');
				month = countdown.data('month');
				day = countdown.data('day');
				hour = countdown.data('hour');
				minute = countdown.data('minute');
				timezone = countdown.data('timezone');
				monthLabel = countdown.data('month-label');
				dayLabel = countdown.data('day-label');
				hourLabel = countdown.data('hour-label');
				minuteLabel = countdown.data('minute-label');
				secondLabel = countdown.data('second-label');
				digitFontSize = countdown.data('digit-size');
				labelFontSize = countdown.data('label-size');

				if( currentMonth != month || currentYear !== year) {
					month = month - 1;
				}
				
				//Initialize countdown
				countdown.countdown({
					until: new Date(year, month, day, hour, minute, 44),
					labels: ['', monthLabel, '', dayLabel, hourLabel, minuteLabel, secondLabel],
					format: 'ODHMS',
					timezone: timezone,
					padZeroes: true,
					onTick: setCountdownStyle
				});
				
				function setCountdownStyle() {
					countdown.find('.countdown-amount').css({
						'font-size' : digitFontSize+'px',
						'line-height' : digitFontSize+'px'
					});
					countdown.find('.countdown-period').css({
						'font-size' : labelFontSize+'px'
					});
				}
			});
		}
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	var counter = {};
	mkd.modules.counter = counter;
	
	counter.mkdInitCounter = mkdInitCounter;
	
	
	counter.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitCounter();
	}
	
	/**
	 * Counter Shortcode
	 */
	function mkdInitCounter() {
		var counterHolder = $('.mkd-counter-holder');
		
		if (counterHolder.length) {
			counterHolder.each(function() {
				var thisCounterHolder = $(this),
					thisCounter = thisCounterHolder.find('.mkd-counter');
				
				thisCounterHolder.appear(function() {
					thisCounterHolder.css('opacity', '1');
					
					//Counter zero type
					if (thisCounter.hasClass('mkd-zero-counter')) {
						var max = parseFloat(thisCounter.text());
						thisCounter.countTo({
							from: 0,
							to: max,
							speed: 1500,
							refreshInterval: 100
						});
					} else {
						thisCounter.absoluteCounter({
							speed: 2000,
							fadeInDelay: 1000
						});
					}
				},{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			});
		}
	}
	
})(jQuery);
(function ($) {
	'use strict';
	
	var customFont = {};
	mkd.modules.customFont = customFont;
	
	customFont.mkdCustomFontResize = mkdCustomFontResize;
	customFont.mkdCustomFontTypeOut = mkdCustomFontTypeOut;
	
	
	customFont.mkdOnDocumentReady = mkdOnDocumentReady;
	customFont.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(document).ready(mkdOnDocumentReady);
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdCustomFontResize();
	}
	
	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {
		mkdCustomFontTypeOut();
	}
	
	/*
	 **	Custom Font resizing style
	 */
	function mkdCustomFontResize() {
		var holder = $('.mkd-custom-font-holder');
		
		if (holder.length) {
			holder.each(function () {
				var thisItem = $(this),
					itemClass = '',
					smallLaptopStyle = '',
					ipadLandscapeStyle = '',
					ipadPortraitStyle = '',
					mobileLandscapeStyle = '',
					style = '',
					responsiveStyle = '';
				
				if (typeof thisItem.data('item-class') !== 'undefined' && thisItem.data('item-class') !== false) {
					itemClass = thisItem.data('item-class');
				}
				
				if (typeof thisItem.data('font-size-1280') !== 'undefined' && thisItem.data('font-size-1280') !== false) {
					smallLaptopStyle += 'font-size: ' + thisItem.data('font-size-1280') + ' !important;';
				}
				if (typeof thisItem.data('font-size-1024') !== 'undefined' && thisItem.data('font-size-1024') !== false) {
					ipadLandscapeStyle += 'font-size: ' + thisItem.data('font-size-1024') + ' !important;';
				}
				if (typeof thisItem.data('font-size-768') !== 'undefined' && thisItem.data('font-size-768') !== false) {
					ipadPortraitStyle += 'font-size: ' + thisItem.data('font-size-768') + ' !important;';
				}
				if (typeof thisItem.data('font-size-680') !== 'undefined' && thisItem.data('font-size-680') !== false) {
					mobileLandscapeStyle += 'font-size: ' + thisItem.data('font-size-680') + ' !important;';
				}
				
				if (typeof thisItem.data('line-height-1280') !== 'undefined' && thisItem.data('line-height-1280') !== false) {
					smallLaptopStyle += 'line-height: ' + thisItem.data('line-height-1280') + ' !important;';
				}
				if (typeof thisItem.data('line-height-1024') !== 'undefined' && thisItem.data('line-height-1024') !== false) {
					ipadLandscapeStyle += 'line-height: ' + thisItem.data('line-height-1024') + ' !important;';
				}
				if (typeof thisItem.data('line-height-768') !== 'undefined' && thisItem.data('line-height-768') !== false) {
					ipadPortraitStyle += 'line-height: ' + thisItem.data('line-height-768') + ' !important;';
				}
				if (typeof thisItem.data('line-height-680') !== 'undefined' && thisItem.data('line-height-680') !== false) {
					mobileLandscapeStyle += 'line-height: ' + thisItem.data('line-height-680') + ' !important;';
				}
				
				if (smallLaptopStyle.length || ipadLandscapeStyle.length || ipadPortraitStyle.length || mobileLandscapeStyle.length) {
					
					if (smallLaptopStyle.length) {
						responsiveStyle += "@media only screen and (max-width: 1280px) {.mkd-custom-font-holder." + itemClass + " { " + smallLaptopStyle + " } }";
					}
					if (ipadLandscapeStyle.length) {
						responsiveStyle += "@media only screen and (max-width: 1024px) {.mkd-custom-font-holder." + itemClass + " { " + ipadLandscapeStyle + " } }";
					}
					if (ipadPortraitStyle.length) {
						responsiveStyle += "@media only screen and (max-width: 768px) {.mkd-custom-font-holder." + itemClass + " { " + ipadPortraitStyle + " } }";
					}
					if (mobileLandscapeStyle.length) {
						responsiveStyle += "@media only screen and (max-width: 680px) {.mkd-custom-font-holder." + itemClass + " { " + mobileLandscapeStyle + " } }";
					}
				}
				
				if (responsiveStyle.length) {
					style = '<style type="text/css">' + responsiveStyle + '</style>';
				}
				
				if (style.length) {
					$('head').append(style);
				}
			});
		}
	}
	
	/*
	 * Init Type out functionality for Custom Font shortcode
	 */
	function mkdCustomFontTypeOut() {
		var mkdTyped = $('.mkd-cf-typed');
		
		if (mkdTyped.length) {
			mkdTyped.each(function () {
				
				//vars
				var thisTyped = $(this),
					typedWrap = thisTyped.parent('.mkd-cf-typed-wrap'),
					customFontHolder = typedWrap.parent('.mkd-custom-font-holder'),
					str = [],
					string_1 = thisTyped.find('.mkd-cf-typed-1').text(),
					string_2 = thisTyped.find('.mkd-cf-typed-2').text(),
					string_3 = thisTyped.find('.mkd-cf-typed-3').text(),
					string_4 = thisTyped.find('.mkd-cf-typed-4').text();
				
				if (string_1.length) {
					str.push(string_1);
				}
				
				if (string_2.length) {
					str.push(string_2);
				}
				
				if (string_3.length) {
					str.push(string_3);
				}
				
				if (string_4.length) {
					str.push(string_4);
				}
				
				customFontHolder.appear(function () {
					thisTyped.typed({
						strings: str,
						typeSpeed: 90,
						backDelay: 700,
						loop: true,
						contentType: 'text',
						loopCount: false,
						cursorChar: '_'
					});
				}, {accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			});
		}
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	var elementsHolder = {};
	mkd.modules.elementsHolder = elementsHolder;
	
	elementsHolder.mkdInitElementsHolderResponsiveStyle = mkdInitElementsHolderResponsiveStyle;
	
	
	elementsHolder.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitElementsHolderResponsiveStyle();
	}
	
	/*
	 **	Elements Holder responsive style
	 */
	function mkdInitElementsHolderResponsiveStyle(){
		var elementsHolder = $('.mkd-elements-holder');
		
		if(elementsHolder.length){
			elementsHolder.each(function() {
				var thisElementsHolder = $(this),
					elementsHolderItem = thisElementsHolder.children('.mkd-eh-item'),
					style = '',
					responsiveStyle = '';
				
				elementsHolderItem.each(function() {
					var thisItem = $(this),
						itemClass = '',
						largeLaptop = '',
						smallLaptop = '',
						ipadLandscape = '',
						ipadPortrait = '',
						mobileLandscape = '',
						mobilePortrait = '';
					
					if (typeof thisItem.data('item-class') !== 'undefined' && thisItem.data('item-class') !== false) {
						itemClass = thisItem.data('item-class');
					}
					if (typeof thisItem.data('1280-1600') !== 'undefined' && thisItem.data('1280-1600') !== false) {
						largeLaptop = thisItem.data('1280-1600');
					}
					if (typeof thisItem.data('1024-1280') !== 'undefined' && thisItem.data('1024-1280') !== false) {
						smallLaptop = thisItem.data('1024-1280');
					}
					if (typeof thisItem.data('768-1024') !== 'undefined' && thisItem.data('768-1024') !== false) {
						ipadLandscape = thisItem.data('768-1024');
					}
					if (typeof thisItem.data('680-768') !== 'undefined' && thisItem.data('680-768') !== false) {
						ipadPortrait = thisItem.data('680-768');
					}
					if (typeof thisItem.data('680') !== 'undefined' && thisItem.data('680') !== false) {
						mobileLandscape = thisItem.data('680');
					}
					
					if(largeLaptop.length || smallLaptop.length || ipadLandscape.length || ipadPortrait.length || mobileLandscape.length || mobilePortrait.length) {
						
						if(largeLaptop.length) {
							responsiveStyle += "@media only screen and (min-width: 1281px) and (max-width: 1600px) {.mkd-eh-item-content."+itemClass+" { padding: "+largeLaptop+" !important; } }";
						}
						if(smallLaptop.length) {
							responsiveStyle += "@media only screen and (min-width: 1025px) and (max-width: 1280px) {.mkd-eh-item-content."+itemClass+" { padding: "+smallLaptop+" !important; } }";
						}
						if(ipadLandscape.length) {
							responsiveStyle += "@media only screen and (min-width: 769px) and (max-width: 1024px) {.mkd-eh-item-content."+itemClass+" { padding: "+ipadLandscape+" !important; } }";
						}
						if(ipadPortrait.length) {
							responsiveStyle += "@media only screen and (min-width: 681px) and (max-width: 768px) {.mkd-eh-item-content."+itemClass+" { padding: "+ipadPortrait+" !important; } }";
						}
						if(mobileLandscape.length) {
							responsiveStyle += "@media only screen and (max-width: 680px) {.mkd-eh-item-content."+itemClass+" { padding: "+mobileLandscape+" !important; } }";
						}
					}
				});
				
				if(responsiveStyle.length) {
					style = '<style type="text/css">'+responsiveStyle+'</style>';
				}
				
				if(style.length) {
					$('head').append(style);
				}
				
				if (typeof mkd.modules.common.mkdOwlSlider === "function") {
					mkd.modules.common.mkdOwlSlider();
				}
			});
		}
	}
	
})(jQuery);
(function ($) {
	'use strict';
	
	var fullScreenImageSlider = {};
	mkd.modules.fullScreenImageSlider = fullScreenImageSlider;
	
	
	fullScreenImageSlider.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnWindowLoad() {
		mkdInitFullScreenImageSlider();
	}
	
	/**
	 * Init Full Screen Image Slider Shortcode
	 */
	function mkdInitFullScreenImageSlider() {
		var holder = $('.mkd-fsis-slider');
		
		if (holder.length) {
			holder.each(function () {
				var sliderHolder = $(this),
					mainHolder = sliderHolder.parent(),
					prevThumbNav = mainHolder.children('.mkd-fsis-prev-nav'),
					nextThumbNav = mainHolder.children('.mkd-fsis-next-nav'),
					maskHolder = mainHolder.children('.mkd-fsis-slider-mask');
				
				mainHolder.addClass('mkd-fsis-is-init');
				
				mkdImageBehavior(sliderHolder);
				mkdPrevNextImageBehavior(sliderHolder, prevThumbNav, nextThumbNav, -1); // -1 is arbitrary value because 0 can be index of item
				
				sliderHolder.on('drag.owl.carousel', function () {
					setTimeout(function () {
						if (!maskHolder.hasClass('mkd-drag') && !mainHolder.hasClass('mkd-fsis-active')) {
							maskHolder.addClass('mkd-drag');
						}
					}, 200);
				});
				
				sliderHolder.on('dragged.owl.carousel', function () {
					setTimeout(function () {
						if (maskHolder.hasClass('mkd-drag')) {
							maskHolder.removeClass('mkd-drag');
						}
					}, 300);
				});
				
				sliderHolder.on('translate.owl.carousel', function (e) {
					mkdPrevNextImageBehavior(sliderHolder, prevThumbNav, nextThumbNav, e.item.index);
				});
				
				sliderHolder.on('translated.owl.carousel', function () {
					mkdImageBehavior(sliderHolder);
					
					setTimeout(function () {
						maskHolder.removeClass('mkd-drag');
					}, 300);
				});
			});
		}
	}
	
	function mkdImageBehavior(sliderHolder) {
		var activeItem = sliderHolder.find('.owl-item.active'),
			imageHolder = sliderHolder.find('.mkd-fsis-item');
		
		imageHolder.removeClass('mkd-fsis-content-image-init');
		
		mkdResetImageBehavior(sliderHolder);
		
		if (activeItem.length) {
			var activeImageHolder = activeItem.find('.mkd-fsis-item'),
				activeItemImage = activeImageHolder.children('.mkd-fsis-image');
			
			setTimeout(function () {
				activeImageHolder.addClass('mkd-fsis-content-image-init');
			}, 100);
			
			activeItemImage.off().on('mouseenter', function () {
				activeImageHolder.addClass('mkd-fsis-image-hover');
			}).on('mouseleave', function () {
				activeImageHolder.removeClass('mkd-fsis-image-hover');
			}).on('click', function () {
				if (activeImageHolder.hasClass('mkd-fsis-active-image')) {
					sliderHolder.trigger('play.owl.autoplay');
					sliderHolder.parent().removeClass('mkd-fsis-active');
					activeImageHolder.removeClass('mkd-fsis-active-image');
				} else {
					sliderHolder.trigger('stop.owl.autoplay');
					sliderHolder.parent().addClass('mkd-fsis-active');
					activeImageHolder.addClass('mkd-fsis-active-image');
				}
			});
			
			//Close on escape
			$(document).keyup(function (e) {
				if (e.keyCode === 27) { //KeyCode for ESC button is 27
					sliderHolder.trigger('play.owl.autoplay');
					sliderHolder.parent().removeClass('mkd-fsis-active');
					activeImageHolder.removeClass('mkd-fsis-active-image');
				}
			});
		}
	}
	
	function mkdPrevNextImageBehavior(sliderHolder, prevThumbNav, nextThumbNav, itemIndex) {
		var activeItem = itemIndex === -1 ? sliderHolder.find('.owl-item.active') : $(sliderHolder.find('.owl-item')[itemIndex]),
			prevItemImage = activeItem.prev().find('.mkd-fsis-image').css('background-image'),
			nextItemImage = activeItem.next().find('.mkd-fsis-image').css('background-image');
		
		if (prevItemImage.length) {
			prevThumbNav.css({'background-image': prevItemImage});
		}
		
		if (nextItemImage.length) {
			nextThumbNav.css({'background-image': nextItemImage});
		}
	}
	
	function mkdResetImageBehavior(sliderHolder) {
		var imageHolder = sliderHolder.find('.mkd-fsis-item');
		
		if (imageHolder.length) {
			imageHolder.removeClass('mkd-fsis-active-image');
		}
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	var googleMap = {};
	mkd.modules.googleMap = googleMap;
	
	googleMap.mkdShowGoogleMap = mkdShowGoogleMap;

	// All functions that google maps are initialized in
	$( document ).on(
		'mkdfGoogleMapsCallbackEvent',
		function () {
			mkdShowGoogleMap();
		}
	);

	/*
	 **	Show Google Map
	 */
	function mkdShowGoogleMap(){
		var googleMap = $('.mkd-google-map');

		if(googleMap.length){
			googleMap.each(function(){
				var element = $(this);

				var snazzyMapStyle = false;
				var snazzyMapCode  = '';
				if(typeof element.data('snazzy-map-style') !== 'undefined' && element.data('snazzy-map-style') === 'yes') {
					snazzyMapStyle = true;
					var snazzyMapHolder = element.parent().find('.mkd-snazzy-map'),
						snazzyMapCodes  = snazzyMapHolder.val();

					if( snazzyMapHolder.length && snazzyMapCodes.length ) {
						snazzyMapCode = JSON.parse( snazzyMapCodes.replace(/`{`/g, '[').replace(/`}`/g, ']').replace(/``/g, '"').replace(/`/g, '') );
					}
				}

				var customMapStyle;
				if(typeof element.data('custom-map-style') !== 'undefined') {
					customMapStyle = element.data('custom-map-style');
				}

				var colorOverlay;
				if(typeof element.data('color-overlay') !== 'undefined' && element.data('color-overlay') !== false) {
					colorOverlay = element.data('color-overlay');
				}

				var saturation;
				if(typeof element.data('saturation') !== 'undefined' && element.data('saturation') !== false) {
					saturation = element.data('saturation');
				}

				var lightness;
				if(typeof element.data('lightness') !== 'undefined' && element.data('lightness') !== false) {
					lightness = element.data('lightness');
				}

				var zoom;
				if(typeof element.data('zoom') !== 'undefined' && element.data('zoom') !== false) {
					zoom = element.data('zoom');
				}

				var pin;
				if(typeof element.data('pin') !== 'undefined' && element.data('pin') !== false) {
					pin = element.data('pin');
				}

				var mapHeight;
				if(typeof element.data('height') !== 'undefined' && element.data('height') !== false) {
					mapHeight = element.data('height');
				}

				var uniqueId;
				if(typeof element.data('unique-id') !== 'undefined' && element.data('unique-id') !== false) {
					uniqueId = element.data('unique-id');
				}

				var scrollWheel;
				if(typeof element.data('scroll-wheel') !== 'undefined') {
					scrollWheel = element.data('scroll-wheel');
				}
				var addresses;
				if(typeof element.data('addresses') !== 'undefined' && element.data('addresses') !== false) {
					addresses = element.data('addresses');
				}

				var addressesTitle;
				if(typeof element.data('addresses-title') !== 'undefined' && element.data('addresses-title') !== false) {
					addressesTitle = element.data('addresses-title');
				}

				var addressesDescription;
				if(typeof element.data('addresses-description') !== 'undefined' && element.data('addresses-description') !== false) {
					addressesDescription = element.data('addresses-description');
				}
				
				var map = "map_"+ uniqueId;
				var geocoder = "geocoder_"+ uniqueId;
				var holderId = "mkd-map-"+ uniqueId;

				mkdfInitializeGoogleMap(snazzyMapStyle, snazzyMapCode, customMapStyle, colorOverlay, saturation, lightness, scrollWheel, zoom, holderId, mapHeight, pin,  map, geocoder, addresses, addressesTitle, addressesDescription);
			});
		}
	}

	/*
	 **	Init Google Map
	 */
	function mkdfInitializeGoogleMap(snazzyMapStyle, snazzyMapCode, customMapStyle, color, saturation, lightness, wheel, zoom, holderId, height, pin,  map, geocoder, data, addressesTitle, addressesDescription){

		if(typeof google !== 'object') {
			return;
		}

		var mapStyles = [];
		if(snazzyMapStyle && snazzyMapCode.length) {
			mapStyles = snazzyMapCode;
		} else {
			mapStyles = [
				{
					stylers: [
						{hue: color },
						{saturation: saturation},
						{lightness: lightness},
						{gamma: 1}
					]
				}
			];
		}

		var googleMapStyleId;

		if(snazzyMapStyle || customMapStyle === 'yes'){
			googleMapStyleId = 'mkd-style';
		} else {
			googleMapStyleId = google.maps.MapTypeId.ROADMAP;
		}

		wheel = wheel === 'yes';

		var qoogleMapType = new google.maps.StyledMapType(mapStyles, {name: "Google Map"});

		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-34.397, 150.644);

		if (!isNaN(height)){
			height = height + 'px';
		}

		var myOptions = {
			zoom: zoom,
			scrollwheel: wheel,
			center: latlng,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.RIGHT_CENTER
			},
			scaleControl: false,
			scaleControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			streetViewControl: false,
			streetViewControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			panControl: false,
			panControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			mapTypeControl: false,
			mapTypeControlOptions: {
				mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'mkd-style'],
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			mapTypeId: googleMapStyleId,
			mapId: "MIKADO_MAP_ID",
		};

		map = new google.maps.Map(document.getElementById(holderId), myOptions);
		map.mapTypes.set('mkd-style', qoogleMapType);

		var index;

		for (index = 0; index < data.length; ++index) {
			mkdfInitializeGoogleAddress(data[index], pin, map, geocoder, addressesTitle, addressesDescription);
		}

		var holderElement = document.getElementById(holderId);
		holderElement.style.height = height;
	}

	/*
	 **	Init Google Map Addresses
	 */
	function mkdfInitializeGoogleAddress(data, pin, map, geocoder, addressesTitle, addressesDescription){
		if (data === '') {
			return;
		}

		var contentString = '<div id="content">'+
			'<div id="siteNotice">'+
			'</div>'+
			'<h3 id="firstHeading" class="firstHeading">'+addressesTitle+'</h3>'+
			'<div id="bodyContent">'+
			'<p class="address">'+addressesDescription+'</p>'+
			'</div>'+
			'</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		geocoder.geocode( { 'address': data}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var pinImg = document.createElement( 'img' );
				pinImg.src = pin;
				var marker = new google.maps.marker.AdvancedMarkerElement({
					map: map,
					position: results[0].geometry.location,
					content: pinImg,
					title: data['store_title']
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});

				window.addEventListener(
					'resize',
					function () {
						map.setCenter(results[0].geometry.location);
					}
				);
			}
		});
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	var icon = {};
	mkd.modules.icon = icon;
	
	icon.mkdIcon = mkdIcon;
	
	
	icon.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdIcon().init();
	}
	
	/**
	 * Object that represents icon shortcode
	 * @returns {{init: Function}} function that initializes icon's functionality
	 */
	var mkdIcon = function() {
		var icons = $('.mkd-icon-shortcode');
		
		/**
		 * Function that triggers icon animation and icon animation delay
		 */
		var iconAnimation = function(icon) {
			if(icon.hasClass('mkd-icon-animation')) {
				icon.appear(function() {
					icon.parent('.mkd-icon-animation-holder').addClass('mkd-icon-animation-show');
				}, {accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			}
		};
		
		/**
		 * Function that triggers icon hover color functionality
		 */
		var iconHoverColor = function(icon) {
			if(typeof icon.data('hover-color') !== 'undefined') {
				var changeIconColor = function(event) {
					event.data.icon.css('color', event.data.color);
				};
				
				var iconElement = icon.find('.mkd-icon-element');
				var hoverColor = icon.data('hover-color');
				var originalColor = iconElement.css('color');
				
				if(hoverColor !== '') {
					icon.on('mouseenter', {icon: iconElement, color: hoverColor}, changeIconColor);
					icon.on('mouseleave', {icon: iconElement, color: originalColor}, changeIconColor);
				}
			}
		};
		
		/**
		 * Function that triggers icon holder background color hover functionality
		 */
		var iconHolderBackgroundHover = function(icon) {
			if(typeof icon.data('hover-background-color') !== 'undefined') {
				var changeIconBgColor = function(event) {
					event.data.icon.css('background-color', event.data.color);
				};
				
				var hoverBackgroundColor = icon.data('hover-background-color');
				var originalBackgroundColor = icon.css('background-color');
				
				if(hoverBackgroundColor !== '') {
					icon.on('mouseenter', {icon: icon, color: hoverBackgroundColor}, changeIconBgColor);
					icon.on('mouseleave', {icon: icon, color: originalBackgroundColor}, changeIconBgColor);
				}
			}
		};
		
		/**
		 * Function that initializes icon holder border hover functionality
		 */
		var iconHolderBorderHover = function(icon) {
			if(typeof icon.data('hover-border-color') !== 'undefined') {
				var changeIconBorder = function(event) {
					event.data.icon.css('border-color', event.data.color);
				};
				
				var hoverBorderColor = icon.data('hover-border-color');
				var originalBorderColor = icon.css('borderTopColor');
				
				if(hoverBorderColor !== '') {
					icon.on('mouseenter', {icon: icon, color: hoverBorderColor}, changeIconBorder);
					icon.on('mouseleave', {icon: icon, color: originalBorderColor}, changeIconBorder);
				}
			}
		};
		
		return {
			init: function() {
				if(icons.length) {
					icons.each(function() {
						iconAnimation($(this));
						iconHoverColor($(this));
						iconHolderBackgroundHover($(this));
						iconHolderBorderHover($(this));
					});
				}
			}
		};
	};
	
})(jQuery);
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
(function($) {
    'use strict';
	
	var imageGallery = {};
	mkd.modules.imageGallery = imageGallery;
	
	imageGallery.mkdInitImageGalleryMasonry = mkdInitImageGalleryMasonry;
	
	
	imageGallery.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {
		mkdInitImageGalleryMasonry();
	}
	
	/*
	 ** Init Image Gallery shortcode - Masonry layout
	 */
	function mkdInitImageGalleryMasonry(){
		var holder = $('.mkd-image-gallery.mkd-ig-masonry-type');
		
		if(holder.length){
			holder.each(function(){
				var thisHolder = $(this),
					masonry = thisHolder.find('.mkd-ig-masonry');
				
				masonry.waitForImages(function() {
					masonry.isotope({
						layoutMode: 'packery',
						itemSelector: '.mkd-ig-image',
						percentPosition: true,
						packery: {
							gutter: '.mkd-ig-grid-gutter',
							columnWidth: '.mkd-ig-grid-sizer'
						}
					});
					
					setTimeout(function() {
						masonry.isotope('layout');
						mkd.modules.common.mkdInitParallax();
					}, 800);
					
					masonry.css('opacity', '1');
				});
			});
		}
	}

})(jQuery);
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
(function($) {
	'use strict';
	
	var itemShowcase = {};
	mkd.modules.itemShowcase = itemShowcase;
	
	itemShowcase.mkdInitItemShowcase = mkdInitItemShowcase;
	
	
	itemShowcase.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitItemShowcase();
	}
	
	/**
	 * Init item showcase shortcode
	 */
	function mkdInitItemShowcase() {
		var itemShowcase = $('.mkd-item-showcase-holder');
		
		if (itemShowcase.length) {
			itemShowcase.each(function(){
				var thisItemShowcase = $(this),
					leftItems = thisItemShowcase.find('.mkd-is-left'),
					rightItems = thisItemShowcase.find('.mkd-is-right'),
					itemImage = thisItemShowcase.find('.mkd-is-image');
				
				//logic
				leftItems.wrapAll( "<div class='mkd-is-item-holder mkd-is-left-holder' />");
				rightItems.wrapAll( "<div class='mkd-is-item-holder mkd-is-right-holder' />");
				thisItemShowcase.animate({opacity:1},200);
				
				setTimeout(function(){
					thisItemShowcase.appear(function(){
						itemImage.addClass('mkd-appeared');
						thisItemShowcase.on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
							function(e) {
								if(mkd.windowWidth > 1200) {
									itemAppear('.mkd-is-left-holder .mkd-is-item');
									itemAppear('.mkd-is-right-holder .mkd-is-item');
								} else {
									itemAppear('.mkd-is-item');
								}
							});
					},{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
				},100);
				
				//appear animation trigger
				function itemAppear(itemCSSClass) {
					thisItemShowcase.find(itemCSSClass).each(function(i){
						var thisListItem = $(this);
						setTimeout(function(){
							thisListItem.addClass('mkd-appeared');
						}, i*150);
					});
				}
			});
		}
	}
	
})(jQuery);
(function($) {
    'use strict';
	
	var parallaxDropShadowImageSection = {};
	mkd.modules.parallaxDropShadowImageSection = parallaxDropShadowImageSection;

    parallaxDropShadowImageSection.mkdOnWindowLoad = mkdOnWindowLoad;
	
	$(window).on('load', mkdOnWindowLoad);
	
	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function mkdOnWindowLoad() {
        mkdParallaxShadow();
	}


    function mkdParallaxShadow() {
        var parallaxIntances = $('.mkd-pdsis-has-parallax-scroll .mkd-parallax-dsis-shadow-holder');

        if (parallaxIntances.length && !mkd.htmlEl.hasClass('touch')) {
            ParallaxScroll.init(); //initialzation removed from plugin js file to have it run only on non-touch devices
        }
    }


})(jQuery);
(function($) {
	'use strict';
	
	var pieChart = {};
	mkd.modules.pieChart = pieChart;
	
	pieChart.mkdInitPieChart = mkdInitPieChart;
	
	
	pieChart.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitPieChart();
	}
	
	/**
	 * Init Pie Chart shortcode
	 */
	function mkdInitPieChart() {
		var pieChartHolder = $('.mkd-pie-chart-holder');
		
		if (pieChartHolder.length) {
			pieChartHolder.each(function () {
				var thisPieChartHolder = $(this),
					pieChart = thisPieChartHolder.children('.mkd-pc-percentage'),
					barColor = '#c7c7c7',
					trackColor = 'transparent',
					lineWidth = 1,
					size = 200;
				
				if(typeof pieChart.data('size') !== 'undefined' && pieChart.data('size') !== '') {
					size = pieChart.data('size');
				}
				
				if(typeof pieChart.data('bar-color') !== 'undefined' && pieChart.data('bar-color') !== '') {
					barColor = pieChart.data('bar-color');
				}
				
				if(typeof pieChart.data('track-color') !== 'undefined' && pieChart.data('track-color') !== '') {
					trackColor = pieChart.data('track-color');
				}
				
				pieChart.appear(function() {
					initToCounterPieChart(pieChart);
					thisPieChartHolder.css('opacity', '1');
					
					pieChart.easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: lineWidth,
						animate: 1500,
						size: size
					});
				},{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
			});
		}
	}
	
	/*
	 **	Counter for pie chart number from zero to defined number
	 */
	function initToCounterPieChart(pieChart){
		var counter = pieChart.find('.mkd-pc-percent'),
			max = parseFloat(counter.text());
		
		counter.countTo({
			from: 0,
			to: max,
			speed: 1500,
			refreshInterval: 50
		});
	}
	
})(jQuery);
(function($) {
	'use strict';
	
	var progressBar = {};
	mkd.modules.progressBar = progressBar;
	
	progressBar.mkdInitProgressBars = mkdInitProgressBars;
	
	
	progressBar.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitProgressBars();
	}
	
	/*
	 **	Horizontal progress bars shortcode
	 */
	function mkdInitProgressBars(){
		var progressBar = $('.mkd-progress-bar');
		
		if(progressBar.length){
			progressBar.each(function() {
				var thisBar = $(this),
					thisBarContent = thisBar.find('.mkd-pb-content'),
					percentage = thisBarContent.data('percentage');
				
				thisBar.appear(function() {
					mkdInitToCounterProgressBar(thisBar, percentage);
					
					thisBarContent.css('width', '0%');
					thisBarContent.animate({'width': percentage+'%'}, 2000);
				});
			});
		}
	}
	
	/*
	 **	Counter for horizontal progress bars percent from zero to defined percent
	 */
	function mkdInitToCounterProgressBar(progressBar, $percentage){
		var percentage = parseFloat($percentage),
			percent = progressBar.find('.mkd-pb-percent');
		
		if(percent.length) {
			percent.each(function() {
				var thisPercent = $(this);
				thisPercent.css('opacity', '1');
				
				thisPercent.countTo({
					from: 0,
					to: percentage,
					speed: 2000,
					refreshInterval: 50
				});
			});
		}
	}
	
})(jQuery);
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
(function($) {
    'use strict';

    var uncoveringSections = {};
    mkd.modules.uncoveringSections = uncoveringSections;

    uncoveringSections.mkdInitUncoveringSections = mkdInitUncoveringSections;


    uncoveringSections.mkdOnDocumentReady = mkdOnDocumentReady;

    $(document).ready(mkdOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitUncoveringSections();
    }

    /*
     **	Init full screen sections shortcode
     */
    function mkdInitUncoveringSections(){
        var uncoveringSections = $('.mkd-uncovering-sections');

        if(uncoveringSections.length){
            uncoveringSections.each(function() {
                var thisUS = $(this),
                    thisCurtain = uncoveringSections.find('.curtains'),
                    curtainItems = thisCurtain.find('.mkd-uss-item'),
                    curtainShadow = uncoveringSections.find('.mkd-fss-shadow');
                var body = mkd.body;
                var defaultHeaderStyle = '';
                if (body.hasClass('mkd-light-header')) {
                    defaultHeaderStyle = 'light';
                } else if (body.hasClass('mkd-dark-header')) {
                    defaultHeaderStyle = 'dark';
                }

                body.addClass('mkd-uncovering-section-on-page');
                if(mkdPerPageVars.vars.mkdHeaderVerticalWidth > 0 && mkd.windowWidth > 1024) {
                    curtainItems.css({
                        left : mkdPerPageVars.vars.mkdHeaderVerticalWidth,
                        width: 'calc(100% - ' + mkdPerPageVars.vars.mkdHeaderVerticalWidth + 'px)'
                    });

                    curtainShadow.css({
                        left : mkdPerPageVars.vars.mkdHeaderVerticalWidth,
                        width: 'calc(100% - ' + mkdPerPageVars.vars.mkdHeaderVerticalWidth + 'px)'
                    });
                }

                thisCurtain.curtain({
                    scrollSpeed: 400,
                    nextSlide: function() { checkFullScreenSectionsItemForHeaderStyle(thisCurtain, defaultHeaderStyle); },
                    prevSlide: function() { checkFullScreenSectionsItemForHeaderStyle(thisCurtain, defaultHeaderStyle);}
                });

                checkFullScreenSectionsItemForHeaderStyle(thisCurtain, defaultHeaderStyle);
                setResposniveData(thisCurtain);

                thisUS.addClass('mkd-loaded');
            });
        }
    }

    function checkFullScreenSectionsItemForHeaderStyle(thisUncoveringSections, default_header_style) {
        var section_header_style = thisUncoveringSections.find('.current').data('header-style');
        if (section_header_style !== undefined && section_header_style !== '') {
            mkd.body.removeClass('mkd-light-header mkd-dark-header').addClass('mkd-' + section_header_style + '-header');
        } else if (default_header_style !== '') {
            mkd.body.removeClass('mkd-light-header mkd-dark-header').addClass('mkd-' + default_header_style + '-header');
        } else {
            mkd.body.removeClass('mkd-light-header mkd-dark-header');
        }
    }

    function setResposniveData(thisUncoveringSections) {
        var uncoveringSections = thisUncoveringSections.find('.mkd-uss-item'),
            responsiveStyle = '',
            style = '';

        uncoveringSections.each(function(){
            var thisSection = $(this),
                thisSectionImage = thisSection.find('.mkd-uss-image-holder'),
                itemClass = '',
                imageLaptop = '',
                imageTablet = '',
                imagePortraitTablet = '',
                imageMobile = '';

            if (typeof thisSection.data('item-class') !== 'undefined' && thisSection.data('item-class') !== false) {
                itemClass = thisSection.data('item-class');
            }

            if (typeof thisSectionImage.data('laptop-image') !== 'undefined' && thisSectionImage.data('laptop-image') !== false) {
                imageLaptop = thisSectionImage.data('laptop-image');
            }
            if (typeof thisSectionImage.data('tablet-image') !== 'undefined' && thisSectionImage.data('tablet-image') !== false) {
                imageTablet = thisSectionImage.data('tablet-image');
            }
            if (typeof thisSectionImage.data('tablet-portrait-image') !== 'undefined' && thisSectionImage.data('tablet-portrait-image') !== false) {
                imagePortraitTablet = thisSectionImage.data('tablet-portrait-image');
            }
            if (typeof thisSectionImage.data('mobile-image') !== 'undefined' && thisSectionImage.data('mobile-image') !== false) {
                imageMobile = thisSectionImage.data('mobile-image');
            }


            if (imageLaptop.length || imageTablet.length || imagePortraitTablet.length || imageMobile.length) {

                if (imageLaptop.length) {
                    responsiveStyle += "@media only screen and (max-width: 1280px) {.mkd-uss-item." + itemClass + " .mkd-uss-image-holder { background-image: url(" + imageLaptop + ") !important; } }";
                }
                if (imageTablet.length) {
                    responsiveStyle += "@media only screen and (max-width: 1024px) {.mkd-uss-item." + itemClass + " .mkd-uss-image-holder { background-image: url( " + imageTablet + ") !important; } }";
                }
                if (imagePortraitTablet.length) {
                    responsiveStyle += "@media only screen and (max-width: 800px) {.mkd-uss-item." + itemClass + " .mkd-uss-image-holder { background-image: url( " + imagePortraitTablet + ") !important; } }";
                }
                if (imageMobile.length) {
                    responsiveStyle += "@media only screen and (max-width: 680px) {.mkd-uss-item." + itemClass + " .mkd-uss-image-holder { background-image: url( " + imageMobile + ") !important; } }";
                }
            }
        });

        if (responsiveStyle.length) {
            style = '<style type="text/css">' + responsiveStyle + '</style>';
        }

        if (style.length) {
            $('head').append(style);
        }
    }

})(jQuery);
(function($) {
	'use strict';
	
	var verticalSplitSlider = {};
	mkd.modules.verticalSplitSlider = verticalSplitSlider;
	
	verticalSplitSlider.mkdInitVerticalSplitSlider = mkdInitVerticalSplitSlider;
	
	
	verticalSplitSlider.mkdOnDocumentReady = mkdOnDocumentReady;
	
	$(document).ready(mkdOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function mkdOnDocumentReady() {
		mkdInitVerticalSplitSlider();
	}
	
	/*
	 **	Vertical Split Slider
	 */
	function mkdInitVerticalSplitSlider() {
		var slider = $('.mkd-vertical-split-slider');
		
		if (slider.length) {
			if (mkd.body.hasClass('mkd-vss-initialized')) {
				mkd.body.removeClass('mkd-vss-initialized');
				$.fn.multiscroll.destroy();
			}
			
			slider.height(mkd.windowHeight).animate({opacity: 1}, 300);
			
			var defaultHeaderStyle = '';
			if (mkd.body.hasClass('mkd-light-header')) {
				defaultHeaderStyle = 'light';
			} else if (mkd.body.hasClass('mkd-dark-header')) {
				defaultHeaderStyle = 'dark';
			}
			
			slider.multiscroll({
				scrollingSpeed: 700,
				easing: 'easeInOutQuart',
				navigation: true,
				useAnchorsOnLoad: false,
				sectionSelector: '.mkd-vss-ms-section',
				leftSelector: '.mkd-vss-ms-left',
				rightSelector: '.mkd-vss-ms-right',
				afterRender: function () {
					mkdCheckVerticalSplitSectionsForHeaderStyle($('.mkd-vss-ms-left .mkd-vss-ms-section:first-child').data('header-style'), defaultHeaderStyle);
					mkd.body.addClass('mkd-vss-initialized');
					
					var contactForm7 = $('div.wpcf7 > form');
					if (contactForm7.length) {
						contactForm7.each(function(){
							var thisForm = $(this);
							
							thisForm.find('.wpcf7-submit').off().on('click', function(e){
								e.preventDefault();
								wpcf7.submit(thisForm);
							});
						});
					}
					
					//prepare html for smaller screens - start //
					var verticalSplitSliderResponsive = $('<div class="mkd-vss-responsive"></div>'),
						leftSide = slider.find('.mkd-vss-ms-left > div'),
						rightSide = slider.find('.mkd-vss-ms-right > div');
					
					slider.after(verticalSplitSliderResponsive);
					
					for (var i = 0; i < leftSide.length; i++) {
						verticalSplitSliderResponsive.append($(leftSide[i]).clone(true));
						verticalSplitSliderResponsive.append($(rightSide[leftSide.length - 1 - i]).clone(true));
					}
					
					//prepare google maps clones
					var googleMapHolder = $('.mkd-vss-responsive .mkd-google-map');
					if (googleMapHolder.length) {
						googleMapHolder.each(function () {
							var map = $(this);
							map.empty();
							var num = Math.floor((Math.random() * 100000) + 1);
							map.attr('id', 'mkd-map-' + num);
							map.data('unique-id', num);
						});
					}
					
					if (typeof mkd.modules.animationHolder.mkdInitAnimationHolder === "function") {
						mkd.modules.animationHolder.mkdInitAnimationHolder();
					}
					
					if (typeof mkd.modules.button.mkdButton === "function") {
						mkd.modules.button.mkdButton().init();
					}
					
					if (typeof mkd.modules.elementsHolder.mkdInitElementsHolderResponsiveStyle === "function") {
						mkd.modules.elementsHolder.mkdInitElementsHolderResponsiveStyle();
					}
					
					if (typeof mkd.modules.googleMap.mkdShowGoogleMap === "function") {
						$( document ).on(
							'mkdfGoogleMapsCallbackEvent',
							function () {
								mkd.modules.googleMap.mkdShowGoogleMap();
							}
						);
					}
					
					if (typeof mkd.modules.icon.mkdIcon === "function") {
						mkd.modules.icon.mkdIcon().init();
					}
					
					if (typeof mkd.modules.progressBar.mkdInitProgressBars === "function") {
						mkd.modules.progressBar.mkdInitProgressBars();
					}
				},
				onLeave: function (index, nextIndex) {
					mkdIntiScrollAnimation(slider, nextIndex);
					mkdCheckVerticalSplitSectionsForHeaderStyle($($('.mkd-vss-ms-left .mkd-vss-ms-section')[$(".mkd-vss-ms-left .mkd-vss-ms-section").length - nextIndex]).data('header-style'), defaultHeaderStyle);
				}
			});
			
			if (mkd.windowWidth <= 1024) {
				$.fn.multiscroll.destroy();
			} else {
				$.fn.multiscroll.build();
			}
			
			$(window).resize(function () {
				if (mkd.windowWidth <= 1024) {
					$.fn.multiscroll.destroy();
				} else {
					$.fn.multiscroll.build();
				}
			});
		}
	}
	
	function mkdIntiScrollAnimation(slider, nextIndex) {
		
		if (slider.hasClass('mkd-vss-scrolling-animation')) {
			
			if (nextIndex > 1 && !slider.hasClass('mkd-vss-scrolled')) {
				slider.addClass('mkd-vss-scrolled');
			} else if (nextIndex === 1 && slider.hasClass('mkd-vss-scrolled')) {
				slider.removeClass('mkd-vss-scrolled');
			}
		}
	}
	
	/*
	 **	Check slides on load and slide change for header style changing
	 */
	function mkdCheckVerticalSplitSectionsForHeaderStyle(section_header_style, default_header_style) {
		if (section_header_style !== undefined && section_header_style !== '') {
			mkd.body.removeClass('mkd-light-header mkd-dark-header').addClass('mkd-' + section_header_style + '-header');
		} else if (default_header_style !== '') {
			mkd.body.removeClass('mkd-light-header mkd-dark-header').addClass('mkd-' + default_header_style + '-header');
		} else {
			mkd.body.removeClass('mkd-light-header mkd-dark-header');
		}
	}
	
})(jQuery);
(function($) {
    'use strict';

    var portfolioList = {};
    mkd.modules.portfolioList = portfolioList;

    portfolioList.mkdOnDocumentReady = mkdOnDocumentReady;
    portfolioList.mkdOnWindowLoad = mkdOnWindowLoad;
    portfolioList.mkdOnWindowResize = mkdOnWindowResize;
    portfolioList.mkdOnWindowScroll = mkdOnWindowScroll;

    $(document).ready(mkdOnDocumentReady);
    $(window).on('load', mkdOnWindowLoad);
    $(window).resize(mkdOnWindowResize);
    $(window).scroll(mkdOnWindowScroll);
    
    /* 
     All functions to be called on $(document).ready() should be in this function
     */
    function mkdOnDocumentReady() {
        mkdInitPortfolioOverlay();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function mkdOnWindowLoad() {
    	mkdInitPortfolioJustifiedGallery();
        mkdInitPortfolioMasonry();
        mkdInitPortfolioFilter();
        mkdInitPortfolioListAnimation();
	    mkdInitPortfolioPagination().init();
    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function mkdOnWindowResize() {
        mkdInitPortfolioMasonry();
    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function mkdOnWindowScroll() {
	    mkdInitPortfolioPagination().scroll();
    }

    /**
     * Initializes portfolio list article animation
     */
    function mkdInitPortfolioListAnimation(){
        var portList = $('.mkd-portfolio-list-holder.mkd-pl-has-animation');

        if(portList.length){
            portList.each(function(){
                var thisPortList = $(this).children('.mkd-pl-inner');

                thisPortList.children('article').each(function(l) {
                    var thisArticle = $(this);

                    thisArticle.appear(function() {
                        thisArticle.addClass('mkd-item-show');

                        setTimeout(function(){
                            thisArticle.addClass('mkd-item-shown');
                        }, 1000);
                    },{accX: 0, accY: 0});
                });
            });
        }
    }

    /**
     * Initializes portfolio list
     */
    function mkdInitPortfolioMasonry(){
        var portList = $('.mkd-portfolio-list-holder.mkd-pl-masonry');

        if(portList.length){
            portList.each(function(){
                var thisPortList = $(this),
                    masonry = thisPortList.children('.mkd-pl-inner'),
                    size = thisPortList.find('.mkd-pl-grid-sizer').width();
                
                mkdResizePortfolioItems(size, thisPortList);

                masonry.isotope({
                    layoutMode: 'packery',
                    itemSelector: 'article',
                    percentPosition: true,
                    packery: {
                        gutter: '.mkd-pl-grid-gutter',
                        columnWidth: '.mkd-pl-grid-sizer'
                    }
                });
                
                setTimeout(function () {
	                mkd.modules.common.mkdInitParallax();
                }, 600);

                masonry.css('opacity', '1');
            });
        }
    }

    /**
     * Init Resize Portfolio Items
     */
    function mkdResizePortfolioItems(size,container){
        if(container.hasClass('mkd-pl-images-fixed')) {
            var padding = parseInt(container.find('article').css('padding-left')),
                defaultMasonryItem = container.find('.mkd-pl-masonry-default'),
                largeWidthMasonryItem = container.find('.mkd-pl-masonry-large-width'),
                largeHeightMasonryItem = container.find('.mkd-pl-masonry-large-height'),
                largeWidthHeightMasonryItem = container.find('.mkd-pl-masonry-large-width-height');

            if (mkd.windowWidth > 680) {
                defaultMasonryItem.css('height', size - 2 * padding);
                largeHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthMasonryItem.css('height', size - 2 * padding);
            } else {
                defaultMasonryItem.css('height', size);
                largeHeightMasonryItem.css('height', size);
                largeWidthHeightMasonryItem.css('height', size);
                largeWidthMasonryItem.css('height', Math.round(size / 2));
            }
        }
    }

    /**
     * Initializes portfolio masonry filter
     */
    function mkdInitPortfolioFilter(){
        var filterHolder = $('.mkd-portfolio-list-holder .mkd-pl-filter-holder');

        if(filterHolder.length){
            filterHolder.each(function(){
                var thisFilterHolder = $(this),
                    thisPortListHolder = thisFilterHolder.closest('.mkd-portfolio-list-holder'),
                    thisPortListInner = thisPortListHolder.find('.mkd-pl-inner'),
                    portListHasLoadMore = thisPortListHolder.hasClass('mkd-pl-pag-load-more') ? true : false;

                thisFilterHolder.find('.mkd-pl-filter:first').addClass('mkd-pl-current');
	            
	            if(thisPortListHolder.hasClass('mkd-pl-gallery')) {
		            thisPortListInner.isotope();
	            }

                thisFilterHolder.find('.mkd-pl-filter').on('click', function(){
                    var thisFilter = $(this),
                        filterValue = thisFilter.attr('data-filter'),
                        filterClassName = filterValue.length ? filterValue.substring(1) : '',
	                    portListHasArticles = thisPortListInner.children().hasClass(filterClassName) ? true : false;

                    thisFilter.parent().children('.mkd-pl-filter').removeClass('mkd-pl-current');
                    thisFilter.addClass('mkd-pl-current');
	
	                if(portListHasLoadMore && !portListHasArticles && filterValue.length) {
		                mkdInitLoadMoreItemsPortfolioFilter(thisPortListHolder, filterValue, filterClassName);
	                } else {
		                filterValue = filterValue.length === 0 ? '*' : filterValue;
                   
                        thisFilterHolder.parent().children('.mkd-pl-inner').isotope({ filter: filterValue });
	                    mkd.modules.common.mkdInitParallax();
                    }
                });
            });
        }
    }

    /**
     * Initializes load more items if portfolio masonry filter item is empty
     */
    function mkdInitLoadMoreItemsPortfolioFilter($portfolioList, $filterValue, $filterClassName) {
        var thisPortList = $portfolioList,
            thisPortListInner = thisPortList.find('.mkd-pl-inner'),
            filterValue = $filterValue,
            filterClassName = $filterClassName,
            maxNumPages = 0;

        if (typeof thisPortList.data('max-num-pages') !== 'undefined' && thisPortList.data('max-num-pages') !== false) {
            maxNumPages = thisPortList.data('max-num-pages');
        }

        var	loadMoreDatta = mkd.modules.common.getLoadMoreData(thisPortList),
            nextPage = loadMoreDatta.nextPage,
	        ajaxData = mkd.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'mkd_core_portfolio_ajax_load_more'),
            loadingItem = thisPortList.find('.mkd-pl-loading');

        if(nextPage <= maxNumPages) {
            loadingItem.addClass('mkd-showing mkd-filter-trigger');
            thisPortListInner.css('opacity', '0');

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: mkdGlobalVars.vars.mkdAjaxUrl,
                success: function (data) {
                    nextPage++;
                    thisPortList.data('next-page', nextPage);
                    var response = $.parseJSON(data),
                        responseHtml = response.html;

                    thisPortList.waitForImages(function () {
                        thisPortListInner.append(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
                        var portListHasArticles = !!thisPortListInner.children().hasClass(filterClassName);

                        if(portListHasArticles) {
                            setTimeout(function() {
                                mkdResizePortfolioItems(thisPortListInner.find('.mkd-pl-grid-sizer').width(), thisPortList);
                                thisPortListInner.isotope('layout').isotope({filter: filterValue});
                                loadingItem.removeClass('mkd-showing mkd-filter-trigger');

                                setTimeout(function() {
                                    thisPortListInner.css('opacity', '1');
                                    mkdInitPortfolioListAnimation();
	                                mkd.modules.common.mkdInitParallax();
                                }, 150);
                            }, 400);
                        } else {
                            loadingItem.removeClass('mkd-showing mkd-filter-trigger');
                            mkdInitLoadMoreItemsPortfolioFilter(thisPortList, filterValue, filterClassName);
                        }
                    });
                }
            });
        }
    }
	
	/**
	 * Initializes portfolio pagination functions
	 */
	function mkdInitPortfolioPagination(){
		var portList = $('.mkd-portfolio-list-holder');
		
		var initStandardPagination = function(thisPortList) {
			var standardLink = thisPortList.find('.mkd-pl-standard-pagination li');
			
			if(standardLink.length) {
				standardLink.each(function(){
					var thisLink = $(this).children('a'),
						pagedLink = 1;
					
					thisLink.on('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						
						if (typeof thisLink.data('paged') !== 'undefined' && thisLink.data('paged') !== false) {
							pagedLink = thisLink.data('paged');
						}
						
						initMainPagFunctionality(thisPortList, pagedLink);
					});
				});
			}
		};
		
		var initLoadMorePagination = function(thisPortList) {
			var loadMoreButton = thisPortList.find('.mkd-pl-load-more a');
			
			loadMoreButton.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				initMainPagFunctionality(thisPortList);
			});
		};
		
		var initInifiteScrollPagination = function(thisPortList) {
			var portListHeight = thisPortList.outerHeight(),
				portListTopOffest = thisPortList.offset().top,
				portListPosition = portListHeight + portListTopOffest - mkdGlobalVars.vars.mkdAddForAdminBar;
			
			if(!thisPortList.hasClass('mkd-pl-infinite-scroll-started') && mkd.scroll + mkd.windowHeight > portListPosition) {
				initMainPagFunctionality(thisPortList);
			}
		};
		
		var initMainPagFunctionality = function(thisPortList, pagedLink) {
			var thisPortListInner = thisPortList.find('.mkd-pl-inner'),
				nextPage,
				maxNumPages;
			
			if (typeof thisPortList.data('max-num-pages') !== 'undefined' && thisPortList.data('max-num-pages') !== false) {
				maxNumPages = thisPortList.data('max-num-pages');
			}
			
			if(thisPortList.hasClass('mkd-pl-pag-standard')) {
				thisPortList.data('next-page', pagedLink);
			}
			
			if(thisPortList.hasClass('mkd-pl-pag-infinite-scroll')) {
				thisPortList.addClass('mkd-pl-infinite-scroll-started');
			}
			
			var loadMoreDatta = mkd.modules.common.getLoadMoreData(thisPortList),
				loadingItem = thisPortList.find('.mkd-pl-loading');
			
			nextPage = loadMoreDatta.nextPage;
			
			if(nextPage <= maxNumPages || maxNumPages == 0){
				if(thisPortList.hasClass('mkd-pl-pag-standard')) {
					loadingItem.addClass('mkd-showing mkd-standard-pag-trigger');
					thisPortList.addClass('mkd-pl-pag-standard-animate');
				} else {
					loadingItem.addClass('mkd-showing');
				}
				
				var ajaxData = mkd.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'mkd_core_portfolio_ajax_load_more');
				
				$.ajax({
					type: 'POST',
					data: ajaxData,
					url: mkdGlobalVars.vars.mkdAjaxUrl,
					success: function (data) {
						if(!thisPortList.hasClass('mkd-pl-pag-standard')) {
							nextPage++;
						}
						
						thisPortList.data('next-page', nextPage);
						
						var response = $.parseJSON(data),
							responseHtml =  response.html;
						
						if(thisPortList.hasClass('mkd-pl-pag-standard')) {
							mkdInitStandardPaginationLinkChanges(thisPortList, maxNumPages, nextPage);
							
							thisPortList.waitForImages(function(){
								if(thisPortList.hasClass('mkd-pl-masonry')){
									mkdInitHtmlIsotopeNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
								} else if (thisPortList.hasClass('mkd-pl-gallery') && thisPortList.hasClass('mkd-pl-has-filter')) {
									mkdInitHtmlIsotopeNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
								} else {
									mkdInitHtmlGalleryNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
								}
							});
						} else {
							thisPortList.waitForImages(function(){
								if(thisPortList.hasClass('mkd-pl-masonry')){
								    if(pagedLink == 1) {
                                        mkdInitHtmlIsotopeNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
                                    } else {
                                        mkdInitAppendIsotopeNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
                                    }
								} else if (thisPortList.hasClass('mkd-pl-gallery') && thisPortList.hasClass('mkd-pl-has-filter') && pagedLink != 1) {
									mkdInitAppendIsotopeNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
								} else {
								    if (pagedLink == 1) {
                                        mkdInitHtmlGalleryNewContent(thisPortList, thisPortListInner, loadingItem, responseHtml);
                                    } else {
                                        mkdInitAppendGalleryNewContent(thisPortListInner, loadingItem, responseHtml);
                                    }
								}
							});
						}
						
						if(thisPortList.hasClass('mkd-pl-infinite-scroll-started')) {
							thisPortList.removeClass('mkd-pl-infinite-scroll-started');
						}
					}
				});
			}
			
			if(nextPage === maxNumPages){
				thisPortList.find('.mkd-pl-load-more-holder').hide();
			}
		};
		
		var mkdInitStandardPaginationLinkChanges = function(thisPortList, maxNumPages, nextPage) {
			var standardPagHolder = thisPortList.find('.mkd-pl-standard-pagination'),
				standardPagNumericItem = standardPagHolder.find('li.mkd-pl-pag-number'),
				standardPagPrevItem = standardPagHolder.find('li.mkd-pl-pag-prev a'),
				standardPagNextItem = standardPagHolder.find('li.mkd-pl-pag-next a');
			
			standardPagNumericItem.removeClass('mkd-pl-pag-active');
			standardPagNumericItem.eq(nextPage-1).addClass('mkd-pl-pag-active');
			
			standardPagPrevItem.data('paged', nextPage-1);
			standardPagNextItem.data('paged', nextPage+1);
			
			if(nextPage > 1) {
				standardPagPrevItem.css({'opacity': '1'});
			} else {
				standardPagPrevItem.css({'opacity': '0'});
			}
			
			if(nextPage === maxNumPages) {
				standardPagNextItem.css({'opacity': '0'});
			} else {
				standardPagNextItem.css({'opacity': '1'});
			}
		};
		
		var mkdInitHtmlIsotopeNewContent = function(thisPortList, thisPortListInner, loadingItem, responseHtml) {
            thisPortListInner.find('article').remove();
            thisPortListInner.append(responseHtml);
            mkdResizePortfolioItems(thisPortListInner.find('.mkd-pl-grid-sizer').width(), thisPortList);
            thisPortListInner.isotope('reloadItems').isotope({sortBy: 'original-order'});
			loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
			thisPortList.removeClass('mkd-pl-pag-standard-animate');
			
			setTimeout(function() {
				thisPortListInner.isotope('layout');
                mkdInitPortfolioOverlay();
				mkdInitPortfolioListAnimation();
				mkd.modules.common.mkdInitParallax();
				mkd.modules.common.mkdPrettyPhoto();
			}, 600);
		};
		
		var mkdInitHtmlGalleryNewContent = function(thisPortList, thisPortListInner, loadingItem, responseHtml) {
			loadingItem.removeClass('mkd-showing mkd-standard-pag-trigger');
			thisPortList.removeClass('mkd-pl-pag-standard-animate');
			thisPortListInner.html(responseHtml);
            mkdInitPortfolioOverlay();
			mkdInitPortfolioListAnimation();
			mkd.modules.common.mkdInitParallax();
			mkd.modules.common.mkdPrettyPhoto();
		};
		
		var mkdInitAppendIsotopeNewContent = function(thisPortList, thisPortListInner, loadingItem, responseHtml) {
            thisPortListInner.append(responseHtml);
            mkdResizePortfolioItems(thisPortListInner.find('.mkd-pl-grid-sizer').width(), thisPortList);
            thisPortListInner.isotope('reloadItems').isotope({sortBy: 'original-order'});
			loadingItem.removeClass('mkd-showing');
			
			setTimeout(function() {
				thisPortListInner.isotope('layout');
                mkdInitPortfolioOverlay();
				mkdInitPortfolioListAnimation();
				mkd.modules.common.mkdInitParallax();
				mkd.modules.common.mkdPrettyPhoto();
			}, 600);
		};
		
		var mkdInitAppendGalleryNewContent = function(thisPortListInner, loadingItem, responseHtml) {
			loadingItem.removeClass('mkd-showing');
			thisPortListInner.append(responseHtml);
            mkdInitPortfolioOverlay();
			mkdInitPortfolioListAnimation();
			mkd.modules.common.mkdInitParallax();
			mkd.modules.common.mkdPrettyPhoto();
		};
		
		return {
			init: function() {
				if(portList.length) {
					portList.each(function() {
						var thisPortList = $(this);
						
						if(thisPortList.hasClass('mkd-pl-pag-standard')) {
							initStandardPagination(thisPortList);
						}
						
						if(thisPortList.hasClass('mkd-pl-pag-load-more')) {
							initLoadMorePagination(thisPortList);
						}
						
						if(thisPortList.hasClass('mkd-pl-pag-infinite-scroll')) {
							initInifiteScrollPagination(thisPortList);
						}
					});
				}
			},
			scroll: function() {
				if(portList.length) {
					portList.each(function() {
						var thisPortList = $(this);
						
						if(thisPortList.hasClass('mkd-pl-pag-infinite-scroll')) {
							initInifiteScrollPagination(thisPortList);
						}
					});
				}
			},
            getMainPagFunction: function(thisPortList, paged) {
                initMainPagFunctionality(thisPortList, paged);
            }
		};
	}

	/**
     * Initializes portfolio list justified gallery
     */
    function mkdInitPortfolioJustifiedGallery(){
        var portLists = $('.mkd-portfolio-list-holder.mkd-pl-justified-gallery');

        if(portLists.length){
            portLists.each(function(){
                var portList = $(this),
                    spacing = typeof portList.data('space-value') !== 'undefined' ? portList.data('space-value') : 7,
                    rowHeight = typeof portList.data('row-height') !== 'undefined' ? portList.data('row-height') : 500,
                    lastRow = typeof portList.data('last-row') !== 'undefined' ? portList.data('last-row') : 'nojustify',
                    justifyThreshold = typeof portList.data('justify-threshold') !== 'undefined' ? portList.data('justify-threshold') : 0.75;
                var thisPortList = portList.children('.mkd-pl-inner');

                thisPortList.waitForImages(function() {
                    thisPortList.justifiedGallery({
                        captions: false,
                        rowHeight: rowHeight,
                        margins: spacing,
                        border: 0,
                        lastRow: lastRow,
                        justifyThreshold: justifyThreshold,
                        selector: '> article'
                    }).on('jg.complete jg.rowflush', function() {
                        var gal = $(this);
                        var deducted = false;
                        gal.find('article').addClass('show').each(function() {
                            $(this).height(Math.round($(this).height()));
                            if (!deducted && $(this).width() == 0) {
                                gal.height(gal.height() - $(this).height() - spacing);
                                deducted = true;
                            }
                        });
                    });
                    portList.css('opacity', '1');
                });
            });
        }
    }

    /**
     * Inti portfolio shortcode on appear
     */
    function mkdInitPortfolioOverlay() {
        var holder = $('.mkd-portfolio-list-holder.mkd-pl-gallery-overlay article');

        if(holder.length) {
            holder.each(function(){
                var thisHolder = $(this);

                thisHolder.appear(function(){
                    thisHolder.addClass('mkd-ptf-appeared');
                },{accX: 0, accY: mkdGlobalVars.vars.mkdElementAppearAmount});
            });
        }
    }

})(jQuery);
