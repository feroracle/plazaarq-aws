<div class="mkd-counter-holder <?php echo esc_attr($holder_classes); ?>">
	<div class="mkd-counter-inner">
		<?php if(!empty($digit)) { ?>
			<span class="mkd-counter <?php echo esc_attr($type) ?>" <?php echo entre_mikado_get_inline_style($counter_styles); ?>><?php echo esc_html($digit); ?></span>
		<?php } ?>
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="mkd-counter-title" <?php echo entre_mikado_get_inline_style($counter_title_styles); ?>>
				<?php echo esc_html($title); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<?php if(!empty($text)) { ?>
			<p class="mkd-counter-text" <?php echo entre_mikado_get_inline_style($counter_text_styles); ?>><?php echo esc_html($text); ?></p>
		<?php } ?>
	</div>
</div>