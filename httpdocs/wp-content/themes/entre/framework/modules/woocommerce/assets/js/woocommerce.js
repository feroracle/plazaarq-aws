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