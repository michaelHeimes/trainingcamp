<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<style>
    form.checkout fieldset {
        margin: 0;
        padding: 0;
        border: none !important;
    }
</style>

<?php /*if (is_user_logged_in()): */?>

    <div class="section">

        <div class="container">
            <div class="bread-crumbs">
                <ul>
                    <li><a href="<?= site_url() ?>">Home</a></li>
                    <li><?= get_the_title() ?></li>
                </ul>
            </div>


            <form name="checkout" method="post" class="checkout woocommerce-checkout"
                  action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                <div class="title">
                    <h2><?= get_field('checkout_billing_title') ?></h2>
                    <?= get_field('checkout_billing_description') ?>
                </div>

               <div class="form-wrap" style="margin-left: 150px; margin-bottom:50px; margin-right: 150px;">
    <p class="form-row form-row-first" id="billing_first_name_field">
        <span class="wpcf7-form-control-wrap your-name">
        <input  name="billing_first_name" id="billing_first_name" 
         type="text"  value="" size="40" 
        class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" 
         aria-required="true" aria-invalid="false" placeholder="Name*">
        <label for="billing_first_name">Name*</label></span>
    </p>
    <p class="form-row form-row-last" id="billing_email_field">
        <span class="wpcf7-form-control-wrap email-address">
        <input type="email" name="billing_email" value="" size="40"
         class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required 
         wpcf7-validates-as-email form-control" id="billing_email_field" aria-required="true"
          aria-invalid="false" placeholder="Email address*">
          <label for="billing_email">Email address*</label></span>
    </p>
    <p class="form-row form-row-first">
        <span class="wpcf7-form-control-wrap phone"><input type="text" name="phone" value="" size="40" class="wpcf7-form-control wpcf7-text form-control" id="phone" aria-invalid="false" placeholder="Phone"><label for="phone">Phone</label></span>
    </p>
    <p class="form-row form-row-last">
        <span class="wpcf7-form-control-wrap company">
        <input type="text" name="company" value="" size="40" 
        class="wpcf7-form-control wpcf7-text form-control" id="company" 
        aria-invalid="false" placeholder="Company Name"><label for="company">Company Name</label></span>
    </p>
    <p class="form-row form-row-first">
        <span class="wpcf7-form-control-wrap phone">
        <input type="text" name="company-phone" value="" size="40" 
        class="wpcf7-form-control wpcf7-text form-control" id="company-phone" aria-invalid="false" 
        placeholder="Company Phone"><label for="company-phone">Company Phone</label></span>
    </p>
    <p class="form-row form-row-last">
        <span class="wpcf7-form-control-wrap company">
        <input type="text" name="vender" value="" size="40"
         class="wpcf7-form-control wpcf7-text form-control" id="vender" aria-invalid="false" 
         placeholder="Vender Code"><label for="company">Vender Code</label></span>
    </p>
</div>

                <div class="title" style="margin-bottom:70px;">
                    <h2><?= get_field('checkout_payment_title') ?></h2>
                    <h3><?= get_field('checkout_payment_description') ?></h3>
                    <div>                
                    <div style="padding-top: 5px;padding-right:20px; width: 50%;text-align: end; float:left">
                    <p>Pay Now </p>
                    </div>
                    <div style="width: 50%;text-align: start; float:right">
                    <label class="switch">
                    <input type="checkbox" id="billing-slider">
                    <span class="slider round"></span>
                    </label>
                    </div>
                    </div>
                </div>            
                <div id="checkout-payment-container" style="display:none;">    
                <?php woocommerce_checkout_payment(); ?>
                </div>
                <!-- <div class="title">
                    <h2><?= get_field('checkout_signin_title') ?></h2>
                    <?= get_field('checkout_signin_description') ?>
                </div>

                <div class="payment_methods">
                        <div class="container">
                        <p class="form-row form-row-wide">
                                <input type="text" placeholder="Company Name" class="form-control" id="company_name"  name="company_name">
                                <label for="username">Company Name</label>
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="text" placeholder="Street Address" name="street_address" id="street_address" class="form-control">
                                <label for="street_address">Street Address</label>                        
                            </p>
                </div>
                </div> -->
                <div class="title">
                    <h2><?= get_field('checkout_review_title') ?></h2>
                    <?= get_field('checkout_review_description') ?>
                </div>

                <?php woocommerce_order_review(); ?>

            </form>
        </div>
    </div>

<?php /*else: */?>

    <?php /* ?>
    <div class="section forms">
        <div class="container">

            <div class="bread-crumbs">
                <ul>
                    <li><a href="<?= site_url() ?>">Home</a></li>
                    <li><?= get_the_title() ?></li>
                </ul>
            </div>

            <div class="title">
                <h2>01. checkout method</h2>
            </div>

            <div class="checkout-method">
                <div class="wrap">

                    <div class="part">
                        <form action="/" id="login-form">
                            <div>
                                <h3><?= get_field('checkout_signin_title') ?></h3>
                                <?= get_field('checkout_signin_description') ?>
                            </div>

                            <?php wp_nonce_field('ajax-login-nonce', 'form-login'); ?>

                            <p class="form-row form-row-wide">
                                <input type="email" placeholder="Email address*" class="form-control" id="username"  name="username" required>
                                <label for="username">Email address*</label>
                            </p>
                            <p class="form-row form-row-wide">
                                <input type="password" placeholder="Password*" name="password" id="password" class="form-control" required>
                                <label for="password">Password*</label>
                                <a class="forgot-pass" href="#forgot-pass-form">Forgot your password?</a>
                            </p>

                            <div class="buttons">
                                <button type="submit" class="btn btn-blue">Sign in</button>
                            </div>

                            <div class="status"></div>
                        </form>

                        <form name="lostpasswordform" id="forgot-pass-form">
                            <div class="form-wrap">
                                <?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>

                                <div class="message">
                                    <h3><?= get_field('checkout_lost_title') ?></h3>
                                    <?= get_field('checkout_lost_description') ?>
                                </div>

                                <p class="form-row form-row-wide">
                                    <input class="form-control" type="email" name="user_login" id="user_login" placeholder="Email address" required>
                                    <label for="user_login">Email address*</label>
                                    <a href="#login-form" class="back-to-login"><span class="arrow-left"></span>Back to login form</a>
                                </p>

                                <p class="buttons">
                                    <button type="submit" class="btn btn-blue">RESET PASSWORD</button>
                                </p>

                                <div class="status"></div>
                            </div>
                        </form>
                    </div>


                    <div class="part">
                        <div>
                            <h3><?= get_field('checkout_register_title') ?></h3>
                            <p><?= get_field('checkout_register_subtitle') ?></p>
                        </div>
                        <div class="content">
                            <?= get_field('checkout_register_description') ?>
                        </div>
                        <div class="buttons">
                            <a href="<?= add_query_arg( 'action', 'signup', get_permalink(get_page_ID_by_page_template('templates/pricing.php')) ); ?>" class="btn btn-blue">register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php */ ?>

<?php /*endif; */?>

