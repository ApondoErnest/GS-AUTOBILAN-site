# Admin navigation and dashboard widgets — V1

**Version:** 1.3 · **Steps:** S048–S050

**Status:** S048-S050 complete.

---

## 1. Navigation groups

1. **Dashboard**  
2. **Operations** — Bookings · Document readiness  
3. **Website Content** — Articles · FAQs · Gallery · Testimonials · Page content  
4. **Agencies & Services**  
5. **Tariffs**  
6. **Communication** — Contact messages  
7. **Users & Settings** — Users · Settings · Audit log  

**Implemented at S049:** group names and order are centralized in `App\Filament\AdminNavigation`. Current overview pages are placeholders for navigation only; module CRUD is still reserved for S051-S055.

---

## 2. Dashboard overview widgets

Show:

- Total bookings  
- New requests  
- Pending confirmations  
- Confirmed / completed / no-shows  
- Bookings by agency (chart or breakdown)  
- Latest contact messages  
- Document-readiness alerts (missing info / contact agency)  
- Latest articles  

**Agency Admin:** see own-agency metrics only.

**Implemented at S050:** `App\Filament\Support\DashboardMetrics` centralizes dashboard counts and latest-activity queries, the Dashboard page renders S050 widgets, and tests cover Super Admin totals plus Agency Admin assigned-agency scoping.
