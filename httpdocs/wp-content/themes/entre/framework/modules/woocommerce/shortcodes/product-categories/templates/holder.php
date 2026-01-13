<?php
if(is_array($query_result) && count($query_result)){ ?>
	<div class="mkd-prod-cats-holder clearfix <?php echo esc_attr($holder_clases); ?>" <?php echo entre_mikado_get_inline_attrs($holder_data); ?>>
		<div class="mkd-prod-cat-holder-inner clearfix">
			<?php foreach ($query_result as $term){
				$link = get_term_link($term->term_id, 'product_cat');
				$img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
				$img_style = '';
				$holder_class =  array();
				$image_url = '';

				if($img_id && $img_id !== ''){

					$image_url = wp_get_attachment_image_url($img_id, 'full');
					if($image_url && $image_url !== ''){
						$img_style = 'background-image: url('.esc_url($image_url).')';
						$holder_class[] = 'mkd-cat-with-image';
					}

				}

				$min_price = entre_mikado_woo_product_category_min_price($term->term_id);

				$term_params = array(
                    'content_position' => $content_position,
					'enable_button' => $enable_button,
					'button_params' => array(
                        'text'  => esc_html__('Shop Now', 'entre'),
                        'type'  => 'simple',
                        'link'  => $link,
                    ),
					'term' => $term,
					'link' => $link,
					'img_url' => $image_url,
					'img_style' => $img_style,
					'min_price' => $min_price,
					'item_classes'   => implode(' ', $holder_class),
					'button_params' => array(
						'type' => 'simple',
						'text' => esc_html__('Shop now', 'entre'),
						'link' => $link,
					)
				);

				echo entre_mikado_get_woo_shortcode_module_template_part('templates/item', 'product-categories', '', $term_params);

			} ?>
		</div>
	</div>
<?php }