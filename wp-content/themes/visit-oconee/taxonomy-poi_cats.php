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

<?php $desc = term_description( $term_id, 'poi_cats' ); ?>
<?php if ($desc != '') : ?>
	<div class="cat-desc">
		<div class="grid-container">
			<div class="grid-x grid-margin-x clear">
				<div class="large-12 cell text-center">
					<?php echo $desc; ?>
				</div>
			</div>
		</div>
	</div>		
<?php endif; ?>

<?php
$args = array( 
    'hide_empty' => false,
    'child_of' => $term->term_id,
);
$child_terms = get_terms( 'poi_cats', $args );
?>

<?php if (!empty($child_terms)) : ?>
<div class="tax-sub-cats">
	<div class="grid-container">
		<div class="grid-x grid-margin-x clear">
			<div class="large-12 cell text-center">
				<div class="cat-filter active" data-filter="all">
					<?php echo file_get_contents(get_field('category_icon', $term)); ?><br />
					<h3>All</h3>
				</div>
				<?php

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
<?php endif; ?>

<div id="page" role="main" class="blog-grid">
	<div class="grid-container">
    	<div class="grid-wrapper">
        	<article class="grid-x grid-margin-x clear">
				
				<!-- BANNER ADS -->
				<?php if(get_field('banner_ads', $term)): ?>
					<div class="large-12 cell cat-banner-ads">
						<div class="slider-container">
							<ul class="bxslider">						
								<?php while(has_sub_field('banner_ads', $term)): ?>
									<?php if (get_sub_field('banner_toggle')) : ?>
									<li>
										<a href="<?php echo get_sub_field('link'); ?>">
											<div class="hide-for-small">
												<?php echo wp_get_attachment_image(get_sub_field('desktop_ad'), 'full'); ?>
											</div>
											<div class="show-for-small">
												<?php echo wp_get_attachment_image(get_sub_field('mobile_ad'), 'full'); ?>
											</div>
										</a>
									</li>
									<?php endif; ?>
								<?php endwhile; ?>
							</ul> <!-- bxslider -->
						</div> <!-- slider-container -->
					</div> <!-- cat-banner-ads -->

<script>
if (typeof bxSlider === "function") { 	
    var slider = jQuery('.bxslider').bxSlider({
        auto: true,
        pager: false,
        controls: false,
        mode: 'fade',
        speed: 1000,
        pause: 3000
    });	
} else {
	jQuery(window).load(function(){
    	var slider = jQuery('.bxslider').bxSlider({
    	    auto: true,
    	    pager: false,
    	    controls: false,
    	    mode: 'fade',
    	    speed: 1000,
    	    pause: 3000
    	});		
	});
}
</script>					
					
				<?php endif; ?>	        	
	        	
        		<?php if ( have_posts() ) : ?>
        			<?php
	        		// global $post;
	        		// update_post_meta( $post->ID, 'show_at_top', '0' );
	        		?>
	    		    <?php while ( have_posts() ) : the_post(); ?>
	    		    	<?php get_template_part( 'template-parts/poi', 'card' ); ?>
					<?php endwhile; ?>
        		<?php else : ?>
        		    <?php get_template_part( 'template-parts/content', 'none' ); ?>
        		<?php endif; // End have_posts() check. ?>
        	</article>
	    </div> <!-- grid-wrapper -->
    </div> <!-- grid-container -->
</div> <!-- #page blog-grid -->

<script>
	
jQuery(".toggle-shade").on( "click", function(e) {
	e.preventDefault();
	jQuery(this).parents('.poi-card').toggleClass('shade-open');
});

jQuery( document ).ready(function() {
	var hash = window.location.hash;
	if (hash != '') {
		jQuery('.cat-filter').removeClass('active');
		jQuery(hash + '-filter').addClass('active');
		// Remove # from hash string
		hash = hash.replace(/^.*#/, '');
		jQuery('.poi-card').fadeOut();
		jQuery('.poi-card.' + hash).fadeIn();
		jQuery('html, body').animate({ scrollTop: jQuery('#page').offset().top - 115}, 500);
	}
});

jQuery(".cat-filter").on( "click", function() {
	jQuery('.cat-filter').removeClass('active');
	jQuery(this).addClass('active');
	var filter = jQuery(this).data('filter');
	if (filter == "all") {
		jQuery('.poi-card').fadeIn();
	} else {
		jQuery('.poi-card').fadeOut();
		jQuery('.poi-card.' + filter).fadeIn();
	}
	jQuery('html, body').animate({ scrollTop: jQuery('#page').offset().top - 115}, 500);
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

<?php get_footer(); ?>