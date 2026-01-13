<?php
if(is_array($query_result) && count($query_result)){
	?>

	<div class="mkd-floating-prod-cats-holder clearfix <?php echo esc_attr($holder_clases); ?>" <?php echo entre_mikado_get_inline_attrs($holder_data); ?>>
		<div class="mkd-floating-prod-cat-holder-inner clearfix">

			<?php foreach ($query_result as $term){

				$link = get_term_link($term->term_id, 'product_cat');
				$img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
				$image_obj = '';
				$holder_class =  array();

				if($img_id && $img_id !== ''){

					$image_obj = wp_get_attachment_image_url($img_id, 'full');

				}

				$tax_img_size = get_term_meta($term->term_id, 'tax_img_size', true);
                if($tax_img_size && $tax_img_size !== '' && $tax_img_size !== null){
	                $holder_class[] = $this_object->generateImgSizeClass($tax_img_size);
                }

				$tax_img_position = get_term_meta($term->term_id, 'tax_img_position', true);
				if($tax_img_position && $tax_img_position !== '' && $tax_img_position !== null){
					$holder_class[] = $this_object->generateImgPositionClass($tax_img_position);
				}

				$tax_content_position = get_term_meta($term->term_id, 'tax_content_position', true);
				if($tax_content_position && $tax_content_position !== '' && $tax_content_position !== null){
					$holder_class[] = $this_object->generateContentPositionClass($tax_content_position);
				}
				$min_price = entre_mikado_woo_product_category_min_price($term->term_id);

				$info_styles = array();

				$info_skin = get_term_meta($term->term_id, 'category_info_skin', true);

				if ($info_skin == 'light') {
					$info_styles[] = 'color: #fff';
				}

				$term_params = array(
					'term' => $term,
					'link' => $link,
					'image_obj' => $image_obj,
					'tax_img_size' => $tax_img_size,
					'tax_img_position' => $tax_img_position,
					'tax_content_position' => $tax_content_position,
					'min_price' => $min_price,
					'item_classes'   => implode(' ', $holder_class),
					'button_params' => array(
						'type' => 'outline',
						'text' => esc_html__('see more', 'entre'),
						'link' => $link,
					),
					'separator_params' => array(
						'width' => '56px'
					),
					'info_styles' => $info_styles
				);

				echo entre_mikado_get_woo_shortcode_module_template_part('templates/item', 'floating-product-categories', '', $term_params);

			} ?>

		</div>
	</div>

<?php }