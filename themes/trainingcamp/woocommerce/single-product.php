<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$contact_page=get_permalink(get_page_ID_by_page_template('templates/contact.php'));
get_header(); ?>

<?php while (have_posts()) : the_post(); ?>


    <?php get_template_part('template-parts/product/single','top-section') ?>


    <div class="tab-wrap section">
        <div class="container">
            <div class="tab-nav">
                <ul>
                    <li class="active"><a href="#includes">What's Included</a></li>
                    <li><a href="#course-outline">Course Outline</a></li>
                    <li><a href="#related-courses">Related Courses</a></li>
                    <!--<li class="special"><a href="#pricing-schedules">Pricing & Schedules</a></li>-->
                    <li class="special"><a href="<?= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) ?>">Pricing & Schedules</a></li>
                </ul>
            </div>
        </div>


        <div class="tab-content active" id="includes">
            <?php get_template_part('template-parts/product/single','includes') ?>
        </div>


        <div class="tab-content" id="course-outline">
            <?php get_template_part('template-parts/product/single','course-outline') ?>
        </div>


        <div class="tab-content" id="related-courses">
            <?php get_template_part('template-parts/product/single','related-courses') ?>
        </div>


        <div class="tab-content" id="pricing-schedules">

            <div class="container pricing-schedules" id="pricing-schedules1">
                <div class="shop-app"></div>
            </div>

        </div>
    </div>


    <?php get_template_part('template-parts/product/single','testimonials') ?>

<?php endwhile; ?>

    <script>
        var productId=<?= get_the_ID() ?>;
        var contact_page='<?= $contact_page ?>'
    </script>

    <?php /* ?>
    <script>
        $(document).ready(function(){
            var data = {
                'action': 'get_variations_by_post_id',
                'post_id': <?= get_the_ID() ?>
            };
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: data,
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                }
            });
        });
    </script>
    <?php */ ?>

<?php get_footer(); ?>