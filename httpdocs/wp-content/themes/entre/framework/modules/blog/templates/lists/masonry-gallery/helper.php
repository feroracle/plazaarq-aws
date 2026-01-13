<?php

if ( ! function_exists( 'entre_mikado_get_blog_holder_params' ) ) {
	/**
	 * Function that generates params for holders on blog templates
	 */
	function entre_mikado_get_blog_holder_params( $params ) {
		$params_list = array();
		
		$masonry_layout = entre_mikado_get_meta_field_intersect( 'blog_masonry_layout' );
		if ( $masonry_layout === 'in-grid' ) {
			$params_list['holder'] = 'mkd-container';
			$params_list['inner']  = 'mkd-container-inner clearfix';
		} else {
			$params_list['holder'] = 'mkd-full-width';
			$params_list['inner']  = 'mkd-full-width-inner';
		}
		
		return $params_list;
	}
	
	add_filter( 'entre_mikado_blog_holder_params', 'entre_mikado_get_blog_holder_params' );
}

if ( ! function_exists( 'entre_mikado_get_blog_list_classes' ) ) {
	/**
	 * Function that generates blog list holder classes for blog list templates
	 */
	function entre_mikado_get_blog_list_classes( $classes ) {
		$list_classes   = array();
		$list_classes[] = 'mkd-blog-type-masonry';
		
		$number_of_columns = entre_mikado_get_meta_field_intersect( 'blog_masonry_number_of_columns' );
		if ( ! empty( $number_of_columns ) ) {
			$list_classes[] = 'mkd-blog-' . $number_of_columns . '-columns';
		}
		
		$space_between_items = entre_mikado_get_meta_field_intersect( 'blog_masonry_space_between_items' );
		if ( ! empty( $space_between_items ) ) {
			$list_classes[] = 'mkd-' . $space_between_items . '-space';
		}
		
		$masonry_layout = entre_mikado_get_meta_field_intersect( 'blog_masonry_layout' );
		$list_classes[] = 'mkd-blog-masonry-' . $masonry_layout;
		
		$classes = array_merge( $classes, $list_classes );
		
		return $classes;
	}
	
	add_filter( 'entre_mikado_blog_list_classes', 'entre_mikado_get_blog_list_classes' );
}

if ( ! function_exists( 'entre_mikado_blog_part_params' ) ) {
	function entre_mikado_blog_part_params( $params ) {
		$part_params              = array();
		$part_params['title_tag'] = 'h3';
		$part_params['link_tag']  = 'h6';
		$part_params['quote_tag'] = 'h6';
		
		return array_merge( $params, $part_params );
	}
	
	add_filter( 'entre_mikado_blog_part_params', 'entre_mikado_blog_part_params' );
}