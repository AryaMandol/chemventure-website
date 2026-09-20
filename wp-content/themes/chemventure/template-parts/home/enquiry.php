<?php
$phone    = chemventure_mod( 'contact_phone', '' );
$whatsapp = chemventure_mod( 'contact_whatsapp', '' );
$email    = chemventure_mod( 'contact_email', '' );
$office   = chemventure_mod( 'corporate_office', '' );
$factory  = chemventure_mod( 'factory_address', '' );
?>
<section class="home-section enquiry-section" id="enquiry" data-section="enquiry">
    <div class="cv-container enquiry-grid">
        <div class="enquiry-copy" data-reveal>
            <p class="home-eyebrow home-eyebrow-dark">Get in touch</p>
            <h2>Tell us about your coating requirement.</h2>
            <p>Share the product, finish, application or quantity you are evaluating. The ChemVenture team can follow up with the relevant information.</p>

            <div class="contact-placeholder" id="contact">
                <h3>ChemVenture India Private Limited</h3>
                <?php if ( $phone || $whatsapp || $email || $office || $factory ) : ?>
                    <div class="contact-details">
                        <?php if ( $phone ) : ?><p><strong>Phone:</strong> <a href="<?php echo esc_url( chemventure_phone_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p><?php endif; ?>
                        <?php if ( $whatsapp ) : ?><p><strong>WhatsApp:</strong> <a href="<?php echo esc_url( chemventure_whatsapp_href( $whatsapp ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $whatsapp ); ?></a></p><?php endif; ?>
                        <?php if ( $email ) : ?><p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></p><?php endif; ?>
                        <?php if ( $office ) : ?><p><strong>Office:</strong> <?php echo esc_html( $office ); ?></p><?php endif; ?>
                        <?php if ( $factory ) : ?><p><strong>Factory:</strong> <?php echo esc_html( $factory ); ?></p><?php endif; ?>
                    </div>
                <?php else : ?>
                    <p>Phone, WhatsApp, email and final office/factory details can be added from Appearance → Customize → ChemVenture Homepage.</p>
                <?php endif; ?>
            </div>

            <div class="enquiry-support" aria-label="Support areas">
                <strong>We can help with</strong>
                <ul><li>Product selection based on use case</li><li>Finish and surface discussion</li><li>Application and process guidance</li><li>Commercial follow-up for quotes</li></ul>
            </div>
        </div>

        <form class="enquiry-form" data-demo-form novalidate>
            <div class="form-title"><strong>Request a quote</strong><span>Fields marked * are required</span></div>
            <div class="form-row two-col">
                <label><span>Name *</span><input type="text" name="name" autocomplete="name" required></label>
                <label><span>Company</span><input type="text" name="company" autocomplete="organization"></label>
            </div>
            <div class="form-row two-col">
                <label><span>Phone / WhatsApp *</span><input type="tel" name="phone" autocomplete="tel" required></label>
                <label><span>Email</span><input type="email" name="email" autocomplete="email"></label>
            </div>
            <label><span>Product interest</span>
                <select name="product" data-product-select>
                    <option value="">Select a product</option>
                    <option>Pure Epoxy</option>
                    <option>Epoxy Polyester Hybrid</option>
                    <option>Pure Polyester</option>
                    <option>Not sure yet</option>
                </select>
            </label>
            <label><span>Requirement</span><textarea name="requirement" rows="5" placeholder="Tell us about the substrate, finish, quantity or application."></textarea></label>
            <button class="cv-button cv-button--primary cv-button--large" type="submit">Get a Quote</button>
            <p class="form-status" aria-live="polite" data-form-status></p>
        </form>
    </div>
</section>
