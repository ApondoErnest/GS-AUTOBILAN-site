/**
 * Frontend entry (Vite).
 * Alpine.js is provided by Livewire — do not import a second Alpine instance here.
 */

const initMobileMenu = () => {
    const menu = document.getElementById('gs-mobile-menu');

    if (!menu) {
        return;
    }

    const openButtons = document.querySelectorAll('[data-mobile-menu-open]');
    const closeButtons = menu.querySelectorAll('[data-mobile-menu-close]');
    const menuLinks = menu.querySelectorAll('[data-mobile-menu-link]');
    const focusableSelector = 'a[href], button:not([disabled])';
    let lastFocusedElement = null;

    const setExpanded = (expanded) => {
        openButtons.forEach((button) => {
            button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    };

    const getFocusableElements = () => [...menu.querySelectorAll(focusableSelector)]
        .filter((element) => element.offsetParent !== null);

    const openMenu = () => {
        lastFocusedElement = document.activeElement;
        menu.classList.remove('hidden');
        menu.setAttribute('aria-hidden', 'false');
        setExpanded(true);
        document.body.style.overflow = 'hidden';

        window.setTimeout(() => {
            const initialFocusElement = menu.querySelector('[data-mobile-menu-initial-focus]');

            if (initialFocusElement instanceof HTMLElement) {
                initialFocusElement.focus();
                return;
            }

            getFocusableElements()[0]?.focus();
        }, 0);
    };

    const closeMenu = () => {
        menu.classList.add('hidden');
        menu.setAttribute('aria-hidden', 'true');
        setExpanded(false);
        document.body.style.overflow = '';

        if (lastFocusedElement instanceof HTMLElement) {
            lastFocusedElement.focus();
        }
    };

    openButtons.forEach((button) => {
        button.addEventListener('click', openMenu);
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeMenu);
    });

    menuLinks.forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', (event) => {
        if (menu.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape') {
            closeMenu();
            return;
        }

        if (event.key !== 'Tab') {
            return;
        }

        const focusableElements = getFocusableElements();
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (!firstElement || !lastElement) {
            return;
        }

        if (event.shiftKey && document.activeElement === firstElement) {
            event.preventDefault();
            lastElement.focus();
        }

        if (!event.shiftKey && document.activeElement === lastElement) {
            event.preventDefault();
            firstElement.focus();
        }
    });
};

const initHeroCarousels = () => {
    const carousels = document.querySelectorAll('[data-hero-carousel]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    carousels.forEach((carousel) => {
        const slides = [...carousel.querySelectorAll('[data-hero-slide]')];

        if (slides.length < 2 || reduceMotion) {
            return;
        }

        let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));

        if (activeIndex < 0) {
            activeIndex = 0;
            slides[activeIndex].classList.add('is-active');
        }

        window.setInterval(() => {
            const nextIndex = (activeIndex + 1) % slides.length;

            slides[activeIndex].classList.remove('is-active');
            slides[nextIndex].classList.add('is-active');
            activeIndex = nextIndex;
        }, 5000);
    });
};

const initAgencyMaps = () => {
    document.querySelectorAll('[data-agency-map]').forEach((map) => {
        const frame = map.querySelector('[data-agency-map-frame]');
        const zoomIn = map.querySelector('[data-agency-map-zoom-in]');
        const zoomOut = map.querySelector('[data-agency-map-zoom-out]');

        if (!(frame instanceof HTMLIFrameElement) || !zoomIn || !zoomOut) {
            return;
        }

        let zoom = Number.parseInt(map.getAttribute('data-map-zoom') || '16', 10);

        const setZoom = (nextZoom) => {
            zoom = Math.min(20, Math.max(10, nextZoom));
            map.setAttribute('data-map-zoom', String(zoom));

            const url = new URL(frame.src);
            url.searchParams.set('z', String(zoom));
            frame.src = url.toString();
        };

        zoomIn.addEventListener('click', () => setZoom(zoom + 1));
        zoomOut.addEventListener('click', () => setZoom(zoom - 1));
    });
};

const initFrontend = () => {
    initMobileMenu();
    initHeroCarousels();
    initAgencyMaps();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFrontend);
} else {
    initFrontend();
}
