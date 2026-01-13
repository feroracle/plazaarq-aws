<?php

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Mkd_Split_Scrolling_Section extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Mkd_Split_Scrolling_Section_Left_Panel extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Mkd_Split_Scrolling_Section_Right_Panel extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Mkd_Split_Scrolling_Section_Content_Item extends WPBakeryShortCodesContainer {}
}

if ( ! function_exists( 'mkd_core_add_split_scrolling_section_shortcodes' ) ) {
	function mkd_core_add_split_scrolling_section_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\SplitScrollingSection\SplitScrollingSection',
			'MikadoCore\CPT\Shortcodes\SplitScrollingSectionContentItem\SplitScrollingSectionContentItem',
			'MikadoCore\CPT\Shortcodes\SplitScrollingSectionLeftPanel\SplitScrollingSectionLeftPanel',
			'MikadoCore\CPT\Shortcodes\SplitScrollingSectionRightPanel\SplitScrollingSectionRightPanel'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_split_scrolling_section_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_split_scrolling_section_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for split scrolling sections shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function mkd_core_set_split_scrolling_section_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-split-scrolling-section';
		$shortcodes_icon_class_array[] = '.icon-wpb-split-scrolling-section-content-item';
		$shortcodes_icon_class_array[] = '.icon-wpb-split-section-left-panel';
		$shortcodes_icon_class_array[] = '.icon-wpb-split-section-right-panel';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_icon_class', 'mkd_core_set_split_scrolling_section_icon_class_name_for_vc_shortcodes' );
}