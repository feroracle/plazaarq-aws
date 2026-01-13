<?php
namespace MikadoCore\CPT\Shortcodes\SplitScrollingSection;

use MikadoCore\Lib;

class SplitScrollingSection implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'mkd_split_scrolling_section';
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		vc_map( array(
			'name' => esc_html__('Mikado Split Scrolling Section', 'mkd-core'),
			'base' => $this->base,
			'icon' => 'icon-wpb-split-scrolling-section extended-custom-icon',
			'category' => esc_html__('by MIKADO', 'mkd-core'),
			'as_parent'	=> array('only' => 'mkd_split_scrolling_section_left_panel, mkd_split_scrolling_section_right_panel'),
			'show_settings_on_create' => true,
			'js_view' => 'VcColumnView',
			'params' => array(
				array()
			)
		));
	}

	public function render($atts, $content = null) {
		$args = array();
		
		$params = shortcode_atts($args, $atts);
		extract($params);

		$params['content'] = $content;

		$html = mkd_core_get_shortcode_module_template_part('templates/split-scrolling-section-template', 'split-scrolling-section', '', $params);

		return $html;
	}
}
