<?php
/*
Template Name: Full Width
*/
?>
<?php
$mkd_sidebar_layout = entre_mikado_sidebar_layout();

get_header();
entre_mikado_get_title();
get_template_part( 'slider' );
do_action('entre_mikado_before_main_content');
?>

<div class="mkd-full-width">
    <?php do_action( 'entre_mikado_after_container_open' ); ?>
	<div class="mkd-full-width-inner">
        <?php do_action( 'entre_mikado_after_container_inner_open' ); ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="mkd-grid-row">
				<div <?php echo entre_mikado_get_content_sidebar_class(); ?>>
					<?php
						the_content();
						do_action( 'entre_mikado_page_after_content' );
					?>
				</div>
				<?php if ( $mkd_sidebar_layout !== 'no-sidebar' ) { ?>
					<div <?php echo entre_mikado_get_sidebar_holder_class(); ?>>
						<?php get_sidebar(); ?>
					</div>
				<?php } ?>
			</div>
		<?php endwhile; endif; ?>
        <?php do_action( 'entre_mikado_before_container_inner_close' ); ?>
	</div>

    <?php do_action( 'entre_mikado_before_container_close' ); ?>
</div>

<?php get_footer(); ?>