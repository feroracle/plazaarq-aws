<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoSearchPostType extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_search_post_type',
				esc_html__( 'Mikado Search Post Type', 'entre' ),
				array( 'description' => esc_html__( 'Select post type that you want to be searched for', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$post_types = apply_filters( 'entre_mikado_search_post_type_widget_params_post_type', array( 'post' => 'Post' ) );
			
			$this->params = array(
				array(
					'type'        => 'dropdown',
					'name'        => 'post_type',
					'title'       => esc_html__( 'Post Type', 'entre' ),
					'description' => esc_html__( 'Choose post type that you want to be searched for', 'entre' ),
					'options'     => $post_types
				)
			);
		}
		
		public function widget( $args, $instance ) {
			$search_type_class = 'mkd-search-post-type';
			$post_type         = $instance['post_type'];
			?>
			
			<div class="widget mkd-search-post-type-widget">
				<div data-post-type="<?php echo esc_attr( $post_type ); ?>" <?php entre_mikado_class_attribute( $search_type_class ); ?>>
					<input class="mkd-post-type-search-field" value=""
					       placeholder="<?php esc_attr_e( 'Search here', 'entre' ) ?>">
					<i class="mkd-search-icon fa fa-search" aria-hidden="true"></i>
					<i class="mkd-search-loading fa fa-spinner fa-spin mkd-hidden" aria-hidden="true"></i>
				</div>
				<div class="mkd-post-type-search-results"></div>
			</div>
		<?php }
	}
}