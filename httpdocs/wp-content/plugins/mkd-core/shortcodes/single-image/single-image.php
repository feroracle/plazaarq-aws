<?php
namespace MikadoCore\CPT\Shortcodes\SingleImage;

use MikadoCore\Lib;

class SingleImage implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'mkd_single_image';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Mikado Single Image', 'mkd-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by MIKADO', 'mkd-core' ),
					'icon'                      => 'icon-wpb-single-image extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image',
							'heading'     => esc_html__( 'Image', 'mkd-core' ),
							'description' => esc_html__( 'Select image from media library', 'mkd-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'image_size',
							'heading'     => esc_html__( 'Image Size', 'mkd-core' ),
							'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size', 'mkd-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'enable_drop_shadow_effect',
							'heading'     => esc_html__( 'Enable Drop Shadow Effect', 'mkd-core' ),
							'value'       => array_flip( entre_mikado_get_yes_no_select_array( false ) ),
							'save_always' => true
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'drop_shadow_color',
							'heading'    => esc_html__( 'Drop Shadow Color', 'mkd-core' ),
							'dependency' => array( 'element' => 'enable_drop_shadow_effect', 'value' => array( 'yes' ) ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'drop_shadow_position',
							'heading'    => esc_html__( 'Drop Shadow Position', 'mkd-core' ),
							'value'      => array(
								esc_html__( 'Left', 'mkd-core' )	=> 'left',
								esc_html__( 'Right', 'mkd-core' )	=> 'right',
							),
							'save_always'=> true,
							'dependency' => array( 'element' => 'enable_drop_shadow_effect', 'value' => array( 'yes' ) ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'image_behavior',
							'heading'    => esc_html__( 'Image Behavior', 'mkd-core' ),
							'value'      => array(
								esc_html__( 'None', 'mkd-core' )             => '',
								esc_html__( 'Open Lightbox', 'mkd-core' )    => 'lightbox',
								esc_html__( 'Open Custom Link', 'mkd-core' ) => 'custom-link',
								esc_html__( 'Zoom', 'mkd-core' )             => 'zoom',
								esc_html__( 'Grayscale', 'mkd-core' )        => 'grayscale',
								esc_html__( 'Moving on Hover', 'mkd-core' )  => 'moving'
							),
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'custom_link',
							'heading'    => esc_html__( 'Custom Link', 'mkd-core' ),
							'dependency' => Array( 'element' => 'image_behavior', 'value' => array( 'custom-link' ) )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'custom_link_target',
							'heading'    => esc_html__( 'Custom Link Target', 'mkd-core' ),
							'value'      => array_flip( entre_mikado_get_link_target_array() ),
							'dependency' => Array( 'element' => 'image_behavior', 'value' => array( 'custom-link' ) )
						),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'image_hover_animation',
                            'heading'     => esc_html__( 'Image Hover Animation', 'mkd-core' ),
                            'value'       => array_flip( entre_mikado_get_yes_no_select_array( false ) ),
                            'dependency' => Array( 'element' => 'image_behavior', 'value' => array( 'custom-link' ) )
                        ),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'image'               		=> '',
			'image_size'          		=> 'full',
			'enable_drop_shadow_effect'	=> 'no',
			'drop_shadow_color'			=> '',
			'drop_shadow_position'		=> '',
			'image_behavior'      		=> '',
			'custom_link'         		=> '',
			'custom_link_target'  		=> '_self',
            'image_hover_animation'     => 'no'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']     = $this->getHolderClasses( $params );
		$params['holder_styles']      = $this->getHolderStyles( $params );
		$params['image']              = $this->getImage( $params );
		$params['image_size']         = $this->getImageSize( $params['image_size'] );
		$params['image_behavior']     = ! empty( $params['image_behavior'] ) ? $params['image_behavior'] : $args['image_behavior'];
		$params['custom_link_target'] = ! empty( $params['custom_link_target'] ) ? $params['custom_link_target'] : $args['custom_link_target'];
		$params['drop_shadow_styles'] = $this->getDropShadowStyles( $params );
		
		$html = mkd_core_get_shortcode_module_template_part( 'templates/single-image', 'single-image', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['image_behavior'] ) ? 'mkd-image-behavior-' . $params['image_behavior'] : '';
		$holderClasses[] = $params['enable_drop_shadow_effect'] == 'yes' ? 'mkd-image-has-drop-shadow-effect' : '';
        $holderClasses[] = $params['image_hover_animation'] == 'yes' ? 'mkd-si-hover-animation' : '';
		$holderClasses[] = ! empty( $params['drop_shadow_position'] ) ? 'mkd-image-drop-shadow-' . $params['drop_shadow_position'] : '';

		return implode( ' ', $holderClasses );
	}
	
	private function getHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['image'] ) && $params['image_behavior'] === 'moving' ) {
			$image_original = wp_get_attachment_image_src( $params['image'], 'full' );
			
			$styles[] = 'background-image: url(' . $image_original[0] . ')';
		}
		
		return implode( ';', $styles );
	}
	
	private function getImage( $params ) {
		$image = array();
		
		if ( ! empty( $params['image'] ) ) {
			$id = $params['image'];
			
			$image['image_id'] = $id;
			$image_original    = wp_get_attachment_image_src( $id, 'full' );
			$image['url']      = $image_original[0];
			$image['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );
		}
		
		return $image;
	}
	
	private function getImageSize( $image_size ) {
		$image_size = trim( $image_size );
		//Find digits
		preg_match_all( '/\d+/', $image_size, $matches );
		if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			return $image_size;
		} elseif ( ! empty( $matches[0] ) ) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		} else {
			return 'thumbnail';
		}
	}

	private function getDropShadowStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['drop_shadow_color'] ) ) {
			$styles[] = 'background-color: ' . $params['drop_shadow_color'];
		}
		
		return implode( ';', $styles );
	}
}