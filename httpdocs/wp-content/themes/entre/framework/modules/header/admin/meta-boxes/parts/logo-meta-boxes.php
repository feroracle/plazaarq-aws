<?php

if ( ! function_exists( 'entre_mikado_logo_meta_box_map' ) ) {
	function entre_mikado_logo_meta_box_map() {
		
		$logo_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page', 'post' ), 'logo_meta' ),
				'title' => esc_html__( 'Logo', 'entre' ),
				'name'  => 'logo_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Default', 'entre' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'entre' ),
				'parent'      => $logo_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_image_dark_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Dark', 'entre' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'entre' ),
				'parent'      => $logo_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_image_light_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Light', 'entre' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'entre' ),
				'parent'      => $logo_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_image_sticky_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Sticky', 'entre' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'entre' ),
				'parent'      => $logo_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_image_mobile_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Mobile', 'entre' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'entre' ),
				'parent'      => $logo_meta_box
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_logo_meta_box_map', 47 );
}