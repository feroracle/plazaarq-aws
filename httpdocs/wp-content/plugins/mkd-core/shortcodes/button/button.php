<?php
namespace MikadoCore\CPT\Shortcodes\Button;

use MikadoCore\Lib;

class Button implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'mkd_button';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Mikado Button', 'mkd-core' ),
					'base'                      => $this->base,
					'category'                  => esc_html__( 'by MIKADO', 'mkd-core' ),
					'icon'                      => 'icon-wpb-button extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array_merge(
						array(
							array(
								'type'        => 'textfield',
								'param_name'  => 'custom_class',
								'heading'     => esc_html__( 'Custom CSS Class', 'mkd-core' ),
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'mkd-core' )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'type',
								'heading'     => esc_html__( 'Type', 'mkd-core' ),
								'value'       => array(
									esc_html__( 'Solid', 'mkd-core' )   => 'solid',
									esc_html__( 'Outline', 'mkd-core' ) => 'outline',
									esc_html__( 'Simple', 'mkd-core' )  => 'simple',
									esc_html__( 'Minimal', 'mkd-core')	=> 'minimal'
								),
								'admin_label' => true
							),
							array(
								'type'       => 'dropdown',
								'param_name' => 'size',
								'heading'    => esc_html__( 'Size', 'mkd-core' ),
								'value'      => array(
									esc_html__( 'Default', 'mkd-core' ) => '',
									esc_html__( 'Small', 'mkd-core' )   => 'small',
									esc_html__( 'Medium', 'mkd-core' )  => 'medium',
									esc_html__( 'Large', 'mkd-core' )   => 'large',
									esc_html__( 'Huge', 'mkd-core' )    => 'huge'
								),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline', 'minimal' ) ),
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'text',
								'heading'     => esc_html__( 'Text', 'mkd-core' ),
								'value'       => esc_html__( 'Button Text', 'mkd-core' ),
								'save_always' => true,
								'admin_label' => true
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'link',
								'heading'    => esc_html__( 'Link', 'mkd-core' )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'target',
								'heading'     => esc_html__( 'Link Target', 'mkd-core' ),
								'value'       => array_flip( entre_mikado_get_link_target_array() ),
								'save_always' => true
							)
						),
						entre_mikado_icon_collections()->getVCParamsArray( array('element' => 'type', 'value' => array('solid', 'outline', 'simple')), '', true ),
						array(
							array(
								'type'       => 'colorpicker',
								'param_name' => 'color',
								'heading'    => esc_html__( 'Color', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'hover_color',
								'heading'    => esc_html__( 'Hover Color', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'background_color',
								'heading'    => esc_html__( 'Background Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid' ) ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'hover_background_color',
								'heading'    => esc_html__( 'Hover Background Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline' ) ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'linear_gradient_background_color',
								'heading'    => esc_html__( 'Linear Gradient Background Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline') ),
								'description' => esc_html__( 'In order to this option be properly applied , please make sure you set Linear Gradient Text Color as well as Linear Gradient Hover Text Color', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'linear_gradient_text_color',
								'heading'    => esc_html__( 'Linear Gradient Text Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline' ) ),
								'description' => esc_html__( 'In order to this option be properly applied , please make sure you set Linear Gradient Background Color as well as Linear Gradient Hover Text Color', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'linear_gradient_text_hover_color',
								'heading'    => esc_html__( 'Linear Gradient Hover Text Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline') ),
								'description' => esc_html__( 'In order to this option be properly applied , please make sure you set Linear Gradient Background Color as well as Linear Gradient Text Color', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'border_color',
								'heading'    => esc_html__( 'Border Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline' ) ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'hover_border_color',
								'heading'    => esc_html__( 'Hover Border Color', 'mkd-core' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'solid', 'outline' ) ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'font_size',
								'heading'    => esc_html__( 'Font Size (px)', 'mkd-core' ),
								'group'      => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'font_weight',
								'heading'     => esc_html__( 'Font Weight', 'mkd-core' ),
								'value'       => array_flip( entre_mikado_get_font_weight_array( true ) ),
								'save_always' => true,
								'group'       => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'text_transform',
								'heading'     => esc_html__( 'Text Transform', 'mkd-core' ),
								'value'       => array_flip( entre_mikado_get_text_transform_array( true ) ),
								'save_always' => true
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'margin',
								'heading'     => esc_html__( 'Margin', 'mkd-core' ),
								'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'mkd-core' ),
								'group'       => esc_html__( 'Design Options', 'mkd-core' )
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'padding',
								'heading'     => esc_html__( 'Button Padding', 'mkd-core' ),
								'description' => esc_html__( 'Insert padding in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'mkd-core' ),
								'dependency'  => array( 'element' => 'type', 'value' => array( 'solid', 'outline' ) ),
								'group'       => esc_html__( 'Design Options', 'mkd-core' )
							)
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$default_atts = array(
			'size'                  		   => '',
			'type'                   		   => 'solid',
			'text'                  		   => '',
			'link'                  		   => '',
			'target'                		   => '_self',
			'color'                 		   => '',
			'hover_color'                      => '',
			'background_color'       		   => '',
			'hover_background_color'           => '',
			'linear_gradient_background_color' => '',
			'linear_gradient_text_color'       => '',
			'linear_gradient_text_hover_color' => '',
		 	'border_color'           		   => '',
			'hover_border_color'     		   => '',
			'font_size'              		   => '',
			'font_weight'            		   => '',
			'text_transform'        		   => '',
			'margin'                 		   => '',
			'padding'                		   => '',
			'custom_class'           		   => '',
			'html_type'              		   => 'anchor',
			'input_name'             		   => '',
			'custom_attrs'                     => array()
		);
		$default_atts = array_merge( $default_atts, entre_mikado_icon_collections()->getShortcodeParams() );
		$params       = shortcode_atts( $default_atts, $atts );
		
		if ( $params['html_type'] !== 'input' ) {
			$iconPackName   = entre_mikado_icon_collections()->getIconCollectionParamNameByKey( $params['icon_pack'] );
			$params['icon'] = $iconPackName ? $params[ $iconPackName ] : '';
		}
		
		$params['size'] = ! empty( $params['size'] ) ? $params['size'] : 'medium';
		$params['type'] = ! empty( $params['type'] ) ? $params['type'] : 'minimal';
		
		$params['link']   = ! empty( $params['link'] ) ? $params['link'] : '#';
		$params['target'] = ! empty( $params['target'] ) ? $params['target'] : $default_atts['target'];
		
		$params['button_classes']      = $this->getButtonClasses( $params );
		$params['button_custom_attrs'] = ! empty( $params['custom_attrs'] ) ? $params['custom_attrs'] : array();
		$params['button_styles']       = $this->getButtonStyles( $params );
		$params['button_data']         = $this->getButtonDataAttr( $params );
		
		return mkd_core_get_shortcode_module_template_part( 'templates/' . $params['html_type'], 'button', '', $params );
	}
	
	private function getButtonStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['color'] ) ) {
			$styles[] = 'color: ' . $params['color'];
		}
		
		if ( ! empty( $params['background_color'] ) && $params['type'] !== 'outline' ) {
			$styles[] = 'background-color: ' . $params['background_color'];
		}

		if ( ! empty( $params['linear_gradient_background_color']) || ! empty( $params['linear_gradient_text_color']) || ! empty( $params['linear_gradient_text_hover_color'] ) ) {
			$styles[] = 'background-image: ' . 'linear-gradient(to right,'.$params['linear_gradient_text_hover_color'].' 50%,'.$params['linear_gradient_text_color'].' 50%),linear-gradient(to right,'.$params['linear_gradient_background_color'].' 50%,transparent 50%)';
		}
		
		if ( ! empty( $params['border_color'] ) ) {
			$styles[] = 'border-color: ' . $params['border_color'];
		}
		
		if ( ! empty( $params['font_size'] ) ) {
			$styles[] = 'font-size: ' . entre_mikado_filter_px( $params['font_size'] ) . 'px';
		}
		
		if ( ! empty( $params['font_weight'] ) && $params['font_weight'] !== '' ) {
			$styles[] = 'font-weight: ' . $params['font_weight'];
		}
		
		if ( ! empty( $params['text_transform'] ) ) {
			$styles[] = 'text-transform: ' . $params['text_transform'];
		}
		
		if ( $params['margin'] !== '' ) {
			$styles[] = 'margin: ' . $params['margin'];
		}
		
		if ( $params['padding'] !== '' ) {
			$styles[] = 'padding: ' . $params['padding'];
		}
		
		return $styles;
	}
	
	private function getButtonDataAttr( $params ) {
		$data = array();
		
		if ( ! empty( $params['hover_color'] ) ) {
			$data['data-hover-color'] = $params['hover_color'];
		}
		
		if ( ! empty( $params['hover_background_color'] ) ) {
			$data['data-hover-bg-color'] = $params['hover_background_color'];
		}
		
		if ( ! empty( $params['hover_border_color'] ) ) {
			$data['data-hover-border-color'] = $params['hover_border_color'];
		}
		
		return $data;
	}
	
	private function getButtonClasses( $params ) {
		$buttonClasses = array(
			'mkd-btn',
			'mkd-btn-' . $params['size'],
			'mkd-btn-' . $params['type']
		);
		
		if ( ! empty( $params['hover_background_color'] ) ) {
			$buttonClasses[] = 'mkd-btn-custom-hover-bg';
		}
		
		if ( ! empty( $params['hover_border_color'] ) ) {
			$buttonClasses[] = 'mkd-btn-custom-border-hover';
		}
		
		if ( ! empty( $params['hover_color'] ) ) {
			$buttonClasses[] = 'mkd-btn-custom-hover-color';
		}
		
		if ( ! empty( $params['icon'] ) ) {
			$buttonClasses[] = 'mkd-btn-icon';
		}
		
		if ( ! empty( $params['custom_class'] ) ) {
			$buttonClasses[] = esc_attr( $params['custom_class'] );
		}
		
		return $buttonClasses;
	}
}