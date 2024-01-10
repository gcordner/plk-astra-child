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
?>

<?php if ( $big_image ) { ?>
	<section class="infoblock infoblock--reverse infoblock--more-image">
		<?php if ( $image ) { ?>
			<picture>
				<source media="(max-width: 500px)" srcset="<?php echo wp_get_attachment_image_url( $image['ID'], 'medium' ); ?>, <?php echo wp_get_attachment_image_url( $image['ID'], 'medium_large' ); ?> 2x">
				<?php
				$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
				echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
				?>
							</picture>
		<?php } ?>
		<div class="container">
			<div class="infoblock__wrapper">
				<?php if ( $block_title ) { ?>
					<h2 class="heading-2 infoblock__heading"><?php echo esc_html( $block_title ); ?></h2>
				<?php } ?>
				<?php echo str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption">', '<p class="text-large infoblock__caption">' ), $text ); ?>
			</div>
		</div>
	</section>
<?php } else { ?>
	<?php if ( ! $reverse ) { ?>
	<section class="infoblock <?php echo $mobile_image_down ? 'infoblock--about' : ''; ?> section-margin">
		<?php if ( $image ) { ?>
			<picture>
				<source media="(max-width: 500px)" srcset="<?php echo wp_get_attachment_image_url( $image['ID'], 'medium' ); ?>, <?php echo wp_get_attachment_image_url( $image['ID'], 'medium_large' ); ?> 2x">
				<?php
				$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
				echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
				?>
							</picture>
		<?php } ?>
		<?php if ( $small_image ) { ?>
			<div class="infoblock__parallax">
				<picture>
				<?php
				$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
				echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
				?>
								</picture>
			</div>
		<?php } ?>
		<div class="container">
			<div class="infoblock__wrapper">
				<?php if ( $block_title ) { ?>
					<h2 class="heading-2 infoblock__heading"><?php echo esc_html( $block_title ); ?></h2>
					<h3>Reverse should be False.</h3>
				<?php } ?>
				<?php echo str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption">', '<p class="text-large infoblock__caption">' ), $text ); ?>
				<?php
				if ( $btn_link ) {
					$a_link        = new Link( $btn_link );
					$a_link->class = 'btn btn--middle btn--primary infoblock__btn';
					echo $a_link->a();
				}
				?>
			</div>
		</div>
	</section>
	<?php } else { ?>
	<section class="aboutinfo section-padding">
		<div class="container">
			<div class="aboutinfo__wrapper section-padding-top">
				<div class="aboutinfo__text">
					<?php if ( $block_title ) { ?>
						<h2 class="heading-2 aboutinfo__heading"><?php echo esc_html( $block_title ); ?></h2>
						<h3>Reverse should be True.</h3>
					<?php } ?>
					<?php echo str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption aboutinfo__caption">', '<p class="text-large infoblock__caption aboutinfo__caption">' ), $text ); ?>
				</div>
				<?php if ( $image ) { ?>
					<picture class="aboutinfo__picture aboutinfo__image">
					<?php
					$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
					echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
					?>
					</picture>
				<?php } ?>
				<?php
				if ( $btn_link ) {
					$a_link        = new Link( $btn_link );
					$a_link->class = 'btn btn--middle btn--primary infoblock__btn';
					echo $a_link->a();
				}
				?>
			</div>
		</div>
	</section>
	<?php } ?>
<?php } ?>
