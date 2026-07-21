# Appointment tracking module — V1

**Version:** 1.2 · **Steps:** S069–S070  

---

## Public shell status

S059 delivered the public tracking shell at `/fr/suivi-rendez-vous` and `/en/appointment-tracking` with a compact clarity hero, secure lookup card, static concierge result state, and mobile two-column details.

S069/S070 must wire real lookup state transitions (`Lookup -> Loading -> Result -> Not found`), persisted data from `TrackingService`, safe generic errors, and rate limiting. Keep the current privacy rule: never reveal which individual field failed.

---

## Lookup requirements

Customer must provide **all three**:

1. Booking reference  
2. Phone number  
3. Vehicle registration number  

---

## Successful display

Reference · agency · requested datetime · confirmed datetime (if any) · booking status · document status · next action · public message · contact options  

---

## Failed lookup

Generic FR/EN message — do not reveal whether the reference alone exists.  
Rate limit failed attempts.  

---

## Never show

Internal notes · admin comments · full private profile · inspection result · lane progress · machine data  

## Acceptance

Customers can safely check appointment/document status without exposing private data.
