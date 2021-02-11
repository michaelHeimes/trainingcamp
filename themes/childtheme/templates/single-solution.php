<?php
/**
 * Template name: Single Solution
 */

get_header(); ?>
<?php while(have_posts()): the_post();
    $background_url = get_the_post_thumbnail_url(get_the_ID(), 'prod_single_img');
    $background_url = ($background_url) ?: get_template_directory_uri() . '/slice/dist/images/solutions-bg.jpg';
    ?>

<!--    <div class="top-bg featured page-heading" style="background-image: url('<?= $background_url ?>');">
        <div class="content-block custom-content-block">
            <h1  class="word-capitalize"><?= get_the_title() ?></h1>
           <p><?= get_field('single_top_subtitle') ?></p>  
        </div>
    </div> -->
    
    
    <div class="section  custom-section custom-section-bottom">
<div class="container custom-about">
<div class="title">
                <h2><?= get_the_title() ?></h2>
            </div>

<p><?= get_field('single_top_subtitle') ?></p>
</div>
        <div class="container">
            <div class="title">
                <h3><?= get_field('title_before_solutions') ?></h3>
                <p><?= get_field('subtitle_before_solutions') ?></p>
            </div>

            <?php if(have_rows('solutions')): ?>
                <ul class="icon-list horizontal">
                    <?php while(have_rows('solutions')): the_row(); ?>
                        <?php
                        $icon=get_sub_field('solution_icon');
                        $title=get_sub_field('solution_title');
                        $description=get_sub_field('solution_description');
                        $link=get_sub_field('solution_link');

                        if($title):
                            ?>
                            <li>
                                <?php if($icon): ?>
                                    <figure style="background-image: url('<?= $icon ?>');"></figure>
                                <?php endif; ?>
                                <div class="info">
                                    <h3><?= $title ?></h3>
                                    <?php if($description): ?>
                                        <p><?= $description ?></p>
                                    <?php endif; ?>
                                   <?php if($link): ?>
					<a href="<?= $link ?>" class="btn btn-white">Learn More</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php
                        endif; ?>

                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
                       <div class="section custom-section-top">
        <div class="container">
            <div class="title">

            </div>
<div class="forms clearfix">
                <div class="send-message">
                    <?= do_shortcode('[contact-form-7 id="1701" title="group training"]') ?>
                </div>

                <div class="contact-info">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>



<?php endwhile; ?>
<?php get_footer();
