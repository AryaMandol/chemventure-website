<?php
/**
 * Theme helper functions.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render the site logo with a bundled fallback.
 */
function chemventure_site_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
        return;
    }

    $logo_uri = CHEMVENTURE_THEME_URI . '/assets/images/green-paints-logo.png';
    ?>
    <a class="cv-brand__fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo esc_url( $logo_uri ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ?: 'Green Paints' ); ?>">
    </a>
    <?php
}

/**
 * Fetch a theme modification with a default.
 */
function chemventure_mod( $setting, $default = '' ) {
    $value = get_theme_mod( $setting, $default );
    return is_string( $value ) ? trim( $value ) : $value;
}

/**
 * Resolve a homepage image from Customizer or a supplied fallback URL.
 */
function chemventure_home_image( $setting, $fallback ) {
    $value = chemventure_mod( $setting, '' );
    return $value ? $value : $fallback;
}

/**
 * Render a resource item as a real link when configured or a prototype button otherwise.
 */
function chemventure_resource_item( $setting, $label ) {
    $url = chemventure_mod( $setting, '' );

    if ( $url ) {
        ?>
        <a class="resource-item" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" data-resource-link data-resource-name="<?php echo esc_attr( $label ); ?>">
            <span><?php echo esc_html( $label ); ?></span><small>PDF</small>
        </a>
        <?php
        return;
    }
    ?>
    <button class="resource-item" type="button" data-resource>
        <span><?php echo esc_html( $label ); ?></span><small>PDF</small>
    </button>
    <?php
}

/**
 * Build a tel link from an arbitrary phone string.
 */
function chemventure_phone_href( $phone ) {
    return 'tel:' . preg_replace( '/[^0-9+]/', '', (string) $phone );
}

/**
 * Return the active WhatsApp number.
 *
 * The staging default is intentionally centralized here so it can be replaced
 * from the WordPress Customizer without changing templates.
 */
function chemventure_whatsapp_number() {
    $number = chemventure_mod( 'contact_whatsapp', '9903645467' );
    return $number ? $number : '9903645467';
}

/**
 * Normalize an Indian WhatsApp number for wa.me links.
 */
function chemventure_whatsapp_digits( $number = '' ) {
    $digits = preg_replace( '/\D+/', '', (string) ( $number ?: chemventure_whatsapp_number() ) );

    if ( 10 === strlen( $digits ) ) {
        $digits = '91' . $digits;
    }

    return $digits;
}

/**
 * Build a WhatsApp URL with an optional pre-filled message.
 */
function chemventure_whatsapp_href( $number = '', $message = '' ) {
    $digits = chemventure_whatsapp_digits( $number );
    if ( ! $digits ) {
        return home_url( '/#enquiry' );
    }

    $url = 'https://wa.me/' . $digits;
    if ( $message ) {
        $url .= '?text=' . rawurlencode( $message );
    }

    return $url;
}

/**
 * Resolve the public Privacy Policy URL even when WordPress Privacy settings
 * have not yet been assigned, provided a published privacy-policy page exists.
 */
function chemventure_privacy_policy_url() {
    $url = get_privacy_policy_url();
    if ( $url ) {
        return $url;
    }

    $page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
    if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
        return get_permalink( $page );
    }

    return '';
}

/**
 * Fallback navigation used until menus are assigned in WordPress Admin.
 */
function chemventure_primary_menu_fallback( $args = array() ) {
    $menu_class = 'cv-nav__list';

    if ( is_object( $args ) && ! empty( $args->menu_class ) ) {
        $menu_class = $args->menu_class;
    } elseif ( is_array( $args ) && ! empty( $args['menu_class'] ) ) {
        $menu_class = $args['menu_class'];
    }

    ?>
    <ul class="<?php echo esc_attr( $menu_class ); ?>">
        <li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>">About</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#products' ) ); ?>">Products</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#finishes' ) ); ?>">Colours &amp; Finishes</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#quality' ) ); ?>">Quality</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#resources' ) ); ?>">Resources</a></li>
    </ul>
    <?php
}
