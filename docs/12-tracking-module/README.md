# Appointment tracking module — V1

**Version:** 1.4 · **Steps:** S069–S070  

---

## Public shell status

S059 delivered the public tracking shell at `/fr/suivi-rendez-vous` and `/en/appointment-tracking` with a compact clarity hero, secure lookup card, static concierge result state, and mobile two-column details.

S069 wires the lookup form through `TrackingLookupRequest` and `TrackingService`: blank tracking pages show only the lookup card, invalid or unmatched submissions show compact generic feedback, and a matching reference + phone + vehicle registration renders a safe public result panel using persisted booking/readiness data.

S070 adds failed-lookup abuse protection: invalid or unmatched submissions count against a requester-scoped five-attempt window for fifteen minutes, successful matches clear prior failed attempts, and throttled users receive the same compact public form treatment without revealing which field failed.

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
Rate limit failed attempts: five failed attempts per requester over fifteen minutes, reset after a successful match.  

---

## Never show

Internal notes · admin comments · full private profile · inspection result · lane progress · machine data  

## Acceptance

Customers can safely check appointment/document status with all three credentials without exposing private data, while repeated failed attempts are limited.
