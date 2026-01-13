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
				<?php entre_mikado_custom_breadcrumbs(); ?>
			</div>
	    </div>
	</div>
</div>

<?php do_action('entre_mikado_after_page_title'); ?>
