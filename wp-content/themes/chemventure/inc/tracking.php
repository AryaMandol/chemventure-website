<?php
/**
 * Google Tag Manager integration.
 *
 * The theme only loads GTM when both a valid container ID and the explicit
 * tracking-enabled setting are present. GA4 and Meta Pixel should be
 * configured inside GTM to avoid duplicate tracking code in the theme.
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
 * Determine whether the GTM container is allowed to load.
 */
function chemventure_tracking_enabled() {
    return (bool) get_theme_mod( 'tracking_enabled', false ) && (bool) chemventure_gtm_id();
}

/**
 * GTM head snippet.
 */
function chemventure_gtm_head() {
    if ( ! chemventure_tracking_enabled() ) {
        return;
    }

    $id = chemventure_gtm_id();
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?php echo esc_js( $id ); ?>');</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action( 'wp_head', 'chemventure_gtm_head', 1 );

/**
 * GTM noscript iframe.
 */
function chemventure_gtm_body() {
    if ( ! chemventure_tracking_enabled() ) {
        return;
    }

    $id = chemventure_gtm_id();
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $id ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action( 'wp_body_open', 'chemventure_gtm_body', 1 );
