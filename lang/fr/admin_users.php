<?php

return [
    'navigation_label' => 'Utilisateurs',
    'empty_user' => 'Utilisateur sans nom',
    'empty_agency' => 'Aucune agence assignée',
    'empty_roles' => 'Aucun rôle assigné',

    'model' => [
        'singular' => 'utilisateur',
        'plural' => 'utilisateurs',
    ],

    'pages' => [
        'list' => [
            'title' => 'Utilisateurs',
            'subtitle' => 'Gérez identité staff, rôles, périmètre agence, accès actif et dernière connexion.',
        ],
        'create' => [
            'title' => 'Nouvel utilisateur',
            'subtitle' => 'Créez un compte staff et assignez le bon rôle admin avant de donner l’accès.',
        ],
        'edit' => [
            'title' => ':user',
            'subtitle' => 'Mettez à jour identité, périmètre agence, état actif et rôles.',
        ],
    ],

    'actions' => [
        'create' => 'Nouvel utilisateur',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
    ],

    'table' => [
        'heading' => 'Répertoire staff',
        'description' => 'Une vue compacte du contrôle d’accès: identité, rôles, agence, état et dernière connexion.',
        'empty_heading' => 'Aucun utilisateur',
        'empty_description' => 'Créez le premier compte staff pour commencer à gérer les accès admin.',
        'columns' => [
            'user' => 'Staff / identité',
            'roles' => 'Rôles',
            'agency' => 'Périmètre agence',
            'status' => 'État d’accès',
            'last_login' => 'Dernière connexion',
        ],
        'descriptions' => [
            'never_logged_in' => 'Jamais connecté',
        ],
        'filters' => [
            'status' => 'État d’accès',
            'agency' => 'Périmètre agence',
            'role' => 'Rôle',
            'without_roles' => 'Sans rôle',
        ],
    ],

    'form' => [
        'sections' => [
            'identity' => [
                'heading' => 'Identité utilisateur',
                'description' => 'Nom, email et mot de passe pour l’authentification staff.',
            ],
            'access' => [
                'heading' => 'Accès et agence',
                'description' => 'État d’accès admin, agence assignée et dernière connexion.',
            ],
            'roles' => [
                'heading' => 'Rôles staff',
                'description' => 'Choisissez le profil de permissions qui contrôle ce que le membre peut gérer.',
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'Nom',
                'placeholder' => 'Nom du membre staff',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'staff@example.com',
            ],
            'password' => [
                'label' => 'Mot de passe',
                'placeholder' => 'Laissez vide pour conserver le mot de passe actuel',
            ],
            'assigned_agency_id' => [
                'label' => 'Agence assignée',
            ],
            'is_active' => [
                'label' => 'Accès admin actif',
                'helper' => 'Les utilisateurs inactifs ne peuvent pas accéder à l’admin.',
            ],
            'last_login_at' => [
                'label' => 'Dernière connexion',
            ],
            'roles' => [
                'label' => 'Rôles',
            ],
        ],
    ],

    'roles' => [
        'super_admin' => 'Super admin',
        'agency_admin' => 'Admin agence',
        'content_manager' => 'Gestionnaire contenu',
    ],

    'statuses' => [
        'active' => 'Actif',
        'inactive' => 'Inactif',
    ],
];
