<?php

return [
    'title' => 'Agences et services',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Suivez les informations publiques des agences et le catalogue services depuis un même espace opérationnel.',
    'empty_value' => 'Non renseigné',
    'feed_empty' => 'Aucun espace agence ou service n’est disponible pour votre rôle.',

    'command' => [
        'eyebrow' => 'Bureau réseau',
        'heading' => 'Réseau d’agences et catalogue services',
        'description' => 'Gardez les informations d’agence, contacts publics, statuts d’ouverture et pages services alignés avec ce que les clients voient sur le site.',
    ],

    'summary' => [
        'label' => 'Résumé agences et services',
        'agencies' => [
            'label' => 'Agences visibles',
            'description' => ':total agences au total dans votre périmètre.',
        ],
        'operational' => [
            'label' => 'Opérationnelles',
            'description' => 'Agences actives prêtes à recevoir les clients.',
        ],
        'services' => [
            'label' => 'Services actifs',
            'description' => ':total services au total dans le catalogue.',
        ],
        'hidden' => [
            'label' => 'Éléments masqués',
            'description' => 'Agences ou services retirés de l’affichage public.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Espaces de gestion',
        'description' => 'Ouvrez les fiches agences ou services qui structurent l’expérience client publique.',
        'empty' => 'Aucun espace de gestion n’est disponible pour votre rôle.',
        'agencies' => [
            'label' => 'Agences',
            'description' => 'Revoyez identité, contacts, horaires, statut et détails carte.',
        ],
        'services' => [
            'label' => 'Services',
            'description' => 'Maintenez les pages bilingues, images, ordre et visibilité.',
        ],
    ],

    'readiness' => [
        'heading' => 'Préparation publique',
        'description' => 'Niveau de complétude et de visibilité des données réseau côté client.',
        'metric' => ':ready sur :total prêts',
        'empty' => 'Aucune donnée de préparation n’est disponible pour votre rôle.',
        'agency_visibility' => [
            'label' => 'Visibilité agences',
        ],
        'contact_ready' => [
            'label' => 'Contacts prêts',
        ],
        'service_visibility' => [
            'label' => 'Visibilité services',
        ],
        'bilingual_services' => [
            'label' => 'Services bilingues',
        ],
    ],

    'latest_agencies' => [
        'heading' => 'Dernières agences',
        'description' => 'Fiches agences récemment mises à jour et disponibilité publique.',
        'empty' => 'Aucune fiche agence n’est encore visible.',
    ],

    'latest_services' => [
        'heading' => 'Derniers services',
        'description' => 'Pages services récemment mises à jour et visibilité catalogue.',
        'empty' => 'Aucune fiche service n’est encore visible.',
    ],

    'attention' => [
        'heading' => 'File d’attention',
        'description' => 'Détails réseau ou catalogue à revoir avant de soutenir le site public.',
        'empty' => 'Aucun élément agence ou service ne demande attention.',
        'closed_agencies' => [
            'label' => 'Fermées temporairement',
            'description' => 'Agences actuellement marquées indisponibles.',
        ],
        'hidden_agencies' => [
            'label' => 'Agences masquées',
            'description' => 'Fiches agences non affichées sur le site public.',
        ],
        'hidden_services' => [
            'label' => 'Services masqués',
            'description' => 'Pages services retirées du catalogue public.',
        ],
        'service_media' => [
            'label' => 'Médias services manquants',
            'description' => 'Pages services sans image dédiée.',
        ],
    ],

    'statuses' => [
        'unknown' => 'Inconnu',
        'hidden' => 'Masqué',
        'agency' => [
            'operational' => 'Opérationnelle',
            'temporarily_closed' => 'Fermée temporairement',
        ],
        'service' => [
            'active' => 'Actif',
        ],
    ],
];
