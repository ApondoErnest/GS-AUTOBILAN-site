<?php

return [
    'title' => 'Communication',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Suivez messages clients, état de réponse, attribution et suivi agence depuis une boîte claire.',
    'empty_value' => 'Non renseigné',
    'empty_subject' => 'Message sans sujet',

    'command' => [
        'eyebrow' => 'Bureau messages',
        'heading' => 'Pilotage des messages clients',
        'description' => 'Gardez les demandes de contact publiques, leur routage agence, leur attribution et leur avancement visibles sans quitter la section.',
    ],

    'summary' => [
        'label' => 'Synthèse communication',
        'total' => [
            'label' => 'Messages visibles',
            'description' => 'Messages disponibles dans votre périmètre actuel.',
        ],
        'new' => [
            'label' => 'Nouveaux',
            'description' => 'Messages clients encore en attente de première revue.',
        ],
        'in_review' => [
            'label' => 'En traitement',
            'description' => 'Messages actuellement pris en charge par l’équipe.',
        ],
        'responded' => [
            'label' => 'Répondus',
            'description' => 'Messages répondus ou clôturés.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Boîte de réception',
        'description' => 'Ouvrez les demandes de contact arrivées depuis le site public.',
        'empty' => 'Aucun espace messages n’est disponible pour votre rôle ou votre périmètre agence.',
        'messages' => [
            'label' => 'Messages de contact',
            'description' => 'Revoyez les demandes clients, attribuez un responsable, mettez à jour l’état et notez le suivi interne.',
        ],
    ],

    'workload' => [
        'heading' => 'Charge de traitement',
        'description' => 'Messages regroupés par état de réponse dans le périmètre actuel.',
        'metric' => ':count sur :total messages',
    ],

    'latest' => [
        'heading' => 'Derniers messages',
        'description' => 'Demandes de contact récentes et leur état de traitement.',
        'empty' => 'Aucun message de contact n’est visible pour le moment.',
    ],

    'attention' => [
        'heading' => 'File d’attention',
        'description' => 'Éléments de communication pouvant demander attribution, revue ou nettoyage.',
        'empty' => 'Aucun élément de communication ne demande d’attention.',
        'new' => [
            'label' => 'Nouveaux messages',
            'description' => 'Demandes en attente de première revue.',
        ],
        'in_review' => [
            'label' => 'En traitement',
            'description' => 'Messages encore pris en charge.',
        ],
        'unassigned' => [
            'label' => 'Non attribués',
            'description' => 'Messages ouverts sans responsable interne.',
        ],
        'spam' => [
            'label' => 'Spam marqué',
            'description' => 'Messages marqués spam pour revue de nettoyage.',
        ],
    ],
];
