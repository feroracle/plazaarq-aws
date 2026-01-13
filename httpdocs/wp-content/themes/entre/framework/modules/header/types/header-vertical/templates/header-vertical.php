<?php do_action('entre_mikado_before_page_header'); ?>

<aside class="mkd-vertical-menu-area <?php echo esc_html($holder_class); ?>">
	<div class="mkd-vertical-menu-area-inner">
		<div class="mkd-vertical-area-background"></div>
		<?php if(!$hide_logo) {
			entre_mikado_get_logo();
		} ?>
		<?php entre_mikado_get_header_vertical_main_menu(); ?>
		<div class="mkd-vertical-area-widget-holder">
			<?php entre_mikado_get_header_vertical_widget_areas(); ?>
		</div>
	</div>
</aside>

<?php do_action('entre_mikado_after_page_header'); ?>