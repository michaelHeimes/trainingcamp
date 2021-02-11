<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();
$shop_link_term_id = get_field('shop_link');
$shop_link = $shop_link_term_id ? get_term_link($shop_link_term_id) : '';
?>

<div class="section">
	<div class="container">

		<div class="bread-crumbs">
			<ul>
				<li><a href="<?= site_url() ?>">Home</a></li>
				<li><?= get_the_title() ?></li>
			</ul>
		</div>

		<div class="title">
			<h2><?= get_the_title() ?></h2>
		</div>
		<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<table class="shop_table shop_table_responsive cart">
				<thead>
					<tr>
						<th colspan="2" class="product-name"></th>
						<th class="product-quantity">Quantity</th>
						<th class="product-price">Price</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<tr class="cart_item alt-table-row">

								<td colspan="2" class="product-name" >
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
											<th><span>delivery format</span></th>
											<th><span>location</span></th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td data-title="begin date"><time datetime="<?= $start_date  ?>"><?= $start_date  ?></time></td>
											<td data-title="end date"><time datetime="<?= $end_date  ?>"><?= $end_date  ?></time></td>
											<td data-title="delivery format">
												<?php if (is_array($terms_name) && count($terms_name) > 0): ?>
													<?php echo implode(',',$terms_name) ?>
												<?php endif; ?>
											</td>
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
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											'min_value'   => '0'
										), $_product, false );
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
									?>
								</td>

								<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
									<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</td>

								<td class="product-remove">
									<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
									?>
								</td>

							</tr>
							<?php
						}
					}
					?>
					<tr>
						<td colspan="5" class="actions">

							<?php if ($shop_link): ?>
								<a href="<?= $shop_link ?>" class="arrow-left">ADD MORE COURSES</a>
							<?php endif; ?>

							<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />
							<?php if ( wc_coupons_enabled() ) { ?>
								<div class="coupon">
									<input type="checkbox" name="show_coupon" id="show_coupon">
									<label for="show_coupon">I HAVE A COUPON CODE</label>
									<div class="form-row form-row-wide">
										<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter a code', 'woocommerce' ); ?>" />
										<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>" />
									</div>

									<?php do_action( 'woocommerce_cart_coupon' ); ?>
								</div>
							<?php } ?>

							<?php do_action( 'woocommerce_cart_actions' ); ?>

							<?php wp_nonce_field( 'woocommerce-cart' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		<div class="cart-collaterals">
			<div class="cart_totals calculated_shipping">
				<table class="shop_table shop_table_responsive">
					<tbody>
						<tr>
							<td class="addition columns">
								<div class="col"><p><?= get_field('assistance_text') ?></p></div>
								<?php
								$phone = get_field('assistance_phone');
								if ($phone):
									?>
									<div class="col"><a href="tel:<?= $phone ?>"><?=$phone ?></a></div>
								<?php endif; ?>
							</td>

							<td data-title="Subtotal" class="discount">
								<span class="woocommerce-Price-amount amount"><?php wc_cart_totals_subtotal_html(); ?></span>
							</td>

							<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>

									<td data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>" class="discount"><?php wc_cart_totals_coupon_html($coupon); ?></td>

							<?php endforeach; ?>

							<td data-title="Total" class="discount order-total">
								<span class="woocommerce-Price-amount amount"><?php wc_cart_totals_order_total_html(); ?></span>
							</td>

						</tr>
					</tbody>
				</table>

				<div class="wc-proceed-to-checkout">
					<a href="<?php echo esc_url( wc_get_checkout_url() ) ;?>" class="checkout-button button alt wc-forward btn btn-blue">
						<?php echo __( 'Proceed to Checkout', 'woocommerce' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>