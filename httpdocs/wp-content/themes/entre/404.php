<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	/**
	 * entre_mikado_header_meta hook
	 *
	 * @see entre_mikado_header_meta() - hooked with 10
	 * @see entre_mikado_user_scalable_meta - hooked with 10
	 * @see mkd_core_set_open_graph_meta - hooked with 10
	 */
	do_action( 'entre_mikado_header_meta' );
	
	wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<?php
	/**
	 * entre_mikado_after_body_tag hook
	 *
	 * @see entre_mikado_get_side_area() - hooked with 10
	 * @see entre_mikado_smooth_page_transitions() - hooked with 10
	 */
	do_action( 'entre_mikado_after_body_tag' ); ?>
	
	<div class="mkd-wrapper mkd-404-page">
		<div class="mkd-wrapper-inner">
            <?php
            /**
             * entre_mikado_after_wrapper_inner hook
             *
             * @see entre_mikado_get_header() - hooked with 10
             * @see entre_mikado_get_mobile_header() - hooked with 20
             * @see entre_mikado_back_to_top_button() - hooked with 30
             * @see entre_mikado_get_header_minimal_full_screen_menu() - hooked with 40
             * @see entre_mikado_get_header_bottom_navigation() - hooked with 40
             */
            do_action( 'entre_mikado_after_wrapper_inner' );

            do_action('entre_mikado_before_main_content'); ?>
			
			<div class="mkd-content" <?php entre_mikado_content_elem_style_attr(); ?>>
				<div class="mkd-content-inner">
					<div class="mkd-page-not-found">
						<?php
						$mkd_title_image_404 = entre_mikado_options()->getOptionValue( '404_page_title_image' );
						$mkd_title_404       = entre_mikado_options()->getOptionValue( '404_title' );
						$mkd_subtitle_404    = entre_mikado_options()->getOptionValue( '404_subtitle' );
						$mkd_text_404        = entre_mikado_options()->getOptionValue( '404_text' );
						$mkd_button_label    = entre_mikado_options()->getOptionValue( '404_back_to_home' );
						$mkd_button_style    = entre_mikado_options()->getOptionValue( '404_button_style' );
						
						if ( ! empty( $mkd_title_image_404 ) ) { ?>
							<div class="mkd-404-title-image">
								<img src="<?php echo esc_url( $mkd_title_image_404 ); ?>" alt="<?php esc_attr_e( '404 Title Image', 'entre' ); ?>" />
							</div>
						<?php } ?>

						<h3 class="mkd-404-subtitle">
							<?php if ( ! empty( $mkd_subtitle_404 ) ) {
								echo esc_html( $mkd_subtitle_404 );
							} else {
								esc_html_e( '', 'entre' );
							} ?>
						</h3>
						
						<h1 class="mkd-404-title">
							<?php if ( ! empty( $mkd_title_404 ) ) {
								echo esc_html( $mkd_title_404 );
							} else {
								esc_html_e( '404', 'entre' );
							} ?>
						</h1>
						
						<p class="mkd-404-text">
							<?php if ( ! empty( $mkd_text_404 ) ) {
								echo esc_html( $mkd_text_404 );
							} else {
								 esc_html_e( 'the page you are looking for does not exist. It might have been moved or deleted.', 'entre' );
							} ?>
						</p>
						
						<?php
							$button_params = array(
								'link' => esc_url( home_url( '/' ) ),
								'text' => ! empty( $mkd_button_label ) ? $mkd_button_label : esc_html__( 'back to home', 'entre' ),
								'type' => 'minimal'
							);
						
							if ( $mkd_button_style == 'light-style' ) {
								$button_params['custom_class'] = 'mkd-btn-light-style';
							}
							
							echo entre_mikado_return_button_html( $button_params );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>