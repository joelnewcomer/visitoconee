<?php

namespace wpautoterms;


use wpautoterms\frontend\Endorsements;
use wpautoterms\frontend\Links;
use wpautoterms\frontend\notice\Cookies_Notice;
use wpautoterms\frontend\notice\Update_Notice;

abstract class Frontend {
	protected static $_body_top = '';
	/**
	 * @var Links
	 */
	protected static $_links;

	public static function init( $license ) {
		global $pagenow;
		if ( in_array( $pagenow, array( 'wp-login.php', 'wp-register.php' ) ) ) {
			return;
		}
		// NOTE: modify buffer on teardown.
		ob_start( array( __CLASS__, '_out_head' ) );
		add_action( WPAUTOTERMS_SLUG . '_registered_cpt', array( __CLASS__, 'action_registered_cpt' ), 20 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'wp_footer', array( __CLASS__, 'footer' ), 100002 );
		$a = Update_Notice::create();
		$a->init();
		$a = Cookies_Notice::create( $license );
		$a->init();
		new Endorsements( $license );
		static::$_links = new Links();
	}


	public static function action_registered_cpt() {
		static::$_body_top = static::top_container( true );
	}

	public static function enqueue_scripts() {
		wp_register_style( WPAUTOTERMS_SLUG . '_css', WPAUTOTERMS_PLUGIN_URL . 'css/wpautoterms.css', false );
		wp_enqueue_style( WPAUTOTERMS_SLUG . '_css' );
	}

	public static function _out_head( $buf ) {
		$ct = 'content-type';
		$ct_len = strlen( $ct );
		$handle = true;
		foreach ( headers_list() as $h ) {
			$h = ltrim( $h );
			if ( strncasecmp( $h, $ct, $ct_len ) === 0 ) {
				// do not handle non-html content
				if ( 1 !== preg_match( '/^content-type:\s*(text\/html|application\/xhtml\+xml)([^[:alnum:]]+.*|)$/i', $h ) ) {
					$handle = false;
				}
				break;
			}
		}
		if ( ! $handle ) {
			return $buf;
		}
		$m = array();
		preg_match( '/(.*<\s*body[^>]*>)(.*)/is', $buf, $m );
		$ret = '';
		if ( count( $m ) < 3 ) {
			// NOTE: HTML is not well formed, we can only detect a closing body
			$ret .= $buf;
			$ret .= static::$_body_top;
		} else {
			$ret .= $m[1];
			$ret .= static::$_body_top;
			$ret .= $m[2];
		}

		return $ret;
	}

	public static function footer() {
		static::$_links->links_box();
		static::bottom_container();
	}

	protected static function container( $where, $type, $return = false ) {
		ob_start();
		do_action( WPAUTOTERMS_SLUG . '_container', $where, $type );
		$c = ob_get_contents();
		ob_end_clean();
		if ( ! empty( $c ) ) {
			$c = '<div id="wpautoterms-' . $where . '-' . $type . '-container">' . $c . '</div>';
		}
		if ( $return ) {
			return $c;
		}
		echo $c;

		return '';
	}

	protected static function top_container( $return = false ) {
		$c = static::container( 'top', 'static', $return );
		$c .= static::container( 'top', 'fixed', $return );
		if ( $return ) {
			return $c;
		}
		echo $c;

		return '';
	}

	protected static function bottom_container() {
		static::container( 'bottom', 'fixed' );
		static::container( 'bottom', 'static' );
	}
}
