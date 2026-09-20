<?php
/**
 * Default template.
 *
 * @package ChemVenture
 */

get_header();
?>
<main id="main-content" class="cv-content-shell">
    <div class="cv-container cv-content-shell__inner">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class( 'cv-entry' ); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="cv-entry__content"><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <h1><?php esc_html_e( 'Nothing found', 'chemventure' ); ?></h1>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
