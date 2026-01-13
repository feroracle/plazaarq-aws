<?php do_action('entre_mikado_before_page_header'); ?>

<header class="mkd-page-header">
	<?php do_action('entre_mikado_after_page_header_html_open'); ?>
	
	<?php if($show_fixed_wrapper) : ?>
		<div class="mkd-fixed-wrapper">
	<?php endif; ?>
			
	<div class="mkd-menu-area">
		<?php do_action('entre_mikado_after_header_menu_area_html_open'); ?>
		
		<?php if($menu_area_in_grid) : ?>
			<div class="mkd-grid">
		<?php endif; ?>
				
			<div class="mkd-vertical-align-containers">
				<div class="mkd-position-left">
					<div class="mkd-position-left-inner">
						<?php if(!$hide_logo) {
							entre_mikado_get_logo();
						} ?>
					</div>
				</div>
				<div class="mkd-position-right">
					<div class="mkd-position-right-inner">
						<a href="javascript:void(0)" class="mkd-fullscreen-menu-opener">
							<span class="mkd-fm-lines">
								<span class="mkd-fm-line mkd-line-1"></span>
								<span class="mkd-fm-line mkd-line-2"></span>
								<span class="mkd-fm-line mkd-line-3"></span>
							</span>
						</a>
					</div>
				</div>
			</div>
				
		<?php if($menu_area_in_grid) : ?>
			</div>
		<?php endif; ?>
	</div>
			
	<?php if($show_fixed_wrapper) { ?>
		</div>
	<?php } ?>
	
	<?php if($show_sticky) {
		entre_mikado_get_sticky_header('minimal', 'header/types/header-minimal');
	} ?>
	
	<?php do_action('entre_mikado_before_page_header_html_close'); ?>
</header>