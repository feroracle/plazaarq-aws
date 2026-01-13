<?php if(entre_mikado_options()->getOptionValue('enable_social_share') == 'yes' && entre_mikado_options()->getOptionValue('enable_social_share_on_portfolio-item') == 'yes') : ?>
    <div class="mkd-ps-info-item mkd-ps-social-share">
    	<h6 class="mkd-ps-info-title mkd-ps-social-share-title"><?php esc_html_e('Share', 'mkd-core'); ?></h6>
        <?php echo entre_mikado_get_social_share_html() ?>
    </div>
<?php endif; ?>