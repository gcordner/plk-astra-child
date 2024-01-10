<?php
/**
 * The template for displaying product category content in the catalog-about.php template.
 *
 * @package plk-child-theme
 */

// Sub Init.
$sub           = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group         = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
// Sub Init Done.

$content_title      = $args['group']['title'] ?? null;
$text               = $args['group']['text'] ?? null;
$image              = $args['group']['image'] ?? null;
$image_then_content = $args['group']['image_then_content'] ?? null;
$bottom_padding     = $args['group']['bottom_padding'] ?? null;
?>

<section class="catalog-about 
<?php
if ( ! $bottom_padding ) {
	echo ' catalog-about_without-bottom';}
?>
">
	<div class="container catalog-about__container">
	<div class="catalog-about__sub-sect">
		<div class="catalog-sub-about
		<?php
		if ( $image_then_content ) :
			?>
			catalog-sub-about_reversed<?php endif; ?>">
		<div class="catalog-sub-about__col-text formated-content">
			<?php if ( $content_title ) { ?>
				<h2 class="heading-2 catalog-sub-about__heading"><?php echo esc_html( $content_title ); ?></h2>
			<?php } ?>
			<?php if ( $text ) { ?>
			<div class="catalog-sub-about__text">
				<?php echo $text; ?>
			</div>
			<?php } ?>
		</div>
		<div class="catalog-sub-about__col-img">
			<div class="catalog-sub-about__wr-img">
			<picture>
				<?php echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $image['alt'] ?: $content_title ) ); ?>
			</picture>
			</div>
		</div>
	</div>
	</div>
</section>
