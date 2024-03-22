<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

do_action( 'woocommerce_before_main_content' );

$term_object  = get_queried_object();
$term_vals    = get_term_meta( $term_object->term_id );
$dysplay_type = $term_vals['display_type'][0] ?? null;
$image        = get_field( 'hero_image', $term_object ) ?: get_field( 'default_archive_image', 'option' );

get_template_part(
	'template-parts/hero-type-three',
	'',
	array(
		'group' => array(
			'title'       => ! $term_object->description || ! stristr( $term_object->description, '<h1' ) ? 'Best Kratom ' . $term_object->name . ' For Sale' : '',
			'description' => $term_object->description,
			'type'        => 'type_3',
			'image'       => $image,
			'image_alt'   => $term_object->name,
		),
	)
)
?>
<section class="category <?php echo $dysplay_type == 'subcategories' ? 'category--brands' : ''; ?> section-padding">
	<div class="ast-container">
		<div class="container">
			<div class="category__wrapper">
				<?php if ( $dysplay_type != 'subcategories' ) { ?>
					<div class="category__filter">
						<?php dynamic_sidebar( 'wc_categories_sidebar' ); ?>
					</div>
				<?php } ?>
				<div class="category__products">
					<?php if ( $dysplay_type != 'subcategories' ) { ?>
						<div class="category__products-wrapper">
							<?php do_action( 'woocommerce_before_shop_loop' ); ?>
						</div>
					<?php } ?>
					<?php
					if ( woocommerce_product_loop() ) {
						woocommerce_product_loop_start();
						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();
								do_action( 'woocommerce_shop_loop' );
								wc_get_template_part( 'content', 'product-main' );
							}
						}
						woocommerce_product_loop_end();
						do_action( 'woocommerce_after_shop_loop' );
					} else {
						do_action( 'woocommerce_no_products_found' );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
if ( $flexible = get_field( 'flexible', $term_object ) ) {
	foreach ( $flexible as $flex ) {
		get_template_part( 'template-parts/' . $flex['acf_fc_layout'], '', array( 'group' => $flex[ $flex['acf_fc_layout'] ] ?? null ) );
	}
}
?>
<?php
get_footer( 'shop' );
