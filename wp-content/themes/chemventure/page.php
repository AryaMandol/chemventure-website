<?php
/**
 * Standard page template.
 *
 * @package ChemVenture
 */

get_header();
?>
<main id="main-content" class="cv-content-shell">
    <div class="cv-container cv-content-shell__inner">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'cv-entry' ); ?>>
                <h1><?php the_title(); ?></h1>
                <div class="cv-entry__content"><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
