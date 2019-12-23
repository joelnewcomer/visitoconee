<?php

namespace WBCR\Antispam\Page;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница лицензирования плагина.
 *
 * Поддерживает режим работы с мультисаймами. Вы можете увидеть эту страницу в панели настройки сети.
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 *
 * @copyright (c) 2018 Webraftic Ltd
 */
class License extends \Wbcr_FactoryClearfy216_LicensePage {

	/**
	 * {@inheritdoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  6.0
	 * @var string
	 */
	public $id = 'license';

	/**
	 * {@inheritdoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  6.0
	 * @var string
	 */
	public $page_parent_page;

	/**
	 * WCL_LicensePage constructor.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 *
	 * @param \Wbcr_Factory424_Plugin $plugin
	 */
	public function __construct( \Wbcr_Factory424_Plugin $plugin ) {
		$this->menu_title                  = __( 'License', 'anti-spam' );
		$this->page_menu_short_description = __( 'Product activation', 'anti-spam' );
		$this->plan_name                   = __( 'Anti-spam PRO', 'anti-spam' );

		parent::__construct( $plugin );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.6.0
	 * @return string
	 */
	public function get_plan_description() {
		$description = '<p style="font-size: 16px;">' . __( '<b>Anti-spam PRO</b> is a paid package of components for the popular free WordPress plugin named Anti-spam PRO. You get access to all paid components at one price.', 'clearfy' ) . '</p>';
		$description .= '<p style="font-size: 16px;">' . __( 'Paid license guarantees that you can download and update existing and future paid components of the plugin.', 'clearfy' ) . '</p>';

		return $description;
	}
}