/**
 * Portal Martiano — Script Principal
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

(function () {
    'use strict';

    // ─── Menú Responsive (Hamburguesa) ───
    const menuToggle = document.querySelector('.cm-menu-toggle');
    const nav = document.querySelector('.cm-nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function () {
            nav.classList.toggle('cm-nav--open');
            this.classList.toggle('cm-menu-toggle--active');
            this.setAttribute(
                'aria-expanded',
                this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
            );
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function (e) {
            if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
                nav.classList.remove('cm-nav--open');
                menuToggle.classList.remove('cm-menu-toggle--active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Cerrar menú al redimensionar
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                nav.classList.remove('cm-nav--open');
                menuToggle.classList.remove('cm-menu-toggle--active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ─── Scroll suave para links internos ───
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ─── Header sticky con sombra al hacer scroll ───
    const header = document.querySelector('.cm-header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', function () {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 10) {
                header.classList.add('cm-header--scrolled');
            } else {
                header.classList.remove('cm-header--scrolled');
            }
            lastScroll = currentScroll;
        });
    }

    // ─── Búsqueda: expandir input al enfocar ───
    const searchInput = document.querySelector('.cm-search-form__input');
    if (searchInput) {
        searchInput.addEventListener('focus', function () {
            this.parentElement.classList.add('cm-search-form--focused');
        });
        searchInput.addEventListener('blur', function () {
            this.parentElement.classList.remove('cm-search-form--focused');
        });
    }

})();
