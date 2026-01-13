<?php

if ( ! function_exists( 'entre_mikado_map_post_video_meta' ) ) {
	function entre_mikado_map_post_video_meta() {
		$video_post_format_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Video Post Format', 'entre' ),
				'name'  => 'post_format_video_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'entre' ),
				'description'   => esc_html__( 'Choose video type', 'entre' ),
				'parent'        => $video_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'entre' ),
					'self'            => esc_html__( 'Self Hosted', 'entre' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#mkd_mkd_video_self_hosted_container',
						'self'            => '#mkd_mkd_video_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#mkd_mkd_video_embedded_container',
						'self'            => '#mkd_mkd_video_self_hosted_container'
					)
				)
			)
		);
		
		$mkd_video_embedded_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $video_post_format_meta_box,
				'name'            => 'mkd_video_embedded_container',
				'hidden_property' => 'mkd_video_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$mkd_video_self_hosted_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $video_post_format_meta_box,
				'name'            => 'mkd_video_self_hosted_container',
				'hidden_property' => 'mkd_video_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'entre' ),
				'description' => esc_html__( 'Enter Video URL', 'entre' ),
				'parent'      => $mkd_video_embedded_container,
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'entre' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'entre' ),
				'parent'      => $mkd_video_self_hosted_container,
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'entre' ),
				'description' => esc_html__( 'Enter video image', 'entre' ),
				'parent'      => $mkd_video_self_hosted_container,
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_video_meta', 22 );
}