# ChemVenture / Green Paints Website

Official single-page corporate and campaign website for **ChemVenture India Private Limited** and its **Green Paints** powder coating brand.

The website is being developed as a lightweight custom WordPress implementation. The responsive HTML design master created during CV-01 remains the visual source of truth for the WordPress build.

## Project Status

| Stage | Scope | Status |
| --- | --- | --- |
| CV-01 | Responsive design master | Complete |
| CV-02 | WordPress + Git foundation | Complete |
| CV-03 | Complete homepage implementation | Complete |
| CV-04 | Lead generation + tracking | In progress |
| CV-05 | Polish, mobile, SEO + hardening | Planned |
| CV-06 | Production deployment + verification | Planned |

## Technology

- WordPress
- Custom PHP theme
- HTML5 / CSS / vanilla JavaScript
- Local for local WordPress development
- Git + GitHub
- Google Tag Manager data layer and lead attribution
- GA4 and Meta Pixel configured through GTM for production

No page builder is used. The production site will not depend on Elementor or a multipurpose commercial theme.

## Repository Structure

```text
chemventure-website/
├── design-master/                 # Approved CV-01 HTML reference
├── docs/                          # Project setup and implementation notes
├── wp-content/
│   └── themes/
│       └── chemventure/           # Custom WordPress theme source
├── .gitignore
└── README.md
```

The WordPress core installation, database, uploads and third-party plugins are **not** committed to this repository.

## Branching Workflow

Each major project stage is developed on its own branch and merged into `main` only after review.

```text
main
├── feature/cv-01-design-master
├── feature/cv-02-wordpress-foundation
├── feature/cv-03-homepage-build
├── feature/cv-04-leads-tracking
├── feature/cv-05-polish-seo-hardening
└── feature/cv-06-production-launch
```

Small fixes inside a stage stay on that stage's branch rather than creating unnecessary branches.

## Design Source of Truth

The approved CV-01 implementation in `design-master/` defines:

- page structure
- visual hierarchy
- typography scale
- colour direction
- spacing and alignment
- image treatment
- responsive behaviour
- navigation behaviour
- interaction direction

WordPress implementation should reproduce this design rather than redesigning sections independently.

## Local Development

The Git repository remains at:

```text
D:\Arya\chemventure-website
```

Local can maintain its normal WordPress installation separately. The custom theme in this repository is connected to Local using a Windows directory junction so that edits in Git are immediately reflected in the Local WordPress site.

See [`docs/CV-02-LOCAL-SETUP.md`](docs/CV-02-LOCAL-SETUP.md) for the exact setup.

## Content and Assets

Temporary stock photography may be used during development. CV-03 exposes the homepage hero/process/laboratory/operations images, key hero/about copy, contact information and technical-resource URLs through WordPress Customizer controls. Additional operational functionality is added in later stages.

Client-supplied factual content remains the source for company, product, testing and operational claims.

## Development Rules

- Keep `main` deployable.
- Do not edit production directly.
- Do not commit WordPress core, database exports, uploads, cache or secrets.
- Test desktop and mobile before merging a stage.
- Keep implementation aligned with the approved design master.
- Update this README whenever the project stage or setup materially changes.


## Homepage Administration

The CV-03 homepage uses native WordPress Customizer controls for the items most likely to change before launch.

Go to:

```text
Appearance → Customize → ChemVenture Homepage
```

The administrator can update hero copy, key about copy, hero/about/quality/operations images, contact details and technical-resource links without changing theme code.

See [`docs/CV-03-HOMEPAGE.md`](docs/CV-03-HOMEPAGE.md) for the implementation and QA notes.


## Lead Generation and Tracking

CV-04 adds working WordPress lead capture, admin-side lead management, CSV export, campaign attribution and a GTM-ready data layer.

Go to:

```text
WP Admin → Leads
```

to review captured enquiries. Lead-recipient email and GTM settings are managed under:

```text
Appearance → Customize → ChemVenture Homepage → Leads & Tracking
```

See [`docs/CV-04-LEADS-TRACKING.md`](docs/CV-04-LEADS-TRACKING.md) for setup, event names and QA.
