<?php
$item_classes           = $this_object->getItemClasses( $params );
$text_wrapper_styles    = $this_object->getTextWrapperStyles( $params );
$params['title_styles'] = $this_object->getTitleStyles( $params );
$woo_product_hover_background_color = get_post_meta( get_the_ID(), 'mkd_product_hover_background_color_woo_meta', true );
$bgcolor = '';
if ( ! empty( $woo_product_hover_background_color ) ) {
	$bgcolor = 'background-color: ' . $woo_product_hover_background_color;
}
?>
<div class="mkd-pli mkd-item-space <?php echo esc_html( $item_classes ); ?>">
	<div class="mkd-pli-inner">
		<div class="mkd-pli-image">
			<?php entre_mikado_get_module_template_part( 'templates/parts/image', 'woocommerce', '', $params ); ?>
		</div>
		<div class="mkd-pli-text" style="<?php echo esc_html($bgcolor); ?>">
			<div class="mkd-pli-text-outer">
				<div class="mkd-pli-text-inner">
					<?php entre_mikado_get_module_template_part( 'templates/parts/add-to-cart', 'woocommerce', '', $params ); ?>
				</div>
			</div>
		</div>
		<a class="mkd-pli-link" itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
	</div>
	<div class="mkd-pli-text-wrapper" <?php echo entre_mikado_get_inline_style( $text_wrapper_styles ); ?>>
		<?php entre_mikado_get_module_template_part( 'templates/parts/title', 'woocommerce', '', $params ); ?>
		
		<?php entre_mikado_get_module_template_part( 'templates/parts/category', 'woocommerce', '', $params ); ?>
		
		<?php entre_mikado_get_module_template_part( 'templates/parts/excerpt', 'woocommerce', '', $params ); ?>
		
		<?php entre_mikado_get_module_template_part( 'templates/parts/rating', 'woocommerce', '', $params ); ?>
		
		<?php entre_mikado_get_module_template_part( 'templates/parts/price', 'woocommerce', '', $params ); ?>
	</div>
</div>