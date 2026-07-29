<?php

return [
    'title' => 'Opérations',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Suivez les rendez-vous, la préparation des dossiers et la charge des agences depuis un espace opérationnel compact.',
    'empty_value' => 'Non défini',
    'command' => [
        'eyebrow' => 'Bureau opérations',
        'heading' => 'Pouls opérationnel du jour',
        'description' => 'Les rendez-vous, confirmations, alertes documentaires et charges agence restent visibles sans quitter la section.',
    ],
    'summary' => [
        'label' => 'Résumé des opérations',
        'today' => [
            'label' => 'Aujourd\'hui',
            'description' => 'Visites préférées datées du jour',
        ],
        'confirmations' => [
            'label' => 'Confirmations',
            'description' => 'Demandes nouvelles et en attente',
        ],
        'documents' => [
            'label' => 'Alertes dossier',
            'description' => 'Infos manquantes ou contact agence',
        ],
        'ready' => [
            'label' => 'Dossiers prêts',
            'description' => ':total dossiers documentaires',
        ],
    ],
    'quick_links' => [
        'heading' => 'Actions prioritaires',
        'description' => 'Accédez rapidement aux dossiers opérationnels à traiter.',
        'empty' => 'Aucun raccourci opérationnel n\'est disponible pour le périmètre agence actuel.',
        'bookings' => [
            'label' => 'Rendez-vous',
            'description' => 'Traiter les demandes',
        ],
        'documents' => [
            'label' => 'Documents',
            'description' => 'Contrôler la préparation',
        ],
    ],
    'workload' => [
        'heading' => 'Charge par agence',
        'description' => 'Réservations visibles regroupées par agence.',
        'metric' => 'réservations visibles',
        'empty' => 'Aucune charge agence disponible pour le moment.',
    ],
    'latest_bookings' => [
        'heading' => 'Derniers rendez-vous',
        'description' => 'Demandes récentes dans le périmètre opérationnel actuel.',
        'empty' => 'Aucun rendez-vous visible pour le moment.',
    ],
    'latest_documents' => [
        'heading' => 'Préparation dossiers',
        'description' => 'Dossiers récemment mis à jour et leur prochain état.',
        'empty' => 'Aucun dossier documentaire visible pour le moment.',
    ],
    'statuses' => [
        'unknown' => 'Inconnu',
        'booking' => [
            'new_request' => 'Nouvelle demande',
            'pending_confirmation' => 'En attente',
            'confirmed' => 'Confirmé',
            'rescheduled' => 'Reprogrammé',
            'cancelled' => 'Annulé',
            'completed' => 'Terminé',
            'no_show' => 'Absence',
        ],
        'document' => [
            'not_reviewed' => 'Non vérifié',
            'complete' => 'Complet',
            'missing_info' => 'Infos manquantes',
            'contact_agency' => 'Contacter agence',
            'ready_for_visit' => 'Prêt',
        ],
    ],
];
