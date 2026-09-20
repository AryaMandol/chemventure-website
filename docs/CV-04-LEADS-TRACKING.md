# CV-04 - Lead Generation and Tracking

CV-04 converts the homepage enquiry UI into a working WordPress lead-capture flow and prepares the site for campaign attribution through Google Tag Manager.

## Lead Capture

The homepage form now submits asynchronously to WordPress using `admin-ajax.php`.

On successful submission WordPress:

1. validates and sanitizes the request;
2. stores the enquiry as a private admin-side `Lead` record;
3. stores campaign attribution fields such as UTM source, medium and campaign;
4. sends a notification with `wp_mail()` to the configured lead recipient;
5. returns a success state to the visitor.

The form includes a honeypot and a lightweight hashed-IP rate limit. Raw IP addresses are not stored with the lead.

## Lead Administration

In WordPress Admin use:

```text
Leads
→ All Leads
```

Each lead includes:

- name;
- company;
- phone / WhatsApp;
- email;
- product interest;
- requirement;
- lead status;
- UTM attribution;
- landing URL;
- referrer.

Lead statuses are:

- New
- Contacted
- Qualified
- Closed

CSV export is available from:

```text
Leads
→ Export CSV
```

## Notification Email

Configure the recipient at:

```text
Appearance
→ Customize
→ ChemVenture Homepage
→ Leads & Tracking
→ Lead notification email
```

If left unchanged, the WordPress administration email is used.

Local may capture `wp_mail()` output in its mail-testing tool instead of delivering it externally. Production SMTP or hosting mail delivery will be finalized during deployment.

## Campaign Attribution

The front end captures these parameters when present:

```text
utm_source
utm_medium
utm_campaign
utm_content
utm_term
gclid
fbclid
```

Attribution is kept in browser `sessionStorage` for the current browsing session and submitted with the lead. No attribution cookie is created by the theme.

Example test URL:

```text
http://chemventure.local/?utm_source=facebook&utm_medium=paid_social&utm_campaign=powder_coating_test&utm_content=hero_ad
```

Submit the form, then inspect the resulting lead in WordPress Admin.

## Front-end Tracking Events

The theme pushes the following events to `window.dataLayer`:

```text
quote_cta_click
product_enquiry_click
whatsapp_click
phone_click
email_click
resource_download
form_start
form_submit
form_error
form_abandon
scroll_depth
```

No name, email address or phone number is pushed to the data layer.

## Google Tag Manager

Configure at:

```text
Appearance
→ Customize
→ ChemVenture Homepage
→ Leads & Tracking
```

Fields:

- Google Tag Manager Container ID, for example `GTM-XXXXXXX`
- Enable Google Tag Manager

The theme intentionally does not hard-code GA4 or Meta Pixel separately. Configure both inside GTM so there is one tracking layer and no duplicate page tags.

During local development leave GTM disabled unless actively testing Tag Manager. Before production activation, complete the CV-05 privacy and consent review.

### Suggested GTM mapping

Use Custom Event triggers for the data-layer event names above.

Recommended conversion mappings:

| Data-layer event | GA4 direction | Meta direction |
| --- | --- | --- |
| `form_submit` | `generate_lead` | `Lead` |
| `whatsapp_click` | contact interaction | `Contact` |
| `phone_click` | contact interaction | `Contact` |
| `product_enquiry_click` | product interest | custom event |
| `resource_download` | file download | custom event |

Do not send form PII into GA4, Meta Pixel or GTM variables.

## Local QA

1. Open a URL with test UTM parameters.
2. Begin typing in the quote form.
3. Submit a valid enquiry.
4. Confirm the success message.
5. Go to `WP Admin → Leads` and confirm the record exists.
6. Open the lead and verify its UTM values and landing URL.
7. Check the Local mail-testing tool for the notification email.
8. Change the lead status and save it.
9. Export the lead CSV and confirm the test record exists.
10. In browser DevTools run `window.dataLayer` and confirm interaction events are present.

## Production Notes

Before launch:

- confirm the production lead-recipient address;
- configure reliable outbound mail / SMTP;
- configure GTM, GA4 and Meta Pixel under client-owned accounts;
- complete privacy/cookie/consent requirements in CV-05;
- verify form and tracking events on the production domain.
