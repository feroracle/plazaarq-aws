<?php

if ( ! function_exists( 'mkd_core_portfolio_meta_box_functions' ) ) {
	function mkd_core_portfolio_meta_box_functions( $post_types ) {
		$post_types[] = 'portfolio-item';
		
		return $post_types;
	}
	
	add_filter( 'entre_mikado_meta_box_post_types_save', 'mkd_core_portfolio_meta_box_functions' );
	add_filter( 'entre_mikado_meta_box_post_types_remove', 'mkd_core_portfolio_meta_box_functions' );
}

if ( ! function_exists( 'mkd_core_portfolio_scope_meta_box_functions' ) ) {
	function mkd_core_portfolio_scope_meta_box_functions( $post_types ) {
		$post_types[] = 'portfolio-item';
		
		return $post_types;
	}
	
	add_filter( 'entre_mikado_set_scope_for_meta_boxes', 'mkd_core_portfolio_scope_meta_box_functions' );
}

if ( ! function_exists( 'mkd_core_portfolio_add_social_share_option' ) ) {
	function mkd_core_portfolio_add_social_share_option( $container ) {
		entre_mikado_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'enable_social_share_on_portfolio-item',
				'default_value' => 'no',
				'label'         => esc_html__( 'Portfolio Item', 'mkd-core' ),
				'description'   => esc_html__( 'Show Social Share for Portfolio Items', 'mkd-core' ),
				'parent'        => $container
			)
		);
	}
	
	add_action( 'entre_mikado_post_types_social_share', 'mkd_core_portfolio_add_social_share_option', 10, 1 );
}

if ( ! function_exists( 'mkd_core_register_portfolio_cpt' ) ) {
	function mkd_core_register_portfolio_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'MikadoCore\CPT\Portfolio\PortfolioRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'mkd_core_filter_register_custom_post_types', 'mkd_core_register_portfolio_cpt' );
}

if ( ! function_exists( 'mkd_core_get_archive_portfolio_list' ) ) {
	function mkd_core_get_archive_portfolio_list( $mkd_taxonomy_slug = '', $mkd_taxonomy_name = '' ) {
		
		$number_of_items        = 12;
		$number_of_items_option = entre_mikado_options()->getOptionValue( 'portfolio_archive_number_of_items' );
		if ( ! empty( $number_of_items_option ) ) {
			$number_of_items = $number_of_items_option;
		}
		
		$number_of_columns        = 4;
		$number_of_columns_option = entre_mikado_options()->getOptionValue( 'portfolio_archive_number_of_columns' );
		if ( ! empty( $number_of_columns_option ) ) {
			$number_of_columns = $number_of_columns_option;
		}
		
		$space_between_items        = 'normal';
		$space_between_items_option = entre_mikado_options()->getOptionValue( 'portfolio_archive_space_between_items' );
		if ( ! empty( $space_between_items_option ) ) {
			$space_between_items = $space_between_items_option;
		}
		
		$image_size        = 'landscape';
		$image_size_option = entre_mikado_options()->getOptionValue( 'portfolio_archive_image_size' );
		if ( ! empty( $image_size_option ) ) {
			$image_size = $image_size_option;
		}
		
		$item_layout        = 'standard-shader';
		$item_layout_option = entre_mikado_options()->getOptionValue( 'portfolio_archive_item_layout' );
		if ( ! empty( $item_layout_option ) ) {
			$item_layout = $item_layout_option;
		}
		
		$category = $mkd_taxonomy_name === 'portfolio-category' && ! empty( $mkd_taxonomy_slug ) ? $mkd_taxonomy_slug : '';
		$tag      = $mkd_taxonomy_name === 'portfolio-tag' && ! empty( $mkd_taxonomy_slug ) ? $mkd_taxonomy_slug : '';
		
		$params = array(
			'type'                => 'gallery',
			'number_of_items'     => $number_of_items,
			'number_of_columns'   => $number_of_columns,
			'space_between_items' => $space_between_items,
			'image_proportions'   => $image_size,
			'category'            => $category,
			'tag'                 => $tag,
			'item_layout'         => $item_layout,
			'pagination_type'     => 'load-more'
		);
		
		$html = entre_mikado_execute_shortcode( 'mkd_portfolio_list', $params );
		
		print entre_mikado_display_content_output($html);
	}
}

// Load portfolio shortcodes
if(!function_exists('mkd_core_include_portfolio_shortcodes_files')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function mkd_core_include_portfolio_shortcodes_files() {
        foreach(glob(MIKADO_CORE_CPT_PATH.'/portfolio/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('mkd_core_action_include_shortcodes_file', 'mkd_core_include_portfolio_shortcodes_files');
}

if ( ! function_exists( 'mkd_core_set_portfolio_single_info_follow_body_class' ) ) {
	/**
	 * Function that adds follow portfolio info class to body if sticky sidebar is enabled on portfolio single layouts
	 *
	 * @param $classes array of body classes
	 *
	 * @return array with follow portfolio info class body class added
	 */
	function mkd_core_set_portfolio_single_info_follow_body_class( $classes ) {
		if ( is_singular( 'portfolio-item' ) && entre_mikado_options()->getOptionValue( 'portfolio_single_sticky_sidebar' ) == 'yes' ) {
			$classes[] = 'mkd-follow-portfolio-info';
		}
		
		return $classes;
	}
	
	add_filter( 'body_class', 'mkd_core_set_portfolio_single_info_follow_body_class' );
}

if ( ! function_exists( 'mkd_core_single_portfolio_title_display' ) ) {
	/**
	 * Function that checks option for single portfolio title and overrides it with filter
	 */
	function mkd_core_single_portfolio_title_display( $show_title_area ) {
		if ( is_singular( 'portfolio-item' ) ) {
			//Override displaying title based on portfolio option
			$show_title_area_meta = entre_mikado_get_meta_field_intersect( 'show_title_area_portfolio_single' );
			
			if ( ! empty( $show_title_area_meta ) ) {
				$show_title_area = $show_title_area_meta == 'yes' ? true : false;
			}
		}
		
		return $show_title_area;
	}
	
	add_filter( 'entre_mikado_show_title_area', 'mkd_core_single_portfolio_title_display' );
}

if ( ! function_exists( 'mkd_core_set_breadcrumbs_output_for_portfolio' ) ) {
	function mkd_core_set_breadcrumbs_output_for_portfolio( $childContent, $delimiter, $before, $after ) {
		
		if ( is_tax( 'portfolio-category' ) ) {
			$portfolio_category = wp_get_post_terms( get_the_ID(), 'portfolio-category' );
			$portfolio_category = $portfolio_category[0];
			$childContent       = '';
			
			if ( ! empty( $portfolio_category ) ) {
				if ( isset( $portfolio_category->parent ) && $portfolio_category->parent != 0 ) {
					$childContent .= get_category_parents( $portfolio_category->parent, true, ' ' . $delimiter );
				}
				$childContent .= $before . $portfolio_category->name . $after;
			}
			
		} elseif ( is_tax( 'portfolio-tag' ) ) {
			$portfolio_tag = wp_get_post_terms( get_the_ID(), 'portfolio-tag' );
			$portfolio_tag = $portfolio_tag[0];
			
			if ( ! empty( $portfolio_tag ) ) {
				$childContent = $before . $portfolio_tag->name . $after;
			}
			
		} elseif ( is_singular( 'portfolio-item' ) ) {
			$portfolio_categories = wp_get_post_terms( entre_mikado_get_page_id(), 'portfolio-category' );
			$childContent         = '';
			
			if ( ! empty( $portfolio_categories ) && count( $portfolio_categories ) ) {
				foreach ( $portfolio_categories as $cat ) {
					$childContent .= '<a itemprop="url" href="' . get_term_link( $cat->term_id ) . '">' . $cat->name . '</a>' . $delimiter;
				}
			}
			
			$childContent .= $before . get_the_title() . $after;
			
		}
		
		return $childContent;
	}
	
	add_filter( 'entre_mikado_breadcrumbs_title_child_output', 'mkd_core_set_breadcrumbs_output_for_portfolio', 10, 4 );
}

if ( ! function_exists( 'mkd_core_set_single_portfolio_comments_enabled' ) ) {
	function mkd_core_set_single_portfolio_comments_enabled( $comments ) {
		if ( is_singular( 'portfolio-item' ) && entre_mikado_options()->getOptionValue( 'portfolio_single_comments' ) == 'yes' ) {
			$comments = true;
		}
		
		return $comments;
	}
	
	add_filter( 'entre_mikado_post_type_comments', 'mkd_core_set_single_portfolio_comments_enabled', 10, 1 );
}

if ( ! function_exists( 'mkd_core_get_single_portfolio' ) ) {
	function mkd_core_get_single_portfolio() {
		$portfolio_template = entre_mikado_get_meta_field_intersect( 'portfolio_single_template' );
		
		$params = array(
			'holder_classes' => 'mkd-ps-' . $portfolio_template . '-layout',
			'item_layout'    => $portfolio_template
		);
		
		mkd_core_get_cpt_single_module_template_part( 'templates/single/holder', 'portfolio', $portfolio_template, $params );
	}
}

if ( ! function_exists( 'mkd_core_set_single_portfolio_style' ) ) {
	/**
	 * Function that return padding for content
	 */
	function mkd_core_set_single_portfolio_style( $style ) {
		$page_id      = entre_mikado_get_page_id();
		$class_prefix = entre_mikado_get_unique_page_class( $page_id );
		
		$current_styles = '';
		$current_style  = array();
		
		$current_selector = array(
			$class_prefix . ' .mkd-portfolio-single-holder .mkd-ps-info-holder'
		);
		
		$info_padding_top = get_post_meta( $page_id, 'portfolio_info_top_padding', true );
		
		if ( ! empty( $info_padding_top ) ) {
			$current_style['padding-top'] = entre_mikado_filter_px( $info_padding_top ) . 'px';
			
			$current_styles .= entre_mikado_dynamic_css( $current_selector, $current_style );
		}
		
		$current_style = $current_styles . $style;
		
		return $current_style;
	}
	
	add_filter( 'entre_mikado_add_page_custom_style', 'mkd_core_set_single_portfolio_style' );
}

if ( ! function_exists( 'mkd_core_add_portfolio_attachment_custom_field' ) ) {
	function mkd_core_add_portfolio_attachment_custom_field( $form_fields, $post = null ) {
		if ( wp_attachment_is_image( $post->ID ) ) {
			$field_value = get_post_meta( $post->ID, 'portfolio_single_masonry_image_size', true );
			
			$form_fields['portfolio_single_masonry_image_size'] = array(
				'input' => 'html',
				'label' => esc_html__( 'Image Size', 'mkd-core' ),
				'helps' => esc_html__( 'Choose image size for portfolio single item - Masonry layout', 'mkd-core' )
			);
			
			$form_fields['portfolio_single_masonry_image_size']['html'] = "<select name='attachments[{$post->ID}][portfolio_single_masonry_image_size]'>";
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'mkd-default-masonry-item', false ) . ' value="mkd-default-masonry-item">' . esc_html__( 'Default Size', 'mkd-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'mkd-large-masonry-item', false ) . ' value="mkd-large-masonry-item">' . esc_html__( 'Large Size', 'mkd-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '</select>';
		}
		
		return $form_fields;
	}
	
	add_filter( 'attachment_fields_to_edit', 'mkd_core_add_portfolio_attachment_custom_field', 10, 2 );
}

if ( ! function_exists( 'mkd_core_save_image_portfolio_attachment_fields' ) ) {
	/**
	 * @param array $post
	 * @param array $attachment
	 *
	 * @return array
	 */
	function mkd_core_save_image_portfolio_attachment_fields( $post, $attachment ) {
		
		if ( isset( $attachment['portfolio_single_masonry_image_size'] ) ) {
			update_post_meta( $post['ID'], 'portfolio_single_masonry_image_size', $attachment['portfolio_single_masonry_image_size'] );
		}
		
		return $post;
	}
	
	add_filter( 'attachment_fields_to_save', 'mkd_core_save_image_portfolio_attachment_fields', 10, 2 );
}

if ( ! function_exists( 'mkd_core_get_portfolio_single_media' ) ) {
	function mkd_core_get_portfolio_single_media() {
		$image_ids       = get_post_meta( get_the_ID(), 'mkd-portfolio-image-gallery', true );
		$videos          = get_post_meta( get_the_ID(), 'mkd_portfolio_images', true );
		$portfolio_media = array();
		
		if ( $image_ids !== '' ) {
			$image_ids = explode( ',', $image_ids );
			
			foreach ( $image_ids as $image_id ) {
				$media                   = array();
				$media['title']          = get_the_title( $image_id );
				$media['type']           = 'image';
				$media['description']    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$media['image_src']      = wp_get_attachment_image_src( $image_id, 'full' );
				$media['holder_classes'] = '';
				
				$image_size = get_post_meta( $image_id, 'portfolio_single_masonry_image_size', true );
				
				switch ( $image_size ) {
					case 'mkd-default-masonry-item':
						$media['holder_classes'] = 'mkd-ps-masonry-normal-item';
						break;
					case 'mkd-large-masonry-item':
						$media['holder_classes'] = 'mkd-ps-masonry-large-item';
						break;
				}
				
				$portfolio_media[] = $media;
			}
		}
		
		if ( is_array( $videos ) && count( $videos ) ) {
			usort( $videos, 'mkd_core_compare_portfolio_videos' );
			foreach ( $videos as $video ) {
				$media = array();
				
				if ( ! empty( $video['portfoliovideotype'] ) ) {
					$media['title']       = $video['portfoliotitle'];
					$media['type']        = $video['portfoliovideotype'];
					$media['description'] = 'video';
					$media['video_url']   = mkd_core_get_portfolio_video_url( $video );
					
					if ( $video['portfoliovideotype'] == 'self' ) {
						$media['video_cover'] = ! empty( $video['portfoliovideoimage'] ) ? $video['portfoliovideoimage'] : '';
					}
					
					if ( $video['portfoliovideotype'] !== 'self' ) {
						$media['video_id'] = $video['portfoliovideoid'];
					}
				} elseif ( ! empty( $video['portfolioimgtype'] ) ) {
					$media['title']     = $video['portfoliotitle'];
					$media['type']      = $video['portfolioimgtype'];
					$media['image_src'] = $video['portfolioimg'];
				}
				
				$portfolio_media[] = $media;
			}
		}
		
		return $portfolio_media;
	}
}

if ( ! function_exists( 'mkd_core_get_portfolio_video_url' ) ) {
	function mkd_core_get_portfolio_video_url( $video ) {
		switch ( $video['portfoliovideotype'] ) {
			case 'youtube':
				return 'https://www.youtube.com/embed/' . $video['portfoliovideoid'] . '?wmode=transparent';
				break;
			case 'vimeo';
				return 'https://player.vimeo.com/video/' . $video['portfoliovideoid'] . '?title=0&amp;byline=0&amp;portrait=0';
				break;
			case 'self':
				$return_array = array();
				
				if ( ! empty( $video['portfoliovideomp4'] ) ) {
					$return_array['mp4'] = $video['portfoliovideomp4'];
				}
				
				return $return_array;
				
				break;
		}
	}
}

if ( ! function_exists( 'mkd_core_get_portfolio_single_media_html' ) ) {
	function mkd_core_get_portfolio_single_media_html( $media ) {
		$params = array();
		
		if ( $media['type'] == 'image' ) {
			$params['lightbox'] = entre_mikado_options()->getOptionValue( 'portfolio_single_lightbox_images' ) == 'yes';
			
			$media['image_url'] = is_array( $media['image_src'] ) ? $media['image_src'][0] : $media['image_src'];
			if ( empty( $media['description'] ) ) {
				$media['description'] = $media['title'];
			}
		}
		
		if ( in_array( $media['type'], array( 'youtube', 'vimeo' ) ) ) {
			$params['lightbox'] = entre_mikado_options()->getOptionValue( 'portfolio_single_lightbox_videos' ) == 'yes';
			
			if ( $params['lightbox'] ) {
				switch ( $media['type'] ) {
					case 'vimeo':
						$url      = 'https://vimeo.com/api/v2/video/' . $media['video_id'] . '.php';
						$request  = wp_remote_get($url);
						$response = unserialize( wp_remote_retrieve_body( $request ) );
						
						$params['video_title']    = $response[0]['title'];
						$params['lightbox_thumb'] = $response[0]['thumbnail_large'];
						break;
					case 'youtube':
						$params['video_title'] = $media['title'];
						
						$params['lightbox_thumb'] = 'https://img.youtube.com/vi/' . trim( $media['video_id'] ) . '/sddefault.jpg';
						break;
				}
			}
		}
		
		$params['media'] = $media;
		
		mkd_core_get_cpt_single_module_template_part( 'templates/single/media/' . $media['type'], 'portfolio', '', $params );
	}
}

if ( ! function_exists( 'mkd_core_compare_portfolio_videos' ) ) {
	/**
	 * Function that compares two portfolio image for sorting
	 *
	 * @param $a int first image
	 * @param $b int second image
	 *
	 * @return int result of comparison
	 */
	function mkd_core_compare_portfolio_videos( $a, $b ) {
		if ( isset( $a['portfolioimgordernumber'] ) && isset( $b['portfolioimgordernumber'] ) ) {
			if ( $a['portfolioimgordernumber'] == $b['portfolioimgordernumber'] ) {
				return 0;
			}
			
			return ( $a['portfolioimgordernumber'] < $b['portfolioimgordernumber'] ) ? - 1 : 1;
		}
		
		return 0;
	}
}

if ( ! function_exists( 'mkd_core_compare_portfolio_options' ) ) {
	/**
	 * Function that compares two portfolio options for sorting
	 *
	 * @param $a int first option
	 * @param $b int second option
	 *
	 * @return int result of comparison
	 */
	function mkd_core_compare_portfolio_options( $a, $b ) {
		if ( isset( $a['optionlabelordernumber'] ) && isset( $b['optionlabelordernumber'] ) ) {
			if ( $a['optionlabelordernumber'] == $b['optionlabelordernumber'] ) {
				return 0;
			}
			
			return ( $a['optionlabelordernumber'] < $b['optionlabelordernumber'] ) ? - 1 : 1;
		}
		
		return 0;
	}
}

if ( ! function_exists( 'mkd_core_get_portfolio_single_related_posts' ) ) {
	/**
	 * Function for returning portfolio single related posts
	 *
	 * @param $post_id
	 *
	 * @return WP_Query
	 */
	function mkd_core_get_portfolio_single_related_posts( $post_id ) {
		//Get tags
		$tags = wp_get_object_terms( $post_id, 'portfolio-tag' );
		
		//Get categories
		$categories = wp_get_object_terms( $post_id, 'portfolio-category' );
		
		$tag_ids = array();
		if ( $tags ) {
			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}
		}
		
		$category_ids = array();
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$category_ids[] = $category->term_id;
			}
		}
		
		$hasRelatedByTag = false;
		
		if ( $tag_ids ) {
			$related_by_tag = mkd_core_get_portfolio_single_related_posts_by_param( $post_id, $tag_ids, 'portfolio-tag' );
			
			if ( ! empty( $related_by_tag->posts ) ) {
				$hasRelatedByTag = true;
				
				return $related_by_tag;
			}
		}
		
		if ( $categories && ! $hasRelatedByTag ) {
			$related_by_category = mkd_core_get_portfolio_single_related_posts_by_param( $post_id, $category_ids, 'portfolio-category' );
			
			if ( ! empty( $related_by_category->posts ) ) {
				return $related_by_category;
			}
		}
	}
}

if ( ! function_exists( 'mkd_core_get_portfolio_single_related_posts_by_param' ) ) {
	/**
	 * @param $post_id - Post ID
	 * @param $term_ids - Category or Tag IDs
	 * @param $taxonomy
	 *
	 * @return WP_Query
	 */
	function mkd_core_get_portfolio_single_related_posts_by_param( $post_id, $term_ids, $taxonomy ) {
		$args = array(
			'post_status'    => 'publish',
			'post__not_in'   => array( $post_id ),
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => '4',
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_ids,
				),
			)
		);
		
		$related_by_taxonomy = new WP_Query( $args );
		
		return $related_by_taxonomy;
	}
}

if ( ! function_exists( 'mkd_core_add_portfolio_to_search_types' ) ) {
	function mkd_core_add_portfolio_to_search_types( $post_types ) {
		
		$post_types['portfolio-item'] = 'Portfolio';
		
		return $post_types;
	}
	
	add_filter( 'entre_mikado_search_post_type_widget_params_post_type', 'mkd_core_add_portfolio_to_search_types' );
}

/**
 * Loads more function for portfolio.
 */
if ( ! function_exists( 'mkd_core_portfolio_ajax_load_more' ) ) {
	function mkd_core_portfolio_ajax_load_more() {
		$shortcode_params = array();
		
		if ( ! empty( $_POST ) ) {
			foreach ( $_POST as $key => $value ) {
				if ( $key !== '' ) {
					$addUnderscoreBeforeCapitalLetter = preg_replace( '/([A-Z])/', '_$1', $key );
					$setAllLettersToLowercase         = strtolower( $addUnderscoreBeforeCapitalLetter );
					
					$shortcode_params[ $setAllLettersToLowercase ] = $value;
				}
			}
		}
		
		$port_list = new \MikadoCore\CPT\Shortcodes\Portfolio\PortfolioList();
		
		$query_array                     = $port_list->getQueryArray( $shortcode_params );
		$query_results                   = new \WP_Query( $query_array );
		$shortcode_params['this_object'] = $port_list;
		
		$html = '';
		if ( $query_results->have_posts() ):
			while ( $query_results->have_posts() ) : $query_results->the_post();
				$html .= mkd_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'portfolio-item', $shortcode_params['item_type'], $shortcode_params );
			endwhile;
		else:
			$html .= mkd_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'parts/posts-not-found', '', $shortcode_params );
		endif;
		
		wp_reset_postdata();
		
		$return_obj = array(
			'html' => $html,
		);
		
		echo json_encode( $return_obj );
		exit;
	}
}

add_action( 'wp_ajax_nopriv_mkd_core_portfolio_ajax_load_more', 'mkd_core_portfolio_ajax_load_more' );
add_action( 'wp_ajax_mkd_core_portfolio_ajax_load_more', 'mkd_core_portfolio_ajax_load_more' );