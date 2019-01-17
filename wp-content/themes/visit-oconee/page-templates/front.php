<?php
/*
Template Name: Front
*/
get_header(); ?>

<div id="page" role="main">

	<?php // get_template_part('template-parts/video'); ?>

	<div class="slider-container">
	    <ul class="bxslider">
			<?php if( have_rows('slides') ):
				while ( have_rows('slides') ) : the_row(); ?>
	                <li>
	                	<?php
		                $link = get_sub_field('link_to');
		                if ($link != '') : ?>
		                    <a href="<?php echo get_sub_field('link_to'); ?>">
			            <?php endif; ?>
							<?php echo wp_get_attachment_image(get_sub_field('slide'), 'featured-home'); ?>
						<?php if ($link != '') : ?>	
	                    	</a>
	                    <?php endif; ?>
	                </li>
				<?php endwhile;
			endif; ?>
	    </ul>
	    <div class="slider-overlay text-center">
		    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/visit-oconee-logo.png" alt="Visit Oconee South Carolina logo">
		    <h1>Oconee, South Carolina is a<br /><span>cool place to play!</span></h1>
	    </div>
	</div> <!-- slider-container -->

	<section class="videos">
		<div class="grid-container">
	   		<div class="grid-x">
	   			<?php if(get_field('videos')): ?>
	   				<?php while(has_sub_field('videos')): ?>
	   					<div class="large-4 medium-4 cell home-video text-center">
		   					<a href="<?php echo get_sub_field('video_url'); ?>?autoplay=1&modestbranding=1&showinfo=0&rel=0" data-featherlight="iframe" data-featherlight-iframe-width="960" data-featherlight-iframe-height="540">
		   						<?php echo wp_get_attachment_image(get_sub_field('video_thumbnail'), 'home-video'); ?>
		   						<?php get_template_part('assets/images/play', 'button.svg'); ?>
		   					</a>
	   					</div>
	   				<?php endwhile; ?>
	   			<?php endif; ?>
	   		</div> <!-- grid-x -->
	   	</div> <!-- grid-container -->	   			
	   	<div class="home-quote text-center">
			<div class="quote-wrapper">
				<?php echo wp_get_attachment_image(get_field('quote_image'), 'full'); ?>
				<h2><i><?php echo get_field('quote'); ?></i></h2>
				<p><?php echo get_field('quote_author'); ?></p>
			</div>
	   	</div>
	</section> <!-- videos -->
	
	<section class="home-blocks">
	   	<div class="grid-x">		
			<?php if(get_field('home_blocks')): ?>
				<?php while(has_sub_field('home_blocks')): ?>
					<div class="large-4 medium-4 cell home-block">
		   				<?php $link = get_sub_field('link'); ?>
						<a href="<?php echo $link['url']; ?>" <?php if ($link['target'] != '') : ?>target="<?php echo $link['target']; ?>"<?php endif; ?>>
							<?php echo wp_get_attachment_image(get_sub_field('image'), 'home-block'); ?>
							<div class="home-block-hover">
								<?php if (get_sub_field('image_hover')) : ?>
									<?php echo wp_get_attachment_image(get_sub_field('image_hover'), 'home-block'); ?>
								<?php else : ?>
									<?php echo wp_get_attachment_image(get_sub_field('image'), 'home-block'); ?>
								<?php endif; ?>
							</div>
							<div class="home-block-overlay">
								<div style="display:table;width:100%;height:100%;">
								  <div style="display:table-cell;vertical-align:middle;">
								    <div style="text-align:center;"><?php echo get_sub_field('title'); ?></div>
								  </div>
								</div>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
	   	</div>
	</section> <!-- home-blocks -->
	
	<!--
	<section class="home-cats">
		<div class="grid-container">
	   		<div class="grid-x">
		   		<?php	
			   	$play_cat_id = 28;
		   		$args = array( 
				    'hide_empty' => 0,
				    'parent' => 0,
				);
				$terms = get_terms( 'poi_cats', $args );
				foreach ( $terms as $term ) {
					$icon = get_field('product_feature_image', $term );
					?>
					<div class="large-3 medium-3 small-6 cell text-center">
					    <a class="transition cat-link" href="<?php echo get_term_link( $term, 'poi_cats' ); ?>" title="View all <?php echo $term->name; ?>">
						    <?php echo file_get_contents(get_field('category_icon', $term)); ?>
						    <?php echo $term->name; ?>
						</a>
					</div>
				<?php } ?>
	   		</div>
		</div>
	</section> <!-- home-cats -->
	
	
	<section class="destinations">
		<div class="grid-container">
	   		<div class="grid-x grid-padding-x">
		   		<div class="large-12 cell text-center">
			   		<h2>Seasonal Trending<br /><span>Destinations</span></h2>		
		   		</div>
		   		<?php if(get_field('seasonal_destinations')): ?>
		   			<?php while(has_sub_field('seasonal_destinations')): ?>
		   				<?php
			   			$title = get_sub_field('title');
			   			$subtitle = get_sub_field('subtitle');
			   			$image = get_sub_field('image');
			   			$blurb = get_sub_field('blurb');
			   			$link_array = get_sub_field('link');
			   			$target = "";
		   				$dest = get_sub_field('select_destination');
		   				$dest_id = $dest->ID;
		   				if (!$link_array) {
			   				$link = get_permalink($dest_id);
		   				} else {
			   				$link = $link_array['url'];
			   				$target = $link_array['target'];
		   				}
		   				if (!$title) {
			   				$title = get_the_title($dest_id);
		   				}
		   				if (!$subtitle) {
			   				$subtitle = get_field('subtitle', $dest_id);
		   				}
		   				if (!$image) {
			   				$image = get_post_thumbnail_id( $dest_id );
		   				}
		   				?>
		   				<div class="large-4 medium-4 cell dest-cell">
		   					<a href="<?php echo $link; ?>" <?php if ($target != '') : ?>target="<?php echo $target; ?>"<?php endif; ?>>
			   					<?php echo wp_get_attachment_image($image, 'home-block'); ?>
			   					<h3><?php echo $title; ?></h3>
			   					<h4><?php echo $subtitle; ?></h4>
								<p><?php echo $blurb; ?></p>	
		   					</a>
		   				</div>
		   				
		   			<?php endwhile; ?>
		   		<?php endif; ?>
	   		</div>
		</div>
	</section> <!-- destinations -->

	<section class="tips">
		<div class="grid-container">
	   		<div class="grid-x grid-padding-x">
		   		<div class="large-12 cell text-center">
			   		<h2>Explore Curated<br /><span>Travel Tips</span></h2>		
		   		</div>
		   		<?php if(get_field('travel_tips')): ?>
		   			<?php while(has_sub_field('travel_tips')): ?>
		   				<?php
			   			$title = get_sub_field('title');
			   			$subtitle = get_sub_field('subtitle');
			   			$image = get_sub_field('image');
			   			$blurb = get_sub_field('blurb');
			   			$link_array = get_sub_field('link');
			   			$target = "";
		   				// $dest = get_sub_field('tip');
		   				// $dest_id = $dest->ID;
		   				if (!$link_array) {
			   				$link = get_permalink($dest_id);
		   				} else {
			   				$link = $link_array['url'];
			   				$target = $link_array['target'];
		   				}
		   				if (!$title) {
			   				$title = get_the_title($dest_id);
		   				}
		   				if (!$subtitle) {
			   				$subtitle = get_field('subtitle', $dest_id);
		   				}
		   				if (!$image) {
			   				$image = get_post_thumbnail_id( $dest_id );
		   				}
		   				?>
		   				<div class="large-4 medium-4 cell dest-cell">
		   					<a href="<?php echo $link; ?>" <?php if ($target != '') : ?>target="<?php echo $target; ?>"<?php endif; ?>>
			   					<?php echo wp_get_attachment_image($image, 'home-block'); ?>
			   					<h3><?php echo $title; ?></h3>
			   					<h4><?php echo $subtitle; ?></h4>
								<p><?php echo $blurb; ?></p>	
		   					</a>
		   				</div>
		   				
		   			<?php endwhile; ?>
		   		<?php endif; ?>
	   		</div>
		</div>
	</section> <!-- tips -->
	
	<section class="instagram">
		<div class="grid-container">
	   		<div class="grid-x grid-padding-x">
		   		<div class="large-12 cell text-center">
			   		<h2>Follow Us On<br /><span>@VisitOconeeSC</span></h2>		
		   		</div>		   		
		   		<div class="large-12 cell text-center">
		   			<?php echo do_shortcode('[instagram-feed]'); ?>
		   			<div class="button large"><a href="https://www.instagram.com/visitoconeesc/" target="_blank">View All</a></div>
		   		</div>
	   		</div>
		</div>
	</section> <!-- instagram -->


</div> <!-- #page -->

<script>
if (typeof bxSlider === "function") { 	
    var slider = jQuery('.bxslider').bxSlider({
        auto: true,
        pager: false,
        controls: true,
        mode: 'fade',
        speed: 1000,
        pause: 7000
    });	
} else {
	jQuery(window).load(function(){
    	var slider = jQuery('.bxslider').bxSlider({
    	    auto: true,
    	    pager: false,
    	    controls: true,
    	    mode: 'fade',
    	    speed: 1000,
    	    pause: 7000
    	});		
	});
}

jQuery(document).one('scroll', function() {
	jQuery('#masthead').addClass('scrolled');
	jQuery('#masthead').addClass('headroom--pinned');
	jQuery('.slider-overlay img').addClass('fade-out');
});

</script>

<?php get_footer(); ?>