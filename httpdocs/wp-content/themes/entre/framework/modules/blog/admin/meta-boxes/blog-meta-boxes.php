<?php

foreach ( glob( MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/blog/admin/meta-boxes/*/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'entre_mikado_map_blog_meta' ) ) {
	function entre_mikado_map_blog_meta() {
		$mkd_blog_categories = array();
		$categories           = get_categories();
		foreach ( $categories as $category ) {
			$mkd_blog_categories[ $category->slug ] = $category->name;
		}
		
		$blog_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'page' ),
				'title' => esc_html__( 'Blog', 'entre' ),
				'name'  => 'blog_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_blog_category_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Blog Category', 'entre' ),
				'description' => esc_html__( 'Choose category of posts to display (leave empty to display all categories)', 'entre' ),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_show_posts_per_page_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Posts', 'entre' ),
				'description' => esc_html__( 'Enter the number of posts to display', 'entre' ),
				'parent'      => $blog_meta_box,
				'options'     => $mkd_blog_categories,
				'args'        => array( "col_width" => 3 )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_blog_masonry_layout_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Layout', 'entre' ),
				'description' => esc_html__( 'Set masonry layout. Default is in grid.', 'entre' ),
				'parent'      => $blog_meta_box,
				'options'     => array(
					''           => esc_html__( 'Default', 'entre' ),
					'in-grid'    => esc_html__( 'In Grid', 'entre' ),
					'full-width' => esc_html__( 'Full Width', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_blog_masonry_number_of_columns_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Number of Columns', 'entre' ),
				'description' => esc_html__( 'Set number of columns for your masonry blog lists', 'entre' ),
				'parent'      => $blog_meta_box,
				'options'     => array(
					''      => esc_html__( 'Default', 'entre' ),
					'two'   => esc_html__( '2 Columns', 'entre' ),
					'three' => esc_html__( '3 Columns', 'entre' ),
					'four'  => esc_html__( '4 Columns', 'entre' ),
					'five'  => esc_html__( '5 Columns', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_blog_masonry_space_between_items_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Space Between Items', 'entre' ),
				'description' => esc_html__( 'Set space size between posts for your masonry blog lists', 'entre' ),
				'options'     => entre_mikado_get_space_between_items_array( true ),
				'parent'      => $blog_meta_box
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_blog_list_featured_image_proportion_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Featured Image Proportion', 'entre' ),
				'description'   => esc_html__( 'Choose type of proportions you want to use for featured images on masonry blog lists', 'entre' ),
				'parent'        => $blog_meta_box,
				'default_value' => '',
				'options'       => array(
					''         => esc_html__( 'Default', 'entre' ),
					'fixed'    => esc_html__( 'Fixed', 'entre' ),
					'original' => esc_html__( 'Original', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_blog_pagination_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'entre' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'entre' ),
				'parent'        => $blog_meta_box,
				'default_value' => '',
				'options'       => array(
					''                => esc_html__( 'Default', 'entre' ),
					'standard'        => esc_html__( 'Standard', 'entre' ),
					'load-more'       => esc_html__( 'Load More', 'entre' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'entre' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'entre' )
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'type'          => 'text',
				'name'          => 'mkd_number_of_chars_meta',
				'default_value' => '',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'entre' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'entre' ),
				'parent'        => $blog_meta_box,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_blog_meta', 30 );
}