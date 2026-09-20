# CV-05C - Staging Approval Readiness

This patch prepares the ChemVenture / Green Paints website for client approval before AWS production deployment.

## Included

- reliable Privacy Policy footer URL fallback
- customized Privacy and Cookie Policy rendering
- staging WhatsApp default `9903645467`
- pre-filled WhatsApp messages by section
- header, hero, product, finishes, contact and footer WhatsApp actions
- deferred theme JavaScript
- XML-RPC disabled
- public REST user enumeration reduced
- WordPress file editor disabled
- legacy discovery links removed
- generic login errors
- front-end emoji assets removed

## WhatsApp number

Update from:

`Appearance → Customize → ChemVenture Homepage → Contact Details → WhatsApp number`

A 10-digit Indian number is automatically converted to the `91` country-code format required by `wa.me`.

## Staging sharing

Use Local Live Links for client review. Keep Local and the development machine running while the link is being reviewed. Privacy Mode credentials should be shared with the client and the Live Link should be disabled when review is complete.

## Production security and performance deferred to CV-06

Hosting-layer controls such as AWS WAF, CloudFront caching/compression, TLS/ACM, backups, SMTP, server patching, least-privilege IAM and production monitoring depend on the final AWS architecture and are intentionally not hard-coded into the theme.
