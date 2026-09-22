<?php


/**
 * Perennial
 *
 * Keeps a copyright notice current — the year is resolved when the page is
 * served, in the site's timezone, and is never written into post content.
 *
 * @package       GhostLabsPerennial
 * @author        GhostLabs
 * @license       GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Perennial
 * Plugin URI:        https://theghostlab.io/docs/perennial
 * Description:       Keeps your copyright notice current by dynamically updating the year and site name.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            GhostLabs
 * Author URI:        https://theghostlab.io
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ghostlabs-perennial
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GHOSTLABS_PERENNIAL_EDITION', 'free' );
define( 'GHOSTLABS_PERENNIAL_VERSION', '1.0.0' );
define( 'GHOSTLABS_PERENNIAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'GHOSTLABS_PERENNIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GHOSTLABS_PERENNIAL_PLUGIN_SLUG', plugin_basename( __FILE__ ) );

require_once GHOSTLABS_PERENNIAL_PLUGIN_PATH . 'bootstrap.php';
