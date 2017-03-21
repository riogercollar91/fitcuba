<?php

/**
 * Plugin bootstrap file
 *
 * @sassy-social-share
 * Plugin Name:       Sassy Social Share
 * Plugin URI:        https://www.heateor.com
 * Description:       Slickest, Simplest and Optimized Share buttons. Facebook, Twitter, Google+, Pinterest, WhatsApp and over 100 more.
 * Version:           2.3
 * Author:            Team Heateor
 * Author URI:        https://www.heateor.com
 * Text Domain:       sassy-social-share
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die( "Cheating........Uh!!" );

// If this file is called directly, halt.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'HEATEOR_SSS_VERSION', '2.3' );
define( 'HEATEOR_SSS_PLUGIN_DIR', plugin_dir_path(__FILE__) );

// plugin core class object
$heateor_sss = null;

/**
 * Updates SVG CSS file according to chosen logo color
 */
function heateor_sss_update_svg_css( $color_to_be_replaced, $css_file ) {
	$path = plugin_dir_url( __FILE__ ) . '/admin/css/' . $css_file . '.css';
	$content = file( $path );
	if ( $content !== false ) {
		$handle = fopen( dirname( __FILE__ ) . '/admin/css/' . $css_file . '.css','w' );
		if ( $handle !== false ) {
			foreach ( $content as $value ) {
			    fwrite( $handle, str_replace( '%23fff', str_replace( '#', '%23', $color_to_be_replaced ), $value ) );
			}
			fclose( $handle );
		}
	}
}

/**
 * Runs during plugin activation
 */
function heateor_sss_default_options() {

	// default options
	add_option( 'heateor_sss', array(
	   'horizontal_sharing_shape' => 'round',
	   'horizontal_sharing_size' => '35',
	   'horizontal_sharing_width' => '70',
	   'horizontal_sharing_height' => '35',
	   'horizontal_border_radius' => '',
	   'horizontal_font_color_default' => '',
	   'horizontal_sharing_replace_color' => '#fff',
	   'horizontal_font_color_hover' => '',
	   'horizontal_sharing_replace_color_hover' => '#fff',
	   'horizontal_bg_color_default' => '',
	   'horizontal_bg_color_hover' => '',
	   'horizontal_border_width_default' => '',
	   'horizontal_border_color_default' => '',
	   'horizontal_border_width_hover' => '',
	   'horizontal_border_color_hover' => '',
	   'vertical_sharing_shape' => 'square',
	   'vertical_sharing_size' => '40',
	   'vertical_sharing_width' => '80',
	   'vertical_sharing_height' => '40',
	   'vertical_border_radius' => '',
	   'vertical_font_color_default' => '',
	   'vertical_sharing_replace_color' => '#fff',
	   'vertical_font_color_hover' => '',
	   'vertical_sharing_replace_color_hover' => '#fff',
	   'vertical_bg_color_default' => '',
	   'vertical_bg_color_hover' => '',
	   'vertical_border_width_default' => '',
	   'vertical_border_color_default' => '',
	   'vertical_border_width_hover' => '',
	   'vertical_border_color_hover' => '',
	   'hor_enable' => '1',
	   'horizontal_target_url' => 'default',
	   'horizontal_target_url_custom' => '',
	   'title' => 'Spread the love',
	   'horizontal_re_providers' => array( 'facebook', 'twitter', 'google_plus', 'linkedin', 'pinterest', 'reddit', 'delicious', 'stumbleupon', 'whatsapp' ),
	   'hor_sharing_alignment' => 'left',
	   'top' => '1',
	   'post' => '1',
	   'page' => '1',
	   'horizontal_more' => '1',
	   'vertical_enable' => '1',
	   'vertical_target_url' => 'default',
	   'vertical_target_url_custom' => '',
	   'vertical_re_providers' => array( 'facebook', 'twitter', 'google_plus', 'linkedin', 'pinterest', 'reddit', 'delicious', 'stumbleupon', 'whatsapp' ),
	   'vertical_bg' => '',
	   'alignment' => 'left',
	   'left_offset' => '-10',
	   'right_offset' => '-10',
	   'top_offset' => '100',
	   'vertical_post' => '1',
	   'vertical_page' => '1',
	   'vertical_home' => '1',
	   'vertical_more' => '1',
	   'hide_mobile_sharing' => '1',
	   'vertical_screen_width' => '783',
	   'bottom_mobile_sharing' => '1',
	   'horizontal_screen_width' => '783',
	   'bottom_sharing_position' => '0',
	   'bottom_sharing_alignment' => 'left',
	   'footer_script' => '1',
	   'delete_options' => '1',
	   'share_count_cache_refresh_count' => '10',
	   'share_count_cache_refresh_unit' => 'minutes',
	   'bitly_username' => '',
	   'bitly_key' => '',
	   'language' => get_locale(),
	   'twitter_username' => '',
	   'buffer_username' => '',
	   'custom_css' => '',
	   'tweet_count_service' => 'newsharecounts',
	   'amp_enable' => '1'
	) );

	// plugin version
	add_option( 'heateor_sss_version', HEATEOR_SSS_VERSION );

}

register_activation_hook( __FILE__, 'heateor_sss_default_options' );

/**
 * The core plugin class
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sassy-social-share.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function heateor_sss_run() {

	global $heateor_sss;
	$heateor_sss = new Sassy_Social_Share( HEATEOR_SSS_VERSION );

}
heateor_sss_run();
