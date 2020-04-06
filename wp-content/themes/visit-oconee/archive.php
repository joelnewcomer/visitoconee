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

// echo 'taxonomy: ' . get_query_var( 'taxonomy' );

if (get_query_var( 'taxonomy' ) == 'poi_cats' || get_query_var( 'taxonomy' ) == 'place_tag') {
	get_template_part('template-parts/content','poi_cats');
} else {
	get_template_part('template-parts/content','archive');
}

get_footer();