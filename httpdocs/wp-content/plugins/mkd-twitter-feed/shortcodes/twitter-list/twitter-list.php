<?php

namespace MikadoTwitter\Shortcodes\TwitterList;

use MikadoTwitter\Lib;

class TwitterList implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'mkd_twitter_list';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Mikado Twitter List', 'mkd-twitter-feed' ),
					'base'                      => $this->base,
					'category'                  => esc_html__( 'by MIKADO', 'mkd-twitter-feed' ),
					'icon'                      => 'icon-wpb-twitter-list extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'user_id',
							'heading'     => esc_html__( 'User ID', 'mkd-twitter-feed' ),
							'admin_label' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'number_of_columns',
							'heading'     => esc_html__( 'Number of Columns', 'mkd-twitter-feed' ),
							'value'       => array(
								esc_html__( 'One', 'mkd-twitter-feed' )   => '1',
								esc_html__( 'Two', 'mkd-twitter-feed' )   => '2',
								esc_html__( 'Three', 'mkd-twitter-feed' ) => '3',
								esc_html__( 'Four', 'mkd-twitter-feed' )  => '4',
								esc_html__( 'Five', 'mkd-twitter-feed' )  => '5'
							),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'space_between_columns',
							'heading'    => esc_html__( 'Space Between Columns', 'mkd-twitter-feed' ),
							'value'      => array_flip( entre_mikado_get_space_between_items_array() )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'number_of_tweets',
							'heading'    => esc_html__( 'Number of Tweets', 'mkd-twitter-feed' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'transient_time',
							'heading'    => esc_html__( 'Tweets Cache Time', 'mkd-twitter-feed' )
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'user_id'               => '',
			'number_of_columns'     => '3',
			'space_between_columns' => 'normal',
			'number_of_tweets'      => '',
			'transient_time'        => ''
		);
		$params = shortcode_atts( $args, $atts );
		extract( $params );
		
		$params['holder_classes'] = $this->getHolderClasses( $params );
		
		$twitter_api           = new \MikadoTwitterApi();
		$params['twitter_api'] = $twitter_api;
		
		if ( $twitter_api->hasUserConnected() ) {
			$response = $twitter_api->fetchTweets( $user_id, $number_of_tweets, array(
				'transient_time' => $transient_time,
				'transient_id'   => 'mkd_twitter_' . rand( 0, 1000 )
			) );
			
			$params['response'] = $response;
		}
		
		//Get HTML from template based on type of team
		$html = mkd_twitter_get_shortcode_module_template_part( 'holder', 'twitter-list', '', $params );
		
		return $html;
	}
	
	public function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = $this->getColumnNumberClass( $params['number_of_columns'] );
		$holderClasses[] = ! empty( $params['space_between_columns'] ) ? 'mkd-' . $params['space_between_columns'] . '-space' : 'mkd-tl-normal-space';
		
		return implode( ' ', $holderClasses );
	}

    public function getColumnNumberClass( $params ) {
        switch ( $params ) {
            case 1:
                $classes = 'mkd-tl-one-column';
                break;
            case 2:
                $classes = 'mkd-tl-two-columns';
                break;
            case 3:
                $classes = 'mkd-tl-three-columns';
                break;
            case 4:
                $classes = 'mkd-tl-four-columns';
                break;
            case 5:
                $classes = 'mkd-tl-five-columns';
                break;
            default:
                $classes = 'mkd-tl-three-columns';
                break;
        }

        return $classes;
    }
}