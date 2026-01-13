<?php

if ( ! function_exists( 'entre_mikado_woocommerce_options_map' ) ) {
	
	/**
	 * Add Woocommerce options page
	 */
	function entre_mikado_woocommerce_options_map() {
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_woocommerce_page',
				'title' => esc_html__( 'Woocommerce', 'entre' ),
				'icon'  => 'fa fa-shopping-cart'
			)
		);
		
		/**
		 * Product List Settings
		 */
		$panel_product_list = entre_mikado_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_product_list',
				'title' => esc_html__( 'Product List', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_woo_product_list_columns',
				'label'         => esc_html__( 'Product List Columns', 'entre' ),
				'default_value' => 'mkd-woocommerce-columns-3',
				'description'   => esc_html__( 'Choose number of columns for product listing and related products on single product', 'entre' ),
				'options'       => array(
					'mkd-woocommerce-columns-3' => esc_html__( '3 Columns', 'entre' ),
					'mkd-woocommerce-columns-4' => esc_html__( '4 Columns', 'entre' )
				),
				'parent'        => $panel_product_list,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_woo_product_list_columns_space',
				'label'         => esc_html__( 'Space Between Items', 'entre' ),
				'description'   => esc_html__( 'Select space between items for product listing and related products on single product', 'entre' ),
				'default_value' => 'normal',
				'options'       => entre_mikado_get_space_between_items_array(),
				'parent'        => $panel_product_list,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_woo_product_list_info_position',
				'label'         => esc_html__( 'Product Info Position', 'entre' ),
				'default_value' => 'info_below_image',
				'description'   => esc_html__( 'Select product info position for product listing and related products on single product', 'entre' ),
				'options'       => array(
					'info_below_image'    => esc_html__( 'Info Below Image', 'entre' ),
					'info_on_image_hover' => esc_html__( 'Info On Image Hover', 'entre' )
				),
				'parent'        => $panel_product_list,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'mkd_woo_products_per_page',
				'label'         => esc_html__( 'Number of products per page', 'entre' ),
				'description'   => esc_html__( 'Set number of products on shop page', 'entre' ),
				'parent'        => $panel_product_list,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_products_list_title_tag',
				'label'         => esc_html__( 'Products Title Tag', 'entre' ),
				'default_value' => 'h4',
				'options'       => entre_mikado_get_title_tag(),
				'parent'        => $panel_product_list,
			)
		);
		
		/**
		 * Single Product Settings
		 */
		$panel_single_product = entre_mikado_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_single_product',
				'title' => esc_html__( 'Single Product', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_woo',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'entre' ),
				'parent'        => $panel_single_product,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'mkd_single_product_title_tag',
				'default_value' => 'h2',
				'label'         => esc_html__( 'Single Product Title Tag', 'entre' ),
				'options'       => entre_mikado_get_title_tag(),
				'parent'        => $panel_single_product,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_number_of_thumb_images',
				'default_value' => '4',
				'label'         => esc_html__( 'Number of Thumbnail Images per Row', 'entre' ),
				'options'       => array(
					'4' => esc_html__( 'Four', 'entre' ),
					'3' => esc_html__( 'Three', 'entre' ),
					'2' => esc_html__( 'Two', 'entre' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_thumb_images_position',
				'default_value' => 'below-image',
				'label'         => esc_html__( 'Set Thumbnail Images Position', 'entre' ),
				'options'       => array(
					'below-image'  => esc_html__( 'Below Featured Image', 'entre' ),
					'on-left-side' => esc_html__( 'On The Left Side Of Featured Image', 'entre' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_enable_single_product_zoom_image',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Zoom Maginfier', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show magnifier image on featured image hover', 'entre' ),
				'parent'        => $panel_single_product,
				'options'       => entre_mikado_get_yes_no_select_array( false ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_single_images_behavior',
				'default_value' => 'pretty-photo',
				'label'         => esc_html__( 'Set Images Behavior', 'entre' ),
				'options'       => array(
					'pretty-photo' => esc_html__( 'Pretty Photo Lightbox', 'entre' ),
					'photo-swipe'  => esc_html__( 'Photo Swipe Lightbox', 'entre' )
				),
				'parent'        => $panel_single_product
			)
		);
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_woocommerce_options_map', 21 );
}