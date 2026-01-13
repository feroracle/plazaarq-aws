<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoSearchOpener extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_search_opener',
				esc_html__( 'Mikado Search Opener', 'entre' ),
				array( 'description' => esc_html__( 'Display a "search" icon that opens the search form', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$this->params = array(
				array(
					'type'        => 'colorpicker',
					'name'        => 'search_icon_color',
					'title'       => esc_html__( 'Icon Color', 'entre' ),
					'description' => esc_html__( 'Define color for search icon', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'search_icon_hover_color',
					'title'       => esc_html__( 'Icon Hover Color', 'entre' ),
					'description' => esc_html__( 'Define hover color for search icon', 'entre' )
				),
				array(
					'type'        => 'textfield',
					'name'        => 'search_icon_margin',
					'title'       => esc_html__( 'Icon Margin', 'entre' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'entre' )
				),
				array(
					'type'        => 'dropdown',
					'name'        => 'show_label',
					'title'       => esc_html__( 'Enable Search Icon Text', 'entre' ),
					'description' => esc_html__( 'Enable this option to show search text next to search icon in header', 'entre' ),
					'options'     => entre_mikado_get_yes_no_select_array()
				)
			);
		}
		
		public function widget( $args, $instance ) {
			global $entre_mikado_options, $entre_mikado_IconCollections;
			
			$search_type_class = 'mkd-search-opener mkd-icon-has-hover';
			$styles            = array();
			$show_search_text  = $instance['show_label'] == 'yes' || $entre_mikado_options['enable_search_icon_text'] == 'yes' ? true : false;
			
			if ( ! empty( $instance['search_icon_color'] ) ) {
				$styles[] = 'color: ' . $instance['search_icon_color'] . ';';
			}
			
			if ( ! empty( $instance['search_icon_margin'] ) ) {
				$styles[] = 'margin: ' . $instance['search_icon_margin'] . ';';
			}
			?>
			
			<a <?php entre_mikado_inline_attr( $instance['search_icon_hover_color'], 'data-hover-color' ); ?> <?php entre_mikado_inline_style( $styles ); ?> <?php entre_mikado_class_attribute( $search_type_class ); ?>
					href="javascript:void(0)">
            <span class="mkd-search-opener-wrapper">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				     width="21px" height="21px" viewBox="0 0 149.391 149.39" enable-background="new 0 0 149.391 149.39"
				     xml:space="preserve">
					<g>
					 <path fill="#434343" d="M62.344,12.468c-27.5,0-49.875,22.375-49.875,49.875c0,1.723,1.394,3.118,3.117,3.118
					  s3.117-1.395,3.117-3.118c0-24.062,19.578-43.64,43.641-43.64c1.722,0,3.121-1.396,3.121-3.117
					  C65.465,13.863,64.066,12.468,62.344,12.468L62.344,12.468z M62.344,12.468"/>
					 <path fill="#434343" d="M108.508,104.101c10.02-11.065,16.184-25.687,16.184-41.758C124.691,27.968,96.723,0,62.344,0
					  C27.969,0,0,27.968,0,62.343c0,34.379,27.969,62.348,62.344,62.348c16.07,0,30.687-6.163,41.757-16.184l40.879,40.883l4.41-4.41
					  L108.508,104.101z M62.344,118.457c-30.938,0-56.11-25.172-56.11-56.114c0-30.937,25.172-56.109,56.11-56.109
					  c30.941,0,56.113,25.172,56.113,56.109C118.457,93.285,93.285,118.457,62.344,118.457L62.344,118.457z M62.344,118.457"/>
					</g>
				</svg>
	            <?php if ( $show_search_text ) { ?>
		            <span class="mkd-search-icon-text"><?php esc_html_e( 'Search', 'entre' ); ?></span>
	            <?php } ?>
            </span>
			</a>
		<?php }
	}
}