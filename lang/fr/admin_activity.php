<?php

return [
    'navigation_label' => 'Audit',
    'empty_value' => 'Non renseigné',
    'empty_id' => 'inconnu',
    'empty_causer' => 'Système',

    'model' => [
        'singular' => 'événement audit',
        'plural' => 'événements audit',
    ],

    'pages' => [
        'list' => [
            'title' => 'Journal d’audit',
            'subtitle' => 'Historique en lecture seule des activités administratives protégées.',
        ],
    ],

    'table' => [
        'heading' => 'Journal d’audit',
        'description' => 'Un journal de sécurité en lecture seule pour événements admin, enregistrements, utilisateurs et dates.',
        'empty_heading' => 'Aucun événement audit',
        'empty_description' => 'Les activités admin protégées apparaîtront ici lors des créations, mises à jour ou suppressions.',
        'columns' => [
            'activity' => 'Activité',
            'log' => 'Journal',
            'event' => 'Événement',
            'subject' => 'Sujet',
            'causer' => 'Auteur',
            'created' => 'Créé',
        ],
        'descriptions' => [
            'no_description' => 'Événement audit',
        ],
        'filters' => [
            'log' => 'Journal',
            'event' => 'Événement',
            'created_window' => 'Date de création',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],

    'events' => [
        'created' => 'Créé',
        'updated' => 'Mis à jour',
        'deleted' => 'Supprimé',
    ],

    'logs' => [
        'agencies' => 'Agences',
        'articles' => 'Articles',
        'bookings' => 'Rendez-vous',
        'contact_messages' => 'Messages contact',
        'document_readiness' => 'Préparation dossiers',
        'gallery_items' => 'Galerie',
        'services' => 'Services',
        'settings' => 'Réglages',
        'tariffs' => 'Tarifs',
        'testimonials' => 'Témoignages',
        'users' => 'Utilisateurs',
    ],
];
