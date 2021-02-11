<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package trainingcamp
 */

get_header(); ?>
<?php while(have_posts()): the_post();
	$subtitle_1=get_field('subtitle_top_section');
	$subtitle_2=get_field('subtitle_before_content');

	$background_url = get_the_post_thumbnail_url(get_the_ID(), 'prod_single_img');
	$background_url = ($background_url) ?: get_template_directory_uri() . '/slice/dist/images/courses-group-bg.jpg';
	?>

	<div class="top-bg" style="background-image: url('<?= get_template_directory_uri() ?>/slice/dist/images/courses-group-bg.jpg');">
		<div class="content-block">
			<h1><?= get_the_title() ?></h1>
			<?php if($subtitle_1): ?>
				<p><?= $subtitle_1 ?></p>
			<?php endif; ?>
		</div>
	</div>


		<div class="section">
		<div class="container small">
			<div class="content">
				<?php if($subtitle_2): ?>
					<div class="title">
						<h2><?= $subtitle_2 ?></h2>
					</div>
				<?php endif; ?>

				<?php the_content() ?>			</div>
		</div>
	</div>

<?php endwhile; ?>
<?php
get_footer();
