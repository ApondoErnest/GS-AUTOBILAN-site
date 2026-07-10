# Booking module — V1

**Version:** 1.1 · **Steps:** S066–S068  
**Workflows:** [../01-project-documentation/05-operational-workflows.md](../01-project-documentation/05-operational-workflows.md)

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

Customer can submit and receive a reference; staff can manage the request from admin.
