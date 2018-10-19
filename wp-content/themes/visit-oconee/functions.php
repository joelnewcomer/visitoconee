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
),array( 'hierarchical' => true, 'label' => 'Events Categories','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => ''),'singular_label' => 'Category') );

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


// Display points of interest in random order
function order_poi( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_tax( 'poi_cats' ) ) {
    $query->set( 'orderby', 'rand' );
  }
}
add_action( 'pre_get_posts', 'order_poi' );

// Display events in date order and exclude past events
function order_events( $query ) {
	if ( !is_admin() && $query->is_main_query() && is_post_type_archive('events') ) {	
    	$query->set( 'orderby', 'meta_value_num' );
    	$query->set( 'meta_key', 'start_date' );
    	$query->set( 'order', 'ASC' );
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
	        $start_date = get_post_meta($post_id, "start_date", true);
	        update_post_meta( $post_id, 'end_date', $start_date );
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

// Custom Image Sizes
add_image_size( 'home-video', 414, 297, true );
add_image_size( 'home-block', 635, 428, true );
add_image_size( 'carousel', 315, 236, true );