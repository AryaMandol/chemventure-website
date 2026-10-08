# CV-05F - Visual Correction Before Client Review

## Objective

Bring the Green Paints WordPress homepage back to a cohesive professional industrial visual language, while retaining the existing content hierarchy, product types, contact destinations, WordPress Customizer controls, lead submission logic, privacy controls and campaign attribution.

## Implementation

1. **Header**: Removes WhatsApp from the narrow utility bar and removes the duplicate Contact action. The main-header WhatsApp action remains beside Get a Quote with a 17px constrained SVG icon. The hamburger appears earlier in narrower viewports.
2. **Hero**: Removes the two decorative highlight bullets and the third full-size CTA. Keeps Get a Quote and WhatsApp as the primary action pair, with a low-emphasis Explore Products text link below. Hero wording remains editable through the WordPress Customizer.
3. **About**: Replaces three framed information cards with a compact divided strengths list. Retains all three factual capability descriptions.
4. **Products**: Changes the three product cards into a coherent sage-tinted catalogue band, with vertical dividers, shorter spacing, and product-specific WhatsApp and enquiry links. Does not alter product keys or form-selection logic.
5. **Why Powder Coating**: Places the heading and introduction in one aligned stack over a 2-by-2 open-grid of benefit items. The coloured section uses the existing green brand palette, without four floating white cards.
6. **Colours & Finishes**: Shows all five supplied finish categories. Structure occupies one large sample column; Glossy, Satin, Semi Gloss and Matt are arranged as a symmetrical 2-by-2 set. Samples are **illustrative representations**, not official calibrated colour/finish swatches. Both enquiry and WhatsApp CTA remain.
7. **Image balance**: Leaves the desktop content-driven image-height rules for About, Quality and Operations unchanged. Do not replace them with static heights.
8. **Cache**: Theme version updated to 0.5.6 so WordPress refreshes CSS asset URLs.

## Changed files

- `README.md`
- `docs/CV-05F-VISUAL-CORRECTION.md`
- `wp-content/themes/chemventure/README.md`
- `wp-content/themes/chemventure/functions.php`
- `wp-content/themes/chemventure/style.css`
- `wp-content/themes/chemventure/header.php`
- `wp-content/themes/chemventure/template-parts/home/hero.php`
- `wp-content/themes/chemventure/template-parts/home/about.php`
- `wp-content/themes/chemventure/template-parts/home/products.php`
- `wp-content/themes/chemventure/template-parts/home/benefits.php`
- `wp-content/themes/chemventure/template-parts/home/finishes.php`
- `wp-content/themes/chemventure/assets/css/theme.css`
- `wp-content/themes/chemventure/assets/css/home.css`

## Local acceptance tests

- Check desktop at 1440px and 1200px, tablet 1024px and 768px, mobile at 390px, 360px and 320px.
- Utility bar contains no WhatsApp link/icon. Main header WhatsApp icon is small, aligned, and the desktop nav never wraps.
- Hero has exactly two full-size actions; no decorative bullets.
- About strengths use plain structured rows, not cards.
- Product cards are sage-tinted, not white, and all three specific WhatsApp links work with the expected pre-filled product text.
- Benefits heading/intro form one vertical text stack. The four benefits use a 2-column split on desktop and stack on mobile.
- Finishes show exactly five items, with Structure featured on desktop, four smaller samples balanced around it. Mobile must not overflow.
- About, Quality and Operations photos align with the paired text height at desktop sizes.
- Enquiry form, legal pages, cookie preferences, resources, lead storage, UTM capture and WhatsApp Customizer number behave as before.
- WordPress theme reports version 0.5.6; no PHP warnings or JS console errors on Local.

## Not changed

- Form field names and AJAX endpoint
- Google Tag Manager/dataLayer event naming
- WhatsApp number in Customizer
- WordPress legal policy pages and consent behaviour
- Enquiry section and lead storage logic
- Actual client images, contact details, certificates or technical PDF documents

## Verification scope

This patch was tested with PHP-lint and a static WordPress-template rendering harness, including 1440px, 1024px, 390px and 320px layout checks. That harness used bundled fallback photographs, not a live WordPress database or the client's final image selection. Validate again on Local before requesting client approval.
