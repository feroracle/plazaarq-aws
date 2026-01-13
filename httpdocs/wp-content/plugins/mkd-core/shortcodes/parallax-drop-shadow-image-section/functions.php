<?php

if ( ! function_exists( 'mkd_core_add_parallax_drop_shadow_image_section_shortcodes' ) ) {
	function mkd_core_add_parallax_drop_shadow_image_section_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\ParallaxDropShadowImageSection\ParallaxDropShadowImageSection'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_parallax_drop_shadow_image_section_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_parallax_drop_shadow_image_section_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for image gallery shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function mkd_core_set_parallax_drop_shadow_image_section_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-parallax-ds-image-section';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_icon_class', 'mkd_core_set_parallax_drop_shadow_image_section_icon_class_name_for_vc_shortcodes' );
}
