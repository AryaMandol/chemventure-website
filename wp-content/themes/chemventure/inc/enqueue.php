<?php
/**
 * Front-end assets.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function chemventure_enqueue_assets() {
    wp_enqueue_style(
        'chemventure-style',
        get_stylesheet_uri(),
        array(),
        CHEMVENTURE_THEME_VERSION
    );

    wp_enqueue_style(
        'chemventure-theme',
        CHEMVENTURE_THEME_URI . '/assets/css/theme.css',
        array( 'chemventure-style' ),
        CHEMVENTURE_THEME_VERSION
    );

    if ( is_front_page() ) {
        wp_enqueue_style(
            'chemventure-home',
            CHEMVENTURE_THEME_URI . '/assets/css/home.css',
            array( 'chemventure-theme' ),
            CHEMVENTURE_THEME_VERSION
        );
    }

    wp_enqueue_script(
        'chemventure-theme',
        CHEMVENTURE_THEME_URI . '/assets/js/theme.js',
        array(),
        CHEMVENTURE_THEME_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'chemventure_enqueue_assets' );
