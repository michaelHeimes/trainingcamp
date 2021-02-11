<?php
/**
 * Template name: Contact us
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-about">
    <div class="container custom-about">
    
        <div class="enterprise-content-top"> </div>
        <div class="title">
        <?php
            $description=get_field('enterprise_child_description');
        ?>
			<h2><?=get_the_title()?></h2>            
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
