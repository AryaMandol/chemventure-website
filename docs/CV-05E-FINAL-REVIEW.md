# CV-05E - Final Client-Review Audit

## Scope

This is a bounded source-level audit and patch based on CV-05D. The existing approved homepage layout, branding, section order, form field names, anchor IDs, lead post type, theme settings and policy copy remain intact. No WordPress database, server, installed plugin set or live browser instance was available in this package, so runtime checks must be completed in Local.

## Corrected

- Replaced internal phrases such as "supplied catalogue" and "managed from WordPress" in public content with buyer-facing language without introducing new capabilities. If About text was already saved through the Customizer, review that stored text manually.
- Unconfigured technical resource rows now link to the enquiry form and prefill its requirement field only if empty. Once a valid PDF URL is configured through the Customizer the row becomes a PDF link again.
- Added the WhatsApp icon to header and mobile-menu actions to match the existing hero, product, form, finishes and footer actions. The number remains in one WordPress Customizer setting.
- Enquiry endpoint now validates reasonable phone digit length and server-side field lengths. Existing nonce, honeypot and rate limiting remain in place.
- Spreadsheet formula prefixes in lead export cells are escaped before CSV generation.
- Opting into GTM no longer flushes earlier pre-consent events to GTM. Changing consent back to Necessary only reloads the page after storing the selection so previously loaded optional scripts stop on the next load.
- Consent modal keyboard Tab handling improved.

## Before Sending the Local Live Link

1. Confirm the homepage opens on desktop and at 390px/360px/320px, with no overflow or image/text gap.
2. Test header, hero, products, finishes, form and footer WhatsApp links. Verify the temporary number is appropriate for this review period.
3. Publish both legal pages, ensure their shortcodes render full text, set the WordPress Privacy Policy and client-owned privacy contact email, and verify footer links. The legal content requires the client's review.
4. Test a product enquiry and an unconfigured resource request. The form should select the product or prefill the requirement without wiping user-entered data.
5. Submit one valid test lead and one malformed phone number. Confirm successful lead storage, correct UTM attribution, expected validation errors, and Local mail capture.
6. Export CSV with a test lead whose company starts with `=1+1` and verify the downloaded field is treated as text, not evaluated as a formula. Delete the test lead afterwards.
7. Test analytics consent only with a known test GTM container: no `gtm.js` before acceptance; after acceptance it may load; after selecting Necessary only, page reloads and it does not load again.
8. Review the visible website copy for outdated Customizer values. Replace stock imagery and upload approved PDFs when provided. Do not imply stock photographs show ChemVenture's real facility.
9. Keep production tracking off until the client-owned accounts, approved policies and Meta/GA4 tagging are configured.
10. Check Git changes, push, open PR using GitHub web, test the live linked Local theme, then merge.

## Not a Production Security Audit

Production security still depends on updated WordPress/core/plugins, TLS, hardened hosting and permissions, tested backups, WAF/bot controls, account MFA, SMTP, monitoring, and an infrastructure review once AWS/domain access is provided. Local testing does not prove these.

## Changed Theme Files

- `header.php`
- `functions.php`, `style.css`
- `inc/helpers.php`, `inc/leads.php`
- `template-parts/home/about.php`, `products.php`, `benefits.php`, `quality.php`, `operations.php`, `finishes.php`, `resources.php`
- `assets/js/theme.js`, `assets/css/home.css`
