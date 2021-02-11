<?php
/**
 * Template name: CISSP Product
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-about">
    <div class="container custom-about">
             <div class="title" style="background-color:black;">
                   <?php $description=get_field('enterprise_child_description'); ?>
             </div>
             <div>
                   <p><?= $description ?></p>
             </div>
             <div style="background-color:white;">
            <?php $description2=get_field('enterprise_child_description2'); ?>
             <p><?= $description2 ?></p>
             </div>

        <section style="margin-top:20px;">
        <div class="row enterprise-solutions-content-row">
        <?php
        $left_content=get_field('enterprise_child_left_content');
        $right_content=get_field('enterprise_child_right_content');
        $bottom_content=get_field('enterprise_child_bottom_content');
        ?>
            <div class="column enterprise-solutions-content-column-1">
                <div style="text-align:left;"> <?= $left_content ?> </div>
            </div>
        <div class="column enterprise-solutions-content-column-2">
        <div> <?= $right_content ?> </div>
        </div>
    </div>
       <div> <?= $bottom_content ?>
       </div>
    </section>
</div>
</div>
<?php endwhile; ?>

<?php
get_footer();
