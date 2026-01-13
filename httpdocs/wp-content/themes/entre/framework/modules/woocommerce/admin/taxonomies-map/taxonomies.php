<?php
use Entre\Modules\Woo\FieldCreator\SelectField;
use Entre\Modules\Woo\FieldCreator\InputField;

if ( ! function_exists( 'entre_mikado_woo_category_add_meta_fields' ) ) {

	function entre_mikado_woo_category_add_meta_fields() {

		$html = '';
		$select_field_creator = new SelectField();
		$input_field_creator = new InputField();

		$img_size_options = array(
			'big' => esc_html__('Big', 'entre'),
			'small'   => esc_html__('Small', 'entre')
		);

		$img_position_options = array(
			'left' => esc_html__('Left', 'entre'),
			'right'   => esc_html__('Right', 'entre')
		);

		$content_options = array(
			'top_left' => esc_html__('Top Left', 'entre'),
			'top_right'   => esc_html__('Top Right', 'entre'),
			'bottom_left' => esc_html__('Bottom Left', 'entre'),
			'bottom_right'   => esc_html__('Bottom Right', 'entre'),
			'middle_right'   => esc_html__('Middle Right', 'entre'),
			'middle_left'   => esc_html__('Middle Left', 'entre'),
		);

		$skin_options = array(
			'' => esc_html__('Default', 'entre'),
			'light' => esc_html__('Light', 'entre'),
			'dark' => esc_html__('Dark', 'entre'),
		);

		ob_start();
		$select_field_creator->renderField('tax_img_size', esc_html__('Choose Image Size(for Floating Product Categories shortcode)' , 'entre'), $img_size_options);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('tax_img_position', esc_html__('Choose Image Position(only if small image is choosen)(for Floating Product Categories shortcode)' , 'entre'), $img_position_options);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('tax_content_position', esc_html__('Choose Content Position(for Floating Product Categories shortcode)' , 'entre'), $content_options);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('category_info_skin', esc_html__('Choose Item Info Skin(for Floating Product Categories shortcode)' , 'entre'), $skin_options);
		$html .= ob_get_clean();

		ob_start();
		$input_field_creator->renderField('category_masonry_order', esc_html__('Set Category Order in Shortcodes(for Floating Product Categories shortcode)' , 'entre'));
		$html .= ob_get_clean();


		echo wp_kses_post($html);
		}

	//add_action( 'product_cat_add_form_fields', 'entre_mikado_woo_category_add_meta_fields', 10, 2 );

}

if ( ! function_exists( 'entre_mikado_woo_category_edit_meta_fields' ) ) {

	function entre_mikado_woo_category_edit_meta_fields($term, $taxonomy) {

		$img_size = get_term_meta( $term->term_id, 'tax_img_size', true );
		$img_position = get_term_meta( $term->term_id, 'tax_img_position', true );
		$content_position = get_term_meta( $term->term_id, 'tax_content_position', true );
		$masonry_order = get_term_meta( $term->term_id, 'category_masonry_order', true );
		$masonry_title_skin = get_term_meta( $term->term_id, 'category_info_skin', true );

		$html = '';
		$select_field_creator = new SelectField();
		$input_field_creator = new InputField();

		$img_size_options = array(
			'big' => esc_html__('Big', 'entre'),
			'small'   => esc_html__('Small', 'entre')
		);

		$img_position_options = array(
			'left' => esc_html__('Left', 'entre'),
			'right'   => esc_html__('Right', 'entre')
		);

		$content_options = array(
			'top-left' => esc_html__('Top Left', 'entre'),
			'top-right'   => esc_html__('Top Right', 'entre'),
			'bottom-left' => esc_html__('Bottom Left', 'entre'),
			'bottom-right'   => esc_html__('Bottom Right', 'entre'),
			'middle-right'   => esc_html__('Middle Right', 'entre'),
			'middle-left'   => esc_html__('Middle Left', 'entre'),
		);

		$skin_options = array(
			'' => esc_html__('Default', 'entre'),
			'light' => esc_html__('Light', 'entre'),
			'dark' => esc_html__('Dark', 'entre'),
		);

		ob_start();
		$select_field_creator->renderField('tax_img_size', esc_html__('Choose Image Size(for Floating Product Categories shortcode)' , 'entre'), $img_size_options, $img_size);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('tax_img_position', esc_html__('Choose Image Position(only if small image is choosen)(for Floating Product Categories shortcode)' , 'entre'), $img_position_options, $img_position);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('tax_content_position', esc_html__('Choose Content Position(for Floating Product Categories shortcode)' , 'entre'), $content_options, $content_position);
		$html .= ob_get_clean();

		ob_start();
		$select_field_creator->renderField('category_info_skin', esc_html__('Choose Item Info Skin(for Floating Product Categories shortcode)' , 'entre'), $skin_options, $masonry_title_skin);
		$html .= ob_get_clean();

		ob_start();
		$input_field_creator->renderField('category_masonry_order', esc_html__('Set Category Order in Shortcodes(for Floating Product Categories shortcode)' , 'entre'),$masonry_order);
		$html .= ob_get_clean();


		print entre_mikado_display_content_output($html);
	}

	add_action( 'product_cat_edit_form_fields', 'entre_mikado_woo_category_edit_meta_fields', 10, 2 );

}

if ( ! function_exists( 'entre_mikado_woo_category_save_meta_fields' ) ) {

	function entre_mikado_woo_category_save_meta_fieldss( $term_id, $taxonomy_id ) {

		if ( isset( $_POST ) ) {



			if(isset($_POST['tax_img_size'])){
				add_term_meta($term_id, 'tax_img_size', esc_attr($_POST['tax_img_size']), true );
			}

			if(isset($_POST['tax_img_position'])){
				add_term_meta($term_id, 'tax_img_position', esc_attr($_POST['tax_img_position']), true );
			}

			if ( isset($_POST['tax_content_position'])) {
				add_term_meta( $term_id, 'tax_content_position', esc_attr($_POST['tax_content_position']), true );
			}

			if ( isset($_POST['category_info_skin'])) {
				add_term_meta( $term_id, 'category_info_skin', esc_attr($_POST['category_info_skin']), true );
			}


			if ( isset($_POST['category_masonry_order'])) {
				add_term_meta( $term_id, 'category_masonry_order', esc_attr($_POST['category_masonry_order']), true );
			}
		}
	}

//	add_action( 'created_term', 'entre_mikado_woo_category_save_meta_fields', 10, 2 );

}

if ( ! function_exists( 'entre_mikado_woo_category_update_meta_fields' ) ) {
	/**
	 * Update listing location taxonomy meta field
	 *
	 * @param $term_id
	 * @param $taxonomy_id
	 */
	function entre_mikado_woo_category_update_meta_fields( $term_id, $taxonomy_id ) {

		if ( isset( $_POST ) ) {

			if(isset($_POST['tax_img_size'])){
				update_term_meta($term_id, 'tax_img_size', esc_attr($_POST['tax_img_size']));
			}

			if(isset($_POST['tax_img_position'])){
				update_term_meta($term_id, 'tax_img_position', esc_attr($_POST['tax_img_position']));
			}

			if ( isset($_POST['tax_content_position'])) {
				update_term_meta( $term_id, 'tax_content_position', esc_attr( $_POST['tax_content_position']) );
			}

			if ( isset($_POST['category_info_skin'])) {
				update_term_meta( $term_id, 'category_info_skin', esc_attr( $_POST['category_info_skin']) );
			}
			
			if ( isset($_POST['category_masonry_order'])) {
				update_term_meta( $term_id, 'category_masonry_order', esc_attr( $_POST['category_masonry_order']) );
			}

		}

	}

	add_action( 'edited_product_cat', 'entre_mikado_woo_category_update_meta_fields', 10, 2 );

}