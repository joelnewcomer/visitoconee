<?php
/**
 * The template for displaying search results pages.
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */

get_header();

$image_id = get_post_thumbnail_id(get_option('page_for_posts'));
// Default Featured Image
if ($image_id == null) {
	$image_id = get_theme_mod( 'default_featured' );
}
?>

	<div class="featured-container">
			<div class="featured-image blog-landing-featured">
				<?php echo wp_get_attachment_image($image_id,'featured'); ?>
				<div class="overlay">
					<div class="blog-header single-header text-center search-and-cats search-header">
						<div style="display:table;width:100%;height:100%;">
							<div style="display:table-cell;vertical-align:middle;">
						    	<div style="text-align:center;">
							    	<h1 class="entry-title search-title single-title-ul"><?php _e( 'Search', 'drumroll' ); ?></h1>
							    	<!-- Search -->
									<form role="search" method="get" id="blog-search" action="<?php echo home_url( '/' ); ?>">
										<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'Search Blog', 'drumroll' ); ?>">
										<input type="submit" class="search" id="searchsubmit" value="">
									</form>
						    	</div>
							</div>
						</div>
					</div> <!-- blog-header -->
				</div> <!-- overlay -->
			</div> <!-- blog-landing-featured -->
	</div> <!-- featured-container -->

<div class="search-results-container">
    <div class="grid-container">
	    <div class="grid-wrapper">
		    <article class="grid-x grid-margin-x clear">
				<div class="large-12 cell" role="main">
					<h2 class="entry-title"><?php echo $wp_query->found_posts; ?> <?php _e( 'Results for', 'drumroll' ); ?> "<?php echo get_search_query(); ?>"</h2>
				</div>
					
					<?php
					$poi_title_shown = false;
					$events_title_shown = false;
					$blog_title_show = false;
					$pages_title_show = false;
					?>
				
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>

					<?php if (get_post_type() == 'events') : ?>
						<?php if (!$events_title_shown) : ?>
							<div class="large-12 cell search-title-cell">
								<h3>Events</h3>
							</div>
							<?php $events_title_shown = true; ?>						
						<?php endif; ?>
						<?php get_template_part( 'template-parts/event', 'card' ); ?>					
					<?php elseif (get_post_type() == 'poi') : ?>
						<?php if (!$poi_title_shown) : ?>
							<div class="large-12 cell search-title-cell">
								<h3>Points of Interest</h3>
							</div>
							<?php $poi_title_shown = true; ?>						
						<?php endif; ?>
						<?php get_template_part( 'template-parts/poi', 'card' ); ?>
					<?php else : ?>
						<?php if (!$blog_title_shown && get_post_type() == 'post') : ?>
							<div class="large-12 cell search-title-cell">
								<h3>From the Blog</h3>
							</div>
							<?php $blog_title_shown = true; ?>						
						<?php endif; ?>
						<?php if (!$pages_title_shown && get_post_type() == 'page') : ?>
							<div class="large-12 cell search-title-cell">
								<h3>Pages</h3>
							</div>
							<?php $pages_title_shown = true; ?>						
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="blog-card large-4 medium-6 cell poi-card transitions">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail( array( 'width' => 640, 'height' => 370, 'crop' => true ) ) ?>
							<?php endif; ?>
							<div class="blog-card-content">
								<h3><?php the_title(); ?></h3>
								<?php if (has_post_thumbnail()) : ?>
									<?php echo wpautop(drum_excerpt(15), false); ?>
								<?php else : ?>
									<?php echo wpautop(drum_excerpt(45), false); ?>
								<?php endif; ?>
							</div> <!-- blog-card-content -->
						</a>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>		
				<?php endif;?>
			
			
			</div>
	    </div> <!-- grid-wrapper -->
	</div> <!-- grid-container -->
</div> <!--search-container -->

<script>
	
jQuery(".toggle-shade").on( "click", function(e) {
	e.preventDefault();
	jQuery(this).parents('.poi-card').toggleClass('shade-open');
});

jQuery( document ).ready(function() {
	// Reset
	// itinerary = new Array();
	// basil.set('itinerary', itinerary);
    var itinerary = basil.get('itinerary');
    if (itinerary != null) {
	    for (var i = 0; i < itinerary.length; i++) {
    		jQuery(".poi-itinerary[data-itinerary='" + itinerary[i] + "']").addClass('added');
		}
	}
});

jQuery(".poi-itinerary:not(.added)").on( "click", function() {
	var poiID = jQuery(this).data('itinerary');
	var itinerary = basil.get('itinerary');
	if (itinerary == null) {
		itinerary = new Array();
	}
	jQuery(this).addClass('added');
	itinerary.push(poiID);
	basil.set('itinerary', itinerary);
});


</script>


<?php get_footer();
