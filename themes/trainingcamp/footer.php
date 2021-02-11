<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package trainingcamp
 */
?>
			<?php if(!is_front_page()): ?>
				</div>
			<?php endif; ?>

			<footer class="footer_">

				<?php if(get_field('action_url','options')): ?>
					<div class="container">
						<form id="subscribe" class="subscribe-form" action="<?= get_field('action_url','options') ?>">
							<?= get_field('form_description','options') ?>
							<div class="form-wrap">
								<div class="form-row form-row-wide large-input">
									<input type="text" name="EMAIL" placeholder="your email address">
									<button type="submit">submit</button>
								</div>
							</div>
							<div class="subscribe-result"></div>
						</form>
					</div>
				<?php endif; ?>


				<div class="footer-wrap">
					<div class="container">
						<nav class="footer-nav">
							<?php
							$defaults = array(
								'menu' => 'Footer Menu',
								'container' => '',
								'menu_id' => '',
								'echo' => true,
								'fallback_cb' => 'wp_page_menu',
								'depth' => 0,
								'items_wrap' => '<ul class="footer-menu">%3$s</ul>',
							);
							wp_nav_menu($defaults);
							?>
							<?php get_template_part('template-parts/footer','social-links') ?>
						</nav>
					</div>
					<div class="container small">
						<div class="copy">
							<p>&copy;1999 - <?= date('Y') ?> <?= get_field('copyright_description','options') ?></p>
							<?php
							$relation_page=get_field('relation_page_copyright','options');
							if(isset($relation_page[0])):
								?>
								<p><a href="<?= get_permalink($relation_page[0]) ?>"><?= get_the_title($relation_page[0]) ?></a></p>
								<?php
							endif; ?>
						</div>
					</div>
				</div>


			</footer>

		</main>

		<div class="popups"></div>

		<?php wp_footer(); ?>

	</body>

</html>