<?php
/**
 * Template Name: Register
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package trainingcamp
 */
if (isset($_GET['noreq']) && $_GET['noreq']!='1'){
    status_header( 404 );
    nocache_headers();
    include( get_query_template( '404' ) );
    die();
}

get_header(); ?>

<?php while(have_posts()): the_post(); ?>

    <div class="section">

        <?php get_template_part('template-parts/register','content') ?>

    </div>

<?php endwhile; ?>
   
<?php get_footer();
