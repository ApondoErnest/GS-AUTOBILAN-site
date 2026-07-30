<?php

return [
    'title' => 'Utilisateurs et réglages',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Gérez accès du personnel, rôles, paramètres système et audit depuis un espace de gouvernance unique.',
    'empty_value' => 'Non renseigné',

    'command' => [
        'eyebrow' => 'Bureau administration',
        'heading' => 'Pilotage accès et paramètres',
        'description' => 'Gardez comptes staff, permissions, périmètres agence, configuration et audit visibles dans une vue de pilotage compacte.',
    ],

    'summary' => [
        'label' => 'Synthèse utilisateurs et réglages',
        'users' => [
            'label' => 'Utilisateurs staff',
            'description' => 'Comptes admin enregistrés dans le système.',
        ],
        'active' => [
            'label' => 'Accès actifs',
            'description' => 'Utilisateurs actuellement autorisés dans l’admin.',
        ],
        'super_admins' => [
            'label' => 'Super admins',
            'description' => 'Comptes à privilèges élevés pouvant tout gérer.',
        ],
        'settings' => [
            'label' => 'Réglages',
            'description' => 'Enregistrements de configuration structurée.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Espaces d’accès',
        'description' => 'Ouvrez les enregistrements administratifs qui pilotent accès, configuration et audit.',
        'empty' => 'Aucun espace administratif n’est disponible pour votre rôle.',
        'users' => [
            'label' => 'Utilisateurs staff',
            'description' => 'Gérez noms, emails, rôles, périmètre agence, état actif et dernière connexion.',
        ],
        'settings' => [
            'label' => 'Réglages système',
            'description' => 'Revoyez les réglages JSON qui pilotent identité du site public et valeurs par défaut.',
        ],
        'audit' => [
            'label' => 'Journal d’audit',
            'description' => 'Consultez les événements administratifs récents en lecture seule.',
        ],
    ],

    'roles' => [
        'heading' => 'Couverture des rôles',
        'description' => 'Utilisateurs staff regroupés par rôle assigné.',
        'metric' => ':count sur :total utilisateurs staff',
    ],

    'latest_users' => [
        'heading' => 'Derniers utilisateurs',
        'description' => 'Comptes admin récemment mis à jour et leur état d’accès.',
        'empty' => 'Aucun utilisateur staff n’est encore enregistré.',
    ],

    'latest_activity' => [
        'heading' => 'Journal d’audit',
        'description' => 'Événements administratifs récents sur les enregistrements protégés.',
        'empty' => 'Aucune activité d’audit n’a encore été enregistrée.',
    ],

    'attention' => [
        'heading' => 'File d’attention',
        'description' => 'Éléments d’accès ou de gouvernance pouvant demander une revue.',
        'empty' => 'Aucun élément d’accès ou de réglage ne demande d’attention.',
        'inactive_users' => [
            'label' => 'Utilisateurs inactifs',
            'description' => 'Comptes actuellement bloqués de l’admin.',
        ],
        'unassigned_agency_admins' => [
            'label' => 'Admins agence sans agence',
            'description' => 'Les admins agence ont besoin d’une agence assignée pour travailler proprement.',
        ],
        'users_without_roles' => [
            'label' => 'Utilisateurs sans rôle',
            'description' => 'Les comptes sans rôle staff ne peuvent pas utiliser l’admin.',
        ],
        'recent_audit' => [
            'label' => 'Événements récents',
            'description' => 'Actions administratives enregistrées durant les dernières 24 heures.',
        ],
    ],
];
