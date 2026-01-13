<?php
$masonry_classes = '';
$number_of_columns = entre_mikado_get_meta_field_intersect('portfolio_single_masonry_columns_number');
if(!empty($number_of_columns)) {
	$masonry_classes .= ' mkd-ps-'.$number_of_columns.'-columns';
}
$space_between_items = entre_mikado_get_meta_field_intersect('portfolio_single_masonry_space_between_items');
if(!empty($space_between_items)) {
	$masonry_classes .= ' mkd-'.$space_between_items.'-space';
}
?>
<div class="mkd-grid-row">
	<div class="mkd-grid-col-7">
		<div class="mkd-ps-image-holder mkd-ps-masonry-images <?php echo esc_attr($masonry_classes); ?>">
			<div class="mkd-ps-image-inner mkd-outer-space">
				<div class="mkd-ps-grid-sizer"></div>
				<div class="mkd-ps-grid-gutter"></div>
				<?php
				$media = mkd_core_get_portfolio_single_media();
				
				if(is_array($media) && count($media)) : ?>
					<?php foreach($media as $single_media) : ?>
						<div class="mkd-ps-image mkd-item-space <?php echo esc_attr($single_media['holder_classes']); ?>">
							<?php mkd_core_get_portfolio_single_media_html($single_media); ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="mkd-grid-col-5">
		<div class="mkd-ps-info-holder mkd-ps-info-sticky-holder">
			<?php
			//get portfolio content section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/content', 'portfolio', $item_layout);
			
			//get portfolio custom fields section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/custom-fields', 'portfolio', $item_layout);
			
			//get portfolio categories section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/categories', 'portfolio', $item_layout);
			
			//get portfolio date section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/date', 'portfolio', $item_layout);
			
			//get portfolio tags section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/tags', 'portfolio', $item_layout);
			
			//get portfolio share section
			mkd_core_get_cpt_single_module_template_part('templates/single/parts/social', 'portfolio', $item_layout);
			?>
		</div>
	</div>
</div>