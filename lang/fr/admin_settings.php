<?php

return [
    'navigation_label' => 'Réglages',
    'empty_key' => 'Aucune clé',

    'model' => [
        'singular' => 'réglage',
        'plural' => 'réglages',
    ],

    'pages' => [
        'list' => [
            'title' => 'Réglages',
            'subtitle' => 'Gérez la configuration JSON structurée utilisée par le site public et les valeurs admin.',
        ],
        'create' => [
            'title' => 'Nouveau réglage',
            'subtitle' => 'Créez un enregistrement de configuration avec une clé stable et une valeur JSON.',
        ],
        'edit' => [
            'title' => ':setting',
            'subtitle' => 'Mettez à jour la valeur JSON de ce réglage.',
        ],
    ],

    'actions' => [
        'create' => 'Nouveau réglage',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
    ],

    'table' => [
        'heading' => 'Réglages système',
        'description' => 'Une vue compacte des clés de configuration, valeurs JSON et historique de mise à jour.',
        'empty_heading' => 'Aucun réglage',
        'empty_description' => 'Créez le premier réglage pour gérer la configuration structurée du site.',
        'columns' => [
            'key' => 'Clé / zone',
            'value' => 'Valeur JSON',
            'updated' => 'Mis à jour',
        ],
        'descriptions' => [
            'area' => 'Zone :area',
        ],
        'filters' => [
            'identity' => 'Identité',
            'seo' => 'SEO',
            'contact' => 'Contact',
        ],
    ],

    'form' => [
        'sections' => [
            'key' => [
                'heading' => 'Clé de configuration',
                'description' => 'Identifiant stable utilisé par l’application pour charger ce réglage.',
            ],
            'value' => [
                'heading' => 'Valeur structurée',
                'description' => 'Payload JSON stocké pour le réglage. Gardez-le valide et volontaire.',
            ],
        ],
        'fields' => [
            'key' => [
                'label' => 'Clé',
                'placeholder' => 'site_identity',
            ],
            'value_json' => [
                'label' => 'Valeur JSON',
            ],
        ],
    ],
];
