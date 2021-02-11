<?php
/**
 * Template name: Course Price NoReQ
 */
if (isset($_GET['noreq']) && $_GET['noreq']!='1'){
    status_header( 404 );
    nocache_headers();
    include( get_query_template( '404' ) );
    die();
}
$contact_page=get_permalink(get_page_ID_by_page_template('templates/contact.php'));
get_header(); ?>

<?php while(have_posts()): the_post(); ?>

    <div class="section">

        <?php get_template_part('template-parts/course-pricing-noreq','content') ?>

    </div>
    
    

<?php endwhile; ?>
    <script>
        var service_block_text="Don’t see the location or date you need? No problem – just let us know what you are looking.";
        var contact_page='<?= $contact_page ?>'
    </script>
<?php get_footer();
