<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
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

        <p class="cart-empty">
            <?php _e('Your cart is currently empty.', 'woocommerce') ?>
        </p>

        <?php if ($shop_link): ?>
            <div class="actions"><a href="<?= $shop_link ?>" class="arrow-left">Return to shop</a></div>
        <?php endif; ?>

    </div>
</div>