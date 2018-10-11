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

// Custom Image Sizes
add_image_size( 'home-video', 414, 297, true );
add_image_size( 'home-block', 635, 428, true );
add_image_size( 'carousel', 315, 236, true );

/* Pull apart OEmbed video link to get thumbnails out*/
function get_video_thumbnail_uri( $video_uri ) {

	$thumbnail_uri = '';
	
	// determine the type of video and the video id
	$video = parse_video_uri( $video_uri );		
	
	// get youtube thumbnail
	if ( $video['type'] == 'youtube' )
		$thumbnail_uri = 'http://img.youtube.com/vi/' . $video['id'] . '/hqdefault.jpg';
	
	// get vimeo thumbnail
	if( $video['type'] == 'vimeo' )
		$thumbnail_uri = get_vimeo_thumbnail_uri( $video['id'] );
	// get wistia thumbnail
	if( $video['type'] == 'wistia' )
		$thumbnail_uri = get_wistia_thumbnail_uri( $video_uri );
	// get default/placeholder thumbnail
	if( empty( $thumbnail_uri ) || is_wp_error( $thumbnail_uri ) )
		$thumbnail_uri = ''; 
	
	//return thumbnail uri
	return $thumbnail_uri;
	
}


/* Parse the video uri/url to determine the video type/source and the video id */
function parse_video_uri( $url ) {
	
	// Parse the url 
	$parse = parse_url( $url );
	
	// Set blank variables
	$video_type = '';
	$video_id = '';
	
	// Url is http://youtu.be/xxxx
	if ( $parse['host'] == 'youtu.be' ) {
	
		$video_type = 'youtube';
		
		$video_id = ltrim( $parse['path'],'/' );	
		
	}
	
	// Url is http://www.youtube.com/watch?v=xxxx 
	// or http://www.youtube.com/watch?feature=player_embedded&v=xxx
	// or http://www.youtube.com/embed/xxxx
	if ( ( $parse['host'] == 'youtube.com' ) || ( $parse['host'] == 'www.youtube.com' ) ) {
	
		$video_type = 'youtube';
		
		parse_str( $parse['query'] );
		
		$video_id = $v;	
		
		if ( !empty( $feature ) )
			$video_id = end( explode( 'v=', $parse['query'] ) );
			
		if ( strpos( $parse['path'], 'embed' ) == 1 )
			$video_id = end( explode( '/', $parse['path'] ) );
		
	}
	
	// Url is http://www.vimeo.com
	if ( ( $parse['host'] == 'vimeo.com' ) || ( $parse['host'] == 'www.vimeo.com' ) ) {
	
		$video_type = 'vimeo';
		
		$video_id = ltrim( $parse['path'],'/' );	
					
	}
	$host_names = explode(".", $parse['host'] );
	$rebuild = ( ! empty( $host_names[1] ) ? $host_names[1] : '') . '.' . ( ! empty($host_names[2] ) ? $host_names[2] : '');
	// Url is an oembed url wistia.com
	if ( ( $rebuild == 'wistia.com' ) || ( $rebuild == 'wi.st.com' ) ) {
	
		$video_type = 'wistia';
			
		if ( strpos( $parse['path'], 'medias' ) == 1 )
				$video_id = end( explode( '/', $parse['path'] ) );
	
	}
	
	// If recognised type return video array
	if ( !empty( $video_type ) ) {
	
		$video_array = array(
			'type' => $video_type,
			'id' => $video_id
		);
	
		return $video_array;
		
	} else {
	
		return false;
		
	}
	
}


/* Takes a Vimeo video/clip ID and calls the Vimeo API v2 to get the large thumbnail URL.*/
function get_vimeo_thumbnail_uri( $clip_id ) {
	$vimeo_api_uri = 'http://vimeo.com/api/v2/video/' . $clip_id . '.php';
	$vimeo_response = wp_remote_get( $vimeo_api_uri );
	if( is_wp_error( $vimeo_response ) ) {
		return $vimeo_response;
	} else {
		$vimeo_response = unserialize( $vimeo_response['body'] );
		return $vimeo_response[0]['thumbnail_large'];
	}
	
}

/* Takes a wistia oembed url and gets the video thumbnail url. */
function get_wistia_thumbnail_uri( $video_uri ) {
	if ( empty($video_uri) )
		return false;
	$wistia_api_uri = 'http://fast.wistia.com/oembed?url=' . $video_uri;
	$wistia_response = wp_remote_get( $wistia_api_uri );
	if( is_wp_error( $wistia_response ) ) {
		return $wistia_response;
	} else {
		$wistia_response = json_decode( $wistia_response['body'], true );
		return $wistia_response['thumbnail_url'];
	}
}


function pippin_add_taxonomy_filters() {
    global $typenow;
    // an array of all the taxonomyies you want to display. Use the taxonomy name or slug
    $taxonomies = array('poi_cats');
    // must set this to the post type you want the filter(s) displayed on
    if( $typenow == 'poi' ){
        foreach ($taxonomies as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            if(count($terms) > 0) {
                echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
                echo "<option value=''>Show All $tax_name</option>";
                foreach ($terms as $term) { 
                    echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
                }
                echo "</select>";
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'pippin_add_taxonomy_filters' );