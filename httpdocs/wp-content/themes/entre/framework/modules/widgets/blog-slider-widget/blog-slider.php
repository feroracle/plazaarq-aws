<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoBlogSliderWidget extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_blog_slider_widget',
				esc_html__( 'Mikado Blog Slider Widget', 'entre' ),
				array( 'description' => esc_html__( 'Display a list of your blog posts', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$this->params = array(
				array(
					'type'  => 'textfield',
					'name'  => 'widget_title',
					'title' => esc_html__( 'Widget Title', 'entre' )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'type',
					'title'   => esc_html__( 'Type', 'entre' ),
					'options' => array(
						'simple'  => esc_html__( 'Simple', 'entre' ),
						'minimal' => esc_html__( 'Minimal', 'entre' )
					)
				),
				array(
					'type'  => 'textfield',
					'name'  => 'number_of_posts',
					'title' => esc_html__( 'Number of Posts', 'entre' )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'space_between_items',
					'title'   => esc_html__( 'Space Between Items', 'entre' ),
					'options' => entre_mikado_get_space_between_items_array()
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'orderby',
					'title'   => esc_html__( 'Order By', 'entre' ),
					'options' => entre_mikado_get_query_order_by_array()
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'order',
					'title'   => esc_html__( 'Order', 'entre' ),
					'options' => entre_mikado_get_query_order_array()
				),
				array(
					'type'        => 'textfield',
					'name'        => 'category',
					'title'       => esc_html__( 'Category Slug', 'entre' ),
					'description' => esc_html__( 'Leave empty for all or use comma for list', 'entre' )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'title_tag',
					'title'   => esc_html__( 'Title Tag', 'entre' ),
					'options' => entre_mikado_get_title_tag( true )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'title_transform',
					'title'   => esc_html__( 'Title Text Transform', 'entre' ),
					'options' => entre_mikado_get_text_transform_array( true )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'post_info_author',
					'title'   => esc_html__( 'Enable Post Info Author', 'entre' ),
					'options' => entre_mikado_get_yes_no_select_array( false )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'post_info_date',
					'title'   => esc_html__( 'Enable Post Info Date', 'entre' ),
					'options' => entre_mikado_get_yes_no_select_array( false, true )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'post_info_category',
					'title'   => esc_html__( 'Enable Post Info Category', 'entre' ),
					'options' => entre_mikado_get_yes_no_select_array( false )
				),
				
				array(
					'type'    => 'dropdown',
					'name'    => 'post_info_read_more',
					'title'   => esc_html__( 'Enable Read More Button', 'entre' ),
					'options' => entre_mikado_get_yes_no_select_array( false )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'post_info_comments',
					'title'   => esc_html__( 'Enable Post Info Comments', 'entre' ),
					'options' => entre_mikado_get_yes_no_select_array( false )
				)
			);
		}
		
		public function widget( $args, $instance ) {
			if ( ! is_array( $instance ) ) {
				$instance = array();
			}
			
			$instance['image_size']        = 'full';
			$instance['post_info_section'] = 'yes';
			$instance['number_of_columns'] = '1';
			
			// Filter out all empty params
			$instance         = array_filter( $instance, function ( $array_value ) {
				return trim( $array_value ) != '';
			} );
			$instance['type'] = ! empty( $instance['type'] ) ? $instance['type'] : 'simple';
			
			$params = '';
			//generate shortcode params
			foreach ( $instance as $key => $value ) {
				$params .= " $key='$value' ";
			}
			
			echo '<div class="widget mkd-blog-slider-widget">';
			if ( ! empty( $instance['widget_title'] ) ) {
				echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
			}
			
			echo do_shortcode( "[mkd_blog_slider $params]" ); // XSS OK
			echo '</div>';
		}
	}
}