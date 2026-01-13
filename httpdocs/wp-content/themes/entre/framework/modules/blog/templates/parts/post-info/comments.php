<?php if(comments_open()) { ?>
	<div class="mkd-post-info-comments-holder">
		<a itemprop="url" class="mkd-post-info-comments" href="<?php comments_link(); ?>" target="_self">
			<?php comments_number('0 ' . esc_html__('Comments','entre'), '1 '.esc_html__('Comment','entre'), '% '.esc_html__('Comments','entre') ); ?>
		</a>
	</div>
<?php } ?>