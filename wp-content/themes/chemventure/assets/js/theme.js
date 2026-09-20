(() => {
  const config = window.ChemVentureConfig || {};
  const header = document.querySelector('[data-cv-header]');
  const toggle = document.querySelector('[data-cv-menu-toggle]');
  const menu = document.querySelector('[data-cv-mobile-menu]');
  const form = document.querySelector('[data-lead-form]');
  const formStatus = document.querySelector('[data-form-status]');
  const productSelect = document.querySelector('[data-product-select]');
  const resourceStatus = document.querySelector('[data-resource-status]');
  const submitButton = document.querySelector('[data-submit-button]');

  window.dataLayer = window.dataLayer || [];

  const track = (eventName, data = {}) => {
    if (!eventName) return;
    window.dataLayer.push({
      event: eventName,
      page_path: window.location.pathname,
      ...data,
    });
  };

  const updateHeader = () => {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 8);
  };

  const closeMenu = () => {
    if (!toggle || !menu) return;
    toggle.setAttribute('aria-expanded', 'false');
    menu.hidden = true;
  };

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const isOpen = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!isOpen));
      menu.hidden = isOpen;
    });

    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') closeMenu();
    });
    window.addEventListener('resize', () => {
      if (window.innerWidth > 980) closeMenu();
    });
  }

  document.querySelectorAll('img[data-fallback]').forEach((img) => {
    img.addEventListener('error', () => {
      const fallback = img.dataset.fallback;
      if (!fallback || img.dataset.fallbackApplied === 'true') return;
      img.dataset.fallbackApplied = 'true';
      img.src = fallback;
    }, { once: true });
  });

  const attributionKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'gclid', 'fbclid'];
  const attributionStorageKey = 'chemventure_campaign_attribution';

  const readStoredAttribution = () => {
    try {
      return JSON.parse(window.sessionStorage.getItem(attributionStorageKey) || '{}');
    } catch (error) {
      return {};
    }
  };

  const writeStoredAttribution = (value) => {
    try {
      window.sessionStorage.setItem(attributionStorageKey, JSON.stringify(value));
    } catch (error) {
      // Storage can be unavailable in restrictive browser modes. The form still works.
    }
  };

  const captureAttribution = () => {
    const params = new URLSearchParams(window.location.search);
    const current = {};
    let hasCampaignValue = false;

    attributionKeys.forEach((key) => {
      const value = (params.get(key) || '').trim();
      current[key] = value;
      if (value) hasCampaignValue = true;
    });

    const stored = readStoredAttribution();
    const result = hasCampaignValue ? current : { ...stored };

    if (!result.landing_url) result.landing_url = window.location.href;
    if (!result.referrer) result.referrer = document.referrer || '';

    if (hasCampaignValue || !stored.landing_url) writeStoredAttribution(result);
    return result;
  };

  let attribution = captureAttribution();

  const fillAttributionFields = () => {
    if (!form) return;
    [...attributionKeys, 'landing_url', 'referrer'].forEach((key) => {
      const field = form.querySelector(`[name="${key}"]`);
      if (field) field.value = attribution[key] || '';
    });
  };

  fillAttributionFields();

  document.querySelectorAll('[data-product-link]').forEach((link) => {
    link.addEventListener('click', () => {
      const productName = link.dataset.productLink || '';
      if (productSelect) productSelect.value = productName;
      track('product_enquiry_click', { product_name: productName });
    });
  });

  document.querySelectorAll('[data-resource]').forEach((button) => {
    button.addEventListener('click', () => {
      if (resourceStatus) {
        resourceStatus.textContent = 'This resource is not linked yet. Add the approved PDF URL in Appearance → Customize → ChemVenture Homepage → Technical Resources.';
      }
    });
  });

  document.querySelectorAll('[data-resource-link]').forEach((link) => {
    link.addEventListener('click', () => {
      track('resource_download', { resource_name: link.dataset.resourceName || '' });
    });
  });

  document.querySelectorAll('[data-cv-event]').forEach((element) => {
    element.addEventListener('click', () => {
      track(element.dataset.cvEvent, { link_location: element.dataset.cvLocation || '' });
    });
  });

  document.querySelectorAll('a[href*="#enquiry"]').forEach((link) => {
    if (link.matches('[data-product-link]')) return;
    link.addEventListener('click', () => {
      track('quote_cta_click', { link_text: (link.textContent || '').trim().slice(0, 80) });
    });
  });

  let formStarted = false;
  let formSubmitted = false;

  const setFormStatus = (message, type = '') => {
    if (!formStatus) return;
    formStatus.textContent = message;
    formStatus.classList.toggle('is-error', type === 'error');
    formStatus.classList.toggle('is-success', type === 'success');
  };

  const setSubmitState = (busy) => {
    if (!submitButton) return;
    if (!submitButton.dataset.defaultText) submitButton.dataset.defaultText = submitButton.textContent;
    submitButton.disabled = busy;
    submitButton.classList.toggle('is-loading', busy);
    submitButton.textContent = busy ? 'Sending…' : submitButton.dataset.defaultText;
  };

  if (form) {
    const startForm = () => {
      if (formStarted) return;
      formStarted = true;
      track('form_start', { form_name: 'quote_request' });
    };

    form.addEventListener('focusin', startForm, { once: true });
    form.addEventListener('input', (event) => {
      startForm();
      if (event.target.matches('input, select, textarea')) event.target.classList.remove('is-invalid');
      setFormStatus('');
    });

    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const requiredFields = [...form.querySelectorAll('[required]')];
      requiredFields.forEach((field) => field.classList.toggle('is-invalid', !field.checkValidity()));

      if (!form.checkValidity()) {
        setFormStatus('Please complete the required fields before submitting.', 'error');
        track('form_error', { form_name: 'quote_request', error_type: 'validation' });
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      if (!config.ajaxUrl || !config.leadNonce || !config.leadAction) {
        setFormStatus('The form service is not configured. Please contact the ChemVenture team directly.', 'error');
        return;
      }

      fillAttributionFields();
      const formData = new FormData(form);
      formData.append('action', config.leadAction);
      formData.append('nonce', config.leadNonce);

      setSubmitState(true);
      setFormStatus('');

      try {
        const response = await fetch(config.ajaxUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });

        const payload = await response.json();
        const message = payload?.data?.message || 'We could not submit your request right now.';

        if (!response.ok || !payload.success) {
          throw new Error(message);
        }

        formSubmitted = true;
        setFormStatus(message, 'success');
        track('form_submit', {
          form_name: 'quote_request',
          product_name: productSelect ? productSelect.value : '',
          utm_source: attribution.utm_source || '',
          utm_medium: attribution.utm_medium || '',
          utm_campaign: attribution.utm_campaign || '',
        });

        form.reset();
        fillAttributionFields();
      } catch (error) {
        setFormStatus(error.message || 'We could not submit your request right now. Please try again.', 'error');
        track('form_error', { form_name: 'quote_request', error_type: 'submission' });
      } finally {
        setSubmitState(false);
      }
    });

    window.addEventListener('pagehide', () => {
      if (formStarted && !formSubmitted) {
        track('form_abandon', { form_name: 'quote_request' });
      }
    });
  }

  const scrollThresholds = [25, 50, 75];
  const reachedThresholds = new Set();
  const trackScrollDepth = () => {
    const documentHeight = Math.max(document.documentElement.scrollHeight - window.innerHeight, 1);
    const percent = Math.min(100, Math.round((window.scrollY / documentHeight) * 100));
    scrollThresholds.forEach((threshold) => {
      if (percent >= threshold && !reachedThresholds.has(threshold)) {
        reachedThresholds.add(threshold);
        track('scroll_depth', { scroll_percent: threshold });
      }
    });
  };

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const revealItems = [...document.querySelectorAll('[data-reveal]')];

  if (reducedMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach((item) => item.classList.add('is-visible'));
  } else {
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });
    revealItems.forEach((item) => revealObserver.observe(item));
  }

  const navLinks = [...document.querySelectorAll('.cv-nav__list a[href*="#"]')];
  const sections = [...document.querySelectorAll('[data-section][id]')];

  if ('IntersectionObserver' in window && navLinks.length && sections.length) {
    const sectionObserver = new IntersectionObserver((entries) => {
      const visible = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (!visible) return;
      const hash = `#${visible.target.id}`;
      navLinks.forEach((link) => {
        const linkHash = new URL(link.href, window.location.href).hash;
        link.classList.toggle('is-active', linkHash === hash);
      });
    }, { rootMargin: '-30% 0px -58% 0px', threshold: [0.01, 0.2, 0.5] });
    sections.forEach((section) => sectionObserver.observe(section));
  }

  updateHeader();
  trackScrollDepth();
  window.addEventListener('scroll', () => {
    updateHeader();
    trackScrollDepth();
  }, { passive: true });
})();
