<?php

if(!function_exists('entre_mikado_register_sticky_sidebar_widget')) {
	/**
	 * Function that register sticky sidebar widget
	 */
	function entre_mikado_register_sticky_sidebar_widget($widgets) {
		$widgets[] = 'EntreMikadoStickySidebar';
		
		return $widgets;
	}
	
	add_filter('entre_core_filter_register_widgets', 'entre_mikado_register_sticky_sidebar_widget');
}