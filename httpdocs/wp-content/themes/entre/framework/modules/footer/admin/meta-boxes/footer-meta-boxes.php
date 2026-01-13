<?php

if ( ! function_exists( 'entre_mikado_map_footer_meta' ) ) {
	function entre_mikado_map_footer_meta() {
		
		$footer_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page', 'post' ), 'footer_meta' ),
				'title' => esc_html__( 'Footer', 'entre' ),
				'name'  => 'footer_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_disable_footer_meta',
				'type'          => 'select',
				'default_value' => 'no',
				'label'         => esc_html__( 'Disable Footer for this Page', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will hide footer on this page', 'entre' ),
				'options'       => entre_mikado_get_yes_no_select_array( false ),
				'parent'        => $footer_meta_box,
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'no'  => '',
						'yes' => '#mkd_mkd_show_footer_meta_container'
					),
					'show'       => array(
						'no'  => '#mkd_mkd_show_footer_meta_container',
						'yes' => ''
					)
				)
			)
		);
		
		$show_footer_meta_container = entre_mikado_add_admin_container(
			array(
				'name'            => 'mkd_show_footer_meta_container',
				'hidden_property' => 'mkd_disable_footer_meta',
				'hidden_value'    => 'yes',
				'parent'          => $footer_meta_box
			)
		);
		
			entre_mikado_create_meta_box_field(
				array(
					'name'          => 'mkd_show_footer_top_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Top', 'entre' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'entre' ),
					'options'       => entre_mikado_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
			
			entre_mikado_create_meta_box_field(
				array(
					'name'          => 'mkd_show_footer_bottom_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Bottom', 'entre' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'entre' ),
					'options'       => entre_mikado_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);

        entre_mikado_create_meta_box_field(
                array(
                    'name'          => 'mkd_uncovering_footer_meta',
                    'type'          => 'select',
                    'default_value' => '',
                    'label'         => esc_html__( 'Uncovering Footer', 'entre' ),
                    'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'entre' ),
                    'options'       => entre_mikado_get_yes_no_select_array(),
                    'parent'        => $footer_meta_box,
                )
            );
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_footer_meta', 70 );
}