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