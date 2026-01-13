<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoButtonWidget extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_button_widget',
				esc_html__( 'Mikado Button Widget', 'entre' ),
				array( 'description' => esc_html__( 'Add button element to widget areas', 'entre' ) )
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
						'solid'   => esc_html__( 'Solid', 'entre' ),
						'outline' => esc_html__( 'Outline', 'entre' ),
						'simple'  => esc_html__( 'Simple', 'entre' )
					)
				),
				array(
					'type'        => 'dropdown',
					'name'        => 'size',
					'title'       => esc_html__( 'Size', 'entre' ),
					'options'     => array(
						'small'  => esc_html__( 'Small', 'entre' ),
						'medium' => esc_html__( 'Medium', 'entre' ),
						'large'  => esc_html__( 'Large', 'entre' ),
						'huge'   => esc_html__( 'Huge', 'entre' )
					),
					'description' => esc_html__( 'This option is only available for solid and outline button type', 'entre' )
				),
				array(
					'type'    => 'textfield',
					'name'    => 'text',
					'title'   => esc_html__( 'Text', 'entre' ),
					'default' => esc_html__( 'Button Text', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'link',
					'title' => esc_html__( 'Link', 'entre' )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'target',
					'title'   => esc_html__( 'Link Target', 'entre' ),
					'options' => entre_mikado_get_link_target_array()
				),
				array(
					'type'  => 'colorpicker',
					'name'  => 'color',
					'title' => esc_html__( 'Color', 'entre' )
				),
				array(
					'type'  => 'colorpicker',
					'name'  => 'hover_color',
					'title' => esc_html__( 'Hover Color', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'background_color',
					'title'       => esc_html__( 'Background Color', 'entre' ),
					'description' => esc_html__( 'This option is only available for solid button type', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'hover_background_color',
					'title'       => esc_html__( 'Hover Background Color', 'entre' ),
					'description' => esc_html__( 'This option is only available for solid button type', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'border_color',
					'title'       => esc_html__( 'Border Color', 'entre' ),
					'description' => esc_html__( 'This option is only available for solid and outline button type', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'hover_border_color',
					'title'       => esc_html__( 'Hover Border Color', 'entre' ),
					'description' => esc_html__( 'This option is only available for solid and outline button type', 'entre' )
				),
				array(
					'type'        => 'textfield',
					'name'        => 'margin',
					'title'       => esc_html__( 'Margin', 'entre' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'entre' )
				)
			);
		}
		
		public function widget( $args, $instance ) {
			$params = '';
			
			if ( ! is_array( $instance ) ) {
				$instance = array();
			}
			
			// Filter out all empty params
			$instance = array_filter( $instance, function ( $array_value ) {
				return trim( $array_value ) != '';
			} );
			
			// Default values
			if ( ! isset( $instance['text'] ) ) {
				$instance['text'] = 'Button Text';
			}
			
			// Generate shortcode params
			foreach ( $instance as $key => $value ) {
				$params .= " $key='$value' ";
			}
			
			echo '<div class="widget mkd-button-widget">';
			echo do_shortcode( "[mkd_button $params]" ); // XSS OK
			echo '</div>';
		}
	}
}