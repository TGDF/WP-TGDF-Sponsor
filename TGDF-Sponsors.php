<?php
/**
 * TGDF Sponsors
 *
  *
 * @link              http://tgdf.tw
 * @since             1.0.0
 * @package           TGDF_Sponsors
 *
 * @wordpress-plugin
 * Plugin Name:       TGDF Sponsors
 * Description:       The Sponsor Maanger for TGDF
 * Version:           1.0.0
 * Author:            Aotokitsuruya
 * Author URI:        https://frost.tw/
 * License:           Apache 2.0
 * License URI:       https://www.apache.org/licenses/LICENSE-2.0
 * Text Domain:       tgdf-sponsors
 * Domain Path:       /languages
 */

if(!defined( 'ABSPATH' )) {
    die;
}

require plugin_dir_path( __FILE__ ) . 'includes/class-tgdf-sponsor.php';

function init_TGDF_Sponsor() {
    $plugin = new TGDF_Sponsor();
    $plugin->init();
}

init_TGDF_Sponsor();
