<?php
/**
 * Front page.
 *
 * @package ChemVenture
 */

get_header();
?>
<main id="main-content" class="cv-homepage">
    <?php
    get_template_part( 'template-parts/home/hero' );
    get_template_part( 'template-parts/home/proof' );
    get_template_part( 'template-parts/home/about' );
    get_template_part( 'template-parts/home/products' );
    get_template_part( 'template-parts/home/benefits' );
    get_template_part( 'template-parts/home/finishes' );
    get_template_part( 'template-parts/home/quality' );
    get_template_part( 'template-parts/home/operations' );
    get_template_part( 'template-parts/home/resources' );
    get_template_part( 'template-parts/home/enquiry' );
    ?>
</main>
<?php
get_footer();
