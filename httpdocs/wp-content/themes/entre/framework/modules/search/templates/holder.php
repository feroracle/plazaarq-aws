<div class="mkd-grid-row">
	<div <?php echo entre_mikado_get_content_sidebar_class(); ?>>
		<div class="mkd-search-page-holder">
			<?php entre_mikado_get_search_page_layout(); ?>
		</div>
		<?php do_action( 'entre_mikado_page_after_content' ); ?>
	</div>
	<?php if ( $sidebar_layout !== 'no-sidebar' ) { ?>
		<div <?php echo entre_mikado_get_sidebar_holder_class(); ?>>
			<?php get_sidebar(); ?>
		</div>
	<?php } ?>
</div>