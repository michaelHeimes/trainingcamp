<?php
$background=get_field('product_top_background');
$product_thumb_url=get_the_post_thumbnail_url(get_the_ID(),'prod_single_img');
if (isset($background['sizes']['prod_single_img'])){
    $background_url=$background['sizes']['prod_single_img'];
}elseif($product_thumb_url){
    $background_url=$product_thumb_url;
}else{
    $background_url=get_template_directory_uri().'/slice/dist/images/course-details-bg.jpg';
}

$certificate_logo=get_field('product_top_certificate');
$certificate_logo=(isset($certificate_logo['sizes']['medium'])) ? $certificate_logo['sizes']['medium'] : '';

$duration=get_field('product_top_duration');
$duration=($duration) ? (int) $duration : '';
if(is_numeric($duration)){
    if ($duration==1){
        $duration=$duration.' day';
    }else{
        $duration=$duration.' days';
    }
}else{
    $duration='';
}
?>


<div class="top-bg featured-course page-heading" style="background-image: url('<?= $background_url ?>');">
    <div class="content-block custom-content-block">
        <h2  class="word-capitalize"><?= get_the_title() ?></h2>

<!--        <p id="course_description"><?php the_excerpt() ?></p> -->

        <?php if($certificate_logo): ?>
            <figure style="background-image: url('<?= $certificate_logo ?>');display:none;"></figure>
        <?php endif; ?>
    </div>
    <?php
    $terms = wp_get_post_terms( get_the_ID(), 'product_cat' );
    if (isset($terms[0])){
        ?>
        <a style="display:none;" href="<?= get_term_link($terms[0]->term_id) ?>" class="anchor back-link">browse courses</a>
        <?php
    }
    ?>

</div>


<?php if($duration || have_rows('product_top_features')): ?>
    <div class="course-info custom-course-info">

        <div class="container">
            <ul>
                <?php if($duration): ?>
                    <li  class="product-top-features-li">
                        <h5>duration</h5>
                        <h5><?= $duration ?></h5>
                    </li>
                <?php endif; ?>

                <?php if (have_rows('product_top_features')): ?>
                    <?php while(have_rows('product_top_features')): the_row(); ?>
                        <?php
                        $name=get_sub_field('product_top_features_name');
                        $value=get_sub_field('product_top_features_value');
                        if($name && $value):
                            ?>
                            <li class="product-top-features-li">
                                <h5><?= $name ?></h5>
                                <h5><?= $value ?></h5>
                            </li>
                            <?php
                        endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>

    </div>
<?php endif; ?>

<div style="display:block;" >
            <div class="columns container content custom-columns">
    <div class="col col-first">
        <p id="course_description"><?php the_excerpt() ?></p></div>
    <div class="col  col-second">
        <div class="buttons aligncenter custom-buttons">
        <a class="btn btn-white pricing-tab btn-pricing-schedule" href="<?= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) ?>">Pricing & Schedules</a>
        </div>
      <!--  <p id="course_description"><?php the_excerpt() ?></p> -->
    </div>
    </div>
</div>








    </div>
</div>
