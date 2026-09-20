<?php
/**
 * Front-end hardening and environment safeguards.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add conservative security headers that are safe for the current theme.
 */
function chemventure_security_headers() {
    if ( headers_sent() ) {
        return;
    }

    header( 'X-Content-Type-Options: nosniff' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
}
add_action( 'send_headers', 'chemventure_security_headers' );

/**
 * Keep local/development sites out of search indexes even if Reading settings drift.
 */
function chemventure_environment_robots( $robots ) {
    $host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) : '';
    $non_production = 'production' !== wp_get_environment_type();
    $local_domain   = str_ends_with( $host, '.local' ) || 'localhost' === $host || str_starts_with( $host, 'localhost:' );

    if ( $non_production || $local_domain ) {
        $robots['noindex']   = true;
        $robots['nofollow']  = true;
        $robots['noarchive'] = true;
    }

    return $robots;
}
add_filter( 'wp_robots', 'chemventure_environment_robots' );

/**
 * Remove generator metadata from the public head.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Add resource hints for temporary stock imagery and configured GTM.
 */
function chemventure_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type && is_front_page() ) {
        $home_image_settings = array( 'hero_image', 'about_image', 'quality_image', 'operations_image' );
        foreach ( $home_image_settings as $setting ) {
            if ( ! chemventure_mod( $setting, '' ) ) {
                $urls[] = array(
                    'href'        => 'https://images.pexels.com',
                    'crossorigin' => 'anonymous',
                );
                break;
            }
        }
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'chemventure_resource_hints', 10, 2 );
