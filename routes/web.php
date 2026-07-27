<?php

use App\Http\Requests\BookingRequest;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Requests\TrackingLookupRequest;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\ContactMessageService;
use App\Services\TrackingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fr/accueil');

$localizedPages = [
    'fr' => [
        ['uri' => 'accueil', 'name' => 'home', 'view' => 'pages.home', 'title' => 'chrome.home_title'],
        ['uri' => 'a-propos', 'name' => 'about', 'view' => 'pages.about', 'title' => 'about.meta_title'],
        ['uri' => 'nos-agences', 'name' => 'agencies', 'view' => 'pages.agencies', 'title' => 'agencies.meta_title'],
        ['uri' => 'services', 'name' => 'services', 'view' => 'pages.services', 'title' => 'services.meta_title'],
        ['uri' => 'tarifs', 'name' => 'tariffs', 'view' => 'pages.tariffs', 'title' => 'tariffs.meta_title'],
        ['uri' => 'visite-technique', 'name' => 'technical_inspection', 'view' => 'pages.technical-inspection', 'title' => 'inspection.meta_title'],
        ['uri' => 'rendez-vous', 'name' => 'booking', 'view' => 'pages.booking', 'title' => 'actions.book'],
        ['uri' => 'suivi-rendez-vous', 'name' => 'tracking', 'view' => 'pages.tracking', 'title' => 'tracking.meta_title'],
        ['uri' => 'actualites', 'name' => 'news', 'title' => 'nav.news'],
        ['uri' => 'contact', 'name' => 'contact', 'view' => 'pages.contact', 'title' => 'contact.meta_title'],
    ],
    'en' => [
        ['uri' => 'home', 'name' => 'home', 'view' => 'pages.home', 'title' => 'chrome.home_title'],
        ['uri' => 'about', 'name' => 'about', 'view' => 'pages.about', 'title' => 'about.meta_title'],
        ['uri' => 'our-agencies', 'name' => 'agencies', 'view' => 'pages.agencies', 'title' => 'agencies.meta_title'],
        ['uri' => 'services', 'name' => 'services', 'view' => 'pages.services', 'title' => 'services.meta_title'],
        ['uri' => 'tariffs', 'name' => 'tariffs', 'view' => 'pages.tariffs', 'title' => 'tariffs.meta_title'],
        ['uri' => 'technical-inspection', 'name' => 'technical_inspection', 'view' => 'pages.technical-inspection', 'title' => 'inspection.meta_title'],
        ['uri' => 'booking', 'name' => 'booking', 'view' => 'pages.booking', 'title' => 'actions.book'],
        ['uri' => 'appointment-tracking', 'name' => 'tracking', 'view' => 'pages.tracking', 'title' => 'tracking.meta_title'],
        ['uri' => 'news', 'name' => 'news', 'title' => 'nav.news'],
        ['uri' => 'contact', 'name' => 'contact', 'view' => 'pages.contact', 'title' => 'contact.meta_title'],
    ],
];

foreach ($localizedPages as $locale => $pages) {
    Route::prefix($locale)
        ->name($locale.'.')
        ->middleware('setLocale')
        ->group(function () use ($pages, $locale): void {
            foreach ($pages as $page) {
                Route::get($page['uri'], function () use ($page) {
                    return view($page['view'] ?? 'pages.public-placeholder', [
                        'title' => __($page['title']),
                    ]);
                })->name($page['name']);

                if ($page['name'] === 'booking') {
                    Route::post($page['uri'], function (BookingRequest $request, BookingService $bookings) use ($locale): RedirectResponse {
                        $payload = $request->validated();
                        $serviceLabel = collect(__('booking.command.step1.services'))
                            ->firstWhere('slug', $payload['service_type'] ?? null);
                        $vehicleLabel = collect(__('booking.command.step2.categories'))
                            ->firstWhere('slug', $payload['vehicle_category'] ?? null);
                        $serviceLabel = data_get($serviceLabel, 'name');
                        $vehicleLabel = data_get($vehicleLabel, 'label') ?? ($payload['vehicle_category'] ?? null);
                        $contactMode = $payload['contact_mode'] ?? null;

                        $payload['customer_message'] = collect([
                            filled($serviceLabel) ? __('booking.command.ticket.fields.service').': '.$serviceLabel : null,
                            filled($contactMode) ? __('booking.command.ticket.fields.contact').': '.$contactMode : null,
                            $payload['customer_message'] ?? null,
                        ])->filter()->implode(PHP_EOL) ?: null;

                        $booking = $bookings->create($payload)->loadMissing(['agency', 'service']);
                        $localizedAgencyName = $locale === 'en'
                            ? $booking->agency?->name_en
                            : $booking->agency?->name_fr;
                        $localizedServiceTitle = $locale === 'en'
                            ? $booking->service?->title_en
                            : $booking->service?->title_fr;
                        $trackingUrl = route($locale.'.tracking', [
                            'reference' => $booking->reference,
                            'phone' => $booking->phone,
                            'vehicle_registration' => $booking->vehicle_registration,
                        ], false);

                        return redirect()
                            ->route($locale.'.booking')
                            ->with('booking_confirmation', [
                                'reference' => $booking->reference,
                                'summary_url' => route($locale.'.booking.summary', [
                                    'booking' => $booking->reference,
                                ], false),
                                'tracking_url' => $trackingUrl,
                                'tracking' => [
                                    'reference' => $booking->reference,
                                    'phone' => $booking->phone,
                                    'vehicle_registration' => $booking->vehicle_registration,
                                ],
                                'fields' => [
                                    'agency' => $localizedAgencyName ?? $booking->agency?->name_fr,
                                    'service' => $serviceLabel ?? $localizedServiceTitle ?? $booking->service?->title_fr,
                                    'vehicle' => $vehicleLabel,
                                    'registration' => $booking->vehicle_registration,
                                    'date' => $booking->preferred_date?->toDateString(),
                                    'period' => $booking->preferred_time_slot,
                                    'contact' => $contactMode,
                                ],
                            ]);
                    })->name($page['name'].'.store');

                    Route::get($page['uri'].'/{booking:reference}/recapitulatif.pdf', function (Booking $booking) use ($locale) {
                        $booking->loadMissing(['agency', 'service', 'documentReadiness']);

                        return Pdf::loadView('pdf.booking-summary', [
                            'booking' => $booking,
                            'locale' => $locale,
                        ])->setPaper('a5', 'portrait')
                            ->download($booking->reference.'-recapitulatif.pdf');
                    })->name($page['name'].'.summary');
                }

                if ($page['name'] === 'contact') {
                    Route::post($page['uri'], function (ContactMessageRequest $request, ContactMessageService $messages): JsonResponse|RedirectResponse {
                        $messages->create($request->validated());
                        $message = __('contact.desk.form.success');

                        if ($request->expectsJson()) {
                            return response()->json(['message' => $message], 201);
                        }

                        return back()->with('contact_message_status', $message);
                    })->name($page['name'].'.store');
                }

                if ($page['name'] === 'tracking') {
                    Route::post($page['uri'], function (TrackingLookupRequest $request, TrackingService $tracking) use ($page, $locale) {
                        $payload = $request->validated();
                        $result = $tracking->lookup(
                            reference: $payload['reference'],
                            phone: $payload['phone'],
                            vehicleRegistration: $payload['vehicle_registration'],
                        );

                        if ($result === null) {
                            return redirect()
                                ->route($locale.'.tracking')
                                ->withInput()
                                ->withErrors(['tracking_lookup' => __('tracking.lookup.errors.not_found')]);
                        }

                        return view($page['view'] ?? 'pages.public-placeholder', [
                            'title' => __($page['title']),
                            'trackingResult' => $result,
                            'trackingLookup' => $payload,
                        ]);
                    })->middleware('tracking.lookup.throttle')->name($page['name'].'.lookup');
                }
            }
        });
}

Route::get('/fr/actualites/{slug}', fn (string $slug) => view('pages.public-placeholder', [
    'title' => __('nav.news'),
    'slug' => $slug,
]))->middleware('setLocale')->name('fr.article.show');

Route::get('/en/news/{slug}', fn (string $slug) => view('pages.public-placeholder', [
    'title' => __('nav.news'),
    'slug' => $slug,
]))->middleware('setLocale')->name('en.article.show');
