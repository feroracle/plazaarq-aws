<?php do_action('entre_mikado_before_page_header'); ?>

	<header class="mkd-page-header">
		<?php if($show_fixed_wrapper) : ?>
		<div class="mkd-fixed-wrapper">
			<?php endif; ?>
			<div class="mkd-menu-area">
				<?php do_action( 'entre_mikado_action_after_header_menu_area_html_open' )?>
				<?php if($menu_area_in_grid) : ?>
				<div class="mkd-grid">
					<?php endif; ?>
					<div class="mkd-vertical-align-containers">
						<div class="mkd-position-left">
							<div class="mkd-position-left-inner">
								<div class="mkd-expanding-menu-opener-holder">
									<a href="javascript:void(0)" class="mkd-expanding-menu-opener">
										<span class="mkd-fm-lines">
											<span class="mkd-fm-line mkd-line-1"></span>
											<span class="mkd-fm-line mkd-line-2"></span>
											<span class="mkd-fm-line mkd-line-3"></span>
										</span>
									</a>
								</div>
								<?php if(!$hide_logo) {
									entre_mikado_get_logo();
								} ?>
							</div>
						</div>
						<div class="mkd-position-right">
							<div class="mkd-position-right-inner">
								<?php entre_mikado_get_main_menu(); ?>
                                <?php entre_mikado_get_header_widget_menu_area(); ?>
							</div>
						</div>
					</div>
					<?php if($menu_area_in_grid) : ?>
				</div>
			<?php endif; ?>
			</div>
			<?php if($show_fixed_wrapper) { ?>
			<?php do_action('entre_mikado_action_end_of_page_header_html'); ?>
		</div>
	<?php } else {
		do_action('entre_mikado_action_end_of_page_header_html');
	} ?>
		<?php if($show_sticky) {
			entre_mikado_get_sticky_header('expanding', 'header/types/header-expanding');
		} ?>
	</header>

<?php do_action('entre_mikado_after_page_header'); ?>