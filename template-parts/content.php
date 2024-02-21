<?php
/**
 * Template part for category content flexible layout
 *
 * @package plk-child-theme
 */

// Sub Init.
$sub   = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );
// Sub Init Done.

$content_title = $group['title'] ?? null;
$text          = $group['text'] ?? null;
?>
<section class="kratom section-padding background--warm">
	<div class="container">
		<?php
		if ( $content_title ) {
			?>
			<h2 class="heading-2 kratom__header"><?php echo esc_html( $content_title ); ?></h2>
			<?php
		}
		if ( $text ) {
			?>
			<div class="kratom__wrapper">
				<?php echo wp_kses_post( str_replace( '<p>', '<p class="kratom__text text-medium">', $text ) ); ?>
			</div>
			<?php
		}
		?>
	</div>    
</section>

