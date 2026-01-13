<?php do_action('entre_mikado_before_mobile_header'); ?>

<header class="mkd-mobile-header">
	<?php do_action('entre_mikado_after_mobile_header_html_open'); ?>
	
	<div class="mkd-mobile-header-inner">
		<div class="mkd-mobile-header-holder">
			<div class="mkd-grid">
				<div class="mkd-vertical-align-containers">
					<div class="mkd-position-left">
						<div class="mkd-position-left-inner">
							<?php entre_mikado_get_mobile_logo(); ?>
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
			</div>
		</div>
	</div>
	
	<?php do_action('entre_mikado_before_mobile_header_html_close'); ?>
</header>

<?php do_action('entre_mikado_after_mobile_header'); ?>