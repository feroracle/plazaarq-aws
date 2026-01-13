<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="mkd-post-content">
	        <?php if ( has_post_thumbnail() ) { ?>
		        <div class="mkd-post-image">
			        <a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				        <?php the_post_thumbnail( 'thumbnail' ); ?>
			        </a>
		        </div>
	        <?php } ?>
	        <div class="mkd-post-title-area <?php if ( ! has_post_thumbnail() ) { echo esc_attr( 'mkd-no-thumbnail' ); } ?>">
		        <div class="mkd-post-title-area-inner">
			        <h5 itemprop="name" class="mkd-post-title entry-title">
				        <a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			        </h5>
			        <?php
			        $mkd_my_excerpt = get_the_excerpt();
			        
			        if ( ! empty( $mkd_my_excerpt ) ) { ?>
				        <p itemprop="description" class="mkd-post-excerpt"><?php echo wp_trim_words( esc_html( $mkd_my_excerpt ), 30 ); ?></p>
			        <?php } ?>
		        </div>
	        </div>
        </div>
    </article>
<?php endwhile; ?>
<?php else: ?>
	<p class="mkd-blog-no-posts"><?php esc_html_e( 'No posts were found.', 'entre' ); ?></p>
<?php endif; ?>