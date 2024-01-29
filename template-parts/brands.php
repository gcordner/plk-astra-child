<?php
/**
 * Brand block.
 *
 * @package PLK
 */

// Sub Init.
$sub = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ?? $args['group'] ?? null;
// Sub Init Done.

$block_title       = $args['group']['title'] ?? null;
$subtitle          = $args['group']['subtitle'] ?? null;
$select_categories = $args['group']['select_categories'] ?? null;
$view_all_link     = $args['group']['view_all_link'] ?? null;
?>
<section class="brand section-padding bg--gradient">
	<div class="container brand-wrapper">
		<?php if ( $block_title ) { ?>
			<h2 class="heading-2"><?php echo esc_html( $block_title ); ?></h2>
		<?php } ?>
		<?php if ( $subtitle ) { ?>
			<p class="brand__caption"><?php echo esc_html( $subtitle ); ?></p>
		<?php } ?>
		<?php if ( $select_categories ) { ?>
		<ul class="brand__list list-reset">
			<?php
			foreach ( $select_categories as $category ) {
				$block_term = get_term( $category, 'product_cat' );
				if ( ! $block_term || is_wp_error( $block_term ) ) {
					continue;
				}
				$thumb_id = get_term_meta( $block_term->term_id, 'thumbnail_id', true );
				?>
				<li class="brand__item">
					<a href="<?php echo esc_url( get_term_link( $block_term, 'product_cat' ) ); ?>">
						<?php if ( $thumb_id ) { ?>
							<picture>
								<?php echo wp_get_attachment_image( $thumb_id, 'woocommerce_thumbnail', '', array( 'alt' => $block_term->name ) ); ?>
							</picture>
						<?php } ?>
					</a>
				</li>
			<?php } ?>
		</ul>
		<?php } ?>
		<?php
		if ( $view_all_link ) {
			$category_link        = new Link( $view_all_link );
			$category_link->class = 'btn btn--middle btn--primary';
			echo wp_kses_post( $category_link->a() );
		}
		?>
	</div>
</section>
