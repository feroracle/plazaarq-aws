<div class="mkd-prod-cat <?php echo esc_attr($item_classes)?>">
    <div class="mkd-prod-cat-inner">
        <?php
            if(isset($img_url) && $img_url!== ''){ ?>
                <div class="mkd-prod-cat-img-wrapper">
                    <div class="mkd-pcw-inner">
                        <a href="<?php echo esc_attr($link);?>">
                            <img src="<?php echo esc_url($img_url);?>" alt="<?php echo esc_attr($term->name);?>">
                        </a>
                    </div>
                </div>
            <?php }
        ?>
        <div class="mkd-prod-cat-content <?php echo esc_attr($content_position);?>">
            <h4 class="mkd-category-title">
                <a href="<?php echo esc_attr($link);?>">
                    <?php
                    echo esc_attr($term->name);
                    ?>
                </a>
            </h4>
            <?php
            if($min_price && $min_price !== 0){ ?>
                <span class="mkd-prod-cat-price-holder">
                    <?php esc_html_e('from $', 'entre');
                        echo esc_attr($min_price);
                    ?>
            </span>
            <?php } ?>
	        <?php if($enable_button === 'yes'){ ?>
                <div class="mkd-prod-cat-button-holder">
			        <?php echo entre_mikado_get_button_html($button_params);?>
                </div>
	        <?php }?>
        </div>
    </div>
</div>