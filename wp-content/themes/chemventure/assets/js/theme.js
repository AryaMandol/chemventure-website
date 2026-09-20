(() => {
  const header = document.querySelector('[data-cv-header]');
  const toggle = document.querySelector('[data-cv-menu-toggle]');
  const menu = document.querySelector('[data-cv-mobile-menu]');
  const form = document.querySelector('[data-demo-form]');
  const formStatus = document.querySelector('[data-form-status]');
  const productSelect = document.querySelector('[data-product-select]');
  const resourceStatus = document.querySelector('[data-resource-status]');

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

  document.querySelectorAll('[data-product-link]').forEach((link) => {
    link.addEventListener('click', () => {
      if (productSelect) productSelect.value = link.dataset.productLink || '';
    });
  });

  document.querySelectorAll('[data-resource]').forEach((button) => {
    button.addEventListener('click', () => {
      if (resourceStatus) {
        resourceStatus.textContent = 'This resource is not linked yet. Add the approved PDF URL in Appearance → Customize → ChemVenture Homepage → Technical Resources.';
      }
    });
  });

  if (form) {
    form.addEventListener('input', (event) => {
      if (event.target.matches('input, select, textarea')) event.target.classList.remove('is-invalid');
      if (formStatus) {
        formStatus.textContent = '';
        formStatus.classList.remove('is-error');
      }
    });

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const requiredFields = [...form.querySelectorAll('[required]')];
      requiredFields.forEach((field) => field.classList.toggle('is-invalid', !field.checkValidity()));

      if (!form.checkValidity()) {
        if (formStatus) {
          formStatus.textContent = 'Please complete the required fields before submitting.';
          formStatus.classList.add('is-error');
        }
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      if (formStatus) {
        formStatus.textContent = 'Form delivery will be connected during CV-04. The current form is a front-end prototype.';
        formStatus.classList.remove('is-error');
      }
    });
  }

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
  window.addEventListener('scroll', updateHeader, { passive: true });
})();
