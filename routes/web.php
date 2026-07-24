<?php

use App\Http\Requests\ContactMessageRequest;
use App\Services\ContactMessageService;
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
        ->group(function () use ($pages): void {
            foreach ($pages as $page) {
                Route::get($page['uri'], function () use ($page) {
                    return view($page['view'] ?? 'pages.public-placeholder', [
                        'title' => __($page['title']),
                    ]);
                })->name($page['name']);

                if ($page['name'] === 'contact') {
                    Route::post($page['uri'], function (ContactMessageRequest $request, ContactMessageService $messages): RedirectResponse {
                        $messages->create($request->validated());

                        return back()->with('contact_message_status', __('contact.desk.form.success'));
                    })->name($page['name'].'.store');
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
