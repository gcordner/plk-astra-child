<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs, the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$product = $args['product'] ?? null;
if ( $product ) {
	setup_postdata( $GLOBALS['post'] =& $product );
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$productId   = $product->get_id();
$tags        = get_the_terms( $productId, 'product_tag' );
$link        = $product->get_permalink();
$current_cat = get_queried_object();
?>

<div <?php wc_product_class( 'products__item category__products-item', $product ); ?>>
	<?php woocommerce_show_product_loop_sale_flash(); ?>
	<?php
	if ( $product->is_type( 'variable' ) && $current_cat->slug == 'free-offers' ) {
		$variations = $product->get_available_variations();
		foreach ( $variations as $key => $value ) {
			if ( stripos( $value['attributes']['attribute_count'], '1 kilo' ) !== false || stripos( $value['attributes']['attribute_capsule-count'], '500 caps' ) !== false || stripos( $value['attributes']['attribute_grams'], '1,000 grams (1 Kilo)' ) !== false ) {
				$link = get_permalink( $value['variation_id'] );
			}
		}
	}
	?>
	<a href="<?php echo $product->get_permalink(); ?>" rel="nofollow noopener" data-tags="
						<?php
						echo is_array( $tags ) ? implode(
							',',
							array_map(
								function( $tag ) {
									return $tag->name;
								},
								(array) $tags
							)
						) : '';
						?>
	">
		<?php $thumbnail_id = get_post_thumbnail_id( $productId ); ?>
		<picture class="products__item-image-wrapper">
			<source media="(max-width: 500px)" srcset="<?php echo wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ); ?>, <?php echo wp_get_attachment_image_url( $thumbnail_id, 'medium' ); ?> 2x">
			<?php echo woocommerce_get_product_thumbnail( 'woocommerce_thumbnail', array( 'alt' => $product->get_name() ) ); ?>
		</picture>
	</a>
	<div class="products__item-inner">
		<h3 class="heading-5 products__item-name">
			<a class="products__item-link" href="<?php echo $product->get_permalink(); ?>">
				<?php echo $product->get_name(); ?>
			</a>
		</h3>
		<div class="product__item-rating">
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>
	</div>
	<div class="products__item-prices">
		<?php woocommerce_template_loop_price(); ?>
	</div>
	<?php woocommerce_template_loop_add_to_cart(); ?>
</div>
<!--ZEPHYR 79-->
