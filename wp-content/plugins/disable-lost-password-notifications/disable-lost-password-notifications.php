<?php
/*
Plugin Name: Disable Lost Password Notifications
Description: See plugin name.
*/

if ( !function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification() {}
}
?>