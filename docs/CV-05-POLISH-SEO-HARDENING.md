# CV-05 - Polish, Mobile, SEO and Hardening

CV-05 prepares the ChemVenture / Green Paints WordPress theme for production readiness before deployment.

## Scope

This stage covers:

- SEO metadata and schema
- privacy-policy integration
- analytics consent
- responsive and accessibility refinement
- progressive enhancement
- performance hints
- conservative front-end security headers
- local-development indexing protection
- final browser QA

## SEO

When no common dedicated SEO plugin is active, the theme outputs homepage:

- meta description
- canonical URL
- Open Graph title, description, URL and image
- Twitter summary-large-image metadata
- Organization JSON-LD
- WebSite JSON-LD

Configure under:

```text
Appearance
→ Customize
→ ChemVenture Homepage
→ SEO & Privacy
```

Settings include:

- Organization legal name
- Homepage meta description
- Social share image

Recommended social image size:

```text
1200 × 630 px
```

If Yoast SEO, Rank Math or All in One SEO is later installed, the theme suppresses its own front-page metadata/schema to reduce duplication.

WordPress core sitemap support remains unchanged.

## Search Indexing

The theme forces `noindex`, `nofollow` and `noarchive` when:

- WordPress environment type is not `production`; or
- the current host ends in `.local`; or
- the site is running on localhost.

Before launch also verify:

```text
Settings → Reading → Discourage search engines from indexing this site
```

is **unchecked** on production.

## Privacy Policy

Create or assign the privacy page under:

```text
Settings → Privacy
```

When a Privacy Policy page exists:

- the enquiry form links to it;
- the footer links to it;
- the analytics-consent panel links to it.

## GTM Consent

GTM configuration remains under:

```text
Appearance
→ Customize
→ ChemVenture Homepage
→ Leads & Tracking
```

GTM loads only when all of the following are true:

1. a valid `GTM-...` container ID is configured;
2. `Enable Google Tag Manager` is checked;
3. the visitor chooses **Accept analytics**.

Before consent, the GTM network script is not requested.

The consent choice is stored in browser `localStorage` as a versioned preference. Visitors can reopen the choice from **Cookie settings** in the footer.

This is a lightweight binary consent implementation for analytics/campaign measurement. If the production campaign targets a jurisdiction that requires more granular categories or additional legal wording, obtain appropriate legal guidance before enabling advertising tags.

## Data Layer

The CV-04 data layer remains available before GTM loads. No name, email or phone value is added to analytics events.

When the visitor later accepts analytics, GTM can process the existing data-layer state and subsequent events.

## Accessibility and Progressive Enhancement

CV-05 adds:

- JavaScript/no-JavaScript root classes;
- reveal content that remains visible when JavaScript fails;
- a usable mobile navigation fallback when JavaScript is disabled;
- Escape-key mobile-menu handling with focus restoration;
- first-link focus when the mobile menu opens;
- `aria-current="location"` on the active desktop navigation item;
- keyboard-focusable consent dialog;
- reduced-motion support already retained from earlier stages.

## Performance

CV-05 adds:

- `fetchpriority="high"` to the hero image;
- asynchronous image decoding;
- lazy loading on supporting images;
- a preconnect hint for temporary Pexels development imagery when WordPress-admin replacement images have not yet been provided.

Before launch, replace temporary external stock-image URLs with approved WordPress Media Library images where possible.

## Security Hardening

The theme sends these conservative response headers:

```text
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
X-Frame-Options: SAMEORIGIN
Permissions-Policy: camera=(), microphone=(), geolocation=()
```

HSTS and a full Content-Security-Policy are intentionally left for CV-06 server/hosting configuration because they depend on the final HTTPS domain, hosting stack, SMTP, GTM and third-party resources.

## QA Checklist

### Desktop

Test at approximately:

```text
1440 × 900
1024 × 768
```

Confirm:

- no unexpected horizontal overflow;
- split-section image and text heights remain aligned;
- header remains readable when sticky;
- all CTA anchors reach the correct section;
- enquiry submission remains functional.

### Mobile

Test at:

```text
390 × 844
360 × 800
320 × 700
```

Confirm:

- hamburger opens and closes;
- first menu link receives focus;
- Escape closes the menu and returns focus to the toggle;
- no horizontal overflow;
- product labels wrap cleanly;
- form fields remain readable and tappable;
- cookie-consent buttons stack cleanly.

### SEO

View page source and confirm:

- one meta description;
- one canonical homepage URL;
- Open Graph metadata;
- JSON-LD Organization + WebSite schema;
- local site carries `noindex` in robots output.

### Consent

For a consent test only, configure a test GTM container and enable GTM.

In DevTools Network:

1. clear site data/localStorage;
2. reload the page;
3. confirm `googletagmanager.com/gtm.js` is **not** requested;
4. choose **Necessary only** and reload;
5. confirm GTM is still not requested;
6. use **Cookie settings** and choose **Accept analytics**;
7. confirm GTM is then requested;
8. reload and confirm the accepted preference persists.

Disable the test GTM configuration again after local QA unless production tracking is ready.

## CV-06 Handoff

CV-06 will handle:

- production backup/deployment;
- production domain and HTTPS verification;
- final SMTP/mail delivery;
- production GTM/GA4/Meta configuration;
- final real contact details and resources;
- final images and social preview asset;
- server-level caching/compression/security settings;
- final search-indexing verification;
- production lead + tracking smoke tests.
