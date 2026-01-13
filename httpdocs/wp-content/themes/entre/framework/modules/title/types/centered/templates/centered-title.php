<?php do_action('entre_mikado_before_page_title'); ?>

<div class="mkd-title-holder <?php echo esc_attr($holder_classes); ?>" <?php entre_mikado_inline_style($holder_styles); ?> <?php echo entre_mikado_get_inline_attrs($holder_data); ?>>
	<?php if(!empty($title_image)) { ?>
		<div class="mkd-title-image">
			<img itemprop="image" src="<?php echo esc_url($title_image['src']); ?>" alt="<?php echo esc_attr($title_image['alt']); ?>" />
		</div>
	<?php } ?>
	<div class="mkd-title-wrapper" <?php entre_mikado_inline_style($wrapper_styles); ?>>
		<div class="mkd-title-inner">
			<div class="mkd-grid">
				<?php if(!empty($title)) { ?>
					<<?php echo entre_mikado_escape_title_tag($title_tag); ?> class="mkd-page-title entry-title" <?php entre_mikado_inline_style($title_styles); ?>><?php echo esc_html($title); ?></<?php echo entre_mikado_escape_title_tag($title_tag); ?>>
				<?php } ?>
				<?php if(!empty($subtitle)){ ?>
					<<?php echo entre_mikado_escape_title_tag($subtitle_tag); ?> class="mkd-page-subtitle" <?php entre_mikado_inline_style($subtitle_styles); ?>><?php echo esc_html($subtitle); ?></<?php echo entre_mikado_escape_title_tag($subtitle_tag); ?>>
				<?php } ?>
			</div>
	    </div>
	</div>
</div>

<?php do_action('entre_mikado_after_page_title'); ?>
