<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/image', $item_style, $params); ?>

<div class="mkd-pli-text-holder">
	<div class="mkd-pli-text-wrapper">
        <div class="mkd-pli-text-wrapper-inner">
            <div class="mkd-pli-text">
                <div class="mkd-pli-text-inner">
                    <?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list','parts/title', $item_style, $params); ?>

                    <?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/category', $item_style, $params); ?>
 
                    <?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/images-count', $item_style, $params); ?>

                    <?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/excerpt', $item_style, $params); ?>
                </div>
            </div>
		</div>
	</div>
</div>