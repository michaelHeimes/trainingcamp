<?php
/**
 * Template name: Special offers or New courses
 */
get_header(); ?>
<?php while(have_posts()): the_post(); ?>

    <?php
    $current_page_id=get_the_ID();
    $special_or_new=get_field('special_or_new');
    ?>

    <?php
    $related_products=($special_or_new=='new') ? get_field('special_related_products') : get_field('special_related_products1');

    if(is_array($related_products) && count($related_products)>0):
        ?>

<!--        <div class="top-bg featured page-heading top-slider">
            <?php foreach($related_products as $product_id): ?>

                <div class="slide" style="background-image: url('<?= get_template_directory_uri() ?>/slice/dist/images/special-offers-bg.jpg');">
                    <div class="content-block  custom-content-block">
                        <h1><?= get_the_title($product_id) ?></h1>
                        <p><?= custom_get_the_excerpt($product_id) ?></p>
                        <?php if($special_or_new!='new'): ?>
                            <h2 class="price">
                                <del>$<?= get_post_meta($product_id,'_min_variation_regular_price',true) ?></del>
                                <strong>$<?= get_post_meta($product_id,'_min_variation_sale_price',true) ?></strong>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div> -->

        <?php
    endif; ?>


    <?php
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    if($special_or_new==='special'){
        $args = array(
            'post_type'      => 'product',
            'paged'          => $paged,
            'post_status'    => 'publish',
            'posts_per_page' => 8,
            //if available sale price for variations
            'post__in'=> wc_get_product_ids_on_sale()
        );
    }elseif($special_or_new==='new'){
        $args = array(
            'post_type'      => 'product',
            'paged'          => $paged,
            'post_status'    => 'publish',
            'posts_per_page' => 8,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'new-courses',
                ),
            ),
            //Not show products with sale price
            'post__not_in'=> wc_get_product_ids_on_sale()
        );
    }


    $query = new WP_Query( $args );
    if($query->have_posts()):
        ?>

        <div class="section">
            <div class="container large">
            <div class="title">
                <h2><?= get_the_title($product_id)?></h2>
            </div>
                <div class="title">
                    <h2><?= get_the_title(); ?></h2>
                    <?php the_content() ?>
                </div>

                <ul class="previews-list product-list">

                    <?php while($query->have_posts()): $query->the_post(); ?>

                        <?php
                        $product_thumb_url=get_the_post_thumbnail_url(get_the_ID(),'prod_archive_img');
                        $product_thumb_url=($product_thumb_url) ? : get_template_directory_uri().'/slice/dist/images/preview-img-1.jpg';

                        $duration=get_field('product_top_duration',get_the_ID());
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

                        <li class="product-item">

                            <figure style="background-image: url('<?= $product_thumb_url ?>')">
                                <a href="<?= get_permalink(); ?>">more details</a>
                            </figure>

                            <div class="info">
                                <h3><?= get_the_title(); ?></h3>

                                <?php if($special_or_new==='special'): ?>

                                    <div class="details">
                                        <h6><?= $duration ?></h6>
                                        <h3 class="price">
                                            <del>$<?= get_post_meta(get_the_ID(),'_min_variation_regular_price',true) ?></del>
                                            <strong>$<?= get_post_meta(get_the_ID(),'_min_variation_sale_price',true) ?></strong>
                                        </h3>
                                    </div>

                                <?php else: ?>

                                    <h6><?= $duration ?></h6>

                                <?php endif; ?>
                            </div>

                        </li>

                    <?php endwhile; ?>

                </ul>


                <?php
                if(function_exists('wp_pagenavi')){
                    ?>
                    <div class="paginate_wrap" style="display: none;">
                        <?php wp_pagenavi(array('query'=>$query)); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="buttons aligncenter">
                    <a href="javascript: void(0)" class="btn btn-white load-more">load more courses</a>
                </div>

            </div>
        </div>

        <?php
        wp_reset_postdata();
    else:

        echo '<p class="not-found">Nothing Found</p>';

    endif;

    ?>

<?php endwhile; ?>

<script>
    $(document).ready(function ($) {
        "use strict";
        // set options
        var loadmore_scroll = {
            'nextSelector': 'a.nextpostslink',
            'navSelector': '.wp-pagenavi',
            'itemSelector': '.product-item',
            'contentSelector': '.product-list'
        };
        $('.product-list').loadmore_scroll(loadmore_scroll);
    });
</script>

<?php get_footer();
