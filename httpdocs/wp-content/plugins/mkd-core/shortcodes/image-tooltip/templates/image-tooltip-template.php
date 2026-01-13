<?php
/**
 * Image Tooltip shortcode template
 */
?>

<a class="mkd-image-tooltip" href="#" title="<img src= '<?php echo esc_attr($image); ?>' />" <?php echo entre_mikado_get_inline_attrs($image_tooltip_data); ?> <?php entre_mikado_inline_style($image_tooltip_style);?>>
	<?php echo esc_html($content);?>
    <span class="mkd-image-tooltip-border"></span>
</a>