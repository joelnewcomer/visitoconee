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
		<?php
		$events_featured = get_field('featured_image', 'option');
		if ($events_featured == '') {
			$featured_url = get_template_directory_uri() . '/assets/images/events-featured.jpg';
		} else {
			$featured_array = wp_get_attachment_image_src($events_featured, 'featured');
			$featured_url = $featured_array[0];
		}
		?>
		<img src="<?php echo $featured_url; ?>" alt="Events Image">
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
						<?php get_template_part( 'template-parts/event', 'card' ); ?>
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
		jQuery('html, body').animate({ scrollTop: jQuery('#page').offset().top - 115}, 500);
	}
});

</script>

<?php get_footer(); ?>