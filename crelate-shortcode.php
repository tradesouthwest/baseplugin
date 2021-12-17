<?php
/*
Plugin Name: Crelate Shortcode
Description: Add custom iframe for Crelate API
Version: 1.0.0
Author: tradesouthwest
Author URI: https://themes.tradesouthwest.com/plugins
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) { // Avoid direct calls to this file and prevent full path disclosure
	exit;
}

/** 
 * Constants
 * 
 * @param CRELATE_SHORT_VER         Using bumped ver.
 * @param CRELATE_SHORT_URL         Base path
 * @since 1.0.0 
 */
if( !defined( 'CRELATE_SHORT_VER' )) { define( 'CRELATE_SHORT_VER', '1.0.0' ); }
if( !defined( 'CRELATE_SHORT_URL' )) { define( 'CRELATE_SHORT_URL', 
    plugin_dir_url(__FILE__)); }

    // Start the plugin when it is loaded.
    register_activation_hook(   __FILE__, 'crelate_shortcode_plugin_activation' );
    register_deactivation_hook( __FILE__, 'crelate_shortcode_plugin_deactivation' );
  
/**
 * Activate/deactivate hooks
 * 
 */
function crelate_shortcode_plugin_activation() 
{

    return false;
}
function crelate_shortcode_plugin_deactivation() 
{
    return false;
}
/**
 * Define the locale for this plugin for internationalization.
 * Set the domain and register the hook with WordPress.
 *
 * @uses slug `swedest`
 */
add_action( 'plugins_loaded', 'crelate_shortcode_load_plugin_textdomain' );

function crelate_shortcode_load_plugin_textdomain() 
{

    $plugin_dir = basename( dirname(__FILE__) ) .'/languages';
                  load_plugin_textdomain( 'crelate-short', false, $plugin_dir );
}

/** 
 * Admin side specific
 *
 * Enqueue admin only scripts 
 */ 
//add_action( 'admin_enqueue_scripts', 'crelate_shortcode_load_admin_scripts' );   
function crelate_shortcode_load_admin_scripts() 
{
    /*
     * Enqueue styles */
    wp_enqueue_style( 'crelate-shortcode-admin', 
                        CRELATE_SHORT_URL . 'css/crelate-shortcode-admin.css', 
                        array(), CRELATE_SHORT_VER, false 
                        );
    wp_register_script( 'js-code-editor', plugin_dir_url( __FILE__ ) 
    . 'js/js-code-editor.js', array( 'jquery' ), '', true );

    // Put scripts to head or footer.
    wp_enqueue_script( 'js-code-editor');
    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
}

require_once ( plugin_dir_path(__FILE__) . 'inc/crelate-shortcode-admin.php' );
require_once ( plugin_dir_path(__FILE__) . 'inc/crelate-shortcode-shortcode.php' );
?>