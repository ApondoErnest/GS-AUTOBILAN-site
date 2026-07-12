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

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileMenu);
} else {
    initMobileMenu();
}
