<div class="mkd-pl-holder <?php echo esc_attr( $holder_classes ) ?>">
	<div class="mkd-pl-outer mkd-outer-space">
		<div class="mkd-pl-sizer"></div>
		<div class="mkd-pl-gutter"></div>
		<?php if ( $query_result->have_posts() ): while ( $query_result->have_posts() ) : $query_result->the_post();
			echo entre_mikado_get_woo_shortcode_module_template_part( 'templates/parts/' . $info_position, 'product-list', '', $params );
		endwhile;
		else:
			entre_mikado_get_module_template_part( 'templates/parts/no-posts', 'woocommerce', '', $params );
		endif;
		wp_reset_postdata();
		?>
	</div>
</div>