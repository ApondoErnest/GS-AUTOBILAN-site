<?php

return [
    'navigation_label' => 'Préparation dossiers',
    'model' => [
        'singular' => 'dossier documentaire',
        'plural' => 'dossiers documentaires',
    ],
    'pages' => [
        'list' => [
            'title' => 'Préparation dossiers',
            'subtitle' => 'Gérez l\'état de vérification, les informations manquantes et les prochaines actions publiques.',
        ],
        'edit' => [
            'title' => 'Dossier :reference',
            'subtitle' => 'Mettez à jour le statut du dossier et les messages de suivi visibles par le client.',
        ],
    ],
    'actions' => [
        'edit' => 'Modifier',
    ],
    'table' => [
        'heading' => 'Bureau préparation dossiers',
        'description' => 'Une vue compacte pour les dossiers, l\'agence responsable, l\'état documentaire et la prochaine action client.',
        'empty_heading' => 'Aucun dossier documentaire',
        'empty_description' => 'Les dossiers documentaires sont créés automatiquement à l\'arrivée des rendez-vous publics.',
        'copy_reference' => 'Référence copiée',
        'columns' => [
            'reference' => 'RDV / client',
            'contact' => 'Contact',
            'agency' => 'Agence / service',
            'booking_status' => 'Statut RDV',
            'readiness' => 'Dossier',
            'note' => 'Note de suivi',
            'updated' => 'Mis à jour',
        ],
        'descriptions' => [
            'missing_contact' => 'Aucun contact secondaire',
            'no_missing_info' => 'Aucune information manquante',
            'no_next_action' => 'Aucune prochaine action publique',
            'not_set' => 'Non défini',
            'not_updated_by' => 'Non assigné',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Statut dossier',
            'agency' => 'Agence',
            'booking_status' => 'Statut rendez-vous',
            'updated_window' => 'Date de mise à jour',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],
    'form' => [
        'sections' => [
            'booking' => [
                'heading' => 'Contexte rendez-vous',
                'description' => 'Le rendez-vous public lié à ce dossier. Ce lien est géré par le flux de réservation.',
            ],
            'status' => [
                'heading' => 'Statut du dossier',
                'description' => 'Définissez l\'état documentaire et la note privée sur les informations manquantes.',
            ],
            'public_actions' => [
                'heading' => 'Prochaines actions publiques',
                'description' => 'Instructions client et messages de suivi dans les deux langues.',
            ],
        ],
        'fields' => [
            'booking_id' => [
                'label' => 'Rendez-vous',
                'helper' => 'Créé automatiquement depuis la demande de rendez-vous publique.',
            ],
            'updated_by' => [
                'label' => 'Dernière mise à jour par',
            ],
            'status' => [
                'label' => 'Statut du dossier',
            ],
            'missing_information_note' => [
                'label' => 'Informations manquantes',
                'placeholder' => 'Note interne sur les documents ou détails encore nécessaires',
            ],
            'next_action_fr' => [
                'label' => 'Prochaine action FR',
                'placeholder' => 'Instruction affichée aux clients francophones',
            ],
            'next_action_en' => [
                'label' => 'Prochaine action EN',
                'placeholder' => 'Instruction affichée aux clients anglophones',
            ],
            'public_message_fr' => [
                'label' => 'Message public FR',
                'placeholder' => 'Message de suivi affiché en français',
            ],
            'public_message_en' => [
                'label' => 'Message public EN',
                'placeholder' => 'Message de suivi affiché en anglais',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Inconnu',
        'document' => [
            'not_reviewed' => 'Non vérifié',
            'complete' => 'Complet',
            'missing_info' => 'Informations manquantes',
            'contact_agency' => 'Contacter agence',
            'ready_for_visit' => 'Prêt pour visite',
        ],
    ],
];
