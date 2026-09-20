<?php
/**
 * Lightweight front-page SEO output.
 *
 * The theme steps aside when a common dedicated SEO plugin is active.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Detect common SEO plugins so the theme does not duplicate their metadata.
 */
function chemventure_seo_plugin_active() {
    return defined( 'WPSEO_VERSION' )
        || defined( 'RANK_MATH_VERSION' )
        || defined( 'AIOSEO_VERSION' )
        || class_exists( 'All_in_One_SEO_Pack' );
}

/**
 * Resolve the homepage social image.
 */
function chemventure_social_image_url() {
    $custom = chemventure_mod( 'social_share_image', '' );
    if ( $custom ) {
        return $custom;
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $logo = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $logo ) {
            return $logo;
        }
    }

    return CHEMVENTURE_THEME_URI . '/assets/images/green-paints-logo.png';
}

/**
 * Remove the core front-page canonical when the theme owns front-page SEO.
 */
function chemventure_prepare_frontpage_seo() {
    if ( is_front_page() && ! chemventure_seo_plugin_active() ) {
        remove_action( 'wp_head', 'rel_canonical' );
    }
}
add_action( 'template_redirect', 'chemventure_prepare_frontpage_seo' );

/**
 * Output front-page description, canonical and social metadata.
 */
function chemventure_output_frontpage_meta() {
    if ( ! is_front_page() || chemventure_seo_plugin_active() ) {
        return;
    }

    $title       = wp_get_document_title();
    $description = chemventure_mod(
        'homepage_meta_description',
        'Green Paints by ChemVenture India offers industrial powder coating solutions including epoxy, epoxy polyester hybrid and pure polyester systems.'
    );
    $canonical   = home_url( '/' );
    $image       = chemventure_social_image_url();
    ?>
    <meta name="description" content="<?php echo esc_attr( $description ); ?>">
    <link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
    <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $canonical ); ?>">
    <?php if ( $image ) : ?>
        <meta property="og:image" content="<?php echo esc_url( $image ); ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
    <?php if ( $image ) : ?>
        <meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
    <?php endif; ?>
    <?php
}
add_action( 'wp_head', 'chemventure_output_frontpage_meta', 2 );

/**
 * Output Organization + WebSite schema on the homepage.
 */
function chemventure_output_schema() {
    if ( ! is_front_page() || chemventure_seo_plugin_active() ) {
        return;
    }

    $organization_name = chemventure_mod( 'organization_name', 'ChemVenture India Private Limited' );
    $phone             = chemventure_mod( 'contact_phone', '' );
    $email             = chemventure_mod( 'contact_email', '' );
    $logo              = chemventure_social_image_url();

    $organization = array(
        '@type' => 'Organization',
        '@id'   => home_url( '/#organization' ),
        'name'  => $organization_name,
        'url'   => home_url( '/' ),
    );

    if ( $logo ) {
        $organization['logo'] = array(
            '@type' => 'ImageObject',
            'url'   => $logo,
        );
    }

    if ( $phone || $email ) {
        $contact_point = array(
            '@type'       => 'ContactPoint',
            'contactType' => 'sales',
        );
        if ( $phone ) {
            $contact_point['telephone'] = $phone;
        }
        if ( $email ) {
            $contact_point['email'] = $email;
        }
        $organization['contactPoint'] = $contact_point;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@graph'   => array(
            $organization,
            array(
                '@type'     => 'WebSite',
                '@id'       => home_url( '/#website' ),
                'url'       => home_url( '/' ),
                'name'      => get_bloginfo( 'name' ),
                'publisher' => array( '@id' => home_url( '/#organization' ) ),
            ),
        ),
    );
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); ?></script>
    <?php
}
add_action( 'wp_head', 'chemventure_output_schema', 20 );
