<?php

if ( ! function_exists( 'entre_mikado_sidearea_options_map' ) ) {
	function entre_mikado_sidearea_options_map() {
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_side_area_page',
				'title' => esc_html__( 'Side Area', 'entre' ),
				'icon'  => 'fa fa-indent'
			)
		);
		
		$side_area_panel = entre_mikado_add_admin_panel(
			array(
				'title' => esc_html__( 'Side Area', 'entre' ),
				'name'  => 'side_area',
				'page'  => '_side_area_page'
			)
		);
		
		$side_area_icon_style_group = entre_mikado_add_admin_group(
			array(
				'parent'      => $side_area_panel,
				'name'        => 'side_area_icon_style_group',
				'title'       => esc_html__( 'Side Area Icon Style', 'entre' ),
				'description' => esc_html__( 'Define styles for Side Area icon', 'entre' )
			)
		);
		
		$side_area_icon_style_row1 = entre_mikado_add_admin_row(
			array(
				'parent' => $side_area_icon_style_group,
				'name'   => 'side_area_icon_style_row1'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent' => $side_area_icon_style_row1,
				'type'   => 'colorsimple',
				'name'   => 'side_area_icon_color',
				'label'  => esc_html__( 'Color', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent' => $side_area_icon_style_row1,
				'type'   => 'colorsimple',
				'name'   => 'side_area_icon_hover_color',
				'label'  => esc_html__( 'Hover Color', 'entre' )
			)
		);
		
		$side_area_icon_style_row2 = entre_mikado_add_admin_row(
			array(
				'parent' => $side_area_icon_style_group,
				'name'   => 'side_area_icon_style_row2',
				'next'   => true
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent' => $side_area_icon_style_row2,
				'type'   => 'colorsimple',
				'name'   => 'side_area_close_icon_color',
				'label'  => esc_html__( 'Close Icon Color', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent' => $side_area_icon_style_row2,
				'type'   => 'colorsimple',
				'name'   => 'side_area_close_icon_hover_color',
				'label'  => esc_html__( 'Close Icon Hover Color', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'text',
				'name'          => 'side_area_width',
				'default_value' => '',
				'label'         => esc_html__( 'Side Area Width', 'entre' ),
				'description'   => esc_html__( 'Enter a width for Side Area', 'entre' ),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'      => $side_area_panel,
				'type'        => 'color',
				'name'        => 'side_area_background_color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Choose a background color for Side Area', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'      => $side_area_panel,
				'type'        => 'text',
				'name'        => 'side_area_padding',
				'label'       => esc_html__( 'Padding', 'entre' ),
				'description' => esc_html__( 'Define padding for Side Area in format top right bottom left', 'entre' ),
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $side_area_panel,
				'type'          => 'selectblank',
				'name'          => 'side_area_aligment',
				'default_value' => '',
				'label'         => esc_html__( 'Text Alignment', 'entre' ),
				'description'   => esc_html__( 'Choose text alignment for side area', 'entre' ),
				'options'       => array(
					''       => esc_html__( 'Default', 'entre' ),
					'left'   => esc_html__( 'Left', 'entre' ),
					'center' => esc_html__( 'Center', 'entre' ),
					'right'  => esc_html__( 'Right', 'entre' )
				)
			)
		);
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_sidearea_options_map', 4 );
}