# Admin modules — V1

**Version:** 1.6 · **Steps:** S051–S055

**Status:** S051-S055 complete.

---

## 1. Agency management

Name · address · phones · WhatsApp · email · opening hours · GPS · map link · photos · status · active flag · services available (if linked)

## 2. Services management

Title FR/EN · descriptions · icon · image · order · active

**Implemented at S051:** `AgencyResource` and `ServiceResource` cover the current schema fields, including bilingual copy, contact/location data, opening-hour JSON fields, active/order flags, and create/edit/delete pages.

## 3. Tariffs management

Category · vehicle type FR/EN · price · validity · notes · active · **is_placeholder** · last updated · PDF export · **audit on change**

**Implemented at S052:** `TariffResource` covers category, bilingual vehicle type, price/currency, validity, notes, active/order flags, `is_placeholder`, and last-updated fields. Placeholder records stay visibly marked and display as pending official tariffs; changes are audited through `activity_log`.

## 4. Booking management

Customer details · agency · service · vehicle · requested datetime · confirmed datetime · status · public message · internal notes  

Statuses: New Request · Pending Confirmation · Confirmed · Rescheduled · Cancelled · Completed · No-show

**Implemented at S053:** `BookingResource` covers customer/contact data, agency/service assignment, vehicle fields, preferred/confirmed schedule, status, customer message, public tracking message, and internal notes. Admin-created bookings receive a generated `GS-YYYY-######` reference and default document-readiness row; Agency Admin records are scoped to their assigned agency.

## 5. Document-readiness management

Status · missing information · public next action · public message · updated by  

Statuses: Not reviewed · Complete · Missing information · Contact agency · Ready for visit

**Implemented at S053:** `DocumentReadinessResource` covers booking review status, missing-information notes, bilingual next actions, bilingual public messages, and `updated_by` tracking. Agency Admin records are scoped through the booking's agency.

## 6. Content management

Homepage blocks · About · Visite Technique · services copy · articles · FAQs · gallery · testimonials

**Implemented at S054:** `ArticleResource` covers article category selection, bilingual title/slug/summary/content, publishing status/date, featured image, and bilingual SEO metadata. `FaqResource` covers bilingual questions/answers plus active/order display controls.

**Implemented at S055:** `GalleryItemResource` covers gallery images, category, optional agency association, bilingual captions, active status, and display order. `TestimonialResource` covers customer name, bilingual type/message, rating, optional image, active status, and display order.

## 7. Contact messages

New queue · agency · subject · status · response notes · close / spam

**Implemented at S054:** `ContactMessageResource` covers sender details, agency assignment, subject/message, queue status, assigned user, and internal notes. Agency Admin records are scoped to their assigned agency; Content Manager access is denied.

## 8. User management (Super Admin)

Name · email · role · assigned agency · active/inactive

**Implemented at S055:** `UserResource` covers staff name/email, assigned agency, active status, password create/update, and role assignment for the three GS staff roles.

## 9. Site settings (Super Admin)

Logo · favicon · slogan · primary contacts · footer FR/EN · social links · default SEO

**Implemented at S055:** `SettingResource` provides Super Admin-only key/value JSON editing for site settings with create/edit/delete pages.

## 10. Audit log

Activity log · event · description · subject · causer · timestamp

**Implemented at S055:** `ActivityResource` provides a Super Admin-only, read-only audit listing backed by Spatie activity log records.
