<?php
/**
 * Template name: Enterprise solutions Template
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-about">
    <div class="container custom-about">
    
        <div class="enterprise-content-top"> </div>
        <div class="title">
        <?php
            $description=get_field('enterprise_description');
        ?>
			<h2><?=get_the_title()?></h2>            
		</div>
        <div>
        <p><?= $description ?></p>
        </div>

           <?php
    $top_content=get_field('enterprise_top_content');
    ?>
            <div> <?= $top_content ?> </div>
    <section>
    <div class="row enterprise-solutions-content-row">
    <?php
    $left_content=get_field('enterprise_left_content');
    $right_content=get_field('enterprise_right_content');
    $bottom_content=get_field('enterprise_bottom_content');
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

    <script>
        $(function () {
            $(".flex-slide").each(function () {
                $(this).hover(function () {
                    $(this).find('.flex-title').css({
                    });
                        top: '25%'
                    $(this).find('.flex-about').css({
                        opacity: '1'
                    });
                }, function () {
                    $(this).find('.flex-title').css({
                        top: '45%'
                    });
                    $(this).find('.flex-about').css({
                        opacity: '0'
                    });
                })
            });
        });
    </script>
</div>

<?php endwhile; ?>

<?php
get_footer();
