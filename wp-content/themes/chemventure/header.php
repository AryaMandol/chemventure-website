<?php
/**
 * Site header.
 *
 * @package ChemVenture
 */

$phone    = chemventure_mod( 'contact_phone', '' );
$whatsapp = chemventure_whatsapp_number();
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.remove('no-js');document.documentElement.classList.add('js');</script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="cv-skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'chemventure' ); ?></a>

<div class="cv-utility-bar">
    <div class="cv-container cv-utility-bar__inner">
        <p><strong>Green Paints</strong><span>A powder coating brand of ChemVenture India Private Limited</span></p>
        <div class="cv-utility-links">
            <?php if ( $phone ) : ?>
                <a href="<?php echo esc_url( chemventure_phone_href( $phone ) ); ?>" data-cv-event="phone_click" data-cv-location="utility"><?php echo esc_html( $phone ); ?></a>
            <?php endif; ?>
            <?php if ( $whatsapp ) : ?>
                <a href="<?php echo esc_url( chemventure_whatsapp_href( $whatsapp, 'Hi, I would like to know more about Green Paints powder coating solutions.' ) ); ?>" target="_blank" data-cv-event="whatsapp_click" data-cv-location="utility" rel="noopener">WhatsApp</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<header class="cv-site-header" data-cv-header>
    <div class="cv-container cv-header-row">
        <div class="cv-brand">
            <?php chemventure_site_logo(); ?>
        </div>

        <nav class="cv-nav cv-nav--desktop" aria-label="<?php esc_attr_e( 'Primary navigation', 'chemventure' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'cv-nav__list',
                    'fallback_cb'    => 'chemventure_primary_menu_fallback',
                    'depth'          => 1,
                )
            );
            ?>
        </nav>

        <div class="cv-header-actions">
            <a class="cv-header-contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Contact</a>
            <a class="cv-button cv-button--whatsapp cv-button--small cv-header-whatsapp" href="<?php echo esc_url( chemventure_whatsapp_href( '', 'Hi, I would like to discuss a Green Paints powder coating requirement.' ) ); ?>" target="_blank" rel="noopener" data-cv-event="whatsapp_click" data-cv-location="header">WhatsApp</a>
            <a class="cv-button cv-button--primary cv-button--small" href="<?php echo esc_url( home_url( '/#enquiry' ) ); ?>">Get a Quote</a>
            <button class="cv-menu-toggle" type="button" aria-expanded="false" aria-controls="cv-mobile-menu" data-cv-menu-toggle>
                <span></span><span></span><span></span>
                <span class="screen-reader-text"><?php esc_html_e( 'Toggle menu', 'chemventure' ); ?></span>
            </button>
        </div>
    </div>

    <div class="cv-mobile-menu" id="cv-mobile-menu" data-cv-mobile-menu hidden>
        <div class="cv-container">
            <nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'chemventure' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'cv-mobile-menu__list',
                        'fallback_cb'    => 'chemventure_primary_menu_fallback',
                        'depth'          => 1,
                    )
                );
                ?>
            </nav>
            <div class="cv-mobile-menu__actions">
                <a class="cv-button cv-button--primary" href="<?php echo esc_url( home_url( '/#enquiry' ) ); ?>">Get a Quote</a>
                <a class="cv-button cv-button--whatsapp" href="<?php echo esc_url( chemventure_whatsapp_href( '', 'Hi, I would like to discuss a Green Paints powder coating requirement.' ) ); ?>" target="_blank" rel="noopener" data-cv-event="whatsapp_click" data-cv-location="mobile_menu">WhatsApp</a>
            </div>
        </div>
    </div>
</header>
