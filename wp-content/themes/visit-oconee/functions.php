<?php
/**
 * Author: Drum Creative
 * URL: http://drumcreative.com
 *
 * drumroll functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
// Global variables
$dimensions = get_theme_mod('featured_dimensions');
global $featured_image_size;
$featured_image_size = intval($dimensions['width']) . ' x ' . intval($dimensions['height']);
$home_dimensions = get_theme_mod('home_featured_dimensions');
global $home_featured_image_size;
$home_featured_image_size = intval($home_dimensions['width']) . ' x ' . intval($home_dimensions['height']);


/** Mobile Detect http://mobiledetect.net/ */
require_once('library/Mobile_Detect.php');

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-drumroll-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Drum's functions */
require_once('library/drum-functions.php');

/** Add Drum's plugins */
require_once('library/drum-plugins.php');

/** Add Customizer Panels/Controls */
require_once('library/customizer.php');

/** Add button shortcode button to TinyMCE */
require_once( 'library/editor-buttons/tinymce-buttons.php' );

/** Add TGM Plugin Activation - http://tgmpluginactivation.com/ */
require_once('library/class-tgm-plugin-activation.php');

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

// Specify Local JSON folder. This was added on 7/19/17 because of a bug preventing the JSON from saving.
function my_acf_json_load_point( $paths ) {
    unset($paths[0]);    
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

register_post_type('poi', array(	'label' => 'Points of Interest','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => true,'rewrite' => array('slug' => ''),'query_var' => true,'exclude_from_search' => false,'supports' => array('title','excerpt','revisions','thumbnail','page-attributes',),'labels' => array (
  'name' => 'Points of Interest',
  'singular_name' => 'Point of Interest',
  'menu_name' => 'Points of Interest',
  'add_new' => 'Add Point of Interest',
  'add_new_item' => 'Add New Point of Interest',
  'edit' => 'Edit',
  'edit_item' => 'Edit Point of Interest',
  'new_item' => 'New Point of Interest',
  'view' => 'View Point of Interest',
  'view_item' => 'View Point of Interest',
  'search_items' => 'Search Points of Interest',
  'not_found' => 'No Points of Interest Found',
  'not_found_in_trash' => 'No Points of Interest Found in Trash',
  'parent' => 'Parent Point of Interest',
),) );

register_taxonomy('poi_cats',array (
  0 => 'poi',
),array( 'hierarchical' => true, 'label' => 'Categories','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => 'visit'),'singular_label' => 'Category') );

register_post_type('events', array(	'label' => 'Events','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'exclude_from_search' => false,'supports' => array('title','editor','excerpt','revisions','thumbnail','page-attributes',),'has_archive' => true, 'labels' => array (
  'name' => 'Events',
  'singular_name' => 'Event',
  'menu_name' => 'Events',
  'add_new' => 'Add Event',
  'add_new_item' => 'Add New Event',
  'edit' => 'Edit',
  'edit_item' => 'Edit Event',
  'new_item' => 'New Event',
  'view' => 'View Event',
  'view_item' => 'View Event',
  'search_items' => 'Search Events',
  'not_found' => 'No Events Found',
  'not_found_in_trash' => 'No Events Found in Trash',
  'parent' => 'Parent Event',
),) );