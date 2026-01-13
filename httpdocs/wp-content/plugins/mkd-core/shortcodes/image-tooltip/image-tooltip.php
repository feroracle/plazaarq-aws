<?php
namespace MikadoCore\CPT\Shortcodes\ImageTooltip;

use MikadoCore\Lib;

class ImageTooltip implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'mkd_image_tooltip';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'color'            => '',
			'image'			   => '',
			'placement'	   => ''
		);

		$params = shortcode_atts( $args, $atts );
		
		$params['content']         		= $content;
		$params['image_tooltip_style'] 	= $this->getImageTooltipStyles( $params );
		$params['image_tooltip_data']   = $this->getImageTooltipDataAttr( $params );
		
		$html = mkd_core_get_shortcode_module_template_part( 'templates/image-tooltip-template', 'image-tooltip', '', $params );
		
		return $html;
	}
	
	private function getImageTooltipStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['color'] ) ) {
			$styles[] = 'color: ' . $params['color'];
		}
		
		return implode( ';', $styles );
	}

	private function getImageTooltipDataAttr( $params ) {
		$data = array(
			'data-toggle' => 'tooltip'
		);

		if ( ! empty( $params['placement'] ) ) {
			$data['data-placement'] = $params['placement'];
		}		
		
		return $data;
	}
}