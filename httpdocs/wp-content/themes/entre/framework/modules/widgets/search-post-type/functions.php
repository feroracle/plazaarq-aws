<?php

if ( ! function_exists( 'entre_mikado_register_search_post_type_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function entre_mikado_register_search_post_type_widget( $widgets ) {
		$widgets[] = 'EntreMikadoSearchPostType';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_search_post_type_widget' );
}

if ( ! function_exists( 'entre_mikado_search_post_types' ) ) {
	function entre_mikado_search_post_types() {
		$user_id = get_current_user_id();
		
		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			entre_mikado_ajax_status( 'error', esc_html__( 'All fields are empty', 'entre' ) );
		} else {
			$args = array(
				'post_type'      => sanitize_text_field( $_POST['postType'] ),
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'orderby'        => 'date',
				's'              =>  sanitize_text_field( $_POST['term'] ),
				'posts_per_page' => 5
			);
			
			$html  = '';
			$query = new WP_Query( $args );
			
			if ( $query->have_posts() ) {
				$html .= '<ul>';
					while ( $query->have_posts() ) {
						$query->the_post();
						$html .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
					}
				$html              .= '</ul>';
				$json_data['html'] = $html;
				entre_mikado_ajax_status( 'success', '', $json_data );
			} else {
				$html              .= '<ul>';
					$html              .= '<li>' . esc_html__( 'No posts found.', 'entre' ) . '</li>';
				$html              .= '</ul>';
				$json_data['html'] = $html;
				entre_mikado_ajax_status( 'success', '', $json_data );
			}
		}
		
		wp_die();
	}
	
	add_action( 'wp_ajax_entre_mikado_search_post_types', 'entre_mikado_search_post_types' );
    add_action( 'wp_ajax_nopriv_entre_mikado_search_post_types', 'entre_mikado_search_post_types' );
}