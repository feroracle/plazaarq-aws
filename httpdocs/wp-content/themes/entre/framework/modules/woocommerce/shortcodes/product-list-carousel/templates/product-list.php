<?php
	$params['title_styles'] = $this_object->getTitleStyles( $params );
?>
<div class="mkd-plc-holder <?php echo esc_attr( $holder_classes ) ?>">
	<div class="mkd-plc-outer mkd-owl-slider" <?php echo entre_mikado_get_inline_attrs( $holder_data ); ?>>
		<?php if ( $query_result->have_posts() ): while ( $query_result->have_posts() ) : $query_result->the_post(); 
			$woo_product_hover_background_color = get_post_meta( get_the_ID(), 'mkd_product_hover_background_color_woo_meta', true );
			$bgcolor = '';
			if ( ! empty( $woo_product_hover_background_color ) ) {
				$bgcolor ='background-color:'.$woo_product_hover_background_color;
			}
		?>
			<div class="mkd-plc">
				<div class="mkd-plc-inner">
					<div class="mkd-plc-image">
						<?php entre_mikado_get_module_template_part( 'templates/parts/image', 'woocommerce', '', $params ); ?>
					</div>
					<div class="mkd-plc-text" style="<?php echo esc_html($bgcolor); ?>">
						<div class="mkd-plc-text-outer">
							<div class="mkd-plc-text-inner">
								<?php entre_mikado_get_module_template_part( 'templates/parts/add-to-cart', 'woocommerce', '', $params ); ?>
							</div>
						</div>
					</div>
					<a class="mkd-plc-link" itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
				</div>
				<div class="mkd-plc-text-wrapper">
					<?php entre_mikado_get_module_template_part( 'templates/parts/title', 'woocommerce', '', $params ); ?>
					
					<?php entre_mikado_get_module_template_part( 'templates/parts/category', 'woocommerce', '', $params ); ?>
					
					<?php entre_mikado_get_module_template_part( 'templates/parts/excerpt', 'woocommerce', '', $params ); ?>
					
					<?php entre_mikado_get_module_template_part( 'templates/parts/rating', 'woocommerce', '', $params ); ?>
					
					<?php entre_mikado_get_module_template_part( 'templates/parts/price', 'woocommerce', '', $params ); ?>
				</div>
			</div>
		<?php endwhile;
		else:
			entre_mikado_get_module_template_part( 'templates/parts/no-posts', 'woocommerce', '', $params );
		endif;
		wp_reset_postdata();
		?>
	</div>
</div>