<?php
$operations_image = chemventure_home_image(
    'operations_image',
    'https://images.pexels.com/photos/4483772/pexels-photo-4483772.jpeg?auto=compress&cs=tinysrgb&w=1400'
);
$fallback = CHEMVENTURE_THEME_URI . '/assets/images/powder-spray-green.jpg';
?>
<section class="home-section operations-section">
    <div class="cv-container operations-layout">
        <div class="operations-copy" data-reveal>
            <p class="home-eyebrow home-eyebrow-dark">Operational Capability</p>
            <h2>From development to delivery.</h2>
            <p>The supplied company material highlights laboratory development, production, inventory support and supply-chain monitoring as part of the operating model.</p>
            <div class="operations-list">
                <article><span class="operations-mark"></span><div><h3>Development</h3><p>Product development and testing capability to support customer requirements.</p></div></article>
                <article><span class="operations-mark"></span><div><h3>Production</h3><p>Dedicated production team focused on consistent product quality.</p></div></article>
                <article><span class="operations-mark"></span><div><h3>Inventory</h3><p>Stock planning intended to support chosen customer requirements.</p></div></article>
                <article><span class="operations-mark"></span><div><h3>Supply Chain</h3><p>Monitoring of raw material and finished goods movement with focus on on-time delivery.</p></div></article>
            </div>
        </div>
        <div class="operations-media" data-reveal>
            <img src="<?php echo esc_url( $operations_image ); ?>" data-fallback="<?php echo esc_url( $fallback ); ?>" alt="Representative industrial operations" loading="lazy">
            <div class="operations-caption">Representative industrial operations image</div>
        </div>
    </div>
</section>
