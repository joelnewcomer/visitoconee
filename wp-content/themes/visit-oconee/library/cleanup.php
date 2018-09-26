<?php
/**
 * Clean up WordPress defaults
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */

if ( ! function_exists( 'drumroll_start_cleanup' ) ) :
function drumroll_start_cleanup() {

	// Launching operation cleanup.
	add_action( 'init', 'drumroll_cleanup_head' );

	// Remove WP version from RSS.
	add_filter( 'the_generator', 'drumroll_remove_rss_version' );

}
add_action( 'after_setup_theme','drumroll_start_cleanup' );
endif;
/**
 * Clean up head.+
 * ----------------------------------------------------------------------------
 */

if ( ! function_exists( 'drumroll_cleanup_head' ) ) :
function drumroll_cleanup_head() {

	// EditURI link (Pingbacks)
	remove_action( 'wp_head', 'rsd_link' );

	// Category feed links.
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Post and comment feed links.
	remove_action( 'wp_head', 'feed_links', 2 );

	// Windows Live Writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Index link.
	remove_action( 'wp_head', 'index_rel_link' );

	// Previous link.
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// Start link.
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// Canonical.
	remove_action( 'wp_head', 'rel_canonical', 10, 0 );

	// Shortlink.
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

	// Links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// WP version.
	remove_action( 'wp_head', 'wp_generator' );

	// Emoji detection script.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Emoji styles.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
endif;

// Remove WP version from RSS.
if ( ! function_exists( 'drumroll_remove_rss_version' ) ) :
function drumroll_remove_rss_version() { return ''; }
endif;

// Remove injected CSS for recent comments widget.
if ( ! function_exists( 'drumroll_remove_wp_widget_recent_comments_style' ) ) :
function drumroll_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
	  remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}
endif;

// Add WooCommerce support for wrappers per http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
if ( class_exists( 'woocommerce' ) ) {
	function drumroll_before_content() {
		echo '<div class="entry-content"><div class="grid-container"><div class="grid-x"><div class="large-12 cell">';
	}
	function drumroll_after_content() {
		echo '</div></div></div></div>';
	}

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	add_action('woocommerce_before_main_content', 'drumroll_before_content', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_after_main_content', 'drumroll_after_content', 10);
}