(() => {
  const header = document.querySelector('[data-header]');
  const menuToggle = document.querySelector('[data-menu-toggle]');
  const mobileMenu = document.querySelector('[data-mobile-menu]');
  const form = document.querySelector('[data-demo-form]');
  const formStatus = document.querySelector('[data-form-status]');
  const resourceStatus = document.querySelector('[data-resource-status]');
  const productSelect = document.querySelector('[data-product-select]');

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

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      const open = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!open));
      mobileMenu.classList.toggle('is-open', !open);
    });

    mobileMenu.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('is-open');
        menuToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  document.querySelectorAll('[data-product-link]').forEach((link) => {
    link.addEventListener('click', () => {
      if (productSelect) productSelect.value = link.dataset.productLink || '';
    });
  });

  document.querySelectorAll('[data-resource]').forEach((button) => {
    button.addEventListener('click', () => {
      if (resourceStatus) {
        resourceStatus.textContent = 'Prototype only. The final PDF will be linked from WordPress Media after client confirmation.';
      }
    });
  });

  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!form.reportValidity()) return;
      if (formStatus) {
        formStatus.textContent = 'Prototype only. Form delivery will be connected during the WordPress lead-generation stage.';
      }
    });
  }

  applyImageFallbacks();
  setHeaderState();
  window.addEventListener('scroll', setHeaderState, { passive: true });
})();
