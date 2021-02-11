<?php
/**
 * Template name: Jobs
 */

get_header(); ?>
<?php while(have_posts()): the_post(); ?>

    <div class="section">
        <div class="container">
            <div class="title">
                <h2  class="word-capitalize"><?= get_the_title() ?></h2>
                <?php the_content(); ?>
            </div>
            <?php
            $args = array(
                'post_type'      => 'jobs',
                'post_status'    => 'publish'
            );
            $args['posts_per_page']=(isset($_GET['per_page']) && $_GET['per_page']==-1) ? -1 : 4;
            $query=new WP_Query($args);

            if($query->have_posts()):
                ?>
                <ul class="jobs-list">
                    <?php while($query->have_posts()): $query->the_post();
                        $location=get_field('job_location');
                        $link=get_field('job_link');
                        ?>
                        <li>
                            <h3><?= get_the_title() ?></h3>

                            <?php if($location): ?>
                                <p><?= $location ?></p>
                            <?php endif; ?>

                            <?php if($link): ?>
                                <a href="<?= $link ?>" class="btn btn-white" target="_blank">view details</a>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>

                <?php if(isset($_GET['per_page']) && $_GET['per_page']==-1): ?>
                <?php else: ?>
                    <div class="buttons">
                        <a href="<?= add_query_arg('per_page',-1,get_permalink()); ?>" class="btn btn-blue">view all</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="not-found">Nothing Found!</p>
            <?php endif; ?>
        </div>
    </div>

<?php endwhile; ?>
<?php
get_footer();
