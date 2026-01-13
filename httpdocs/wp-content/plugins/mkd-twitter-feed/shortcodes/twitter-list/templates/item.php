<li class="mkd-tl-item mkd-item-space">
    <div class="mkd-tli-inner">
        <div class="mkd-tli-content">
            <div class="mkd-twitter-content-top">
                <div class="mkd-twitter-user clearfix">
                    <div class="mkd-twitter-image">
                        <img src="<?php echo esc_html( $twitter_api->getHelper()->getTweetProfileImage( $tweet ) ); ?>" alt="<?php echo esc_html( $twitter_api->getHelper()->getTweetProfileName( $tweet ) ); ?>"/>
                    </div>
                    <div class="mkd-twitter-name">
                        <div class="mkd-twitter-autor">
                            <h5>
                                <?php echo esc_html( $twitter_api->getHelper()->getTweetProfileName( $tweet ) ); ?>
                            </h5>
                        </div>
                        <div class="mkd-twitter-profile">
                            <a href="<?php echo esc_url( $twitter_api->getHelper()->getTweetProfileURL( $tweet ) ); ?>" target="_blank" itemprop="url">
                                <?php echo esc_html( $twitter_api->getHelper()->getTweetProfileScreenName( $tweet ) ); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <i class="mkd-twitter-icon social_twitter"></i>
            </div>
            <div class="mkd-twitter-content-bottom">
                <div class="mkd-tweet-text">
                    <?php echo wp_kses_post( $twitter_api->getHelper()->getTweetText( $tweet ) ); ?>
                </div>
            </div>
            <a class="mkd-twitter-link-over" href="<?php echo esc_url( $twitter_api->getHelper()->getTweetProfileURL( $tweet ) ); ?>" target="_blank" itemprop="url"></a>
        </div>
    </div>
</li>