<?php

if ( ! function_exists( 'entre_mikado_map_content_bottom_meta' ) ) {
	function entre_mikado_map_content_bottom_meta() {
		
		$content_bottom_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page', 'post' ), 'content_bottom_meta' ),
				'title' => esc_html__( 'Content Bottom', 'entre' ),
				'name'  => 'content_bottom_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_enable_content_bottom_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Enable Content Bottom Area', 'entre' ),
				'description'   => esc_html__( 'This option will enable Content Bottom area on pages', 'entre' ),
				'parent'        => $content_bottom_meta_box,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''   => '#mkd_mkd_show_content_bottom_meta_container',
						'no' => '#mkd_mkd_show_content_bottom_meta_container'
					),
					'show'       => array(
						'yes' => '#mkd_mkd_show_content_bottom_meta_container'
					)
				)
			)
		);
		
		$show_content_bottom_meta_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $content_bottom_meta_box,
				'name'            => 'mkd_show_content_bottom_meta_container',
				'hidden_property' => 'mkd_enable_content_bottom_area_meta',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_content_bottom_sidebar_custom_display_meta',
				'type'          => 'selectblank',
				'default_value' => '',
				'label'         => esc_html__( 'Sidebar to Display', 'entre' ),
				'description'   => esc_html__( 'Choose a content bottom sidebar to display', 'entre' ),
				'options'       => entre_mikado_get_custom_sidebars(),
				'parent'        => $show_content_bottom_meta_container,
				'args'          => array(
					'select2' => true
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_content_bottom_in_grid_meta',
				'default_value' => '',
				'label'         => esc_html__( 'Display in Grid', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will place content bottom in grid', 'entre' ),
				'options'       => entre_mikado_get_yes_no_select_array(),
				'parent'        => $show_content_bottom_meta_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'type'        => 'color',
				'name'        => 'mkd_content_bottom_background_color_meta',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Choose a background color for content bottom area', 'entre' ),
				'parent'      => $show_content_bottom_meta_container
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_content_bottom_meta', 71 );
}