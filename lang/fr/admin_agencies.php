<?php

return [
    'navigation_label' => 'Agences',
    'model' => [
        'singular' => 'agence',
        'plural' => 'agences',
    ],
    'pages' => [
        'list' => [
            'title' => 'Agences',
            'subtitle' => 'Gérez l’identité des agences, les contacts publics, le statut d’ouverture et la préparation localisation.',
        ],
        'create' => [
            'title' => 'Nouvelle agence',
            'subtitle' => 'Créez une fiche agence publique avec les détails bilingues de localisation et de contact.',
        ],
        'edit' => [
            'title' => ':agency',
            'subtitle' => 'Mettez à jour les détails publics, la visibilité, les contacts, horaires et informations carte.',
        ],
    ],
    'actions' => [
        'create' => 'Nouvelle agence',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
    ],
    'table' => [
        'heading' => 'Répertoire agences',
        'description' => 'Une vue compacte pour la visibilité, les contacts client, la couverture ville et la préparation publique des agences.',
        'empty_heading' => 'Aucune agence',
        'empty_description' => 'Créez la première fiche agence pour publier les détails réseau sur le site.',
        'columns' => [
            'agency' => 'Agence / localisation',
            'contact' => 'Contact',
            'status' => 'Visibilité',
            'order' => 'Ordre',
            'updated' => 'Mis à jour',
        ],
        'descriptions' => [
            'hidden' => 'Masquée du site public',
            'no_contact' => 'Aucun contact public',
            'no_location' => 'Aucune localisation',
            'no_phone' => 'Aucun téléphone',
            'not_set' => 'Non renseigné',
            'public' => 'Visible sur le site public',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Statut d’ouverture',
            'visibility' => 'Visibilité publique',
            'updated_window' => 'Date de mise à jour',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],
    'form' => [
        'sections' => [
            'identity' => [
                'heading' => 'Identité agence',
                'description' => 'Nom public, clé URL, ordre d’affichage et état d’ouverture.',
            ],
            'contact' => [
                'heading' => 'Contact public',
                'description' => 'Téléphone, WhatsApp, email et lien carte visibles par les clients.',
            ],
            'location' => [
                'heading' => 'Localisation',
                'description' => 'Adresse, ville, quartier et coordonnées cartographiques.',
            ],
            'hours' => [
                'heading' => 'Horaires',
                'description' => 'Horaires bilingues affichés sur le site public.',
            ],
            'descriptions' => [
                'heading' => 'Descriptions publiques',
                'description' => 'Contexte court de l’agence pour les pages visibles par les clients.',
            ],
        ],
        'fields' => [
            'name_fr' => [
                'label' => 'Nom FR',
                'placeholder' => 'GS AUTOBILAN Nkolbisson',
            ],
            'name_en' => [
                'label' => 'Nom EN',
                'placeholder' => 'GS AUTOBILAN Nkolbisson',
            ],
            'slug' => [
                'label' => 'Slug',
                'placeholder' => 'nkolbisson',
            ],
            'status' => [
                'label' => 'Statut d’ouverture',
            ],
            'is_active' => [
                'label' => 'Visible sur le site public',
                'helper' => 'Désactivez pour conserver l’agence en admin sans la publier.',
            ],
            'sort_order' => [
                'label' => 'Ordre d’affichage',
            ],
            'phones' => [
                'label' => 'Téléphones publics',
                'placeholder' => '+237 6XX XXX XXX',
                'helper' => 'Ajoutez un ou plusieurs numéros visibles par les clients.',
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'agence@example.com',
            ],
            'map_link' => [
                'label' => 'Lien carte',
                'placeholder' => 'https://maps.google.com/...',
            ],
            'address_fr' => [
                'label' => 'Adresse FR',
                'placeholder' => 'Carrefour Nkolbisson',
            ],
            'address_en' => [
                'label' => 'Adresse EN',
                'placeholder' => 'Nkolbisson junction',
            ],
            'city' => [
                'label' => 'Ville',
                'placeholder' => 'Yaoundé',
            ],
            'quarter' => [
                'label' => 'Quartier',
                'placeholder' => 'Nkolbisson',
            ],
            'latitude' => [
                'label' => 'Latitude',
            ],
            'longitude' => [
                'label' => 'Longitude',
            ],
            'opening_hours_fr' => [
                'label' => 'Horaires FR',
                'key' => 'Période',
                'value' => 'Horaires',
            ],
            'opening_hours_en' => [
                'label' => 'Horaires EN',
                'key' => 'Period',
                'value' => 'Hours',
            ],
            'description_fr' => [
                'label' => 'Description FR',
                'placeholder' => 'Description publique courte de cette agence.',
            ],
            'description_en' => [
                'label' => 'Description EN',
                'placeholder' => 'Brief public description of this agency.',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Inconnu',
        'agency' => [
            'operational' => 'Opérationnelle',
            'temporarily_closed' => 'Fermée temporairement',
        ],
    ],
];
