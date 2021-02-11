<?php
global $wp_query;
$current_term_id = get_queried_object()->term_id;
$term = get_term_by('id', $current_term_id, 'product_cat');
$thumbnail_id = get_woocommerce_term_meta($current_term_id, 'thumbnail_id', true);
$attach_details = ($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'prod_single_img') : '';
$img_src = (isset($attach_details[0])) ? $attach_details[0] : get_template_directory_uri() . '/slice/dist/images/courses-group-bg.jpg';
?>

<div class="top-bg" style="background-image: url('<?= $img_src ?>');">
    <div class="content-block">
        <h1><?= $term->name ?></h1>
        <p><?= $term->description ?></p>
    </div>
    <a href="<?= get_term_link($term->parent) ?>" class="anchor back-link">back to courses</a>
</div>


<div class="section">
    <div class="container clearfix">

        <div class="title">
            <h2>
                <?php
                $paged = max(1, $wp_query->get('paged'));
                $per_page = $wp_query->get('posts_per_page');
                $total = $wp_query->found_posts;
                $first = ($per_page * $paged) - $per_page + 1;
                $last = min($total, $wp_query->get('posts_per_page') * $paged);

                if ($total <= $per_page || -1 === $per_page) {
                    printf(_n('Showing the single result', '%d courses', $total, 'woocommerce'), $total);
                } else {
                    printf(_nx('Showing the single result', '%1$d&ndash;%2$d courses <span>(%3$d)</span>', $total, '%1$d = first, %2$d = last, %3$d = total', 'woocommerce'), $first, $last, $total);
                }
                ?>
            </h2>
        </div>


        <?php
        $taxonomy_name = 'product_tag';
        $terms = get_terms($taxonomy_name, array('parent' => 0, 'hide_empty' => 0));
        if (count($terms) > 0) {
            ?>
            <aside>
                <div class="filter">
                    <form action="<?= get_term_link($current_term_id) ?>" method="get" id="filter_form">
                        <?php foreach ($terms as $parent_term): ?>

                            <?php
                            $child_terms = get_terms($taxonomy_name, array('parent' => $parent_term->term_id, 'hide_empty' => 0));
                            $checked_cats = (isset($_GET['category'])) ? $_GET['category'] : '';
                            $checked_cats = ($checked_cats) ? explode(",", $checked_cats) : array();
                            ?>

                            <?php if (count($child_terms) > 0): ?>
                                <h5><?= $parent_term->name ?></h5>

                                <div class="form-wrap">

                                    <?php foreach ($child_terms as $child_term): ?>

                                        <?php $checked = (in_array($child_term->slug, $checked_cats)) ? 'checked' : ''; ?>

                                        <div class="form-row form-row-wide">

                                            <input type="checkbox" name="category" value="<?= $child_term->slug ?>"
                                                   id="category-<?= $child_term->term_id ?>" <?= $checked ?>>
                                            <label
                                                for="category-<?= $child_term->term_id ?>"><?= $child_term->name ?></label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        <div class="buttons">
                            <button type="reset" class="filter-btn" onclick="location.href='<?= get_term_link($current_term_id) ?>';">clear all</button>
                        </div>
                    </form>
                </div>
            </aside>
            <?php
        }
        ?>


        <?php if (have_posts()): ?>

            <div class="courses">
                <ul class="courses-list">

                    <?php while (have_posts()): the_post();

                        $duration = get_field('product_top_duration', get_the_ID());
                        $duration = ($duration) ? (int)$duration : '';
                        if (is_numeric($duration)) {
                            if ($duration == 1) {
                                $duration = $duration . ' day';
                            } else {
                                $duration = $duration . ' days';
                            }
                        } else {
                            $duration = '';
                        }
                        $term_list = wp_get_post_terms(get_the_ID(), $taxonomy_name, array("all"));
                        $term_not_nums = array();
                        if (count($term_list) > 0) {
                            $i = 0;
                            foreach ($term_list as $current_term) {
                                if ($current_term->parent != 42)
                                    $term_not_nums[] = $i;
                                $i++;
                            }
                            foreach ($term_not_nums as $num) {
                                unset($term_list[$num]);
                            }
                        }
                        ?>

                        <li>
                            <div class="info">
                                <h3><a href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>

                                <h5><?= $duration ?></h5>

                                <p><?php the_excerpt() ?></p>

                                <?php if (is_array($term_list) && count($term_list) > 0): ?>
                                    <ul class="tags">
                                        <?php foreach ($term_list as $current_term): ?>
                                            <li><?= $current_term->name ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                </ul>


                <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>


            </div>

        <?php else: ?>

            <div class="courses">
                <p class="not-found">Nothing found!</p>
            </div>

        <?php endif; ?>

    </div>
</div>

<script>
    var form = $('form#filter_form');
    form.find('input[type="checkbox"]').change(function () {
        form.submit();
    });
    form.submit(function () {
        //get all field values
        var query = "category="; //write here parameter name
        $("form#filter_form [name=category]:checked").each(function (i) { //it will check for all elements inside form with name "id"
            query += $(this).val() + ",";
        });
        query = query.slice(0, -1); //remove last extra comma
        //redirect url by passing "query" as GET parameter
        window.location = $(this).attr("action") + "?" + query;
        return false;
    });
</script>