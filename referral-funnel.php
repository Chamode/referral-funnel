<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              https://jwtechlab.com
 * @since             1.0.0
 * @package           Referral_Funnel
 *
 * @wordpress-plugin
 * Plugin Name:       Referral Funnel
 * Plugin URI:        https://jwtechlab.com
 * Description:       Referral Plugin for InnerAwesome. Create and manage all referrals easily.
 * Version:           1.0.0
 * Author:            JW TechLab
 * Author URI:        https://jwtechlab.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       referral-funnel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-referral-funnel-activator.php
 */
function activate_referral_funnel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-referral-funnel-activator.php';
	Referral_Funnel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-referral-funnel-deactivator.php
 */
function deactivate_referral_funnel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-referral-funnel-deactivator.php';
	Referral_Funnel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_referral_funnel' );
register_deactivation_hook( __FILE__, 'deactivate_referral_funnel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-referral-funnel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_referral_funnel() {

	$plugin = new Referral_Funnel();
	$plugin->run();

}
run_referral_funnel();
