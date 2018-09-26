<?php
/**
 * Register Menus
 *
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
register_nav_menus(array(
	'main-menu'  => 'Main Menu',
	'top-menu'  => 'Top Menu',
));

/**
 * Desktop navigation - Main Menu
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'drumroll_main_menu' ) ) {
	function drumroll_main_menu() {
		wp_nav_menu( array(
			'container'      => false,
			'menu_class'     => 'dropdown menu slimmenu',
			'items_wrap'     => '<ul id="%1$s" class="%2$s desktop-menu" data-dropdown-menu>%3$s</ul>',
			'theme_location' => 'main-menu',
			'depth'          => 3,
			'fallback_cb'    => false,
		));
	}
}

if ( ! function_exists( 'drumroll_top_menu' ) ) {
	function drumroll_top_menu() {
		wp_nav_menu( array(
			'container'      => false,
			'menu_class'     => 'menu',
			'items_wrap'     => '<ul id="%1$s" class="%2$s top-menu">%3$s</ul>',
			'theme_location' => 'top-menu',
			'depth'          => 1,
			'fallback_cb'    => false,
		));
	}
}