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