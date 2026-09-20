<?php
/**
 * Privacy and optional measurement-consent UI.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render the consent banner only when optional tracking is configured.
 *
 * Necessary site functions do not require consent. Google Tag Manager, GA4,
 * Meta Pixel or any other optional measurement tags must remain blocked until
 * the visitor accepts optional measurement.
 */
function chemventure_cookie_consent_ui() {
    if ( ! chemventure_tracking_enabled() ) {
        return;
    }

    $privacy_url = chemventure_privacy_policy_url();
    $cookie_url  = function_exists( 'chemventure_cookie_policy_url' ) ? chemventure_cookie_policy_url() : '';
    ?>
    <div class="cv-cookie-consent" data-cookie-consent hidden>
        <div class="cv-cookie-consent__panel" role="dialog" aria-modal="true" aria-labelledby="cv-cookie-title" aria-describedby="cv-cookie-copy" tabindex="-1" data-cookie-panel>
            <div class="cv-cookie-consent__copy">
                <strong id="cv-cookie-title">Your privacy choices</strong>
                <p id="cv-cookie-copy">We use necessary storage to keep the website working. With your permission, we also use optional analytics and campaign-measurement technologies to understand visits and improve our marketing. You can accept or reject optional measurement and change your choice later.</p>
                <div class="cv-cookie-consent__links">
                    <?php if ( $privacy_url ) : ?>
                        <a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a>
                    <?php endif; ?>
                    <?php if ( $cookie_url ) : ?>
                        <a href="<?php echo esc_url( $cookie_url ); ?>">Cookie Policy</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="cv-cookie-consent__actions">
                <button class="cv-button cv-button--primary" type="button" data-cookie-accept>Accept optional</button>
                <button class="cv-button cv-button--secondary" type="button" data-cookie-reject>Reject optional</button>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'chemventure_cookie_consent_ui', 30 );
