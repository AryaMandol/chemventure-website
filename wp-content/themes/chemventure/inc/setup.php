<?php
/**
 * Theme setup.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function chemventure_theme_setup() {
    load_theme_textdomain( 'chemventure', CHEMVENTURE_THEME_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    add_theme_support(
        'custom-logo',
        array(
            'height'               => 120,
            'width'                => 420,
            'flex-height'          => true,
            'flex-width'           => true,
            'unlink-homepage-logo' => false,
        )
    );

    register_nav_menus(
        array(
            'primary' => __( 'Primary Navigation', 'chemventure' ),
            'footer'  => __( 'Footer Navigation', 'chemventure' ),
        )
    );

    add_image_size( 'chemventure-hero', 1920, 1080, true );
    add_image_size( 'chemventure-section', 1200, 900, true );

    add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', 'chemventure_theme_setup' );
