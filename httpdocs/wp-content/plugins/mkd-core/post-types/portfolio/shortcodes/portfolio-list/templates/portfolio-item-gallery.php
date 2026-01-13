<?php
$media = mkd_core_get_portfolio_single_media();

?>
<article class="mkd-pl-item mkd-item-space <?php echo esc_attr( $this_object->getArticleClasses( $params ) ); ?>">
	<div class="mkd-pl-item-inner">
		<?php echo mkd_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'layout-collections/' . $item_style, '', $params ); ?>
		
		<?php if ( is_array( $media ) && count( $media ) > 0 ) : ?>
			<?php echo mkd_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'parts/image-gallery', '', $params ); ?>
		<?php endif; ?>
	</div>
</article>