<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoSeparatorWidget extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_separator_widget',
				esc_html__( 'Mikado Separator Widget', 'entre' ),
				array( 'description' => esc_html__( 'Add a separator element to your widget areas', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$this->params = array(
				array(
					'type'    => 'dropdown',
					'name'    => 'type',
					'title'   => esc_html__( 'Type', 'entre' ),
					'options' => array(
						'normal'     => esc_html__( 'Normal', 'entre' ),
						'full-width' => esc_html__( 'Full Width', 'entre' )
					)
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'position',
					'title'   => esc_html__( 'Position', 'entre' ),
					'options' => array(
						'center' => esc_html__( 'Center', 'entre' ),
						'left'   => esc_html__( 'Left', 'entre' ),
						'right'  => esc_html__( 'Right', 'entre' )
					)
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'border_style',
					'title'   => esc_html__( 'Style', 'entre' ),
					'options' => array(
						'solid'  => esc_html__( 'Solid', 'entre' ),
						'dashed' => esc_html__( 'Dashed', 'entre' ),
						'dotted' => esc_html__( 'Dotted', 'entre' )
					)
				),
				array(
					'type'  => 'colorpicker',
					'name'  => 'color',
					'title' => esc_html__( 'Color', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'width',
					'title' => esc_html__( 'Width (px or %)', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'thickness',
					'title' => esc_html__( 'Thickness (px)', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'top_margin',
					'title' => esc_html__( 'Top Margin (px or %)', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'bottom_margin',
					'title' => esc_html__( 'Bottom Margin (px or %)', 'entre' )
				)
			);
		}
		
		public function widget( $args, $instance ) {
			if ( ! is_array( $instance ) ) {
				$instance = array();
			}
			
			//prepare variables
			$params = '';
			
			//is instance empty?
			if ( is_array( $instance ) && count( $instance ) ) {
				//generate shortcode params
				foreach ( $instance as $key => $value ) {
					$params .= " $key='$value' ";
				}
			}
			
			echo '<div class="widget mkd-separator-widget">';
			echo do_shortcode( "[mkd_separator $params]" ); // XSS OK
			echo '</div>';
		}
	}
}