<?php
$about_image = chemventure_home_image(
    'about_image',
    'https://images.pexels.com/photos/36215204/pexels-photo-36215204.jpeg?auto=compress&cs=tinysrgb&w=1400'
);
$fallback = CHEMVENTURE_THEME_URI . '/assets/images/powder-spray-green.jpg';
?>
<section class="home-section home-section-white" id="about" data-section="about">
    <div class="cv-container split-grid about-grid">
        <div class="home-media-card about-media" data-reveal>
            <img src="<?php echo esc_url( $about_image ); ?>" data-fallback="<?php echo esc_url( $fallback ); ?>" alt="Industrial powder coating process" loading="lazy" decoding="async">
            <div class="media-caption">Representative powder coating process image</div>
        </div>

        <div class="content-block" data-reveal>
            <p class="home-eyebrow home-eyebrow-dark">About Green Paints</p>
            <h2><?php echo esc_html( chemventure_mod( 'about_title', 'Powder coating expertise backed by ChemVenture.' ) ); ?></h2>
            <p class="lead"><?php echo esc_html( chemventure_mod( 'about_lead', 'ChemVenture India Private Limited was founded in 2010 and later expanded into chemical intermediates and powder paints for the coatings industry. Green Paints is the company\'s powder coating range.' ) ); ?></p>
            <p><?php echo esc_html( chemventure_mod( 'about_body', 'The business focuses on product development, consistent quality, operational efficiency and customer value. Its supplied company profile also records customers ranging from job coaters to OEMs.' ) ); ?></p>

            <div class="about-strengths">
                <article><h3>Development &amp; Laboratory</h3><p>Products are developed and tested before moving to the customer's facility.</p></article>
                <article><h3>Production</h3><p>A dedicated production team supports consistent product quality.</p></article>
                <article><h3>Supply Support</h3><p>Inventory and supply-chain processes are focused on timely customer fulfilment.</p></article>
            </div>
        </div>
    </div>
</section>
