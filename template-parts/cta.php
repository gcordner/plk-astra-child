<?php
/**
 * CTA Block
 *
 * @package plk-child-theme
 */

$sub   = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );

$image          = $group['image'] ?? null;
$cta_title      = $group['title'] ?? null;
$subtitle       = $group['subtitle'] ?? null;
$view_link      = $group['link'] ?? null;
$bottom_content = $group['bottom_content'] ?? null;
$color          = $group['color'] ?? null;
$padding_top    = $group['padding_top'] ?? null;
?>
<section class="cta-block <?php echo ( isset( $padding_top ) ? 'section-padding' : 'section-padding-bottom' ); ?> <?php echo esc_html( $color ); ?>">
	<div class="ast-container">    
		<div class="container">
			<div class="cta-block__wrapper section-padding">
				<?php
				if ( $image ) :
					?>
					<picture class="cta-block__cta">
						<?php echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $image['alt'] ?? $cta_title ) ); ?>
					</picture>
					<?php
				endif;
				if ( $cta_title ) :
					?>
					<h2 class="heading-2 cta-block__heading"><?php echo esc_html( $cta_title ); ?></h2>
					<?php
				endif;
				if ( $subtitle ) :
					?>
					<h3 class="heading-3 cta-block__subheading"><?php echo esc_html( $subtitle ); ?></h4>
					<?php
				endif;
				if ( $view_link ) :
					$link_title = $view_link['title'] ?? '';
					$link_href  = $view_link['url'] ?? '';
					?>
					<div class="cta-block__btn-wrapper">
						<a href="<?php echo esc_html( $link_href ); ?>" class="btn btn--middle btn--primary">
							<?php echo esc_html( $link_title ); ?>
						</a>
					</div>
					<?php
				endif;
				?>
			</div>
			<?php
			if ( $bottom_content ) :
				?>
				<div class="info-cta__disclosure">
					<?php echo wp_kses_post( $bottom_content ); ?>
				</div>
				<?php
			endif;
			?>
		</div>
		</div>
</section>
