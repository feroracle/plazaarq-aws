<?php
/*
Plugin Name: Mikado Instagram Feed
Description: Plugin that adds Instagram feed functionality to our theme
Author: Mikado Themes
Version: 2.0.1
*/


include_once 'load.php';

if(!function_exists('mkd_instagram_feed_text_domain')) {
    /**
     * Loads plugin text domain so it can be used in translation
     */
    function mkd_instagram_feed_text_domain() {
        load_plugin_textdomain('mkd-instagram-feed', false, MIKADO_INSTAGRAM_REL_PATH.'/languages');
    }

    add_action('plugins_loaded', 'mkd_instagram_feed_text_domain');
}