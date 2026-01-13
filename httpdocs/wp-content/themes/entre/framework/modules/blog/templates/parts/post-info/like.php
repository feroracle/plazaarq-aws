<?php if(entre_mikado_core_plugin_installed()) { ?>
    <div class="mkd-blog-like">
        <?php if( function_exists('entre_mikado_get_like') ) entre_mikado_get_like(); ?>
    </div>
<?php } ?>