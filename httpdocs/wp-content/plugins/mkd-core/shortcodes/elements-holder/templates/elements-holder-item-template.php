<div class="mkd-eh-item <?php echo esc_attr($holder_classes); ?>" <?php echo entre_mikado_get_inline_style($holder_styles); ?> <?php echo entre_mikado_get_inline_attrs($holder_data); ?>>
	<div class="mkd-eh-item-inner">
		<div class="mkd-eh-item-content <?php echo esc_attr($holder_rand_class); ?>" <?php echo entre_mikado_get_inline_style($content_styles); ?>>
			<?php echo do_shortcode($content); ?>
		</div>
	</div>
</div>