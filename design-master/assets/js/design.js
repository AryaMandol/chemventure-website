(() => {
  const header = document.querySelector('[data-header]');
  const menuToggle = document.querySelector('[data-menu-toggle]');
  const mobileMenu = document.querySelector('[data-mobile-menu]');
  const form = document.querySelector('[data-demo-form]');
  const formStatus = document.querySelector('[data-form-status]');
  const resourceStatus = document.querySelector('[data-resource-status]');
  const productSelect = document.querySelector('[data-product-select]');
  const navLinks = [...document.querySelectorAll('[data-nav-link]')];
  const sections = [...document.querySelectorAll('[data-section]')];

  const applyImageFallbacks = () => {
    document.querySelectorAll('img[data-fallback]').forEach((img) => {
      img.addEventListener('error', () => {
        const fallback = img.dataset.fallback;
        if (!fallback || img.dataset.fallbackApplied === 'true') return;
        img.dataset.fallbackApplied = 'true';
        img.src = fallback;
      }, { once: true });
    });
  };

  const setHeaderState = () => {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 8);
  };

  const closeMenu = () => {
    if (!menuToggle || !mobileMenu) return;
    mobileMenu.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');
  };

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      const open = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!open));
      mobileMenu.classList.toggle('is-open', !open);
    });

    mobileMenu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') closeMenu();
    });
  }

  document.querySelectorAll('[data-product-link]').forEach((link) => {
    link.addEventListener('click', () => {
      if (productSelect) productSelect.value = link.dataset.productLink || '';
    });
  });

  document.querySelectorAll('[data-resource]').forEach((button) => {
    button.addEventListener('click', () => {
      if (resourceStatus) resourceStatus.textContent = 'Prototype only. The final PDF will be linked from WordPress Media after client confirmation.';
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
        formStatus.textContent = 'Prototype only. Form delivery will be connected during the WordPress lead-generation stage.';
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

  if ('IntersectionObserver' in window && navLinks.length && sections.length) {
    const sectionObserver = new IntersectionObserver((entries) => {
      const visible = entries
        .filter((entry) => entry.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (!visible) return;

      const id = visible.target.id;
      navLinks.forEach((link) => {
        link.classList.toggle('is-active', link.getAttribute('href') === `#${id}`);
      });
    }, { rootMargin: '-30% 0px -58% 0px', threshold: [0.01, 0.2, 0.5] });

    sections.forEach((section) => {
      if (section.id) sectionObserver.observe(section);
    });
  }

  applyImageFallbacks();
  setHeaderState();
  window.addEventListener('scroll', setHeaderState, { passive: true });
})();
