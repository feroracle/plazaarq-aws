<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoSideAreaOpener extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_side_area_opener',
				esc_html__( 'Mikado Side Area Opener', 'entre' ),
				array( 'description' => esc_html__( 'Display a "hamburger" icon that opens the side area', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$this->params = array(
				array(
					'type'        => 'colorpicker',
					'name'        => 'icon_color',
					'title'       => esc_html__( 'Side Area Opener Color', 'entre' ),
					'description' => esc_html__( 'Define color for side area opener', 'entre' )
				),
				array(
					'type'        => 'colorpicker',
					'name'        => 'icon_hover_color',
					'title'       => esc_html__( 'Side Area Opener Hover Color', 'entre' ),
					'description' => esc_html__( 'Define hover color for side area opener', 'entre' )
				),
				array(
					'type'        => 'textfield',
					'name'        => 'widget_margin',
					'title'       => esc_html__( 'Side Area Opener Margin', 'entre' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'widget_title',
					'title' => esc_html__( 'Side Area Opener Title', 'entre' )
				)
			);
		}
		
		public function widget( $args, $instance ) {
			$holder_styles = array();
			
			if ( ! empty( $instance['icon_color'] ) ) {
				$holder_styles[] = 'color: ' . $instance['icon_color'] . ';';
			}
			if ( ! empty( $instance['widget_margin'] ) ) {
				$holder_styles[] = 'margin: ' . $instance['widget_margin'];
			}
			?>
			
			<a class="mkd-side-menu-button-opener mkd-icon-has-hover" <?php echo entre_mikado_get_inline_attr( $instance['icon_hover_color'], 'data-hover-color' ); ?>
			   href="javascript:void(0)" <?php entre_mikado_inline_style( $holder_styles ); ?>>
				<?php if ( ! empty( $instance['widget_title'] ) ) { ?>
					<h5 class="mkd-side-menu-title"><?php echo esc_html( $instance['widget_title'] ); ?></h5>
				<?php } ?>
				<span class="mkd-side-menu-icon">
        		<span class="mkd-sm-lines">
                    <span class="mkd-sm-line mkd-line-1"></span>
                    <span class="mkd-sm-line mkd-line-2"></span>
                    <span class="mkd-sm-line mkd-line-3"></span>
                </span>
        	</span>
			</a>
		<?php }
	}
}