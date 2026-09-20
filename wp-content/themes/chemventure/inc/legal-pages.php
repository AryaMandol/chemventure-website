<?php
/**
 * ChemVenture privacy and cookie policies.
 *
 * The public pages use shortcodes so contact details stay synchronized with
 * the Customizer instead of being copied into static page text.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the designated privacy-contact email.
 */
function chemventure_privacy_contact_email() {
    $privacy_email = sanitize_email( chemventure_mod( 'privacy_contact_email', '' ) );
    if ( $privacy_email ) {
        return $privacy_email;
    }

    return sanitize_email( chemventure_mod( 'contact_email', '' ) );
}


/**
 * Locate the Privacy Policy page.
 */
function chemventure_privacy_policy_page() {
    $assigned_id = absint( get_option( 'wp_page_for_privacy_policy', 0 ) );
    if ( $assigned_id ) {
        $page = get_post( $assigned_id );
        if ( $page instanceof WP_Post && 'page' === $page->post_type && 'trash' !== $page->post_status ) {
            return $page;
        }
    }

    $page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
    return $page instanceof WP_Post ? $page : null;
}

/**
 * Locate the cookie-policy page.
 */
function chemventure_cookie_policy_page() {
    $saved_id = absint( get_option( 'chemventure_cookie_policy_page_id', 0 ) );
    if ( $saved_id ) {
        $page = get_post( $saved_id );
        if ( $page instanceof WP_Post && 'page' === $page->post_type && 'trash' !== $page->post_status ) {
            return $page;
        }
    }

    $page = get_page_by_path( 'cookie-policy', OBJECT, 'page' );
    return $page instanceof WP_Post ? $page : null;
}

/**
 * Public cookie-policy URL, only when the page is published.
 */
function chemventure_cookie_policy_url() {
    $page = chemventure_cookie_policy_page();
    if ( ! $page || 'publish' !== $page->post_status ) {
        return '';
    }
    return get_permalink( $page );
}

/**
 * Create policy-page drafts when missing. Existing pages are never overwritten.
 */
function chemventure_ensure_legal_pages() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $privacy_page = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
    if ( ! $privacy_page ) {
        $privacy_id = wp_insert_post(
            array(
                'post_title'     => 'Privacy Policy',
                'post_name'      => 'privacy-policy',
                'post_content'   => '[chemventure_privacy_policy]',
                'post_status'    => 'draft',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            )
        );
        if ( $privacy_id && ! is_wp_error( $privacy_id ) ) {
            $privacy_page = get_post( $privacy_id );
        }
    }

    if ( $privacy_page instanceof WP_Post && ! get_option( 'wp_page_for_privacy_policy' ) ) {
        update_option( 'wp_page_for_privacy_policy', $privacy_page->ID );
    }

    $cookie_page = get_page_by_path( 'cookie-policy', OBJECT, 'page' );
    if ( ! $cookie_page ) {
        $cookie_id = wp_insert_post(
            array(
                'post_title'     => 'Cookie Policy',
                'post_name'      => 'cookie-policy',
                'post_content'   => '[chemventure_cookie_policy]',
                'post_status'    => 'draft',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            )
        );
        if ( $cookie_id && ! is_wp_error( $cookie_id ) ) {
            $cookie_page = get_post( $cookie_id );
        }
    }

    if ( $cookie_page instanceof WP_Post ) {
        update_option( 'chemventure_cookie_policy_page_id', $cookie_page->ID );
    }
}
add_action( 'admin_init', 'chemventure_ensure_legal_pages' );

/**
 * Shared policy heading/contact block.
 */
function chemventure_policy_contact_markup() {
    $email   = chemventure_privacy_contact_email();
    $phone   = chemventure_mod( 'contact_phone', '' );
    $office  = chemventure_mod( 'corporate_office', '' );
    $contact = array();

    if ( $email ) {
        $contact[] = '<a href="mailto:' . esc_attr( antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
    }
    if ( $phone ) {
        $contact[] = '<a href="' . esc_url( chemventure_phone_href( $phone ) ) . '">' . esc_html( $phone ) . '</a>';
    }
    if ( $office ) {
        $contact[] = esc_html( $office );
    }

    if ( ! $contact ) {
        return '<p>For privacy requests, please use the contact details published in the Contact section of this website.</p>';
    }

    return '<p>' . implode( '<br>', $contact ) . '</p>';
}

/**
 * Customized Privacy Policy.
 */
function chemventure_privacy_policy_shortcode() {
    $cookie_url = chemventure_cookie_policy_url();
    ob_start();
    ?>
    <div class="cv-legal-policy">
        <p class="cv-legal-policy__updated"><strong>Last updated:</strong> September 2026</p>
        <p>ChemVenture India Private Limited ("ChemVenture", "we", "us" or "our") operates this website for its Green Paints powder coating business. This Privacy Policy explains how we collect, use, store and share personal data when you browse the website, submit an enquiry, request a quote, contact us or interact with campaign links.</p>

        <div class="cv-legal-policy__summary">
            <strong>In short</strong>
            <p>We use enquiry information to respond to you and manage business follow-up. Optional analytics and campaign-measurement technologies are blocked until you accept them. We do not sell personal data.</p>
        </div>

        <nav class="cv-legal-policy__toc" aria-label="Privacy Policy contents">
            <strong>Contents</strong>
            <a href="#privacy-data">Data we collect</a>
            <a href="#privacy-use">How we use it</a>
            <a href="#privacy-sharing">Sharing</a>
            <a href="#privacy-retention">Retention and security</a>
            <a href="#privacy-rights">Your choices and rights</a>
            <a href="#privacy-contact">Contact</a>
        </nav>

        <section id="privacy-data">
            <h2>1. Personal data we collect</h2>
            <h3>Information you provide</h3>
            <p>When you submit the website enquiry or quote form, we may collect your name, company, phone or WhatsApp number, email address, product interest and the requirement or message you provide. If you contact us by phone, WhatsApp or email, we may also retain the information contained in that communication.</p>

            <h3>Enquiry and campaign context</h3>
            <p>To understand how an enquiry reached us, the site may attach first-party campaign information such as UTM source, medium, campaign, content or term, advertising click identifiers such as gclid or fbclid when present, the landing-page URL and referrer. This information is used with the enquiry for attribution and follow-up.</p>

            <h3>Website and measurement data</h3>
            <p>Necessary technical information may be processed by the website or hosting environment to deliver pages, prevent abuse and maintain security. If you accept optional measurement, Google Tag Manager may load analytics or campaign-measurement services configured by ChemVenture, which can collect device, browser, page-view, interaction and campaign information according to those providers' settings and privacy terms.</p>
        </section>

        <section id="privacy-use">
            <h2>2. How we use personal data</h2>
            <p>We use personal data for the specific business and website purposes for which it is collected, including to:</p>
            <ul>
                <li>respond to product, technical, commercial and quote enquiries;</li>
                <li>identify the relevant Green Paints product or finish for follow-up;</li>
                <li>contact you by phone, WhatsApp or email about your enquiry;</li>
                <li>manage leads and maintain reasonable business records;</li>
                <li>understand which campaigns or website sections generate enquiries;</li>
                <li>operate, secure, troubleshoot and improve the website;</li>
                <li>measure website and campaign performance when you have accepted optional measurement; and</li>
                <li>comply with applicable legal or regulatory requirements.</li>
            </ul>
            <p>Where consent is required for a processing activity, you may withdraw that consent. Withdrawing consent does not affect processing that was lawful before withdrawal or information that must be retained for an applicable legal purpose.</p>
        </section>

        <section id="privacy-sharing">
            <h2>3. When we share information</h2>
            <p>We may share personal data only where reasonably necessary with authorized ChemVenture personnel and service providers that help us operate the website, hosting, email, communications, security, analytics or campaign measurement. Optional analytics and campaign-measurement providers are not loaded until the visitor accepts optional measurement through the website preference banner.</p>
            <p>We may also disclose information when required by applicable law, legal process, regulatory request, or to protect ChemVenture, our customers or others from fraud, abuse, security threats or legal claims.</p>
            <p><strong>We do not sell personal data to advertisers.</strong></p>
        </section>

        <section id="privacy-retention">
            <h2>4. Retention and security</h2>
            <p>We keep enquiry and business-contact information only for as long as reasonably necessary for follow-up, customer or prospect relationship management, business records, dispute handling, security and applicable legal obligations. Records that are no longer reasonably required should be deleted or anonymized as part of periodic business-data review.</p>
            <p>We use reasonable administrative and technical safeguards designed to protect data against unauthorized access, alteration, disclosure or loss. No website or electronic transmission can be guaranteed to be completely secure.</p>
        </section>

        <section>
            <h2>5. Cookies and similar technologies</h2>
            <p>The website uses limited browser storage for site preferences and may use optional analytics or campaign-measurement technologies only after consent. <?php if ( $cookie_url ) : ?><a href="<?php echo esc_url( $cookie_url ); ?>">Read our Cookie Policy</a> for categories and controls.<?php else : ?>A separate Cookie Policy describes the categories and controls available on this website.<?php endif; ?></p>
        </section>

        <section>
            <h2>6. Third-party and cross-border processing</h2>
            <p>Some hosting, email, analytics, communication or campaign-measurement providers may process information using infrastructure located outside your state or country. Where such services are used, processing is subject to the provider's applicable terms, safeguards and applicable law. ChemVenture will configure production services with due regard to any restrictions that apply to transfers of personal data.</p>
        </section>

        <section>
            <h2>7. Children's data</h2>
            <p>This website is intended primarily for business and industrial enquiries and is not directed at children. We do not knowingly seek personal data from children through the enquiry form. If you believe a child has provided personal data to us, contact us so that the situation can be reviewed.</p>
        </section>

        <section id="privacy-rights">
            <h2>8. Your choices and rights</h2>
            <p>Subject to applicable law, you may contact us to request information about personal data associated with your enquiry, ask for correction or erasure where appropriate, withdraw consent where processing relies on consent, or raise a grievance about our handling of personal data. We may need reasonable information to verify the request before acting on it.</p>
            <p>You can change optional measurement choices at any time using <strong>Cookie settings</strong> in the website footer.</p>
        </section>

        <section>
            <h2>9. Changes to this policy</h2>
            <p>We may update this Privacy Policy when our website, vendors, business processes or legal requirements change. The current version and update date will be published on this page.</p>
        </section>

        <section id="privacy-contact">
            <h2>10. Privacy contact</h2>
            <p><strong>ChemVenture India Private Limited</strong></p>
            <?php echo wp_kses_post( chemventure_policy_contact_markup() ); ?>
        </section>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'chemventure_privacy_policy', 'chemventure_privacy_policy_shortcode' );

/**
 * Customized Cookie Policy.
 */
function chemventure_cookie_policy_shortcode() {
    $privacy_url = chemventure_privacy_policy_url();
    ob_start();
    ?>
    <div class="cv-legal-policy">
        <p class="cv-legal-policy__updated"><strong>Last updated:</strong> September 2026</p>
        <p>This Cookie Policy explains how the Green Paints website operated by ChemVenture India Private Limited uses cookies, local storage, session storage and similar browser technologies.</p>

        <div class="cv-legal-policy__summary">
            <strong>Our approach</strong>
            <p>Necessary storage can operate without optional consent. Analytics and campaign-measurement technologies are blocked until you choose <strong>Accept optional</strong>.</p>
        </div>

        <section>
            <h2>1. What these technologies are</h2>
            <p>Cookies are small data files that a website or third-party service may place in your browser. Local storage and session storage are browser features that can remember a preference or limited session information without necessarily using a traditional cookie.</p>
        </section>

        <section>
            <h2>2. Technologies used by this website</h2>
            <div class="cv-legal-table-wrap">
                <table class="cv-legal-table">
                    <thead><tr><th>Category</th><th>Purpose</th><th>Examples</th><th>When used</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Necessary</strong></td><td>Remember privacy choices and support core website/security functions.</td><td><code>chemventure_cookie_consent</code> in browser local storage; WordPress/security cookies where technically required.</td><td>As needed for the site to function.</td></tr>
                        <tr><td><strong>Enquiry attribution</strong></td><td>Keep limited campaign context during the current browsing session so a submitted enquiry can be associated with the page or campaign that generated it.</td><td><code>chemventure_campaign_attribution</code> in session storage; UTM parameters; landing URL; referrer; gclid/fbclid when present.</td><td>During the current session and when an enquiry is submitted.</td></tr>
                        <tr><td><strong>Optional analytics & campaign measurement</strong></td><td>Measure visits, interactions, conversions and advertising/campaign performance.</td><td>Tags configured through Google Tag Manager, such as Google Analytics 4 or Meta Pixel. These providers may set their own cookies or identifiers.</td><td>Only after you choose <strong>Accept optional</strong>.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>3. Google Tag Manager, analytics and advertising measurement</h2>
            <p>Google Tag Manager is used as the site's container for optional measurement tags. The container itself is blocked until optional measurement is accepted. Depending on the production configuration, accepted tags may include Google Analytics 4 and Meta campaign-measurement technologies. The exact cookies or identifiers created by those providers can vary with browser settings, consent mode and provider configuration.</p>
            <p>Rejecting optional measurement does not stop the core website or enquiry form from working.</p>
        </section>

        <section>
            <h2>4. Your choices</h2>
            <p>When optional measurement is enabled for the website, the consent banner offers two choices:</p>
            <ul>
                <li><strong>Accept optional</strong> - optional analytics and campaign-measurement tags may load.</li>
                <li><strong>Reject optional</strong> - optional measurement tags remain blocked.</li>
            </ul>
            <p>Your choice is stored in your browser. You can reopen the banner at any time through <strong>Cookie settings</strong> in the footer. You can also clear website data through your browser settings.</p>
        </section>

        <section>
            <h2>5. How long browser storage remains</h2>
            <p>The consent choice remains in browser local storage until it is replaced, cleared, or the consent version changes. Session attribution storage normally ends with the browser session. Third-party analytics or advertising cookies, when accepted and configured, follow the retention settings of those services and the browser.</p>
        </section>

        <section>
            <h2>6. Changes to this Cookie Policy</h2>
            <p>We may update this policy when tracking tools, providers, retention settings or legal requirements change. The current version will be published on this page.</p>
        </section>

        <section>
            <h2>7. Contact and further information</h2>
            <?php if ( $privacy_url ) : ?><p>For information about how ChemVenture handles personal data, read the <a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a>.</p><?php endif; ?>
            <?php echo wp_kses_post( chemventure_policy_contact_markup() ); ?>
        </section>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'chemventure_cookie_policy', 'chemventure_cookie_policy_shortcode' );
