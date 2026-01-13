<?php
$title_tag = isset($quote_tag) ? $quote_tag : 'h5';
$quote_text_meta = get_post_meta(get_the_ID(), "mkd_post_quote_text_meta", true );

$post_title = !empty($quote_text_meta) ? $quote_text_meta : get_the_title();

$post_author = get_post_meta(get_the_ID(), "mkd_post_quote_author_meta", true );
?>

<div class="mkd-post-quote-holder">
    <div class="mkd-post-quote-holder-inner">
        <<?php echo entre_mikado_escape_title_tag($title_tag);?> itemprop="name" class="mkd-quote-title mkd-post-title">
        <?php if(entre_mikado_blog_item_has_link()) { ?>
            <a itemprop="url" href="<?php echo get_the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php } ?>
            <?php echo esc_html($post_title); ?>
        <?php if(entre_mikado_blog_item_has_link()) { ?>
            </a>
        <?php } ?>
        </<?php echo entre_mikado_escape_title_tag($title_tag);?>>
        <?php if($post_author != '') { ?>
            <span class="mkd-quote-author">
                <?php echo esc_html($post_author); ?>
            </span>
        <?php } ?>
    </div>
</div>