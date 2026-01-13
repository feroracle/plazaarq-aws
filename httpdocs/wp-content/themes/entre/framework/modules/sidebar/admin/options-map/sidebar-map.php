<?php

if ( ! function_exists( 'entre_mikado_sidebar_options_map' ) ) {
	function entre_mikado_sidebar_options_map() {
		
		$sidebar_panel = entre_mikado_add_admin_panel(
			array(
				'title' => esc_html__( 'Sidebar Area', 'entre' ),
				'name'  => 'sidebar',
				'page'  => '_page_page'
			)
		);
		
		entre_mikado_add_admin_field( array(
			'name'          => 'sidebar_layout',
			'type'          => 'select',
			'label'         => esc_html__( 'Sidebar Layout', 'entre' ),
			'description'   => esc_html__( 'Choose a sidebar layout for pages', 'entre' ),
			'parent'        => $sidebar_panel,
			'default_value' => 'no-sidebar',
            'options'       => entre_mikado_get_custom_sidebars_options()
		) );
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_add_admin_field( array(
				'name'        => 'custom_sidebar_area',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'entre' ),
				'description' => esc_html__( 'Choose a sidebar to display on pages. Default sidebar is "Sidebar"', 'entre' ),
				'parent'      => $sidebar_panel,
				'options'     => $entre_custom_sidebars,
				'args'        => array(
					'select2' => true
				)
			) );
		}
	}
	
	add_action( 'entre_mikado_additional_page_options_map', 'entre_mikado_sidebar_options_map' );
}