<div class="mkd-price-table mkd-item-space <?php echo esc_attr($holder_classes); ?>">
	<div class="mkd-pt-inner" <?php echo entre_mikado_get_inline_style($holder_styles); ?>>
		<ul>
			<li class="mkd-pt-title-holder">
				<span class="mkd-pt-title" <?php echo entre_mikado_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></span>
			</li>
			<li class="mkd-pt-prices">
				<sup class="mkd-pt-value" <?php echo entre_mikado_get_inline_style($currency_styles); ?>><?php echo esc_html($currency); ?></sup>
				<span class="mkd-pt-price" <?php echo entre_mikado_get_inline_style($price_styles); ?>><?php echo esc_html($price); ?></span>
				<h6 class="mkd-pt-mark" <?php echo entre_mikado_get_inline_style($price_period_styles); ?>><?php echo esc_html($price_period); ?></h6>
			</li>
			<li class="mkd-pt-content">
				<?php echo do_shortcode($content); ?>
			</li>
			<?php 
			if(!empty($button_text)) { ?>
				<li class="mkd-pt-button">
					<?php echo entre_mikado_get_button_html(array(
						'link' => $link,
						'text' => $button_text,
						'type' => $button_type,
                        'size' => 'medium'
					)); ?>
				</li>				
			<?php } ?>
		</ul>
	</div>
</div>