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


<div class="top-bg" style="background-image: url('<?= $background_url ?>');">
    <div class="content-block">
        <h1><?= get_the_title() ?></h1>

        <p><?php the_excerpt() ?></p>

        <?php if($certificate_logo): ?>
            <figure style="background-image: url('<?= $certificate_logo ?>');"></figure>
        <?php endif; ?>
    </div>
    <?php
    $terms = wp_get_post_terms( get_the_ID(), 'product_cat' );
    if (isset($terms[0])){
        ?>
        <a href="<?= get_term_link($terms[0]->term_id) ?>" class="anchor back-link">browse courses</a>
        <?php
    }
    ?>

</div>


<?php if($duration || have_rows('product_top_features')): ?>
    <div class="course-info">

        <div class="container">
            <ul>
                <?php if($duration): ?>
                    <li>
                        <h5>duration</h5>
                        <h6><?= $duration ?></h6>
                    </li>
                <?php endif; ?>

                <?php if (have_rows('product_top_features')): ?>
                    <?php while(have_rows('product_top_features')): the_row(); ?>
                        <?php
                        $name=get_sub_field('product_top_features_name');
                        $value=get_sub_field('product_top_features_value');
                        if($name && $value):
                            ?>
                            <li>
                                <h5><?= $name ?></h5>
                                <h6><?= $value ?></h6>
                            </li>
                            <?php
                        endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>

    </div>
<?php endif; ?>


<?php
$arr_keys=array(
    'live',
    'virtual',
    'self',
    'premise'
);
?>
<div class="course-additions">
    <div class="container">
        <ul>
            <?php
            foreach($arr_keys as $key){
                $title=get_field('product_top_'.$key.'_title');
                $description=get_field('product_top_'.$key.'_description');
                $cta_text=get_field('product_top_'.$key.'_cta_text');
                $cta_link=($key=='live' || $key=='virtual') ? add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) : get_field('product_top_'.$key.'_cta_link');
                //$cta_link=get_field('product_top_'.$key.'_cta_link');
                $cta_external=get_field('product_top_'.$key.'_cta_link_external');

                if ($title){
                    ?>
                    <li>
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
            ?>
        </ul>
    </div>
</div>