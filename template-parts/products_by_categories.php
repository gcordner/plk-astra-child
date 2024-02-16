<?php
/**
 * Products by Categories Block
 *
 * @package plk-child-theme
 */

$sub   = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );

$block_title     = $group['title'] ?? null;
$select_category = $group['select_category'] ?? null;
$select_products = $group['select_products'] ?? null;
$view_all_link   = $group['view_all_link']['url'] ?? null;

$class            = 'products';
$background_value = $group['background'];
if ( $background_value ) {
	$bg_class = 'background--warm-contrast section-padding-top--md section-padding-bottom--md';
} else {
	$bg_class = 'section-padding-top--md ';
}

$args = array(
	'post_type'   => 'product',
	'numberposts' => 8,
	'orderby'     => 'rand',
	'post_status' => 'publish',
	'tax_query'   => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $select_category, /*category name*/
			'operator' => 'IN',
		),
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array( 'outofstock' ),
			'operator' => 'NOT IN',
		),
	),
);
if ( $select_products ) {
	unset( $args['tax_query'] );
	$args['post__in'] = $select_products;
}
$products = get_posts( $args );

?>

<?php if ( $products ) : ?>
<section class="products section-margin <?php echo esc_html( $bg_class ); ?>">
	<div class="ast-container">
		<div class="container categories__container">
			<?php if ( $block_title ) : ?>
				<h2 class="heading-2 products__heading"><?php echo esc_html( $block_title ); ?></h2>
				<?php
			endif;
			if ( $view_all_link ) :
				?>
				<a class="btn--arrow link-reset products__link" href="<?php echo esc_url( $view_all_link ); ?>">
					<?php echo esc_html( $block_title ); ?><span class="icon-nav-arrow"></span>
				</a>
			<?php endif; ?>

			<!-- products below this line-->
			<div class="products__slider custom-navigation splide">
				<div class="products-container splide__track">
					<ul class="products__list list-reset splide__list" style="padding-top: 32px;">
						<?php
						foreach ( $products as $product ) {
							$post_object = get_post( $product->ID );
							setup_postdata( $post_object );
							echo '<li  class="splide__slide">';
							wc_get_template_part( 'content', 'product' );
							echo '</li>';
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;
wp_reset_postdata(); ?>
