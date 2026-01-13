<?php

if ( ! function_exists( 'entre_mikado_map_post_audio_meta' ) ) {
	function entre_mikado_map_post_audio_meta() {
		$audio_post_format_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Audio Post Format', 'entre' ),
				'name'  => 'post_format_audio_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_audio_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Audio Type', 'entre' ),
				'description'   => esc_html__( 'Choose audio type', 'entre' ),
				'parent'        => $audio_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Audio Service', 'entre' ),
					'self'            => esc_html__( 'Self Hosted', 'entre' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#mkd_mkd_audio_self_hosted_container',
						'self'            => '#mkd_mkd_audio_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#mkd_mkd_audio_embedded_container',
						'self'            => '#mkd_mkd_audio_self_hosted_container'
					)
				)
			)
		);
		
		$mkd_audio_embedded_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $audio_post_format_meta_box,
				'name'            => 'mkd_audio_embedded_container',
				'hidden_property' => 'mkd_audio_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$mkd_audio_self_hosted_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $audio_post_format_meta_box,
				'name'            => 'mkd_audio_self_hosted_container',
				'hidden_property' => 'mkd_audio_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio URL', 'entre' ),
				'description' => esc_html__( 'Enter audio URL', 'entre' ),
				'parent'      => $mkd_audio_embedded_container,
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_audio_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio Link', 'entre' ),
				'description' => esc_html__( 'Enter audio link', 'entre' ),
				'parent'      => $mkd_audio_self_hosted_container,
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_audio_meta', 23 );
}