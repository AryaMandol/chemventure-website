<?php
/**
 * 404 template.
 *
 * @package ChemVenture
 */

get_header();
?>
<main id="main-content" class="cv-content-shell">
    <div class="cv-container cv-content-shell__inner cv-error-page">
        <p class="cv-eyebrow">404</p>
        <h1>Page not found.</h1>
        <p>The page you are looking for may have moved or no longer exists.</p>
        <a class="cv-button cv-button--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Return home</a>
    </div>
</main>
<?php
get_footer();
