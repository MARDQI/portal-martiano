/**
 * Portal Martiano — Infinite Scroll
 *
 * Carga más contenido automáticamente usando Intersection Observer + AJAX.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

(function () {
    'use strict';

    // Verificar que las variables AJAX están disponibles
    if (typeof cmAjax === 'undefined') return;

    /**
     * Iniciralizar infinite scroll para un contenedor.
     *
     * @param {string} containerSelector - Selector del contenedor de posts.
     * @param {string} postType          - Tipo de post ('noticia', 'evento', etc.).
     * @param {number} perPage           - Posts por carga.
     */
    function initInfiniteScroll(containerSelector, postType, perPage) {
        const container = document.querySelector(containerSelector);
        if (!container) return;

        let currentPage = 1;
        let isLoading = false;
        let hasMore = true;

        // Crear sentinel (elemento invisible al final del contenedor)
        const sentinel = document.createElement('div');
        sentinel.className = 'cm-infinite-scroll-sentinel';
        container.parentNode.insertBefore(sentinel, container.nextSibling);

        // Crear indicador de carga
        const loader = document.createElement('div');
        loader.className = 'cm-infinite-scroll-loading';
        loader.innerHTML = '<div class="cm-loading__spinner"></div>';
        loader.style.display = 'none';
        container.parentNode.insertBefore(loader, sentinel);

        /**
         * Cargar más posts vía AJAX.
         */
        function loadMore() {
            if (isLoading || !hasMore) return;

            isLoading = true;
            loader.style.display = 'block';
            currentPage++;

            const formData = new FormData();
            formData.append('action', 'cm_load_more');
            formData.append('nonce', cmAjax.nonce);
            formData.append('page', currentPage);
            formData.append('post_type', postType);
            formData.append('per_page', perPage);

            fetch(cmAjax.ajaxurl, {
                method: 'POST',
                body: formData,
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.success && data.data.html) {
                        // Insertar el nuevo HTML
                        const temp = document.createElement('div');
                        temp.innerHTML = data.data.html;
                        while (temp.firstChild) {
                            container.appendChild(temp.firstChild);
                        }
                        hasMore = data.data.has_more;
                    } else {
                        hasMore = false;
                    }
                })
                .catch(function (error) {
                    console.error('Error cargando más contenido:', error);
                    hasMore = false;
                })
                .finally(function () {
                    isLoading = false;
                    loader.style.display = 'none';

                    if (!hasMore) {
                        sentinel.remove();
                        loader.remove();
                    }
                });
        }

        // Intersection Observer
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            loadMore();
                        }
                    });
                },
                {
                    rootMargin: '200px',
                    threshold: 0,
                }
            );
            observer.observe(sentinel);
        } else {
            // Fallback: cargar con scroll event
            window.addEventListener('scroll', function () {
                const rect = sentinel.getBoundingClientRect();
                if (rect.top <= window.innerHeight + 200) {
                    loadMore();
                }
            });
        }
    }

    // ─── Inicializar al cargar la página ───
    document.addEventListener('DOMContentLoaded', function () {
        // Infinite scroll para la sección de noticias en el home
        initInfiniteScroll('.cm-noticias-list', 'noticia', 3);
    });

    // Exponer para uso externo si se necesita
    window.cmInfiniteScroll = { init: initInfiniteScroll };

})();
