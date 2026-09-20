<?php
$hero_image = chemventure_home_image(
    'hero_image',
    'https://images.pexels.com/photos/36184235/pexels-photo-36184235.jpeg?auto=compress&cs=tinysrgb&w=1800'
);
$fallback = CHEMVENTURE_THEME_URI . '/assets/images/powder-spray-yellow.png';
?>
<section class="hero" id="top" data-section="top">
    <div class="hero-media" aria-hidden="true">
        <img src="<?php echo esc_url( $hero_image ); ?>" data-fallback="<?php echo esc_url( $fallback ); ?>" alt="" loading="eager" fetchpriority="high" decoding="async">
    </div>
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="cv-container hero-content">
        <div class="hero-copy" data-reveal>
            <p class="home-eyebrow"><?php echo esc_html( chemventure_mod( 'hero_eyebrow', 'Green Paints by ChemVenture India' ) ); ?></p>
            <h1><?php echo esc_html( chemventure_mod( 'hero_title', 'Industrial powder coatings built for reliable performance.' ) ); ?></h1>
            <p class="hero-lead"><?php echo esc_html( chemventure_mod( 'hero_lead', 'Epoxy, epoxy polyester hybrid and pure polyester powder coating solutions for consistent finish, protection and dependable application.' ) ); ?></p>
            <div class="hero-actions">
                <a class="cv-button cv-button--primary cv-button--large" href="#enquiry">Get a Quote</a>
                <a class="cv-button cv-button--whatsapp cv-button--large" href="<?php echo esc_url( chemventure_whatsapp_href( '', 'Hi, I am interested in Green Paints powder coating solutions. Please help me with my requirement.' ) ); ?>" target="_blank" rel="noopener" data-cv-event="whatsapp_click" data-cv-location="hero">WhatsApp</a>
                <a class="cv-button cv-button--outline cv-button--large" href="#products">Explore Products</a>
            </div>
            <div class="hero-meta" aria-label="Green Paints highlights">
                <span>Job coater and OEM requirements</span>
                <span>In-house testing capability</span>
            </div>
        </div>
    </div>
</section>
