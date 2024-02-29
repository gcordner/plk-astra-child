<?php
/**
 *
 * This file generates the single banner, double banner, and hero.
 *
 * @package PLK
 */

// Sub Init.
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
		?>
		">
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
					'alt'     => $image['alt'] ? $image['alt'] : ( $cat_title ? $cat_title : $image_alt ),
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
				$cat_title_promo = $cat_title . ' Promo';
				echo wp_get_attachment_image(
					$promo_image['ID'],
					'hero',
					'',
					array(
						'alt'     => $promo_image['alt'] ? $promo_image['alt'] : ( $cat_title_promo ? $cat_title_promo : $image_alt . ' Promo' ),
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
	<?php
endif;