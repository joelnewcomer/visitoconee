<?php
// Blog featured Image
if (is_home() && get_option('page_for_posts') ) {
	$title = get_the_title(get_option('page_for_posts'));
	$image_id = get_the_post_thumbnail_id(get_option('page_for_posts'));
// Standard Featured Image
} else {
	$title = get_the_title();
	$image_id = get_post_thumbnail_id();
}
// Default Featured Image (from Customizer)
if ($image_id == null || get_field('featured_not_in_header')) {
	$image_id = get_theme_mod( 'default_featured' );
}
// Featured Image Dimensions (from Customizer)
$image_url = wp_get_attachment_image_src($image_id, 'featured');
?>

<div class="featured-image parallax-featured" data-paroller-factor="0.5" style="background: url(<?php echo $image_url[0]; ?>) center center no-repeat;">
	<div class="grid-container featured-image-overlay">
		<div class="large-12 cell text-center">
			<div style="display:table;width:100%;height:100%;">
				<div style="display:table-cell;vertical-align:middle;">
			    	<div style="text-align:center;"><h1 class="entry-title"><?php echo $title; ?></h1></div>
			  	</div>
			</div>
		</div>
	</div>
</div>