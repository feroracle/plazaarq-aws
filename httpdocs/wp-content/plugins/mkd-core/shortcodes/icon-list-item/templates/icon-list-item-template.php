<?php $icon_html = entre_mikado_icon_collections()->renderIcon($icon, $icon_pack, $params); ?>
<div class="mkd-icon-list-holder <?php echo esc_attr($holder_classes); ?>" <?php echo entre_mikado_get_inline_style($holder_styles); ?>>
	<div class="mkd-il-icon-holder">
		<?php echo wp_kses_post($icon_html); ?>
	</div>
	<p class="mkd-il-text" <?php echo entre_mikado_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></p>
</div>