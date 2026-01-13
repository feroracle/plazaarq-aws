<div class="mkd-fsis-item">
	<div class="mkd-fsis-image" <?php entre_mikado_inline_style( $image_styles ); ?>>
		<div class="mkd-fsis-image-wrapper">
			<div class="mkd-fsis-image-inner">
				<?php if ( ! empty( $image_top ) ) { ?>
					<div class="mkd-fsis-content-image mkd-fsis-image-top">
						<?php echo wp_get_attachment_image( $image_top, 'full' ); ?>
					</div>
				<?php } ?>
				<?php if ( ! empty( $image_left ) ) { ?>
					<div class="mkd-fsis-content-image mkd-fsis-image-left">
						<?php echo wp_get_attachment_image( $image_left, 'full' ); ?>
					</div>
				<?php } ?>
				<?php if ( ! empty( $image_right ) ) { ?>
					<div class="mkd-fsis-content-image mkd-fsis-image-right">
						<?php echo wp_get_attachment_image( $image_right, 'full' ); ?>
					</div>
				<?php } ?>
				<?php if ( ! empty( $title ) ) { ?>
					<<?php echo esc_attr( $title_tag ); ?> class="mkd-fsis-title" <?php echo entre_mikado_get_inline_style( $title_styles ); ?>><?php echo wp_kses( $title, array( 'br' => true ) ); ?></<?php echo esc_attr( $title_tag ); ?>>
				<?php } ?>
				<?php if ( ! empty( $subtitle ) ) { ?>
					<<?php echo esc_attr( $subtitle_tag ); ?> class="mkd-fsis-subtitle" <?php echo entre_mikado_get_inline_style( $subtitle_styles ); ?>><?php echo wp_kses( $subtitle, array( 'br' => true ) ); ?></<?php echo esc_attr( $subtitle_tag ); ?>>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="mkd-fsis-frame mkd-fsis-frame-top"></div>
	<div class="mkd-fsis-frame mkd-fsis-frame-right"></div>
	<div class="mkd-fsis-frame mkd-fsis-frame-bottom"></div>
	<div class="mkd-fsis-frame mkd-fsis-frame-left"></div>
</div>