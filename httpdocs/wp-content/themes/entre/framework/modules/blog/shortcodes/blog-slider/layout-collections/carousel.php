<li class="mkd-blog-slider-item">
	<div class="mkd-blog-slider-item-inner">
		<div class="mkd-item-image">
			<a itemprop="url" href="<?php echo get_permalink(); ?>">
				<?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?>
			</a>
		</div>
		<div class="mkd-bli-content">
			<?php entre_mikado_get_module_template_part('templates/parts/title', 'blog', '', $params); ?>
			
			<div class="mkd-bli-excerpt">
				<?php entre_mikado_get_module_template_part( 'templates/parts/excerpt', 'blog', '', $params ); ?>
				<?php entre_mikado_get_module_template_part( 'templates/parts/post-info/read-more', 'blog', '', $params ); ?>
			</div>
		</div>
	</div>
</li>