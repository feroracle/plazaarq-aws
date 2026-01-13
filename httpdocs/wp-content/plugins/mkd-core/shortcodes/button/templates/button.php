<button type="submit" <?php entre_mikado_inline_style($button_styles); ?> <?php entre_mikado_class_attribute($button_classes); ?> <?php echo entre_mikado_get_inline_attrs($button_data); ?> <?php echo entre_mikado_get_inline_attrs($button_custom_attrs); ?>>
    <span class="mkd-btn-text"><?php echo esc_html($text); ?></span>
    <?php echo entre_mikado_icon_collections()->renderIcon($icon, $icon_pack); ?>
    <?php if ($type == 'minimal') { ?>
    	<span class="mkd-btn-icon arrow_right"></span>
    <?php } ?>
</button>