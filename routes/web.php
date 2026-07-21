<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fr/accueil');

$localizedPages = [
    'fr' => [
        ['uri' => 'accueil', 'name' => 'home', 'view' => 'pages.home', 'title' => 'chrome.home_title'],
        ['uri' => 'a-propos', 'name' => 'about', 'view' => 'pages.about', 'title' => 'about.meta_title'],
        ['uri' => 'nos-agences', 'name' => 'agencies', 'view' => 'pages.agencies', 'title' => 'agencies.meta_title'],
        ['uri' => 'services', 'name' => 'services', 'title' => 'nav.services'],
        ['uri' => 'tarifs', 'name' => 'tariffs', 'title' => 'nav.tariffs'],
        ['uri' => 'visite-technique', 'name' => 'technical_inspection', 'title' => 'nav.technical_inspection'],
        ['uri' => 'rendez-vous', 'name' => 'booking', 'view' => 'pages.booking', 'title' => 'actions.book'],
        ['uri' => 'suivi-rendez-vous', 'name' => 'tracking', 'view' => 'pages.tracking', 'title' => 'tracking.meta_title'],
        ['uri' => 'actualites', 'name' => 'news', 'title' => 'nav.news'],
        ['uri' => 'contact', 'name' => 'contact', 'title' => 'nav.contact'],
    ],
    'en' => [
        ['uri' => 'home', 'name' => 'home', 'view' => 'pages.home', 'title' => 'chrome.home_title'],
        ['uri' => 'about', 'name' => 'about', 'view' => 'pages.about', 'title' => 'about.meta_title'],
        ['uri' => 'our-agencies', 'name' => 'agencies', 'view' => 'pages.agencies', 'title' => 'agencies.meta_title'],
        ['uri' => 'services', 'name' => 'services', 'title' => 'nav.services'],
        ['uri' => 'tariffs', 'name' => 'tariffs', 'title' => 'nav.tariffs'],
        ['uri' => 'technical-inspection', 'name' => 'technical_inspection', 'title' => 'nav.technical_inspection'],
        ['uri' => 'booking', 'name' => 'booking', 'view' => 'pages.booking', 'title' => 'actions.book'],
        ['uri' => 'appointment-tracking', 'name' => 'tracking', 'view' => 'pages.tracking', 'title' => 'tracking.meta_title'],
        ['uri' => 'news', 'name' => 'news', 'title' => 'nav.news'],
        ['uri' => 'contact', 'name' => 'contact', 'title' => 'nav.contact'],
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
