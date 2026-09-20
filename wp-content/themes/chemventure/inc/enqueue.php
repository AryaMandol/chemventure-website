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
    wp_script_add_data( 'chemventure-theme', 'strategy', 'defer' );

    wp_localize_script(
        'chemventure-theme',
        'ChemVentureConfig',
        array(
            'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
            'leadAction'       => 'chemventure_submit_lead',
            'leadNonce'        => wp_create_nonce( 'chemventure_submit_lead' ),
            'trackingEnabled'  => chemventure_tracking_enabled(),
            'gtmId'            => chemventure_gtm_id(),
            'consentVersion'   => '2',
            'privacyPolicyUrl' => chemventure_privacy_policy_url(),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'chemventure_enqueue_assets' );
