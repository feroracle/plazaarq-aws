<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoStickySidebar extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_sticky_sidebar',
				esc_html__( 'Mikado Sticky Sidebar Widget', 'entre' ),
				array( 'description' => esc_html__( 'Use this widget to make the sidebar sticky. Drag it into the sidebar above the widget which you want to be the first element in the sticky sidebar.', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
		}
		
		public function widget( $args, $instance ) {
			echo '<div class="widget mkd-widget-sticky-sidebar"></div>';
		}
	}
}