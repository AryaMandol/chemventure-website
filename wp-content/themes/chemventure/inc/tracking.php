<?php
/**
 * Tracking configuration helpers.
 *
 * Google Tag Manager is not injected by PHP. CV-05 loads it client-side only
 * after the visitor accepts optional analytics cookies.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return a validated GTM container ID or an empty string.
 */
function chemventure_gtm_id() {
    $id = strtoupper( chemventure_mod( 'gtm_container_id', '' ) );
    return preg_match( '/^GTM-[A-Z0-9]+$/', $id ) ? $id : '';
}

/**
 * Determine whether analytics tracking is configured by an administrator.
 *
 * Consent is evaluated in the browser before GTM is loaded.
 */
function chemventure_tracking_enabled() {
    return (bool) get_theme_mod( 'tracking_enabled', false ) && (bool) chemventure_gtm_id();
}
