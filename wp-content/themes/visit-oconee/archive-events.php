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
get_header(); ?>

<div class="featured-container">
	<div class="featured-image blog-landing-featured">
		<img src=" <?php echo get_template_directory_uri(); ?>/assets/images/events-featured.jpg" alt="Events Image">
		<div class="overlay">
			<div class="blog-header blog-header-1 text-center">
				<div style="display:table;width:100%;height:100%;">
					<div style="display:table-cell;vertical-align:middle;">
				    	<div style="text-align:center;">
					    	<h1 class="entry-title">Events</h1>
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
					<?php get_template_part('assets/images/events', 'all-icon.svg'); ?><br />
					<h3>All</h3>
				</div>
				<?php
				$args = array( 
				    'hide_empty' => false,
				    'parent' => 0,
				);
				$child_terms = get_terms( 'events_cats', $args );
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
		    		    global $post;
		    		    $start_date = get_post_meta($post->ID, "start_date", true);
		    		    $end_date = get_post_meta($post->ID, "end_date", true);
		    		    $social = array();
		    		    $link = get_field('more_info_link');
		    		    $target = 'target="_blank"';
		    		    if ($link == '') {
			    		    $link = get_permalink($post->ID);
			    		    $target = '';
			    		} 
		    		    if (get_field('social_instagram') != '') {
			    		    $social['instagram'] = get_field('social_instagram');
			    		}
			    		if (get_field('social_facebook') != '') {
			    		    $social['facebook'] = get_field('social_facebook');
			    		}
			    		if (get_field('social_twitter') != '') {
			    		    $social['twitter'] = get_field('social_twitter');
			    		}
		    		    $terms = wp_get_post_terms( $post->ID, 'events_cats', array("fields" => "slugs") );
		    		    $classes = implode(" ", $terms);
		    		    ?>
						<div class="large-4 medium-6 cell event-card month-<?php echo date('n', $start_date); ?> transition <?php echo $classes; ?>">
							<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-card-month text-center">
								<?php echo date('F', $start_date); ?>
							</a>
							<div class="event-card-content">
								<a href="<?php echo $link; ?>" <?php echo $target; ?>>
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</a>
								<div class="date-range">
									<?php echo date('j', $start_date); ?><?php if ($start_date != $end_date && $end_date != '') : ?>- <?php echo date('j', $end_date); ?><?php endif; ?>
								</div>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>>
									<h3><?php the_title(); ?></h3>
								</a>
								<div class="description-container">
									<p><?php echo get_field('short_description'); ?></p>
								</div>
								
								<div class="event-links">
									<a href="<?php echo $link; ?>" <?php echo $target; ?> class="event-link event-more">More Info</a>
								</div> <!-- event-links -->
								<div class="event-social">
								<?php foreach( $social as $social_name => $social_url ) : ?>
									<?php
									echo '<a href="' . $social_url . '" class="' . $social_name . '" target="_blank">';
									get_template_part('assets/images/social/' . $social_name , 'official.svg');
									echo '</a>';
									?>
								<?php endforeach; ?>
								</div> <!-- poi-social -->
								<a class="corner-link" href="<?php echo $link; ?>" <?php echo $target; ?></a>
							</div> <!-- event-card-content -->
						</div> <!-- event-card -->
					<?php endwhile; ?>
        		<?php else : ?>
        		    <?php get_template_part( 'template-parts/content', 'none' ); ?>
        		<?php endif; // End have_posts() check. ?>
        		<div class="large-12 cell text-center">
	        		<a class="submit-event" href="<?php echo get_site_url(); ?>/submit-an-event">Submit a New Event</a>
        		</div>
        	</article>
	    </div> <!-- grid-wrapper -->
    </div> <!-- grid-container -->
</div> <!-- #page blog-grid -->

<script>

jQuery( document ).ready(function() {
	var hash = window.location.hash;
	if (hash != '') {
		jQuery('.cat-filter').removeClass('active');
		jQuery(hash + '-filter').addClass('active');
		// Remove # from hash string
		hash = hash.replace(/^.*#/, '');
		jQuery('.event-card').fadeOut();
		jQuery('.event-card.' + hash).fadeIn();
	}
});

jQuery(".cat-filter").on( "click", function() {
	jQuery('.cat-filter').removeClass('active');
	jQuery(this).addClass('active');
	var filter = jQuery(this).data('filter');
	if (filter == "all") {
		jQuery('.event-card').fadeIn();
	} else {
		jQuery('.event-card').fadeOut();
		jQuery('.event-card.' + filter).fadeIn();
	}
});

</script>

<?php get_footer(); ?>