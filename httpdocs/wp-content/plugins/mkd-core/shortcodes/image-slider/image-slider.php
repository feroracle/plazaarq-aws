<?php
namespace MikadoCore\CPT\Shortcodes\ImageSlider;

use MikadoCore\Lib;

class ImageSlider implements Lib\ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkd_image_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 */
	public function vcMap() {
		vc_map(array(
			'name'                      => esc_html__('Mikado Image Slider', 'mkd-core'),
			'base'                      => $this->getBase(),
			'category'                  => esc_html__('by MIKADO', 'mkd-core'),
			'icon' 						=> 'icon-wpb-image-slider extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params' => array(
				array(
					'type' => 'param_group',
					'heading' => esc_html__('Content Item', 'mkd-core'),
					'param_name' => 'content_item',
					'value' => '',
					'params' => array(
						array(
							'type' => 'attach_image',
							'heading' => esc_html__('Image', 'mkd-core'),
							'param_name' => 'image',
							'description' => '',
							'admin_label' => true
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('Title', 'mkd-core'),
							'param_name' => 'title',
							'description' => '',
							'admin_label' => true
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('Content', 'mkd-core'),
							'param_name' => 'content',
							'description' => '',
							'admin_label' => true
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Skin', 'mkd-core'),
							'param_name' => 'skin',
							'value'      => array(
								esc_html__( 'Dark', 'mkd-core' )     => 'dark',
								esc_html__( 'Light', 'mkd-core' )    => 'light',
							),
							'description' => '',
						),
					)
				),
                array(
                    'type'		  => 'dropdown',
                    'param_name'  => 'enable_navigation',
                    'heading'	  => esc_html__('Enable Navigation', 'mkd-core'),
                    'value'       => array_flip(entre_mikado_get_yes_no_select_array(false))
                ),
                array(
                    'type'        => 'dropdown',
                    'param_name'  => 'slider_loop',
                    'heading'     => esc_html__( 'Enable Slider Loop', 'mkd-core' ),
                    'value'       => array_flip( entre_mikado_get_yes_no_select_array( false, true ) ),
                    'save_always' => true,
                    'dependency'  => array( 'element' => 'type', 'value' => array( 'slider', 'carousel' ) ),
                    'group'       => esc_html__( 'Slider Settings', 'mkd-core' )
                ),
                array(
                    'type'        => 'dropdown',
                    'param_name'  => 'slider_autoplay',
                    'heading'     => esc_html__( 'Enable Slider Autoplay', 'mkd-core' ),
                    'value'       => array_flip( entre_mikado_get_yes_no_select_array( false, true ) ),
                    'save_always' => true,
                    'dependency'  => array( 'element' => 'type', 'value' => array( 'slider', 'carousel' ) ),
                    'group'       => esc_html__( 'Slider Settings', 'mkd-core' )
                ),
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'slider_speed',
                    'heading'     => esc_html__( 'Slide Duration', 'mkd-core' ),
                    'description' => esc_html__( 'Default value is 5000 (ms)', 'mkd-core' ),
                    'dependency'  => array( 'element' => 'type', 'value' => array( 'slider', 'carousel' ) ),
                    'group'       => esc_html__( 'Slider Settings', 'mkd-core' )
                ),
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'slider_speed_animation',
                    'heading'     => esc_html__( 'Slide Animation Duration', 'mkd-core' ),
                    'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'mkd-core' ),
                    'dependency'  => array( 'element' => 'type', 'value' => array( 'slider', 'carousel' ) ),
                    'group'       => esc_html__( 'Slider Settings', 'mkd-core' )
                ),
			)
		));
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 * @return string
	 */
	public function render($atts, $content = null) {
		$args = array(
			'content_item'            => '',
            'enable_navigation'       => 'no',
            'slider_loop'             => 'yes',
            'slider_autoplay'         => 'yes',
            'slider_speed'            => '5000',
            'slider_speed_animation'  => '600',
		);

		$params = shortcode_atts($args, $atts);
		$params['all_items'] = json_decode(urldecode($params['content_item']), true);
		$params['all_items'] = $this->generateImageSrcToParamArray($params['all_items']);
		$params['data_params'] = $this->generateDataParams($params);

		$html = mkd_core_get_shortcode_module_template_part('templates/holder', 'image-slider', '', $params);

		return $html;
	}

	/**
	 * @param $params
	 */
	public function generateDataParams($params){
		$data_params = array(
			'data-enable-autoplay'    => 'yes',
			'data-slider-animate-in'  => 'slideInLeft',
            'data-slider-animate-out' => 'slideOutRight',
		);

        $data_params['data-enable-navigation'] = ($params['enable_navigation'] === 'yes') ? 'yes' : 'no';
        $data_params['data-enable-loop']            = ! empty( $params['slider_loop'] ) ? $params['slider_loop'] : '';
        $data_params['data-enable-autoplay']        = ! empty( $params['slider_autoplay'] ) ? $params['slider_autoplay'] : '';
        $data_params['data-slider-speed']           = ! empty( $params['slider_speed'] ) ? $params['slider_speed'] : '5000';
        $data_params['data-slider-speed-animation'] = ! empty( $params['slider_speed_animation'] ) ? $params['slider_speed_animation'] : '600';

		return $data_params;

	}

	function generateImageSrcToParamArray($items){

		if(is_array($items) && count($items)){

			foreach ($items as $item_key => $item){
				if(isset($item['image']) && $item['image'] !== '' ){

					$image_url_obj = wp_get_attachment_image_src($item['image'], 'full');
					$items[$item_key]['image_style']= '';
					$items[$item_key]['image_url']= '';

					if($image_url_obj && $image_url_obj !== ''){
						$items[$item_key]['image_style'] = 'background-image: url('.esc_url($image_url_obj[0]).')';
						$items[$item_key]['image_url'] = $image_url_obj[0];
					}

				}

			}

		}

		return $items;

	}

}