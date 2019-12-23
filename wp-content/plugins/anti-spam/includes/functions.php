<?php
/**
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>, Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 12.12.2019, Webcraftic
 * @version       1.0
 */

/**
 * Should show a page about the plugin or not.
 *
 * @return bool
 */
function wantispam_is_need_show_about_page() {
	if ( \WBCR\Antispam\Plugin::app()->isNetworkActive() ) {
		$need_show_about = (int) get_site_option( \WBCR\Antispam\Plugin::app()->getOptionName( 'what_is_new_64' ) );
	} else {
		$need_show_about = (int) get_option( \WBCR\Antispam\Plugin::app()->getOptionName( 'what_is_new_64' ) );
	}

	$is_ajax = wantispam_doing_ajax();
	$is_cron = wantispam_doing_cron();
	$is_rest = wantispam_doing_rest_api();

	if ( $need_show_about && ! $is_ajax && ! $is_cron && ! $is_rest ) {
		return true;
	}

	return false;
}

/**
 * Checks if the current request is a WP REST API request.
 *
 * Case #1: After WP_REST_Request initialisation
 * Case #2: Support "plain" permalink settings
 * Case #3: URL Path begins with wp-json/ (your REST prefix)
 *          Also supports WP installations in subfolders
 *
 * @author matzeeable https://wordpress.stackexchange.com/questions/221202/does-something-like-is-rest-exist
 * @since  2.1.0
 * @return boolean
 */
function wantispam_doing_rest_api() {
	$prefix     = rest_get_url_prefix();
	$rest_route = \WBCR\Antispam\Plugin::app()->request->get( 'rest_route', null );
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST // (#1)
	     || ! is_null( $rest_route ) // (#2)
	        && strpos( trim( $rest_route, '\\/' ), $prefix, 0 ) === 0 ) {
		return true;
	}

	// (#3)
	$rest_url    = wp_parse_url( site_url( $prefix ) );
	$current_url = wp_parse_url( add_query_arg( [] ) );

	return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
}

/**
 * @since 2.1.0
 * @return bool
 */
function wantispam_doing_ajax() {
	if ( function_exists( 'wp_doing_ajax' ) ) {
		return wp_doing_ajax();
	}

	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

/**
 * @since 2.1.0
 * @return bool
 */
function wantispam_doing_cron() {
	if ( function_exists( 'wp_doing_cron' ) ) {
		return wp_doing_cron();
	}

	return defined( 'DOING_CRON' ) && DOING_CRON;
}