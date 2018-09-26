<?php
/**
 * Plugin Name: One Click Remove Menu
 * Plugin URI:  http://blogk.xyz
 * Description:  One click remove menu in dashboard helps you save a lot of time.
 * Version: 1.0.0
 * Author: Max
 * Author URI: http://blogk.xyz
 * License: GPLv2 or later
 * Text Domain: one-click-rm
 * Domain Path: /languages
 */

define( 'ONE_CLICK_RM_VERSION', '1.0.0' );
define( 'ONE_CLICK_RM_FILE', __FILE__ );
define( 'ONE_CLICK_RM_PATH', dirname( __FILE__ ) );
define( 'ONE_CLICK_RM_URI', untrailingslashit( plugins_url( '/', ONE_CLICK_RM_FILE ) ) );

add_action( 'admin_enqueue_scripts', 'one_click_rm_admin_enqueue_scripts' );

function one_click_rm_admin_enqueue_scripts( $page ) {
	if ( $page != 'nav-menus.php' ) {
		return;
	}

	wp_enqueue_script( 'one-click-rm', ONE_CLICK_RM_URI . '/menu-manager.js', array( 'jquery', 'backbone' ), ONE_CLICK_RM_VERSION );
	wp_enqueue_style( 'one-click-rm', ONE_CLICK_RM_URI . '/menu-manager.css', array(), ONE_CLICK_RM_VERSION );

	wp_localize_script( 'one-click-rm', 'one_click_rm', array(
		'confirm' => __( 'Are you really want to remove menu item?', 'one-click-rm' ),
	) );
}