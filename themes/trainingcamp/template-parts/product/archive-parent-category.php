<?php
$background=get_field('training_background','options');
$background=(isset($background['url'])) ? $background['url'] : get_template_directory_uri().'/slice/dist/images/training-courses-bg.jpg';
?>
<div class="top-bg"
     style="background-image: url('<?= $background ?>');">
    <div class="content-block">
        <h1><?= get_field('training_title','options') ?></h1>
        <p><?= get_field('training_description','options') ?></p>
    </div>
</div>


<div class="section">

    <?php
    $tax = 'product_cat';
    $terms = get_terms($tax, array('parent' => 0, 'hide_empty' => 0, 'exclude'=>array(11)));
    $current_term_id = get_queried_object()->term_id;
    ?>

    <?php if(is_array($terms) && count($terms)>0): ?>

        <div class="container">
            <div class="title">
                <h2>browse courses</h2>
            </div>
            <div class="tab-nav">
                <ul>
                    <?php foreach ($terms as $term):

                        $class=($current_term_id==$term->term_id) ? 'class="active"' : '';
                        ?>

                        <li <?= $class ?>><a href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    <?php endif; ?>


    <?php
    $terms = get_terms($tax, array('parent' => $current_term_id, 'hide_empty' => 0));

    if (count($terms) > 0) {
        if (get_query_var('paged'))
            $paged = get_query_var('paged');
        else if (get_query_var('page'))
            $paged = get_query_var('page');
        else
            $paged = 1;

        $per_page = 40;
        $number_of_series = count($terms);
        $offset = $per_page * ($paged - 1);

        $args = array(
            'parent' => $current_term_id,
            'hide_empty' => 0,
            'offset' => $offset,
            'number' => $per_page
        );
        $categories = get_terms($tax, $args);
        ?>

        <div class="container large">

            <div class="tab-content active">

                <ul class="previews-list product-list">
                    <?php foreach($categories as $category):
                        $default_cat_img=get_field('product_cat_default_img','options');
                        $default_cat_img=(isset($default_cat_img['sizes']['prod_archive_img'])) ? $default_cat_img['sizes']['prod_archive_img'] : '';
                        $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
                        $attach_details=($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id,'prod_archive_img') : '';
                        $img_src=(isset($attach_details[0])) ? $attach_details[0] : $default_cat_img;
                        ?>

                        <li class="product-item">
                            <figure
                                style="background-image: url('<?= $img_src ?>')">
                                <a href="<?= get_term_link($category->term_id) ?>">more details</a>
                            </figure>
                            <div class="info">
                                <h3><?= $category->name ?></h3>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>

                <?php
                echo "<div class='pagination' style='display: none;'>" . paginate_links(array(
                        'base' => '%_%',
                        'format' => '?page=%#%',
                        'current' => $paged,
                        'total' => ceil($number_of_series / $per_page)
                    )) . '</div>';
                ?>

                <div class="buttons aligncenter">
                    <a href="javascript: void(0)" class="btn btn-white load-more">load more courses</a>
                </div>

            </div>

        </div>
        <?php
    } ?>

</div>

<script>
    $(document).ready(function ($) {
        "use strict";
        // set options
        var loadmore_scroll = {
         'nextSelector': 'a.next',
         'navSelector': '.pagination',
         'itemSelector': '.product-item',
         'contentSelector': '.product-list'
         };
        $('.previews-list').loadmore_scroll(loadmore_scroll);
    });
</script>