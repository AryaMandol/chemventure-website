# ChemVenture / Green Paints Website

Official single-page corporate and campaign website for **ChemVenture India Private Limited** and its **Green Paints** powder coating brand.

The site is implemented as a lightweight custom WordPress theme. The approved CV-01 design master remains the visual reference for production implementation.

## Project Status

| Stage | Scope | Status |
| --- | --- | --- |
| CV-01 | Responsive design master | Complete |
| CV-02 | WordPress + Git foundation | Complete |
| CV-03 | Complete homepage implementation | Complete |
| CV-04 | Lead generation + campaign tracking | Complete |
| CV-05 | Polish, mobile, SEO + hardening | Complete + legal policy patch |
| CV-06 | Production deployment + verification | Planned |

## Technology

- WordPress
- custom PHP theme
- HTML5 / CSS / vanilla JavaScript
- Local for local WordPress development
- Git + GitHub
- native WordPress lead storage
- Google Tag Manager-ready data layer
- GA4 and Meta Pixel intended to be configured through GTM in production

No page builder is used. The site does not depend on Elementor or a multipurpose commercial theme.

## Repository Structure

```text
chemventure-website/
├── design-master/                 # Approved CV-01 HTML reference
├── docs/                          # Setup, implementation and QA notes
├── wp-content/
│   └── themes/
│       └── chemventure/           # Custom WordPress theme source
├── .gitignore
└── README.md
```

WordPress core, the database, uploads, cache, Local configuration and third-party plugins are not committed to this repository.

## Branching Workflow

Each major stage is developed on its own branch and merged into `main` after review.

```text
main
├── feature/cv-01-design-master
├── feature/cv-02-wordpress-foundation
├── feature/cv-03-homepage-build
├── feature/cv-04-leads-tracking
├── feature/cv-05-polish-seo-hardening
└── feature/cv-06-production-launch
```

Small fixes within a stage stay on that stage branch.

## Design Source of Truth

The approved CV-01 implementation under `design-master/` defines the page structure, visual hierarchy, typography, spacing, image treatment, responsive behaviour and interaction direction.

WordPress implementation should preserve that design unless a later review explicitly approves a visual change.

## Local Development

The repository path used for this project is:

```text
D:\Arya\chemventure-website
```

Local maintains its normal WordPress installation separately. The custom theme in this repository is linked into Local using a Windows directory junction, so edits in Git are immediately reflected on the local WordPress site.

See [`docs/CV-02-LOCAL-SETUP.md`](docs/CV-02-LOCAL-SETUP.md).

## Homepage Administration

Homepage content is managed through:

```text
Appearance → Customize → ChemVenture Homepage
```

Available administration areas include:

- Hero Content
- Homepage Images
- About Content
- Contact Details
- Technical Resources
- Leads & Tracking
- SEO & Privacy

See [`docs/CV-03-HOMEPAGE.md`](docs/CV-03-HOMEPAGE.md).

## Leads and Campaign Attribution

CV-04 provides:

- AJAX enquiry submission
- private WordPress lead records
- lead status management
- notification email
- CSV export
- UTM / click-ID attribution
- GTM-ready data-layer events

See [`docs/CV-04-LEADS-TRACKING.md`](docs/CV-04-LEADS-TRACKING.md).

## SEO, Privacy and Hardening

CV-05 adds lightweight homepage SEO metadata, Organization/WebSite schema, local-development `noindex`, progressive-enhancement safeguards, security headers, responsive/accessibility refinements, consent-gated GTM loading, and customized Privacy/Cookie Policy pages.

See [`docs/CV-05-POLISH-SEO-HARDENING.md`](docs/CV-05-POLISH-SEO-HARDENING.md) and [`docs/CV-05B-LEGAL-POLICIES.md`](docs/CV-05B-LEGAL-POLICIES.md).

## Development Rules

- Keep `main` deployable.
- Do not edit production directly.
- Do not commit WordPress core, databases, uploads, cache or secrets.
- Test desktop and mobile before merging a stage.
- Keep factual claims grounded in client-approved material.
- Do not place personally identifiable form data in analytics events.
- GTM must remain blocked until the visitor accepts optional analytics/measurement cookies.
- Update this README when the project stage or setup materially changes.


## Staging approval preparation

Before production, the current website can be shared with the client using Local Live Links. The staging default WhatsApp number is `9903645467`; update it from **Appearance → Customize → ChemVenture Homepage → Contact Details → WhatsApp number** before sharing the approval link. Privacy and Cookie Policy pages should be published for review.
