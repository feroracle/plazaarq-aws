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
						mkd.modules.googleMap.mkdShowGoogleMap();
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