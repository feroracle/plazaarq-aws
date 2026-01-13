<?php

if ( ! function_exists( 'entre_mikado_footer_options_map' ) ) {
	function entre_mikado_footer_options_map() {
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_footer_page',
				'title' => esc_html__( 'Footer', 'entre' ),
				'icon'  => 'fa fa-sort-amount-asc'
			)
		);
		
		$footer_panel = entre_mikado_add_admin_panel(
			array(
				'title' => esc_html__( 'Footer', 'entre' ),
				'name'  => 'footer',
				'page'  => '_footer_page'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'footer_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Footer in Grid', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will place Footer content in grid', 'entre' ),
				'parent'        => $footer_panel
			)
		);

        entre_mikado_add_admin_field(
            array(
                'type'          => 'yesno',
                'name'          => 'uncovering_footer',
                'default_value' => 'no',
                'label'         => esc_html__( 'Uncovering Footer', 'entre' ),
                'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'entre' ),
                'parent'        => $footer_panel,
            )
        );
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_top',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Top', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_show_footer_top_container'
				),
				'parent'        => $footer_panel,
			)
		);

		$show_footer_top_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'show_footer_top_container',
				'hidden_property' => 'show_footer_top',
				'hidden_value'    => 'no',
				'parent'          => $footer_panel
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns',
				'parent'        => $show_footer_top_container,
				'default_value' => '4',
				'label'         => esc_html__( 'Footer Top Columns', 'entre' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Top area', 'entre' ),
				'options'       => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4'
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns_alignment',
				'default_value' => 'left',
				'label'         => esc_html__( 'Footer Top Columns Alignment', 'entre' ),
				'description'   => esc_html__( 'Text Alignment in Footer Columns', 'entre' ),
				'options'       => array(
					''       => esc_html__( 'Default', 'entre' ),
					'left'   => esc_html__( 'Left', 'entre' ),
					'center' => esc_html__( 'Center', 'entre' ),
					'right'  => esc_html__( 'Right', 'entre' )
				),
				'parent'        => $show_footer_top_container,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'footer_top_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Set background color for top footer area', 'entre' ),
				'parent'      => $show_footer_top_container
			)
		);

		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_logo',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Footer Logo Image', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show Logo Image in Footer', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_show_footer_logo_container'
				),
				'parent'        => $footer_panel,
			)
		);
		
		$show_footer_logo_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'show_footer_logo_container',
				'hidden_property' => 'show_footer_logo',
				'hidden_value'    => 'no',
				'parent'          => $footer_panel
			)
		);

		entre_mikado_add_admin_field(
			array(
				'name'          => 'footer_logo',
				'type'          => 'image',
				'default_value' => MIKADO_ASSETS_ROOT . "/img/footer_logo.png",
				'label'         => esc_html__( 'Footer Logo Image', 'entre' ),
				'parent'        => $show_footer_logo_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_bottom',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Bottom', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_show_footer_bottom_container'
				),
				'parent'        => $footer_panel,
			)
		);
		
		$show_footer_bottom_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'show_footer_bottom_container',
				'hidden_property' => 'show_footer_bottom',
				'hidden_value'    => 'no',
				'parent'          => $footer_panel
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_bottom_columns',
				'default_value' => '2',
				'label'         => esc_html__( 'Footer Bottom Columns', 'entre' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Bottom area', 'entre' ),
				'options'       => array(
					'1' => '1',
					'2' => '2',
					'3' => '3'
				),
				'parent'        => $show_footer_bottom_container,
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'footer_bottom_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Set background color for bottom footer area', 'entre' ),
				'parent'      => $show_footer_bottom_container
			)
		);
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_footer_options_map', 11 );
}