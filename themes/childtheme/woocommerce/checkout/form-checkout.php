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

                <?php if (sizeof($checkout->checkout_fields) > 0) : ?>

                    <?php do_action('woocommerce_checkout_billing'); ?>

                <?php endif; ?>
                
                  <div class="title">
                    <h2><?= get_field('additional_information_title') ?></h2>
                    <?= get_field('additional_information_description') ?>
                </div>
                
                <div class="form-wrap billing_form_content">
                   <p class="form-row form-row form-row-first form-row-wide validate-required validate-required" id="additional_hear_about_field">
                    <input type="text" class="input-text form-control input-text" name="additional_hear_about" id="additional_hear_about" placeholder="How did you hear about us?*" value="<?= isset($_POST['additional_hear_about']) ? $_POST['additional_hear_about'] : ''; ?>">
                    <label for="additional_hear_about" class="">How did you hear about us?*</label></p>
		            <p class="form-row form-row form-row-last form-row-wide" id="additional_alumni_code_field">
                    <input type="text" class="input-text form-control input-text" name="additional_alumni_code" id="additional_alumni_code" placeholder="Alumni Advantage Code Number" value="<?= isset($_POST['additional_alumni_code']) ? $_POST['additional_alumni_code'] : ''; ?>">
                    <label for="additional_alumni_code" class="">Alumni Advantage Code Number</label></p>
                    
                     <p class="form-row form-row form-row-wide" style="margin-top:20px;" id="additional_billing_information_field"> 
                    <label style="font-size: medium;">Approving Manager Contact (For Enrollment Confirmation)</label>
                    </p>
                    
                     <p class="form-row form-row form-row-first form-row-wide validate-required validate-required" style="margin-top:20px;" id="additional_title_field">
                    <input type="text" class="input-text form-control input-text" name="additional_title" id="additional_title" placeholder="Title*" value="<?= isset($_POST['additional_title']) ? $_POST['additional_title'] : ''; ?>">
                    <label for="additional_title" class="">Title*</label></p>
                    <p class="form-row form-row form-row-last form-row-wide validate-required validate-required" style="margin-top:20px;" id="additional_name_field">
                    <input type="text" class="input-text form-control input-text" name="additional_name" id="additional_name" placeholder="Name*" value="<?= isset($_POST['additional_name']) ? $_POST['additional_name'] : ''; ?>">
                    <label for="additional_name" class="">Name*</label></p>
		            <p class="form-row form-row form-row-first form-row-wide validate-required validate-phone" style="margin-top:20px;" id="additional_phone_number">
                    <input type="text" class="input-text form-control input-text" name="additional_phone_number" id="additional_phone_number" placeholder="Phone Number*"  value="<?= isset($_POST['additional_phone_number']) ? $_POST['additional_phone_number'] : ''; ?>">
                    <label for="additional_phone_number" class="">Phone Number*</label></p>
                    <p class="form-row form-row form-row-last form-row-wide validate-required validate-email" id="additional_email">
                    <input type="text" class="input-text form-control input-text" name="additional_email" id="additional_email" placeholder="Email Address*" value="<?= isset($_POST['additional_email']) ? $_POST['additional_email'] : ''; ?>">
                    <label for="additional_email" class="">Email Address*</label></p>
                    <input type="hidden" name="training_payment_type" id="training_payment_type" value="<?= isset($_POST['payment_method']) ? $_POST['payment_method'] : ''; ?>">
                </div>

                <div class="title">
                    <h2><?= get_field('checkout_payment_title') ?></h2>
                    
                    <div style="display:inline-flex;">
                    <p style="margin-right:15px; margin-top:5px;">Pay Now</p>
                    <label class="switch">
                    <input type="checkbox" id="billing-slider">
                    <span class="slider round"></span>
                    </label>
                    </div>

                    <?= get_field('checkout_payment_description') ?>
                </div>        
                
                <div id="checkout-payment-container" style="display:none;">
                <?php action_before_checkout_form(); ?>
                <div class="tab-nav  custom-tab-nav custom-product-ul">
                <?php woocommerce_checkout_payment(); ?>  
                
                </div>
                </div>

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

