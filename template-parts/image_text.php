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
		get_template_part(
			'template-parts/sub-templates/image_text',
			'picture',
			array(
				'image'       => $image,
				'block_title' => $block_title,
			)
		);
	endif;
	get_template_part(
		'template-parts/sub-templates/image_text',
		'container',
		array(
			'image'       => $image,
			'block_title' => $block_title,
			'text'        => $text,
			'btn_link'    => $btn_link,
		)
	);
	?>
	</section>
	<?php
else :
	if ( ! $reverse ) :
		?>
		<section class="infoblock <?php echo $mobile_image_down ? 'infoblock--about' : ''; ?> section-margin section-padding">
		<?php
		if ( $image ) :
			get_template_part(
				'template-parts/sub-templates/image_text',
				'picture',
				array(
					'image'       => $image,
					'block_title' => $block_title,
					'small_image' => $small_image,
				)
			);
		endif;
		get_template_part(
			'template-parts/sub-templates/image_text',
			'container',
			array(
				'image'       => $image,
				'block_title' => $block_title,
				'text'        => $text,
				'btn_link'    => $btn_link,
			)
		);
		?>
		</section>
		<?php
	else :
		?>
		<section class="aboutinfo section-padding">
			<div class="ast-container">
				<div class="container">
					<div class="aboutinfo__wrapper section-padding-top">
						<div class="aboutinfo__text">
							<?php
							if ( $block_title ) :
								?>
								<h2 class="heading-2 aboutinfo__heading"><?php echo esc_html( $block_title ); ?></h2>
								<h3>Reverse should be True.</h3>
							<?php
							endif;
							echo wp_kses_post( str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption aboutinfo__caption">', '<p class="text-large infoblock__caption aboutinfo__caption">' ), $text ) );
							if( !empty( $btn_link ) ):
								?>
								<a href="<?php echo esc_url( $btn_link['url'] ); ?>" class="btn btn--middle btn--primary infoblock__btn desktop"><?php echo esc_html( $btn_link['title'] ); ?></a>
							<?php
							endif;
							?>
						</div>
						<?php
						if ( $image ) :
							?>
							<picture class="aboutinfo__picture aboutinfo__image">
								<?php
								$alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
								echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
								?>
							</picture>
							<?php
						endif;
						if( !empty( $btn_link ) ):
							?>
							<a href="<?php echo esc_url( $btn_link['url'] ); ?>" class="btn btn--middle btn--primary infoblock__btn mobile"><?php echo esc_html( $btn_link['title'] ); ?></a>
						<?php
						endif;
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	endif;
endif;