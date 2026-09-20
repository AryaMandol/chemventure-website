<?php
/**
 * ChemVenture Green Paints theme bootstrap.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CHEMVENTURE_THEME_VERSION', '0.2.0' );
define( 'CHEMVENTURE_THEME_DIR', get_template_directory() );
define( 'CHEMVENTURE_THEME_URI', get_template_directory_uri() );

require_once CHEMVENTURE_THEME_DIR . '/inc/setup.php';
require_once CHEMVENTURE_THEME_DIR . '/inc/enqueue.php';
require_once CHEMVENTURE_THEME_DIR . '/inc/helpers.php';
