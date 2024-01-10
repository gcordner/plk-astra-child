<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>
<div class="woocommerce-product-details__short-description">
	<?php echo $short_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<div class="woocommerce-product-details__categories">
<?php
global $product;

if ( $product && ( $product instanceof WC_Product ) ) {
	$categories = wc_get_product_category_list( $product->get_id() );
	$tags       = wc_get_product_tag_list( $product->get_id() );
	if ( $categories ) {
		echo '<p>Categories: ',  wp_kses_post( $categories ), '</p>'; // This will output the product categories as a comma-separated list.

	}
}
?>
</div>
