<?php
$share_type = isset($share_type) ? $share_type : 'list';
?>
<?php if( entre_mikado_core_plugin_installed() && entre_mikado_options()->getOptionValue('enable_social_share') === 'yes' && entre_mikado_options()->getOptionValue('enable_social_share_on_post') === 'yes') { ?>
    <div class="mkd-blog-share">
        <?php echo entre_mikado_get_social_share_html(array('type' => $share_type)); ?>
    </div>
<?php } ?>