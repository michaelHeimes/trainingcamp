<?php
/**
 * Template name: Course Pricing & Schedules
 */
if (isset($_GET['noreq']) && $_GET['noreq']!='1'){
    status_header( 404 );
    nocache_headers();
    include( get_query_template( '404' ) );
    die();
}
$contact_page=get_permalink(get_page_ID_by_page_template('templates/contact.php'));
$relation_testimonials=get_field('see_price_testimonials');
get_header(); ?>

<?php while(have_posts()): the_post(); ?>

    <div class="section">

        <?php get_template_part('template-parts/course-pricing','content') ?>

    </div>
    
    

<?php endwhile; ?>

 <?php if(is_array($relation_testimonials) && count($relation_testimonials)>0): ?>
        <section class="quote-slider">
            <div class="container">
                <?php if(get_field('see_price_testimonials_title')): ?>
                    <h2 class="custom-testimonials-title"><?= get_field('see_price_testimonials_title') ?></h2>
                <?php endif; ?>

                <div class="slides custom-home-testmonials">
                    <?php foreach($relation_testimonials as $relation_testimonial_id): ?>
                        <div class="slide">
                            <blockquote class="home-blockquote">
                                <q class="word-capitalize"><?= get_field('testimonial_text',$relation_testimonial_id) ?></q>
                                <footer>
                                    <div class="info">
                                         <cite class="word-capitalize home-blockquote"><?= get_field('testimonial_author',$relation_testimonial_id) ?></cite>
                                        <span class="word-capitalize"><?= get_field('testimonial_source',$relation_testimonial_id) ?></span>
                                    </div>
                                </footer>
                            </blockquote>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="slide-num">
                    <strong class="cur-slide home-blockquote home-custom-testimonial-slide">01</strong>
                <strong class="home-blockquote slides-qty home-custom-testimonial-slide">08</strong>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <script>
        var service_block_text="Don’t see the location or date you need? No problem – just let us know what you are looking.";
        var contact_page='<?= $contact_page ?>'
    </script>
<?php get_footer();



