# Booking module — V1

**Version:** 1.3 · **Steps:** S066–S068  
**Workflows:** [../01-project-documentation/05-operational-workflows.md](../01-project-documentation/05-operational-workflows.md)

---

## Public shell status

S058 delivered the public booking interface at `/fr/rendez-vous` and `/en/booking`: compact expectation hero, non-auto-confirmation notice, live ticket summary, three-step intake wizard, custom date picker, review panel, and client-side virtual receipt.

S066 replaced the shell-only submit path with localized POST routes, `BookingRequest` normalization for the wizard fields, `BookingService` persistence, generated references, default document-readiness creation, and the existing admin notification event. The receipt now displays the persisted `GS-YEAR-SEQUENCE` reference after redirect, links to a dedicated booking-summary PDF, and the wizard blocks forward navigation with no-reload required-field highlighting until each step is complete.

S067 turns that receipt into a full confirmation state: it shows the generated reference, registration, bilingual next steps, the exact tracking credentials customers should keep, and a tracking link that pre-fills reference + phone + plate on the tracking form.

S068 verifies the end-to-end staff workflow for public-created bookings: an assigned agency admin can find the new request in Filament, update it through all V1 operational statuses, set confirmed date/time, and save public/internal follow-up messages.

---

## Customer-side steps

1. Open Booking  
2. Read non-auto-confirm message  
3. Enter personal details  
4. Select agency  
5. Enter vehicle details  
6. Select service  
7. Choose preferred date/time  
8. Submit  
9. System validates  
10. System creates reference `GS-YEAR-SEQUENCE`  
11. System stores booking  
12. System creates document-readiness (`not_reviewed`)  
13. Confirmation + tracking instructions  

---

## Admin-side steps

1. Open booking list · 2. Filter agency/status · 3. Open details · 4. Contact customer · 5. Set status · 6. Add confirmed datetime · 7. Add public message · 8. Tracking updates  

---

## Reference rules

Format **GS-YEAR-SEQUENCE** (e.g. `GS-2026-000123`) · unique · readable · shown on confirmation · used for tracking  

## Statuses only

New Request · Pending Confirmation · Confirmed · Rescheduled · Cancelled · Completed · No-show  

## Acceptance

Customer can submit, receive a reference, understand the next steps, and open a prefilled tracking link; staff can manage the request from admin.
