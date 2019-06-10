<?php
/**
*   Plugin Name:     Drum Dashboard
*   Plugin URI:      https://cliftonc0613@bitbucket.org/drumcreative/drum-dashboard
*   Description:     This plugin adds a set of panels in the dashboard for the client.
*   Author:          Drum Creative
*   Author URI:      https://drumcreative.com
*   Text Domain:     drumcreative-drum-dashboard
*   Domain Path:     /languages
*   Version:          2.0.1
*   @package         Drum_Dashboard
*/


// Automatic Updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://bitbucket.org/drumcreative/drum-dashboard',
	__FILE__,
	'drumcreative-drum-dashboard'
);

//Optional: If you're using a private repository, create an OAuth consumer
//and set the authentication credentials like this:
/*
$myUpdateChecker->setAuthentication(array(
	'consumer_key' => '...',
	'consumer_secret' => '...',
));
*/

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');


// Disables ALL Panels on admin Dashboard
function my_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['wpe_dify_news_feed'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

// remove Gavity Form Meta Box
//    remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal');

}

add_action( 'wp_dashboard_setup', 'my_remove_dashboard_widgets' );

// Disables Woocommerce Panels on admin Dashboard
function remove_woocommerce_dashboard_widgets() {

// remove WooCommerce Dashboard Status
	remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );
	remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal' );
}

add_action( 'wp_user_dashboard_setup', 'remove_woocommerce_dashboard_widgets', 20 );
add_action( 'wp_dashboard_setup', 'remove_woocommerce_dashboard_widgets', 20 );


// Adds all the scripts and styles for the plugin
add_action( 'admin_enqueue_scripts', 'admin_script' );
function admin_script() {
	if ( is_admin() ) {

		wp_register_style( 'dashboard-styles', plugins_url( 'style.css', __FILE__ ) );
		wp_enqueue_style( 'dashboard-styles' );

		wp_register_style( 'dashboard-app-styles', plugins_url( '/assets/stylesheets/app.min.css', __FILE__ ) );
		wp_enqueue_style( 'dashboard-app-styles' );

		wp_enqueue_script( 'fitvids', plugins_url( '/assets/javascript/jquery.fitvids.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'fitvids' );
		wp_enqueue_script( 'admin_script', plugins_url( '/assets/javascript/plugin_script.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'admin_script' );
	}
}

/**
 *    Adds hidden content to admin_footer, then shows with jQuery, and inserts after welcome panel
 *
 * @author Ren Ventura <EngageWP.com>
 * @see http://www.engagewp.com/how-to-create-full-width-dashboard-widget-wordpress
 */
add_action( 'admin_footer', 'drum_custom_dashboard_widget' );

//Checks
if ( function_exists( 'acf_add_options_page' ) ) {

	$option_page = acf_add_options_page( array(
		'page_title' => 'Admin Dashboard',
		'menu_title' => 'Admin Dashboard',
		'menu_slug'  => 'admin-dashboard',
		'capability' => 'edit_posts',
		'icon_url' => 'dashicons-layout', // Add this line and replace the second inverted commas with class of the icon you like
		'redirect'   => false
	) );

	/** ACF fields */
	require_once( 'acf/acf_fields.php' );

}
function display_admin_notice() { ?>
<?php

if( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) { ?>
    <!--  This the admin notice that show if you do not have ACF Pro activated.  -->
    <div class="notice notice-error"><h3>👍 🤘 Please activate the Advanced Custom Fields PRO plugin so the Drum
            Dashboard will show up! Thanks! 👍 🤘</h3></div>
	<?php
}else {
	add_action('rest_api_init', function() {

		/* unhook default function */
		remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');

		/* then add your own filter */
		add_filter('rest_pre_serve_request', function( $value ) {
			$origin = get_http_origin();
			$my_sites = array( 'https://drumcreative.com', );
			if ( in_array( $origin, $my_sites ) ) {
				header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
			} else {
				header( 'Access-Control-Allow-Origin: ' . esc_url_raw( site_url() ) );
			}
			header( 'Access-Control-Allow-Methods: GET' );

			return $value;
		});
	}, 15);
	// Show Dashboard Settings submenu for selected user only
	function remove_menus() {
		$user         = wp_get_current_user();
		$allowed_user = get_field( 'allowed_user', 'option' );
		if ( $allowed_user != null ) {
			if ( $user->ID != $allowed_user['ID'] ) {
				remove_menu_page( 'admin-dashboard' );
			}
		}
	}

	add_action( 'admin_menu', 'remove_menus', 999 );


	/**
	 *    Adds hidden content to admin_footer, then shows with jQuery, and inserts after welcome panel
	 *
	 */
	add_action( 'admin_footer', 'drum_custom_dashboard_widget' );
	function drum_custom_dashboard_widget() {
		// Bail if not viewing the main dashboard page
		if ( get_current_screen()->base !== 'dashboard' ) {
			return;
		}
		?>

		<?php if ( get_field( 'show_welcome_screen', 'option' ) == true ): ?>
            <div id="drum-welcome" class="welcome-panel drum-panel" style="display: none;">
                <div class="welcome-panel-content drum-panel-content">
					<?php echo the_field( 'admin_intro_content', 'option' ); ?>
                    <div class="welcome-panel-column-container">
                        <div class="large-3 medium-12 small-12 column panel-1">
                            <img src="<?php echo plugins_url( '/assets/images/admin-logo.png', __FILE__ ); ?>"
                                 alt="Drum Logo">
                        </div> <!-- column panel-1 -->
                        <div class="large-4 medium-6 small-12 column panel-2">
                            <div class="maintenance">
								<?php if ( get_field( 'maintenance_hours', 'option' ) ): ?>
                                    <h1>Maintenance:
										<?php if ( get_field( 'maintenance_hours', 'option' ) || get_field( 'maintenance_hours', 'option' ) == 0 ): ?>
                                            <span class="no-wrap"><?php echo the_field( 'maintenance_hours', 'option' ); ?>
                                                Hrs</span>
										<?php endif; ?>
                                    </h1>
									<?php if ( get_field( 'maintenance_hours', 'option' ) == 0 ): ?>
                                        <a class="button button-primary button-hero"
                                           href="mailto:support@drumcreative.com">Signup For Maintenance</a>
									<?php else: ?>
                                        <a class="button button-primary button-hero"
                                           href="mailto:support@drumcreative.com">Submit Support Ticket</a>
									<?php endif; ?>
								<?php else: ?>
                                    <div class="button__alone">
                                        </h1> <a class="button button-primary button-hero"
                                                 href="mailto:support@drumcreative.com">Signup For Maintenance</a>
                                    </div> <!-- .button__alone -->
								<?php endif; ?>
                            </div> <!-- maintenance -->
                            <div class="hosting">
								<?php if ( get_field( 'hosting', 'option' ) ): ?>
                                    <h1>Hosting: <span
                                                class="no-wrap"><?php echo the_field( 'hosting', 'option' ); ?></span>
                                    </h1>
								<?php endif; ?>
                            </div> <!-- hosting -->
                        </div> <!-- column panel-2 -->
                        <div class="large-5 medium-6 small-12 column panel-3">
                            <h1>Account Manager</h1>
                            <!-- div where the Account Manager information is output -->
                            <div id="manager"></div>
                            <p><strong>Hours:</strong> Mon. – Fri. 8am-5pm EST</p>
                        </div> <!-- column panel-3 -->
                        <!-- Script that outputs all the code for the Account Manager -->
                        <script>
                            jQuery(document).ready(function () {
                                // WP Rest API url from http://drumcreative.com
                                var rest_url = 'https://drumcreative.com/wp-json/acf/v2/options/account_managers?_jsonp?';
                                jQuery.ajax({
                                    url: rest_url,
                                    dataType: 'json',
                                    jsonpCallback: 'MyJSONPCallback', // specify the callback name if you're hard-coding it
                                    success: function(account_managers){
                                        // we make a successful JSONP call!
                                        var output = '';
                                        var account_managers = account_managers.account_managers
                                        // Name for Account Manager
                                        output += "<p><strong>Name: </strong>" +
                                            account_managers[<?php echo get_field( 'account_manager', 'option' ); ?>].name +
                                            "</p>" +
                                            // Email for Account Manager
                                            "<p><strong>Email: </strong> <a href='mailto:" + account_managers[<?php echo get_field( 'account_manager', 'option' ); ?>].email + "'>" + account_managers[<?php echo get_field( 'account_manager', 'option' ); ?>].email + "</a></p>" +
                                            // Phone Number for Account Manager
                                            "<p><strong>Phone: </strong>" + account_managers[<?php echo get_field( 'account_manager', 'option' ); ?>].phone_number_extention + "</p>";
                                        console.log(account_managers);

                                        // Outputs the code for the Account Manager
                                        var update = document.getElementById('manager');
                                        update.innerHTML = output;

                                    }
                                });
                            });
                        </script>
                    </div> <!-- .welcome-panel-column-container -->
                </div> <!-- .drum-panel-content -->
            </div> <!-- #drum-welcome -->
		<?php endif; ?>
		<?php if ( get_field( 'show_video_tutorials', 'option' ) == true ): ?>
            <div id="drum-video" class="welcome-panel drum-panel" style="display: none;">
                <div class="welcome-panel-content drum-panel-content">
					<?php echo the_field( 'video_admin_intro_content', 'option' ); ?>
                    <div class="welcome-panel-column-container">
                        <div class="builder-type">
                            <div class="medium-12 columns">
                                <?php if( get_field('website_builder_type', 'option') == 'drumdivi' ): ?>
                                    <h1>Page Builder Video Training</h1> <a class="button button-primary button-hero"
                                                                    href="https://vimeo.com/album/5739459"
                                                                    target="_blank">Learn Basics</a>
                                <?php elseif( get_field('website_builder_type', 'option') == 'drumelementor' ): ?>
                                    <h1> Page Builder Video Training</h1> <a class="button button-primary button-hero"
                                                                          href="https://vimeo.com/album/5885095" target="_blank">Learn Basics</a>
                                <?php else:?>
                                    <h1>Your Video Training</h1>
                                <?php endif; ?>
                            </div>
                        </div>
						<?php
						if ( have_rows( 'videos', 'option' ) ):
							$counter = 1;
							while ( have_rows( 'videos', 'option' ) ) : the_row(); ?>
                                <div class="large-3 medium-6 short-delay columns tut-video">
									<?php if ( get_sub_field( 'video_type' ) == 'Loom' ): ?>
										<?php
										$loom_url = get_sub_field( 'loom_video_url' );
										$new_url  = str_replace( 'share', 'embed', $loom_url );
										?>

                                        <iframe class="vid-iframe" width="100%" height="218"
                                                src="<?php echo $new_url; ?>" frameborder="0" webkitallowfullscreen
                                                mozallowfullscreen allowfullscreen></iframe>
                                        <div class="loom-video-title">
                                            <h2><?php echo get_sub_field( 'loom_video_title' ); ?></h2>
                                        </div>
                                    <?php elseif (get_sub_field('video_type') == 'Youtube') : ?>
                                        <?php
                                        // get iframe HTML
                                        $iframe = get_sub_field('youtube');
                                        // use preg_match to find iframe src
                                        preg_match('/src="(.+?)"/', $iframe, $matches);
                                        $src = $matches[1];
                                        // add extra params to iframe src
                                        $params = array(
                                            'controls' => 0,
                                            'hd' => 1,
                                            'autohide' => 1,
                                            'modestbranding' => 0,
                                            'showinfo' => 0

                                        );

                                        $new_src = add_query_arg($params, $src);
                                        $iframe = str_replace($src, $new_src, $iframe);
                                        // add extra attributes to iframe html
                                        $attributes = 'frameborder="0"';

                                        $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
                                        // echo $iframe
                                        echo $iframe;

                                        ?>
                                        <div class="youtube-video-title">
                                            <h2><?php echo get_sub_field('youtube_video_title'); ?></h2>
                                        </div>
									<?php else: ?>
                                        <iframe id="video-<?php echo $counter; ?>" width="560" height="370"
                                                src="https://player.vimeo.com/video/<?php echo the_sub_field( 'video_id' ); ?>?title=0&byline=0&portrait=0"
                                                frameborder="0" allowfullscreen></iframe>
                                        <div id="video-title-<?php echo $counter; ?>" class="video-title"></div>
                                        <script>
                                            jQuery(window).load(function () {
                                                var videoFrame = document.querySelector('iframe#video-<?php echo $counter; ?>');
                                                var options = {
                                                    loop: false
                                                };
                                                var player = new Vimeo.Player(videoFrame, options);
                                                player.getVideoTitle().then(function (title) {
                                                    jQuery('#video-title-<?php echo $counter; ?>').html('<h2>' + title + '</h2>');
                                                }).catch(function (error) {
                                                    alert('Some went wrong ');
                                                });
                                            });
                                        </script>
									<?php endif; ?>
                                </div> <!-- .tut-video -->
								<?php $counter ++; ?>
							<?php endwhile;
						endif;
						?>
                    </div><!-- .welcome-panel-column-container -->
                </div><!-- .drum-panel-content -->
            </div><!-- #drum-video -->
		<?php endif; ?>
		<?php if ( get_field( 'show_drum_hosting_ad', 'option' ) == true ): ?>
            <div id="drum-ad" class="welcome-panel drum-panel" style="display: none;">
                <div class="welcome-panel-content drum-panel-content">
					<?php if ( get_field( 'drum_ad', 'option' ) == 'Ad Maintenance' ): ?>
                        <!--            <a href="https://drumcreative.com/dashboard-maintenance" target="_blank"> -->
                        <a href="mailto:support@drumcreative.com?subject=Interested in a Maintenance Plan">
                            <img src="https://drumcreative.com/ads/ad-maintenance.jpg" alt="Maintenance Ad"/>
                        </a> <!-- drum ad- -->
					<?php elseif ( get_field( 'drum_ad', 'option' ) == 'Ad SEO' ): ?>
                        <!--            <a href="https://drumcreative.com/dashboard-seo" target="_blank"> -->
                        <a href="mailto:support@drumcreative.com?subject=Interested in a SEO Plan">
                            <img src="https://drumcreative.com/ads/ad-seo.jpg" alt="SEO Ad"/>
                        </a> <!-- drum ad- -->
					<?php else: ?>
                        <!--            <a href="https://drumcreative.com/dashboard-hosting" target="_blank"> -->
                        <a href="mailto:support@drumcreative.com?subject=Interested in a Hosting Plan">
                            <img src="https://drumcreative.com/ads/ad-hosting.jpg" alt="Hosting Ad"/>
                        </a> <!-- drum ad- -->
					<?php endif; ?>
                </div><!-- .drum-panel-content -->
            </div><!-- #drum-ad -->
		<?php endif; ?>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            jQuery(document).ready(function () {
                jQuery('#dashboard-widgets-wrap').prepend(jQuery('#drum-ad').show());
                jQuery('#dashboard-widgets-wrap').prepend(jQuery('#drum-video').show());
                jQuery('#dashboard-widgets-wrap').prepend(jQuery('#drum-welcome').show());

            });
        </script>
	<?php }

}
}
add_action( 'admin_notices', 'display_admin_notice' );
?>