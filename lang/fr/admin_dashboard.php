<?php

return [
    'title' => 'Tableau de bord admin',
    'navigation_label' => 'Tableau de bord',
    'header' => [
        'eyebrow' => 'Centre de commandement des opérations',
        'heading' => 'Tableau de bord admin',
        'intro' => 'Suivez les rendez-vous, la charge des agences, les dossiers à préparer et les signaux de contenu depuis un espace professionnel.',
        'language_label' => 'Langue',
        'role_label' => 'Rôle',
        'scope_label' => 'Périmètre',
        'updated_label' => 'Mis à jour',
        'status_label' => 'Espace sécurisé',
        'status_value' => 'Accès protégé',
    ],
    'roles' => [
        'super_admin' => 'Super admin',
        'agency_admin' => 'Admin agence',
        'content_manager' => 'Gestionnaire contenu',
        'staff' => 'Personnel',
    ],
    'scopes' => [
        'all_agencies' => 'Toutes les agences',
        'agency_unassigned' => 'Agence non affectée',
        'content_workspace' => 'Espace contenu',
        'staff_workspace' => 'Espace personnel',
        'general' => 'Général',
    ],
    'widgets' => [
        'booking' => [
            'heading' => 'Vue opérationnelle',
            'description' => 'Demandes et résultats de rendez-vous pour les opérations visibles.',
            'total' => [
                'label' => 'Total réservations',
                'description' => 'Toutes les demandes visibles',
            ],
            'new' => [
                'label' => 'Nouvelles demandes',
                'description' => 'En attente de première revue',
            ],
            'pending' => [
                'label' => 'Confirmations en attente',
                'description' => 'Rendez-vous à confirmer',
            ],
            'confirmed' => [
                'label' => 'Confirmés',
                'description' => 'Prêts pour la visite',
            ],
            'completed' => [
                'label' => 'Terminés',
                'description' => 'Rendez-vous finalisés',
            ],
            'no_show' => [
                'label' => 'Absences',
                'description' => 'Rendez-vous manqués',
            ],
        ],
        'agency' => [
            'heading' => 'Charge par agence',
            'description' => 'Réservations regroupées selon votre périmètre agence.',
            'visible_bookings' => 'Réservations visibles',
        ],
        'alerts' => [
            'heading' => 'File d’attention',
            'description' => 'Suivis opérationnels et signaux de contenu publiable.',
            'missing_info' => [
                'label' => 'Informations manquantes',
                'description' => 'Alertes de préparation dossier',
            ],
            'contact_agency' => [
                'label' => 'Contacter l’agence',
                'description' => 'Le client doit appeler ou passer',
            ],
            'new_contacts' => [
                'label' => 'Nouveaux messages',
                'description' => 'Messages publics non traités',
            ],
            'published_articles' => [
                'label' => 'Articles publiés',
                'description' => 'Actualités et conseils visibles',
            ],
        ],
        'activity' => [
            'heading' => 'Dernière activité',
            'description' => 'Signaux récents de contact et de contenu pour le périmètre du personnel.',
            'contacts_heading' => 'Messages de contact',
            'articles_heading' => 'Mises à jour contenu',
            'empty_contacts' => 'Aucun message de contact pour le moment.',
            'empty_articles' => 'Aucun article pour le moment.',
            'subject_fallback' => 'Message sans titre',
            'article_fallback' => 'Article sans titre',
        ],
    ],
    'statuses' => [
        'draft' => 'Brouillon',
        'published' => 'Publié',
        'archived' => 'Archivé',
    ],
];
