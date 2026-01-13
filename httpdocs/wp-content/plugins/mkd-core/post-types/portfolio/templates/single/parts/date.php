<?php if(entre_mikado_options()->getOptionValue('portfolio_single_hide_date') === 'yes') : ?>
    <div class="mkd-ps-info-item mkd-ps-date">
        <h6 class="mkd-ps-info-title"><?php esc_html_e('Year', 'mkd-core'); ?></h6>
        <p itemprop="dateCreated" class="mkd-ps-info-date entry-date updated"><?php echo get_the_date('Y'); ?></p>
        <meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(entre_mikado_get_page_id()); ?>"/>
    </div>
<?php endif; ?>