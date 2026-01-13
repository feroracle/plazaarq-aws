<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoContactForm7Widget extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_contact_form_7_widget',
				esc_html__( 'Mikado Contact Form 7 Widget', 'entre' ),
				array( 'description' => esc_html__( 'Add contact form 7 to widget areas', 'entre' ) )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
			
			$contact_forms = array();
			if ( $cf7 ) {
				foreach ( $cf7 as $cform ) {
					$contact_forms[ $cform->ID ] = $cform->post_title;
				}
			} else {
				$contact_forms[0] = esc_html__( 'No contact forms found', 'entre' );
			}
			
			$this->params = array(
				array(
					'type'  => 'textfield',
					'name'  => 'extra_class',
					'title' => esc_html__( 'Extra Class Name', 'entre' )
				),
				array(
					'type'  => 'textfield',
					'name'  => 'widget_title',
					'title' => esc_html__( 'Widget Title', 'entre' )
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'contact_form',
					'title'   => esc_html__( 'Select Contact Form 7', 'entre' ),
					'options' => $contact_forms
				),
				array(
					'type'    => 'dropdown',
					'name'    => 'contact_form_style',
					'title'   => esc_html__( 'Contact Form 7 Style', 'entre' ),
					'options' => array(
						''                   => esc_html__( 'Default', 'entre' ),
						'cf7_custom_style_1' => esc_html__( 'Custom Style 1', 'entre' ),
						'cf7_custom_style_2' => esc_html__( 'Custom Style 2', 'entre' ),
						'cf7_custom_style_3' => esc_html__( 'Custom Style 3', 'entre' )
					)
				)
			);
		}
		
		public function widget( $args, $instance ) {
			$extra_class = ! empty( $instance['extra_class'] ) ? esc_attr( $instance['extra_class'] ) : '';
			?>
			<div class="widget mkd-contact-form-7-widget <?php echo esc_attr( $extra_class ); ?>">
				<?php if ( ! empty( $instance['widget_title'] ) ) {
					echo wp_kses_post( $args['before_title'] ) . esc_html( $instance['widget_title'] ) . wp_kses_post( $args['after_title'] );
				} ?>
				<?php if ( ! empty( $instance['contact_form'] ) ) {
					echo do_shortcode( '[contact-form-7 id="' . esc_attr( $instance['contact_form'] ) . '" html_class="' . esc_attr( $instance['contact_form_style'] ) . '"]' );
				} ?>
			</div>
			<?php
		}
	}
}