<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/image', $item_style, $params); ?>

<div class="mkd-pli-text-holder">
	<div class="mkd-pli-go-text-wrapper">
		<div class="mkd-pli-go-text">
			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/title', $item_style, $params); ?>

			<?php if ($enable_category === 'yes') { ?>

				<div class="mkd-pli-separator-category-holder">

					<?php echo entre_mikado_get_separator_html(array('width'=>'56px')); ?>

					<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/category', $item_style, $params); ?>

				</div>

			<?php } ?>

			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/images-count', $item_style, $params); ?>
			
			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/excerpt', $item_style, $params); ?>
		</div>
	</div>
</div>