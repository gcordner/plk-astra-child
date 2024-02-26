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
elseif ( ! $reverse ) :
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
else:

endif;