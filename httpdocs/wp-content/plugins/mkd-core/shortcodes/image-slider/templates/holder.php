<?php
if(is_array($all_items) && count($all_items)){?>
    <div class="mkd-image-slider-holder mkd-owl-slider" <?php echo entre_mikado_get_inline_attrs($data_params); ?> >
        <?php
        foreach ($all_items as $item){ ?>
            <div class="mkd-image-slider-item" <?php echo entre_mikado_get_inline_style($item['image_style']); ?> >
                <?php if($item['image_url'] !== '' ){ ?>
                    <div class="mkd-image-slider-item-inner mkd-image-slider-image">
                        <img src="<?php echo esc_url($item['image_url']);?>" alt="<?php esc_attr_e('Image Slider Item', 'mkd-core')?>" >
                    </div>
                <?php } ?>
                <?php if((isset($item['content']) && $item['content'] !== '') || isset($item['title']) && $item['title'] !== ''){
                    ?>
                    <div class="mkd-image-slider-item-inner-wrapper" <?php entre_mikado_get_inline_style($item['image_style']); ?> >
                        <div class="mkd-image-slider-item-content <?php echo 'mkd-image-slider-item-' . $item['skin'];?>">
                            <?php if(isset($item['title']) && $item['title'] !== ''){ ?>
                                <div class="mkd-image-slider-item-inner mkd-image-slider-title">
                                    <span>
                                        <?php
                                            echo esc_attr($item['title']);
                                        ?>
                                    </span>
                                </div>
                            <?php }	?>
                            <?php if(isset($item['content']) && $item['content'] !== ''){ ?>
                                <div class="mkd-image-slider-item-inner mkd-image-slider-content">
                                    <span>
                                        <?php
                                            echo esc_attr($item['content']);
                                        ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
          <?php }
        ?>
    </div>
<?php }