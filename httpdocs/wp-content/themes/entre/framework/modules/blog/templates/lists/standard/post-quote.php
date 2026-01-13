<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="mkd-post-content">
        <div class="mkd-post-text">
            <div class="mkd-post-text-inner">
                <div class="mkd-post-text-main">
                    <div class="mkd-post-mark">
                        <span class="mkd-quote-mark">&rdquo;</span>
                    </div>
                    <?php entre_mikado_get_module_template_part('templates/parts/post-type/quote', 'blog', '', $part_params); ?>
                </div>
            </div>
        </div>
        <div class="mkd-post-info-bottom clearfix">
            <div class="mkd-post-info-bottom-left">
                <?php entre_mikado_get_module_template_part('templates/parts/post-info/share', 'blog', '', $part_params); ?>
            </div>
            <div class="mkd-post-info-bottom-right">
                <?php entre_mikado_get_module_template_part('templates/parts/post-info/category', 'blog', '', $part_params); ?>
            </div>
        </div>
    </div>
</article>