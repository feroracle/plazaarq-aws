<li class="mkd-uss-item <?php echo esc_attr($holder_classes); ?>" <?php echo entre_mikado_get_inline_attrs($holder_data); ?>>
    <div class="mkd-uss-image-holder" <?php echo entre_mikado_get_inline_attrs($image_data); ?> <?php entre_mikado_inline_style($holder_styles); ?>></div>
    <div class="mkd-uss-item-outer">
        <div class="mkd-uss-item-inner" <?php entre_mikado_inline_style($item_inner_styles); ?>>
            <?php echo do_shortcode($content); ?>
        </div>
	</div>
	<?php if(!empty($link)) { ?>
		<a itemprop="url" class="mkd-uss-item-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($link_target); ?>"></a>
	<?php } ?>
</li>