<?php if ( ! entre_mikado_post_has_read_more() && ! post_password_required() ) { ?>
	<div class="mkd-post-read-more-button">
		<?php
			$button_params = array(
				'type'         => 'minimal',
				'link'         => get_the_permalink(),
				'text'         => esc_html__( 'read more', 'entre' ),
				'custom_class' => 'mkd-blog-list-button'
			);
			
			echo entre_mikado_return_button_html( $button_params );
		?>
	</div>
<?php } ?>