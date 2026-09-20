<?php
/**
 * Privacy and analytics-consent UI.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render analytics consent only when GTM is configured and enabled.
 */
function chemventure_cookie_consent_ui() {
    if ( ! chemventure_tracking_enabled() ) {
        return;
    }

    $privacy_url = get_privacy_policy_url();
    ?>
    <div class="cv-cookie-consent" data-cookie-consent hidden>
        <div class="cv-cookie-consent__panel" role="dialog" aria-labelledby="cv-cookie-title" aria-describedby="cv-cookie-copy" tabindex="-1" data-cookie-panel>
            <div class="cv-cookie-consent__copy">
                <strong id="cv-cookie-title">Cookie preferences</strong>
                <p id="cv-cookie-copy">We use optional analytics cookies to understand website usage and measure campaign performance. Necessary site functions continue to work if you decline analytics.</p>
                <?php if ( $privacy_url ) : ?>
                    <a href="<?php echo esc_url( $privacy_url ); ?>">Read our Privacy Policy</a>
                <?php endif; ?>
            </div>
            <div class="cv-cookie-consent__actions">
                <button class="cv-button cv-button--primary" type="button" data-cookie-accept>Accept analytics</button>
                <button class="cv-button cv-button--secondary" type="button" data-cookie-reject>Necessary only</button>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'chemventure_cookie_consent_ui', 30 );
