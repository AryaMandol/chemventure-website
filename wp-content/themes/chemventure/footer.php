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
            <p class="cv-footer-cta__eyebrow">Need help with a coating requirement?</p>
            <h3>Talk to the Green Paints team.</h3>
            <p class="cv-footer-cta__copy">Share your product, finish or application requirement and choose the channel that suits you.</p>
            <div class="cv-footer-cta__actions">
                <a class="cv-button cv-button--outline" href="<?php echo esc_url( home_url( '/#enquiry' ) ); ?>">Get a Quote</a>
                <a class="cv-button cv-button--whatsapp" href="<?php echo esc_url( chemventure_whatsapp_href( '', 'Hi, I would like to discuss a powder coating requirement with Green Paints.' ) ); ?>" target="_blank" rel="noopener" data-cv-event="whatsapp_click" data-cv-location="footer"><?php chemventure_whatsapp_icon(); ?><span>WhatsApp</span></a>
            </div>
        </div>
    </div>

    <div class="cv-container cv-footer-bottom">
        <p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> ChemVenture India Private Limited. All rights reserved.</p>
        <div class="cv-footer-legal">
            <?php if ( chemventure_privacy_policy_url() ) : ?>
                <a href="<?php echo esc_url( chemventure_privacy_policy_url() ); ?>">Privacy Policy</a>
            <?php endif; ?>
            <?php if ( function_exists( 'chemventure_cookie_policy_url' ) && chemventure_cookie_policy_url() ) : ?>
                <a href="<?php echo esc_url( chemventure_cookie_policy_url() ); ?>">Cookie Policy</a>
            <?php endif; ?>
            <?php if ( chemventure_tracking_enabled() ) : ?>
                <button type="button" data-cookie-settings>Cookie settings</button>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
