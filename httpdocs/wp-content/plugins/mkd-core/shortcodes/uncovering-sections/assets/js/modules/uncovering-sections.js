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