<?php
/**
 *
 * This file generates the single banner, double banner, and hero.
 *
 * @package PLK
 */

// Sub Init.
$sub = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
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


<?php 
if ( 'type_1' === $hero_type ) {
	?>
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
<?php }