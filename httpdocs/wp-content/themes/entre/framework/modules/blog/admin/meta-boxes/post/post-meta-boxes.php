<?php

/*** Post Settings ***/

if ( ! function_exists( 'entre_mikado_map_post_meta' ) ) {
	function entre_mikado_map_post_meta() {
		
		$post_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Post', 'entre' ),
				'name'  => 'post-meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_blog_single_sidebar_layout_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'entre' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog single page', 'entre' ),
				'default_value' => '',
				'parent'        => $post_meta_box,
                'options'       => entre_mikado_get_custom_sidebars_options( true )
			)
		);
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_create_meta_box_field( array(
				'name'        => 'mkd_blog_single_custom_sidebar_area_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'entre' ),
				'description' => esc_html__( 'Choose a sidebar to display on Blog single page. Default sidebar is "Sidebar"', 'entre' ),
				'parent'      => $post_meta_box,
				'options'     => entre_mikado_get_custom_sidebars(),
				'args' => array(
					'select2' => true
				)
			) );
		}
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_blog_list_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Blog List Image', 'entre' ),
				'description' => esc_html__( 'Choose an Image for displaying in blog list. If not uploaded, featured image will be shown.', 'entre' ),
				'parent'      => $post_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_blog_masonry_gallery_fixed_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Fixed Proportion', 'entre' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry lists in fixed proportion', 'entre' ),
				'default_value' => 'default',
				'parent'        => $post_meta_box,
				'options'       => array(
					'default'            => esc_html__( 'Default', 'entre' ),
					'large-width'        => esc_html__( 'Large Width', 'entre' ),
					'large-height'       => esc_html__( 'Large Height', 'entre' ),
					'large-width-height' => esc_html__( 'Large Width/Height', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_blog_masonry_gallery_original_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Original Proportion', 'entre' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry lists in original proportion', 'entre' ),
				'default_value' => 'default',
				'parent'        => $post_meta_box,
				'options'       => array(
					'default'     => esc_html__( 'Default', 'entre' ),
					'large-width' => esc_html__( 'Large Width', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_show_title_area_blog_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single post page', 'entre' ),
				'parent'        => $post_meta_box,
				'options'       => entre_mikado_get_yes_no_select_array()
			)
		);

		do_action('entre_mikado_blog_post_meta', $post_meta_box);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_meta', 20 );
}
