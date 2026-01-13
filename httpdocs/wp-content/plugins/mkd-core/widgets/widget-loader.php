<?php

if ( ! function_exists( 'entre_core_register_widgets' ) ) {
    function entre_core_register_widgets() {
        $widgets = apply_filters( 'entre_core_filter_register_widgets', $widgets = array() );

        foreach ( $widgets as $widget ) {
            register_widget( $widget );
        }
    }

    add_action( 'widgets_init', 'entre_core_register_widgets' );
}