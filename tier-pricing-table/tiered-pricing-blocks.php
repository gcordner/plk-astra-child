<?php
/**
 * Tiered Pricing Table
 *
 * This overrides the plugin file.
 *
 * @see https://u2code.com/how-to-override-our-plugins-templates/
 * @package Tiered Pricing Table\Templates
 * @version 1.0.0
 */

use TierPricingTable\PriceManager;

if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Available variables
 *
 * @var array $price_rules
 * @var string $real_price
 * @var string $product_name
 * @var string $pricing_type
 * @var WC_Product $product
 * @var string $id
 * @var int $product_id
 * @var int $minimum
 * @var array $settings
 */
?>

<?php if ( ! empty( $price_rules ) ) : ?>

	<div class="tiered-pricing-wrapper">

		<?php if ( ! empty( $settings['title'] ) ) : ?>
			<h3 class="tiered-pricing-block__quantity-label" style="clear:both;"><?php echo esc_attr( $settings['title'] ); ?></h3>
		<?php endif; ?>

		<div class="tiered-pricing-blocks"
			id="<?php echo esc_attr( $id ); ?>"
			data-product-id="<?php echo esc_attr( $product_id ); ?>"
			data-price-rules="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $price_rules ) ) ); ?>"
			data-minimum="<?php echo esc_attr( $minimum ); ?>"
			data-product-name="<?php echo esc_attr( $product_name ); ?>"
			data-regular-price="<?php echo esc_attr( $product->get_regular_price() ); ?>"
			data-sale-price="<?php echo esc_attr( $product->get_sale_price() ); ?>"
			data-price="<?php echo esc_attr( $product->get_price() ); ?>"
			data-product-price-suffix="<?php echo esc_attr( $product->get_price_suffix() ); ?>"
		>

			<div class="tiered-pricing-block tiered-pricing--active"
				data-tiered-quantity="<?php echo esc_attr( $minimum ); ?>"
				data-tiered-price="
				<?php
				echo esc_attr(
					wc_get_price_to_display(
						wc_get_product( $product_id ),
						array(
							'price' => $real_price,
						)
					)
				);
				?>
				"
				data-tiered-price-exclude-taxes="
				<?php
				echo esc_attr(
					wc_get_price_excluding_tax(
						wc_get_product( $product_id ),
						array(
							'price' => $real_price,
						)
					)
				);
				?>
				"
				data-tiered-price-include-taxes="
				<?php
				echo esc_attr(
					wc_get_price_including_tax(
						wc_get_product( $product_id ),
						array(
							'price' => $real_price,
						)
					)
				);
				?>
			">
			<!--SINGLE ITEM BEGINS -->
				<span class="tiered-pricing-block__quantity quantity1">
						<?php if ( 1 >= array_keys( $price_rules )[0] - $minimum || 'static' === $settings['quantity_type'] ) : ?>
							<span><?php echo esc_attr( number_format_i18n( $minimum ) ); ?></span>

						<?php else : ?>
							<span><?php echo esc_attr( number_format_i18n( $minimum ) ); ?> - <?php echo esc_attr( number_format_i18n( array_keys( $price_rules )[0] - 1 ) ); ?></span>
						<?php endif; ?>
				</span>
				<div class="tiered-pricing-block__price-discount">
					<?php
					echo wp_kses_post(
						wc_price(
							wc_get_price_to_display(
								wc_get_product( $product_id ),
								array(
									'price' => $real_price,
								)
							)
						)
					);
					?>
				</div>
				<!--SINGLE ITEM ENDS -->
			</div>

			<?php $iterator = new ArrayIterator( $price_rules ); ?>

			<?php while ( $iterator->valid() ) : ?>
				<?php
				$current_price    = $iterator->current();
				$current_quantity = $iterator->key();

				if ( 'percentage' === $pricing_type ) {
					$discount_amount = $current_price;
				} else {
					$discount_amount = PriceManager::calculateDiscount( $real_price, $current_price );
				}

				$iterator->next();

				if ( $iterator->valid() ) {
					$quantity = $current_quantity;

					if ( intval( $iterator->key() - 1 !== $current_quantity ) ) {

						$quantity = number_format_i18n( $quantity );

						if ( 'range' === $settings['quantity_type'] ) {
							$quantity .= ' - ' . number_format_i18n( intval( $iterator->key() - 1 ) );
						}
					}
				} else {
					$quantity = sprintf( '%s+', number_format_i18n( $current_quantity ) );
				}

				/*
				Translators: %s qty of the product %s quantity measurement e.g., pieces
				 */

				$current_product_price = PriceManager::getPriceByRules( $current_quantity, $product_id );

				$current_product_price_exclude_taxes = wc_get_price_excluding_tax(
					wc_get_product( $product_id ),
					array(
						'price' => PriceManager::getPriceByRules( $current_quantity, $product_id, null, null, false ),
					)
				);

				$current_product_price_include_taxes = wc_get_price_including_tax(
					wc_get_product( $product_id ),
					array(
						'price' => PriceManager::getPriceByRules( $current_quantity, $product_id, null, null, false ),
					)
				);
				?>
<!-- THIS IS THE QUANTITY DISCOUNT BLOCK -->
				<div class="tiered-pricing-block"
					data-tiered-quantity="<?php echo esc_attr( $current_quantity ); ?>"
					data-tiered-price="<?php echo esc_attr( $current_product_price ); ?>"
					data-tiered-price-exclude-taxes="<?php echo esc_attr( $current_product_price_exclude_taxes ); ?>"
					data-tiered-price-include-taxes="<?php echo esc_attr( $current_product_price_include_taxes ); ?>">
					<span class="tiered-pricing-block__quantity quantity2"><?php echo esc_html( $quantity ); ?></span>
					<div class="tiered-pricing-block__price">
						<span  class="tiered-pricing-block__price-discount">
							<?php
							echo wp_kses_post(
								wc_price(
									PriceManager::getPriceByRules(
										$current_quantity,
										$product_id
									)
								)
							);
							?>
							<?php if ( $settings['show_discount_column'] ) : ?>
								<?php
								/* translators: %s: discount */
								echo esc_html( sprintf( __( ' (%d%%)', 'tier-pricing-table' ), round( $discount_amount, 2 ) ) );
								?>
						<?php endif; ?>
						</span>
					</div>
				</div>
<!-- END QUANTITY DISCOUNT BLOCK -->               
			<?php endwhile; ?>
		</div>
	</div>

	<style>
		<?php
		if ( $settings['clickable_rows'] ) {
			echo esc_attr( '#' . $id ) . ' .tiered-pricing-block {cursor: pointer; }';
		}
		?>

		<?php echo esc_attr( '#' . $id ); ?>
		.tiered-pricing--active {
			border-color: <?php echo esc_attr( $settings['active_tier_color'] ); ?> !important;
		}
	</style>
<?php endif; ?>
