<?php
/**
 * Template name: About TEST
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

    <?php
    $background_url = get_the_post_thumbnail_url(get_the_ID(), 'prod_single_img');
    $background_url = ($background_url) ?: get_template_directory_uri() . '/slice/dist/images/about-bg.jpg';
    ?>
  <div class="top-bg featured page-heading" style="background-color: black">
        <div class="content-block custom-content-block">
            <h1 class="word-capitalize"><?= get_field('about_top_title') ?></h1>
            <p><?= get_field('about_top_subtitle') ?></p>
        </div>
    </div> 
<div class="section custom-section-about">
<div class="container custom-about">
<div class="title">
                <h2><?= get_field('about_top_title')?></h2>
            </div>
</div>
</div>
   
    <?php if(have_rows('about_features')): ?>
        <div class="section custom-about-top-section">
<div class="container custom-about">
<p><?= get_field('about_top_subtitle') ?></p>
</div>
            <div class="container">
                <div class="title">
                    <h2><?= get_the_title() ?></h2>
                </div>
                <ul class="about-list">
                    <?php while(have_rows('about_features')): the_row(); ?>
                        <?php
                        $title=get_sub_field('feature_title');
                        $icon=get_sub_field('feature_icon');
                        $description=get_sub_field('feature_description');

                        if ($title):?>
                            <li>
                                <?php if($icon): ?>
                                    <figure style="background-image: url('<?= $icon ?>');"></figure>
                                <?php endif; ?>

                                <h3><?= $title ?></h3>

                                <?php if($description): ?>
                                    <p><?= $description ?></p>
                                <?php endif; ?>
                            </li>
                            <?php
                        endif; ?>

                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>


    <?php if(have_rows("about_partners")): ?>
        <div class="section" style="background-color: #f8fcff;">
            <div class="container">
                <div class="title">
                    <h2><?= get_field('about_partners_title') ?></h2>
                </div>

                <ul class="partners-list">
                    <?php while(have_rows('about_partners')): the_row(); ?>
                        <?php
                        $logo=get_sub_field('partner_logo');
                        $title=get_sub_field('partner_title');
                        $description=get_sub_field('partner_description');

                        if($title):?>

                            <li>
                                <?php if(isset($logo['sizes']['medium'])): ?>
                                    <figure>
                                        <img src="<?= $logo['sizes']['medium'] ?>" alt="">
                                    </figure>
                                <?php endif; ?>
                                <div class="info">
                                    <h3><?= $title ?></h3>
                                    <?php if($description): ?>
                                        <p><?= $description ?></p>
                                    <?php endif; ?>
                                </div>
                            </li>

                            <?php
                        endif; ?>

                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

<?php endwhile; ?>

<?php
get_footer();
