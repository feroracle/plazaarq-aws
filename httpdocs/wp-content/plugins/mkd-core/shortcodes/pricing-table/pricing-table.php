<?php
namespace MikadoCore\CPT\Shortcodes\PricingTable;

use MikadoCore\Lib;

class PricingTable implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'mkd_pricing_table';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                    => esc_html__( 'Mikado Pricing Table', 'mkd-core' ),
					'base'                    => $this->base,
					'as_parent'               => array( 'only' => 'mkd_pricing_table_item' ),
					'content_element'         => true,
					'category'                => esc_html__( 'by MIKADO', 'mkd-core' ),
					'icon'                    => 'icon-wpb-pricing-table extended-custom-icon',
					'show_settings_on_create' => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'columns',
							'heading'     => esc_html__( 'Number of Columns', 'mkd-core' ),
							'value'       => array(
								esc_html__( 'One', 'mkd-core' )   => 'mkd-one-column',
								esc_html__( 'Two', 'mkd-core' )   => 'mkd-two-columns',
								esc_html__( 'Three', 'mkd-core' ) => 'mkd-three-columns',
								esc_html__( 'Four', 'mkd-core' )  => 'mkd-four-columns',
								esc_html__( 'Five', 'mkd-core' )  => 'mkd-five-columns',
							),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Items', 'mkd-core' ),
							'value'       => array_flip( entre_mikado_get_space_between_items_array() ),
							'save_always' => true
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'columns'             => 'mkd-two-columns',
			'space_between_items' => 'normal'
		);
		$params = shortcode_atts( $args, $atts );
		
		$holder_class = $this->getHolderClasses( $params, $args );
		
		$html = '<div class="mkd-pricing-tables clearfix ' . esc_attr( $holder_class ) . '">';
			$html .= '<div class="mkd-pt-wrapper mkd-outer-space">';
				$html .= do_shortcode( $content );
			$html .= '</div>';
		$html .= '</div>';
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['columns'] ) ? $params['columns'] : $args['columns'];
		$holderClasses[] = ! empty( $params['space_between_items'] ) ? 'mkd-' . $params['space_between_items'] . '-space' : 'mkd-' . $args['space_between_items'] . '-space';
		
		return implode( ' ', $holderClasses );
	}
}