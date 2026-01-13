<div class="mkd-progress-bar <?php echo esc_attr($holder_classes); ?>">
	<<?php echo esc_attr($title_tag); ?> class="mkd-pb-title-holder" <?php echo entre_mikado_inline_style($title_styles); ?>>
		<span class="mkd-pb-title"><?php echo esc_html($title); ?></span>
		<span class="mkd-pb-percent">0</span>
	</<?php echo esc_attr($title_tag); ?>>
	<div class="mkd-pb-content-holder" <?php echo entre_mikado_inline_style($inactive_bar_style); ?>>
		<div data-percentage=<?php echo esc_attr($percent); ?> class="mkd-pb-content" <?php echo entre_mikado_inline_style($active_bar_style); ?>></div>
	</div>
</div>