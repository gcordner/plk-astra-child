<?php
/**
 * About block.
 *
 * @package PLK
 */

/**
 * Function to determine alt text.
 *
 * @param [type] $image The image data.
 * @param [type] $default The default alt text.
 * @return string
 */
function get_image_alt_text( $image, $default ) {
	if ( ! empty( $image['alt'] ) ) {
		return $image['alt'];
	}
	return $default;
}
// Sub Init.
$sub = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
if ( $sub ) {
	$group = $sub;
} else {
	$group = $args['group'] ?? null;
}
// Sub Init Done.

$layout_title = $group['title'] ?? null;
$subtitle     = $group['subtitle'] ?? null;
$big_image    = $group['big_image'] ?? null;
$small_image  = $group['small_image'] ?? null;
$right_image  = $group['right_image'] ?? null;
$content      = $group['content'] ?? null;
$layout_link  = $group['link'] ?? null;
?>
<section class="about background--warm-contrast section-padding">
	<div class="ast-container">
		<div class="container">
			<div class="about__wrapper--large">
				<?php if ( $layout_title ) : ?>
					<h2 class="heading-2"><?php echo esc_html( $layout_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $subtitle ) : ?>
					<p class="about__caption"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<div class="about__wrapper-image">
					<?php if ( $big_image ) : ?>
						<picture class="about__image">
							<source media="(max-width: 500px)" srcset="<?php echo esc_url( wp_get_attachment_image_url( $big_image['ID'], 'medium' ) ); ?>, <?php echo esc_url( wp_get_attachment_image_url( $big_image['ID'], 'medium_large' ) ); ?> 2x">
							<?php echo wp_get_attachment_image( $big_image['ID'], 'large', '', array( 'alt' => get_image_alt_text( $big_image, $layout_title ) ) ); ?>
						</picture>
					<?php endif; ?>
					<?php if ( $small_image ) : ?>
						<picture class="about__image--animated">
							<?php echo wp_get_attachment_image( $small_image['ID'], 'medium', '', array( 'alt' => get_image_alt_text( $small_image, $layout_title ) ) ); ?>
						</picture>
					<?php endif; ?>
				</div>
			</div>
			<div class="about__wrapper--small">
				<?php if ( $right_image ) : ?>
					<picture class="about__image">
						<?php echo wp_get_attachment_image( $right_image['ID'], 'medium_large', '', array( 'alt' => get_image_alt_text( $right_image, $layout_title ) ) ); ?>
					</picture>
				<?php endif; ?>
				<?php
				// Define the allowed HTML tags and their attributes for wp_kses().
				$allowed_html = array(
					'p' => array(
						'class' => array(),
					),
				);

				// Replace <p> tags with <p> tags that have specific classes, ensuring content is safely output.
				echo wp_kses( str_replace( '<p>', '<p class="about__caption about__caption--small">', $content ), $allowed_html );
				?>
				<?php
				if ( $content ) {
					$layout_link              = new Link( $layout_link );
					$layout_link->class       = 'btn--arrow link-reset about__btn';
					$layout_link->wrapper_end = '<span class="icon-nav-arrow"></span>';
					echo wp_kses(
						$layout_link->a(),
						array(
							'a'    => array(
								'href'  => array(),
								'class' => array(),
								'title' => array(),
							),
							'span' => array(
								'class' => array(),
							),
						)
					);
				}
				?>
			</div>
		</div>
	</div>
</section>
