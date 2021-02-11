<div class="container small">

    <div class="bread-crumbs">
        <ul>
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li><?= get_the_title() ?></li>
        </ul>
    </div>

    <div class="title">
        <h2><?= get_the_title() ?></h2>
    </div>

    <div class="tab-nav">
        <ul>
            <li class="<?php if(!isset($_GET['action']) || (isset($_GET['action']) && $_GET['action']!='signup')) echo 'active' ?>"><a href="#login-wrap">Returning Customers</a></li>
            <li class="<?php if(isset($_GET['action']) && $_GET['action']=='signup') echo 'active' ?>"><a href="#register-wrap">create account</a></li>
        </ul>
    </div>

    <div class="tab-content <?php if(!isset($_GET['action']) || (isset($_GET['action']) && $_GET['action']!='signup')) echo 'active' ?>" id="login-wrap">

        <form id="login-form">
            <div class="form-wrap">
                <?php wp_nonce_field('ajax-login-nonce', 'form-login'); ?>

                <p class="form-row form-row-wide">
                    <input type="email" id="login-email" class="form-control" placeholder="Email*" name="username" required>
                    <label for="login-email">Email*</label>
                </p>

                <p class="form-row form-row-wide">
                    <input type="password" id="login-password" class="form-control" name="password" placeholder="Password*" required>
                    <label for="login-password">Password*</label>
                    <a class="forgot-pass" href="#forgot-password">Forgot your password?</a>
                </p>

                <p class="form-row form-row-wide">
                    <input type="submit" class="btn btn-blue" value="sign in">
                </p>

                <div class="status"></div>
            </div>
        </form>

    </div>

    <div class="tab-content" id="forgot-password">

        <form name="lostpasswordform" id="lostpasswordform"  method="post">
            <div class="form-wrap">
                <div class="message">
                    <h3><?= get_field('form_forgot_title') ?></h3>
                    <?= get_field('form_forgot_description') ?>
                </div>

                <?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>

                <p class="form-row form-row-wide">
                    <input class="form-control" name="user_login" id="user_login" type="email" placeholder="Email address" required>
                    <label for="user_login">Email address*</label>
                </p>

                <p class="form-row form-row-wide">
                    <button type="submit" class="btn btn-blue">RESET PASSWORD</button>
                </p>

                <div class="status"></div>
            </div>
        </form>

    </div>


    <div class="tab-content <?php if(isset($_GET['action']) && $_GET['action']=='signup') echo ' active' ?>" id="register-wrap" <?php if(isset($_GET['action']) && $_GET['action']=='signup') echo 'style="display:block;"' ?>>
        <header>
            <h3><?= get_field('form_register_title') ?></h3>
            <?= get_field('form_register_description') ?>
        </header>

        <form id="registration_form">
            <div class="form-wrap">
                <?php wp_nonce_field('form_registration'); ?>
                <p class="form-row form-row-first">
                    <input type="text" id="first-name" class="form-control" name="first_name" placeholder="first name*" required>
                    <label for="first-name">first name*</label>
                </p>
                <p class="form-row form-row-last">
                    <input type="text" id="last-name" class="form-control" name="last_name" placeholder="Last Name*" required>
                    <label for="last-name">Last Name*</label>
                </p>

                <p class="form-row form-row-first">
                    <input type="email" id="email-address" class="form-control" name="user_email" placeholder="Email Address*" required>
                    <label for="email-address">Email Address*</label>
                </p>
                <p class="form-row form-row-last">
                    <input type="text" id="phone-number" class="form-control" name="billing_phone" placeholder="Phone Number">
                    <label for="phone-number">Phone Number</label>
                </p>

                <p class="form-row form-row-first">
                    <input type="password" id="user_pass" class="form-control" name="user_pass" placeholder="password*" required>
                    <label for="user_pass">password*</label>
                </p>
                <p class="form-row form-row-last">
                    <input type="password" id="user_pass_confirmation" class="form-control" name="user_pass_confirmation" placeholder="password again*" required>
                    <label for="user_pass_confirmation">password again*</label>
                </p>
                <p class="form-row form-row-wide">
                    <input type="submit" class="btn btn-blue" value="sign up">
                </p>

                <div class="status"></div>
            </div>
        </form>
    </div>

</div>