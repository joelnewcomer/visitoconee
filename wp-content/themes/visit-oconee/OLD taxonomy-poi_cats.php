<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
get_header();
date_default_timezone_set(get_option('timezone_string'));
?>

<div class="featured-container">
	<?php
	$term = get_queried_object();
	$image_id = get_field('feature_image', $term);
	// Default Featured Image
	if ($image_id == null) {
		$image_id = get_theme_mod( 'default_featured' );
	}
	?>	
	<div class="featured-image blog-landing-featured">
		<?php echo wp_get_attachment_image($image_id,'featured'); ?>
		<div class="overlay">
			<div class="blog-header blog-header-1 text-center">
				<div style="display:table;width:100%;height:100%;">
					<div style="display:table-cell;vertical-align:middle;">
				    	<div style="text-align:center;">
					    	<?php
						    global $title;
							$title = single_term_title("", false);
						    ?>
					    	<h1 class="entry-title"><?php echo $title; ?></h1>
				    	</div>
					</div>
				</div>
			</div> <!-- blog-header -->
		</div> <!-- overlay -->
	</div> <!-- blog-landing-featured -->
</div> <!-- featured-container -->

<div class="tax-sub-cats">
	<div class="grid-container">
		<div class="grid-x grid-margin-x clear">
			<div class="large-12 cell text-center">
				<div class="cat-filter active" data-filter="all">
					<?php get_template_part('assets/images/eat', 'all-icon.svg'); ?><br />
					<h3>All</h3>
				</div>
				<?php
				$args = array( 
				    'hide_empty' => false,
				    'child_of' => $term->term_id,
				);
				$child_terms = get_terms( 'poi_cats', $args );
				foreach ( $child_terms as $child_term ) { ?>
					<div class="cat-filter" id="<?php echo $child_term->slug; ?>-filter" data-filter="<?php echo $child_term->slug; ?>">
						<?php echo file_get_contents(get_field('category_icon', $child_term)); ?>
						<h3><?php echo $child_term->name; ?></h3>
					</div>
				<?php } ?>
			</div>
		</div> <!-- grid-x -->
	</div> <!-- grid-container -->
</div> <!-- tax-sub-cats -->	

<div id="page" role="main" class="blog-grid">
	<div class="grid-container">
    	<div class="grid-wrapper">
        	<article class="grid-x grid-margin-x clear">
        		<?php if ( have_posts() ) : ?>
	    		    <?php while ( have_posts() ) : the_post(); ?>
	    		    	<?
		    		    $website = get_field('website');
		    		    $address = get_field('address');
		    		    $phone = get_field('phone');
		    		    $day_of_week = strtolower(date('l', time()));
		    		    $hours = get_field('hours_' . $day_of_week);
		    		    $social = array();
		    		    if (get_field('social_instagram') != '') {
			    		    $social['instagram'] = get_field('social_instagram');
			    		}
			    		if (get_field('social_facebook') != '') {
			    		    $social['facebook'] = get_field('social_facebook');
			    		}
			    		if (get_field('social_twitter') != '') {
			    		    $social['twitter'] = get_field('social_twitter');
			    		}
		    		    $terms = wp_get_post_terms( $post->ID, 'poi_cats', array("fields" => "slugs") );
		    		    $classes = implode(" ", $terms);
		    		    ?>
						<div class="large-4 medium-6 cell poi-card transition <?php echo $classes; ?>" data-pop="<?php echo $post->post_name; ?>">
							<div class="clickable">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>
							<div class="poi-card-content">
								<h3 class="clickable"><?php the_title(); ?></h3>
								<p class="clickable"><?php echo wp_trim_words( get_field('pop-up_content'), 20, '...' ); ?></p>
								<div class="poi-links">
									<span class="clickable poi-link poi-more">More Info</span>
									<?php if ($website != '') : ?>
										<a class="poi-link" href="<?php echo $website; ?>" target="_blank">Website</a>
									<?php endif; ?>
								</div> <!-- poi-links -->
								<div class="poi-social">
								<?php foreach( $social as $social_name => $social_url ) : ?>
									<?php
									echo '<a href="' . $social_url . '" class="' . $social_name . '" target="_blank">';
									get_template_part('assets/images/social/' . $social_name , 'official.svg');
									echo '</a>';
									?>
								<?php endforeach; ?>
								</div> <!-- poi-social -->
								<div class="poi-itinerary">
									<?php get_template_part('assets/images/itinerary', 'icon.svg'); ?>
									<div><span class="caps">Add</span> to my itinerary</div>
								</div>
							</div> <!-- poi-card-content -->
							<div class="poi-modal transition">
								<div style="display:table;width:100%;height:100%;">
									<div style="display:table-cell;vertical-align:middle;">
										<div class="modal-inner">
											<div class="close-modal"><?php get_template_part('assets/images/close', 'icon.svg'); ?></div>
											<div class="poi-gallery" data-featherlight-gallery data-featherlight-filter="a">
												<?php if(get_field('additional_photos')): ?>


													    <div class="carousel-container">
															<div class="bxslider">
													<?php while(has_sub_field('additional_photos')): ?>
													

														<div>
														<?php if (get_sub_field('media_type') == 'Photo') : ?>
															<?php $src = wp_get_attachment_image_src(get_sub_field('photo'), 'full'); ?>
															<a href="<?php echo $src[0]; ?>">
																<?php echo wp_get_attachment_image(get_sub_field('photo'), 'carousel'); ?>
															</a>
														<?php else : ?>
															<?php
															$video = get_sub_field('video'); // OEmbed Code
															$video_url = get_sub_field('video', FALSE, FALSE); // URL
															$video_thumb_url = get_video_thumbnail_uri($video_url); // thumbnail URL
															?>
															<a class="video" href="<?php echo $video_url; ?>?autoplay=1&modestbranding=1&showinfo=0&rel=0" data-featherlight="iframe" data-featherlight-iframe-width="960" data-featherlight-iframe-height="540">
																<img src="<?php echo $video_thumb_url; ?>"/>
															    <div class="play-overlay">
															        <?php get_template_part('assets/images/play', 'button.svg'); ?><br />
															    </div>
															</a>
														<?php endif; ?>
														</div>
																												
													<?php endwhile; ?>

														    </div> <!-- bxcarousel -->
    													</div> <!-- carousel-container -->

												<?php endif; ?>
											</div> <!-- gallery -->
											<h3><?php the_title(); ?></h3>
											<p><?php echo get_field('pop-up_content'); ?></p>
										</div> <!-- modal-inner -->
									</div>
								</div>
							</div> <!-- poi-modal -->
						</div> <!-- poi-card -->
					<?php endwhile; ?>
        		<?php else : ?>
        		    <?php get_template_part( 'template-parts/content', 'none' ); ?>
        		<?php endif; // End have_posts() check. ?>
        	</article>
	    </div> <!-- grid-wrapper -->
    </div> <!-- grid-container -->
</div> <!-- #page blog-grid -->

<script>
var carousel = '';	
	
jQuery( document ).ready(function() {
	var hash = window.location.hash;
	if (hash != '') {
		jQuery('.cat-filter').removeClass('active');
		jQuery(hash + '-filter').addClass('active');
	}
});

jQuery(".poi-card .clickable").on( "click", function() {
	jQuery('poi-modal').removeClass('active');
	jQuery(this).parents('.poi-card').find('.poi-modal').addClass('active');
	
    carousel = jQuery('.poi-modal.active .bxslider').bxSlider({
        auto: false,
        pager: false,
        controls: true,
        mode: 'horizontal',
        speed: 1000,
        pause: 7000,
        minSlides: 1,
        maxSlides: 3,
        slideWidth: 350,
        slideMargin: 16,
        moveSlides: 1,
        shrinkItems: true,
    });	
	
});

jQuery(".close-modal").on( "click", function(e) {
	jQuery('.poi-modal').removeClass('active');
	// Wait till animation completes before destroying slider
	setTimeout(function(){ carousel.destroySlider(); }, 1000);
});
</script>

<?php get_footer(); ?>