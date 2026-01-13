<?php
$post_classes[] = 'mkd-item-space';
if ( isset( $image_proportion_value ) && $image_proportion_value !== '' ) {
    $size           = $image_proportion_value !== '' ? $image_proportion_value : 'default';
    $post_classes[] = 'mkd-post-size-' . $size;
} else {
    $size           = 'default';
    $post_classes[] = 'mkd-post-size-default';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="mkd-post-content">
        <div class="mkd-post-text">
            <div class="mkd-post-mark">
                <span class="mkd-line-left"></span>
                <span class="lnr lnr-paperclip mkd-link-mark"></span>
                <span class="mkd-line-right"></span>
            </div>
            <?php entre_mikado_get_module_template_part('templates/parts/post-type/link', 'blog', '', $part_params); ?>
        </div>
    </div>
</article>