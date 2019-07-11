<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also defines a function that starts the plugin.
 *
 * @link              http://localhost/trinity/wp-content/pligins/trinity=modal
 * @since             1.0.0
 * @package           Trinity_Modal
 *
 * @wordpress-plugin
 * Plugin Name:       Trinity Modal
 * Plugin URI:        http://localhost/trinity/wp-content/pligins/trinity=modal
 * Description:       Shows modal for selected post types, pages etc..
 * Version:           1.0.0
 * Author:            Nemanja Stanojlović
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}
// Include the shared and public dependencies.
include_once( plugin_dir_path( __FILE__ ) . 'shared/class-deserializer.php' );
include_once( plugin_dir_path( __FILE__ ) . 'public/class-content-messenger.php' );
wp_register_style( 'trinity.css', plugin_dir_url( __FILE__ ) . '_inc/trinity.css', array(), TRINITY_VERSION );
wp_enqueue_style( 'trinity.css');

wp_register_script( 'trinity.js', plugin_dir_url( __FILE__ ) . '_inc/trinity.js', array('jquery'), TRINITY_VERSION );
wp_enqueue_script( 'trinity.js' );
// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
    include_once $file;
}
add_action( 'plugins_loaded', 'trinity_modal_settings' );
/**
 * Starts the plugin.
 *
 * @since 1.0.0
 */
function trinity_modal_settings() {
    $serializer = new Serializer();
    $serializer->init();
 
    $deserializer = new Deserializer();
 
    $plugin = new Submenu( new Submenu_Page( $deserializer ) );
    $plugin->init();
 
    // Setup the public facing functionality.
    $public = new Content_Messenger( $deserializer );
    $public->init();
}
