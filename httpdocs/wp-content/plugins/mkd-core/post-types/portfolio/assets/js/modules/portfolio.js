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