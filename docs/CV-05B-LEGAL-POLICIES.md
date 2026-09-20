# CV-05B - Privacy Policy, Cookie Policy and Consent Banner

## Purpose

This patch adds ChemVenture-specific privacy and cookie disclosures and refines the existing consent banner before CV-06 production deployment.

## Public policies

The theme registers:

- `[chemventure_privacy_policy]`
- `[chemventure_cookie_policy]`

If pages with the slugs `privacy-policy` and `cookie-policy` do not exist, draft pages are created when an administrator opens WordPress Admin. Existing pages are never overwritten.

## Required review before publishing

1. Confirm ChemVenture's legal name.
2. Set the Privacy contact email under `Appearance → Customize → ChemVenture Homepage → SEO & Privacy`.
3. Confirm the published phone/address details.
4. Review the full wording with the client or legal adviser if the client requires formal legal approval.
5. Publish both pages.
6. Under `Settings → Privacy`, select the customized Privacy Policy page.

## Consent behaviour

The consent banner is shown only when GTM is configured and enabled. Necessary website functions remain available without optional consent. Optional analytics/campaign-measurement tags load only after `Accept optional`.

The footer contains `Privacy Policy`, `Cookie Policy`, and, when tracking is enabled, `Cookie settings`.

## Policy maintenance

The policies describe the website architecture as implemented in CV-04/CV-05. Update them if the site later adds new forms, CRM integrations, chat tools, ad platforms, profiling, remarketing, user accounts, payment processing, or materially different retention practices.
