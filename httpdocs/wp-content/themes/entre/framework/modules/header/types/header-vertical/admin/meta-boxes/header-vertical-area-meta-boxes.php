<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_vertical_area_meta_boxes' ) ) {
	function entre_mikado_get_hide_dep_for_header_vertical_area_meta_boxes() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_vertical_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_vertical_area_meta_options_map' ) ) {
	function entre_mikado_header_vertical_area_meta_options_map( $header_meta_box ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_vertical_area_meta_boxes();
		
		$header_vertical_area_meta_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $header_meta_box,
				'name'            => 'header_vertical_area_container',
				'hidden_property' => 'mkd_header_type_meta',
				'hidden_values'   => $hide_dep_options
			)
		);
		
		entre_mikado_add_admin_section_title(
			array(
				'parent' => $header_vertical_area_meta_container,
				'name'   => 'vertical_area_style',
				'title'  => esc_html__( 'Vertical Area Style', 'entre' )
			)
		);
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_create_meta_box_field(
				array(
					'name'        => 'mkd_custom_vertical_area_sidebar_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Custom Widget Area in Vertical area', 'entre' ),
					'description' => esc_html__( 'Choose custom widget area to display in vertical menu"', 'entre' ),
					'parent'      => $header_vertical_area_meta_container,
					'options'     => $entre_custom_sidebars
				)
			);
		}
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_vertical_header_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Set background color for vertical menu', 'entre' ),
				'parent'      => $header_vertical_area_meta_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_vertical_header_background_image_meta',
				'type'          => 'image',
				'default_value' => '',
				'label'         => esc_html__( 'Background Image', 'entre' ),
				'description'   => esc_html__( 'Set background image for vertical menu', 'entre' ),
				'parent'        => $header_vertical_area_meta_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_disable_vertical_header_background_image_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Disable Background Image', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will hide background image in Vertical Menu', 'entre' ),
				'parent'        => $header_vertical_area_meta_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_vertical_header_shadow_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Shadow', 'entre' ),
				'description'   => esc_html__( 'Set shadow on vertical menu', 'entre' ),
				'parent'        => $header_vertical_area_meta_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array()
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_vertical_header_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Vertical Area Border', 'entre' ),
				'description'   => esc_html__( 'Set border on vertical area', 'entre' ),
				'parent'        => $header_vertical_area_meta_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_vertical_header_border_container',
						'no'  => '#mkd_vertical_header_border_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_vertical_header_border_container'
					)
				)
			)
		);
		
		$vertical_header_border_container = entre_mikado_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'vertical_header_border_container',
				'parent'          => $header_vertical_area_meta_container,
				'hidden_property' => 'mkd_vertical_header_border_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_vertical_header_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'entre' ),
				'description' => esc_html__( 'Choose color of border', 'entre' ),
				'parent'      => $vertical_header_border_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_vertical_header_center_content_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Center Content', 'entre' ),
				'description'   => esc_html__( 'Set content in vertical center', 'entre' ),
				'parent'        => $header_vertical_area_meta_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array()
			)
		);
	}
	
	add_action( 'entre_mikado_additional_header_area_meta_boxes_map', 'entre_mikado_header_vertical_area_meta_options_map', 10, 1 );
}