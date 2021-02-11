<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="section">
    <div class="container small">

        <?php if ($order) : ?>

            <div class="bread-crumbs">
                <ul>
                    <li><a href="<?= site_url() ?>">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-thankyou-order-failed"><?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

        <?php else : ?>

            <script type="text/javascript">(function () {
                    if (window.addtocalendar)if (typeof window.addtocalendar.start == "function")return;
                    if (window.ifaddtocalendar == undefined) {
                        window.ifaddtocalendar = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript';
                        s.charset = 'UTF-8';
                        s.async = true;
                        s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://addtocalendar.com/atc/1.5/atc.min.js';
                        var h = d[g]('body')[0];
                        h.appendChild(s);
                    }
                })();
            </script>

            <div class="title">
                <h2>Congratulations!</h2>
            </div>

            <h3><?= get_field('checkout_thank_title') ?></h3>
            <?= get_field('checkout_thank_description') ?>

            <div class="buttons">
                <span class="addtocalendar atc-style-blue">
                    <?php
                    $order = wc_get_order($order->id);
                    foreach ($order->get_items() as $item_id => $item) {
                        $atc_title = $item['name'];
                        $product_id = $item['item_meta']['_product_id'][0];
                        $atc_description = custom_get_the_excerpt($product_id);
                        $variation_id = $item['item_meta']['_variation_id'][0];
                        $location_slug = $item['item_meta']['pa_location'][0];
                        $start_date = get_post_meta($variation_id, '_start_date', true);
                        $end_date = get_post_meta($variation_id, '_end_date', true);
                        $term = get_term_by('slug', $location_slug, 'pa_location');
                        $location = $term->name;
                        ?>
                        <var class="atc_event">
                            <var class="atc_date_start"><?= $start_date ?> 00:00:00</var>
                            <var class="atc_date_end"><?= $end_date ?> 20:00:00</var>
                            <var class="atc_timezone">UTC</var>
                            <var class="atc_title"><?= $atc_title ?></var>
                            <var class="atc_description"><?= $atc_description ?></var>
                            <var class="atc_location"><?= $location ?></var>
                            <var class="atc_organizer">Training Camp</var>
                            <var class="atc_organizer_email"><?= get_option('admin_email') ?></var>
                        </var>
                        <?php
                    }
                    ?>
                </span>
            </div>

        <?php endif; ?>

        <?php else : ?>

            <p class="woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'woocommerce'), null); ?></p>

        <?php endif; ?>

    </div>
</div>
