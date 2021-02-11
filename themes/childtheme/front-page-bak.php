<?php
get_header(); ?>

<?php while(have_posts()): the_post(); ?>

    <?php
    $background_url = get_the_post_thumbnail_url(get_the_ID(), 'prod_single_img');
    $background_url = ($background_url) ?: get_template_directory_uri() . '/slice/dist/images/home-bg-1.jpg';

    $tax = 'product_cat';
    $vendor_terms = get_terms($tax, array('parent' => 21, 'hide_empty' => 0));
    $topic_terms = get_terms($tax, array('parent' => 35, 'hide_empty' => 0));

    $relation_courses=get_field('home_courses');
    $relation_testimonials=get_field('home_testimonials');
    ?>

    <?php
    $main_categories=array();
    $main_categories_str=get_field('main_categories');
    if ($main_categories_str){
        $main_categories=explode(',',$main_categories_str);
    }
    ?>
    <div class="top-bg home-bg" style="background-image: url('<?= $background_url ?>');">
        <div class="content-block">
            <h1 class="word-capitalize"><?= get_field('home_top_subtitle') ?></h1>
           <div class="home-content"> <?php the_content(); ?> </div>
        </div>
        <?php if (count($main_categories)>0): ?>
            <a class="anchor">browse courses</a>
        <?php endif; ?>
    </div>


    <?php if (count($main_categories)>0): ?>
        <div class="choose-course">
            <?php foreach($main_categories as $category): ?>
                <?php
                $category_obj=get_term_by('slug',$category,$tax);
                if (isset($category_obj->term_id)){
                    $category_name=$category_obj->name;
                    $terms=get_terms($tax, array('parent' => $category_obj->term_id, 'hide_empty' => 0));
                    if (count($terms)>0){
                        ?>
                        <div class="dropdown">
                            <p class="dropdown-title"><?= $category_name ?></p>
                            <ul class="">
                                <?php foreach ($terms as $term): ?>
                                    <li><a href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
                ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <?php if(have_rows('home_logos')): ?>
        <section class="as-seen-on">
            <div class="container">
                <h4><?= get_field('home_logos_title') ?></h4>
                <ul>
                    <?php while(have_rows('home_logos')): the_row(); ?>
                        <?php
                        $icon=get_sub_field('home_logos_icon');

                        if(isset($icon['sizes']['medium'])):
                            ?>
                            <li>
                                <img src="<?= $icon['sizes']['medium'] ?>" alt="">
                            </li>
                            <?php
                        endif; ?>
                    <?php endwhile; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>


    <?php if(is_array($relation_courses) && count($relation_courses)>0): ?>
        <section class="popular-courses">
            <?php if(get_field('home_courses_title')): ?>
                <div class="title"><h2><?= get_field('home_courses_title') ?></h2></div>
            <?php endif; ?>
           <!-- <div class="slides">
                <?php foreach($relation_courses as $relation_course_id): ?>
                    <?php
                    $duration=get_field('product_top_duration',$relation_course_id);
                    $background_url = get_the_post_thumbnail_url($relation_course_id, 'large')
                    ?>

                    <div class="slide">
                        <?php if($background_url): ?>
                            <div class="img" style="background-image: url('<?= $background_url ?>');"></div>
                        <?php endif; ?>
                        <div class="content-block">
                            <?php if($duration): ?>
                                <figure>
                                    <strong><?= $duration ?></strong>
                                    <small>days</small>
                                    <span></span>
                                    <span></span>
                                </figure>
                            <?php endif; ?>
                            <h5><?= get_the_title($relation_course_id) ?></h5>
                            <a href="<?= get_permalink($relation_course_id) ?>" class="more">more details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> -->

        <div class="container large">

            <div class="tab-content active">
                <ul class="previews-list product-list">
                <?php foreach($relation_courses as $relation_course_id): ?>
<li class="product-item custom-product-item custom-popular-course">
    <a id="professional-dev1" class="tile professional-dev custom-professional-dev" href="<?= get_permalink($relation_course_id) ?>">
                    <div class="content">
                        <h3 class="heading custom-course-heading home-course-heading"><?= get_the_title($relation_course_id) ?></h3>

                    </div>
                </a>
</li>
                <?php endforeach; ?>
<ul>
</div>
</div>
        </section>
    <?php endif; ?>


    <?php if(have_rows('home_why_features')): ?>
        <section class="why-choose">
            <div class="container">
                <?php if(get_field('home_why_title')): ?>
                    <div class="title"><h2><?= get_field('home_why_title') ?></h2></div>
                <?php endif; ?>
                <ul class="icon-list vertical">
                    <?php while(have_rows('home_why_features')): the_row(); ?>
                        <?php
                        $icon=get_sub_field('home_why_features_icon');
                        $title=get_sub_field('home_why_features_title');
                        $subtitle=get_sub_field('home_why_features_subtitle');
                        if($title):
                            ?>
                            <li>
                                <?php if($icon): ?>
                                    <figure style="background-image: url('<?= $icon ?>');"></figure>
                                <?php endif; ?>
                                <h3><?= $title ?></h3>
                                <?php if($subtitle): ?>
                                    <p><?= $subtitle ?></p>
                                <?php endif; ?>
                            </li>
                            <?php
                        endif; ?>
                    <?php endwhile; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>


    <?php if(have_rows('home_solutions')): ?>
        <?php
        $background_section=get_field('home_solutions_background');
        $background_url=(isset($background_section['url'])) ? $background_section['sizes']['full_hd'] : get_template_directory_uri().'/slice/dist/images/home-bg-3.jpg';
        ?>

        <section class="home-custom-section img-block solutions" style="background-image: url('<?= $background_url ?>');">
            <div class="container">
                <?php if(get_field('home_solutions_title')): ?>
                    <div class="title"><h2><?= get_field('home_solutions_title') ?></h2></div>
                <?php endif; ?>
                <ul>
                    <?php while(have_rows('home_solutions')): the_row(); ?>
                        <?php
                        $title=get_sub_field('home_solutions_title');
                        $subtitle=get_sub_field('home_solutions_subtitle');
                        $icon=get_sub_field('home_solutions_icon');
                        $relation_pages=get_sub_field('home_solutions_relation_page');

                        if($title):
                            ?>
                            <li class="slide">
                                <a href="<?= get_permalink($relation_pages[0]) ?>">
                                <?php if($icon): ?>
                                    <figure style="background-image: url('<?= $icon?>')">
                                        <span></span>
                                        <span></span>
                                    </figure>
                                <?php endif; ?>
                                <h3><?= $title ?></h3>
                                <?php if($subtitle): ?>
                                    <p><?= $subtitle ?></p>
                                <?php endif; ?>
                                <?php if(isset($relation_pages[0])): ?>
                                    <div class="more word-capitalize"><a href="<?= get_permalink($relation_pages[0]) ?>">more details</a></div>
                                <?php endif; ?>
                                </a>
                            </li>
                            <?php
                        endif; ?>
                    <?php endwhile; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>


    <?php if(is_array($relation_testimonials) && count($relation_testimonials)>0): ?>
        <section class="quote-slider">
            <div class="container">
                <?php if(get_field('home_testimonials_title')): ?>
                    <h2 class="custom-testimonials-title"><?= get_field('home_testimonials_title') ?></h2>
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


    <?php
    $title=get_field('home_jobs_title');
    $description=get_field('home_jobs_description');
    $background=get_field('home_jobs_background');
    $background_url=(isset($background['url'])) ? $background['sizes']['full_hd'] : get_template_directory_uri().'/slice/dist/images/home-bg-3.jpg';
    $relation_page=get_field('home_jobs_relation_page');
    ?>
   

<?php endwhile; ?>
<?php
get_footer();
