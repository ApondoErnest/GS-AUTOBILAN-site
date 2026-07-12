# Validation and notifications — V1

**Version:** 1.1 · **Steps:** S046–S047

---

## 1. Booking request validation

| Field | Rule |
|-------|------|
| Full name | Required |
| Phone | Required; normalize for storage/compare |
| WhatsApp | Optional (recommended if different from phone) |
| Email | Optional; valid if present |
| Agency | Required; must exist and be active |
| Service | Required; must exist and be active |
| Vehicle registration | Required |
| Vehicle type/category | As designed (required or optional per form UX) |
| Preferred date | Required; not in the past |
| Preferred time slot | Required |
| Message | Optional; max length |

---

## 2. Tracking lookup validation

| Field | Rule |
|-------|------|
| Booking reference | Required |
| Phone | Required |
| Vehicle registration | Required |
| Normalization | Uppercase plate; strip spaces; normalize phone before query |

---

## 3. Contact validation

| Field | Rule |
|-------|------|
| Name | Required |
| Phone or email | At least one required |
| Subject | Required |
| Message | Required; max length |
| Agency | Optional |

---

## 4. Notifications (V1)

| Channel | When |
|---------|------|
| Admin email | New booking · new contact |
| Customer email | Optional if email provided |
| WhatsApp / SMS APIs | **Not in V1** — staff use deep links / phone manually |

**Implemented at S047:** booking/contact create services fire events; listeners send queued mail notifications to `settings.direction_generale.email` with `mail.from.address` as fallback. Local mail remains compatible with `MAIL_MAILER=log`.

---

## 5. Failed tracking message

**EN:** We could not find a matching booking. Please verify your reference, phone number and vehicle registration, or contact GS AUTOBILAN.

**FR:** Nous n'avons pas trouvé de rendez-vous correspondant. Veuillez vérifier votre référence, numéro de téléphone et immatriculation, ou contactez GS AUTOBILAN.

Never reveal whether the reference alone exists.
