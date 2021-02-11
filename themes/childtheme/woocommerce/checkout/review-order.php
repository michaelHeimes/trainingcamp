<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

global $woocommerce;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="shop_table shop_table_responsive cart">
	<thead>
		<tr>
			<th class="product-name" ></th>
			<th class="product-quantity">Quantity</th>
			<th class="product-price">Price</th>
		</tr>
	</thead>
	<tbody>

		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="cart_item alt-table-row">

					<td class="product-name">
						<h3><?php echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key ); ?></h3>
						<?php
						$product_id=$cart_item['product_id'];
						$variation_id=$cart_item['variation_id'];
						$start_date=get_post_meta( $variation_id, '_start_date', true );
						$end_date=get_post_meta( $variation_id, '_end_date', true );

						$taxonomy_name='product_tag';
						$term_list = wp_get_post_terms($product_id, $taxonomy_name, array("all"));
						$term_not_nums = array();
						$terms_name=array();
						if (count($term_list) > 0) {
							$i = 0;
							foreach ($term_list as $current_term) {
								if ($current_term->parent != 42)
									$term_not_nums[] = $i;
								$i++;
							}
							foreach ($term_not_nums as $num) {
								unset($term_list[$num]);
							}

							foreach ($term_list as $current_term){
								$terms_name[]=$current_term->name;
							}
						}
						?>
						<table class="course-info">
							<thead>
							<tr>
								<th><span>Begin Date</span></th>
								<th><span>end Date</span></th>
								<!--  
								 <th><span>delivery format</span></th>
								-->
								<th><span>location</span></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td data-title="begin date"><time datetime="<?= $start_date  ?>"><?= $start_date  ?></time></td>
								<td data-title="end date"><time datetime="<?= $end_date  ?>"><?= $end_date  ?></time></td>
							<!-- 	<td data-title="delivery format">
									<?php if (is_array($terms_name) && count($terms_name) > 0): ?>
										<?php echo implode(',',$terms_name) ?>
									<?php endif; ?>
								</td>
								-->
								<td data-title="location">
									<?php //echo WC()->cart->get_item_data( $cart_item );// Meta data ?>
									<?php
									$variation = new WC_Product_Variation($cart_item['variation_id']);
									if ($variation){
										$var_names=array();
										foreach($variation->get_variation_attributes() as $name => $attr) {
											$name = substr($name, 10);
											$var_names[]= $variation->get_attribute($name);
										}
										echo implode('; ',$var_names);
									}
									?>
								</td>
							</tr>
							</tbody>
						</table>
					</td>

					<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

				</tr>
				<?php
			}
		}
		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
		<tr>
			<td colspan="3" class="actions">
				<a href="<?= $woocommerce->cart->get_cart_url() ?>" class="arrow-left">edit your order</a>
			</td>
		</tr>
	</tbody>
</table>

<div class="cart-collaterals">
	<div class="cart_totals calculated_shipping">
		<table class="shop_table shop_table_responsive">
			<tbody>
			<tr>
				<td class="addition">
					<p><?= get_field('checkout_notice') ?></p>
				</td>

				<td data-title="Subtotal" class="cart-subtotal">
					<span class="woocommerce-Price-amount amount"><?php wc_cart_totals_subtotal_html(); ?></span>
				</td>

				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<td data-title="Discount" class="discount"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
				<?php endforeach; ?>

				<td data-title="Total" class="order-total">
					<strong><span class="woocommerce-Price-amount amount"><?php wc_cart_totals_order_total_html(); ?></span></strong>
				</td>
			</tr>
			</tbody>
		</table>

		<div class="wc-proceed-to-checkout">
			<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="btn btn-blue checkout-button button alt wc-forward" name="woocommerce_checkout_place_order" id="place_order" value="Complete Order" data-value="Complete Order" />' ); ?>
		</div>

	</div>
</div>