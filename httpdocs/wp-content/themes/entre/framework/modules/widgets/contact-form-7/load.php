<?php

if ( entre_mikado_contact_form_7_installed() ) {
	include_once MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/widgets/contact-form-7/contact-form-7.php';
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_cf7_widget' );
}

if ( ! function_exists( 'entre_mikado_register_cf7_widget' ) ) {
	/**
	 * Function that register cf7 widget
	 */
	function entre_mikado_register_cf7_widget( $widgets ) {
		$widgets[] = 'EntreMikadoContactForm7Widget';
		
		return $widgets;
	}
}