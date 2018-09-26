<?php

namespace wpautoterms;

use wpautoterms\admin\Menu;
use wpautoterms\admin\Options;
use wpautoterms\admin\page\Legacy_Settings;
use wpautoterms\admin\page\Settings_Base;
use wpautoterms\cpt\CPT;

class Upgrade {
	public function __construct() {
		add_action( 'init', array( $this, 'run' ) );
	}

	public function run() {
		if ( ! get_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED ) ) {
			/**
			 * @var $page \wpautoterms\admin\page\Base
			 */
			foreach ( Menu::$pages as $page ) {
				if ( $page instanceof Settings_Base ) {
					$d = $page->defaults();
					if ( ! empty( $d ) ) {
						foreach ( $d as $k => $v ) {
							add_option( WPAUTOTERMS_OPTION_PREFIX . $k, $v );
						}
					}
				}
			}
			flush_rewrite_rules();
			CPT::add_caps();
			update_option( WPAUTOTERMS_OPTION_PREFIX . WPAUTOTERMS_OPTION_ACTIVATED, true );
		}
		$version = get_option( WPAUTOTERMS_OPTION_PREFIX . Menu::VERSION );
		if ( $version !== WPAUTOTERMS_VERSION ) {
			$this->_upgrade_from_tos_pp();
			$this->_add_slug_option();
			update_option( WPAUTOTERMS_OPTION_PREFIX . Menu::VERSION, WPAUTOTERMS_VERSION );
		}
	}

	protected function _upgrade_from_tos_pp() {
		$version = get_option( WPAUTOTERMS_OPTION_PREFIX . Menu::VERSION );
		if ( ! empty( $version ) ) {
			$v = explode( '.', $version );
			if ( intval( $v[0] ) > 1 ) {
				return;
			}
		}
		$options = get_option( Menu::AUTO_TOS_OPTIONS, false );
		update_option( WPAUTOTERMS_OPTION_PREFIX . Menu::LEGACY_OPTIONS, $options !== false );
		if ( $options === false ) {
			return;
		}
		$transform = array_keys( Legacy_Settings::all_options() );
		foreach ( $transform as $k ) {
			if ( isset( $options[ $k ] ) ) {
				$v = $options[ $k ];
			} else {
				$v = '';
			}
			update_option( WPAUTOTERMS_OPTION_PREFIX . $k, $v );
		}
	}

	protected function _add_slug_option() {
		$slug = Options::get_option( Options::LEGAL_PAGES_SLUG, true );
		if ( empty( $slug ) ) {
			Options::set_option( Options::LEGAL_PAGES_SLUG, Options::default_value( Options::LEGAL_PAGES_SLUG ) );
		}
	}
}
