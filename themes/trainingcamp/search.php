<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package trainingcamp
 */

get_header();
global $wp_query;
?>
	<div class="section">
		<div class="container">

			<div class="title">
				<h2>Search results</h2>
			</div>


			<form role="search" method="get" action="<?php echo home_url( '/' );?>" id="search-form">
				<div class="form-wrap">
					<div class="form-row form-row-wide large-input">
						<input type="search" name="s" placeholder="search for something...">
						<?php if (isset($_GET['per-page']) && in_array($_GET['per-page'],per_pages())): ?>
							<input type="hidden" name="per-page" value="<?= $_GET['per-page'] ?>">
						<?php endif; ?>
						<?php if(isset($_GET['special']) && $_GET['special']=='on'): ?>
							<input type="hidden" name="special" value="on">
						<?php endif; ?>
						<?php if(isset($_GET['guaranteed']) && $_GET['guaranteed']=='on'): ?>
							<input type="hidden" name="guaranteed" value="on">
						<?php endif; ?>

						<button type="submit"></button>
					</div>
				</div>
			</form>


			<form action="<?= home_url( '/' ) ?>" method="get" id="manage-results">
				<input type="hidden" name="s" value="<?= get_search_query() ?>">
				<?php if (isset($_GET['per-page']) && in_array($_GET['per-page'],per_pages())): ?>
					<input type="hidden" name="per-page" value="<?= $_GET['per-page'] ?>">
				<?php endif; ?>
				<div class="form-wrap">
					<div class="form-row form-row-first">
						<input type="checkbox" name="special" id="special" <?php if(isset($_GET['special']) && $_GET['special']=='on') echo 'checked' ?>>
						<label for="special">Special offers</label>
					</div>
					<div class="form-row form-row-last">
						<input type="checkbox" name="guaranteed" id="guaranteed" <?php if(isset($_GET['guaranteed']) && $_GET['guaranteed']=='on') echo 'checked' ?>>
						<label for="guaranteed">Guaranteed to Run</label>
					</div>
				</div>
			</form>


			<?php if(have_posts()): ?>

				<div class="results-header">
					<div class="columns">

						<div class="col">
							<p>
								About <span class="qty"><?= $wp_query->found_posts ?></span> results found for
								<strong class="query">"<?= get_search_query() ?>"</strong>
							</p>
						</div>

						<div class="col">
							<form action="<?= home_url( '/' ) ?>" method="get" id="per_page">
								<input type="hidden" name="s" value="<?= get_search_query() ?>">
								<?php if(isset($_GET['special']) && $_GET['special']=='on'): ?>
									<input type="hidden" name="special" value="on">
								<?php endif; ?>
								<?php if(isset($_GET['guaranteed']) && $_GET['guaranteed']=='on'): ?>
									<input type="hidden" name="guaranteed" value="on">
								<?php endif; ?>
								<?php $per_pages=per_pages() ?>
								<p>
									Results per page:
									<?php foreach ($per_pages as $per_page): ?>
										<?php $checked=(isset($_GET['per-page']) && $_GET['per-page']==$per_page) ? 'checked' : '' ?>
										<input type="radio" name="per-page" id="qty-<?= $per_page ?>" value="<?= $per_page ?>" <?= $checked ?>>
										<label for="qty-<?= $per_page ?>"><?= $per_page ?></label>
									<?php endforeach; ?>
								</p>
							</form>
						</div>

					</div>
				</div>


				<div class="results-list">
					<ul>
						<?php while (have_posts()): the_post(); ?>

							<li>
								<a href="<?= get_permalink(); ?>"><h5><?= get_the_title() ?></h5></a>
								<p><?php the_excerpt(); ?></p>
							</li>

						<?php endwhile; ?>
					</ul>
				</div>

				<?php if(function_exists('wp_pagenavi')){ wp_pagenavi(); } ?>

			<?php else: ?>

				<div class="results-list">
					<p class="not-found">Nothing Found!</p>
				</div>

			<?php endif; ?>

		</div>
	</div>


<script>
	$(document).ready(function(){
		var form=$('form#manage-results');
		var form2=$('form#per_page');
		form.find('input[type="checkbox"]').on('change',function(){
			form.submit();
		});
		form2.find('input[type="radio"]').on('change',function(){
			form2.submit();
		});
	});
</script>

<?php
get_footer();