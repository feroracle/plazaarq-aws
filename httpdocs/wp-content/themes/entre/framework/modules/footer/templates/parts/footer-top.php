<div class="mkd-footer-top-holder">
	<div class="mkd-footer-top-inner <?php echo esc_attr($footer_top_grid_class); ?> <?php echo esc_attr($footer_has_logo_class); ?>">
		<div class="mkd-footer-logo-area">
			<?php if ( $show_footer_logo ) { ?>
				<div class="mkd-footer-logo-wrapper">
					<?php echo entre_mikado_get_footer_logo(); ?>
				</div>
			<?php } ?>
			<div class="mkd-footer-line"></div>
		</div>
		<div class="mkd-grid-row <?php echo esc_attr($footer_top_classes); ?>">
			<?php for($i = 1; $i <= $footer_top_columns; $i++) { ?>
				<div class="mkd-column-content mkd-grid-col-<?php echo esc_attr(12 / $footer_top_columns); ?>">
					<div class="mkd-footer-column-inner">
						<?php
							if(is_active_sidebar('footer_top_column_'.$i)) {
								dynamic_sidebar('footer_top_column_'.$i);
							}
						?>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="mkd-footer-line"></div>
	</div>
</div>