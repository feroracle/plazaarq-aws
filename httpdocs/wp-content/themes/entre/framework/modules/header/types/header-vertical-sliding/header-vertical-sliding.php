<?php
namespace EntreMikado\Modules\Header\Types;

use EntreMikado\Modules\Header\Lib\HeaderType;

/**
 * Class that represents Header Vertical layout and option
 *
 * Class HeaderVertical
 */
class HeaderVerticalSliding extends HeaderType {
	protected $mobileHeaderHeight;
	
	public function __construct() {
		$this->slug = 'header-vertical-sliding';
		
		if ( ! is_admin() ) {
			$this->mobileHeaderHeight = entre_mikado_set_default_mobile_menu_height_for_header_types();
			
			add_action( 'wp', array( $this, 'setHeaderHeightProps' ) );
			
			add_filter( 'entre_mikado_js_global_variables', array( $this, 'getGlobalJSVariables' ) );
			add_filter( 'entre_mikado_per_page_js_vars', array( $this, 'getPerPageJSVariables' ) );
		}
	}
	
	/**
	 * Loads template for header type
	 *
	 * @param array $parameters associative array of variables to pass to template
	 */
	public function loadTemplate( $parameters = array() ) {
		$parameters['holder_class'] = entre_mikado_vertical_sliding_header_holder_class();
		
		$parameters = apply_filters( 'entre_mikado_header_vertical_sliding_parameters', $parameters );
		
		entre_mikado_get_module_template_part( 'templates/' . $this->slug, $this->moduleName . '/types/' . $this->slug, '', $parameters );
	}
	
	/**
	 * Sets header height properties after WP object is set up
	 */
	public function setHeaderHeightProps() {
		$this->mobileHeaderHeight = $this->calculateMobileHeaderHeight();
	}
	
	/**
	 * Returns total height of transparent parts of header
	 *
	 * @return mixed
	 */
	public function calculateHeightOfTransparency() {
		$menuAreaTransparent = false;
		
		if ( is_404() ) {
			$menuAreaTransparent = true;
		}
		
		$transparencyHeight = 0;
		
		if ( $menuAreaTransparent ) {
			$transparencyHeight = $this->mobileHeaderHeight;
		}
		
		return $transparencyHeight;
	}
	
	/**
	 * Returns height of header parts that are totaly transparent
	 *
	 * @return mixed
	 */
	public function calculateHeightOfCompleteTransparency() {
		return 0;
	}
	
	/**
	 * Returns header height
	 *
	 * @return mixed
	 */
	public function calculateHeaderHeight() {
		return 0;
	}
	
	/**
	 * Returns total height of mobile header
	 *
	 * @return int|string
	 */
	public function calculateMobileHeaderHeight() {
		$mobileHeaderHeight = $this->mobileHeaderHeight;
		
		return $mobileHeaderHeight;
	}
	
	/**
	 * Returns global js variables of header
	 *
	 * @param $globalVariables
	 *
	 * @return int|string
	 */
	public function getGlobalJSVariables( $globalVariables ) {
		$globalVariables['mkdLogoAreaHeight']     = 0;
		$globalVariables['mkdMenuAreaHeight']     = 0;
		$globalVariables['mkdMobileHeaderHeight'] = $this->mobileHeaderHeight;
		
		return $globalVariables;
	}
	
	/**
	 * Returns per page js variables of header
	 *
	 * @param $perPageVars
	 *
	 * @return int|string
	 */
	public function getPerPageJSVariables( $perPageVars ) {
		$perPageVars['mkdHeaderTransparencyHeight'] = 0;
        $perPageVars['mkdHeaderVerticalWidth'] = 90;
		
		return $perPageVars;
	}
}