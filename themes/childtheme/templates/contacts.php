<?php
/**
 * Template name: Contact us1
 */

get_header();?>
<style>
    .screen-reader-response, .wpcf7-not-valid-tip{
        display: none !important;
    }
</style>
<?php while (have_posts()): the_post();?>
				    <div class="section">
				        <div class="container">
				            <div class="title">
				                <h2><?=get_the_title()?></h2>
				            </div>
				        </div>
	                    <div class="row">
		            <div class="contact-blocks">
		            <?php while (have_rows('contact_box_content')): the_row();?>
				                    <div class="flex">
				                        <?php
        $title = get_sub_field('contact_box_title');
        $icon = get_sub_field('contact_box_icon');
        $description = get_sub_field('contact_box_description');
        $tel_number = get_sub_field('contact_box_phone_number');
     
				       $email = get_sub_field('contact_box_email');?>
				                        <div class="supporting-img">
				                            <img src='<?= $icon ?>'>
				                        </div>
				                        <div class="block-content">
				                            <h3><?=$title?></h3>
				                            <p><?=$description?></p>
				                            <p class="num"><a href="tel:<?=$tel_number?>"><?=$tel_number?></a></p>
				                            <p>
				                                <a href="mailto:<?=$email?>"><?=$email?></a>
				                            </p>
				                        </div>
				                    </div>
				            <?php endwhile;?>
		            </div>
		        </div>
		                <div class="container">
				            <div class="forms clearfix">
				                <div class="send-message">
				                    <?=do_shortcode('[contact-form-7 id="390" title="Contact form"]')?>
				                </div>

				                <div class="contact-info">
				                    <?php the_content();?>
				                </div>
				            </div>
				        </div>
				   </div>

<?php endwhile; ?>
<?php get_footer();
