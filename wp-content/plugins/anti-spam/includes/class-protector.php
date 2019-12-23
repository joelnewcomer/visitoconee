<?php

namespace WBCR\Antispam;

/**
 * The class implement some protections ways against spam
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 *
 * @copyright (c) 2018 Webraftic Ltd
 */
class Protector {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_action( 'comment_form', [ $this, 'form_part' ] ); // add anti-spam inputs to the comment form

		if ( \WBCR\Antispam\Plugin::app()->premium->is_activate() ) {
			add_action( 'comment_form_after', [ $this, 'display_comment_form_privacy_notice' ] );
		}

		if ( ! is_admin() ) { // without this check it is not possible to add comment in admin section
			add_filter( 'preprocess_comment', [ $this, 'check_comment' ], 1 );
		}
	}

	public function enqueue_script() {
		global $withcomments; // WP flag to show comments on all pages
		if ( ( is_singular() || $withcomments ) && comments_open() ) { // load script only for pages with comments form
			wp_enqueue_script( 'anti-spam-script', WANTISPAM_PLUGIN_URL . '/assets/js/anti-spam-5.5.js', null, null, true );
		}
	}

	public function form_part() {
		$rn = "\r\n"; // .chr(13).chr(10)

		echo $rn . '<!-- Anti-spam plugin wordpress.org/plugins/anti-spam/ -->' . $rn;
		echo '
        <input type="hidden" name="antspm-j" class="antispam-control antispam-control-j" value="off" />
        ' . $rn; // trap for simple bots that do not emulate the browser

		echo '
		<input type="hidden" name="antspm-t" class="antispam-control antispam-control-t" value="' . time() . '" />
		' . $rn; // Start time of form filling

		if ( ! is_user_logged_in() ) { // add anti-spam fields only for not logged in users

			echo '		<p class="antispam-group antispam-group-q" style="clear: both;">
			<label>Current ye@r <span class="required">*</span></label>
			<input type="hidden" name="antspm-a" class="antispam-control antispam-control-a" value="' . date( 'Y' ) . '" />
			<input type="text" name="antspm-q" class="antispam-control antispam-control-q" value="' . \WBCR\Antispam\Plugin::app()->getPluginVersion() . '" autocomplete="off" />
		</p>' . $rn; // question (hidden with js)
			echo '		<p class="antispam-group antispam-group-e" style="display: none;">
			<label>Leave this field empty</label>
			<input type="text" name="antspm-e-email-url-website" class="antispam-control antispam-control-e" value="" autocomplete="off" />
		</p>' . $rn; // empty field (hidden with css); trap for spammers because many bots will try to put email or url here
		}
	}

	public function check_comment( $commentdata ) {
		$save_spam_comments = \WBCR\Antispam\Plugin::app()->getPopulateOption( 'save_spam_comments', true );

		$comment_type = isset( $commentdata['comment_type'] ) ? $commentdata['comment_type'] : null;

		if ( ! is_user_logged_in() && $comment_type != 'pingback' && $comment_type != 'trackback' ) { // logged in user is not a spammer
			if ( $this->check_for_spam() ) {
				if ( $save_spam_comments ) {
					$this->store_comment( $commentdata );
				}
				$this->counter_stats();
				wp_die( 'Comment is a spam.' ); // die - do not send comment and show error message
			}
		}

		if ( $comment_type == 'trackback' ) {
			if ( $save_spam_comments ) {
				$this->store_comment( $commentdata );
			}
			$this->counter_stats();
			wp_die( 'Trackbacks are disabled.' ); // die - do not send trackback and show error message
		}

		return $commentdata; // if comment does not looks like spam
	}

	public function counter_stats() {
		$antispam_stats = get_option( 'antispam_stats', [] );
		if ( array_key_exists( 'blocked_total', $antispam_stats ) ) {
			$antispam_stats['blocked_total'] ++;
		} else {
			$antispam_stats['blocked_total'] = 1;
		}
		update_option( 'antispam_stats', $antispam_stats );
	}

	public function check_for_spam() {
		$spam_flag = false;

		$antspm_q = '';
		if ( isset( $_POST['antspm-q'] ) ) {
			$antspm_q = trim( $_POST['antspm-q'] );
		}

		$antspm_d = '';
		if ( isset( $_POST['antspm-d'] ) ) {
			$antspm_d = trim( $_POST['antspm-d'] );
		}

		$antspm_e = '';
		if ( isset( $_POST['antspm-e-email-url-website'] ) ) {
			$antspm_e = trim( $_POST['antspm-e-email-url-website'] );
		}

		if ( $antspm_q != date( 'Y' ) ) { // year-answer is wrong - it is spam
			if ( $antspm_d != date( 'Y' ) ) { // extra js-only check: there is no js added input - it is spam
				$spam_flag = true;
			}
		}

		if ( ! empty( $antspm_e ) ) { // trap field is not empty - it is spam
			$spam_flag = true;
		}

		return $spam_flag;
	}

	public function store_comment( $commentdata ) {
		global $wpdb;

		if ( isset( $commentdata['user_ID'] ) ) {
			$commentdata['user_id'] = $commentdata['user_ID'] = (int) $commentdata['user_ID'];
		}

		$prefiltered_user_id = ( isset( $commentdata['user_id'] ) ) ? (int) $commentdata['user_id'] : 0;

		$commentdata['comment_post_ID'] = (int) $commentdata['comment_post_ID'];
		if ( isset( $commentdata['user_ID'] ) && $prefiltered_user_id !== (int) $commentdata['user_ID'] ) {
			$commentdata['user_id'] = $commentdata['user_ID'] = (int) $commentdata['user_ID'];
		} else if ( isset( $commentdata['user_id'] ) ) {
			$commentdata['user_id'] = (int) $commentdata['user_id'];
		}

		$commentdata['comment_parent'] = isset( $commentdata['comment_parent'] ) ? absint( $commentdata['comment_parent'] ) : 0;
		$parent_status                 = ( 0 < $commentdata['comment_parent'] ) ? wp_get_comment_status( $commentdata['comment_parent'] ) : '';
		$commentdata['comment_parent'] = ( 'approved' == $parent_status || 'unapproved' == $parent_status ) ? $commentdata['comment_parent'] : 0;

		if ( ! isset( $commentdata['comment_author_IP'] ) ) {
			$commentdata['comment_author_IP'] = $_SERVER['REMOTE_ADDR'];
		}
		$commentdata['comment_author_IP'] = preg_replace( '/[^0-9a-fA-F:., ]/', '', $commentdata['comment_author_IP'] );

		if ( ! isset( $commentdata['comment_agent'] ) ) {
			$commentdata['comment_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
		}
		$commentdata['comment_agent'] = substr( $commentdata['comment_agent'], 0, 254 );

		if ( empty( $commentdata['comment_date'] ) ) {
			$commentdata['comment_date'] = current_time( 'mysql' );
		}

		if ( empty( $commentdata['comment_date_gmt'] ) ) {
			$commentdata['comment_date_gmt'] = current_time( 'mysql', 1 );
		}

		$commentdata = wp_filter_comment( $commentdata );

		$commentdata['comment_approved'] = wp_allow_comment( $commentdata );
		if ( is_wp_error( $commentdata['comment_approved'] ) ) {
			return $commentdata['comment_approved'];
		}

		$comment_ID = wp_insert_comment( $commentdata );
		if ( ! $comment_ID ) {
			$fields = [ 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content' ];

			foreach ( $fields as $field ) {
				if ( isset( $commentdata[ $field ] ) ) {
					$commentdata[ $field ] = $wpdb->strip_invalid_text_for_column( $wpdb->comments, $field, $commentdata[ $field ] );
				}
			}

			$commentdata = wp_filter_comment( $commentdata );

			$commentdata['comment_approved'] = wp_allow_comment( $commentdata );
			if ( is_wp_error( $commentdata['comment_approved'] ) ) {
				return $commentdata['comment_approved'];
			}

			$comment_ID = wp_insert_comment( $commentdata );
			if ( ! $comment_ID ) {
				return false;
			}
		}

		wp_set_comment_status( $comment_ID, 'spam' );
	}

	/**
	 * Controls the display of a privacy related notice underneath the comment form using the `akismet_comment_form_privacy_notice` option and filter respectively.
	 * Default is top not display the notice, leaving the choice to site admins, or integrators.
	 */
	public function display_comment_form_privacy_notice() {
		if ( ! \WBCR\Antispam\Plugin::app()->getPopulateOption( 'comment_form_privacy_notice' ) ) {
			return;
		}
		echo '<p class="wantispam-comment-form-privacy-notice" style="margin-top:10px;">' . sprintf( __( 'This site uses Antispam to reduce spam. <a href="%s" target="_blank" rel="nofollow noopener">Learn how your comment data is processed</a>.', 'anti-spam' ), 'https://anti-spam.space/antispam-privacy/' ) . '</p>';
	}
}

new \WBCR\Antispam\Protector();










