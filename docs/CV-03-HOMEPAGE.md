# CV-03 - WordPress Homepage Implementation

## Objective

Convert the approved CV-01 landing-page design into the custom WordPress theme while keeping the design responsive and allowing the most frequently changing content to be updated through WordPress administration.

## Files Added / Updated

```text
wp-content/themes/chemventure/
├── front-page.php
├── functions.php
├── header.php
├── style.css
├── inc/
│   ├── customizer.php
│   ├── enqueue.php
│   └── helpers.php
├── template-parts/home/
│   ├── hero.php
│   ├── proof.php
│   ├── about.php
│   ├── products.php
│   ├── benefits.php
│   ├── finishes.php
│   ├── quality.php
│   ├── operations.php
│   ├── resources.php
│   └── enquiry.php
└── assets/
    ├── css/home.css
    ├── css/theme.css
    ├── js/theme.js
    └── images/
```

## WordPress Admin Controls

Open:

```text
Appearance → Customize → ChemVenture Homepage
```

### Hero Content

- hero eyebrow
- hero title
- supporting copy

### Homepage Images

- hero image
- About / powder-coating image
- Quality / laboratory image
- Operations / supply image

When no image has been uploaded, the theme uses the representative development image URL and falls back to a bundled local image if that external image fails.

### About Content

- heading
- lead paragraph
- supporting paragraph

### Contact Details

- phone
- WhatsApp number
- email
- corporate office
- factory

### Technical Resources

- Powder Coating Guide URL
- Application Guidelines URL
- Pretreatment Guidelines URL
- Finish Selection Support URL

If a resource URL has not been configured, the button stays in prototype mode and explains that the file must be configured through WordPress.

## CV-03 QA

Check the following before merging the branch:

- desktop homepage matches the approved CV-01 structure
- 390px mobile layout has no horizontal overflow
- mobile menu opens, closes and responds to Escape
- hero image loads or falls back cleanly
- split-section images match the height of their text column on desktop
- product enquiry links pre-select the correct product
- form validation UI works
- resource placeholders work when no URL is configured
- uploaded Customizer images replace development images
- contact details appear only when configured
- PHP syntax check passes
- browser console shows no JavaScript errors

## Deferred to CV-04

- real form submission and email delivery
- spam protection
- enquiry persistence
- UTM capture
- Google Tag Manager
- GA4 events
- Meta Pixel
- WhatsApp conversion tracking
