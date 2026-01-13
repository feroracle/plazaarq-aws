<div class="mkd-parallax-ds-image-section <?php echo esc_attr($holder_classes); ?>">
	<div class="mkd-parallax-dsis-image">
        <?php echo wp_get_attachment_image($image['image_id'], 'full'); ?>
        <span class="mkd-parallax-dsis-shadow-holder <?php echo esc_attr($shadow_classes); ?>"  <?php echo entre_mikado_get_inline_attrs($this_object->getParallaxData($params)); ?>></span>
	</div>

    <?php if (!empty($text)) { ?>
        <div class="mkd-parallax-dsis-text">
            <h6><?php echo esc_html($text); ?></h6>
        </div>
    <?php } ?>
</div>