# Backend design — V1

**Project:** GS AUTOBILAN Official Website  
**Version:** 1.2 · **Status:** S040-S047 implemented; backend block complete  
**Related:** [01-routes-and-controllers.md](01-routes-and-controllers.md) · [02-services-policies-events.md](02-services-policies-events.md) · [03-validation-notifications.md](03-validation-notifications.md)

---

## 1. Objective

Design the Laravel backend so it controls routing, validation, business logic, data access, authorization, public lookup, admin operations, notifications, logging, and future extensibility — without inspection-lane complexity.

---

## 2. Architectural approach

Clean separation:

```
Routes → Controllers / Livewire (thin)
  → Form Requests
    → Services
      → Models
    → Policies
    → Events → Listeners → Notifications / Jobs
    → Audit (activitylog)
```

Controllers stay thin. Business rules live in **services**.

---

## 3. Backend module build order

1. Authentication and roles  
2. Agencies  
3. Services  
4. Tariffs  
5. Bookings  
6. Document readiness  
7. Tracking lookup  
8. Contact messages  
9. Articles  
10. FAQs  
11. Gallery  
12. Testimonials  
13. Site settings  
14. Audit logs  
15. Notifications  
16. SEO metadata helpers  

---

## 4. Status management (controlled enums)

| Domain | Allowed values |
|--------|----------------|
| Booking | New Request · Pending Confirmation · Confirmed · Rescheduled · Cancelled · Completed · No-show |
| Document readiness | Not reviewed yet · Documents appear complete · Missing information · Please contact agency · Ready for visit |
| Contact | New · In review · Responded · Closed · Spam |
| Article | Draft · Published · Archived |

Do not use free-text statuses in V1.

---

## 5. Error handling principles

- Tracking failure → generic safe message (no field leakage)  
- Unauthorized admin → 403  
- Failed contact submit → preserve input  
- Upload errors → clear user message  
- System errors → log privately; never expose stack traces publicly  

---

## 6. Logging & audit

**Log:** booking create/status, document updates, login failures, tariff/role changes, critical errors  

**Audit:** booking/document/tariff/agency/user/settings changes — who, module, when, summary  

---

## 7. Acceptance

Backend design is complete when each module has clear responsibilities, validation, authorization, public behaviour, and admin behaviour — see detail files in this folder.
