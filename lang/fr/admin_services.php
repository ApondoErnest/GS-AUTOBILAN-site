<?php

return [
    'navigation_label' => 'Services',
    'model' => [
        'singular' => 'service',
        'plural' => 'services',
    ],
    'pages' => [
        'list' => [
            'title' => 'Services',
            'subtitle' => 'Gérez les pages services publiques, résumés bilingues, images, ordre et visibilité.',
        ],
        'create' => [
            'title' => 'Nouveau service',
            'subtitle' => 'Créez une page service visible par les clients dans le catalogue public.',
        ],
        'edit' => [
            'title' => ':service',
            'subtitle' => 'Mettez à jour textes bilingues, média, ordre, visibilité et contenu détaillé.',
        ],
    ],
    'actions' => [
        'create' => 'Nouveau service',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
    ],
    'table' => [
        'heading' => 'Catalogue services',
        'description' => 'Une vue compacte pour la visibilité, les résumés bilingues, la préparation média et l’ordre du catalogue public.',
        'empty_heading' => 'Aucun service',
        'empty_description' => 'Créez le premier service pour commencer à structurer le catalogue public.',
        'copy_slug' => 'Slug copié',
        'columns' => [
            'image' => 'Image',
            'service' => 'Service / résumé',
            'slugs' => 'Slugs',
            'icon' => 'Clé icône',
            'visibility' => 'Visibilité',
            'order' => 'Ordre',
            'updated' => 'Mis à jour',
        ],
        'descriptions' => [
            'no_english_slug' => 'Aucun slug anglais',
            'no_summary' => 'Aucun résumé',
            'not_set' => 'Non renseigné',
        ],
        'filters' => [
            'visibility' => 'Visibilité publique',
            'missing_image' => 'Image manquante',
            'updated_window' => 'Date de mise à jour',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],
    'form' => [
        'sections' => [
            'content' => [
                'heading' => 'Contenu service bilingue',
                'description' => 'Titres publics, clés URL et résumés courts du catalogue services.',
            ],
            'display' => [
                'heading' => 'Média et visibilité',
                'description' => 'Image, clé icône, ordre d’affichage et état de publication.',
            ],
            'descriptions' => [
                'heading' => 'Descriptions détaillées',
                'description' => 'Contenu long bilingue utilisé sur les pages détail service.',
            ],
        ],
        'fields' => [
            'title_fr' => [
                'label' => 'Titre FR',
                'placeholder' => 'Contrôle technique',
            ],
            'title_en' => [
                'label' => 'Titre EN',
                'placeholder' => 'Technical inspection',
            ],
            'slug_fr' => [
                'label' => 'Slug FR',
                'placeholder' => 'controle-technique',
            ],
            'slug_en' => [
                'label' => 'Slug EN',
                'placeholder' => 'technical-inspection',
            ],
            'short_description_fr' => [
                'label' => 'Résumé court FR',
                'placeholder' => 'Résumé court affiché dans le catalogue.',
            ],
            'short_description_en' => [
                'label' => 'Résumé court EN',
                'placeholder' => 'Short summary shown in the catalogue.',
            ],
            'icon' => [
                'label' => 'Clé icône',
                'placeholder' => 'truck',
                'helper' => 'Clé optionnelle utilisée par les composants publics.',
            ],
            'image' => [
                'label' => 'Image du service',
            ],
            'sort_order' => [
                'label' => 'Ordre d’affichage',
            ],
            'is_active' => [
                'label' => 'Visible sur le site public',
                'helper' => 'Désactivez pour conserver le service en admin sans le publier.',
            ],
            'full_description_fr' => [
                'label' => 'Description complète FR',
                'placeholder' => 'Description publique détaillée en français.',
            ],
            'full_description_en' => [
                'label' => 'Description complète EN',
                'placeholder' => 'Detailed public service description in English.',
            ],
        ],
    ],
    'statuses' => [
        'visibility' => [
            'active' => 'Actif',
            'hidden' => 'Masqué',
        ],
    ],
];
