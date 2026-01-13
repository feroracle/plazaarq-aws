<?php

if ( ! function_exists( 'entre_mikado_like' ) ) {
	/**
	 * Returns EntreMikadoLike instance
	 *
	 * @return EntreMikadoLike
	 */
	function entre_mikado_like() {
		return EntreMikadoLike::get_instance();
	}
}

function entre_mikado_get_like() {
	
	echo wp_kses( entre_mikado_like()->add_like(), array(
		'span' => array(
			'class'       => true,
			'aria-hidden' => true,
			'style'       => true,
			'id'          => true
		),
		'i'    => array(
			'class' => true,
			'style' => true,
			'id'    => true
		),
		'a'    => array(
			'href'  => true,
			'class' => true,
			'id'    => true,
			'title' => true,
			'style' => true
		)
	) );
}