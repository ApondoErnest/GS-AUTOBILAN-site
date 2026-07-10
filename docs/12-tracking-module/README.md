# Appointment tracking module — V1

**Version:** 1.1 · **Steps:** S069–S070  

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
