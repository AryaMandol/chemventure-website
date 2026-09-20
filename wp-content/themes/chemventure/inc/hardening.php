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


/**
 * Additional staging/production-safe WordPress hardening for this brochure site.
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'pings_open', '__return_false', 20, 2 );

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

/**
 * Do not expose public WordPress user-directory REST endpoints to anonymous visitors.
 */
function chemventure_limit_public_user_rest_endpoints( $endpoints ) {
    if ( is_user_logged_in() ) {
        return $endpoints;
    }

    foreach ( array_keys( $endpoints ) as $route ) {
        if ( str_starts_with( $route, '/wp/v2/users' ) ) {
            unset( $endpoints[ $route ] );
        }
    }

    return $endpoints;
}
add_filter( 'rest_endpoints', 'chemventure_limit_public_user_rest_endpoints' );

/**
 * Avoid revealing whether a username exists on failed login attempts.
 */
function chemventure_generic_login_error() {
    return __( 'Login failed. Please check your credentials and try again.', 'chemventure' );
}
add_filter( 'login_errors', 'chemventure_generic_login_error' );

/**
 * Remove legacy emoji assets on the public site. Modern browsers render emoji natively.
 */
function chemventure_disable_frontend_emoji_assets() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'chemventure_disable_frontend_emoji_assets' );
