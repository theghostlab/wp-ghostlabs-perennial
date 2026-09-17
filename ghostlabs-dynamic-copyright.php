<?php


/**
 * GhostLabs: Dynamic Copyright
 *
 * Keeps a copyright notice current — the year is resolved when the page is
 * served, in the site's timezone, and is never written into post content.
 *
 * @package       GhostLabsDynamicCopyright
 * @author        GhostLabs
 * @license       GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       GhostLabs: Dynamic Copyright
 * Plugin URI:        https://theghostlab.io/docs/dynamic-copyright
 * Description:       Keeps your copyright notice current by dynamically updating the year and site name.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            GhostLabs
 * Author URI:        https://theghostlab.io
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ghostlabs-dynamic-copyright
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GHOSTLABS_DYNAMIC_COPYRIGHT_EDITION', 'free' );
define( 'GHOSTLABS_DYNAMIC_COPYRIGHT_VERSION', '1.0.0' );
define( 'GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_SLUG', plugin_basename( __FILE__ ) );

require_once GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_PATH . 'bootstrap.php';
