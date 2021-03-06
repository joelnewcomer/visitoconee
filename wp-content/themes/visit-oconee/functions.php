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

/** Include DomPDF */
include 'library/dompdf/autoload.inc.php';

/** Add TGM Plugin Activation - http://tgmpluginactivation.com/ */
require_once('library/class-tgm-plugin-activation.php');

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

// Specify Local JSON folder. This was added on 7/19/17 because of a bug preventing the JSON from saving.
function my_acf_json_load_point( $paths ) {
    unset($paths[0]);    
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

register_post_type('poi', array(	'label' => 'Points of Interest','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => true,'rewrite' => array('slug' => 'point-of-interest'),'query_var' => true,'exclude_from_search' => false,'supports' => array('title','excerpt','revisions','thumbnail','page-attributes',),'labels' => array (
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

register_post_type('events', array(	'label' => 'Events','description' => '','public' => true,'menu_icon' => 'dashicons-calendar','show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'exclude_from_search' => false,'supports' => array('title','editor','excerpt','revisions','thumbnail','page-attributes',),'has_archive' => true, 'labels' => array (
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

register_taxonomy('events_cats',array (
  0 => 'events',
),array( 'hierarchical' => true, 'label' => 'Events Categories','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => 'event-category'),'singular_label' => 'Category') );

// Add featured to filter by category in points of interest
function pippin_add_taxonomy_filters() {
    global $typenow;
    // an array of all the taxonomies you want to display. Use the taxonomy name or slug
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


// Display points of interest in order by show_at_top then title alphabetically
function order_poi( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_tax( 'poi_cats' ) ) {
    $query->set( 'orderby', array( 'meta_value' => 'DESC', 'title' => 'ASC' ));
    $query->set( 'meta_key', 'show_at_top');
    $query->set( 'posts_per_page', -1);
  }
}
add_action( 'pre_get_posts', 'order_poi' );

// Display events in date order and exclude past events
function order_events( $query ) {
	if ( !is_admin() && $query->is_main_query()) {
		if (is_post_type_archive('events') || is_tax('events_cats')) {	
    		$query->set( 'orderby', 'meta_value_num' );
    		$query->set( 'meta_key', 'start_date' );
    		$query->set( 'order', 'ASC' );
    		$query->set( 'posts_per_page', -1);
			$query->set( 'meta_query', array(
			    array(
			        'key' => 'end_date',
			        'value' => strtotime('today midnight'),
			        'compare' => '>=',
			        	'type' => 'numeric'
			        )
			));
		}
  	}
}
add_action( 'pre_get_posts', 'order_events' );

// Save Date field as Unix timestamp
add_filter('acf/update_value/type=date_picker', 'my_update_value_date_picker', 10, 3);
function my_update_value_date_picker( $value, $post_id, $field ) {
    return strtotime($value);
}

// Automatically set event end date to match start date if end date is blank
function update_end_date( $post_id ) {
    $post_type = get_post_type($post_id);
    if ($post_type == 'events') {
	    $end_date = get_post_meta($post_id, "end_date", true);
	    if ($end_date == '') {
		    $submitted_end_date = get_post_meta($post_id, "submitted_end_date", true);
		    if ($submitted_end_date == '') {
		        $start_date = get_post_meta($post_id, "start_date", true);
				update_post_meta( $post_id, 'end_date', $start_date );
			} else {
				$end_date = strtotime($submitted_end_date);
				update_post_meta( $post_id, 'end_date', $end_date );
			}
	    }   		    
    }
}
add_action( 'save_post', 'update_end_date' );

// Include the Ajax library on the front end
add_action( 'wp_head','add_ajax_library' );
function add_ajax_library() {
    $html = '<script type="text/javascript">';
    $html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
    $html .= '</script>';
    echo $html;
}

// Add AJAX function to load itinerary
add_action( 'wp_ajax_load_itinerary', 'load_itinerary');
add_action( 'wp_ajax_nopriv_load_itinerary', 'load_itinerary');
function load_itinerary() {
    if( isset( $_POST['itinerary'] ) ) {
        $itinerary = $_POST['itinerary'];
        foreach ($itinerary as $post_id) {
			$post = get_post( $post_id );
		    $website = get_field('website', $post_id);
		    $address = get_field('address', $post_id);
		    $phone = get_field('phone', $post_id);
		    $social = array();
		    if (get_field('social_instagram', $post_id) != '') {
			    $social['instagram'] = get_field('social_instagram', $post_id);
			}
			if (get_field('social_facebook', $post_id) != '') {
			    $social['facebook'] = get_field('social_facebook', $post_id);
			}
			if (get_field('social_twitter', $post_id) != '') {
			    $social['twitter'] = get_field('social_twitter', $post_id);
			}
		    $terms = wp_get_post_terms( $post_id, 'poi_cats', array("fields" => "slugs") );
		    $classes = implode(" ", $terms);			
			?>
			<div id="poi-<?php echo $post_id; ?>" class="grid-x poi-card itinerary-card sort-scroll-element transition <?php echo $classes; ?>">
				<div class="large-4 medium-4 cell clickable poi-image">
					<?php echo get_the_post_thumbnail( $post_id, 'thumbnail' ); ?>
				</div>
				<div class="large-8 medium-8 cell">
					<div class="poi-card-content">
						<h3><?php echo get_the_title($post_id); ?></h3>
						<?php
						$address = get_field('address', $post_id);
						$detect = new Mobile_Detect;
						$clean_address = urlencode( strip_tags($address) );
						if( $detect->isiOS() ) : ?>
						    <a class="address" href="http://maps.apple.com/?daddr=<?php echo $clean_address; ?>">
						<?php else : ?>
						    <a class="address" href="http://maps.google.com/?q=<?php echo $clean_address; ?>" target="_blank">
						<?php endif; ?>
						    <?php echo $address; ?>
						</a>
						<?php if (get_field('more_info', $post_id)) : ?>
							<p><?php echo get_field('more_info', $post_id); ?></p>
						<?php endif; ?>
						<div class="poi-links hide-for-print">
							<a href="<?php echo get_field('google_business_url', $post_id); ?>" target="_blank" class="poi-link poi-more">More Info</a>
							<?php if ($website != '') : ?>
								<a class="poi-link" href="<?php echo $website; ?>" target="_blank">Website</a>
							<?php endif; ?>
						</div> <!-- poi-links -->
						<div class="poi-social hide-for-print">
						<?php foreach( $social as $social_name => $social_url ) : ?>
							<?php
							echo '<a href="' . $social_url . '" class="' . $social_name . '" target="_blank">';
							get_template_part('assets/images/social/' . $social_name , 'official.svg');
							echo '</a>';
							?>
						<?php endforeach; ?>
						</div> <!-- poi-social -->
						<div class="poi-itinerary button remove hide-for-print" data-itinerary="<?php echo $post->ID; ?>">
							Remove
						</div>
					</div> <!-- poi-card-content -->
					<div class="reorder hide-for-print">
						<div class="up sort-scroll-button-up"><?php get_template_part('assets/images/up', 'arrow.svg'); ?></div>
						<div class="down sort-scroll-button-down"><?php get_template_part('assets/images/down', 'arrow.svg'); ?></div>
					</div> <!-- reorder -->
				</div> <!-- cell -->
			</div> <!-- poi-card -->
			<?php
        }
    } 
    die();
}

// Attach PDF to "Email Itinerary" notification email
add_filter( 'gform_notification_6', 'change_user_notification_attachments', 10, 3 );
function change_user_notification_attachments( $notification, $form, $entry ) {
	session_start();
    $notification['attachments'] = ( is_array( rgget('attachments', $notification ) ) ) ? rgget( 'attachments', $notification ) : array();
    $attachment = get_home_path() . 'wp-content/uploads/itineraries/my-itinerary-' . session_id() . '.pdf';
    $notification['attachments'][] = $attachment;
    return $notification;
}

/**
* Gravity Wiz // Require Minimum Character Limit for Gravity Forms
* 
* Adds support for requiring a minimum number of characters for text-based Gravity Form fields.
* 
* @version	 1.0
* @author    David Smith <david@gravitywiz.com>
* @license   GPL-2.0+
* @link      http://gravitywiz.com/...
* @copyright 2013 Gravity Wiz
*/
class GW_Minimum_Characters {
    
    public function __construct( $args = array() ) {
        
        // make sure we're running the required minimum version of Gravity Forms
        if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.7', '>=' ) )
            return;
    	
    	// set our default arguments, parse against the provided arguments, and store for use throughout the class
    	$this->_args = wp_parse_args( $args, array( 
    		'form_id' => false,
    		'field_id' => false,
    		'min_chars' => 0,
            'max_chars' => false,
            'validation_message' => false,
            'min_validation_message' => __( 'Please enter at least %s characters.' ),
            'max_validation_message' => __( 'You may only enter %s characters.' )
    	) );
    	
        extract( $this->_args );
        
        if( ! $form_id || ! $field_id || ! $min_chars )
            return;
        
    	// time for hooks
    	add_filter( "gform_field_validation_{$form_id}_{$field_id}", array( $this, 'validate_character_count' ), 10, 4 );
        
    }
    
    public function validate_character_count( $result, $value, $form, $field ) {

        $char_count = strlen( $value );
        $is_min_reached = $this->_args['min_chars'] !== false && $char_count >= $this->_args['min_chars'];
        $is_max_exceeded = $this->_args['max_chars'] !== false && $char_count > $this->_args['max_chars'];

        if( ! $is_min_reached ) {

            $message = $this->_args['validation_message'];
            if( ! $message )
                $message = $this->_args['min_validation_message'];

            $result['is_valid'] = false;
            $result['message'] = sprintf( $message, $this->_args['min_chars'] );

        } else if( $is_max_exceeded ) {

            $message = $this->_args['max_validation_message'];
            if( ! $message )
                $message = $this->_args['validation_message'];

            $result['is_valid'] = false;
            $result['message'] = sprintf( $message, $this->_args['max_chars'] );

        }
        
        return $result;
    }
    
}

# Configuration

new GW_Minimum_Characters( array( 
    'form_id' => 5,
    'field_id' => 27,
    'min_chars' => 80,
    'max_chars' => 120,
    'min_validation_message' => __( 'Oops! You need to enter at least %s characters.' ),
    'max_validation_message' => __( 'Oops! You can only enter %s characters.' )
) );


// Set minimum characters for event short description ACF field
add_filter('acf/validate_value/name=short_description', 'validate_min_chars', 10, 4);
 function validate_min_chars( $valid, $value, $field, $input ){
 
	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}
 
	if ( strlen($value) < 80 ) {		
		$valid = 'Must be a minimum of 80 characters.';
	} 
 
	// return
	return $valid;
}

// Custom Image Sizes
add_image_size( 'home-video', 414, 297, true );
add_image_size( 'home-block', 635, 428, true );
add_image_size( 'carousel', 315, 236, true );

// Exclude the URL custom fields from indexing
add_filter('relevanssi_index_custom_fields', 'rlv_skip_custom_fields');
function rlv_skip_custom_fields($custom_fields) {
	$unwanted_fields = array('website', 'google_business_url');
	$custom_fields = array_diff($custom_fields, $unwanted_fields);
	return $custom_fields;
}

// Set search results post type order
add_filter( 'relevanssi_comparison_order', 'rlv_post_type_order' );
function rlv_post_type_order( $order_array ) {
    $order_array = array(
        'poi' => 0,
        'events' => 1,
        'post' => 2,
        'page' => 3,
    );
    return $order_array;
}

add_filter( 'relevanssi_modify_wp_query', 'rlv_orderby' );
function rlv_orderby( $query ) {
    $query->set( 'orderby', 'post_type' );
    $query->set( 'order', 'ASC' );
    return $query;
}

// Display events in date order and exclude past events
function show_all_events( $query ) {
	if ( !is_admin() && $query->is_search ) {
    	$query->set( 'posts_per_page', -1);   
  	}
}
add_action( 'pre_get_posts', 'show_all_events' );

// Fix the Lost Password / Mandrill issue
add_filter('mandrill_payload', 'wpmandrill_auto_add_breaks');
function wpmandrill_auto_add_breaks($message) {    
    $html = $message['html'];
    $is_comment_notification = ( $message['tags']['automatic'][0] == 'wp_wp_notify_moderator' );
    $is_password_reset = ( $message['tags']['automatic'][0] == 'wp_retrieve_password' );
    $no_html_found = ( $html == strip_tags($html) );
    // Add line breaks and links to messages that don't appear to be HTML
    if ( $no_html_found || $is_comment_notification || $is_password_reset ) {
        $html = wpautop($html);
        $message['html'] = make_clickable($html);
    }
    return $message;
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title'     => 'Events Options',
        'menu_title'    => 'Events Options',
        'parent_slug'    => 'edit.php?post_type=events',
    ));
}

/* @link https://anythinggraphic.net/paste-as-text-by-default-in-wordpress
/* Use Paste As Text by default in the editor
----------------------------------------------------------------------------------------*/
add_filter('tiny_mce_before_init', 'ag_tinymce_paste_as_text');
function ag_tinymce_paste_as_text( $init ) {
	$init['paste_as_text'] = true;
	return $init;
}

function cptui_register_my_taxes_place_tag() {

	/**
	 * Taxonomy: Tags.
	 */

	$labels = [
		"name" => __( "Tags", "custom-post-type-ui" ),
		"singular_name" => __( "Tag", "custom-post-type-ui" ),
		"menu_name" => __( "Tags", "custom-post-type-ui" ),
		"all_items" => __( "All Tags", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Tag", "custom-post-type-ui" ),
		"view_item" => __( "View Tag", "custom-post-type-ui" ),
		"update_item" => __( "Update Tag name", "custom-post-type-ui" ),
		"add_new_item" => __( "Add new Tag", "custom-post-type-ui" ),
		"new_item_name" => __( "New Tag name", "custom-post-type-ui" ),
		"parent_item" => __( "Parent Tag", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Tag:", "custom-post-type-ui" ),
		"search_items" => __( "Search Tags", "custom-post-type-ui" ),
		"popular_items" => __( "Popular Tags", "custom-post-type-ui" ),
		"separate_items_with_commas" => __( "Separate Tags with commas", "custom-post-type-ui" ),
		"add_or_remove_items" => __( "Add or remove Tags", "custom-post-type-ui" ),
		"choose_from_most_used" => __( "Choose from the most used Tags", "custom-post-type-ui" ),
		"not_found" => __( "No Tags found", "custom-post-type-ui" ),
		"no_terms" => __( "No Tags", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Tags list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Tags list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Tags", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'tags', 'with_front' => false, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "place_tag",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "place_tag", [ "poi" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_place_tag' );
