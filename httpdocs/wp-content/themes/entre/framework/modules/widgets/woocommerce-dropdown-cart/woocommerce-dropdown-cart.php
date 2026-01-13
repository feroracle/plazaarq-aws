<?php
if ( class_exists( 'EntreCoreClassWidget' ) ) {
	
	class EntreMikadoWoocommerceDropdownCart extends EntreCoreClassWidget {
		public function __construct() {
			parent::__construct(
				'mkd_woocommerce_dropdown_cart',
				esc_html__( 'Mikado Woocommerce Cart', 'entre' ),
				array( 'description' => esc_html__( 'Display a shop cart icon with a dropdown that shows products that are in the cart', 'entre' ), )
			);
			
			$this->setParams();
		}
		
		protected function setParams() {
			
			$this->params = array(
				array(
					'type'        => 'textfield',
					'name'        => 'woocommerce_dropdown_cart_margin',
					'title'       => esc_html__( 'Icon Margin', 'entre' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'entre' )
				)
			);
		}
		
		public function widget( $args, $instance ) {
			extract( $args );
			
			global $woocommerce;
			
			$icon_styles = array();
			
			if ( $instance['woocommerce_dropdown_cart_margin'] !== '' ) {
				$icon_styles[] = 'padding: ' . $instance['woocommerce_dropdown_cart_margin'];
			}
			if(is_object(WC()->cart)){
			$cart_is_empty = sizeof( $woocommerce->cart->get_cart() ) <= 0;
			?>
			<div class="mkd-shopping-cart-holder" <?php entre_mikado_inline_style( $icon_styles ) ?>>
				<div class="mkd-shopping-cart-inner">
					<a class="mkd-header-cart" href="javascript:void(0)">
                    <span class="mkd-cart-icon lnr lnr-cart">
                        <span class="mkd-cart-number"><?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'entre' ), WC()->cart->cart_contents_count ); ?></span>
                    </span>
						<span class="mkd-cart-info">
				        <span class="mkd-cart-info-total"><?php echo '(' . wp_kses( $woocommerce->cart->get_cart_subtotal(), array(
							        'span' => array(
								        'class' => true,
								        'id'    => true
							        )
						        ) ) . ')'; ?></span>
			        </span>
					</a>
					<div class="mkd-shopping-cart-dropdown">
						<div class="mkd-shopping-cart-dropdown-top-info-holder">
							<a class="mkd-header-cart-close" href="#" target="_self">
								<?php echo entre_mikado_icon_collections()->renderIcon( 'lnr lnr-cross', 'linear_icons' ); ?>
							</a>
							<span class="mkd-shopping-cart-dropdown-text">
                            <?php esc_html_e( 'Your Cart', 'entre' ); ?>
                        </span>
							<span class="mkd-header-cart">
                            <span class="mkd-cart-icon lnr lnr-cart">
                                <span class="mkd-cart-number"><?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'entre' ), WC()->cart->cart_contents_count ); ?></span>
                            </span>
                            <span class="mkd-cart-info">
                                <span class="mkd-cart-info-total"><?php echo '(' . wp_kses( $woocommerce->cart->get_cart_subtotal(), array(
			                                'span' => array(
				                                'class' => true,
				                                'id'    => true
			                                )
		                                ) ) . ')'; ?></span>
                            </span>
                        </span>
						</div>
						<ul>
							<?php if ( ! $cart_is_empty ) : ?>
								<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :
									$_product = $cart_item['data'];
									// Only display if allowed
									if ( ! $_product->exists() || $cart_item['quantity'] == 0 ) {
										continue;
									}
									// Get price
									$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax( $_product ) : wc_get_price_including_tax( $_product );
									?>
									<li>
										<div class="mkd-item-image-holder">
											<a itemprop="url"
											   href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ); ?>">
												<?php echo wp_kses( $_product->get_image(), array(
													'img' => array(
														'src'    => true,
														'width'  => true,
														'height' => true,
														'class'  => true,
														'alt'    => true,
														'title'  => true,
														'id'     => true
													)
												) ); ?>
											</a>
										</div>
										<div class="mkd-item-info-holder">
											<h4 itemprop="name" class="mkd-product-title">
												<a itemprop="url"
												   href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ); ?>"><?php echo apply_filters( 'entre_mikado_woo_widget_cart_product_title', $_product->get_name(), $_product ); ?></a>
											</h4>
											<span class="mkd-quantity"><?php esc_html_e( 'Quantity: ', 'entre' );
												echo esc_html( $cart_item['quantity'] ); ?></span>
											<?php echo apply_filters( 'entre_mikado_woo_cart_item_price_html', wc_price( $product_price ), $cart_item, $cart_item_key ); ?>
											<?php echo apply_filters( 'entre_mikado_woo_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><span class="lnr lnr-cross"></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'entre' ) ), $cart_item_key );
											?>
										</div>
									</li>
								<?php endforeach; ?>
								<li class="mkd-cart-bottom">
									<div class="mkd-subtotal-holder clearfix">
										<span class="mkd-total"><?php esc_html_e( 'Total:', 'entre' ); ?></span>
										<span class="mkd-total-amount">
										<?php echo wp_kses( $woocommerce->cart->get_cart_subtotal(), array(
											'span' => array(
												'class' => true,
												'id'    => true
											)
										) ); ?>
									</span>
									</div>
									<div class="mkd-btn-holder clearfix">
										<a itemprop="url" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
										   class="mkd-view-cart"><?php esc_html_e( 'go to checkout', 'entre' ); ?></a>
									</div>
								</li>
							<?php else : ?>
								<li class="mkd-empty-cart"><?php esc_html_e( 'No products in the cart.', 'entre' ); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php }
		}
	}
}

add_filter('woocommerce_add_to_cart_fragments', 'entre_mikado_woocommerce_header_add_to_cart_fragment');

function entre_mikado_woocommerce_header_add_to_cart_fragment($fragments) {
    global $woocommerce;

    ob_start();

    $cart_is_empty = sizeof($woocommerce->cart->get_cart()) <= 0;
    ?>
    <div class="mkd-shopping-cart-inner">
        <a class="mkd-header-cart" href="javascript:void(0)">
            <span class="mkd-cart-icon lnr lnr-cart">
                <span class="mkd-cart-number"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'entre'), WC()->cart->cart_contents_count); ?></span>
            </span>
            <span class="mkd-cart-info">
                <span class="mkd-cart-info-total"><?php echo '(' . wp_kses($woocommerce->cart->get_cart_subtotal(), array('span' => array('class' => true, 'id' => true))) . ')'; ?></span>
            </span>
        </a>
        <div class="mkd-shopping-cart-dropdown">
            <div class="mkd-shopping-cart-dropdown-top-info-holder">
                <a class="mkd-header-cart-close" href="#" target="_self">
                    <?php echo entre_mikado_icon_collections()->renderIcon( 'lnr lnr-cross', 'linear_icons' ); ?>
                </a>
                <span class="mkd-shopping-cart-dropdown-text">
                    <?php esc_html_e('Your Cart', 'entre'); ?>
                </span>
                <span class="mkd-header-cart">
                    <span class="mkd-cart-icon lnr lnr-cart">
                        <span class="mkd-cart-number"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'entre'), WC()->cart->cart_contents_count); ?></span>
                    </span>
                    <span class="mkd-cart-info">
                        <span class="mkd-cart-info-total"><?php echo '(' . wp_kses($woocommerce->cart->get_cart_subtotal(), array('span' => array('class' => true, 'id' => true))) . ')'; ?></span>
                    </span>
                </span>
            </div>
            <ul>
                <?php if (!$cart_is_empty) : ?>
                    <?php foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
                        $_product = $cart_item['data'];
                        // Only display if allowed
                        if (!$_product->exists() || $cart_item['quantity'] == 0) {
                            continue;
                        }
                        // Get price
                        $product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
                        ?>
                        <li>
                            <div class="mkd-item-image-holder">
                                <a itemprop="url" href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
                                    <?php echo wp_kses($_product->get_image(), array(
                                        'img' => array(
                                            'src'    => true,
                                            'width'  => true,
                                            'height' => true,
                                            'class'  => true,
                                            'alt'    => true,
                                            'title'  => true,
                                            'id'     => true
                                        )
                                    )); ?>
                                </a>
                            </div>
                            <div class="mkd-item-info-holder">
                                <h4 itemprop="name" class="mkd-product-title">
	                                <a itemprop="url" href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>"><?php echo apply_filters('entre_mikado_woo_widget_cart_product_title', $_product->get_name(), $_product); ?></a>
                                </h4>
                                <span class="mkd-quantity"><?php esc_html_e('Quantity: ', 'entre'); echo esc_html($cart_item['quantity']); ?></span>
                                <?php echo apply_filters('entre_mikado_woo_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key); ?>
                                <?php echo apply_filters('entre_mikado_woo_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"><span class="lnr lnr-cross"></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__('Remove this item', 'entre')), $cart_item_key);  
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <li class="mkd-cart-bottom">
                        <div class="mkd-subtotal-holder clearfix">
                            <span class="mkd-total"><?php esc_html_e('Total:', 'entre'); ?></span>
                            <span class="mkd-total-amount">
								<?php echo wp_kses($woocommerce->cart->get_cart_subtotal(), array(
                                    'span' => array(
                                        'class' => true,
                                        'id'    => true
                                    )
                                )); ?>
							</span>
                        </div>
                        <div class="mkd-btn-holder clearfix">
                            <a itemprop="url" href="<?php echo esc_url(wc_get_cart_url()); ?>" class="mkd-view-cart"><?php esc_html_e('go to checkout', 'entre'); ?></a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="mkd-empty-cart"><?php esc_html_e('No products in the cart.', 'entre'); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <?php
    $fragments['div.mkd-shopping-cart-inner'] = ob_get_clean();

    return $fragments;
}

?>