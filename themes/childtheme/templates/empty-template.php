<?php
/**
 * Template name: Empty Template
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-about">
    <div class="container custom-about">
        <?php the_content(); ?>
    </div>
</div>


<?php endwhile; ?>

<?php
get_footer();
