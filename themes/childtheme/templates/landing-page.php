<?php
/**
 * Template name: Landing Page
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="section custom-section-landing-page">
	
	<div class="banner">
		<div class="bg" style="background-image:url(<?php the_field('banner_background_image');?>)"></div>
		
		<div class="container">
		
			<div class="top">
				
				<div class="banner-text">
					<?php the_field('banner_copy');?>				
				</div>
				
			</div>
			
			<div class="bottom">
				<?php 
				$link = get_field('banner_cta_button');
				if( $link ): 
				    $link_url = $link['url'];
				    $link_title = $link['title'];
				    $link_target = $link['target'] ? $link['target'] : '_self';
				    ?>
				    <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endif; ?>
			</div>
			
		</div>
		
	</div>
	
    <div class="custom-landing-page s1">
	    
	    <div class="container">
		    
		    <div class="four-col-wrap">
			    
			    <h2 class="dash-bg"><?php the_field('s1_four_column_row_heading');?></h2>
			    
			    <div class="inner">
				    
				    <?php if( have_rows('s1_four_column_row') ):?>
				    	<?php while ( have_rows('s1_four_column_row') ) : the_row();?>	
						<?php if( have_rows('single_column') ):?>
							<?php while ( have_rows('single_column') ) : the_row();?>
							
							<div class="singe-col">
								<h3><?php the_sub_field('heading');?></h3>
								<p><?php the_sub_field('copy');?></p>	
							</div>
							<?php endwhile;?>
						<?php endif;?>				    
				    	<?php endwhile;?>
				    <?php endif;?>
				    
			    </div>			    
			    
		    </div>
		    
		    <div class="copy-wrap">
			    <?php the_field('s1_copy');?>
		    </div>
		    
		    <div class="s1-ctas-with-images">
			    <?php if( have_rows('s1_ctas_with_images') ):?>
			    	<?php while ( have_rows('s1_ctas_with_images') ) : the_row();?>	
			    	<?php if( have_rows('single_cta') ):?>
			    		<?php while ( have_rows('single_cta') ) : the_row();?>	
						
						<div class="ctas-with-images">
							<div class="inner">
								<div class="left">
									<?php 
									$image = get_sub_field('image');
									if( !empty( $image ) ): ?>
									<div class="img-wrap">
									    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
									</div>
									<?php endif; ?>
								</div>
								
								<div class="right">
									<h3><?php the_sub_field('heading');?></h3>
									<p><?php the_sub_field('text');?></p>
								</div>
							</div>
						</div>
						
			    		<?php endwhile;?>
			    	<?php endif;?>
			    	<?php endwhile;?>
			    <?php endif;?>
		    </div>
		    
	    </div>
	    
		<div class="sticky-form-wrap">
			
			<div class="inner">
			
				<div class="top">
					
					<h2><?php the_field('form_heading');?></h2>
		
					<?php 
					$link = get_field('form_cta_button');
					if( $link ): 
					    $link_url = $link['url'];
					    $link_title = $link['title'];
					    $link_target = $link['target'] ? $link['target'] : '_self';
					    ?>
					    <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
					
				</div>
				
				<div class="break"></div>
				
				<div class="bottom">
					<?php the_field('form');?>
				</div>
				
			</div>
			
		</div>
	    
	</div>
	
	
    <div class="custom-landing-page s2">
		<div class="bg" style="background-image:url(<?php the_field('s2_background_image');?>)"></div>
	    
	    <div class="container">
		    
		    <?php if( have_rows('s2_cards_and_copy') ):?>
		    	<?php while ( have_rows('s2_cards_and_copy') ) : the_row();?>	
		    	
		    	<?php if( have_rows('single_card_and_copy') ):?>
		    		<?php while ( have_rows('single_card_and_copy') ) : the_row();?>	

		    	<div class="single-card">
			    	
			    	<div class="inner">
			    	
				    	<div class="top">
					    	<div class="heading"><?php the_sub_field('card_heading');?></div>
					    	<div class="sub-heading"><?php the_sub_field('card_sub-heading');?></div>
					    	
					    	<p><?php the_sub_field('copy');?></p>
					    	
							<?php 
							$image = get_sub_field('card_image');
							if( !empty( $image ) ): ?>
							<div class="img-wrap">
							    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
							</div>
							<?php endif; ?>					    	
					    	
				    	</div>
				    	
				    	<div class="bottom">
					    	
					    	<?php the_sub_field('copy');?>
					    	
				    	</div>
			    	
			    	</div>
			    	
		    	</div>
		    	
			    	<?php endwhile;?>
			    <?php endif;?>		    	
		    
		    	<?php endwhile;?>
		    <?php endif;?>
		    
	    </div>
	    
    </div>
    
    
    <div class="custom-landing-page s3">
	    <div class="container">
		    
		    <div class="left">
			    <h2 class="dash-bg"><?php the_field('s3_heading');?></h2>
			    <div class="copy-wrap"><?php the_field('s3_copy');?></div>
				<?php 
				$link = get_field('s3_cta_link');
				if( $link ): 
				    $link_url = $link['url'];
				    $link_title = $link['title'];
				    $link_target = $link['target'] ? $link['target'] : '_self';
				    ?>
				    <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endif; ?>
		    </div>

		    <div class="right">
			    <?php if( have_rows('s3_icon_and_text_cards') ):?>
			    	<?php while ( have_rows('s3_icon_and_text_cards') ) : the_row();?>	
					<?php if( have_rows('single_card') ):?>
						<?php while ( have_rows('single_card') ) : the_row();?>	
						
						<div class="single-card">
							<div class="left">
								<?php 
								$image = get_sub_field('icon');
								if( !empty( $image ) ): ?>
								<div class="img-wrap">
								    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								</div>
								<?php endif; ?>	
							</div>
							<div class="right">
								<h4><?php the_sub_field('heading');?></h4>
								<p><?php the_sub_field('copy');?></p>
							</div>
						</div>
					
						<?php endwhile;?>
					<?php endif;?>			    
			    	<?php endwhile;?>
			    <?php endif;?>
		    </div>
		    
	    </div>
    </div>
    
    
    <div class="custom-landing-page s4">
	    <div class="container">

		    <div class="left">
			    <h2 class="dash-bg"><?php the_field('s4_heading');?></h2>
				<?php 
				$image = get_field('s4_logo');
				if( !empty( $image ) ): ?>
				<div class="img-wrap">
				    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
				</div>
				<?php endif; ?>	
			    <div class="copy-wrap"><?php the_field('s4_copy');?></div>
		    </div>

		    <div class="right">
			    <?php if( have_rows('s4_icon_and_text_cards') ):?>
			    	<?php while ( have_rows('s4_icon_and_text_cards') ) : the_row();?>	
					<?php if( have_rows('single_card') ):?>
						<?php while ( have_rows('single_card') ) : the_row();?>	
						
						<div class="single-card">
							<div class="left">
								<?php 
								$image = get_sub_field('icon');
								if( !empty( $image ) ): ?>
								<div class="img-wrap">
								    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								</div>
								<?php endif; ?>	
							</div>
							<div class="right">
								<h4><?php the_sub_field('heading');?></h4>
								<p><?php the_sub_field('copy');?></p>
							</div>
						</div>
					
						<?php endwhile;?>
					<?php endif;?>			    
			    	<?php endwhile;?>
			    <?php endif;?>
		    </div>		    
		    
	    </div>
    </div>

	<?php if( have_rows('faq_accordions') ):?>
    <div class="custom-landing-page s5">
	    <div class="container">
		    
		    <h2 class="dash-bg">FAQ</h2>
		    
		    <div class="faq-accordion">
			    		    
			    <?php while ( have_rows('faq_accordions') ) : the_row();?>	
			    
				    <?php if( have_rows('single_faq') ):?>
				    	<?php while ( have_rows('single_faq') ) : the_row();?>
				    
						<h3><?php the_sub_field('question');?></h3>
						
						<div>
							<?php the_sub_field('answer');?>
						</div>
					
				    	<?php endwhile;?>
				    <?php endif;?>
				
				<?php endwhile;?>
			    
		    </div>
		    
	    </div>
    </div>
    <?php endif;?>
    
    
    <div class="custom-landing-page s5">
	    <div class="container">
		
		<div class="left">
			<?php the_field('featured_heading');?>
		</div>
		    
		<div class="right">
			
		<?php 
		$images = get_field('featured_logos');
		if( $images ): ?>
		        <?php foreach( $images as $image ): ?>
		            <div class="logo-wrap">
		                <a href="<?php echo esc_url($image['url']); ?>">
		                     <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
		                </a>
		                <p><?php echo esc_html($image['caption']); ?></p>
		            </div>
		        <?php endforeach; ?>
		<?php endif; ?>
			
		</div>
		    
	    </div>
    </div>
    
    
    <div class="custom-landing-page s5">
	    <div class="container">
		  
			<div class="left">
				<h2><?php the_field('s7_heading');?></h2>
				<p><?php the_field('s7_copy');?></p>
				
				<?php 
				$link = get_field('s7_cta_link');
				if( $link ): 
				    $link_url = $link['url'];
				    $link_title = $link['title'];
				    $link_target = $link['target'] ? $link['target'] : '_self';
				    ?>
				    <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endif; ?>
				
			</div>  
	
			<div class="right">
				
				<h2 class="dash-bg"><?php the_field('s7_cta_link_rows_header');?></h2>

				<?php if( have_rows('s7_cta_link_rows') ):?>
				<div class="rows">
					<?php while ( have_rows('s7_cta_link_rows') ) : the_row();?>	
				
					<div class="single-row">
						<?php 
						$link = get_sub_field('single_link');
						if( $link ): 
						    $link_url = $link['url'];
						    $link_title = $link['title'];
						    $link_target = $link['target'] ? $link['target'] : '_self';
						    ?>
						    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <img src="/wp-content/themes/trainingcamp/slice/assets/images/arrow.svg"/></a>
						<?php endif; ?>						
					</div>
				
					<?php endwhile;?>
				</div>
				<?php endif;?>													
				
			</div> 
		    
	    </div>
    </div>
    
	
</div> <!-- end custom-section-landing-page -->

<link rel="stylesheet" href="https://use.typekit.net/imu7eop.css">
<link rel="stylesheet" href="/wp-content/themes/childtheme/landing-page-style.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/wp-content/themes/trainingcamp/js/landing-page.js"></script>

<?php endwhile;?>



<?php
get_footer();


