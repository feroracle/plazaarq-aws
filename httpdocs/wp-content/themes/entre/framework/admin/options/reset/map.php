<?php

if ( ! function_exists( 'entre_mikado_reset_options_map' ) ) {
	/**
	 * Reset options panel
	 */
	function entre_mikado_reset_options_map() {
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_reset_page',
				'title' => esc_html__( 'Reset', 'entre' ),
				'icon'  => 'fa fa-retweet'
			)
		);
		
		$panel_reset = entre_mikado_add_admin_panel(
			array(
				'page'  => '_reset_page',
				'name'  => 'panel_reset',
				'title' => esc_html__( 'Reset', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'reset_to_defaults',
				'default_value' => 'no',
				'label'         => esc_html__( 'Reset to Defaults', 'entre' ),
				'description'   => esc_html__( 'This option will reset all Select Options values to defaults', 'entre' ),
				'parent'        => $panel_reset
			)
		);
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_reset_options_map', 100 );
}