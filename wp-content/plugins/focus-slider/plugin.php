<?php

/*
  Plugin Name: Focus by Phpbits
  Plugin URI: http://focus-wp.com/
  Description: Featured Post Slider for WordPress
  Author: phpbits
  Version: 1.0
  Author URI: https://phpbits.net/

  Text Domain: focuswp
 */

//avoid direct calls to this file

if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
define( 'FOCUSWP_SLIDER_VERSION', '1.0' );

//allow widget to print shortcode
add_filter('widget_text', 'do_shortcode');

/*##################################
  REQUIRE
################################## */
require_once( dirname( __FILE__ ) . '/core/functions.enqueue.php' );
require_once( dirname( __FILE__ ) . '/core/functions.shortcodes.php' );
require_once( dirname( __FILE__ ) . '/core/functions.widget.php' );
require_once( dirname( __FILE__ ) . '/core/functions.media-frame.php' );
require_once( dirname( __FILE__ ) . '/core/functions.tinymce.php' );
require_once( dirname( __FILE__ ) . '/core/functions.screen.php' );
require_once( dirname( __FILE__ ) . '/core/functions.notices.php' );

/**
 * Install
 *
 * Runs on plugin install to populates the settings fields for those plugin
 * pages.
 */
if( !function_exists( 'focuswp_slider_install' ) ){
	register_activation_hook( __FILE__, 'focuswp_slider_install' );
	function focuswp_slider_install() {
		if( !get_option( 'focuswp_installDate' ) ){
			add_option( 'focuswp_installDate', date( 'Y-m-d h:i:s' ) );
		}
	}
}
?>
