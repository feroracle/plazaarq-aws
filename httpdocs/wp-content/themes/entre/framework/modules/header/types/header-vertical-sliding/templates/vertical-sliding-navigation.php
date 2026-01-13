<?php do_action('entre_mikado_before_top_navigation'); ?>
<nav class="mkd-fullscreen-menu">
    <?php
    wp_nav_menu(array(
        'theme_location'  => 'vertical-navigation',
        'container'       => '',
        'container_class' => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'fallback_cb'     => 'top_navigation_fallback',
        'link_before'     => '<span>',
        'link_after'      => '</span>',
        'walker'          => new EntreMikadoFullscreenNavigationWalker()
    ));
    ?>
</nav>
<?php do_action('entre_mikado_after_top_navigation'); ?>