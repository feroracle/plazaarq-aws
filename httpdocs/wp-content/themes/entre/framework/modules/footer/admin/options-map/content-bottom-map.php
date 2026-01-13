<?php

if ( ! function_exists( 'entre_mikado_content_bottom_options_map' ) ) {
	function entre_mikado_content_bottom_options_map() {
		
		$panel_content_bottom = entre_mikado_add_admin_panel(
			array(
				'page'  => '_page_page',
				'name'  => 'panel_content_bottom',
				'title' => esc_html__( 'Content Bottom Area Style', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'enable_content_bottom_area',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Content Bottom Area', 'entre' ),
				'description'   => esc_html__( 'This option will enable Content Bottom area on pages', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_enable_content_bottom_area_container'
				),
				'parent'        => $panel_content_bottom
			)
		);
		
		$enable_content_bottom_area_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $panel_content_bottom,
				'name'            => 'enable_content_bottom_area_container',
				'hidden_property' => 'enable_content_bottom_area',
				'hidden_value'    => 'no'
			)
		);
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'selectblank',
				'name'          => 'content_bottom_sidebar_custom_display',
				'default_value' => '',
				'label'         => esc_html__( 'Widget Area to Display', 'entre' ),
				'description'   => esc_html__( 'Choose a Content Bottom widget area to display', 'entre' ),
				'options'       => $entre_custom_sidebars,
				'parent'        => $enable_content_bottom_area_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'content_bottom_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Display in Grid', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will place Content Bottom in grid', 'entre' ),
				'parent'        => $enable_content_bottom_area_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'        => 'color',
				'name'        => 'content_bottom_background_color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Choose a background color for Content Bottom area', 'entre' ),
				'parent'      => $enable_content_bottom_area_container
			)
		);
	}
	
	add_action( 'entre_mikado_additional_page_options_map', 'entre_mikado_content_bottom_options_map' );
}