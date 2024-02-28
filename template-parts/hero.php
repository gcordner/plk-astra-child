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

if ( 'type_1' === $hero_type ) :
	?>
	<section class="hero hero--warm hero--index
		<?php
		if ( ! $promo_image ) : 
			echo 'layout-hero is-preview'; 
		endif;
		if ( ! empty( $promo_wide ) ) :
			echo 'hero--wide';
		endif;
		?>"
		>
		<?php
		if ( $image ) :
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
		<?php
		else :
			?>
			<div class="hero__image"></div>
		<?php
		endif;
		
		if ( $promo_link ) :
			?>
			<a class="hero__promo-link" href="<?php echo esc_url( $promo_link ); ?>" aria-label="Promo Link">
			<?php if ( $promo_button_text ) { ?>
				<style>.hero__fake-btn:hover { color: #ffffff;}</style>
				<div class="hero__fake-btn"><?php echo esc_html( $promo_button_text ); ?></div>
			<?php } ?>
			</a>
		<?php
		endif;
		
		if ( $promo_image ) :
		?>
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
		<?php
		endif;
		
		if ( 1 === $enable_star ) :
		?>
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
		<?php
		endif;
		?>

		<div class="ast-container">
			<div class="container">
				<div class="hero__wrapper--text">
					<?php
					if ( $cat_title ) :
						?>
						<h1 class="heading-1 hero__heading"><?php echo esc_html( $cat_title ); ?></h1>
					<?php
					endif;
					if ( $subtitle ) :
					?>
						<p class="text-large hero__caption"><?php echo esc_html( $subtitle ); ?></p>
					<?php
					endif;
					do_action( 'paylesskratom_banners' );
					if ( $description ) :
					?>
						<p class="hero__caption"><?php echo esc_html( $description ); ?></p>
					<?php
					endif;
					?>
				</div>
			</div>
		</div>
</section>
<?php endif;