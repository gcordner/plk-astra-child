<?php
/**
 * Template part for image text flexible layout
 *
 * @package plk-child-theme
 */

$reverse           = $args['group']['reverse'] ?? null;
$big_image         = $args['group']['big_image'] ?? null;
$image             = $args['group']['image'] ?? null;
$small_image       = $args['group']['small_image'] ?? null;
$block_title       = $args['group']['title'] ?? null;
$text              = $args['group']['text'] ?? null;
$btn_link          = $args['group']['link'] ?? null;
$mobile_image_down = $args['group']['mobile_image_down'] ?? null;

if ( $big_image ) :
	?>
	<section class="infoblock infoblock--reverse infoblock--more-image">
	<?php
	if ( $image ) :
		?>
		<picture>
			<source 
				media="(max-width: 500px)" 
				srcset="
					<?php
					echo esc_url( wp_get_attachment_image_url( $image['ID'], 'medium' ) );
					?>
					,
					<?php
					echo esc_url( wp_get_attachment_image_url( $image['ID'], 'medium_large' ) );
					?>
					2x">
			<?php
			$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
			echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
			?>
		</picture>
		<?php
		endif;
	?>
		<div class="ast-container">
			<div class="container">
				<div class="infoblock__wrapper">
					<?php
					if ( $block_title ) :
						?>
						<h2 class="heading-2 infoblock__heading"><?php echo esc_html( $block_title ); ?></h2>
						<?php
					endif;
					echo esc_textarea( str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption">', '<p class="text-large infoblock__caption">' ), $text ) );
					?>
					<a href="<?php echo esc_url( $btn_link['url'] ); ?>" class="btn btn--primary"><?php echo esc_html( $btn_link['title'] ); ?></a>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;