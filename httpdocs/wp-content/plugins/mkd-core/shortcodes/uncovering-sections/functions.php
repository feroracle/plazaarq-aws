<?php

if ( ! function_exists( 'mkd_core_enqueue_scripts_for_uncovering_sections_shortcodes' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this shortcode
	 */
	function mkd_core_enqueue_scripts_for_uncovering_sections_shortcodes() {
		wp_enqueue_script( 'curtain', MIKADO_CORE_SHORTCODES_URL_PATH . '/uncovering-sections/assets/js/plugins/curtain.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'entre_mikado_enqueue_third_party_scripts', 'mkd_core_enqueue_scripts_for_uncovering_sections_shortcodes' );
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Mikado_Uncovering_Sections extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Mikado_Uncovering_Sections_Item extends WPBakeryShortCodesContainer {}
}

if ( ! function_exists( 'mkd_core_add_uncovering_sections_shortcodes' ) ) {
	function mkd_core_add_uncovering_sections_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\UncoveringSections\UncoveringSections',
			'MikadoCore\CPT\Shortcodes\UncoveringSections\UncoveringSectionsItem'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_uncovering_sections_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_uncovering_sections_custom_style_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom css style for full screen sections holder shortcode
	 */
	function mkd_core_set_uncovering_sections_custom_style_for_vc_shortcodes( $style ) {
		$current_style = '.vc_shortcodes_container.wpb_mkd_uncovering_sections_item { 
			background-color: #f4f4f4; 
		}';
		
		$style .= $current_style;
		
		return $style;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_style', 'mkd_core_set_uncovering_sections_custom_style_for_vc_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_uncovering_sections_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for full screen sections holder shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function mkd_core_set_uncovering_sections_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-uncovering-sections';
		$shortcodes_icon_class_array[] = '.icon-wpb-uncovering-sections-item';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_icon_class', 'mkd_core_set_uncovering_sections_icon_class_name_for_vc_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_uncovering_sections_header_top_custom_styles' ) ) {
    /**
     * Function that set custom icon class name for full screen sections holder shortcode to set our icon for Visual Composer shortcodes panel
     */
    function mkd_core_set_uncovering_sections_header_top_custom_styles() {
        $top_header_height = entre_mikado_options()->getOptionValue( 'top_bar_height' );

        if ( ! empty( $top_header_height ) ) {
            echo entre_mikado_dynamic_css( '.mkd-uncovering-section-on-page:not(.mkd-header-bottom).mkd-header-top-enabled .mkd-top-bar', array( 'top' => '-' . entre_mikado_filter_px( $top_header_height ) . 'px' ) );
            echo entre_mikado_dynamic_css( '.mkd-uncovering-section-on-page:not(.mkd-header-bottom).mkd-header-top-enabled:not(.mkd-sticky-header-appear) .mkd-page-header', array( 'top' => entre_mikado_filter_px( $top_header_height ) . 'px' ) );
        }
    }

    add_action( 'entre_mikado_style_dynamic', 'mkd_core_set_uncovering_sections_header_top_custom_styles' );
}