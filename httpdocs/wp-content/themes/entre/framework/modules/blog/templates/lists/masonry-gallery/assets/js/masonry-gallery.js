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