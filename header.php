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
	<?php
	astra_header_before();

	astra_header();

	astra_header_after();

	astra_content_before();

	astra_content_top();
