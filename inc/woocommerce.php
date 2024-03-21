<?php
/**
 * WooCommerce Compatibility File.
 *
 * @link https://woocommerce.com/
 *
 * @package PLK
 */

/**
 * Supports.
 */
function woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'woocommerce_setup' );


add_action( 'wp_ajax_woocommerce_ajax_total_cart_count', 'woocommerce_ajax_total_cart_count' );
add_action( 'wp_ajax_nopriv_woocommerce_ajax_total_cart_count', 'woocommerce_ajax_total_cart_count' );
/**
 * Dynamic Change Count In Cart.
 */
function woocommerce_ajax_total_cart_count() {
	// Using sprintf to format the string with WC()->cart object.
	$total_count = sprintf( __( '%s', 'woocommerce' ), WC()->cart->get_cart_contents_count() );
	echo esc_html( $total_count );
	die();
}


add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart' );
/**
 * Add to cart ajax.
 */
function woocommerce_ajax_add_to_cart() {

	$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( wp_unslash( $_POST['product_id'] ) ) );
	$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
	$product_status    = get_post_status( $product_id );
	$variation_id      = absint( wp_unslash( $_POST['variation_id'] ) );
	if ( ! empty( $variation_id ) ) {
		$product_id = absint( wp_unslash( $_POST['product_id_orig'] ) );
	}

	if ( $passed_validation && ( empty( $variation_id ) ? WC()->cart->add_to_cart( $product_id, $quantity ) : WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) ) && 'publish' === $product_status ) {

		do_action( 'woocommerce_ajax_added_to_cart', $product_id );

		if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
		}

		WC_AJAX::get_refreshed_fragments();
	} else {

		$data = array(
			'error'       => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
		);

		echo wp_json_encode( $data );
	}

	wp_die();
}


add_filter( 'woocommerce_product_tabs', 'my_remove_product_tabs', 98 );
/**
 * Remove product data tabs.
 *
 * @param array $tabs Product tabs.
 */
function my_remove_product_tabs( $tabs ) {
	unset( $tabs['additional_information'] ); // To remove the additional information tab.
	return $tabs;
}

// Remove actions.
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 ); // Removes loop price from archive pages.
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); // Removes sidebar from single product pages.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ); // Removes product title.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ); // Removes default woocommerce product rating.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 ); // Removes woocommerce single price from single product page.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ); // Removes woocommerce short description.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); // Removes variants, qty discount, and add-to-cart button from single page.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 ); // Removes the product SKU, tags, etc.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

// Add actions.
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 1 ); // Product title added below reviews (Note priority change).
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 ); // Adds woocommerce single price with new priority.
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); // Adds variants, qty discount, and add-to-cart button from single page.
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40 ); // Adds woocommerce short description.
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 5 ); // Adds the product SKU.


// Adds tooltip to woocommerce_single_product_summary.
add_action(
	'woocommerce_single_product_summary',
	function () {
		$custom_tooltips = get_field( 'custom_tooltips', 'option' );
		$html            = '';
		foreach ( $custom_tooltips as $key => $tooltip ) {
			$title           = $tooltip['title'] ?? null;
			$tooltip_content = $tooltip['tooltip_content'] ?? null;
			if ( $title ) {
				$html .= '<p class="text-middle product__shipping">' . str_replace( '<a', '<a class="product__shipping-link"', $title );
				if ( $tooltip_content ) {
					$html .= '<button class="product__question-icon" id="id_' . $key . '" aria-describedby="tooltip-id_' . $key . '">?</button>';
				}
				$html .= '</p>';
				if ( $tooltip_content ) {
					$html .= '<div class="product__tooltip" id="tooltip-id_' . $key . '" role="tooltip">';
					$html .= str_replace( '<p>', '<p class="product__tooltip-text">', $tooltip_content );
					$html .= '<div class="product__tooltip-arrow" data-popper-arrow></div>';
					$html .= '</div>';
				}
			}
		}

		echo $html;
	},
	35
);

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



add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
/**
 * Change Add To Cart Fragments.
 */
function iconic_cart_count_fragments( $fragments ) {
	$fragments['span.woo-cart-items-count'] = '<span class="header__nav-backet-count woo-cart-items-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	return $fragments;
}

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

/**
 * Change number of products that are displayed per page (shop page).
 * $cols contains the current number of products per page based on the value stored on Options –> Reading
 * Return the number of products you wanna show per page.
 */
function new_loop_shop_per_page( $cols ) {
	$cols = 24;
	return $cols;
}

// add_filter( 'woocommerce_single_product_image_thumbnail_html', 'custom_remove_product_link' );
// function custom_remove_product_link( $html ) {
// return strip_tags( $html, '<div><img>' );
// }

// Return Custom Fields Metabox.
add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

// Add New Track Action.
// add_filter( 'woocommerce_my_account_my_orders_actions', 'add_my_account_order_actions', 10, 2 );
// function add_my_account_order_actions( $actions, $order ) {
// $matrix              = array(
// 'USPS'  => 'https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1={number}',
// 'UPS'   => 'https://www.ups.com/track?loc=en_US&requester=ST/?trackingNumber={number}',
// 'FedEx' => 'https://www.fedex.com/fedextrack/?trknbr={number}',
// );
// $tracking_number_key = get_post_meta( $order->get_id(), 'routeapp_shipment_tracking_number', true );

// if ( $tracking_number_key ) {
// $shipping_method = $order->get_shipping_method();
// foreach ( $matrix as $key => $value ) {
// if ( stristr( $shipping_method, $key ) ) {
// $tracking_number_key       = trim( str_replace( array( '.', '-(Shipstation)' ), '', $tracking_number_key ) );
// $actions['shipping_track'] = array(
// 'url'  => str_replace( '{number}', $tracking_number_key, $value ),
// 'name' => $key . ' Track ',
// );
// }
// }
// }

// if ( ( strtotime( 'now' ) - strtotime( $order->get_date_created() ) ) <= 60 * 60 * 24 * 35 ) {
// $actions['file_a_claim'] = array(
// 'url'  => 'https://claims.route.com/',
// 'name' => 'File a Claim',
// );
// }
// return $actions;
// }
// remove menu link.
add_filter( 'woocommerce_account_menu_items', 'cwa_remove_my_account_dashboard' );
function cwa_remove_my_account_dashboard( $menu_links ) {

	unset( $menu_links['dashboard'] );
	return $menu_links;

}

// Add Write Review Functional To Order Item.
add_filter( 'woocommerce_display_item_meta', 'plk_woocommerce_display_item_meta_filter', 10, 3 );

function plk_woocommerce_display_item_meta_filter( $html, $item, $args ) {
	$review_link = add_query_arg( array( 'writeReview' => true ), get_permalink( $item->get_product_id() ) );
	$html       .= '<a class="product-write-review" href="' . $review_link . '">Write Review</a>';
	return $html;
}

// Custom Popup Payment Method.
add_action( 'wp_ajax_zelle_payment_info', 'zelle_payment_info' );
add_action( 'wp_ajax_nopriv_zelle_payment_info', 'zelle_payment_info' );
/**
 * Zelle payment method.
 */
function zelle_payment_info() {
	$order_number = $_POST['order_number'] ?? 'Not Set';
	echo '
        <p><span style="color: #282828;"><b><span style="font-size: 100%;" data-line-height="s"><span style="font-size: 140%;">Cash App<br /></span></span></b></span><span style="font-size: 100%;" data-line-height="s">(Use your credit card through the App with No Fees)</span></p>
        <p>CashTag: <strong>$pk91204</strong><br />Name: <strong>PKwholesale</strong></p>
        <p>For: <span style="color: #ff0000;">Enter <strong>ONLY</strong> your order number:<span style="color: #000000;"><strong> ' . $order_number . '</strong></span></span></p>
    ';
	die();
}

// Custom Checkout Filter.
add_action(
	'woocommerce_checkout_before_customer_details',
	function() {
		echo '<div class="checkout-wrapper checkout-wrapper__cart-checkout-form">';
	}
);

add_action(
	'woocommerce_checkout_before_order_review_heading',
	function() {
		echo '<div class="col2-set">';
	}
);

// add_action(
// 'woocommerce_checkout_after_order_review',
// function() {
// echo '</div>';
// echo '</div>';
// }
// );

add_action(
	'woocommerce_before_cart',
	function() {
		echo '<div class="cart_wrapper">';
	}
);

add_action(
	'woocommerce_after_cart',
	function() {
		echo '</div>';
	}
);

add_action(
	'woocommerce_after_single_product',
	function() {

		// Variable Products Only.
		global $product;
		if ( ! $product ) {
			return;
		}
		$product_id = $product->get_id();
		$terms      = get_the_terms( $product_id, 'product_tag' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( strpos( $term->slug, 'get-it-for-free' ) !== false ) {
					$link_name = get_field( 'link_name', $product_id );
					$link_url  = get_field( 'link_url', $product_id );
					$image     = get_field( 'autopopup', 'option' );
					?>
					<?php if ( ! empty( $link_name ) && ! empty( $link_url ) ) : ?>
		<style>#auto-popup{background:linear-gradient(121.47deg, #1FA009 0.83%, #0D7DBC 100.02%);}</style>
		<div id="auto-popup" class="popup auto-popup" data-popup="auto">
		<picture class="popup__image">
						<?php
						echo wp_get_attachment_image(
							$image['ID'],
							'medium_large',
							'',
							array(
								'alt'     => 'Limited Offer!',
								'loading' => 'lazy',
							)
						);
						?>
	</picture>
	<div class="popup__content">
			<div class="heading-2">Limited Offer!</div>
			<p>Purchase any special brand product and get this item for <span>FREE!</span></p>
			<p>Get the deal:</p>
			<ul>
			<li><a href="<?php echo $link_url; ?>"><?php echo $link_name; ?> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="15"><path fill="#FFE600" fill-rule="evenodd" d="m0 15 8.566-7.52L0 0l3.798 7.48L0 15Z" clip-rule="evenodd"/></svg></a></li>
			</ul>
		</div>
		<div class="note">*No exchange, no refund</div>
		</div>
	<?php endif; ?>
						<?php
				}
			}
		}
		// Inline jQuery.
		?>

<script>
jQuery( document ).ready( function( $ ) {
		<?php if ( $product->is_type( 'variable' ) ) : ?>
	jQuery(document).on('found_variation', '.variations_form', function( event, variation ) {
	  var qty = parseInt(jQuery('.variations_form input[name="quantity"]').val());
	  var prEl = jQuery('.product__info > .price');
	  jQuery('.variations_form').data('price',variation.display_price);
	  if(qty <= parseInt(variation.max_qty)){
		var total = Math.round(parseFloat(variation.display_price) * qty * 100) / 100;
		prEl.text('$'+total);
	  }
	  else{
		prEl.text('$'+variation.display_price);
	  }
	});
	jQuery(document).on('change', '.variations_form input[name="quantity"]', function() {
	  var price = jQuery('.variations_form').data('price');
	  var qty = parseInt(jQuery('.variations_form input[name="quantity"]').val());
	  var prEl = jQuery('.product__info > .price');
	  var total = Math.round(parseFloat(price) * qty * 100) / 100;
	  prEl.text('$'+total);
	});
	$( ".variations_form" ).on( "wc_variation_form woocommerce_update_variation_values", function() {

	  $( "label.generatedRadios" ).remove();
	  $( ".product__wrapper table.variations select" ).each( function() {
		var selName = $( this ).attr( "name" );
		$( "select[name=" + selName + "] option" ).each( function() {
			var option = $( this );
			var value = option.attr( "value" );
			if( value == "" ) {
				return;
			}
			var label = option.text();
			var select = option.parent();
			var selected = select.val();
			var isSelected = ( selected == value )
				? " checked=\"checked\"" : "";
			var selClass = ( selected == value )
				? " product__counts-item-btn--active" : "";
			var radHtml
				= `<input name="${selName}" type="radio" value="${value}" />`;
			var optionHtml
				= `<label class="btn btn--transparent btn--ultra-small product__counts-item product__counts-item-btn generatedRadios${selClass}">${radHtml} ${label}</label>`;
			select.parent().find('.product__counts-list').append(
				$( optionHtml ).click( function() {
					select.val( value ).trigger( "change" );
				} )
			)
		} ).parent().hide();
	  } );

	} );
  <?php else : ?>
	jQuery(document).on('change', '.cart input[name="quantity"]', function() {
	  <?php $regularPrice = get_post_meta( $product_id, '_regular_price', true ); ?>
	  var retailPrice = <?php echo $regularPrice; ?>;
	  <?php /*var price = jQuery('[property="product:price:amount"]').attr('content');*/ ?>
	  var qty = parseInt(jQuery('.cart input[name="quantity"]').val());
	  var prEl = jQuery('.product__info > .price bdi');
	  var total = Math.round(parseFloat(retailPrice) * qty * 100) / 100;
	  if(prEl) prEl.html('<span class="woocommerce-Price-currencySymbol">$</span>'+total);
	});
  <?php endif; ?>

} );
</script>
		<?php

	}
);

/**
 * Display price in variation options dropdown for products that have only one attribute.
 *
 * @param  string $term Existing option term value.
 * @return string $term Existing option term value or updated term value with price.
 */
function display_price_in_variation_options( $term ) {
	if ( is_admin() ) {
		return $term;
	}
	$product = wc_get_product( get_the_ID() );
	if ( ! $product ) {
		return $term;
	}
	$id = $product->get_id();
	if ( empty( $term ) || empty( $id ) ) {
		return $term;
	}
	if ( $product->is_type( 'variable' ) ) {
		$product_variations = $product->get_available_variations();
	} else {
		return $term;
	}
	foreach ( $product_variations as $variation ) {
		$caps_count = '';
		if ( count( $variation['attributes'] ) > 1 ) {
			return $term;
		}
		$attribute = array_values( $variation['attributes'] )[0];
		if ( stristr( $attribute, 'caps' ) ) {
			$caps_count = explode( ' ', $attribute )[0] ?? null ?: preg_replace( '/[^0-9]/', '', $attribute );
		}
		if ( $attribute === $term && $caps_count ?? null ) {
			$term .= '<span>' . strip_tags( wc_price( $variation['display_price'] / $caps_count ) ) . '</span>';
		}
	}

	return $term;
}
add_filter( 'woocommerce_variation_option_name', 'display_price_in_variation_options' );

function my__template_redirect() {
	if ( is_shop() ) {
		wp_redirect( site_url() . '/', '301' );
	}
}
add_action( 'template_redirect', 'my__template_redirect' );

add_filter(
	'subcategory_archive_thumbnail_size',
	function() {
		return 'medium';
	}
);

add_filter( 'get_post_metadata', 'get_alt_for_thumbs_flexslider', 10, 3 );
function get_alt_for_thumbs_flexslider( $value, $object_id, $meta_key ) {
	if ( '_wp_attachment_image_alt' === $meta_key && is_product() ) {
		return get_the_title();
	}

	return $value;
}

/**
 * Filter to change breadcrumb settings.
 *
 * @param  array $settings Breadcrumb Settings.
 * @return array $setting.
 */
add_filter(
	'rank_math/frontend/breadcrumb/settings',
	function( $settings ) {
		$settings = array(
			'home'           => true,
			'separator'      => '',
			'remove_title'   => '',
			'hide_tax_name'  => '',
			'show_ancestors' => '',
		);
		return $settings;
	}
);

// Disable Separator.
add_filter(
	'rank_math/frontend/breadcrumb/html',
	function( $html ) {
		return str_replace( array( '<span class="separator">', '</span>' ), array(), $html );
	}
);

/**
 * Signature Fee
 */

add_action( 'woocommerce_after_checkout_billing_form', 'signature_fee_checkbox' );
function signature_fee_checkbox( $checkout ) {
	echo '<div id="signature_fee_wrapper">';
	woocommerce_form_field(
		'signature_fee',
		array(
			'label' => 'Signature Fee: $4',
			'class' => array( 'signature_fee' ),
			'type'  => 'checkbox',
		),
		$checkout->get_value( 'signature_fee' )
	);
	echo '</div>';
}
add_action( 'wp_footer', 'signature_fee_ajax' );

function signature_fee_ajax() {
	if ( is_checkout() ) {
		?>
		<script type="text/javascript">
			const waitForJQuery = setInterval(function () {
				if (typeof jQuery !== 'undefined') {
					jQuery( document ).ready(
						function($) {
							$('#signature_fee').click(
								function() {
									jQuery('body').trigger('update_checkout');
								}
							);
						}
					);
					clearInterval(waitForJQuery)
				}
			}, 1500);
		</script>
		<?php
	}
}

function lab_pacakge_cost() {
	global $woocommerce;
	if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
		return;
	}
	if ( isset( $_POST['post_data'] ) ) {
		parse_str( $_POST['post_data'], $post_data );
	} else {
		$post_data = $_POST;
	}
	if ( isset( $post_data['signature_fee'] ) ) {
		$woocommerce->cart->add_fee( __( 'Signature Fee', 'om-service-widget' ), 4 );
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'lab_pacakge_cost' );

// Payment Method Get Shipstation.
add_filter( 'woocommerce_shipstation_export_custom_field_3', '__return_true' );
add_filter( 'woocommerce_shipstation_export_custom_field_3_value', 'woo_shipstation_custom_field_3_value', 10, 3 );
function woo_shipstation_custom_field_3_value( $value, $order_id ) {

	$pay_method = get_post_meta( $order_id, '_payment_method', true );
	return $pay_method;

}

/**
 * Schedule custom day event.
 *
 * @param  array $schedules Schedules.
 */
function isa_add_cron_recurrence_interval( $schedules ) {
	$schedules['every_day_morning'] = array(
		'interval' => 86400,
		'display'  => __( 'Every Morning', 'cn-core' ),
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'isa_add_cron_recurrence_interval' );

/**
 * Schedule custom day event. Initilization of cron hook.
 */
function cn_core_cron_init() {
	if ( ! wp_next_scheduled( 'cn_core_update_order_status' ) ) {
		wp_schedule_event( time(), 'every_day_morning', 'cn_core_update_order_status' );
	}
}
add_action( 'init', 'cn_core_cron_init' );


add_action( 'cn_core_update_order_status', 'cancel_unpaid_orders' );
/**
 * Schedule custom day event. Cancel unpaid orders. Will Fire a code while payment.
 */
function cancel_unpaid_orders() {
	$days_delay = 10; // <=== SET the delay (number of days to wait before cancelation)
	$one_day    = 24 * 60 * 60;
	$today      = strtotime( date( 'Y-m-d' ) );

	// Get unpaid orders (5 days old here).
	$unpaid_orders = (array) wc_get_orders(
		array(
			'limit'        => -1,
			'status'       => 'wc-pending',
			'date_created' => '<' . ( $today - ( $days_delay * $one_day ) ),
		)
	);
	// print_r($unpaid_orders); exit; phpcs:ignore Squiz.PHP.CommentedOutCode.Found.
	if ( sizeof( $unpaid_orders ) > 0 ) {
		$cancelled_text = __( 'The order was cancelled due to no payment from customer.', 'woocommerce' );

		// Loop through orders.
		foreach ( $unpaid_orders as $order ) {
			$order->update_status( 'cancelled', $cancelled_text );
		}
	}
}

add_filter( 'woocommerce_single_product_carousel_options', 'customslug_single_product_carousel_options', 99, 1 );
/**
 * WooCommerce Product Gallery Slider Options.
 *
 * @param array $options Gallery options.
 * @return array
 */
function customslug_single_product_carousel_options( $options ) {
	$options['slideshow']    = true;
	$options['directionNav'] = true;
	return $options;
}

add_filter( 'woocommerce_single_product_zoom_options', 'custom_single_product_zoom_options', 10, 3 );
/**
 * WooCommerce Product Gallery Zoom Options.
 *
 * @param array $zoom_options Zoom options.
 * @return array
 */
function custom_single_product_zoom_options( $zoom_options ) {
	$zoom_options['magnify'] = 0;
	return $zoom_options;
}

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

// Out Of Stock.
/**
 * WooCommerce Out Of Stock.
 *
 * @param string $posts_clauses Posts clauses.
 * @param string $query Query.
 * @return string
 */
function _nok_order_by_stock_status( $posts_clauses, $query ) {

	// only change query on WooCommerce loops.
	if ( ! is_admin() ) {
		if ( $query->is_main_query() && ( is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop() ) ) {
			global $wpdb;

			$posts_clauses['join'] .=
				" LEFT JOIN ( 
            SELECT post_id, meta_id, meta_value FROM $wpdb->postmeta 
            WHERE meta_key = '_stock_status' AND meta_value <> '' 
        ) istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";

			$posts_clauses['orderby'] =
				" CASE istockstatus.meta_value WHEN 
            'outofstock' THEN 1 
            ELSE 0 
        END ASC, " . $posts_clauses['orderby'];
		}
	}

	return $posts_clauses;
}
add_filter( 'posts_clauses', '_nok_order_by_stock_status', 2000, 2 );

// define the woocommerce_structured_data_breadcrumblist callback.
function custom_woocommerce_structured_data_breadcrumblist( $markup, $breadcrumbs ) {
	// custom code here.
	return '';
}

// add the action.
add_filter( 'woocommerce_structured_data_breadcrumblist', 'custom_woocommerce_structured_data_breadcrumblist', 10, 2 );

// Only USPS Pobox
// add_filter('woocommerce_package_rates', 'elex_hide_shipment', 10, 2);
// function elex_hide_shipment($available_shipping_methods, $package){
// if(isset($package['destination']) && isset($package['destination']['address'])  ){
// $replace = array( " ", ".", "," );
// $address = $package['destination']['address'];
// $address2 = $package['destination']['address_2'];
// $postcode = $package['destination']['postcode'];
// Replaced
// $address = strtolower( str_replace( $replace, '', $address ) );
// $address2 = strtolower( str_replace( $replace, '', $address2 ) );
// $postcode = strtolower( str_replace( $replace, '', $postcode ) );
//
// if ( strstr( $address, 'pobox' ) || strstr( $address2, 'pobox' ) || strstr( $postcode, 'pobox' ) ) {
// $available_shipping_methods_temp = $available_shipping_methods;
// foreach ($available_shipping_methods_temp as $shipping_method => $value) {
// if(isset($value->label) && is_string($value->label)){
// if(!is_int(stripos($value->label ,'USPS')) ){
// unset($available_shipping_methods[$shipping_method]);
// }
// }
// }
// }
// }
// return $available_shipping_methods;
// }

// Hooks near the bottom of profile page (if current user).
add_action( 'show_user_profile', 'custom_user_profile_fields' );

// Hooks near the bottom of the profile page (if not current user).
add_action( 'edit_user_profile', 'custom_user_profile_fields' );

// @param WP_User $user
function custom_user_profile_fields( $user ) {
	?>
	<table class="form-table">
		<tr>
			<th>
				<label for="code"><?php _e( 'Billing Wigzo Sms' ); ?></label>
			</th>
			<td>
				<input type="text" name="billing_wigzo_sms" id="billing_wigzo_sms" value="<?php echo esc_attr( get_the_author_meta( 'billing_wigzo_sms', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
	</table>
	<?php
}


// Hook is used to save custom fields that have been added to the WordPress profile page (if current user).
add_action( 'personal_options_update', 'update_extra_profile_fields' );

// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user).
add_action( 'edit_user_profile_update', 'update_extra_profile_fields' );

function update_extra_profile_fields( $user_id ) {
	if ( current_user_can( 'edit_user', $user_id ) ) {
		update_user_meta( $user_id, 'billing_wigzo_sms', $_POST['billing_wigzo_sms'] );
	}
}

/**
 * Change number of related products output
 */
function woo_related_products_limit() {
	global $product;
	$args['posts_per_page'] = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
/**
 * Modify the arguments for related products in WooCommerce.
 *
 * @param array $args Arguments for related products query.
 *
 * @return array Modified arguments for related products query.
 */
function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // limit to 4 related products.
	$args['columns']        = 2; // arrange in 2 columns.
	return $args;
}

// Remove some shipping & billing states.

// add_filter( 'woocommerce_states', 'custom_us_states', 10, 1 );
// function custom_us_states( $states ) {
// $non_allowed_us_states = array( 'AL', 'AR', 'IN', 'RI', 'TN', 'VT', 'WI');

// Loop through your non allowed us states and remove them
// foreach( $non_allowed_us_states as $state_code ) {
// if( isset($states['US'][$state_code]) )
// unset( $states['US'][$state_code] );
// }
// return $states;
// }

// Change Agy Template.
add_filter(
	'agy_accept_template',
	function() {
		return get_theme_file_path( '/inc/custom-templates/accept-age.php' );
	}
);

add_filter(
	'BeRocket_AAPF_template_full_content',
	function( $array ) {
		if ( $array['template']['content']['header']['tag'] ?? null ) {
			$array['template']['content']['header']['tag'] = 'div';
		}
		if ( $array['template']['content']['title']['tag'] ?? null ) {
			$array['template']['content']['title']['tag'] = 'div';
		}
		if ( $array['template']['content']['header']['content']['title']['tag'] ?? null ) {
			$array['template']['content']['header']['content']['title']['tag'] = 'div';
		}
		return $array;
	}
);

add_filter(
	'BeRocket_AAPF_template_full_element_content',
	function( $array ) {
		if ( $array['template']['content']['header']['tag'] ?? null ) {
			$array['template']['content']['header']['tag'] = 'div';
		}
		if ( $array['template']['content']['header']['content']['title']['tag'] ?? null ) {
			$array['template']['content']['header']['content']['title']['tag'] = 'div';
		}
		return $array;
	}
);

add_action( 'woocommerce_single_product_summary', 'pkt_show_product_categories', 60 );
/**
 * Retrieve the product categories.
 */
function pkt_show_product_categories() {
	global $product;

	$cat_list = wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' );
	if ( $cat_list ) {
		echo '<div class="product_meta__categories">' . wp_kses_post( $cat_list ) . '</div>';
	}
}

add_filter( 'woocommerce_product_categories_widget_args', 'pkt_alphabetical_category_order' );
add_filter( 'woocommerce_product_subcategories_args', 'pkt_alphabetical_category_order' );
/**
 * Sort product categories alphabetically.
 *
 * @param array $args Arguments for product categories query.
 *
 * @return array Modified arguments for product categories query with alphabetical order.
 */
function pkt_alphabetical_category_order( $args ) {
	$args['orderby'] = 'name';
	$args['order']   = 'asc';
	return $args;
}

/**
 * Change order status "processing" to "preparing shipment".
 *
 * @param array $statuses Array of order statuses.
 * @return array Modified array of order statuses.
 */
function plk_change_processing_order_status_label( $statuses ) {
	// Change the label for processing orders.
	$statuses['wc-processing'] = __( 'Preparing for Shipment', 'woocommerce' );
	return $statuses;
}
add_filter( 'wc_order_statuses', 'plk_change_processing_order_status_label' );

/**
 * Sets different shipping address as false for default
 */

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
/**
 * Add/remove products to/from sale category when sale price is set/deleted.
 */

add_action( 'woocommerce_before_product_object_save', 'plk_product_sale_category', 10, 1 );

/**
 * Add products to sale category when they have a sale price.
 * Remove products from sale category on save when they don't have a sale price.
 *
 * @param WC_Product $product The product object.
 */
function plk_product_sale_category( $product ) {
	$category_name = 'Sale'; // replace with your sale category name.
	$category_term = get_term_by( 'name', $category_name, 'product_cat' );
	$category_id   = $category_term->term_id;

	if ( $product->is_on_sale() ) {
		wp_set_object_terms( $product->get_id(), $category_id, 'product_cat', true );
	} else {
		wp_remove_object_terms( $product->get_id(), $category_id, 'product_cat' );
	}
}

/**
 * Create an Order Restricted user role
 */
function register_order_restricted_role() {
	add_role(
		'order_restricted',
		'Order Restricted',
		array(
			'read'                 => true,
			'edit_posts'           => false,
			'delete_posts'         => false,
			'edit_published_posts' => false,
			'publish_posts'        => false,
			'edit_shop_orders'     => false, // Restrict order management.
			'manage_woocommerce'   => false, // Restrict WooCommerce settings.
		)
	);
}
add_action( 'init', 'register_order_restricted_role' );

/**
 * Check if current user has "order_restricted" role and prevent order placement.
 */
function plk_prevent_order_restricted_place_order() {
	if ( current_user_can( 'order_restricted' ) ) {
		// Clear the cart.
		WC()->cart->empty_cart();

		// Redirect user to homepage.
		wp_safe_redirect( home_url() );
		exit;
	}
}
add_action( 'woocommerce_check_cart_items', 'plk_prevent_order_restricted_place_order' );

/**
 * Display JavaScript alert message on the homepage for restricted users.
 */
function plk_display_order_restricted_message() {
	if ( current_user_can( 'order_restricted' ) && is_front_page() ) {
		?>
		<script type="text/javascript">
			window.onload = function() {
				alert('You have been banned from placing orders on this site. For more information, please email support@paylesskratom.com');
			};
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'plk_display_order_restricted_message' );

/**
 * Restock items on cancelled cash-app orders.
 *
 * @param int    $order_id   ID of the order.
 * @param string $old_status Old status of the order.
 * @param string $new_status New status of the order.
 */
function plk_custom_restock_on_pending_to_cancelled( $order_id, $old_status, $new_status ) {
	// only proceed if the order's status is changing from 'pending' to 'cancelled'.
	if ( 'pending' === $old_status && 'cancelled' === $new_status ) {
		$order = wc_get_order( $order_id );
		foreach ( $order->get_items() as $item ) {
			$product = $item->get_product(); // Get the WC_Product object.
			$qty     = $item->get_quantity(); // Get the item quantity.
			if ( $product && $product->managing_stock() ) {
				$new_qty = $product->get_stock_quantity() + $qty;
				$product->set_stock_quantity( $new_qty );
				$product->save();
			}
		}
		$order->add_order_note( __( 'Stock levels for order items have been increased due to order cancellation.', 'woocommerce' ) );
	}
}
add_action( 'woocommerce_order_status_changed', 'plk_custom_restock_on_pending_to_cancelled', 10, 3 );


add_action( 'woocommerce_single_product_summary', 'show_quantity_in_stock', 10 );
/**
 * Show quantity in stock on product page if in Deals category.
 *
 * @return void
 */
function show_quantity_in_stock() {
	global $product;
	$stock_quantity = $product->get_stock_quantity();
	// Check if the product is in the "deals" category.
	if ( has_term( 'deals', 'product_cat', $product->get_id() ) ) {
		$stock_quantity = $product->get_stock_quantity();

		if ( '' !== $stock_quantity && $stock_quantity > 0 && $stock_quantity < 17 ) {

			echo '<div class="product__info-stock">';
			echo '<p>Only <span class="bold-stock"> ' . esc_html( $stock_quantity ) . ' deals left!</span></p>';
			echo '</div>';

		}
	}
}

