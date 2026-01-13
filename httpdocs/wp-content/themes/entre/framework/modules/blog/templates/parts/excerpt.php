<?php
if(post_password_required()) {
	echo get_the_password_form();
} else {
	$excerpt_length = isset($params['excerpt_length']) ? $params['excerpt_length'] : '';
	$excerpt = entre_mikado_excerpt($excerpt_length);
	
	$link_page_exists = apply_filters( 'entre_mikado_filter_single_links_exists', '' );
	
	if ( ! empty( $excerpt ) && empty( $link_page_exists ) ) { ?>
		<div class="mkd-post-excerpt-holder">
			<p itemprop="description" class="mkd-post-excerpt">
				<?php echo wp_kses_post($excerpt); ?>
			</p>
		</div>
	<?php }
} ?>