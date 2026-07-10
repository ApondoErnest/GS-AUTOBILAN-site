# Project brief

**GS AUTOBILAN Official Website** · Step **S001**

## Objective

Modern bilingual (FR default / EN) website for GS AUTOBILAN with two agencies (Nkolbisson, Obili Scalom): company presentation, practical info, booking intake, appointment/document tracking, and a private admin dashboard.

Company data: [00-company-data.md](00-company-data.md)

## Users

**Public:** vehicle owners, taxi drivers, transport operators, fleet representatives  
**Admin:** Super Admin, Agency Admin, Content Manager, reception staff

## Stack (locked)

Laravel · Blade · Livewire · Alpine.js · Tailwind CSS · Filament · Heroicons · MySQL  
Detail: [../04-laravel-setup/01-technology-stack.md](../04-laravel-setup/01-technology-stack.md)

## Approach

Local → stabilize → Docker → VPS · Timezone `Africa/Douala`

## Core V1 principle

Booking = **digital intake** (staff confirm by phone/WhatsApp).  
Tracking = **appointment + document readiness** only — not lane/machine status.

## Suggested About copy (approve with company)

**Mission:** Contribuer à la sécurité routière au Cameroun en offrant un service de contrôle technique automobile fiable, transparent et professionnel.  
**Vision:** Devenir une référence du contrôle technique grâce à la qualité du service et à la confiance des usagers.  
**Values:** Safety · Professionalism · Transparency · Responsibility · Customer care · Reliability

## Next

[02-scope.md](02-scope.md)
