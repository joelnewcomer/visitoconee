<?php

namespace wpautoterms\cpt;

use wpautoterms\admin\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


abstract class CPT {
	const ROLE = 'manage_wpautoterms_pages';
	const ADD_TO_ROLE = 'administrator';

	public static function init() {
		add_filter( 'theme_' . static::type() . '_templates', array( __CLASS__, 'filter_templates' ), 10, 2 );
		add_action( 'user_register', array( __CLASS__, 'add_role' ), 10, 1 );
	}

	public static function edit_cap() {
		return 'edit_' . static::cap_plural();
	}

	public static function type() {
		return WPAUTOTERMS_SLUG . '_page';
	}

	public static function cap_singular() {
		return WPAUTOTERMS_SLUG . '_page';
	}

	public static function cap_plural() {
		return WPAUTOTERMS_SLUG . '_pages';
	}

	public static function caps() {
		$p = static::cap_plural();

		return array(
			'edit_' . $p => true,
			'edit_others_' . $p => true,
			'edit_private_' . $p => true,
			'edit_published_' . $p => true,
			'read_private_' . $p => true,
			'delete_' . $p => true,
			'delete_others_' . $p => true,
			'delete_private_' . $p => true,
			'delete_published_' . $p => true,
			'publish_' . $p => true,
		);
	}

	public static function register() {
		$labels = array(
			'name' => __( 'Legal Pages', WPAUTOTERMS_SLUG ),
			'all_items' => __( 'All Legal Pages', WPAUTOTERMS_SLUG ),
			'singular_name' => __( 'Legal Page', WPAUTOTERMS_SLUG ),
			'add_new' => __( 'Add Legal Pages', WPAUTOTERMS_SLUG ),
			'add_new_item' => __( 'Add Legal Page', WPAUTOTERMS_SLUG ),
			'edit' => __( 'Edit', WPAUTOTERMS_SLUG ),
			'edit_item' => __( 'Edit Legal Page', WPAUTOTERMS_SLUG ),
			'new_item' => __( 'New Legal Page', WPAUTOTERMS_SLUG ),
			'view' => __( 'View', WPAUTOTERMS_SLUG ),
			'view_item' => __( 'View Legal Page', WPAUTOTERMS_SLUG ),
			'search_items' => __( 'Search Legal Pages', WPAUTOTERMS_SLUG ),
			'not_found' => __( 'No legal pages exist.', WPAUTOTERMS_SLUG ),
			'not_found_in_trash' => __( 'No legal pages found in Trash', WPAUTOTERMS_SLUG ),
			'parent' => __( 'Parent Legal Pages', WPAUTOTERMS_SLUG ),
			'plugin_listing_table_title_cell_link' => __( 'Wpautoterms', WPAUTOTERMS_SLUG ),
			'menu_name' => __( 'WP AutoTerms', WPAUTOTERMS_SLUG ),
		);

		$cs = static::cap_singular();
		$cp = static::cap_plural();

		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'revisions', 'page-attributes', 'custom-fields' ),
			'public' => true,
			'show_ui' => true,
			//'show_in_nav_menus'   => false,
			'show_in_menu' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => array( 'slug' => Options::get_option( Options::LEGAL_PAGES_SLUG ) ),
			'map_meta_cap' => true,
			'capability_type' => array( static::cap_singular(), static::cap_plural() ),
			'menu_icon' => WPAUTOTERMS_PLUGIN_URL . 'images/icon.png',
			'show_admin_column' => true,
		);

		register_post_type( static::type(), $args );
	}

	public static function register_role() {
		$role = add_role( static::ROLE, __( 'WPAutoTerms Legal pages editor' ), static::caps() );
		if ( $role === null ) {
			return;
		}
		$users = get_users( array( 'role' => static::ADD_TO_ROLE ) );
		if ( ! empty( $users ) ) {
			/**
			 * @var $user \WP_User
			 */
			foreach ( $users as $user ) {
				$user->add_role( static::ROLE );
			}
		}
	}

	public static function unregister_role() {
		remove_role( static::ROLE );
	}

	public static function add_role( $user_id ) {
		$user = get_user_by( 'id', $user_id );
		if ( in_array( static::ADD_TO_ROLE, $user->roles ) ) {
			$user->add_role( static::ROLE );
		}
	}

	/**
	 * @param [] $post_templates
	 * @param \WP_Theme $theme
	 *
	 * @return array
	 */
	public static function filter_templates( $post_templates, $theme ) {
		return array_merge( $post_templates, $theme->get_page_templates() );
	}
}
