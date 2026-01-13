<?php if($max_num_pages > 1) { ?>
	<div class="mkd-blog-pag-loading">
		<div class="mkd-blog-pag-bounce1"></div>
		<div class="mkd-blog-pag-bounce2"></div>
		<div class="mkd-blog-pag-bounce3"></div>
	</div>
	<div class="mkd-blog-pag-load-more">
		<?php
			$button_params = array(
				'link' => 'javascript: void(0)',
				'text' => esc_html__( 'Load More', 'entre' )
			);
			
			echo entre_mikado_return_button_html( $button_params );
		?>
	</div>
<?php }