<?php

if(!function_exists('entre_mikado_map_woocommerce_meta')) {
    function entre_mikado_map_woocommerce_meta() {
        $woocommerce_meta_box = entre_mikado_create_meta_box(
            array(
                'scope' => array('product'),
                'title' => esc_html__('Product Meta', 'entre'),
                'name' => 'woo_product_meta'
            )
        );

        entre_mikado_create_meta_box_field(array(
            'name'        => 'mkd_product_featured_image_size',
            'type'        => 'select',
            'label'       => esc_html__('Dimensions for Product List Shortcode', 'entre'),
            'description' => esc_html__('Choose image layout when it appears in Mikado Product List - Masonry layout shortcode', 'entre'),
            'parent'      => $woocommerce_meta_box,
            'options'     => array(
                'mkd-woo-image-normal-width' => esc_html__('Default', 'entre'),
                'mkd-woo-image-large-width'  => esc_html__('Large Width', 'entre')
            )
        ));

        entre_mikado_create_meta_box_field(
            array(
                'name'          => 'mkd_show_title_area_woo_meta',
                'type'          => 'select',
                'default_value' => '',
                'label'         => esc_html__('Show Title Area', 'entre'),
                'description'   => esc_html__('Disabling this option will turn off page title area', 'entre'),
                'parent'        => $woocommerce_meta_box,
                'options'       => entre_mikado_get_yes_no_select_array()
            )
        );

        entre_mikado_create_meta_box_field(
            array(
                'name'        => 'mkd_product_hover_background_color_woo_meta',
                'parent'      => $woocommerce_meta_box,
                'type'        => 'color',
                'label'       => esc_html__( 'Background Color', 'entre' ),
                'description' => esc_html__( 'Choose hover background color for single product. This option will be shown in default shop list as well as in Mikado Product List Shortcode', 'entre' )
            )
        );
    }
	
    add_action('entre_mikado_meta_boxes_map', 'entre_mikado_map_woocommerce_meta', 99);
}