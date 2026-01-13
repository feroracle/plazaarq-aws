<?php

if ( ! function_exists( 'entre_mikado_set_search_fullscreen_global_option' ) ) {
    /**
     * This function set search type value for search options map
     */
    function entre_mikado_set_search_fullscreen_global_option( $search_type_options ) {
        $search_type_options['fullscreen'] = esc_html__( 'Fullscreen', 'entre' );

        return $search_type_options;
    }

    add_filter( 'entre_mikado_search_type_global_option', 'entre_mikado_set_search_fullscreen_global_option' );
}