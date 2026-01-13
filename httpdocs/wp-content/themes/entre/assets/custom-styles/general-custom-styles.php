<?php

if(!function_exists('entre_mikado_design_styles')) {
    /**
     * Generates general custom styles
     */
    function entre_mikado_design_styles() {
	    $font_family = entre_mikado_options()->getOptionValue( 'google_fonts' );
	    if ( ! empty( $font_family ) && entre_mikado_is_font_option_valid( $font_family ) ) {
		    $font_family_selector = array(
			    'body'
		    );
		    echo entre_mikado_dynamic_css( $font_family_selector, array( 'font-family' => entre_mikado_get_font_option_val( $font_family ) ) );
	    }

		$first_main_color = entre_mikado_options()->getOptionValue('first_color');
        if(!empty($first_main_color)) {
            $color_selector = array(
                'blockquote>:before',
				'.mkd-comment-holder .mkd-comment-text #cancel-comment-reply-link',
				'.widget.widget_rss .mkd-widget-title .rsswidget:hover',
				'.widget.widget_search button:hover',
				'.widget.widget_tag_cloud a:hover',
				'.widget.widget_mkd_twitter_widget .mkd-twitter-widget.mkd-twitter-standard li .mkd-twitter-icon',
				'.widget.widget_mkd_twitter_widget .mkd-twitter-widget.mkd-twitter-slider li .mkd-tweet-text a',
				'.widget.widget_mkd_twitter_widget .mkd-twitter-widget.mkd-twitter-slider li .mkd-tweet-text span',
				'.widget.widget_mkd_twitter_widget .mkd-twitter-widget.mkd-twitter-standard li .mkd-tweet-text a:hover',
				'.widget.widget_mkd_twitter_widget .mkd-twitter-widget.mkd-twitter-slider li .mkd-twitter-icon i',
				'.widget_icl_lang_sel_widget .wpml-ls-legacy-dropdown .wpml-ls-item-toggle:hover',
				'.widget_icl_lang_sel_widget .wpml-ls-legacy-dropdown-click .wpml-ls-item-toggle:hover',
				'.mkd-bl-standard-pagination ul li.mkd-bl-pag-active a',
				'.mkd-author-description .mkd-author-description-text-holder .mkd-author-name a:hover',
				'.mkd-author-description .mkd-author-description-text-holder .mkd-author-social-icons a:hover',
				'.mkd-blog-single-navigation .mkd-blog-single-next:hover',
				'.mkd-blog-single-navigation .mkd-blog-single-prev:hover',
				'.mkd-header-bottom .mkd-header-bottom-menu-opener.active',
				'.mkd-header-vertical-closed .mkd-vertical-menu ul li a:hover',
				'.mkd-header-vertical-closed .mkd-vertical-menu ul li.current-menu-ancestor>a',
				'.mkd-header-vertical-closed .mkd-vertical-menu ul li.current-menu-item>a',
				'.mkd-header-vertical-closed .mkd-vertical-menu ul li.current_page_item>a',
				'.mkd-header-vertical-closed .mkd-vertical-menu ul li.mkd-active-item>a',
				'.mkd-header-vertical-compact .mkd-vertical-menu .mkd-menu-featured-icon',
				'.mkd-mobile-header .mkd-mobile-menu-opener.mkd-mobile-menu-opened a',
				'.mkd-mobile-header .mkd-mobile-nav .mkd-grid>ul>li.mkd-active-item>a',
				'.mkd-mobile-header .mkd-mobile-nav .mkd-grid>ul>li.mkd-active-item>h6',
				'.mkd-mobile-header .mkd-mobile-nav ul li a:hover',
				'.mkd-mobile-header .mkd-mobile-nav ul li h6:hover',
				'.mkd-mobile-header .mkd-mobile-nav ul ul li.current-menu-ancestor>a',
				'.mkd-mobile-header .mkd-mobile-nav ul ul li.current-menu-ancestor>h6',
				'.mkd-mobile-header .mkd-mobile-nav ul ul li.current-menu-item>a',
				'.mkd-mobile-header .mkd-mobile-nav ul ul li.current-menu-item>h6',
				'.mkd-search-page-holder article.sticky .mkd-post-title a',
				'.mkd-pl-filter-holder ul li.mkd-pl-current span',
				'.mkd-pl-filter-holder ul li:hover span',
				'.mkd-pl-standard-pagination ul li.mkd-pl-pag-active a',
				'.mkd-accordion-holder .mkd-accordion-title .mkd-accordion-mark',
				'.mkd-banner-holder .mkd-banner-link-text .mkd-banner-link-hover span',
				'.mkd-social-share-holder.mkd-list li a:hover',
				'.mkd-social-share-holder.mkd-dropdown .mkd-social-share-dropdown-opener:hover',
				'.mkd-team.main-info-below-image .mkd-team-social-wrapp .mkd-icon-shortcode span:hover',
				'.mkd-team.main-info-below-image.info-below-image-boxed .mkd-team-social-wrapp .mkd-icon-shortcode .flip-icon-holder .icon-normal span',
				'.mkd-team.main-info-below-image.info-below-image-standard .mkd-team-social-wrapp .mkd-icon-shortcode .flip-icon-holder .icon-flip span',
				'.mkd-team.main-info-on-hover .mkd-team-info-wrapper .mkd-team-position',
				'.mkd-team.main-info-on-hover .mkd-team-info-wrapper .mkd-team-social-wrapp span:hover',
				'.mkd-twitter-list-holder .mkd-twitter-icon',
				'.mkd-twitter-list-holder .mkd-tweet-text a:hover',
				'.mkd-twitter-list-holder .mkd-twitter-profile a:hover'
            );

            $woo_color_selector = array();
            if(entre_mikado_is_woocommerce_installed()) {
                $woo_color_selector = array(
					'.woocommerce-pagination .page-numbers li a.current',
					'.woocommerce-pagination .page-numbers li a:hover',
					'.woocommerce-pagination .page-numbers li span.current',
					'.woocommerce-pagination .page-numbers li span:hover',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-minus:hover',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-plus:hover',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-minus:hover',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-plus:hover',
					'.mkd-woo-single-page .mkd-single-product-summary .product_meta>span a:hover',
					'.widget.woocommerce.widget_layered_nav ul li.chosen a',
					'.widget.woocommerce.widget_product_tag_cloud .tagcloud a:hover'
                );
            }

            $color_selector = array_merge($color_selector, $woo_color_selector);

	        $color_important_selector = array(
		        
	        );

            $background_color_selector = array(
                '.mkd-st-loader .pulse',
				'.mkd-st-loader .double_pulse .double-bounce1',
				'.mkd-st-loader .double_pulse .double-bounce2',
				'.mkd-st-loader .cube',
				'.mkd-st-loader .rotating_cubes .cube1',
				'.mkd-st-loader .rotating_cubes .cube2',
				'.mkd-st-loader .stripes>div',
				'.mkd-st-loader .wave>div',
				'.mkd-st-loader .two_rotating_circles .dot1',
				'.mkd-st-loader .two_rotating_circles .dot2',
				'.mkd-st-loader .five_rotating_circles .container1>div',
				'.mkd-st-loader .five_rotating_circles .container2>div',
				'.mkd-st-loader .five_rotating_circles .container3>div',
				'.mkd-st-loader .atom .ball-1:before',
				'.mkd-st-loader .atom .ball-2:before',
				'.mkd-st-loader .atom .ball-3:before',
				'.mkd-st-loader .atom .ball-4:before',
				'.mkd-st-loader .clock .ball:before',
				'.mkd-st-loader .mitosis .ball',
				'.mkd-st-loader .lines .line1',
				'.mkd-st-loader .lines .line2',
				'.mkd-st-loader .lines .line3',
				'.mkd-st-loader .lines .line4',
				'.mkd-st-loader .fussion .ball',
				'.mkd-st-loader .fussion .ball-1',
				'.mkd-st-loader .fussion .ball-2',
				'.mkd-st-loader .fussion .ball-3',
				'.mkd-st-loader .fussion .ball-4',
				'.mkd-st-loader .wave_circles .ball',
				'.mkd-st-loader .pulse_circles .ball',
				'.entre-preloader .entre-background',
				'.mkd-404-page .mkd-page-not-found .mkd-404-text:before',
				'.widget #wp-calendar td#today',
				'.widget.widget_tag_cloud a:after',
				'.mkd-social-icons-group-widget.mkd-square-icons .mkd-social-icon-widget-holder:hover',
				'.mkd-social-icons-group-widget.mkd-square-icons.mkd-light-skin .mkd-social-icon-widget-holder:hover',
				'.mkd-blog-holder article .mkd-post-info-bottom .mkd-post-info-category>span',
				'.mkd-blog-holder article.format-link .mkd-post-text',
				'.mkd-blog-holder article.format-quote .mkd-post-text',
				'.mkd-blog-holder.mkd-blog-masonry-gallery article:not(.format-quote):not(.format-link) .mkd-post-text',
				'.mkd-blog-holder.mkd-blog-masonry-gallery article.format-quote .mkd-post-content .mkd-post-text .mkd-post-quote-holder .mkd-quote-author:before',
				'.mkd-author-description .mkd-author-description-text-holder .mkd-author-position-wrapper .mkd-autor-position:before',
				'nav.mkd-fullscreen-menu ul li a .mkd-fullscreen-menu-arrow',
				'.mkd-header-vertical-closed .mkd-vertical-menu-area .mkd-vertical-area-opener .mkd-vertical-area-opener-line',
				'.mkd-header-vertical-closed .mkd-vertical-menu-area .mkd-vertical-area-opener .mkd-vertical-area-opener-line:before',
				'.mkd-header-vertical-closed .mkd-vertical-menu-area .mkd-vertical-area-opener .mkd-vertical-area-opener-line:after',
				'.mkd-header-vertical-compact .mkd-vertical-menu>ul>li:hover',
				'.mkd-header-vertical-sliding .mkd-vertical-menu>ul>li>a:before',
				'.mkd-header-vertical-sliding .mkd-vertical-menu>ul>li>a:after',
				'.mkd-fullscreen-search-holder .mkd-field-holder:after',
				'.mkd-ps-navigation-wrapper',
				'.mkd-portfolio-list-holder.mkd-pl-floating-portfolio-item article .mkd-pl-item-inner .mkd-pli-image-holder .mkd-pli-image-drop-shadow',
				'.mkd-portfolio-list-holder.mkd-pl-floating-portfolio-item article .mkd-pl-item-inner .mkd-pli-category-holder:before',
				'.mkd-testimonials-holder.mkd-testimonials-standard .mkd-author-separator-line',
				'.mkd-accordion-holder.mkd-ac-boxed .mkd-accordion-title.ui-state-active',
				'.mkd-accordion-holder.mkd-ac-boxed .mkd-accordion-title.ui-state-hover',
				'.mkd-icon-shortcode.mkd-circle',
				'.mkd-icon-shortcode.mkd-dropcaps.mkd-circle',
				'.mkd-icon-shortcode.mkd-square',
				'.mkd-progress-bar .mkd-pb-content-holder .mkd-pb-content',
				'.mkd-single-image-holder.mkd-image-has-drop-shadow-effect .mkd-si-inner .mkd-si-drop-shadow',
				'.mkd-tabs.mkd-tabs-standard .mkd-tabs-nav li.ui-state-active a',
				'.mkd-tabs.mkd-tabs-standard .mkd-tabs-nav li.ui-state-hover a',
				'.mkd-tabs.mkd-tabs-boxed .mkd-tabs-nav li.ui-state-active a',
				'.mkd-tabs.mkd-tabs-boxed .mkd-tabs-nav li.ui-state-hover a',
				'.mkd-tabs.mkd-tabs-simple .mkd-tabs-nav li a:after',
				'.mkd-tabs.mkd-tabs-vertical .mkd-tabs-nav li a:before'
            );

            $woo_background_color_selector = array();
            if(entre_mikado_is_woocommerce_installed()) {
                $woo_background_color_selector = array(
	                'ul.products>.product .mkd-pl-inner .mkd-pl-text',
					'.mkd-woo-single-page .woocommerce-tabs ul.tabs>li a:after',
					'.mkd-woo-single-page .mkd-related-products .mkd-full-width-inner-wrapper',
					'.mkd-shopping-cart-holder .mkd-header-cart .mkd-cart-icon .mkd-cart-number',
					'.widget.woocommerce.widget_price_filter .price_slider_wrapper .ui-widget-content .ui-slider-handle',
					'.widget.woocommerce.widget_price_filter .price_slider_wrapper .ui-widget-content .ui-slider-range',
					'.widget.woocommerce.widget_product_tag_cloud .tagcloud a:after',
                );
            }

            $background_color_selector = array_merge($background_color_selector, $woo_background_color_selector);

            $border_color_selector = array(
                '.mkd-st-loader .pulse_circles .ball',
				'.mkd-accordion-holder.mkd-ac-boxed .mkd-accordion-title',
				'.mkd-accordion-holder.mkd-ac-boxed .mkd-accordion-title.ui-state-active',
				'.mkd-accordion-holder.mkd-ac-boxed .mkd-accordion-title.ui-state-hover',
				'.mkd-accordion-holder.mkd-ac-simple .mkd-accordion-content.ui-accordion-content-active',
				'.mkd-pie-chart-holder .mkd-pc-percentage .mkd-pc-percent',
				'.mkd-price-table .mkd-pt-inner',
				'.mkd-accordion-holder.mkd-ac-simple .mkd-accordion-title',
				'.mkd-price-table .mkd-pt-inner ul li.mkd-pt-title-holder .mkd-pt-title',
				'.mkd-separator'
            );

            $woo_border_color_selector = array();
            if(entre_mikado_is_woocommerce_installed()) {
            	  $woo_border_color_selector = array(
            	  	'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-input:focus',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-minus:focus',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-plus:focus',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-input:focus',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-minus:focus',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-plus:focus',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-input',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-minus',
					'.woocommerce-page .mkd-content .mkd-quantity-buttons .mkd-quantity-plus',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-input',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-minus',
					'div.woocommerce .mkd-quantity-buttons .mkd-quantity-plus'
            	  );
            }

            $border_color_selector = array_merge($border_color_selector, $woo_border_color_selector);

            echo entre_mikado_dynamic_css($color_selector, array('color' => $first_main_color));
	        echo entre_mikado_dynamic_css($color_important_selector, array('color' => $first_main_color.'!important'));
	        echo entre_mikado_dynamic_css($background_color_selector, array('background-color' => $first_main_color));
	        echo entre_mikado_dynamic_css($border_color_selector, array('border-color' => $first_main_color));
        }
	
	    $page_background_color = entre_mikado_options()->getOptionValue( 'page_background_color' );
	    if ( ! empty( $page_background_color ) ) {
		    $background_color_selector = array(
			    'body',
			    '.mkd-content'
		    );
		    echo entre_mikado_dynamic_css( $background_color_selector, array( 'background-color' => $page_background_color ) );
	    }
	
	    $selection_color = entre_mikado_options()->getOptionValue( 'selection_color' );
	    if ( ! empty( $selection_color ) ) {
		    echo entre_mikado_dynamic_css( '::selection', array( 'background' => $selection_color ) );
		    echo entre_mikado_dynamic_css( '::-moz-selection', array( 'background' => $selection_color ) );
	    }
	
	    $preload_background_styles = array();
	
	    if ( entre_mikado_options()->getOptionValue( 'preload_pattern_image' ) !== "" ) {
		    $preload_background_styles['background-image'] = 'url(' . entre_mikado_options()->getOptionValue( 'preload_pattern_image' ) . ') !important';
	    }
	
	    echo entre_mikado_dynamic_css( '.mkd-preload-background', $preload_background_styles );
    }

    add_action('entre_mikado_style_dynamic', 'entre_mikado_design_styles');
}

if ( ! function_exists( 'entre_mikado_content_styles' ) ) {
	function entre_mikado_content_styles() {
		$content_style = array();
		
		$padding_top = entre_mikado_options()->getOptionValue( 'content_top_padding' );
		if ( $padding_top !== '' ) {
			$content_style['padding-top'] = entre_mikado_filter_px( $padding_top ) . 'px';
		}
		
		$content_selector = array(
			'.mkd-content .mkd-content-inner > .mkd-full-width > .mkd-full-width-inner',
		);
		
		echo entre_mikado_dynamic_css( $content_selector, $content_style );
		
		$content_style_in_grid = array();
		
		$padding_top_in_grid = entre_mikado_options()->getOptionValue( 'content_top_padding_in_grid' );
		if ( $padding_top_in_grid !== '' ) {
			$content_style_in_grid['padding-top'] = entre_mikado_filter_px( $padding_top_in_grid ) . 'px';
		}
		
		$content_selector_in_grid = array(
			'.mkd-content .mkd-content-inner > .mkd-container > .mkd-container-inner',
		);
		
		echo entre_mikado_dynamic_css( $content_selector_in_grid, $content_style_in_grid );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_content_styles' );
}

if ( ! function_exists( 'entre_mikado_h1_styles' ) ) {
	function entre_mikado_h1_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h1_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h1_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h1' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h1'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h1_styles' );
}

if ( ! function_exists( 'entre_mikado_h2_styles' ) ) {
	function entre_mikado_h2_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h2_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h2_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h2' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h2'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h2_styles' );
}

if ( ! function_exists( 'entre_mikado_h3_styles' ) ) {
	function entre_mikado_h3_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h3_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h3_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h3' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h3'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h3_styles' );
}

if ( ! function_exists( 'entre_mikado_h4_styles' ) ) {
	function entre_mikado_h4_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h4_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h4_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h4' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h4'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h4_styles' );
}

if ( ! function_exists( 'entre_mikado_h5_styles' ) ) {
	function entre_mikado_h5_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h5_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h5_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h5' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h5'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h5_styles' );
}

if ( ! function_exists( 'entre_mikado_h6_styles' ) ) {
	function entre_mikado_h6_styles() {
		$margin_top    = entre_mikado_options()->getOptionValue( 'h6_margin_top' );
		$margin_bottom = entre_mikado_options()->getOptionValue( 'h6_margin_bottom' );
		
		$item_styles = entre_mikado_get_typography_styles( 'h6' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = entre_mikado_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = entre_mikado_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h6'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_h6_styles' );
}

if ( ! function_exists( 'entre_mikado_text_styles' ) ) {
	function entre_mikado_text_styles() {
		$item_styles = entre_mikado_get_typography_styles( 'text' );
		
		$item_selector = array(
			'p'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_text_styles' );
}

if ( ! function_exists( 'entre_mikado_link_styles' ) ) {
	function entre_mikado_link_styles() {
		$link_styles      = array();
		$link_color       = entre_mikado_options()->getOptionValue( 'link_color' );
		$link_font_style  = entre_mikado_options()->getOptionValue( 'link_fontstyle' );
		$link_font_weight = entre_mikado_options()->getOptionValue( 'link_fontweight' );
		$link_decoration  = entre_mikado_options()->getOptionValue( 'link_fontdecoration' );
		
		if ( ! empty( $link_color ) ) {
			$link_styles['color'] = $link_color;
		}
		if ( ! empty( $link_font_style ) ) {
			$link_styles['font-style'] = $link_font_style;
		}
		if ( ! empty( $link_font_weight ) ) {
			$link_styles['font-weight'] = $link_font_weight;
		}
		if ( ! empty( $link_decoration ) ) {
			$link_styles['text-decoration'] = $link_decoration;
		}
		
		$link_selector = array(
			'a',
			'p a'
		);
		
		if ( ! empty( $link_styles ) ) {
			echo entre_mikado_dynamic_css( $link_selector, $link_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_link_styles' );
}

if ( ! function_exists( 'entre_mikado_link_hover_styles' ) ) {
	function entre_mikado_link_hover_styles() {
		$link_hover_styles     = array();
		$link_hover_color      = entre_mikado_options()->getOptionValue( 'link_hovercolor' );
		$link_hover_decoration = entre_mikado_options()->getOptionValue( 'link_hover_fontdecoration' );
		
		if ( ! empty( $link_hover_color ) ) {
			$link_hover_styles['color'] = $link_hover_color;
		}
		if ( ! empty( $link_hover_decoration ) ) {
			$link_hover_styles['text-decoration'] = $link_hover_decoration;
		}
		
		$link_hover_selector = array(
			'a:hover',
			'p a:hover'
		);
		
		if ( ! empty( $link_hover_styles ) ) {
			echo entre_mikado_dynamic_css( $link_hover_selector, $link_hover_styles );
		}
		
		$link_heading_hover_styles = array();
		
		if ( ! empty( $link_hover_color ) ) {
			$link_heading_hover_styles['color'] = $link_hover_color;
		}
		
		$link_heading_hover_selector = array(
			'h1 a:hover',
			'h2 a:hover',
			'h3 a:hover',
			'h4 a:hover',
			'h5 a:hover',
			'h6 a:hover'
		);
		
		if ( ! empty( $link_heading_hover_styles ) ) {
			echo entre_mikado_dynamic_css( $link_heading_hover_selector, $link_heading_hover_styles );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_link_hover_styles' );
}

if ( ! function_exists( 'entre_mikado_smooth_page_transition_styles' ) ) {
	function entre_mikado_smooth_page_transition_styles( $style ) {
		$id            = entre_mikado_get_page_id();
		$loader_style  = array();
		$current_style = '';
		
		$background_color = entre_mikado_get_meta_field_intersect( 'smooth_pt_bgnd_color', $id );
		if ( ! empty( $background_color ) ) {
			$loader_style['background-color'] = $background_color;
		}
		
		$loader_selector = array(
			'.mkd-smooth-transition-loader'
		);
		
		if ( ! empty( $loader_style ) ) {
			$current_style .= entre_mikado_dynamic_css( $loader_selector, $loader_style );
		}
		
		$spinner_style = array();
		$spinner_color = entre_mikado_get_meta_field_intersect( 'smooth_pt_spinner_color', $id );
		if ( ! empty( $spinner_color ) ) {
			$spinner_style['background-color'] = $spinner_color;
		}
		
		$spinner_selectors = array(
			'.mkd-st-loader .mkd-rotate-circles > div',
			'.mkd-st-loader .pulse',
			'.mkd-st-loader .double_pulse .double-bounce1',
			'.mkd-st-loader .double_pulse .double-bounce2',
			'.mkd-st-loader .cube',
			'.mkd-st-loader .rotating_cubes .cube1',
			'.mkd-st-loader .rotating_cubes .cube2',
			'.mkd-st-loader .stripes > div',
			'.mkd-st-loader .wave > div',
			'.mkd-st-loader .two_rotating_circles .dot1',
			'.mkd-st-loader .two_rotating_circles .dot2',
			'.mkd-st-loader .five_rotating_circles .container1 > div',
			'.mkd-st-loader .five_rotating_circles .container2 > div',
			'.mkd-st-loader .five_rotating_circles .container3 > div',
			'.mkd-st-loader .atom .ball-1:before',
			'.mkd-st-loader .atom .ball-2:before',
			'.mkd-st-loader .atom .ball-3:before',
			'.mkd-st-loader .atom .ball-4:before',
			'.mkd-st-loader .clock .ball:before',
			'.mkd-st-loader .mitosis .ball',
			'.mkd-st-loader .lines .line1',
			'.mkd-st-loader .lines .line2',
			'.mkd-st-loader .lines .line3',
			'.mkd-st-loader .lines .line4',
			'.mkd-st-loader .fussion .ball',
			'.mkd-st-loader .fussion .ball-1',
			'.mkd-st-loader .fussion .ball-2',
			'.mkd-st-loader .fussion .ball-3',
			'.mkd-st-loader .fussion .ball-4',
			'.mkd-st-loader .wave_circles .ball',
			'.mkd-st-loader .pulse_circles .ball'
		);
		
		if ( ! empty( $spinner_style ) ) {
			$current_style .= entre_mikado_dynamic_css( $spinner_selectors, $spinner_style );
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'entre_mikado_add_page_custom_style', 'entre_mikado_smooth_page_transition_styles' );
}