<?php

if ( ! function_exists( 'entre_mikado_logo_options_map' ) ) {
	function entre_mikado_logo_options_map() {
		
		$panel_logo = entre_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_logo',
				'title' => esc_html__( 'Branding', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $panel_logo,
				'type'          => 'yesno',
				'name'          => 'hide_logo',
				'default_value' => 'no',
				'label'         => esc_html__( 'Hide Logo', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will hide logo image', 'entre' ),
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "#mkd_hide_logo_container",
					"dependence_show_on_yes" => ""
				)
			)
		);
		
		$hide_logo_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $panel_logo,
				'name'            => 'hide_logo_container',
				'hidden_property' => 'hide_logo',
				'hidden_value'    => 'yes'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'logo_image',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Default', 'entre' ),
				'parent'        => $hide_logo_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_dark',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Dark', 'entre' ),
				'parent'        => $hide_logo_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_light',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo_white.png",
				'label'         => esc_html__( 'Logo Image - Light', 'entre' ),
				'parent'        => $hide_logo_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_sticky',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Sticky', 'entre' ),
				'parent'        => $hide_logo_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'logo_image_mobile',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Mobile', 'entre' ),
				'parent'        => $hide_logo_container
			)
		);
	}
	
	add_action( 'entre_mikado_action_additional_general_settings', 'entre_mikado_logo_options_map' );
}