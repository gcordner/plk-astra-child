<?php
/**
 * Template Name: Page Builder
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra Child
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
</div><!-- closes ast-container div opened in header.php -->
	<div id="primary" <?php astra_primary_class(); ?>>
	<?php
	if ( $flexible = get_field( 'flexible' ) ) {
		foreach ( $flexible as $key => $flex ) {
			get_template_part( 'template-parts/' . $flex['acf_fc_layout'], '', array( 'group' => $flex[ $flex['acf_fc_layout'] ] ) );
		}
	}
	?>

		<?php astra_primary_content_top(); ?>
		<?php astra_content_page_loop(); ?>


		
	</div><!-- #primary -->

<!--BEGIN FOOTER -->
<div class="ast-container"><!-- new ast-container div -->
<?php get_footer(); ?>
