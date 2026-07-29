<?php

return [
    'meta_title' => 'Suivre mon rendez-vous · GS AUTOBILAN',
    'meta_description' => 'Suivez votre demande de rendez-vous GS AUTOBILAN avec votre référence, téléphone et immatriculation du véhicule.',
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
        'errors' => [
            'validation' => 'Veuillez vérifier les trois informations de suivi puis réessayer.',
            'not_found' => 'Aucune demande ne correspond à ces trois informations. Vérifiez votre référence, votre téléphone et votre immatriculation.',
            'throttled' => 'Trop de tentatives de suivi. Réessayez dans :minutes min.',
        ],
        'recovery_prompt' => 'Vous n’avez plus votre référence ?',
        'recovery_action' => 'Nous vous aidons à la retrouver',
    ],
    'result' => [
        'empty' => 'À confirmer',
        'status_labels' => [
            'new_request' => 'Nouvelle demande',
            'pending_confirmation' => 'En attente de confirmation',
            'confirmed' => 'Confirmé',
            'rescheduled' => 'Reprogrammé',
            'cancelled' => 'Annulé',
            'completed' => 'Terminé',
            'no_show' => 'Absence',
        ],
        'status_titles' => [
            'new_request' => 'Votre demande a été reçue.',
            'pending_confirmation' => 'Votre demande est en cours de vérification.',
            'confirmed' => 'Votre passage a été confirmé par l’agence.',
            'rescheduled' => 'Votre rendez-vous doit être reprogrammé.',
            'cancelled' => 'Votre demande a été annulée.',
            'completed' => 'Votre passage est terminé.',
            'no_show' => 'Votre passage est marqué absent.',
        ],
        'status_bodies' => [
            'new_request' => 'Notre équipe doit encore confirmer le créneau exact.',
            'pending_confirmation' => 'Un agent vérifie la disponibilité et vous contactera pour finaliser le créneau.',
            'confirmed' => 'Nous vous attendons à la date confirmée avec les documents requis.',
            'rescheduled' => 'Veuillez suivre les indications de l’agence pour choisir un nouveau créneau.',
            'cancelled' => 'Contactez l’agence si vous souhaitez soumettre une nouvelle demande.',
            'completed' => 'Merci d’avoir effectué votre passage chez GS AUTOBILAN.',
            'no_show' => 'Contactez l’agence pour connaître les possibilités de reprogrammation.',
        ],
        'document_labels' => [
            'not_reviewed' => 'Non vérifié',
            'complete' => 'Complet',
            'missing_info' => 'Informations manquantes',
            'contact_agency' => 'Contacter l’agence',
            'ready_for_visit' => 'Prêt pour le passage',
        ],
        'dynamic_details' => [
            'reference' => 'Référence',
            'agency' => 'Agence',
            'requested_date' => 'Date demandée',
            'requested_time' => 'Période demandée',
            'confirmed_date' => 'Date confirmée',
            'confirmed_time' => 'Heure confirmée',
            'booking_status' => 'Statut de demande',
            'document_status' => 'État du dossier',
        ],
        'messages' => [
            'title' => 'Message public',
            'fallback' => 'Aucun message public supplémentaire pour le moment.',
        ],
        'no_next_action' => 'Aucune action spécifique n’est demandée pour le moment.',
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
