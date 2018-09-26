<?php
/**
 * Foundation PHP template
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */

// Pagination.
if ( ! function_exists( 'drumroll_pagination' ) ) :
function drumroll_pagination() {
	global $wp_query;

	$big = 999999999; // This needs to be an unlikely integer

	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'prev_next' => true,
	    'prev_text' => __( '<svg class="blog-pag-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 40"><path class="left-arrow-1" d="M2.38,20,19.71,1.71A1,1,0,1,0,18.29.29l-18,19a1,1,0,0,0,0,1.41l18,19a1,1,0,1,0,1.41-1.41Z"/></svg> &nbsp; Prev', 'drumroll' ),
	    'next_text' => __( 'Next &nbsp; <svg class="blog-pag-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 40"><path class="right-arrow-1" d="M19.71,19.29l-18-19A1,1,0,1,0,.29,1.71L17.62,20,.29,38.29a1,1,0,1,0,1.41,1.41l18-19a1,1,0,0,0,0-1.41Z"/></svg>', 'drumroll' ),
		'type' => 'list',
	) );

	$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
	$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
	$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
	$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
	$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
	$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

	// Display the pagination if more than one page is found.
	if ( $paginate_links ) {
		echo '<div class="pagination text-center">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}
endif;

// Add Foundation 'active' class for the current menu item.
if ( ! function_exists( 'drumroll_active_nav_class' ) ) :
function drumroll_active_nav_class( $classes, $item ) {
	if ( 1 == $item->current || true == $item->current_item_ancestor ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'drumroll_active_nav_class', 10, 2 );
endif;

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch.
 */
if ( ! function_exists( 'drumroll_active_list_pages_class' ) ) :
function drumroll_active_list_pages_class( $input ) {

	$pattern = '/current_page_item/';
	$replace = 'current_page_item active';

	$output = preg_replace( $pattern, $replace, $input );

	return $output;
}
add_filter( 'wp_list_pages', 'drumroll_active_list_pages_class', 10, 2 );
endif;