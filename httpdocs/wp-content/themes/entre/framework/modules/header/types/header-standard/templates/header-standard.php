<?php do_action('entre_mikado_before_page_header'); ?>

<header class="mkd-page-header">
	<?php do_action('entre_mikado_after_page_header_html_open'); ?>
	
	<?php if($show_fixed_wrapper) : ?>
		<div class="mkd-fixed-wrapper">
	<?php endif; ?>
			
	<div class="mkd-menu-area <?php echo esc_attr($menu_area_position_class); ?>">
		<?php do_action('entre_mikado_after_header_menu_area_html_open') ?>
		
		<?php if($menu_area_in_grid) : ?>
			<div class="mkd-grid">
		<?php endif; ?>
				
			<div class="mkd-vertical-align-containers">
				<div class="mkd-position-left">
					<div class="mkd-position-left-inner">
						<?php if(!$hide_logo) {
							entre_mikado_get_logo();
						} ?>
						<?php if($menu_area_position === 'left') : ?>
							<?php entre_mikado_get_main_menu(); ?>
						<?php endif; ?>
					</div>
				</div>
				<?php if($menu_area_position === 'center') : ?>
					<div class="mkd-position-center">
						<div class="mkd-position-center-inner">
							<?php entre_mikado_get_main_menu(); ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="mkd-position-right">
					<div class="mkd-position-right-inner">
						<?php if($menu_area_position === 'right') : ?>
							<?php entre_mikado_get_main_menu(); ?>
						<?php endif; ?>
						<?php entre_mikado_get_header_widget_menu_area(); ?>
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
		entre_mikado_get_sticky_header();
	} ?>
	
	<?php do_action('entre_mikado_before_page_header_html_close'); ?>
</header>

<?php do_action('entre_mikado_after_page_header'); ?>