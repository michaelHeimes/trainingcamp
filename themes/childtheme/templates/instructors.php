<?php
/**
 * Template name: Instructors
 */

get_header(); ?>
<?php while(have_posts()): the_post(); ?>

    <?php
    $background_url = get_the_post_thumbnail_url(get_the_ID(), 'prod_single_img');
    $background_url = ($background_url) ?: get_template_directory_uri() . '/slice/dist/images/instructors-bg.jpg';
    ?>

    <div class="top-bg featured page-heading" style="background-image: url('<?= $background_url ?>');">
        <div class="content-block custom-content-block">
            <h1 class="word-capitalize"><?= get_the_title() ?></h1>
        </div>
    </div>


    <div class="section">
        <div class="container large">

            <div class="title">
                <?php the_content() ?>
            </div>

            <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
                'post_type'      => 'instructors',
                'post_status'    => 'publish',
                'posts_per_page' => 4,
                'paged'          => $paged
            );
            $query=new WP_Query($args);
            if($query->have_posts()) {
                ?>

                <ul class="instructors">
                    <?php while ($query->have_posts()): $query->the_post();
                        $photo = get_the_post_thumbnail_url(get_the_ID(), 'instructor_thump');
                        ?>
                        <li class="instructor">
                            <?php if ($photo): ?>
                                <figure style="background-image: url('<?= $photo ?>');"></figure>
                            <?php endif; ?>
                            <h3><?= get_the_title() ?></h3>
                            <h5><?= get_field('instructor_position') ?></h5>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php
                if (function_exists('wp_pagenavi')) wp_pagenavi(array('query' => $query));
            }else{
                ?><p class="not-found">Nothing Found!</p><?php
            }
            wp_reset_postdata(); ?>

        </div>
    </div>

<?php endwhile; ?>

<?php
get_footer();
