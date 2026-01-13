<div class="mkd-section-title-holder <?php echo esc_attr($holder_classes); ?>" <?php echo entre_mikado_get_inline_style($holder_styles); ?>>
	<div class="mkd-st-inner">
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="mkd-st-title" <?php echo entre_mikado_get_inline_style($title_styles); ?>>
				<?php echo wp_kses($title, array('br' => true, 'span' => array('class' => true))); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<?php if(!empty($subtitle)) { ?>
			<?php echo entre_mikado_get_separator_html(array('width'=>'56px', 'color'=> $separator_color)); ?>
			<<?php echo esc_attr($subtitle_tag); ?> class="mkd-st-subtitle" <?php echo entre_mikado_get_inline_style($subtitle_styles); ?>>
				<?php echo wp_kses($subtitle, array('br' => true)); ?>
			</<?php echo esc_attr($subtitle_tag); ?>>
		<?php } ?>
		<?php if(!empty($text)) { ?>
			<<?php echo esc_attr($text_tag); ?> class="mkd-st-text" <?php echo entre_mikado_get_inline_style($text_styles); ?>>
				<?php echo wp_kses($text, array('br' => true)); ?>
			</<?php echo esc_attr($text_tag); ?>>
		<?php } ?>
	</div>
</div>