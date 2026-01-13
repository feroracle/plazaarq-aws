<?php
if($show_header_top) {
	do_action('entre_mikado_before_header_top');
	?>
	
	<?php if($show_header_top_background_div){ ?>
		<div class="mkd-top-bar-background"></div>
	<?php } ?>
	
	<div class="mkd-top-bar">
		<?php do_action( 'entre_mikado_after_header_top_html_open' ); ?>
		
		<?php if($top_bar_in_grid) : ?>
			<div class="mkd-grid">
		<?php endif; ?>
				
			<div class="mkd-vertical-align-containers">
				<div class="mkd-position-left">
					<div class="mkd-position-left-inner">
						<?php if(is_active_sidebar('mkd-top-bar-left')) : ?>
							<?php dynamic_sidebar('mkd-top-bar-left'); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="mkd-position-right">
					<div class="mkd-position-right-inner">
						<?php if(is_active_sidebar('mkd-top-bar-right')) : ?>
							<?php dynamic_sidebar('mkd-top-bar-right'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
				
		<?php if($top_bar_in_grid) : ?>
			</div>
		<?php endif; ?>
		
		<?php do_action( 'entre_mikado_before_header_top_html_close' ); ?>
	</div>
	
	<?php do_action('entre_mikado_after_header_top');
}