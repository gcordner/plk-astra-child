<?php
/**
 * Woocommerce Functions.
 *
 * @package PLK Child Theme
 * @since 1.0.0
 */

/**
 * Remove the reset variations button from the product page.
 */
function enqueue_custom_scripts() {
	?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var element = document.querySelector('.reset_variations');
			if (element) {
				element.parentNode.removeChild(element);
			}
		});
	</script>
	<?php
}

add_action( 'wp_footer', 'enqueue_custom_scripts' );


/**
 * Console log test function.
 */
function enqueue_woocommerce_log_script() {
	?>
	<script>
		console.log("inc/woocommerce.php loaded");
	</script>
	<?php
}

add_action( 'wp_footer', 'enqueue_woocommerce_log_script' );

// Hide Price Range for WooCommerce Variable Products.
add_filter( 'woocommerce_variable_sale_price_html', 'lw_variable_product_price', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'lw_variable_product_price', 10, 2 );
/**
 * WooCommerce Variable Product Price.
 *
 * @param string $v_price Variable price.
 * @param string $v_product Variable product.
 * @return string
 */
function lw_variable_product_price( $v_price, $v_product ) {
	if ( is_admin() ) {
		return $v_price;
	}

	// Product Price.
	$prod_prices = array(
		$v_product->get_variation_price( 'min', true ),
		$v_product->get_variation_price( 'max', true ),
	);
	$prod_price  = wc_price( $prod_prices[0] );

	// Regular Price.
	$regular_prices = array(
		$v_product->get_variation_regular_price( 'min', true ),
		$v_product->get_variation_regular_price( 'max', true ),
	);
	sort( $regular_prices );
	$regular_price = wc_price( $regular_prices[0] );

	if ( $prod_prices[0] !== $regular_prices[0] ) {
		$prod_price = '<del>' . $regular_price . $v_product->get_price_suffix() . '</del> <ins>' .
			$prod_price . $v_product->get_price_suffix() . '</ins>';
	}
	return 'Starting at: <br>' . $prod_price;
}
