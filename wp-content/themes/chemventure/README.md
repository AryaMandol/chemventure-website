# ChemVenture Green Paints Theme

Custom lightweight WordPress theme for the ChemVenture / Green Paints website.

## Current Stage

**CV-03 - Complete homepage implementation**

The homepage now implements the approved CV-01 visual direction inside WordPress.

### Implemented

- responsive hero and proof band
- About / Green Paints section
- powder-coating product range
- Why Powder Coating section
- Colours & Finishes section
- Quality & Testing section
- Operational Capability section
- Technical Resources section
- enquiry form UI
- responsive navigation and footer
- active-section navigation state
- product-to-enquiry selection behaviour
- reduced-motion-safe reveal behaviour
- content-driven desktop media height for split sections
- native WordPress Customizer controls for primary homepage imagery, key copy, contact details and resource URLs

## Admin Editing

Go to:

```text
Appearance → Customize → ChemVenture Homepage
```

The Customizer provides sections for:

- Hero Content
- Homepage Images
- About Content
- Contact Details
- Technical Resources

## Not Included Yet

CV-04 will connect the enquiry form to real lead handling and add analytics / Meta tracking.

## Requirements

- WordPress 6.5+
- PHP 8.1+

## Design Principle

The approved CV-01 design master remains the visual reference. WordPress implementation should preserve its professional B2B industrial layout and responsive behaviour.


## CV-04 Lead Handling

The theme includes a native lead-capture endpoint, private `cv_lead` admin records, lead notification email, CSV export, UTM attribution and GTM-ready data-layer events. See the project-level `docs/CV-04-LEADS-TRACKING.md`.
