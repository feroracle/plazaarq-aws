<?php
namespace MikadoCore\CPT\Shortcodes\ParallaxDropShadowImageSection;

use MikadoCore\Lib;

class ParallaxDropShadowImageSection implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'mkd_parallax_ds_image_section';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Mikado Parallax Drop Shadow Image Section', 'mkd-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by MIKADO', 'mkd-core' ),
					'icon'                      => 'icon-wpb-parallax-ds-image-section extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
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
								esc_html__( 'Default', 'mkd-core' )      => '',
								esc_html__( 'With Text', 'mkd-core' )    => 'with-text'
							),
							'save_always' => true,
							'admin_label' => true
						),
						array(
							'type'        => 'attach_image',
							'param_name'  => 'image',
							'heading'     => esc_html__( 'Image', 'mkd-core' ),
							'description' => esc_html__( 'Select images from media library', 'mkd-core' )
						),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'shadow_side',
                            'heading'     => esc_html__( 'Choose Image Shadow Position', 'mkd-core' ),
                            'value'       => array(
                                esc_html__( 'Left', 'mkd-core' )    => 'left',
                                esc_html__( 'Right', 'mkd-core' )   => 'right'
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type'       => 'textarea',
                            'param_name' => 'text',
                            'heading'    => esc_html__( 'Text', 'mkd-core' ),
                            'dependency' => Array( 'element' => 'type', 'value' => array( 'with-text' ) )
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_parallax_animation',
                            'heading'     => esc_html__( 'Enable Parallax Animation', 'edge-core' ),
                            'value'       => array_flip( entre_mikado_get_yes_no_select_array( false, true ) ),
                            'description' => esc_html__( 'Enabling this option will trigger parallax scrolling effect for image shadow.', 'edge-core' ),
                            'save_always' => true
                        ),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'              => '',
			'type'                      => '',
			'image'                     => '',
            'shadow_side'               => 'left',
            'enable_parallax_animation' => 'yes',
			'text'                      => ''
		);
		$params = shortcode_atts( $args, $atts );

        $params['this_object'] = $this;
		
		$params['holder_classes']     = $this->getHolderClasses( $params, $args );
        $params['shadow_classes']     = $this->getShadowSideClass( $params, $args );
		$params['image']              = $this->getImage( $params );
		
		$html = mkd_core_get_shortcode_module_template_part( 'templates/parallax-drop-shadow-image-section', 'parallax-drop-shadow-image-section', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['type'] ) ? 'mkd-parallax-dsis-' . $params['type'] . '-type' : 'mkd-parallax-dsis-' . $args['type'] . '-type';

        if ($params['enable_parallax_animation'] == 'yes') {
            $holderClasses[] = 'mkd-pdsis-has-parallax-scroll';
        }
		
		return implode( ' ', $holderClasses );
	}

    private function getShadowSideClass( $params, $args ) {
        $shadowClasses = array();

        $shadowClasses[] = ! empty( $params['shadow_side'] ) ? 'mkd-parallax-dsis-' . $params['shadow_side'] : 'mkd-parallax-dsis-' . $args['shadow_side'];

        return implode( ' ', $shadowClasses );
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

    function getParallaxData( $params ) {
        $itemData = array();

        if ($params['enable_parallax_animation'] === 'yes') {
            $y_absolute = rand(-80, -100);
            $smoothness = 20; //1 is for linear, non-animated parallax

            $itemData['data-parallax']= '{&quot;y&quot;: '.$y_absolute.', &quot;smoothness&quot;: '.$smoothness.'}';
        }

        return $itemData;
    }
}