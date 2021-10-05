<?php
/**
 *
 * @link              https://github.com/jworkman/gutenberg-block-manager
 * @since             1.0.0
 * @package           Gutenberg_Block_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Block Manager
 * Plugin URI:        https://github.com/jworkman/gutenberg-block-manager
 * Description:       Allows you to define & manage new custom Gutenberg blocks & components through the Wordpress interface.
 * Version:           1.0.0
 * Author:            JWorkman Development
 * Author URI:        https://github.com/jworkman
 * License:           GPL-3.0+
 * License URI:       https://raw.githubusercontent.com/jworkman/gutenberg-block-manager/main/LICENSE
 * Text Domain:       gutenberg-block-manager
 */
require_once plugin_dir_path( __FILE__ ) . '/includes/Factory.php';
use JWorkman\Gutenberg_Block_Manager\Factory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/**
* Currently plugin version.
* Start at version 1.0.0 and use SemVer - https://semver.org
* Rename this for your plugin and update it as you release new versions.
*/
define( 'GUTENBERG_BLOCK_MANAGER_VERSION', '1.0.0' );
define( 'GUTENBERG_BLOCK_MANAGER_CPT_SLUG', 'gbm-component' );

/**
* The code that runs during plugin activation.
* This action is documented in includes/class-plugin-name-activator.php
*/
function activate_gutenberg_block_manager() {
  Factory::invokeStatic('State', 'deactivate');
}

/**
* The code that runs during plugin deactivation.
* This action is documented in includes/class-plugin-name-deactivator.php
*/
function deactivate_gutenberg_block_manager() {
  Factory::invokeStatic('State', 'activate');
}

register_activation_hook( __FILE__, 'activate_gutenberg_block_manager' );
register_deactivation_hook( __FILE__, 'deactivate_gutenberg_block_manager' );

/**
* Begins execution of the plugin.
*
* Since everything within the plugin is registered via hooks,
* then kicking off the plugin from this point in the file does
* not affect the page life cycle.
*
* @since    1.0.0
*/
function run_gutenberg_block_manager() {

  try {
    $plugin = Factory::init('Manager')->run();
  } catch(\Exception $e) {
    error_log($e->getMessage());
  }

}
run_gutenberg_block_manager();
