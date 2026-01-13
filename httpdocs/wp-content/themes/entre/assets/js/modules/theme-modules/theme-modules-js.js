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