<?php

namespace WBCR\Antispam\Page;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница общих настроек для этого плагина.
 *
 * Не поддерживает режим работы с мультисаймами.
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 * @copyright (c) 2019 Webraftic Ltd
 * @version       1.0
 */
class Settings extends \Wbcr_FactoryClearfy216_PageBase {

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var string
	 */
	public $id = "settings";

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-testimonial';

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var string
	 */
	public $menu_target = 'options-general.php';

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var bool
	 */
	public $show_right_sidebar_in_options = true;

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var bool
	 */
	public $internal = false;

	/**
	 * {@inheritDoc}
	 *
	 * @since  6.0
	 * @var bool
	 */
	public $add_link_to_plugin_actions = true;

	/**
	 * WBCR\Page\Settings constructor.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 *
	 * @param \Wbcr_Factory424_Plugin $plugin
	 */
	public function __construct( \Wbcr_Factory424_Plugin $plugin ) {
		$this->menu_title                  = __( 'Anti-spam', 'anti-spam' );
		$this->page_menu_short_description = __( 'All settings', 'anti-spam' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}


	public function getPageTitle() {
		return __( 'General', 'anti-spam' );
	}

	/**
	 * Enqueue page assets
	 *
	 * @since 6.2
	 * @return void
	 * @see   Wbcr_FactoryPages424_AdminPage
	 *
	 */
	public function assets( $scripts, $styles ) {
		parent::assets( $scripts, $styles );

		$this->styles->add( WANTISPAM_PLUGIN_URL . '/admin/assets/css/settings.css' );
		$this->scripts->add( WANTISPAM_PLUGIN_URL . '/admin/assets/js/settings.js', [
			'jquery',
			'wbcr-factory-clearfy-216-global'
		], 'wantispam-settings' );
	}

	/**
	 * Permalinks options.
	 *
	 * @since 6.2
	 * @return mixed[]
	 */
	public function getPageOptions() {
		$is_premium = \WBCR\Antispam\Plugin::app()->premium->is_activate();

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . '<strong>' . __( 'Base options.', 'anti-spam' ) . '</strong>' . '<p>' . __( 'More 1 000 000 spam comments were blocked by Anti-spam plugin so far. Upgrade to Anti-spam Pro for advanced protection.', 'anti-spam' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'save_spam_comments',
			'title'   => __( 'Save spam comments', 'anti-spam' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
			'hint'    => __( 'Save spam comments into spam section. Useful for testing how the plugin works.', 'anti-spam' ),
			'default' => true
		];

		if ( $is_premium ) {
			$options[] = [
				'type'    => 'checkbox',
				'way'     => 'buttons',
				'name'    => 'comment_form_privacy_notice',
				'title'   => __( 'Display a privacy notice under your comment forms.', 'anti-spam' ),
				'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
				'hint'    => __( 'To help your site with transparency under privacy laws like the GDPR, Antispam can display a notice to your users under your comment forms. This feature is disabled by default, however, you can turn it on above.', 'anti-spam' ),
				'default' => false
			];
		}

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . '<strong>' . __( 'Modules.', 'anti-spam' ) . '</strong>' . '<p>' . __( 'Additional modules to spam protect.', 'anti-spam' ) . '</p>' . '</div>'
		];

		$options[] = [
			'type'     => 'checkbox',
			'way'      => 'buttons',
			'name'     => 'protect_register_form',
			'title'    => __( 'Protect Register Form', 'anti-spam' ),
			'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
			'hint'     => __( 'Registration form can be protected in a matter of minutes with a few new fields and limits imposed.', 'anti-spam' ),
			'default'  => false,
			'cssClass' => ! $is_premium ? [ 'factory-checkbox--disabled wantispam-checkbox-premium-label' ] : [],
		];
		$options[] = [
			'type'     => 'checkbox',
			'way'      => 'buttons',
			'name'     => 'protect_comments_form',
			'title'    => __( 'Advanced protection of comment forms', 'anti-spam' ),
			'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'green' ],
			'hint'     => sprintf( __( 'In order to protect your cooment forms, you need to make it difficult or impossible for an automated tool to fill in or submit the form while keeping it as easy as possible for your customers to fill out the form.', 'anti-spam' ), \WBCR\Antispam\Plugin::app()->getPluginTitle() ),
			'default'  => false,
			'cssClass' => ! $is_premium ? [ 'factory-checkbox--disabled wantispam-checkbox-premium-label' ] : [],
		];
		/*$options[] = [
			'type'     => 'checkbox',
			'way'      => 'buttons',
			'name'     => 'protect_contacts_form',
			'title'    => __( 'Protect Contact Forms (Beta)', 'anti-spam' ),
			'layout'   => [ 'hint-type' => 'icon', 'hint-icon-color' => 'red' ],
			'hint'     => __( 'Job Spam-Free for WordPress Contact Forms.', 'anti-spam' ),
			'default'  => false,
			'cssClass' => ! $is_premium ? [ 'factory-checkbox--disabled wantispam-checkbox-premium-label' ] : [],
		];*/

		$form_options = [];

		$form_options[] = [
			'type'  => 'form-group',
			'items' => $options,
			//'cssClass' => 'postbox'
		];

		return apply_filters( 'wantispam/settings_form/options', $form_options, $this );
	}
}
