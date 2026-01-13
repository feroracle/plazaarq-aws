<?php 
	$mkd_drop_shadow_effect_styles = array();
	$mkd_drop_shadow_effect_color  = get_post_meta( get_the_ID(), 'drop_shadow_effect_color', true);
	if ( !empty( $mkd_drop_shadow_effect_color ) ) {
		$mkd_drop_shadow_effect_styles[] = 'background-color: ' .  $mkd_drop_shadow_effect_color;
	}
?>
<div class="mkd-pli-image-holder" >
	<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/image', $item_style, $params); ?>
	<div class="mkd-pli-image-drop-shadow" <?php entre_mikado_inline_style($mkd_drop_shadow_effect_styles); ?> <?php echo entre_mikado_get_inline_attrs($this_object->getParallaxData($params)); ?>></div>
</div>
<div class="mkd-pli-text-holder">
	<div class="mkd-pli-text-wrapper">
		<div class="mkd-pli-text">
			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/title', $item_style, $params); ?>

			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/category', $item_style, $params); ?>

			<?php echo mkd_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/excerpt', $item_style, $params); ?>
		</div>
	</div>
</div>