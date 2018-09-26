<?php
/**
 * Useful function(s) included in this library:
 *
 * 1. drum_excerpt($length) - Line 56 - Allows you to output a custom-length excerpt. 
 * 2. has_gform() - Line 119 - Checks to see if a Gravity Forms form is on the current page.
 * 3. is_woocommerce_activated() -  Line 415 - Checks to see if WooCommerce is activated.
 * 4. is_blog() - Line 406 Checks to see if this is a blog-related page (blog, blog post, archive)
 */

// Set content width to appease Theme Check
if ( ! isset( $content_width ) ) $content_width = 1048;

// Dequeue jQuery Migrate Script in WordPress for performance - https://www.noupe.com/wordpress/the-26-most-useful-and-most-functional-wordpress-snippets.html
if ( ! function_exists( 'evolution_remove_jquery_migrate' ) ) :
function evolution_remove_jquery_migrate( &$scripts) {
    if(!is_admin()) {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
    }
}
add_filter( 'wp_default_scripts', 'evolution_remove_jquery_migrate' );
endif;

// Disable self pingbacks since they are annoying - https://www.noupe.com/wordpress/the-26-most-useful-and-most-functional-wordpress-snippets.html
function evolution_no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'evolution_no_self_ping' );

// Add a "Read More" link to excerpts
function new_excerpt_more( $more ) {
	global $blog_header_two;
	global $wp_query;
	// Header 2 first blog post
	if ($blog_header_two && $wp_query->current_post == -1) {
		$arrow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 40"><path class="right-arrow-1" d="M19.71,19.29l-18-19A1,1,0,1,0,.29,1.71L17.62,20,.29,38.29a1,1,0,1,0,1.41,1.41l18-19a1,1,0,0,0,0-1.41Z"/></svg>';		
		return '...' . PHP_EOL . '</p><p class="faux-link faux-button read-more arrow reverse small">Read Full Story' . $arrow;
	} else {
		return '...' . PHP_EOL . '</p><p class="faux-link read-more">Read More';
	}
	
}
add_filter('excerpt_more', 'new_excerpt_more');

// Drum custom excerpt length
function drum_excerpt($length) {
	$excerpt = get_the_content('');
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = apply_filters('the_content', $excerpt);
	$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
	$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
	$excerpt = preg_replace($regex,'', $excerpt);
	$excerpt_length = apply_filters('excerpt_length', $length);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
	return $excerpt;
}

// Add post/page name to body class
function post_name_in_body_class( $classes ){
	if( is_singular() ) {
		global $post;
		array_push( $classes, "{$post->post_name}" );
	}
	return $classes;
}
add_filter( 'body_class', 'post_name_in_body_class' );

// Filter to process shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Change the media link type to None by default
update_option('image_default_link_type','none');

// Show full WYSIWYG toolbar by default
function unhide_kitchensink( $args ) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}
add_filter( 'tiny_mce_before_init', 'unhide_kitchensink' );

// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}

// Deny Comment Posting to No Referrer Requests
function check_referrer() {
    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "") {
        wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, bugger off!', 'drum-roll') );
    }
}
add_action('check_comment_flood', 'check_referrer');

// Remove query strings from static resources (Performance) - https://gist.github.com/michaelwilhelmsen/2bc3b5787256a6b01751
function _remove_query_strings_1( $src ){
	$rqs = explode( '?ver', $src );
        return $rqs[0];
}
function _remove_query_strings_2( $src ){
	$rqs = explode( '&ver', $src );
        return $rqs[0];
}
add_filter( 'script_loader_src', '_remove_query_strings_1', 15, 1 );
add_filter( 'style_loader_src', '_remove_query_strings_1', 15, 1 );
add_filter( 'script_loader_src', '_remove_query_strings_2', 15, 1 );
add_filter( 'style_loader_src', '_remove_query_strings_2', 15, 1 );

// Conditional to check whether Gravity Forms shortcode is on a page
function has_gform() {
    global $post;
    $all_content = get_the_content();
    if (strpos($all_content,'[gravityform') !== false) {
		return true;
    } else {
		return false;
    }
}

// White Label login logo
function login_logo() {
	if ( get_theme_mod( 'site_logo' ) ) {
	    $logo = get_theme_mod( 'site_logo' );    
	} else {
		$logo = get_template_directory_uri() . '/assets/images/logo.svg';
	} ?>
	<style type="text/css">
	        body.login div#login h1 a {
	            background-image: url(<?php echo $logo; ?>);
	            background-size: contain !important;
	            background-repeat: no-repeat;
	            background-position: center center;
	            width: 100%;
	        }
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'login_logo' );

// White Label admin logo
function custom_logo() {
	if ( get_theme_mod( 'admin_logo' ) ) {
	    $logo = get_theme_mod( 'admin_logo' );    
	} else {
		$logo = get_template_directory_uri() . '/assets/images/admin-logo.svg';
	}
	echo '<style type="text/css">
	#wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo .ab-icon {
		background: url(' . $logo . ') center center no-repeat !important;
		background-size: contain !important;
		width: 20px;
		height: 20px;
		margin-top: 7px;
		padding: 0;
	}
	#wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo .ab-icon:before {
		display: none !important;
	}
	</style>';
}
add_action('admin_head', 'custom_logo');

// White Label Admin Footer
function admin_footer () {
	echo '<a href="http://www.drumcreative.com" target="_blank">&copy;' . date('Y') . ' Drum Creative</a>';
}
add_filter('admin_footer_text', 'admin_footer');

// White Label Admin Login Link
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return site_url();
}

// Filter Gravity Forms emails through WP Better Emails - http://codrspace.com/jbiros/wp-better-email-gravity-form-template-fix/
add_filter('gform_notification', 'change_notification_format', 10, 3);
function change_notification_format( $notification, $form, $entry ) {
    // is_plugin_active is not availble on front end
    if( !is_admin() )
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    // does WP Better Emails exists and activated ?
    if( !is_plugin_active('wp-better-emails/wpbe.php') )
        return $notification;
    // change notification format to text from the default html
    $notification['message_format'] = "text";
    // disable auto formatting so you don't get double line breaks
    $notification['disableAutoformat'] = true;
    return $notification;
}

// Remove "You may use these HTML tags..." from comments
add_filter( 'comment_form_defaults', 'remove_comment_form_allowed_tags' );
function remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

// Strip header tag contents from excerpts so excerpts don't read weird - https://pastebin.com/XMJNtH6A
function wp_strip_header_tags( $excerpt='' ) {
	$raw_excerpt = $excerpt;
	if ( '' == $excerpt ) {
		$excerpt = get_the_content('');
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
	}
	$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
	$excerpt = preg_replace($regex,'', $excerpt);
	$excerpt_length = apply_filters('excerpt_length', 55);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
	return apply_filters('wp_trim_excerpt', preg_replace($regex,'', $excerpt), $raw_excerpt);
}
add_filter( 'get_the_excerpt', 'wp_strip_header_tags', 9);

// Don't allow TIF's to be uploaded since Chrome doesn't display them.
function unset_tiff($mime_types){
    unset($mime_types['tif|tiff']); //Removing the tif extension
    return $mime_types;
}
add_filter('upload_mimes', 'unset_tiff', 1, 1);

// Add no-border class to gallery items
function add_class_to_gallery($link, $id) {
	$border = true;
	$border = get_field('border', $id);
	if (!$border) {
		return str_replace('attachment-thumbnail', 'attachment-thumbnail no-border', $link);
	} else {
		return $link;
	}
}
add_filter( 'wp_get_attachment_link', 'add_class_to_gallery', 10, 2 );

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
    $plugins = array(
        // Require Gravity Forms
        array(
            'name'               => 'Gravity Forms', // The plugin name.
            'slug'               => 'gravityforms', // The plugin slug (typically the folder name).
            'source'             => 'http://drumcreative.com/wp-content/required-plugins/gravityforms.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
        // ACF Pro
        array(
            'name'               => 'Advanced Custom Fields Pro', // The plugin name.
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => 'http://drumcreative.com/wp-content/required-plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ),
        // Require Wordpress SEO
        array(
            'name'      => 'WordPress SEO by Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => true,
        ),
        // Require WP Featherlight
        array(
            'name'      => 'WP Featherlight',
            'slug'      => 'wp-featherlight',
            'required'  => true,
        ),
        // Require Lazy Loader
        array(
            'name'      => 'Lazy Loader',
            'slug'      => 'lazy-loading-responsive-images',
            'required'  => true,
        ),
        // Require Kirki
        array(
            'name'      => 'Kirki',
            'slug'      => 'kirki',
            'required'  => true,
        ),
        // Require Email Login
        array(
            'name'      => 'Email Login',
            'slug'      => 'wp-email-login',
            'required'  => true,
        ),
        // Require Email Address Encoder
        array(
            'name'      => 'Email Address Encoder',
            'slug'      => 'email-address-encoder',
            'required'  => true,
        ),
        // Require Optimize Images Resizing
        array(
            'name'      => 'Optimize Images Resizing',
            'slug'      => 'optimize-images-resizing',
            'required'  => true,
        ),
        // Require Safe SVG
        array(
            'name'      => 'Safe SVG',
            'slug'      => 'safe-svg',
            'required'  => true,
        ),
    );
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'drum-beat-6-starter-theme' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'drum-beat-6-starter-theme' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'drum-beat-6-starter-theme' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa( $plugins, $config );
}

// Add Schema.org support
function html_tag_schema() {
    $schema = 'http://schema.org/';
    // Is single post
    if(is_single()) {
        $type = "Article";
    }
    // Is author page
    elseif( is_author() ) {
        $type = 'ProfilePage';
    }
    // Contact form page
    elseif( is_page('Contact') || is_page('Contact') ) {
        $type = 'ContactPage';
    }
    // Is search results page
    elseif( is_search() ) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
}

// Add User Browser and OS Classes to Body Class
function browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) {
            $classes[] = 'ie';
            if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie'.$browser_version[1];
    } else $classes[] = 'unknown';
    if($is_iphone) $classes[] = 'iphone';
    if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
             $classes[] = 'osx';
       } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
             $classes[] = 'linux';
       } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
             $classes[] = 'windows';
       }
    return $classes;
}
add_filter('body_class','browser_body_class');

// Remove "Custom Fields" meta box to speed up admin
function admin_speedup_remove_post_meta_box() {
	global $post_type;
	if ( is_admin()  && post_type_supports( $post_type, 'custom-fields' )) {
		remove_meta_box( 'postcustom', $post_type, 'normal' );
	}
}
add_action( 'add_meta_boxes', 'admin_speedup_remove_post_meta_box' );

// Add field type class to Gravity Forms fields
add_filter( 'gform_field_css_class', 'gf_field_type_classes', 10, 3 );
function gf_field_type_classes( $classes, $field, $form ) {
	if (!is_admin()) {
	    $classes .= ' gfield_' . $field->type;
	}
	return $classes;
}

// Check to see if this is a blog-related page
function is_blog() {
	if (is_home() || is_singular('post') || is_post_type_archive('post') || is_archive()) {
		return true;
	} else {
		return false;
	}
}

// Check to see if WooCommerce is activated
if ( !function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

// Add user role class to body
function add_role_to_body($classes) {
	if (is_user_logged_in()) {
		global $current_user;
		$user_role = array_shift($current_user->roles);
		$classes[] = 'role-'. $user_role;
	}
	return $classes;
}
add_filter('body_class','add_role_to_body');

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <a class="view-cart-icon" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span><?php echo WC()->cart->cart_contents_count; ?></span></a>
    <?php
    $fragments['a.view-cart-icon'] = ob_get_clean();
    return $fragments;
}

// Add ACF Options Page
if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Admin Dashboard Settings',
        'menu_title'	=> 'Dashboard Settings',
        'parent_slug'	=> 'options',
    ));
}

// Output Address with link. Links to Apple Maps on an iPhone/iPad.
function drum_smart_address($street1,$street2,$city,$state,$zip) {
	// Format address for links to map
	if ($street2 == null) {
		$address = $street1 . ', ' . $street2 . ', ' . $city . ', ' . $state . ' ' . $zip;
	} else {
		$address = $street1 . ', ' . $city . ', ' . $state . ' ' . $zip;
	}
	// Link to Map
	$clean_address = urlencode( strip_tags($address) );
	$detect = new Mobile_Detect;
	if( $detect->isiOS() ) {
    	$output = '<a href="http://maps.apple.com/?daddr=' . $clean_address . '">';
	} else {
	    $output = '<a href="http://maps.google.com/?q=' . $clean_address . '" target="_blank">';
	}	
	// Create address output
	$output .= $street1 . '<br />';
	if ($street2 != null) {
		$output .= $street2 . '<br />';
	}
	$output .= $city . ', ' . $state . ' ' . $zip;
	$output .= '</a>';
    return $output;
}

// Display phone number and convert to a button for mobile
function drum_smart_phone($phone, $button_text = 'Click to Call', $phone_prefix) {
	$clean_phone = preg_replace("/[^0-9]/","",$phone);
	$output = '<span class="hide-for-small">' . $phone_prefix . $phone . '</span>';
	$output .= '<span class="button hide-for-print"><a class="show-for-small" href="tel:' . $clean_phone . '">' . $button_text . '</a></span>';
	return $output;
}

// Output Directions button. Links to Apple Maps on an iPhone/iPad.
function drum_smart_directions($street1,$street2,$city,$state,$zip) {
	// Format address for links to map
	if ($street2 == null) {
		$address = $street1 . ', ' . $street2 . ', ' . $city . ', ' . $state . ' ' . $zip;
	} else {
		$address = $street1 . ', ' . $city . ', ' . $state . ' ' . $zip;
	}
	// Show 'Get Directions' button
	$clean_address = urlencode( strip_tags($address) );
	$detect = new Mobile_Detect;
	$output = '<div class="button hide-for-print">';
	if( $detect->isiOS() ) {
    	$output .= '<a href="http://maps.apple.com/?daddr=' . $clean_address . '">Apple Maps';
	} else {
	    $output .= '<a href="http://maps.google.com/?q=' . $clean_address . '" target="_blank">Get Directions';
	}
    $output .= '</a></div>';
    return $output;
}

/**
 * Add placeholders to comment form
 */
 function placeholder_author_email_url_form_fields($fields) {
    $replace_author = __('Your Name *', 'textdomain');
    $replace_email = __('Your Email *', 'textdomain');
    $replace_url = __('Your Website *', 'textdomain');

    $fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'textdomain' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="author" name="author" type="text" placeholder="'.$replace_author.'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></p>';

    $fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email', 'textdomain' ) . '</label> ' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '<input id="email" name="email" type="text" placeholder="'.$replace_email.'" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' /></p>';

    $fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website', 'textdomain' ) . '</label>' .
    '<input id="url" name="url" type="text" placeholder="'.$replace_url.'" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" /></p>';

    return $fields;
}
add_filter('comment_form_default_fields','placeholder_author_email_url_form_fields');

/**
 * Comment Form Placeholder Comment Field
 */
 function placeholder_comment_form_field($fields) {
    $replace_comment = __('Your Comment', 'textdomain');
    $fields['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
    '</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.$replace_comment.'" aria-required="true"></textarea></p>';
    return $fields;
 }
add_filter( 'comment_form_defaults', 'placeholder_comment_form_field' );

// Add notice stating featured image size
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction( $content ) {
	global $home_featured_image_size;
	global $featured_image_size;
	global $post;
	$post_id = $post->ID;
	if ($post_id == get_option('page_on_front')) {
		return $content .= '<p>Featured Image must be sized to at least ' . $home_featured_image_size . ' pixels.</p>';
	} else {
		return $content .= '<p>Featured Image must be sized to at least ' . $featured_image_size . ' pixels.</p>';
	}
}

// Set WYSIWYG Colors on Options Page - http://stackoverflow.com/questions/23171247/add-custom-text-color-wordpress-3-9-tinymce-4-visual-editor
function my_mce4_options($init) {
	$default_colors = '';
	$colors = get_theme_mod( 'wysiwyg_colors' );
	if ($colors != '') {
		foreach( $colors as $color ) :
			$default_colors .= '"' . ltrim($color['color'], '#') . '", "' . $color['color_name'] . '",';
		endforeach;
		$init['textcolor_map'] = '['.$default_colors.']';
		return $init;
	}
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

// Update CSS within in Admin
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/stylesheets/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

// Add button shortcode
add_shortcode( 'button', 'button_shortcode' );
function button_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'size' => 'normal',
        'type' => 'primary',
        'align' => 'text-left'
    ), $atts ) );
	$html = '<div class="button ' . $size . ' ' . $type . ' ' . $align . '">' . $content . '</div>';
    return $html;
}

// Adds an anchor tag above Gravity Forms confirmation messages so the error/confirmation will be visible when the form is submitted
add_filter( 'gform_confirmation_anchor', '__return_true' );

// COMMENTED OUT 4/24/18 BECAUSE IT BREAKS GUTENBERG
// Clean up script tags- https://css-tricks.com/forums/topic/clean-up-script-tags-in-wordpress/
/* add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($input) {
	$input = str_replace("type='text/javascript' ", '', $input);
	return str_replace("'", '"', $input);
} */

// Custom Image Sizes
$dimensions = get_theme_mod('home_featured_dimensions', true);
add_image_size( 'featured-home', intval($dimensions['width']), intval($dimensions['height']), true );
$dimensions = get_theme_mod('featured_dimensions', true);
add_image_size( 'featured', intval($dimensions['width']), intval($dimensions['height']), true );

// Disable Gutenberg on specific templates - https://www.billerickson.net/disabling-gutenberg-certain-templates/
function drum_disable_editor( $id = false ) {
	// Add all custom templates here
	$excluded_templates = array(
		'page-templates/front.php',
	);
	if( empty( $id ) )
		return false;
	$id = intval( $id );
	$template = get_page_template_slug( $id );
	return in_array( $template, $excluded_templates );
}
function drum_disable_gutenberg( $can_edit, $post_type ) {
	if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
		return $can_edit;
	if( drum_disable_editor( $_GET['post'] ) )
		$can_edit = false;
	return $can_edit;
}
add_filter( 'gutenberg_can_edit_post_type', 'drum_disable_gutenberg', 10, 2 );

function clean_media_url($url) {
	// remove everything before 'wp-content'
	$cleaned = strstr($url, 'wp-content');
	// remove everything after '.' (file extension)
	$cleaned = substr($cleaned, 0, strpos($cleaned, "."));
	return $cleaned;
}

// Update ACF 'content' field on all pages when media file is renamed
add_action( 'mfrh_media_renamed', 'url_of_media_was_modified', 10, 3 );
function url_of_media_was_modified( $post, $orig_image_url, $new_image_url ) {
	$orig_image_url = clean_media_url($orig_image_url);
	$new_image_url = clean_media_url($new_image_url);
	$page_ids = get_all_page_ids();	
	
	// Debug
	$string = 'original ' . $orig_image_url . ' new: ' . $new_image_url . '<br />';
	
	foreach($page_ids as $page) {
		$content = get_field('content',$page);
		$content = str_replace($orig_image_url, $new_image_url, $content);
		$debug = print_r($content,true);
		$string .= '<br /><br />' . $debug;
		update_field('content',$content,$page);
	}
	
	// Debug
	update_field('content', $string, 4);
}


// Add WooCommerce body class
add_filter('body_class','woocommerce_body_class');
function woocommerce_body_class($classes){
    if (is_woocommerce_activated()) {
    	$classes[] = 'woocommerce';
    }
    return $classes;
}
?>