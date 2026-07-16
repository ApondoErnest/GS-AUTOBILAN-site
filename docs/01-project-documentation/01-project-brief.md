# Project brief

**GS AUTOBILAN Official Website** · Step **S001**

**Slogan:** Votre sécurité, c’est notre métier.

## Objective

Modern bilingual (FR default / EN) website for GS AUTOBILAN with two agencies (Nkolbisson, Obili Scalom): company presentation, practical info, booking intake, appointment/document tracking, and a private admin dashboard.

Company data: [00-company-data.md](00-company-data.md)

## Agencies

| Agency | Role in V1 |
|--------|------------|
| **Nkolbisson** | Public listing, booking target, contact/map |
| **Obili Scalom** | Public listing, booking target, contact/map |
| **Direction Générale** (Bastos) | Company contact / HQ reference |

Full addresses, phones, hours, GPS: [00-company-data.md](00-company-data.md)

## Users

**Public:** vehicle owners, taxi drivers, transport operators, fleet representatives  
**Admin (system roles):** Super Admin, Agency Admin, Content Manager  
**Operational (no separate login in V1):** reception staff — use Agency Admin or shared desk access as defined later

## Stack (locked)

Laravel · Blade · Livewire · Alpine.js · Tailwind CSS · Filament · Heroicons · MySQL  
Detail: [../04-laravel-setup/01-technology-stack.md](../04-laravel-setup/01-technology-stack.md)

## Approach

Local → stabilize → Docker → VPS · Timezone `Africa/Douala`

**Public UI identity:** [GS Royal Safety Bands](../06-frontend-design/01-brand-and-ui.md) (royal blue · white · red bands · industrial grey)

## Core V1 principle

Booking = **digital intake** (staff confirm by phone/WhatsApp).  
Tracking = **appointment + document readiness** only — not lane/machine status.

## About page copy draft (implemented in S065; approve with company)

**FR mission:** Contribuer à la sécurité routière en offrant un service de visite technique fiable, clair et accessible.  
**FR vision:** Devenir une référence en matière de contrôle technique automobile professionnel, moderne et orienté client.  
**FR values:** Sécurité · Transparence · Professionnalisme · Fiabilité

**EN mission:** Contribute to road safety by offering a reliable, clear, and accessible technical inspection service.  
**EN vision:** Become a reference for professional, modern, customer-oriented vehicle technical inspection.  
**EN values:** Safety · Transparency · Professionalism · Reliability

## Next

[02-scope.md](02-scope.md)
