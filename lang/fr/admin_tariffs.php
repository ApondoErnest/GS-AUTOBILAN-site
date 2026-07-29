<?php

return [
    'title' => 'Tarifs',
    'navigation_label' => 'Vue générale',
    'subtitle' => 'Suivez la préparation des tarifs publics, les lignes provisoires, les prix officiels et les mises à jour.',
    'empty_value' => 'Non renseigné',

    'command' => [
        'eyebrow' => 'Bureau tarifs',
        'heading' => 'Pilotage des tarifs publics',
        'description' => 'Gardez les tarifs par catégorie de véhicule alignés avec le site public, avec suivi des lignes provisoires, prix officiels, visibilité et dates de mise à jour.',
    ],

    'summary' => [
        'label' => 'Synthèse des tarifs',
        'active' => [
            'label' => 'Lignes visibles',
            'description' => ':total lignes tarifaires au total.',
        ],
        'official' => [
            'label' => 'Prix officiels',
            'description' => 'Lignes avec prix confirmés et prêtes pour les clients.',
        ],
        'placeholders' => [
            'label' => 'Provisoires',
            'description' => 'Lignes encore en attente de confirmation officielle.',
        ],
        'categories' => [
            'label' => 'Catégories',
            'description' => 'Catégories de véhicules représentées dans la grille.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Espace tarifs',
        'description' => 'Ouvrez les enregistrements du catalogue qui pilotent les lignes tarifaires publiques.',
        'empty' => 'Aucun espace tarifs n’est disponible pour votre rôle.',
        'tariffs' => [
            'label' => 'Catalogue tarifs',
            'description' => 'Gérez catégories de véhicules, prix, lignes provisoires, notes et visibilité.',
        ],
    ],

    'readiness' => [
        'heading' => 'Préparation publication',
        'description' => 'Niveau de préparation de la grille tarifaire pour le public.',
        'metric' => ':ready sur :total prêts',
        'visibility' => [
            'label' => 'Visibilité publique',
        ],
        'official_prices' => [
            'label' => 'Tarifs officiels',
        ],
        'update_dates' => [
            'label' => 'Dates de mise à jour',
        ],
        'bilingual_notes' => [
            'label' => 'Notes bilingues',
        ],
    ],

    'latest' => [
        'heading' => 'Dernières lignes tarifaires',
        'description' => 'Lignes tarifaires récemment mises à jour et état des prix.',
        'empty' => 'Aucune ligne tarifaire n’a encore été créée.',
    ],

    'attention' => [
        'heading' => 'File d’attention',
        'description' => 'Lignes qui demandent encore un prix officiel, une visibilité ou une révision.',
        'empty' => 'Aucune ligne tarifaire ne demande d’attention.',
        'placeholders' => [
            'label' => 'Lignes provisoires',
            'description' => 'Lignes encore marquées en attente de confirmation.',
        ],
        'missing_prices' => [
            'label' => 'Prix manquants',
            'description' => 'Lignes sans tarif public numérique.',
        ],
        'hidden_rows' => [
            'label' => 'Lignes masquées',
            'description' => 'Tarifs retirés de l’affichage public.',
        ],
        'missing_dates' => [
            'label' => 'Dates manquantes',
            'description' => 'Lignes sans horodatage officiel de mise à jour.',
        ],
    ],

    'statuses' => [
        'tariff' => [
            'placeholder' => 'Provisoire',
            'official' => 'Officiel',
        ],
    ],

    'resource' => [
        'navigation_label' => 'Tarifs',
        'model' => [
            'singular' => 'tarif',
            'plural' => 'tarifs',
        ],
        'pages' => [
            'list' => [
                'title' => 'Tarifs',
                'subtitle' => 'Gérez les lignes tarifaires publiques, les catégories, les états provisoires, les prix et les dates de mise à jour.',
            ],
            'create' => [
                'title' => 'Nouveau tarif',
                'subtitle' => 'Créez une ligne tarifaire par catégorie de véhicule pour la grille publique.',
            ],
            'edit' => [
                'title' => ':tariff',
                'subtitle' => 'Mettez à jour catégorie, prix, publication, notes et date officielle de mise à jour.',
            ],
        ],
        'actions' => [
            'create' => 'Nouveau tarif',
            'edit' => 'Modifier',
            'delete' => 'Supprimer',
            'delete_selected' => 'Supprimer la sélection',
        ],
        'table' => [
            'heading' => 'Catalogue tarifs',
            'description' => 'Une vue compacte des catégories de véhicules, prix officiels, lignes provisoires, notes et visibilité publique.',
            'empty_heading' => 'Aucun tarif',
            'empty_description' => 'Créez la première ligne pour commencer à structurer la grille tarifaire publique.',
            'columns' => [
                'vehicle' => 'Véhicule / catégorie',
                'category' => 'Catégorie',
                'price' => 'Tarif',
                'pricing_state' => 'État tarifaire',
                'visibility' => 'Visibilité',
                'last_updated' => 'Mis à jour',
                'order' => 'Ordre',
            ],
            'descriptions' => [
                'pending_price' => 'Tarif officiel en attente',
                'not_updated' => 'Non mis à jour',
                'no_notes' => 'Aucune note publique',
            ],
            'filters' => [
                'category' => 'Catégorie',
                'pricing_state' => 'État tarifaire',
                'visibility' => 'Visibilité publique',
                'missing_price' => 'Prix manquant',
                'updated_window' => 'Date officielle de mise à jour',
                'from' => 'Du',
                'until' => 'Au',
            ],
        ],
        'form' => [
            'sections' => [
                'vehicle' => [
                    'heading' => 'Véhicule et catégorie',
                    'description' => 'Clé catégorie, libellés bilingues, validité et ordre d’affichage.',
                ],
                'pricing' => [
                    'heading' => 'Prix et publication',
                    'description' => 'Montant officiel, devise, état provisoire, visibilité et date de mise à jour.',
                ],
                'notes' => [
                    'heading' => 'Notes publiques',
                    'description' => 'Contexte bilingue affiché avec la ligne tarifaire.',
                ],
            ],
            'fields' => [
                'category' => [
                    'label' => 'Catégorie',
                    'placeholder' => 'light',
                ],
                'vehicle_type_fr' => [
                    'label' => 'Type de véhicule FR',
                    'placeholder' => 'Véhicules légers',
                ],
                'vehicle_type_en' => [
                    'label' => 'Type de véhicule EN',
                    'placeholder' => 'Light vehicles',
                ],
                'validity' => [
                    'label' => 'Validité',
                    'placeholder' => 'Annuel',
                ],
                'sort_order' => [
                    'label' => 'Ordre d’affichage',
                ],
                'price' => [
                    'label' => 'Prix',
                    'placeholder' => '25000',
                ],
                'currency' => [
                    'label' => 'Devise',
                    'placeholder' => 'XAF',
                ],
                'last_updated_at' => [
                    'label' => 'Dernière mise à jour',
                ],
                'is_active' => [
                    'label' => 'Visible sur le site public',
                    'helper' => 'Désactivez pour garder la ligne en admin sans la publier.',
                ],
                'is_placeholder' => [
                    'label' => 'Ligne provisoire',
                    'helper' => 'Gardez activé tant que le tarif officiel n’a pas été confirmé.',
                ],
                'notes_fr' => [
                    'label' => 'Notes FR',
                    'placeholder' => 'Tarif officiel en attente de confirmation.',
                ],
                'notes_en' => [
                    'label' => 'Notes EN',
                    'placeholder' => 'Official tariff pending confirmation.',
                ],
            ],
        ],
        'statuses' => [
            'placeholder' => 'Provisoire',
            'official' => 'Officiel',
            'active' => 'Actif',
            'hidden' => 'Masqué',
        ],
        'categories' => [
            'light' => 'Véhicules légers',
            'utility' => 'Véhicules utilitaires',
            'taxi' => 'Taxis',
            'driving_school' => 'Auto-écoles',
            'public_transport' => 'Bus et transport public',
            'heavy_goods' => 'Poids lourds',
            'reinspection' => 'Contre-visite',
            'fleet' => 'Entreprises et parcs automobiles',
        ],
    ],
];
