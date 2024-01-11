<?php
/**
 * Products by Categories Block
 *
 * @package plk-child-theme
 */

// Sub Init.
$sub           = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group         = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
// Sub Init Done.

$block_title     = $args['group']['title'] ?? null;
$select_category = $args['group']['select_category'] ?? null;
$select_products = $args['group']['select_products'] ?? null;
$view_all_link   = $args['group']['view_all_link']['url'] ?? null;

$class            = 'products';
$background_value = $args['group']['background'];
if ( 1 == $background_value ) {
	$bg_class = 'background--warm-contrast section-padding-top--md section-padding-bottom--md';
} else {
	$bg_class = 'section-margin';
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

<?php if ( $products ) { ?>
	<section class="categories section-margin section-margin-bottom <?php echo esc_html( $bg_class ); ?>">
		<div class="container categories__container">
			<?php if ( $block_title ) { ?>
				<h2 class="heading-2 products__heading"><?php echo esc_html( $block_title ); ?></h2>
				<?php
			}
			if ( $view_all_link ) {
				?>
<a class="btn--arrow link-reset products__link" href="<?php echo esc_url( $view_all_link ); ?>"><?php echo esc_html( $block_title ); ?><span class="icon-nav-arrow"></span></a>
<?php } ?>

<!-- products below this line-->
<div class="products__slider custom-navigation">
				<div class="swiper-container">
					<ul class="products__list list-reset swiper-wrapper">
						<?php
						$i = 0;foreach ( $products as $product ) {
							echo '<li style="width:25%; margin-right: 14px;" class="swiper-slide">';
								$post_object = get_post( $product->ID );
								setup_postdata( $GLOBALS['post'] =& $post_object );
								wc_get_template_part( 'content', 'product' );
							echo '</li>';
							$i++;
						}
						?>
					</ul>
					<div class="custom-navigation__button custom-navigation__button--next custom-navigation__button--next-capsules"><span class="icon-arrow-up"></span></div>
					<div class="custom-navigation__button custom-navigation__button--prev custom-navigation__button--prev-capsules"><span class="icon-arrow-up"></span></div>
				</div>
			</div>
		</div>
	</section>
<?php } wp_reset_postdata(); ?>