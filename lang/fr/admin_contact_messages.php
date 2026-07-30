<?php

return [
    'navigation_label' => 'Messages',
    'empty_subject' => 'Message sans sujet',
    'empty_agency' => 'Aucune agence assignée',

    'model' => [
        'singular' => 'message de contact',
        'plural' => 'messages de contact',
    ],

    'pages' => [
        'list' => [
            'title' => 'Messages de contact',
            'subtitle' => 'Gérez les demandes publiques, le routage agence, les attributions, l’état et le suivi interne.',
        ],
        'create' => [
            'title' => 'Journaliser un message',
            'subtitle' => 'Enregistrez un contact client traité hors formulaire du site public.',
        ],
        'edit' => [
            'title' => ':message',
            'subtitle' => 'Mettez à jour le routage, l’état de réponse, l’attribution et les notes de suivi interne.',
        ],
    ],

    'actions' => [
        'create' => 'Journaliser',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
    ],

    'table' => [
        'heading' => 'Boîte de réception',
        'description' => 'Une vue compacte des demandes clients, agence responsable, état de réponse, attribution et date de réception.',
        'empty_heading' => 'Aucun message de contact',
        'empty_description' => 'Les demandes du formulaire de contact public apparaîtront ici.',
        'columns' => [
            'subject' => 'Sujet / message',
            'sender' => 'Expéditeur',
            'agency' => 'Agence',
            'status' => 'État de réponse',
            'assigned' => 'Assigné',
            'received' => 'Reçu',
        ],
        'descriptions' => [
            'unassigned' => 'Non attribué',
            'no_contact' => 'Aucun téléphone ou email',
            'no_message' => 'Aucun texte de message',
        ],
        'filters' => [
            'status' => 'État de réponse',
            'agency' => 'Agence',
            'unassigned' => 'Non attribué',
            'received_window' => 'Date de réception',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],

    'form' => [
        'sections' => [
            'sender' => [
                'heading' => 'Expéditeur et routage',
                'description' => 'Identité client, canaux de contact et agence responsable du suivi.',
            ],
            'message' => [
                'heading' => 'Demande client',
                'description' => 'Sujet et message reçus du client.',
            ],
            'handling' => [
                'heading' => 'Notes de traitement',
                'description' => 'État de réponse, responsable interne et contexte de suivi.',
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'Nom',
                'placeholder' => 'Nom du client',
            ],
            'phone' => [
                'label' => 'Téléphone',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'client@example.com',
            ],
            'agency_id' => [
                'label' => 'Agence',
            ],
            'subject' => [
                'label' => 'Sujet',
                'placeholder' => 'Demande d’information rendez-vous',
            ],
            'message' => [
                'label' => 'Message',
                'placeholder' => 'Demande client ou détail de suivi.',
            ],
            'status' => [
                'label' => 'État de réponse',
            ],
            'assigned_user_id' => [
                'label' => 'Utilisateur assigné',
            ],
            'internal_notes' => [
                'label' => 'Notes internes',
                'placeholder' => 'Notes privées de traitement pour l’équipe.',
            ],
        ],
    ],

    'statuses' => [
        'new' => 'Nouveau',
        'in_review' => 'En traitement',
        'responded' => 'Répondu',
        'closed' => 'Fermé',
        'spam' => 'Spam',
        'unknown' => 'Inconnu',
    ],
];
