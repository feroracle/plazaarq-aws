<?php

if ( ! function_exists( 'entre_mikado_register_blog_masonry_gallery_template_file' ) ) {
	/**
	 * Function that register blog masonry gallery template
	 */
	function entre_mikado_register_blog_masonry_gallery_template_file( $templates ) {
		$templates['blog-masonry-gallery'] = esc_html__( 'Blog: Masonry Gallery', 'entre' );
		
		return $templates;
	}
	
	add_filter( 'entre_mikado_register_blog_templates', 'entre_mikado_register_blog_masonry_gallery_template_file' );
}

if ( ! function_exists( 'entre_mikado_set_blog_masonry_gallery_type_global_option' ) ) {
	/**
	 * Function that set blog list type value for global blog option map
	 */
	function entre_mikado_set_blog_masonry_gallery_type_global_option( $options ) {
		$options['masonry-gallery'] = esc_html__( 'Blog: Masonry Gallery', 'entre' );
		
		return $options;
	}
	
	add_filter( 'entre_mikado_blog_list_type_global_option', 'entre_mikado_set_blog_masonry_gallery_type_global_option' );
}