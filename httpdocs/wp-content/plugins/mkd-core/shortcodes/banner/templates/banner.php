<div class="mkd-banner-holder <?php echo esc_attr($holder_classes); ?>">
    <div class="mkd-banner-image">
        <?php echo wp_get_attachment_image($image, 'full'); ?>
    </div>
    <div class="mkd-banner-text-holder" <?php echo entre_mikado_get_inline_style($overlay_styles); ?>>
	    <div class="mkd-banner-text-outer">
		    <div class="mkd-banner-text-inner">
		        <?php if(!empty($subtitle)) { ?>
		            <<?php echo esc_attr($subtitle_tag); ?> class="mkd-banner-subtitle" <?php echo entre_mikado_get_inline_style($subtitle_styles); ?>>
			            <?php echo esc_html($subtitle); ?>
		            </<?php echo esc_attr($subtitle_tag); ?>>
		        <?php } ?>
		        <?php if(!empty($title)) { ?>
		            <<?php echo esc_attr($title_tag); ?> class="mkd-banner-title" <?php echo entre_mikado_get_inline_style($title_styles); ?>>
		                <?php echo wp_kses($title, array('span' => array('class' => true))); ?>
	                </<?php echo esc_attr($title_tag); ?>>
		        <?php } ?>
				<?php if(!empty($link) && !empty($link_text)) { ?>
		            <a itemprop="url" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" class="mkd-banner-link-text" <?php echo entre_mikado_get_inline_style($link_styles); ?>>
			            <span class="mkd-banner-link-original">
				            <span class="mkd-banner-link-icon ion-arrow-right-c"></span>
			                <span class="mkd-banner-link-label"><?php echo esc_html($link_text); ?></span>
			            </span>
			            <span class="mkd-banner-link-hover">
				            <span class="mkd-banner-link-icon ion-arrow-right-c"></span>
			                <span class="mkd-banner-link-label"><?php echo esc_html($link_text); ?></span>
			            </span>
		            </a>
		        <?php } ?>
			</div>
		</div>
	</div>
	<?php if (!empty($link)) { ?>
        <a itemprop="url" class="mkd-banner-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"></a>
    <?php } ?>
</div>