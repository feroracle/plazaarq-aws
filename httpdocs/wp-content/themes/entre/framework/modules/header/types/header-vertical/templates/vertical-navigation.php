<?php do_action('entre_mikado_before_top_navigation'); ?>
<div class="mkd-vertical-menu-outer">
	<nav class="mkd-vertical-menu mkd-vertical-dropdown-on-click">
		<?php
			wp_nav_menu(array(
				'theme_location'  => 'vertical-navigation',
				'container'       => '',
				'container_class' => '',
				'menu_class'      => '',
				'menu_id'         => '',
				'fallback_cb'     => 'top_navigation_fallback',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'walker'          => new EntreMikadoTopNavigationWalker()
			));
		?>
	</nav>
</div>
<?php do_action('entre_mikado_after_top_navigation'); ?>