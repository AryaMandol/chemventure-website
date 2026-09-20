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
 * Render the site logo with a bundled fallback for the initial setup.
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
 * Fallback navigation used until menus are assigned in WordPress Admin.
 *
 * @param object|array $args WordPress menu arguments.
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
