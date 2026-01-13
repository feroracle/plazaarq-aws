<div class="mkd-floating-prod-cat <?php echo esc_attr($item_classes)?>">

    <div class="mkd-floating-cat-inner">
        <div class="mkd-floating-cat-wrapper">

            <img class="mkd-floating-cat-image" src= "<?php echo esc_url($image_obj); ?>" alt="floating-cat-image" >

            <div class="mkd-floating-cat-content">
                <h3 class="mkd-category-title" <?php entre_mikado_inline_style($info_styles); ?>>
                    <a href="<?php echo esc_attr($link);?>">
                        <?php
                        echo esc_attr($term->name);
                        ?>
                    </a>
                </h3>
                <?php
                if($min_price && $min_price !== 0){ ?>
                    <div class="mkd-floating-cat-price-holder" <?php entre_mikado_inline_style($info_styles); ?>>
                    <?php echo entre_mikado_get_separator_html($separator_params); ?>
                    <?php esc_html_e('from $', 'entre');?>
                        <span>
                        <?php
                        echo esc_attr($min_price);
                        ?>
                    </span>
                </div>
                <?php }
                echo entre_mikado_get_button_html($button_params);
                ?>
            </div>

        </div>
    </div>

</div>