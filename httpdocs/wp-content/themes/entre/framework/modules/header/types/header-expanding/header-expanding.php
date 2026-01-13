<?php
namespace EntreMikado\Modules\Header\Types;

use EntreMikado\Modules\Header\Lib\HeaderType;

/**
 * Class that represents Header expanding layout and option
 *
 * Class Headerexpanding
 */
class HeaderExpanding extends HeaderType {
	protected $heightOfTransparency;
	protected $heightOfCompleteTransparency;
	protected $headerHeight;
	protected $mobileHeaderHeight;
	protected $menuAreaHeight;
	
	/**
	 * Sets slug property which is the same as value of option in DB
	 */
	public function __construct() {
		$this->slug = 'header-expanding';
		
		if ( ! is_admin() ) {
			$this->menuAreaHeight     = entre_mikado_set_default_menu_height_for_header_types();
			$this->mobileHeaderHeight = entre_mikado_set_default_mobile_menu_height_for_header_types();
			
			add_action( 'wp', array( $this, 'setHeaderHeightProps' ) );
			
			add_filter( 'entre_mikado_js_global_variables', array( $this, 'getGlobalJSVariables' ) );
			add_filter( 'entre_mikado_per_page_js_vars', array( $this, 'getPerPageJSVariables' ) );
		}
	}

	/**
	 * Loads template file for this header type
	 *
	 * @param array $parameters associative array of variables that needs to passed to template
	 */
	public function loadTemplate( $parameters = array() ) {

		entre_mikado_get_module_template_part( 'templates/' . $this->slug, $this->moduleName . '/types/' . $this->slug, '', $parameters );

	}
	
	/**
	 * Sets header height properties after WP object is set up
	 */
	public function setHeaderHeightProps() {
		$this->heightOfTransparency         = $this->calculateHeightOfTransparency();
		$this->heightOfCompleteTransparency = $this->calculateHeightOfCompleteTransparency();
		$this->headerHeight                 = $this->calculateHeaderHeight();
		$this->mobileHeaderHeight           = $this->calculateMobileHeaderHeight();
	}
	
	/**
	 * Returns total height of transparent parts of header
	 *
	 * @return int
	 */
	public function calculateHeightOfTransparency() {
	
		$transparencyHeight = $this->menuAreaHeight;
		
		return $transparencyHeight;
	}
	
	/**
	 * Returns height of completely transparent header parts
	 *
	 * @return int
	 */
	public function calculateHeightOfCompleteTransparency() {
		
		$transparencyHeight = $this->menuAreaHeight;
		
		return $transparencyHeight;
	}
	
	
	/**
	 * Returns total height of header
	 *
	 * @return int|string
	 */
	public function calculateHeaderHeight() {
		$headerHeight = $this->menuAreaHeight;
		if ( entre_mikado_is_top_bar_enabled() ) {
			$headerHeight += entre_mikado_get_top_bar_height();
		}
		
		return $headerHeight;
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
		$globalVariables['mkdMenuAreaHeight']     = $this->menuAreaHeight;
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
		//calculate transparency height only if header has no sticky behaviour
		$header_behavior = entre_mikado_get_meta_field_intersect( 'header_behaviour' );
		if ( ! in_array( $header_behavior, array( 'sticky-header-on-scroll-up', 'sticky-header-on-scroll-down-up' ) ) ) {
			$perPageVars['mkdHeaderTransparencyHeight'] = $this->headerHeight - ( entre_mikado_get_top_bar_height() + $this->heightOfCompleteTransparency );
		} else {
			$perPageVars['mkdHeaderTransparencyHeight'] = 0;
		}
		
		return $perPageVars;
	}
	
}