<?php
/**
 * Template name: ABOUT US CHILD TEMPLATE RIGHT FORM
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-about">
    <div class="container custom-about">
        <div class="enterprise-content-top" style="margin-top:75px;"> </div>
             <div class="title">
        <?php $description=get_field('enterprise_child_description'); ?>
		     </div>
             <div>
             <p><?= $description ?></p>
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
