<?php
$tags = get_the_tags();
$show_tags = entre_mikado_options()->getOptionValue('blog_single_tags') == 'yes' ? true : false;
?>
<?php if($tags && $show_tags ) { ?>
<div class="mkd-tags-holder">
    <div class="mkd-tags">
        <?php the_tags('', ', ', ''); ?>
    </div>
</div>
<?php } ?>