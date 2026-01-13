<?php
/*
Template Name: WooCommerce
*/
?>
<?php
$mkd_sidebar_layout = entre_mikado_sidebar_layout();

get_header();
entre_mikado_get_title();
get_template_part( 'slider' );
do_action('entre_mikado_before_main_content');

//Woocommerce content
if ( ! is_singular( 'product' ) ) { ?>
	<div class="mkd-container">
		<div class="mkd-container-inner clearfix">
			<div class="mkd-grid-row">
				<div <?php echo entre_mikado_get_content_sidebar_class(); ?>>
					<?php entre_mikado_woocommerce_content(); ?>
				</div>
				<?php if ( $mkd_sidebar_layout !== 'no-sidebar' ) { ?>
					<div <?php echo entre_mikado_get_sidebar_holder_class(); ?>>
						<?php get_sidebar(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="mkd-container">
		<div class="mkd-container-inner clearfix">
			<?php entre_mikado_woocommerce_content(); ?>
		</div>
	</div>
	<div class="mkd-full-width mkd-related-products">
		<div class="mkd-full-width-inner-wrapper">
			<?php do_action( 'entre_mikado_after_single_product_summary' ); ?>
		</div>
	</div>

<?php  } ?>
<?php get_footer(); ?>