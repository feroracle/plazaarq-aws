<?php
get_header();
entre_mikado_get_title();
do_action('entre_mikado_before_main_content'); ?>
<div class="mkd-container mkd-default-page-template">
	<?php do_action('entre_mikado_after_container_open'); ?>
	<div class="mkd-container-inner clearfix">
		<?php
			$mkd_taxonomy_id = get_queried_object_id();
			$mkd_taxonomy_type	= is_tax( 'portfolio-tag' ) ? 'portfolio-tag' : 'portfolio-category';
			$mkd_taxonomy	= ! empty( $mkd_taxonomy_id ) ? get_term_by( 'id', $mkd_taxonomy_id, $mkd_taxonomy_type) : '';
			$mkd_taxonomy_slug = !empty($mkd_taxonomy) ? $mkd_taxonomy->slug : '';
			$mkd_taxonomy_name = !empty($mkd_taxonomy) ? $mkd_taxonomy->taxonomy : '';
		
			mkd_core_get_archive_portfolio_list($mkd_taxonomy_slug, $mkd_taxonomy_name);
		?>
	</div>
	<?php do_action('entre_mikado_before_container_close'); ?>
</div>
<?php get_footer(); ?>
