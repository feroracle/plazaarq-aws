<?php

if ( ! function_exists( 'entre_mikado_get_blog_list_types_options' ) ) {
	function entre_mikado_get_blog_list_types_options() {
		$blog_list_type_options = apply_filters( 'entre_mikado_blog_list_type_global_option', $blog_list_type_options = array() );
		
		return $blog_list_type_options;
	}
}

if ( ! function_exists( 'entre_mikado_blog_options_map' ) ) {
	function entre_mikado_blog_options_map() {
		$blog_list_type_options = entre_mikado_get_blog_list_types_options();
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_blog_page',
				'title' => esc_html__( 'Blog', 'entre' ),
				'icon'  => 'fa fa-files-o'
			)
		);
		
		/**
		 * Blog Lists
		 */
		$panel_blog_lists = entre_mikado_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_lists',
				'title' => esc_html__( 'Blog Lists', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_list_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Blog Layout for Archive Pages', 'entre' ),
				'description'   => esc_html__( 'Choose a default blog layout for archived blog post lists', 'entre' ),
				'default_value' => 'standard',
				'parent'        => $panel_blog_lists,
				'options'       => $blog_list_type_options
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'archive_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout for Archive Pages', 'entre' ),
				'description'   => esc_html__( 'Choose a sidebar layout for archived blog post lists', 'entre' ),
				'default_value' => '',
				'parent'        => $panel_blog_lists,
                'options'       => entre_mikado_get_custom_sidebars_options(),
			)
		);
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_add_admin_field(
				array(
					'name'        => 'archive_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display for Archive Pages', 'entre' ),
					'description' => esc_html__( 'Choose a sidebar to display on archived blog post lists. Default sidebar is "Sidebar Page"', 'entre' ),
					'parent'      => $panel_blog_lists,
					'options'     => entre_mikado_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_masonry_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Layout', 'entre' ),
				'default_value' => 'in-grid',
				'description'   => esc_html__( 'Set masonry layout. Default is in grid.', 'entre' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'in-grid'    => esc_html__( 'In Grid', 'entre' ),
					'full-width' => esc_html__( 'Full Width', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_masonry_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Number of Columns', 'entre' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for your masonry blog lists. Default value is 4 columns', 'entre' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'two'   => esc_html__( '2 Columns', 'entre' ),
					'three' => esc_html__( '3 Columns', 'entre' ),
					'four'  => esc_html__( '4 Columns', 'entre' ),
					'five'  => esc_html__( '5 Columns', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_masonry_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Space Between Items', 'entre' ),
				'description'   => esc_html__( 'Set space size between posts for your masonry blog lists. Default value is normal', 'entre' ),
				'default_value' => 'normal',
				'options'       => entre_mikado_get_space_between_items_array(),
				'parent'        => $panel_blog_lists
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_list_featured_image_proportion',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Featured Image Proportion', 'entre' ),
				'default_value' => 'fixed',
				'description'   => esc_html__( 'Choose type of proportions you want to use for featured images on masonry blog lists', 'entre' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'fixed'    => esc_html__( 'Fixed', 'entre' ),
					'original' => esc_html__( 'Original', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_pagination_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'entre' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'entre' ),
				'parent'        => $panel_blog_lists,
				'default_value' => 'standard',
				'options'       => array(
					'standard'        => esc_html__( 'Standard', 'entre' ),
					'load-more'       => esc_html__( 'Load More', 'entre' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'entre' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'number_of_chars',
				'default_value' => '40',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'entre' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'entre' ),
				'parent'        => $panel_blog_lists,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		/**
		 * Blog Single
		 */
		$panel_blog_single = entre_mikado_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_single',
				'title' => esc_html__( 'Blog Single', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_single_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'entre' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog Single pages', 'entre' ),
				'default_value' => '',
				'parent'        => $panel_blog_single,
                'options'       => entre_mikado_get_custom_sidebars_options()
			)
		);
		
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_add_admin_field(
				array(
					'name'        => 'blog_single_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display', 'entre' ),
					'description' => esc_html__( 'Choose a sidebar to display on Blog Single pages. Default sidebar is "Sidebar"', 'entre' ),
					'parent'      => $panel_blog_single,
					'options'     => entre_mikado_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_blog',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_single_title_in_title_area',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Post Title in Title Area', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show post title in title area on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'no'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_single_related_posts',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Related Posts', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show related posts on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);

		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_single_tags',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Tags', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show tags on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'blog_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments Form', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show comments form on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_navigation',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Prev/Next Single Post Navigation Links', 'entre' ),
				'description'   => esc_html__( 'Enable navigation links through the blog posts (left and right arrows will appear)', 'entre' ),
				'parent'        => $panel_blog_single,
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_mkd_blog_single_navigation_container'
				)
			)
		);
		
		$blog_single_navigation_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'mkd_blog_single_navigation_container',
				'hidden_property' => 'blog_single_navigation',
				'hidden_value'    => 'no',
				'parent'          => $panel_blog_single,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_navigation_through_same_category',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Navigation Only in Current Category', 'entre' ),
				'description'   => esc_html__( 'Limit your navigation only through current category', 'entre' ),
				'parent'        => $blog_single_navigation_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Author Info Box', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will display author name and descriptions on single post pages', 'entre' ),
				'parent'        => $panel_blog_single,
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_mkd_blog_single_author_info_container'
				)
			)
		);
		
		$blog_single_author_info_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'mkd_blog_single_author_info_container',
				'hidden_property' => 'blog_author_info',
				'hidden_value'    => 'no',
				'parent'          => $panel_blog_single,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info_email',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Author Email', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show author email', 'entre' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_author_social',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Author Social Icons', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show author social icons on single post pages', 'entre' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		do_action( 'entre_mikado_blog_single_options_map', $panel_blog_single );
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_blog_options_map', 13 );
}