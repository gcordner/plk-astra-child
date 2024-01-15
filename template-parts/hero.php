<?php
/**
 *
 * This file generates the single banner, double banner, and hero.
 *
 * @package PLK
 */

// Sub Init.
$sub = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
if ( ! $sub ) {
	?><link href="<?php echo esc_url( get_template_directory_uri() ); ?>/front/build/hero.css?ver=<?php echo esc_attr( '1.02' ); ?>" rel="stylesheet">
	<?php
}
$group         = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
// Sub Init Done.

$hero_type          = $args['group']['type'] ?? null;
$image              = $args['group']['image'] ?? null;
$bg_color           = $args['group']['bg_color'] ?? null;
$promo_wide         = $args['group']['promo_wide'] ?? null;
$promo_image        = $args['group']['promo_image'] ?? null;
$promo_link         = $args['group']['promo_link'] ?? null;
$promo_button_text  = $args['group']['promo_button_text'] ?? null;
$small_right_image  = $args['group']['small_right_image'] ?? null;
$small_bottom_image = $args['group']['small_bottom_image'] ?? null;
$enable_star        = $args['group']['enable_star'] ?? null;
$star_number        = $args['group']['star_number'] ?? null;
$star_text          = $args['group']['star_text'] ?? null;
$cat_title          = $args['group']['title'] ?? null;
$subtitle           = $args['group']['subtitle'] ?? null;
$description        = $args['group']['description'] ?? null;
$hero_link          = $args['group']['link'] ?? null;
$image_alt          = $args['group']['image_alt'] ?? null;
?>
<?php if ( ! empty( $bg_color ) ) : ?>
<style>.hero.hero--warm{background:<?php echo $bg_color; ?>}</style>
<?php endif; ?>
<style>.hero--wide.hero--index .hero__image{width:72%}.hero--wide.hero--index .hero__image img{object-fit:contain;object-position:right}@media (max-width: 768px){.hero--wide.hero--index .hero__image{width:100%;height:auto;margin-top:20px}}</style>

<?php
/** Define function to output styles for double image banners */
function double_image_styles() {
	?>
	<style>
		/* Style for hero image section */
		section.hero.hero--image.layout-hero {
			background: #fff;
			padding-bottom: 0px !important;
		}

		/* Style for hero image section on large screens */
		@media only screen and (min-width:1025px){
			section.hero.hero--image.layout-hero {
				margin-bottom: -60px !important;
			}
		}

		/* Style for banner images on small screens */
		@media only screen and (max-width:768px){
			.banner-images {
				flex-direction: column !important;
				max-height: none;
			}
		}

		/* Style for hero heading */
		.hero--image .hero__heading {
			color: #042825;
			font-size: 2.2rem;
		}

		@media only screen and (max-width:768px){
			.hero--image .hero__heading {
			font-size: 1.8rem;
		}
		}



		/* Style for hero caption */
		.hero--image .hero__caption {
			color: #042825;
			margin-top: 10px;
		}

		/* Style for breadcrumb links */
		.breadcrumb--category .breadcrumb__item a {
			color: #949494;
		}

		/* Style for header */
		header.header {
			border-bottom: 5px solid #fff4d2;
		}

		/* Style for breadcrumb arrow icon */
		span.icon-arrow-up.breadcrumb__item-icon {
			color: #949494 !important;
		}

		/* Reorder elements */
		.hero__wrapper--text {
			display: flex;
			flex-direction: column;
		}
		h1.heading-1.hero__heading {
			order: 1;
		}
		.hero__wrapper--text {
			max-width: none !important;
		}
		p.hero__caption {
			max-width: none !important;
		}
		.banner-images {
			order: 2;
			display: flex;
			flex-direction: row;
			width: 100%;
			gap: 25px;
		}
		.banner-images a {
			width: 100%;
		}
		.banner-images img {
			width: 100%;
			object-fit: contain;
		}
		p.hero__caption {
			order: 3;
		}
		/* Style for quantity discount text */
		span.qty-dis{
			color:#FF5800;
		}
		@media (max-width:768px) {
			.mobi-show {
			display:block;
		}
		.mobi-hide {
			display:none;
		}
		}

		@media (min-width:768px) {
			.mobi-show {
			display:none;
		}
		.mobi-hide {
			display:block;
		}
		}
		
		
		.fluffy {
			color: red;
		}
	</style>
	<?php
}

// Get current term and check if it has image banners.
$current_term = get_term( get_queried_object()->term_id );
$banner_type  = get_field( 'banner_type', $current_term );

if ( ( 'single banner' === $banner_type || 'double banner' === $banner_type ) ) {
	// Output styles for double image banners.
	double_image_styles();

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
?>


<?php if ( 'type_1' === $hero_type ) { ?>
<section class="hero hero--warm hero--index 
	<?php
	if ( ! $promo_image ) {
		?>
	layout-hero is-preview<?php } ?>
								  <?php // phpcs:ignore WordPress.WhiteSpace.PrecisionAlignment.Found
									if ( ! empty( $promo_wide ) ) {
										?>
	 hero--wide<?php } ?>">
	
	 
	<?php
	// if image exists, open a picture element with class "hero__image".
	if ( $image ) {
		?>
		<picture class="hero__image">
			<a href="<?php echo esc_url( $promo_link ); ?>">
			<source media="(max-width: 500px)" srcset="<?php echo esc_url( wp_get_attachment_image_url( $image['ID'], 'medium' ) ); ?>, <?php echo esc_url( wp_get_attachment_image_url( $image['ID'], 'woocommerce_single' ) ); ?> 2x">
			<?php
			echo wp_get_attachment_image(
				$image['ID'],
				'hero',
				'',
				array(
					'alt'     => $image['alt'] ?: $cat_title ?: $image_alt,
					'loading' => 'none',
				)
			);
			?>
			</a>
		</picture>
	<?php } else { ?>
		<div class="hero__image"></div>
	<?php } ?>
	<?php if ( $promo_link ) { ?>
		<a class="hero__promo-link" href="<?php echo esc_url( $promo_link ); ?>" aria-label="Promo Link">
		<?php if ( $promo_button_text ) { ?>
			<style>.hero__fake-btn:hover { color: #ffffff;}</style>
			<div class="hero__fake-btn"><?php echo esc_html( $promo_button_text ); ?></div>
		<?php } ?>
		</a>
	<?php } ?>
	<?php if ( $promo_image ) { ?>
			<picture class="hero__image-promo">
				<source media="(max-width: 500px)" srcset="<?php echo esc_url( wp_get_attachment_image_url( $promo_image['ID'], 'medium' ) ); ?>, <?php echo esc_url( wp_get_attachment_image_url( $promo_image['ID'], 'woocommerce_single' ) ); ?> 2x">
				<?php
				echo wp_get_attachment_image(
					$promo_image['ID'],
					'hero',
					'',
					array(
						'alt'     => $promo_image['alt'] ?: $cat_title . ' Promo' ?: $image_alt . ' Promo',
						'loading' => 'none',
					)
				);
				?>
			</picture>
	<?php } ?>





	<?php if ( 1 === $enable_star ) { ?>
		<div class="hero__stars">
			<picture><img src="<?php echo esc_url( get_template_directory_uri() ) . '/front/build/images/star.svg'; ?>" alt="star"></picture>
			<?php if ( $star_number ) { ?>
				<div class="hero__stars-text"><?php echo esc_html( $star_number ); ?>
					<?php if ( $star_text ) { ?>
						<span class="hero__stars-caption"><?php echo esc_html( $star_text ); ?></span>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>




	<div class="container">
		<div class="hero__wrapper--text">
			<?php if ( $cat_title ) { ?>
				<h1 class="heading-1 hero__heading"><?php echo esc_html( $cat_title ); ?></h1>
			<?php } ?>
			<?php if ( $subtitle ) { ?>
				<p class="text-large hero__caption"><?php echo esc_html( $subtitle ); ?></p>
			<?php } ?>
			<?php do_action( 'paylesskratom_banners' ); ?>
			<?php if ( $description ) { ?>
				<p class="hero__caption"><?php echo esc_html( $description ); ?></p>
			<?php } ?>
		</div>
	</div>
</section>
<?php } elseif ( 'type_2' === $hero_type ) { ?>
<section class="hero hero--no-image layout-hero is-preview">
	<div class="container">
		<div class="hero__wrapper--text">
			<?php if ( $cat_title ) { ?>
				<h1 class="heading-1 hero__heading"><?php echo esc_html( $cat_title ); ?></h1>
			<?php } ?>
			<?php do_action( 'paylesskratom_banners' ); ?>
			<?php if ( $subtitle ) { ?>
				<p class="text-large hero__caption"><?php echo esc_html( $subtitle ); ?></p>
			<?php } ?>
		</div>
		<?php if ( $image ) { ?>
			<div class="hero__wrapper-parallax">
				<picture class="hero__wrapper-image--parallax image-parallax">
					<source media="(max-width: 500px)" srcset="<?php echo esc_url( wp_get_attachment_image_url( $image['ID'], 'medium' ) ); ?>, <?php echo esc_url( wp_get_attachment_image_url( $image['ID'], 'woocommerce_single' ) ); ?> 2x">
					<?php
					echo wp_get_attachment_image(
						$image['ID'],
						'hero',
						'',
						array(
							'alt'     => $image['alt'] ?: $cat_title ?: $image_alt,
							'loading' => 'none',
						)
					);
					?>
				</picture>
			</div>
		<?php } ?>
		<?php if ( $small_bottom_image ) { ?>
			<picture class="hero__wrapper-image">
				<?php
				echo wp_get_attachment_image(
					$small_bottom_image['ID'],
					'medium_large',
					'',
					array(
						'alt'     => $small_bottom_image['alt'] ?: $cat_title,
						'loading' => 'none',
					)
				);
				?>
			</picture>
		<?php } ?>
		<?php if ( $small_right_image ) { ?>
			<div class="hero__wrapper-parallax--right">
				<picture class="hero__wrapper-image--parallax-right">
					<?php
					echo wp_get_attachment_image(
						$small_right_image['ID'],
						'medium_large',
						'',
						array(
							'alt'     => $small_right_image['alt'] ?: $cat_title,
							'loading' => 'none',
						)
					);
					?>
				</picture>
			</div>
		<?php } ?>
	</div>
</section>


	<?php
} elseif ( 'type_3' === $hero_type ) {
	;
	?>

<!-- SINGLE BANNER -->
	<?php if ( 'single banner' === $banner_type ) { ?>
	<section class="hero hero--image layout-hero is-preview">
		<div class="container">
			<div class="hero__wrapper--text">
				<?php if ( $cat_title ) { ?>
					<h1 class="heading-1 hero__heading"><?php echo esc_html( $cat_title ); ?></h1>
				<?php } ?>
				<?php if ( $description ) { ?>
					<?php
					$description_filtered = apply_filters( 'the_content', $description );
					$description_filtered = str_replace(
						array( '<p>', '<h1>' ),
						array( '<p class="hero__caption">', '<h1 class="heading-1 hero__heading">' ),
						$description_filtered
					);
					echo wp_kses_post( $description_filtered );
					?>
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
<?php } elseif ( 'double banner' === $banner_type ) { ?>
	<!--START DBL BANNER. -->
		<section class="hero hero--image layout-hero is-preview">
	<div class="container">
		<div class="hero__wrapper--text">
			<?php if ( isset( $title ) && $title ) { ?>
				<h1 class="heading-1 hero__heading"><?php echo esc_html( $title ); ?></h1>
			<?php } ?>
			<?php if ( isset( $description ) && $description ) { ?>
				<?php echo str_replace( array( '<p>', '<h1>' ), array( '<p class="hero__caption">', '<h1 class="heading-1 hero__heading">' ), apply_filters( 'the_content', $description ) ); ?>
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
		<?php } else { ?>
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
				<?php if ( $title ) { ?>
				<h1 class="heading-1 hero__heading"><?php echo esc_html( $title ); ?></h1>
			<?php } ?>
				<?php if ( $description ) { ?>
					<?php echo str_replace( array( '<p>', '<h1>' ), array( '<p class="hero__caption">', '<h1 class="heading-1 hero__heading">' ), apply_filters( 'the_content', $description ) ); ?>
			<?php } ?>
				<?php do_action( 'paylesskratom_banners' ); ?>
		</div>
	</div>
</section>
<!--HERO ENDS -->
				<?php } ?>






<?php } ?>
