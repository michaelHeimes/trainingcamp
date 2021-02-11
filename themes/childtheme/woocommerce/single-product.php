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
get_header();
?>

<?php while (have_posts()) : the_post(); ?>


    <?php get_template_part('template-parts/product/single','top-section') ?>
                                                    
    <div class="tab-wrap section custom-tab-section">
        <div class="container">
            <div class="tab-nav  custom-tab-nav custom-product-ul">
                <ul  class="custom-ul custom-product-ul">
                    <li class="active"><a href="#includes">What's Included</a></li>
                    <li><a href="#course-outline">Course Outline</a></li>
                    <li><a href="#related-courses">Related Courses</a></li>
<!--                    <li><a href="#pricing-schedules">Pricing & Schedules</a></li> -->
                  <!--  <li><a href="<?= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) ?>">Pricing & Schedules</a></li> -->
                
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
<!--
         <div class="tab-content" id="pricing-schedules">

            <div class="container pricing-schedules" id="pricing-schedules1">
                <div class="shop-app"></div>
            </div>

        </div>  -->
       <!-- <div class="buttons aligncenter">
        <a class="btn btn-white pricing-tab" href="<?= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) ?>">Pricing & Schedules</a>
        </div> -->
    </div>


                        <?php
$arr_keys=array(
    'live',
    'virtual',
    'premise',
    'register'
);
?>
<div class="course-additions custom-course-additions">
    <div class="container">
        <ul  style="text-align: center;">
            <?php
            foreach($arr_keys as $key){
                $cta_link=get_field('product_top_'.$key.'_cta_link');
                if(!isset($cta_link) || trim($cta_link) === ''){
                }else{
                $title=get_field('product_top_'.$key.'_title');
                $description=get_field('product_top_'.$key.'_description');
                $cta_text=get_field('product_top_'.$key.'_cta_text');
                //$cta_link=($key=='live' || $key=='virtual') ? add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) : get_field('product_top_'.$key.'_cta_link');
                $cta_link=get_field('product_top_'.$key.'_cta_link');
                $cta_external=get_field('product_top_'.$key.'_cta_link_external');
                
                if($cta_link === '#pricing-schedules'){
                    $cta_link= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php')));
                }else if($cta_link === '#register'){
                    $cta_link= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/register.php')));
                }

                if ($title){
                    ?>
                    <li class="item-course-additions">
                        <h3><?= $title ?></h3>
                        <?php if ($description): ?>
                            <p><?= $description ?></p>
                        <?php endif; ?>
                        <?php if ($cta_text && $cta_link): ?>
                            <?php $external_html=($cta_external==='yes') ? 'target="_blank"' : ''; ?>
                            <a href="<?= $cta_link ?>" class="btn btn-white pricing-tab" <?= $external_html ?>><?= $cta_text ?></a>
                        <?php endif; ?>
                    </li>
                    <?php
                }
                }
            }
            ?>
        </ul>




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
    <?php */?>
<script>
$('.pricing-tab').click(function (e) {
console.log($('.pricing-tab').attr('href'));
if($('.pricing-tab').attr('href') == '#pricing-schedules'){
$('.custom-product-ul li:nth-child(1)').removeClass('active');
$('.custom-product-ul li:nth-child(2)').removeClass('active');
$('.custom-product-ul li:nth-child(3)').removeClass('active');
$('.custom-product-ul li:nth-child(4)').addClass('active');
}

});
</script>    
    

<?php get_footer(); ?>
