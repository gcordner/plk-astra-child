<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( is_product() ) {
	// Sub Init.
	$sub = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
	if ( ! $sub ) {
		?><link href="<?php echo esc_url( get_template_directory_uri() ); ?>/front/build/breadcrumb.css" rel="stylesheet">
		<?php
	}
	$group         = $sub ?? null ?: $args['group'] ?? null;
	$args['group'] = $group;
	// Sub Init Done.
	$color        = $args['group']['color'] ?? null;
	$custom_class = '';
	?>
	<?php
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs(
			array(
				'delimiter'   => '',
				'wrap_before' => '<section class="breadcrumb ' . $custom_class . '"><div class="container"><ul class="breadcrumb__list list-reset">',
				'wrap_after'  => '</ul></div></section>',
				'before'      => '<li class="breadcrumb__item text-small">',
				'after'       => '<template class="icon-arrow-up breadcrumb__item-icon"></template></li>',
			)
		);}
	?>
	<?php
} else {
	if ( ! empty( $breadcrumb ) ) {

		echo $wrap_before;

		foreach ( $breadcrumb as $key => $crumb ) {

			echo $before;

			if ( ! empty( $crumb[1] ) && count( $breadcrumb ) !== $key + 1 ) {
				echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
			} else {
				echo esc_html( $crumb[0] );
			}

			echo $after;

			if ( count( $breadcrumb ) !== $key + 1 ) {
				echo esc_html( $delimiter );
			}
		}

		echo $wrap_after;

	}
}
