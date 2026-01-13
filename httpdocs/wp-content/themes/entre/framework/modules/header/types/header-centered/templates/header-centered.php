<?php do_action('entre_mikado_before_page_header'); ?>

<header class="mkd-page-header">
	<?php do_action('entre_mikado_after_page_header_html_open'); ?>
	
    <div class="mkd-logo-area">
	    <?php do_action( 'entre_mikado_after_header_logo_area_html_open' ); ?>
	    
        <?php if($logo_area_in_grid) : ?>
            <div class="mkd-grid">
        <?php endif; ?>
			
            <div class="mkd-vertical-align-containers">
                <div class="mkd-position-center">
                    <div class="mkd-position-center-inner">
                        <?php if(!$hide_logo) {
                            entre_mikado_get_logo();
                        } ?>
                    </div>
                </div>
            </div>
	            
        <?php if($logo_area_in_grid) : ?>
            </div>
        <?php endif; ?>
    </div>
	
    <?php if($show_fixed_wrapper) : ?>
        <div class="mkd-fixed-wrapper">
    <?php endif; ?>
	        
    <div class="mkd-menu-area">
	    <?php do_action( 'entre_mikado_after_header_menu_area_html_open' ); ?>
	    
        <?php if($menu_area_in_grid) : ?>
            <div class="mkd-grid">
        <?php endif; ?>
	            
            <div class="mkd-vertical-align-containers">
                <div class="mkd-position-center">
                    <div class="mkd-position-center-inner">
                        <?php entre_mikado_get_main_menu(); ?>
                    </div>
                </div>
            </div>
	            
        <?php if($menu_area_in_grid) : ?>
            </div>
        <?php endif; ?>
    </div>
	
    <?php if($show_fixed_wrapper) { ?>
        </div>
	<?php } ?>
	
	<?php if($show_sticky) {
		entre_mikado_get_sticky_header('centered', 'header/types/header-centered');
	} ?>
	
	<?php do_action('entre_mikado_before_page_header_html_close'); ?>
</header>

<?php do_action('entre_mikado_after_page_header'); ?>