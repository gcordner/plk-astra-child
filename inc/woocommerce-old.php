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

// Display the Woocommerce Discount Percentage on the Sale Badge for variable products and single products.
add_filter( 'woocommerce_sale_flash', 'display_percentage_on_sale_badge', 20, 3 );
function display_percentage_on_sale_badge( $html, $post, $product ) {
	$product_id = $product->get_id();
	$tags       = get_the_terms( $product_id, 'product_tag' );
	$badge      = '';
	if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
		foreach ( $tags as $tag ) {
			if ( stripos( $tag->name, 'badge:' ) !== false ) {
				$badge = '<div class="products__item-free">' . explode( ':', $tag->name )[1] . '</div>';
			}
		}
	}
	$html = '';
	if ( $product->is_on_sale() ) {
		if ( $product->is_type( 'variable' ) ) {
			$percentages = array();

			// This will get all the variation prices and loop throughout them.
			$prices = $product->get_variation_prices();

			foreach ( $prices['price'] as $key => $price ) {
				// Only on sale variations.
				if ( $prices['regular_price'][ $key ] !== $price ) {
					// Calculate and set in the array the percentage for each variation on sale.
					$percentages[] = round( 100 - ( floatval( $prices['sale_price'][ $key ] ) / floatval( $prices['regular_price'][ $key ] ) * 100 ) );
				}
			}
			// Displays maximum discount value.
			$percentage = max( $percentages ) . '%';

		} elseif ( $product->is_type( 'grouped' ) ) {
			$percentages = array();

			// This will get all the variation prices and loop throughout them.
			$children_ids = $product->get_children();

			foreach ( $children_ids as $child_id ) {
				$child_product = wc_get_product( $child_id );

				$regular_price = (float) $child_product->get_regular_price();
				$sale_price    = (float) $child_product->get_sale_price();

				if ( 0 !== $sale_price || ! empty( $sale_price ) ) {
					// Calculate and set in the array the percentage for each child on sale.
					$percentages[] = round( 100 - ( $sale_price / $regular_price * 100 ) );
				}
			}
			// Displays maximum discount value.
			$percentage = max( $percentages ) . '%';

		} else {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			if ( ( 0 !== $sale_price || ! empty( $sale_price ) ) && ( 0 !== $regular_price && ! empty( $regular_price ) ) ) {
				$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';
			} else {
				$html = '<div class="products__item-sale"><span class="onsale">Sale</span></div>';
			}
		}
		if ( empty( $html ) ) {
			$html = '<div class="products__item-sale"><span class="onsale">' . esc_html__( '-', 'woocommerce' ) . ' ' . $percentage . '</span></div>';
		}
	}
	return $badge . $html; // If needed then change or remove "up to -" text.
}