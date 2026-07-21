<?php

return [
    'meta_title' => 'Suivre mon rendez-vous · GS AUTOBILAN',
    'hero' => [
        'eyebrow' => 'Suivi de demande',
        'title' => 'Suivez votre demande de rendez-vous',
        'lead' => 'Consultez la confirmation de votre rendez-vous et l’état de préparation de votre dossier.',
        'notice' => [
            'label' => 'Information',
            'body' => 'Ce service ne suit pas votre véhicule en temps réel sur la ligne de contrôle.',
            'confirmation' => 'Il présente uniquement le statut de votre demande de rendez-vous et la préparation de votre dossier.',
        ],
    ],
    'lookup' => [
        'title' => 'Retrouvez votre demande',
        'lead' => 'Saisissez les informations utilisées lors de votre demande de rendez-vous.',
        'help' => 'Besoin d’aide ?',
        'fields' => [
            'reference' => [
                'label' => 'Référence de demande',
                'placeholder' => 'Ex : GS-2026-NK-48192',
            ],
            'phone' => [
                'label' => 'Téléphone ou numéro WhatsApp',
                'placeholder' => 'Ex : +237 678 844 791',
            ],
            'registration' => [
                'label' => 'Immatriculation du véhicule',
                'placeholder' => 'Ex : LT-123-AB',
            ],
        ],
        'submit' => 'Suivre ma demande',
        'recovery_prompt' => 'Vous n’avez plus votre référence ?',
        'recovery_action' => 'Nous vous aidons à la retrouver',
    ],
    'result' => [
        'timeline' => [
            [
                'label' => 'Demande reçue',
                'meta' => '12 mai 2026',
                'state' => 'completed',
            ],
            [
                'label' => 'Rendez-vous confirmé',
                'meta' => '13 mai 2026',
                'state' => 'current',
            ],
            [
                'label' => 'Dossier prêt',
                'meta' => 'En cours',
                'state' => 'upcoming',
            ],
            [
                'label' => 'Passage prévu',
                'meta' => 'À venir',
                'state' => 'upcoming',
            ],
        ],
        'status' => [
            'label' => 'Confirmé',
            'title' => 'Votre passage a été confirmé par l’agence.',
            'body' => 'Nous vous attendons à la date confirmée avec les documents requis.',
            'download' => 'Télécharger le récapitulatif',
        ],
        'details' => [
            [
                'icon' => 'ticket',
                'label' => 'Référence',
                'value' => 'GS-2026-NK-48192',
            ],
            [
                'icon' => 'map',
                'label' => 'Agence',
                'value' => 'GS AUTOBILAN Nkolbisson',
            ],
            [
                'icon' => 'calendar',
                'label' => 'Date confirmée',
                'value' => '15 août 2026',
            ],
            [
                'icon' => 'service',
                'label' => 'Service',
                'value' => 'Visite technique périodique',
            ],
            [
                'icon' => 'vehicle',
                'label' => 'Véhicule',
                'value' => 'Véhicule léger',
            ],
            [
                'icon' => 'clock',
                'label' => 'Période / Heure confirmée',
                'value' => 'Matin (07h00 – 11h00)',
            ],
            [
                'icon' => 'plate',
                'label' => 'Immatriculation',
                'value' => 'LT-123-AB',
            ],
            [
                'icon' => 'calendar',
                'label' => 'Date demandée',
                'value' => '15 août 2026 (Matin)',
            ],
            [
                'icon' => 'whatsapp',
                'label' => 'Contact de confirmation',
                'value' => '+237 678 844 791',
            ],
        ],
        'dossier' => [
            'eyebrow' => 'État du dossier',
            'title' => 'Dossier à compléter',
            'body' => 'Certains éléments doivent être fournis avant votre passage.',
            'action' => 'Voir les éléments à compléter',
        ],
        'next_action' => [
            'eyebrow' => 'Prochaine étape',
            'title' => 'Veuillez compléter votre dossier.',
            'body' => 'Notre équipe vous contactera si des informations supplémentaires sont nécessaires.',
            'whatsapp' => 'Écrire sur WhatsApp',
            'call' => 'Appeler l’agence',
        ],
    ],
];
