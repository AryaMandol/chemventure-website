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
 * Render the WhatsApp brand icon inline without an external icon library.
 */
function chemventure_whatsapp_icon( $class = '' ) {
    $classes = trim( 'cv-whatsapp-icon ' . sanitize_html_class( $class ) );
    ?>
    <svg class="<?php echo esc_attr( $classes ); ?>" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
        <path fill="currentColor" d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93a7.898 7.898 0 0 0-2.327-5.607ZM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.25a6.565 6.565 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.591-6.592 6.591Zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.066-.315-.099-.445.099-.133.197-.513.646-.627.775-.116.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.984-.59-.525-.987-1.174-1.104-1.371-.116-.198-.012-.304.088-.4.09-.09.198-.232.297-.35.1-.116.133-.198.198-.33.066-.133.034-.248-.016-.347-.05-.1-.445-1.076-.61-1.47-.16-.389-.323-.336-.445-.341-.116-.008-.248-.008-.38-.008a.729.729 0 0 0-.529.248c-.182.198-.692.678-.692 1.654 0 .977.713 1.916.81 2.049.099.132 1.404 2.141 3.4 3.003.476.205.847.328 1.135.42.477.15.91.129 1.254.078.383-.058 1.171-.48 1.338-.943.164-.463.164-.86.116-.943-.05-.083-.182-.132-.38-.23Z"/>
    </svg>
    <?php
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
