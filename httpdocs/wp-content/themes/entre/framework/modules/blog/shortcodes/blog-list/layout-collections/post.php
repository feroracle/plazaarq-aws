<li class="mkd-bl-item mkd-item-space clearfix">
	<div class="mkd-bli-inner">
		<?php if ( $post_info_image == 'yes' ) {
			entre_mikado_get_module_template_part( 'templates/parts/media', 'blog', '', $params );
		} ?>
        <div class="mkd-bli-content">
            <?php if ($post_info_section == 'yes') { ?>
                <div class="mkd-bli-info">
	                <?php
		                if ( $post_info_date == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/date', 'blog', '', $params );
		                }
		                if ( $post_info_category == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/category', 'blog', '', $params );
		                }
		                if ( $post_info_author == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/author', 'blog', '', $params );
		                }
		                if ( $post_info_comments == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/comments', 'blog', '', $params );
		                }
		                if ( $post_info_like == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/like', 'blog', '', $params );
		                }
		                if ( $post_info_share == 'yes' ) {
			                entre_mikado_get_module_template_part( 'templates/parts/post-info/share', 'blog', '', $params );
		                }
	                ?>
                </div>
            <?php } ?>
	
	        <?php entre_mikado_get_module_template_part( 'templates/parts/title', 'blog', '', $params ); ?>
	
	        <div class="mkd-bli-excerpt">
	        	<?php if($post_info_excerpt === 'yes') { ?>
		           <?php entre_mikado_get_module_template_part( 'templates/parts/excerpt', 'blog', '', $params ); ?>
		        <?php } ?>
		        <?php entre_mikado_get_module_template_part( 'templates/parts/post-info/read-more', 'blog', '', $params ); ?>
	        </div>
        </div>
	</div>
</li>