<div class="mkd-testimonial-content" id="mkd-testimonials-<?php echo esc_attr( $current_id ) ?>">
	<div class="mkd-testimonial-text-holder">
		<?php if ( ! empty( $title ) ) { ?>
			<h3 itemprop="name" class="mkd-testimonial-title entry-title"><?php echo esc_html( $title ); ?></h3>
		<?php } ?>
			<?php if ( ! empty( $text ) ) { ?>
				<p class="mkd-testimonial-text"><?php echo esc_html( $text ); ?></p>
			<?php } ?>
				<?php if ( ! empty( $author ) ) { ?>
			<span class="mkd-testimonial-author">
				<span class="mkd-testimonials-author-name"><?php echo esc_html( $author ); ?></span>
				<?php if ( ! empty( $position ) ) { ?>
					<span class="mkd-testimonials-author-job"><?php echo esc_html( $position ); ?></span>
				<?php } ?>
			</span>
		    <?php } ?>
	</div>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="mkd-testimonial-image">
			<?php echo get_the_post_thumbnail( get_the_ID(), array( 66, 66 ) ); ?>
		</div>
	<?php } ?>
</div>