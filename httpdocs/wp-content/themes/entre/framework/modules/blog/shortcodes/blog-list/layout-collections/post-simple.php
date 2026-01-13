<li class="mkd-bl-item mkd-item-space clearfix">
	<div class="mkd-bli-inner">
		<?php if ( $post_info_image == 'yes' ) {
			entre_mikado_get_module_template_part( 'templates/parts/media', 'blog', '', $params );
		} ?>
		<div class="mkd-bli-content">
			<?php entre_mikado_get_module_template_part( 'templates/parts/title', 'blog', '', $params ); ?>
			<?php entre_mikado_get_module_template_part( 'templates/parts/post-info/date', 'blog', '', $params ); ?>
		</div>
	</div>
</li>