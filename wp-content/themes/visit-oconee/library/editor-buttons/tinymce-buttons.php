<?php
// Hooks your functions into the correct filters
function drum_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'drum_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'drum_register_mce_button' );
	}
}
add_action('admin_head', 'drum_add_mce_button');

// Declare script for new button
function drum_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['drum_mce_button'] = get_template_directory_uri() .'/library/editor-buttons/drum-plugin.js';
	return $plugin_array;
}

// Register new button in the editor
function drum_register_mce_button( $buttons ) {
	array_push( $buttons, 'drum_mce_button' );
	return $buttons;
}

function drum_shortcodes_mce_css() {
	wp_enqueue_style('drum_shortcodes', get_template_directory_uri() . '/library/editor-buttons/tinymce-buttons.css' );
}
add_action( 'admin_enqueue_scripts', 'drum_shortcodes_mce_css' );
?>