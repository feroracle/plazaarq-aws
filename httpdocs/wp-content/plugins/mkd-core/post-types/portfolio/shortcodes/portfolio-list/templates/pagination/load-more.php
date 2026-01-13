<?php if($query_results->max_num_pages > 1) {
	$holder_styles = $this_object->getLoadMoreStyles($params);
	?>
	<div class="mkd-pl-loading">Loading...</div>
	<div class="mkd-pl-load-more-holder">
		<div class="mkd-pl-load-more" <?php entre_mikado_inline_style($holder_styles); ?>>
			<?php 
				echo entre_mikado_get_button_html(array(
					'link' => 'javascript: void(0)',
					'size' => 'medium',
					'type' => 'outline',
					'text' => esc_html__('load more', 'mkd-core')
				));
			?>
		</div>
	</div>
<?php }