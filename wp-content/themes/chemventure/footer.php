<?php
/**
 * Site footer.
 *
 * @package ChemVenture
 */
?>
<footer class="cv-site-footer">
    <div class="cv-container cv-footer-grid">
        <div class="cv-footer-brand">
            <?php chemventure_site_logo(); ?>
            <p>A powder coating brand of ChemVenture India Private Limited.</p>
        </div>

        <nav class="cv-footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'chemventure' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'cv-footer-nav__list',
                    'fallback_cb'    => 'chemventure_primary_menu_fallback',
                    'depth'          => 1,
                )
            );
            ?>
        </nav>

        <div class="cv-footer-cta">
            <p>Have a coating requirement?</p>
            <a class="cv-button cv-button--outline" href="<?php echo esc_url( home_url( '/#enquiry' ) ); ?>">Get a Quote</a>
        </div>
    </div>

    <div class="cv-container cv-footer-bottom">
        <p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> ChemVenture India Private Limited. All rights reserved.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
