<<?php echo esc_attr( $title_tag ); ?> class="mkd-custom-font-holder <?php echo esc_attr( $holder_classes ); ?>" <?php entre_mikado_inline_style( $holder_styles ); ?> <?php echo entre_mikado_get_inline_attrs( $holder_data ); ?>>
	<?php echo wp_kses_post( $title ); ?>
</<?php echo esc_attr( $title_tag ); ?>>