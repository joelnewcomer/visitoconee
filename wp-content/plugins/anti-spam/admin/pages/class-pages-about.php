<?php

namespace WBCR\Antispam\Page;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The file contains a short help info.
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 * @copyright (c) 2019 Webraftic Ltd
 * @version       1.0
 */
class About extends \Wbcr_FactoryClearfy216_PageBase {

	/**
	 * {@inheritdoc}
	 */
	public $id = 'about';

	/**
	 * {@inheritdoc}
	 */
	public $page_menu_dashicon = 'dashicons-star-filled';

	/**
	 * {@inheritdoc}
	 */
	public $type = 'page';

	/**
	 * {@inheritdoc}
	 */
	public $show_right_sidebar_in_options = false;

	/**
	 * {@inheritdoc}
	 */
	public $page_menu_position = 0;


	/**
	 * Logs constructor.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 *
	 * @param \Wbcr_Factory424_Plugin $plugin
	 */
	public function __construct( \Wbcr_Factory424_Plugin $plugin ) {
		$this->plugin = $plugin;

		$this->menu_title                  = __( 'Premium', 'anti-spam' );
		$this->page_menu_short_description = sprintf( __( 'What is new in %s?', 'anti-spam' ), $this->plugin->getPluginVersion() );

		parent::__construct( $plugin );
	}

	/**
	 * {@inheritdoc}
	 */
	public function showPageContent() {
		global $wp_version;
		?>
        <div class="wrap about-wrap full-width-layout" id="wbcr-inp-about">
        <!-- News Title !-->
        <h1>Meet with <?php echo $this->plugin->getPluginTitle() ?>
            Pro in <?php echo $this->plugin->getPluginVersion() ?></h1>
        <!-- News Subtext !-->
        <div class="about-text">
            Thanks for upgrading! Many new features and improvements are available that you will enjoy.
        </div>
        <!-- Latest News !-->
        <div class="headline">
            <h3 class="headline-title">
                You’ve probably noticed how much our plugin has changed! Now, it’s a
                fully-functional cloud anti-spam
                service: easy to use and without captcha or complex settings.
            </h3>
            <div class="featured-image">
                <img src="<?php echo WANTISPAM_PLUGIN_URL ?>/admin/assets/img/about-preview.jpg" alt="">
            </div>
            <p>&nbsp;</p>
            <p class="introduction">
                A new way of checking comments and registrations for spam. Once you install the plugin, all messages
                pass a three-step verification:
            </p>
            <ul>
                <li>- match with the constantly updated spam base;</li>
                <li>- check by a neural network;</li>
                <li>- filter comments posted on a website before the plugin installation.</li>
            </ul>
            <p>Besides, now you have a handy control panel with various settings and analytics section. The result of
                our work is a great plugin that protects your site from spam much better! Check how it works. If you
                like it, don’t forget to post a review – that motivates us the best!</p>
        </div>
        <div class="feature-section one-col">
            <div class="col">
                <h2>Useful features scheduled for future releases:</h2>
            </div>
        </div>
        <div class="feature-section one-col">
            <div class="col">
                <ul>
                    <li>An additional level of checking comments on the base of stop words;</li>
                    <li>Additional integrations:
                        <p>popular plugins for generating forms; membership plugins, plugins
                            that add registration forms; elementor builders, beaver, composer; woocommerce; bbPress; the
                            subscription forms protection from popular services (for example, Mailchimp).
                        </p>
                    </li>
                    <li>Block or allow comments from specific countries.</li>
                    <li>Allow comments in a certain language only.</li>
                    <li>
                        Manual sorting of comments mistakenly marked as spam.
                        <p>(If a user clicked Spam (that it is not spam), display a pop-up window offering to remove the
                            user from the blacklist. In that case, the messages from this user won’t be considered as
                            spam anymore. It’s a sort of a training model helping the user to avoid manual operations
                            when his client mistakenly ended up being in the blacklist.)</p>
                    </li>
                    <li>Remove all links from comments.</li>
                    <li>Admin notifications to control the correct plugin performance.</li>
                    <li>The spam list auto clean after a certain period.</li>
                </ul>
            </div>
        </div>
		<?php
	}

}
