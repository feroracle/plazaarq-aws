<?php do_action('entre_mikado_before_sticky_header'); ?>

<div class="mkd-sticky-header">
    <?php do_action( 'entre_mikado_after_sticky_menu_html_open' ); ?>
    <div class="mkd-sticky-holder">
        <?php if($sticky_header_in_grid) : ?>
        <div class="mkd-grid">
            <?php endif; ?>
            <div class="mkd-vertical-align-containers">
                <div class="mkd-position-left">
                    <div class="mkd-position-left-inner">
                        <?php if(!$hide_logo) {
                            entre_mikado_get_logo('sticky');
                        } ?>
                        <?php if($menu_area_position === 'left') : ?>
                            <?php entre_mikado_get_sticky_menu('mkd-sticky-nav'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if($menu_area_position === 'center') : ?>
                    <div class="mkd-position-center">
                        <div class="mkd-position-center-inner">
                            <?php entre_mikado_get_sticky_menu('mkd-sticky-nav'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mkd-position-right">
                    <div class="mkd-position-right-inner">
                        <?php if($menu_area_position === 'right') : ?>
                            <?php entre_mikado_get_sticky_menu('mkd-sticky-nav'); ?>
                        <?php endif; ?>
                        <?php if(is_active_sidebar('mkd-sticky-right')) : ?>
                            <?php dynamic_sidebar('mkd-sticky-right'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if($sticky_header_in_grid) : ?>
        </div>
        <?php endif; ?>
    </div>
	<?php do_action( 'entre_mikado_before_sticky_menu_html_close' ); ?>
</div>

<?php do_action('entre_mikado_after_sticky_header'); ?>