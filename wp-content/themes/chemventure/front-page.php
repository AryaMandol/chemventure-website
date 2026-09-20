<?php
/**
 * Front page foundation template.
 *
 * CV-03 will replace this temporary verification surface with the
 * approved CV-01 homepage implementation.
 *
 * @package ChemVenture
 */

get_header();
?>
<main id="main-content">
    <section class="cv-foundation-hero">
        <div class="cv-container cv-foundation-hero__inner">
            <p class="cv-eyebrow">CV-02 WordPress Foundation</p>
            <h1>Green Paints theme is active.</h1>
            <p>This temporary screen confirms that the custom ChemVenture WordPress theme, assets, navigation and Git-connected Local environment are working correctly.</p>
            <div class="cv-foundation-actions">
                <a class="cv-button cv-button--primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>">Theme Setup Complete</a>
                <span class="cv-foundation-reference">CV-01 remains the visual source of truth for the homepage build.</span>
            </div>
        </div>
    </section>

    <section class="cv-foundation-checks">
        <div class="cv-container">
            <h2>Foundation checks</h2>
            <div class="cv-foundation-grid">
                <article><strong>Custom theme</strong><span>Active and loaded from the Git repository.</span></article>
                <article><strong>Theme assets</strong><span>CSS, JavaScript and bundled Green Paints logo are loading.</span></article>
                <article><strong>Responsive shell</strong><span>Header, mobile navigation and footer are ready for CV-03.</span></article>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
