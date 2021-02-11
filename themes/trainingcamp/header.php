<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package trainingcamp
 */
global $woocommerce;
$contact_page_url = get_permalink(get_page_ID_by_page_template('templates/contact.php'));
$pricing_page_url = get_permalink(get_page_ID_by_page_template('templates/pricing.php'));
$cart_icon_class = (WC()->cart->cart_contents_count == 0) ? '' : 'filled-cart';
?><!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-dev">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="shortcut icon" href="<?php trainingcamp_images_uri('apple-icon.png') ?>" type="image/x-icon">
    <link rel="icon" href="<?= trainingcamp_images_uri('favicon.ico') ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= trainingcamp_images_uri('apple-icon.png') ?>"/>
    <meta content="telephone=no" name="format-detection">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_page( 'global-noreq-coursepricing' ) ) : ?>
        <meta name="robots" content="noindex">
    <?php endif; ?>
    <?php if ( is_page( 'learning' ) ) : ?>
        <meta name="robots" content="noindex">
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<body <?php //body_class(); ?>>

<main class="wrapper">

    <header class="header_">

        <div class="main-header">
            <strong class="logo" style="background-image: url('<?= trainingcamp_images_uri('logo.png') ?>');">
                <a href="<?= site_url() ?>">Training Camp</a>
            </strong>
            <div class="menu-btn"><span></span></div>
            <a href="https://www.trainingcamp.com/contact-us/" class="btn btn-blue contact-us">GET IN TOUCH</a>
            <div class="controls">
                <a href="javascript:void(0)" class="search-btn">
                    <?php get_template_part('template-parts/icons/icon', 'search') ?>
                </a>
		<?php $link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(); ?>
                <a href="<?= $link ?>" class="cart-btn <?= $cart_icon_class ?>">
                    <?php get_template_part('template-parts/icons/icon', 'cart') ?>
                </a>
            </div>
        </div>

        <div class="navigation">
            <nav class="main-nav">
                <?php
                $defaults = array(
                    'menu' => 'Primary header menu',
                    'container' => '',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'depth' => 0,
                    'items_wrap' => '<ul class="">%3$s</ul>',
                );
                wp_nav_menu($defaults);
                ?>
            </nav>

            <nav class="sub-nav">
                <?php
                $defaults = array(
                    'menu' => 'Secondary header menu',
                    'container' => '',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'depth' => 0,
                    'items_wrap' => '<ul class="">%3$s</ul>',
                );
                wp_nav_menu($defaults);
                ?>
            </nav>

            <?php if (get_field('phone', 'options')): ?>
                <a href="tel:<?= get_field('phone', 'options') ?>"
                   class="phone"><?= get_field('phone', 'options') ?></a>
            <?php endif; ?>

            <div class="controls">
                <a href="<?= $contact_page_url ?>" class="btn btn-blue contact-us">get in touch</a>
                <?php $signin_link = get_field('signin_link', 'options'); ?>
                <?php if ($signin_link): ?>
                    <a href="<?= $signin_link ?>" target="_blank" class="btn btn-white sign-in">sign in</a>
                <?php endif; ?>
            </div>
        </div>

    </header>


    <div class="search-panel">
        <span class="close-btn"></span>
        <div class="container">
            <form action="<?= site_url() ?>" method="get">
                <div class="form-wrap">
                    <div class="form-row form-row-wide large-input">
                        <input type="search" name="s" placeholder="search for something...">
                        <button type="submit"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php if (!is_front_page()): ?>
    <div class="page-wrap <?php if (is_checkout()) echo 'congrats' ?>">
<?php endif; ?>

