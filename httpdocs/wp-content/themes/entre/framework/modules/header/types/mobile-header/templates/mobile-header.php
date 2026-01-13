<?php do_action('entre_mikado_before_mobile_header'); ?>

<header class="mkd-mobile-header">
	<?php do_action('entre_mikado_after_mobile_header_html_open'); ?>
	
	<div class="mkd-mobile-header-inner">
		<div class="mkd-mobile-header-holder">
			<div class="mkd-grid">
				<div class="mkd-vertical-align-containers">
					<div class="mkd-vertical-align-containers">
						<?php if($show_navigation_opener) : ?>
							<div class="mkd-mobile-menu-opener">
								<a href="javascript:void(0)">
									<span class="mkd-mobile-menu-icon">
										<?php echo entre_mikado_icon_collections()->renderIcon('icon_menu', 'font_elegant'); ?>
									</span>
									<?php if(!empty($mobile_menu_title)) { ?>
										<h5 class="mkd-mobile-menu-text"><?php echo esc_attr($mobile_menu_title); ?></h5>
									<?php } ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="mkd-position-center">
							<div class="mkd-position-center-inner">
								<?php entre_mikado_get_mobile_logo(); ?>
							</div>
						</div>
						<div class="mkd-position-right">
							<div class="mkd-position-right-inner">
								<?php if(is_active_sidebar('mkd-right-from-mobile-logo')) {
									dynamic_sidebar('mkd-right-from-mobile-logo');
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php entre_mikado_get_mobile_nav(); ?>
	</div>
	
	<?php do_action('entre_mikado_before_mobile_header_html_close'); ?>
</header>

<?php do_action('entre_mikado_after_mobile_header'); ?>