<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="format-detection" content="telephone=no">
	<?php
	$google_map_key = get_field( 'google_map_key', 'option' );
	if ( $google_map_key ) :
		?>
		<meta name="GOOGLE_API_KEY" content="<?php echo esc_html( $google_map_key ); ?>">
		<?php
	endif;
	?>
	<?php
	if ( apply_filters( 'astra_header_profile_gmpg_link', true ) ) {
		?>
		<link rel="profile" href="https://gmpg.org/xfn/11"> 
		<?php
	}

	wp_head();
	astra_head_bottom();
	?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<main 
<?php
echo esc_attr(
	astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site root',
		)
	)
);
?>
>
	<header class="header
	<?php
	if ( isset( $top_banner ) && $top_banner ) :
		echo ' bar-shown" style="--header-banner-height:45px';
	endif;
	?>
	">
	<?php
	if ( isset( $top_banner ) && $top_banner ) :
		?>
		<div class="header__banner">
			<div class="container">
				<div class="header__banner-text text-small text-reset"><?php echo esc_html( $top_banner ); ?></div><button class="header__banner-close" aria-label="Close Banner"></button>
			</div>
		</div>
		<?php
	endif;
	?>
	<div class="header__nav">
		<div class="ast-container">
			<div class="container">
				<div class="header__logo-link">
					<?php Astra_Builder_UI_Controller::render_site_identity( $device = 'desktop' );?>
				</div>

				<div class="header__nav-wrapper">
					<div class="header__nav-search mobile-hide">
						<?php aws_get_search_form( true ); ?>
					</div>
					<a class="btn btn--small btn--transparent header__nav-btn header__nav-private" href="/my-account/" aria-label="My Account">
						<?php
						if ( is_user_logged_in() ) :
							global $current_user;
							?>
							<span class="header__nav-btn-text">My Account</span>
							<?php
						else :
							?>
							<span class="header__nav-btn-text">Sign in</span>
							<?php
						endif;
						?>
						<span class="header__nav-btn-icon icon-private desktop-hide"></span>
					</a>
					<a class="btn btn--small btn--primary header__nav-btn header__nav-basket-btn" href="/cart/" aria-label="Cart Button">
						<?php $items_count = WC()->cart->get_cart_contents_count(); ?>
						<span class="header__nav-btn-text">Cart</span>
						<span class="header__nav-backet-count woo-cart-items-count"><?php echo esc_attr( $items_count ? $items_count : '0' ); ?></span>
						<span class="header__nav-btn-icon icon-basket"></span>
					</a>
					<button class="header__nav-burger desktop-hide" aria-label="NAV BURGER DELUXE">
						<span class="header__nav-burger-line header__nav-burger-line--top"></span>
						<span class="header__nav-burger-line header__nav-burger-line--bottom"></span>
					</button>
				</div>
			</div>
		</div>
	</div>