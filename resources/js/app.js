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

const initBackToTop = () => {
    const button = document.querySelector('[data-back-to-top]');
    const header = document.querySelector('.gs-header');

    if (!(button instanceof HTMLButtonElement) || !(header instanceof HTMLElement)) {
        return;
    }

    const mobileQuery = window.matchMedia('(max-width: 1023px)');
    const reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    let ticking = false;

    const getHeaderEnd = () => header.offsetTop + header.offsetHeight;

    const setVisible = (isVisible) => {
        button.classList.toggle('is-visible', isVisible);
        button.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
        button.tabIndex = isVisible ? 0 : -1;
    };

    const updateVisibility = () => {
        const shouldShow = mobileQuery.matches && window.scrollY > getHeaderEnd();

        setVisible(shouldShow);
        ticking = false;
    };

    const requestVisibilityUpdate = () => {
        if (ticking) {
            return;
        }

        ticking = true;
        window.requestAnimationFrame(updateVisibility);
    };

    button.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: reduceMotionQuery.matches ? 'auto' : 'smooth',
        });
    });

    window.addEventListener('scroll', requestVisibilityUpdate, { passive: true });
    window.addEventListener('resize', requestVisibilityUpdate);
    mobileQuery.addEventListener('change', requestVisibilityUpdate);
    updateVisibility();
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

const initContactMessageForms = () => {
    document.querySelectorAll('[data-contact-message-form]').forEach((form) => {
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        const status = form.querySelector('[data-contact-form-status]');
        const submitButton = form.querySelector('button[type="submit"]');
        const submitLabel = submitButton?.querySelector('span');
        const defaultSubmitText = submitLabel?.textContent || '';
        const baseStatusClass = status?.getAttribute('data-contact-status-base-class') || '';
        const successClass = status?.getAttribute('data-contact-success-class') || '';
        const errorClass = status?.getAttribute('data-contact-error-class') || '';
        const fallbackError = status?.getAttribute('data-contact-error-message') || 'Unable to send the message.';

        const showStatus = (message, type) => {
            if (!(status instanceof HTMLElement)) {
                return;
            }

            status.className = `${baseStatusClass} ${type === 'success' ? successClass : errorClass}`;
            status.textContent = message;
            status.setAttribute('role', type === 'success' ? 'status' : 'alert');
            status.focus({ preventScroll: true });
        };

        const setSubmitting = (isSubmitting) => {
            form.setAttribute('aria-busy', isSubmitting ? 'true' : 'false');

            if (submitButton instanceof HTMLButtonElement) {
                submitButton.disabled = isSubmitting;
                submitButton.classList.toggle('opacity-70', isSubmitting);
                submitButton.classList.toggle('cursor-wait', isSubmitting);
            }

            if (submitLabel) {
                submitLabel.textContent = isSubmitting ? `${defaultSubmitText}...` : defaultSubmitText;
            }
        };

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!form.reportValidity()) {
                return;
            }

            setSubmitting(true);

            try {
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    body: new FormData(form),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const validationMessage = payload?.message || Object.values(payload?.errors || {})[0]?.[0];
                    showStatus(validationMessage || fallbackError, 'error');
                    return;
                }

                showStatus(payload?.message || defaultSubmitText, 'success');
                form.reset();
            } catch (error) {
                showStatus(fallbackError, 'error');
            } finally {
                setSubmitting(false);
            }
        });
    });
};

const initBookingIntakes = () => {
    document.querySelectorAll('[data-booking-intake]').forEach((root) => {
        const form = root.querySelector('[data-booking-form]');

        if (root.hasAttribute('data-booking-confirmed')) {
            return;
        }

        const mobileTicket = root.querySelector('[data-booking-mobile-ticket]');
        const mobileTicketToggles = root.querySelectorAll('[data-booking-mobile-ticket-toggle]');
        const mobileTicketChevrons = root.querySelectorAll('[data-booking-mobile-ticket-chevron]');
        const emptyValue = root.getAttribute('data-ticket-empty') || root.querySelector('[data-ticket-field]')?.textContent?.trim() || 'A renseigner';
        const panels = [...root.querySelectorAll('[data-booking-step-panel]')];
        const triggers = [...root.querySelectorAll('[data-booking-step-trigger]')];
        const closedWarning = root.querySelector('[data-closed-warning]');
        const periodOptions = [...root.querySelectorAll('[data-period-option]')];
        const datePicker = root.querySelector('[data-booking-date-picker]');
        const dateField = form?.querySelector('[name="preferred_date"]');
        const dateDisplay = root.querySelector('[data-booking-date-display]');
        const dateLabel = root.querySelector('[data-booking-date-label]');
        const calendar = root.querySelector('[data-booking-calendar]');
        const calendarTitle = root.querySelector('[data-calendar-title]');
        const calendarGrid = root.querySelector('[data-calendar-grid]');
        const calendarWeekdays = root.querySelector('[data-calendar-weekdays]');
        const calendarPrev = root.querySelector('[data-calendar-prev]');
        const calendarNext = root.querySelector('[data-calendar-next]');
        const calendarToday = root.querySelector('[data-calendar-today]');
        const calendarClear = root.querySelector('[data-calendar-clear]');
        const calendarLocale = datePicker?.getAttribute('data-calendar-locale') || document.documentElement.lang || 'fr-FR';
        const calendarPlaceholder = datePicker?.getAttribute('data-calendar-placeholder') || emptyValue;
        const calendarClosedLabel = datePicker?.getAttribute('data-calendar-closed-label') || 'Closed';
        const parseDate = (value) => {
            const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value || '');

            if (!match) {
                return null;
            }

            return new Date(Number(match[1]), Number(match[2]) - 1, Number(match[3]), 12);
        };
        const formatDateValue = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        const minCalendarDate = parseDate(datePicker?.getAttribute('data-min-date')) || new Date();
        let activeCalendarMonth = parseDate(dateField?.value) || new Date(minCalendarDate.getFullYear(), minCalendarDate.getMonth(), 1, 12);
        let activeStep = 1;

        const selectedChoiceClasses = ['border-gs-primary', 'bg-gs-soft', 'shadow-md', 'shadow-gs-primary/10'];
        const unselectedChoiceClasses = ['border-gs-concrete', 'bg-white', 'shadow-sm', 'shadow-gs-navy/5'];
        const invalidChoiceClasses = ['ring-2', 'ring-gs-danger/40', 'border-gs-danger', 'bg-red-50'];
        const invalidFieldClasses = ['border-gs-danger', 'ring-2', 'ring-gs-danger/30', 'bg-red-50'];

        const getSelectedInput = (name) => form?.querySelector(`input[name="${name}"]:checked`) || null;
        const getSelectedAgencySlug = () => getSelectedInput('agency')?.dataset.agencySlug || '';
        const getDayStart = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
        const getMonthStart = (date) => new Date(date.getFullYear(), date.getMonth(), 1, 12);
        const dateSummaryFormatter = new Intl.DateTimeFormat(calendarLocale, {
            weekday: 'short',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
        const calendarMonthFormatter = new Intl.DateTimeFormat(calendarLocale, {
            month: 'long',
            year: 'numeric',
        });
        const weekdayFormatter = new Intl.DateTimeFormat(calendarLocale, { weekday: 'short' });
        const isClosedDate = (date) => getSelectedAgencySlug() === 'nkolbisson' && date.getDay() === 0;
        const isDateDisabled = (date) => getDayStart(date) < getDayStart(minCalendarDate) || isClosedDate(date);
        const setDateValue = (date) => {
            if (!(dateField instanceof HTMLInputElement)) {
                return;
            }

            const value = formatDateValue(date);
            const label = dateSummaryFormatter.format(date);
            dateField.value = value;
            dateField.dataset.summaryLabel = label;
            if (dateLabel) {
                dateLabel.textContent = label;
                dateLabel.classList.remove('text-gs-grey');
                dateLabel.classList.add('text-gs-ink');
            }
            activeCalendarMonth = getMonthStart(date);
            dateField.dispatchEvent(new Event('input', { bubbles: true }));
            dateField.dispatchEvent(new Event('change', { bubbles: true }));
        };
        const clearDateValue = () => {
            if (!(dateField instanceof HTMLInputElement)) {
                return;
            }

            dateField.value = '';
            delete dateField.dataset.summaryLabel;
            if (dateLabel) {
                dateLabel.textContent = calendarPlaceholder;
                dateLabel.classList.add('text-gs-grey');
                dateLabel.classList.remove('text-gs-ink');
            }
            dateField.dispatchEvent(new Event('input', { bubbles: true }));
            dateField.dispatchEvent(new Event('change', { bubbles: true }));
        };
        const closeCalendar = () => {
            calendar?.classList.add('hidden');
            dateDisplay?.setAttribute('aria-expanded', 'false');
        };
        const renderCalendar = () => {
            if (!calendarGrid || !calendarTitle || !calendarWeekdays) {
                return;
            }

            const selectedDate = parseDate(dateField?.value);
            const minMonth = getMonthStart(minCalendarDate);
            activeCalendarMonth = activeCalendarMonth < minMonth ? minMonth : activeCalendarMonth;

            calendarTitle.textContent = calendarMonthFormatter.format(activeCalendarMonth);
            calendarWeekdays.innerHTML = '';

            for (let dayIndex = 0; dayIndex < 7; dayIndex += 1) {
                const weekdayDate = new Date(2026, 6, 12 + dayIndex, 12);
                const weekday = document.createElement('span');
                weekday.textContent = weekdayFormatter.format(weekdayDate).replace('.', '');
                weekday.className = dayIndex === 0 ? 'text-gs-danger' : '';
                calendarWeekdays.appendChild(weekday);
            }

            calendarGrid.innerHTML = '';
            const firstOfMonth = getMonthStart(activeCalendarMonth);
            const startDate = new Date(firstOfMonth);
            startDate.setDate(firstOfMonth.getDate() - firstOfMonth.getDay());

            for (let dayIndex = 0; dayIndex < 42; dayIndex += 1) {
                const cellDate = new Date(startDate);
                cellDate.setDate(startDate.getDate() + dayIndex);

                const sameMonth = cellDate.getMonth() === activeCalendarMonth.getMonth();
                const selected = selectedDate && formatDateValue(selectedDate) === formatDateValue(cellDate);
                const today = formatDateValue(new Date()) === formatDateValue(cellDate);
                const closed = isClosedDate(cellDate);
                const disabled = isDateDisabled(cellDate);
                const button = document.createElement('button');

                button.type = 'button';
                button.textContent = String(cellDate.getDate());
                button.disabled = disabled;
                button.className = [
                    'inline-flex',
                    'h-8',
                    'min-w-0',
                    'items-center',
                    'justify-center',
                    'rounded-md',
                    'text-xs',
                    'font-black',
                    'transition',
                    'focus:outline-none',
                    'focus:ring-2',
                    'focus:ring-gs-primary/30',
                    'sm:h-9',
                    'sm:text-sm',
                    selected ? 'bg-gs-primary text-white shadow-md shadow-gs-primary/20' : '',
                    !selected && sameMonth ? 'bg-white text-gs-ink hover:bg-gs-soft hover:text-gs-primary' : '',
                    !selected && !sameMonth ? 'bg-gs-soft/60 text-gs-grey hover:bg-gs-soft hover:text-gs-primary' : '',
                    !selected && today ? 'ring-1 ring-gs-primary/45 text-gs-primary' : '',
                    !selected && cellDate.getDay() === 0 ? 'text-gs-danger' : '',
                    disabled ? 'cursor-not-allowed bg-gs-concrete/40 text-gs-grey/45 line-through hover:bg-gs-concrete/40 hover:text-gs-grey/45' : '',
                ].filter(Boolean).join(' ');
                button.setAttribute('aria-label', `${dateSummaryFormatter.format(cellDate)}${closed ? `, ${calendarClosedLabel}` : ''}`);

                button.addEventListener('click', () => {
                    if (disabled) {
                        return;
                    }

                    setDateValue(cellDate);
                    closeCalendar();
                    renderCalendar();
                });

                calendarGrid.appendChild(button);
            }

            if (calendarPrev instanceof HTMLButtonElement) {
                calendarPrev.disabled = getMonthStart(activeCalendarMonth) <= minMonth;
            }

            if (calendarToday instanceof HTMLButtonElement) {
                const today = new Date();
                calendarToday.disabled = isDateDisabled(today);
            }
        };
        const openCalendar = () => {
            renderCalendar();
            calendar?.classList.remove('hidden');
            dateDisplay?.setAttribute('aria-expanded', 'true');
        };

        const getTicketValue = (field) => {
            if (field === 'agency') {
                return getSelectedInput('agency')?.dataset.summaryLabel || emptyValue;
            }

            if (field === 'service') {
                return getSelectedInput('service_type')?.dataset.summaryLabel || emptyValue;
            }

            if (field === 'vehicle') {
                return getSelectedInput('vehicle_category')?.dataset.summaryLabel || emptyValue;
            }

            if (field === 'registration') {
                const registration = form?.querySelector('[name="vehicle_registration"]')?.value?.trim();
                return registration ? registration.toUpperCase() : emptyValue;
            }

            if (field === 'date') {
                const dateInput = form?.querySelector('[name="preferred_date"]');
                return dateInput?.dataset.summaryLabel || dateInput?.value || emptyValue;
            }

            if (field === 'period') {
                return getSelectedInput('preferred_time_slot')?.dataset.summaryLabel || emptyValue;
            }

            if (field === 'contact') {
                return getSelectedInput('contact_mode')?.dataset.summaryLabel || emptyValue;
            }

            return emptyValue;
        };

        const updateTextTargets = (selector, value) => {
            root.querySelectorAll(selector).forEach((target) => {
                target.textContent = value;
            });
        };

        const updateChoiceCards = () => {
            root.querySelectorAll('[data-choice-card]').forEach((card) => {
                const input = card.querySelector('input');
                const band = card.querySelector('[data-choice-band]');
                const check = card.querySelector('[data-choice-check]');
                const selectedLabel = card.querySelector('[data-selected-label]');
                const isSelected = input instanceof HTMLInputElement && input.checked;
                const isInvalid = invalidChoiceClasses.some((className) => card.classList.contains(className));

                card.classList.toggle('ring-2', isSelected || isInvalid);
                card.classList.toggle('ring-gs-primary/20', isSelected && !isInvalid);
                selectedChoiceClasses.forEach((className) => card.classList.toggle(className, isSelected && !isInvalid));
                unselectedChoiceClasses.forEach((className) => card.classList.toggle(className, !isSelected && !isInvalid));
                band?.classList.toggle('hidden', !isSelected);
                check?.classList.toggle('hidden', !isSelected);
                selectedLabel?.classList.toggle('hidden', !isSelected);
                selectedLabel?.classList.toggle('inline-flex', isSelected);
            });
        };

        const clearInvalidState = (scope = root) => {
            scope.querySelectorAll('[data-choice-card]').forEach((card) => {
                invalidChoiceClasses.forEach((className) => card.classList.remove(className));
            });

            scope.querySelectorAll('input, select, textarea, [data-booking-date-display]').forEach((control) => {
                invalidFieldClasses.forEach((className) => control.classList.remove(className));
            });

            scope.querySelectorAll('[data-booking-invalid-label]').forEach((label) => {
                invalidChoiceClasses.forEach((className) => label.classList.remove(className));
                label.removeAttribute('data-booking-invalid-label');
            });

            updateChoiceCards();
        };

        const markInvalidControl = (control) => {
            if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement)) {
                return null;
            }

            if (control.type === 'radio') {
                const group = form ? [...form.querySelectorAll(`input[name="${control.name}"]`)] : [control];
                let firstCard = null;

                group.forEach((input) => {
                    const card = input.closest('[data-choice-card]');

                    if (!card) {
                        return;
                    }

                    firstCard ??= card;
                    invalidChoiceClasses.forEach((className) => card.classList.add(className));
                });

                return firstCard;
            }

            if (control.type === 'checkbox') {
                const label = control.closest('label') || control;
                invalidChoiceClasses.forEach((className) => label.classList.add(className));
                label.setAttribute('data-booking-invalid-label', '');

                return label;
            }

            if (control.name === 'preferred_date') {
                invalidFieldClasses.forEach((className) => dateDisplay?.classList.add(className));

                return dateDisplay;
            }

            invalidFieldClasses.forEach((className) => control.classList.add(className));

            return control;
        };

        const focusInvalidTarget = (target) => {
            if (!(target instanceof HTMLElement)) {
                return;
            }

            target.scrollIntoView({ behavior: 'smooth', block: 'center' });

            window.setTimeout(() => {
                if (target === dateDisplay) {
                    dateDisplay?.focus();
                    return;
                }

                const focusable = target.matches('input, select, textarea, button, a[href]')
                    ? target
                    : target.querySelector('input, select, textarea, button, a[href]');

                if (focusable instanceof HTMLElement) {
                    focusable.focus({ preventScroll: true });
                }
            }, 120);
        };

        const controlIsMissing = (control) => {
            if (control instanceof HTMLInputElement && control.type === 'radio') {
                return !getSelectedInput(control.name);
            }

            if (control instanceof HTMLInputElement && control.type === 'checkbox') {
                return !control.checked;
            }

            if (control instanceof HTMLInputElement && control.name === 'preferred_date') {
                const selectedDate = parseDate(control.value);

                return !selectedDate || isDateDisabled(selectedDate);
            }

            return !String(control.value || '').trim();
        };

        const validateStep = (step, shouldFocus = true) => {
            const panel = root.querySelector(`[data-booking-step-panel="${step}"]`);

            if (!panel) {
                return true;
            }

            clearInvalidState(panel);

            const checkedGroups = new Set();
            let firstInvalidTarget = null;

            panel.querySelectorAll('input[required], select[required], textarea[required]').forEach((control) => {
                if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement)) {
                    return;
                }

                if (control instanceof HTMLInputElement && control.type === 'radio') {
                    if (checkedGroups.has(control.name)) {
                        return;
                    }

                    checkedGroups.add(control.name);
                }

                if (controlIsMissing(control)) {
                    firstInvalidTarget ??= markInvalidControl(control);
                }
            });

            if (firstInvalidTarget) {
                if (shouldFocus) {
                    focusInvalidTarget(firstInvalidTarget);
                }

                return false;
            }

            return true;
        };

        const updateTicket = () => {
            ['agency', 'service', 'vehicle', 'registration', 'date', 'period', 'contact'].forEach((field) => {
                const value = getTicketValue(field);
                updateTextTargets(`[data-ticket-field="${field}"]`, value);
                updateTextTargets(`[data-review-field="${field}"]`, value);
                updateTextTargets(`[data-receipt-field="${field}"]`, value);

                root.querySelectorAll(`[data-ticket-check="${field}"]`).forEach((check) => {
                    check.classList.toggle('hidden', value === emptyValue);
                });
            });
        };

        const updatePeriods = () => {
            const agency = getSelectedAgencySlug();
            const dateValue = form?.querySelector('[name="preferred_date"]')?.value;
            const selectedDate = parseDate(dateValue);
            const isSunday = selectedDate?.getDay() === 0;
            const nkolbissonSunday = agency === 'nkolbisson' && isSunday;
            const obiliSunday = agency === 'obili-scalom' && isSunday;

            closedWarning?.classList.toggle('hidden', !nkolbissonSunday);

            periodOptions.forEach((option) => {
                const input = option.querySelector('input');
                const time = option.querySelector('[data-period-time]');

                if (!(input instanceof HTMLInputElement)) {
                    return;
                }

                const nextTime = obiliSunday
                    ? time?.getAttribute('data-obili-sunday-time')
                    : time?.getAttribute('data-default-time');
                const label = option.querySelector('.text-gs-primary')?.textContent?.trim();

                if (time && nextTime) {
                    time.textContent = nextTime;
                }

                if (label && nextTime) {
                    input.value = `${label} — ${nextTime}`;
                    input.dataset.summaryLabel = `${label} — ${nextTime}`;
                }

                input.disabled = nkolbissonSunday;
                option.classList.toggle('opacity-45', nkolbissonSunday);
                option.classList.toggle('pointer-events-none', nkolbissonSunday);

                if (nkolbissonSunday) {
                    input.checked = false;
                }
            });

            renderCalendar();
        };

        const setStep = (nextStep) => {
            activeStep = Math.min(3, Math.max(1, nextStep));

            panels.forEach((panel) => {
                const isActivePanel = panel.getAttribute('data-booking-step-panel') === String(activeStep);
                panel.classList.toggle('hidden', !isActivePanel);
                panel.querySelectorAll('input, select, textarea, button').forEach((control) => {
                    if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement || control instanceof HTMLButtonElement)) {
                        return;
                    }

                    control.disabled = !isActivePanel;
                });
            });

            triggers.forEach((trigger) => {
                const step = Number.parseInt(trigger.getAttribute('data-booking-step-trigger') || '1', 10);
                const dot = trigger.querySelector('[data-booking-step-dot]');
                const isActive = step === activeStep;
                const isComplete = step < activeStep;

                trigger.classList.toggle('text-gs-primary', isActive || isComplete);
                trigger.classList.toggle('text-gs-ink-muted', !isActive && !isComplete);

                if (!dot) {
                    return;
                }

                dot.classList.toggle('bg-gs-primary', isActive || isComplete);
                dot.classList.toggle('text-white', isActive || isComplete);
                dot.classList.toggle('bg-gs-concrete', !isActive && !isComplete);
                dot.classList.toggle('text-gs-grey', !isActive && !isComplete);
                dot.textContent = isComplete ? '✓' : String(step);
            });

            root.querySelectorAll('[data-booking-collapsed-steps] [data-booking-step-trigger]').forEach((row) => {
                const step = Number.parseInt(row.getAttribute('data-booking-step-trigger') || '1', 10);
                row.classList.toggle('hidden', step === activeStep);
            });

            if (activeStep !== 3) {
                closeCalendar();
            }

            updatePeriods();
        };

        const toggleMobileTicket = (forceOpen = null) => {
            if (!mobileTicket) {
                return;
            }

            const shouldOpen = forceOpen ?? mobileTicket.classList.contains('hidden');
            mobileTicket.classList.toggle('hidden', !shouldOpen);
            mobileTicketToggles.forEach((toggle) => toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false'));
            mobileTicketChevrons.forEach((chevron) => chevron.classList.toggle('rotate-180', shouldOpen));
        };

        root.querySelectorAll('[data-ticket-input]').forEach((input) => {
            input.addEventListener('input', () => {
                clearInvalidState(root);
                updatePeriods();
                updateChoiceCards();
                updateTicket();
            });

            input.addEventListener('change', () => {
                clearInvalidState(root);
                updatePeriods();
                updateChoiceCards();
                updateTicket();
            });
        });

        form?.querySelectorAll('input:not([data-ticket-input]), select:not([data-ticket-input]), textarea:not([data-ticket-input])').forEach((control) => {
            control.addEventListener('input', () => clearInvalidState(root));
            control.addEventListener('change', () => clearInvalidState(root));
        });

        dateDisplay?.addEventListener('click', () => {
            if (calendar?.classList.contains('hidden')) {
                openCalendar();
                return;
            }

            closeCalendar();
        });

        calendarPrev?.addEventListener('click', () => {
            activeCalendarMonth = new Date(activeCalendarMonth.getFullYear(), activeCalendarMonth.getMonth() - 1, 1, 12);
            renderCalendar();
        });

        calendarNext?.addEventListener('click', () => {
            activeCalendarMonth = new Date(activeCalendarMonth.getFullYear(), activeCalendarMonth.getMonth() + 1, 1, 12);
            renderCalendar();
        });

        calendarToday?.addEventListener('click', () => {
            const today = new Date();

            if (isDateDisabled(today)) {
                return;
            }

            setDateValue(today);
            closeCalendar();
            renderCalendar();
        });

        calendarClear?.addEventListener('click', () => {
            clearDateValue();
            renderCalendar();
        });

        document.addEventListener('click', (event) => {
            if (!datePicker || !(event.target instanceof Node) || datePicker.contains(event.target)) {
                return;
            }

            closeCalendar();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeCalendar();
            }
        });

        mobileTicketToggles.forEach((button) => {
            button.addEventListener('click', () => toggleMobileTicket());
        });

        const goToStep = (nextStep) => {
            const boundedStep = Math.min(3, Math.max(1, nextStep));

            if (boundedStep <= activeStep) {
                setStep(boundedStep);
                return;
            }

            for (let step = activeStep; step < boundedStep; step += 1) {
                if (!validateStep(step, step === activeStep)) {
                    if (step !== activeStep) {
                        setStep(step);
                        window.setTimeout(() => validateStep(step), 0);
                    }

                    return;
                }
            }

            setStep(boundedStep);
        };

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                goToStep(Number.parseInt(trigger.getAttribute('data-booking-step-trigger') || '1', 10));
            });
        });

        root.querySelectorAll('[data-booking-next]').forEach((button) => {
            button.addEventListener('click', () => goToStep(activeStep + 1));
        });

        root.querySelectorAll('[data-booking-prev]').forEach((button) => {
            button.addEventListener('click', () => setStep(activeStep - 1));
        });

        const enableAllPanelControls = () => {
            panels.forEach((panel) => {
                panel.querySelectorAll('input, select, textarea, button').forEach((control) => {
                    if (!(control instanceof HTMLInputElement || control instanceof HTMLSelectElement || control instanceof HTMLTextAreaElement || control instanceof HTMLButtonElement)) {
                        return;
                    }

                    control.disabled = false;
                });
            });
        };

        form?.addEventListener('submit', (event) => {
            updatePeriods();

            for (let step = 1; step <= 3; step += 1) {
                if (!validateStep(step, false)) {
                    event.preventDefault();
                    setStep(step);
                    window.setTimeout(() => validateStep(step), 0);
                    return;
                }
            }

            enableAllPanelControls();

            if (!form.checkValidity()) {
                event.preventDefault();

                const invalidControl = form.querySelector(':invalid');
                const invalidPanel = invalidControl?.closest('[data-booking-step-panel]');
                const invalidStep = Number.parseInt(invalidPanel?.getAttribute('data-booking-step-panel') || String(activeStep), 10);

                setStep(invalidStep);
                window.setTimeout(() => {
                    if (invalidControl instanceof HTMLInputElement || invalidControl instanceof HTMLSelectElement || invalidControl instanceof HTMLTextAreaElement) {
                        markInvalidControl(invalidControl);
                    }

                    form.reportValidity();
                }, 0);
            }
        });

        setStep(1);
        updatePeriods();
        updateChoiceCards();
        updateTicket();
    });
};

const initServiceVehicleSelectors = () => {
    document.querySelectorAll('[data-service-vehicle-selector]').forEach((root) => {
        const tabs = [...root.querySelectorAll('[data-vehicle-profile-tab]')];
        const panels = [...root.querySelectorAll('[data-vehicle-profile-panel]')];

        if (!tabs.length || !panels.length) {
            return;
        }

        const activeClasses = ['border-gs-primary', 'bg-gs-primary', 'text-white', 'shadow-md', 'shadow-gs-primary/20'];
        const inactiveClasses = ['border-gs-primary/20', 'bg-gs-soft', 'text-gs-bay', 'hover:bg-white'];

        const setActiveProfile = (profile, shouldFocus = false) => {
            tabs.forEach((tab) => {
                const isActive = tab.getAttribute('data-vehicle-profile-tab') === profile;

                activeClasses.forEach((className) => tab.classList.toggle(className, isActive));
                inactiveClasses.forEach((className) => tab.classList.toggle(className, !isActive));
                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                tab.setAttribute('tabindex', isActive ? '0' : '-1');

                if (isActive && shouldFocus) {
                    tab.focus();
                }
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.getAttribute('data-vehicle-profile-panel') !== profile);
            });
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                const profile = tab.getAttribute('data-vehicle-profile-tab');

                if (profile) {
                    setActiveProfile(profile);
                }
            });

            tab.addEventListener('keydown', (event) => {
                const keyMap = {
                    ArrowLeft: index - 1,
                    ArrowRight: index + 1,
                    Home: 0,
                    End: tabs.length - 1,
                };

                if (!(event.key in keyMap)) {
                    return;
                }

                event.preventDefault();
                const nextIndex = (keyMap[event.key] + tabs.length) % tabs.length;
                const nextProfile = tabs[nextIndex]?.getAttribute('data-vehicle-profile-tab');

                if (nextProfile) {
                    setActiveProfile(nextProfile, true);
                }
            });
        });

        const initialProfile = tabs.find((tab) => tab.getAttribute('aria-selected') === 'true')?.getAttribute('data-vehicle-profile-tab')
            || tabs[0]?.getAttribute('data-vehicle-profile-tab');

        if (initialProfile) {
            setActiveProfile(initialProfile);
        }
    });
};

const initTariffNavigators = () => {
    document.querySelectorAll('[data-tariff-navigator]').forEach((root) => {
        const tabs = [...root.querySelectorAll('[data-tariff-tab]')];
        const panels = [...root.querySelectorAll('[data-tariff-panel]')];

        if (!tabs.length || !panels.length) {
            return;
        }

        const activeClasses = ['border-gs-primary', 'bg-gs-primary', 'text-white', 'shadow-md', 'shadow-gs-primary/20'];
        const inactiveClasses = ['border-gs-primary/15', 'bg-white', 'text-gs-navy', 'hover:bg-gs-soft'];

        const setActiveTariff = (slug, shouldFocus = false) => {
            tabs.forEach((tab) => {
                const isActive = tab.getAttribute('data-tariff-tab') === slug;

                activeClasses.forEach((className) => tab.classList.toggle(className, isActive));
                inactiveClasses.forEach((className) => tab.classList.toggle(className, !isActive));
                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                tab.setAttribute('tabindex', isActive ? '0' : '-1');

                if (isActive && shouldFocus) {
                    tab.focus();
                }
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.getAttribute('data-tariff-panel') !== slug);
            });
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                const slug = tab.getAttribute('data-tariff-tab');

                if (slug) {
                    setActiveTariff(slug);
                }
            });

            tab.addEventListener('keydown', (event) => {
                const keyMap = {
                    ArrowLeft: index - 1,
                    ArrowRight: index + 1,
                    ArrowUp: index - 1,
                    ArrowDown: index + 1,
                    Home: 0,
                    End: tabs.length - 1,
                };

                if (!(event.key in keyMap)) {
                    return;
                }

                event.preventDefault();
                const nextIndex = (keyMap[event.key] + tabs.length) % tabs.length;
                const nextSlug = tabs[nextIndex]?.getAttribute('data-tariff-tab');

                if (nextSlug) {
                    setActiveTariff(nextSlug, true);
                }
            });
        });

        const initialTariff = tabs.find((tab) => tab.getAttribute('aria-selected') === 'true')?.getAttribute('data-tariff-tab')
            || tabs[0]?.getAttribute('data-tariff-tab');

        if (initialTariff) {
            setActiveTariff(initialTariff);
        }
    });
};

const initTariffMatrices = () => {
    document.querySelectorAll('[data-tariff-matrix]').forEach((root) => {
        const searchInput = root.querySelector('[data-tariff-matrix-search]');
        const categoryFilter = root.querySelector('[data-tariff-matrix-category]');
        const groupFilter = root.querySelector('[data-tariff-matrix-group]');
        const resetButton = root.querySelector('[data-tariff-matrix-reset]');
        const printButton = root.querySelector('[data-tariff-matrix-print]');
        const downloadButton = root.querySelector('[data-tariff-matrix-download]');
        const shareButton = root.querySelector('[data-tariff-matrix-share]');
        const emptyState = root.querySelector('[data-tariff-matrix-empty]');
        const rows = [...root.querySelectorAll('[data-tariff-matrix-row]')];
        const cards = [...root.querySelectorAll('[data-tariff-matrix-card]')];
        const detailLinks = [...root.querySelectorAll('[data-tariff-detail-link]')];
        let searchTimer = null;

        const getControls = () => ({
            search: (searchInput?.value || '').trim().toLowerCase(),
            category: categoryFilter?.value || '',
            group: groupFilter?.value || '',
        });

        const matchesItem = (item, controls) => {
            const categoryMatches = !controls.category || item.getAttribute('data-category') === controls.category;
            const groupMatches = !controls.group || item.getAttribute('data-group') === controls.group;
            const searchMatches = !controls.search || (item.getAttribute('data-search') || '').includes(controls.search);

            return categoryMatches && groupMatches && searchMatches;
        };

        const updateResults = () => {
            const controls = getControls();
            let visibleRows = 0;

            rows.forEach((row) => {
                const isVisible = matchesItem(row, controls);
                row.classList.toggle('hidden', !isVisible);

                if (isVisible) {
                    visibleRows += 1;
                }
            });

            cards.forEach((card) => {
                card.classList.toggle('hidden', !matchesItem(card, controls));
            });

            emptyState?.classList.toggle('hidden', visibleRows > 0);
        };

        const debouncedUpdate = () => {
            window.clearTimeout(searchTimer);
            searchTimer = window.setTimeout(updateResults, 300);
        };

        searchInput?.addEventListener('input', debouncedUpdate);
        categoryFilter?.addEventListener('change', updateResults);
        groupFilter?.addEventListener('change', updateResults);

        resetButton?.addEventListener('click', () => {
            if (searchInput) {
                searchInput.value = '';
            }

            if (categoryFilter) {
                categoryFilter.value = '';
            }

            if (groupFilter) {
                groupFilter.value = '';
            }

            updateResults();
        });

        printButton?.addEventListener('click', () => window.print());
        downloadButton?.addEventListener('click', () => window.print());
        shareButton?.addEventListener('click', async () => {
            const shareData = {
                title: document.title,
                url: window.location.href,
            };

            if (navigator.share) {
                await navigator.share(shareData);
                return;
            }

            await navigator.clipboard?.writeText(window.location.href);
        });

        detailLinks.forEach((link) => {
            link.addEventListener('click', (event) => {
                const slug = link.getAttribute('data-tariff-detail-link');
                const tab = slug ? document.getElementById(`tariff-tab-${slug}`) : null;
                const panel = slug ? document.getElementById(`tariff-panel-${slug}`) : null;

                if (!tab || !panel) {
                    return;
                }

                event.preventDefault();
                tab.click();
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                window.history.replaceState(null, '', `#${panel.id}`);
            });
        });

        updateResults();
    });
};

const initFrontend = () => {
    initMobileMenu();
    initHeroCarousels();
    initBackToTop();
    initAgencyMaps();
    initContactMessageForms();
    initBookingIntakes();
    initServiceVehicleSelectors();
    initTariffNavigators();
    initTariffMatrices();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFrontend);
} else {
    initFrontend();
}
