<?php
/**
 *
 * This file generates the single banner, double banner, and hero.
 *
 * @package PLK
 */
$sub   = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );
// Sub Init Done.

$hero_type          = $group['type'] ?? null;
$image              = $group['image'] ?? null;
$promo_wide         = $group['promo_wide'] ?? null;
$promo_image        = $group['promo_image'] ?? null;
$promo_link         = $group['promo_link'] ?? null;
$promo_button_text  = $group['promo_button_text'] ?? null;
$enable_star        = $group['enable_star'] ?? null;
$star_number        = $group['star_number'] ?? null;
$star_text          = $group['star_text'] ?? null;
$cat_title          = $group['title'] ?? null;
$subtitle           = $group['subtitle'] ?? null;
$description        = $group['description'] ?? null;
$image_alt          = $group['image_alt'] ?? null;

$current_term = get_term( get_queried_object()->term_id );
$banner_type  = get_field( 'banner_type', $current_term );

if ( ( 'single banner' === $banner_type || 'double banner' === $banner_type ) ) {
	// Output styles for double image banners.
	// double_image_styles();

	// Get banner images and URLs and check for quantity discounts.
	$banner_image_1 = get_field( 'banner_image_1', $current_term );
	$banner_url_1   = get_field( 'banner_url_1', $current_term );
	$banner_image_2 = get_field( 'banner_image_2', $current_term );
	$banner_url_2   = get_field( 'banner_url_2', $current_term );
	$qty_dis        = get_field( 'quantity_discount', $current_term );
	$mobile_banner  = get_field( 'mobile_banner', $current_term );
	$desktop_banner = get_field( 'desktop_banner', $current_term );
	$banner_url     = get_field( 'banner_url', $current_term );


	// Add quantity discount text to description if available.
	if ( $qty_dis ) {
		$description = $description . "<span class='qty-dis'> Quantity Discount Available! (on most products)</span>";
	}
}

if ( 'single banner' === $banner_type ) {
	?>
<!-- SINGLE BANNER -->
	<section class="hero hero--image layout-hero is-preview">
		<div class="container">
			<div class="hero__wrapper--text">
				
				<?php if ( $description ) { ?>
					
										<?php if ( $mobile_banner ) : ?>
						<div class="banner-images mobi-show">
											<?php if ( $banner_url ) : ?>
							<a href="<?php echo esc_url( $banner_url ); ?>"><?php endif; ?>
								<img src="<?php echo esc_url( $mobile_banner['url'] ); ?>" alt="<?php echo esc_html( $mobile_banner['alt'] ); ?>">
											<?php if ( $banner_url ) : ?>
							</a><?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $desktop_banner ) : ?>
						<div class="banner-images mobi-hide">
						<?php if ( $banner_url ) : ?>
							<a href="<?php echo esc_url( $banner_url ); ?>"><?php endif; ?>
								<img src="<?php echo esc_url( $desktop_banner['url'] ); ?>" alt="<?php echo esc_html( $desktop_banner['alt'] ); ?>">
											<?php if ( $banner_url ) : ?>
							</a><?php endif; ?>
						</div>
					<?php endif; ?>
				<?php } ?>

				<?php do_action( 'paylesskratom_banners' ); ?>
			</div>
		</div>
	</section>
<!-- END SINGLE BANNER -->
<?php
} elseif ( 'double banner' === $banner_type ) {
	?>
<!--START DBL BANNER. -->
	<section class="hero hero--image layout-hero is-preview">
		<div class="container">
			<div class="hero__wrapper--text">
				
				<?php if ( isset( $description ) && $description ) { ?>
					
					<div class="banner-images">
						<?php if ( isset( $banner_image_1 ) && $banner_image_1 ) : ?>
							<?php if ( $banner_url_1 ) : ?>
							<a href="<?php echo esc_url( $banner_url_1 ); ?>"><?php endif; ?>
								<img src="<?php echo esc_url( $banner_image_1['url'] ); ?>" alt="<?php echo esc_html( $banner_image_1['alt'] ); ?>">
								<?php if ( $banner_url_1 ) : ?>
							</a>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( isset( $banner_image_2 ) && $banner_image_2 ) : ?>
							<?php if ( $banner_url_2 ) : ?>
							<a href="<?php echo esc_url( $banner_url_2 ); ?>"><?php endif; ?>
								<img src="<?php echo esc_url( $banner_image_2['url'] ); ?>" alt="<?php echo esc_html( $banner_image_2['alt'] ); ?>">
								<?php if ( $banner_url_2 ) : ?>
							</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php } ?>
				<?php do_action( 'paylesskratom_banners' ); ?>
			</div>
		</div>
	</section>
<!-- END DBL BANNER -->
<?php
} else {
	?>
<!-- IF BANNER SELECTION == NONE OR IS NULL, START HERO -->
	<section class="hero hero--image layout-hero is-preview">
	<?php if ( $image ) { ?>
		<picture class="hero__image">
			<?php
			echo wp_get_attachment_image(
				$image['ID'],
				'hero',
				'',
				array(
					'alt'     => $image['alt'] ?: $title ?: $image_alt,
					'loading' => 'none',
				)
			);
			?>
		</picture>
	<?php } ?>
		<div class="container">
			<div class="hero__wrapper--text">
					
					<?php do_action( 'paylesskratom_banners' ); ?>
			</div>
		</div>
	</section>
<!--HERO ENDS -->
<?php
}