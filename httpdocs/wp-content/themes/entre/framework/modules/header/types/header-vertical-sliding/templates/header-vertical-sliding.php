<?php do_action('entre_mikado_before_page_header'); ?>
<aside class="mkd-vertical-menu-area <?php echo esc_html($holder_class); ?>">
    <div class="mkd-vertical-menu-area-inner">
        <div class="mkd-vertical-area-background"></div>
        <div class="mkd-vertical-menu-nav-holder-outer">
            <div class="mkd-vertical-menu-nav-holder">
                <div class="mkd-vertical-menu-holder-nav-inner">
                    <?php entre_mikado_get_header_vertical_sliding_main_menu(); ?>
                </div>
            </div>
        </div>
        <div class="mkd-vertical-menu-opener">
            <a href="#">
                <span class="mkd-vs-lines">
                    <span class="mkd-vs-line mkd-line-1"></span>
                    <span class="mkd-vs-line mkd-line-2"></span>
                    <span class="mkd-vs-line mkd-line-3"></span>
                </span>
            </a>
        </div>
        <div class="mkd-vertical-menu-holder">
            <div class="mkd-vertical-menu-table">
                <div class="mkd-vertical-menu-table-cell">
                    <?php if(!$hide_logo) {
                        entre_mikado_get_logo();
                    } ?>
                    <div class="mkd-vertical-area-widget-holder">
                        <?php entre_mikado_get_header_vertical_sliding_widget_areas(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<?php do_action('entre_mikado_after_page_header'); ?>
