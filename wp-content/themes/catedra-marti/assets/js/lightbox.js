/**
 * Lightbox para la Galería de Imágenes
 *
 * @package CatedraMarti
 * @since   1.0.0
 */
(function () {
    'use strict';

    const lightbox = document.getElementById('cmLightbox');
    if (!lightbox) return;

    const img     = lightbox.querySelector('.cm-lightbox__img');
    const caption = lightbox.querySelector('.cm-lightbox__caption');
    const btnClose = lightbox.querySelector('.cm-lightbox__close');
    const btnPrev  = lightbox.querySelector('.cm-lightbox__prev');
    const btnNext  = lightbox.querySelector('.cm-lightbox__next');

    const links = Array.from(document.querySelectorAll('.cm-gallery-page__link'));
    let currentIndex = 0;

    function open(index) {
        currentIndex = index;
        const link = links[index];
        img.src = link.href;
        img.alt = link.dataset.caption || '';
        caption.textContent = link.dataset.caption || '';
        lightbox.classList.add('is-active');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.remove('is-active');
        document.body.style.overflow = '';
        img.src = '';
    }

    function prev() {
        currentIndex = (currentIndex - 1 + links.length) % links.length;
        open(currentIndex);
    }

    function next() {
        currentIndex = (currentIndex + 1) % links.length;
        open(currentIndex);
    }

    // Click en each imagen
    links.forEach(function (link, i) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            open(i);
        });
    });

    btnClose.addEventListener('click', close);
    btnPrev.addEventListener('click', prev);
    btnNext.addEventListener('click', next);

    // Click fuera de la imagen cierra
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox || e.target === lightbox.querySelector('.cm-lightbox__content')) {
            close();
        }
    });

    // Teclado
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('is-active')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') prev();
        if (e.key === 'ArrowRight') next();
    });
})();
