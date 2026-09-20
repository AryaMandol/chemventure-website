<?php
$quality_image = chemventure_home_image(
    'quality_image',
    'https://images.pexels.com/photos/3861442/pexels-photo-3861442.jpeg?auto=compress&cs=tinysrgb&w=1400'
);
$fallback = CHEMVENTURE_THEME_URI . '/assets/images/powder-spray-yellow.png';
?>
<section class="home-section home-section-white" id="quality" data-section="quality">
    <div class="cv-container split-grid quality-grid">
        <div class="home-media-card quality-media" data-reveal>
            <img src="<?php echo esc_url( $quality_image ); ?>" data-fallback="<?php echo esc_url( $fallback ); ?>" alt="Representative laboratory testing" loading="lazy" decoding="async">
            <div class="media-caption">Representative laboratory image</div>
        </div>
        <div class="content-block" data-reveal>
            <p class="home-eyebrow home-eyebrow-dark">Quality &amp; Testing</p>
            <h2>Tested for consistency before customer use.</h2>
            <p class="lead">ChemVenture's supplied catalogue lists in-house testing for key coating properties, with additional special testing available when required by customers.</p>
            <div class="test-list">
                <div><span>Impact Resistance</span><small>Mechanical performance check</small></div>
                <div><span>Gloss Measurement</span><small>Finish consistency check</small></div>
                <div><span>Film Thickness</span><small>Coating build measurement</small></div>
                <div><span>Flexibility</span><small>Coating response assessment</small></div>
                <div><span>Special Testing</span><small>As required by customers</small></div>
            </div>
        </div>
    </div>
</section>
