<?php

if ( ! function_exists('entre_mikado_contact_form_map') ) {
	/**
	 * Map Contact Form 7 shortcode
	 * Hooks on vc_after_init action
	 */
	function entre_mikado_contact_form_map() {
		vc_add_param('contact-form-7', array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'entre'),
			'param_name' => 'html_class',
			'value' => array(
				esc_html__('Default', 'entre') => 'default',
				esc_html__('Custom Style 1', 'entre') => 'cf7_custom_style_1',
				esc_html__('Custom Style 2', 'entre') => 'cf7_custom_style_2',
				esc_html__('Custom Style 3', 'entre') => 'cf7_custom_style_3'
			),
			'description' => esc_html__('You can style each form element individually in Mikado Options > Contact Form 7', 'entre')
		));
	}
	
	add_action('vc_after_init', 'entre_mikado_contact_form_map');
}