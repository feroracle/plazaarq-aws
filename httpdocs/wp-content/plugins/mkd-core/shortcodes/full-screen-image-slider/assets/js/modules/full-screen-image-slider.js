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