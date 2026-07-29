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
            'subtitle' => 'Manage public service pages, bilingual summaries, images, ordering, and visibility.',
        ],
        'create' => [
            'title' => 'New service',
            'subtitle' => 'Create a customer-facing service page for the public catalogue.',
        ],
        'edit' => [
            'title' => ':service',
            'subtitle' => 'Update bilingual copy, media, ordering, visibility, and detailed service content.',
        ],
    ],
    'actions' => [
        'create' => 'New service',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
    ],
    'table' => [
        'heading' => 'Service catalogue',
        'description' => 'A compact working view for public service visibility, bilingual summaries, media readiness, and catalogue order.',
        'empty_heading' => 'No services yet',
        'empty_description' => 'Create the first service to start building the public service catalogue.',
        'copy_slug' => 'Slug copied',
        'columns' => [
            'image' => 'Image',
            'service' => 'Service / summary',
            'slugs' => 'Slugs',
            'icon' => 'Icon key',
            'visibility' => 'Visibility',
            'order' => 'Order',
            'updated' => 'Updated',
        ],
        'descriptions' => [
            'no_english_slug' => 'No English slug',
            'no_summary' => 'No summary set',
            'not_set' => 'Not set',
        ],
        'filters' => [
            'visibility' => 'Public visibility',
            'missing_image' => 'Missing image',
            'updated_window' => 'Updated date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],
    'form' => [
        'sections' => [
            'content' => [
                'heading' => 'Bilingual service content',
                'description' => 'Public titles, URL keys, and short summaries for the service catalogue.',
            ],
            'display' => [
                'heading' => 'Media and visibility',
                'description' => 'Image, icon key, sort order, and public display state.',
            ],
            'descriptions' => [
                'heading' => 'Detailed descriptions',
                'description' => 'Long-form bilingual copy used on service detail pages.',
            ],
        ],
        'fields' => [
            'title_fr' => [
                'label' => 'Title FR',
                'placeholder' => 'Contrôle technique',
            ],
            'title_en' => [
                'label' => 'Title EN',
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
                'label' => 'Short description FR',
                'placeholder' => 'Résumé court affiché dans le catalogue.',
            ],
            'short_description_en' => [
                'label' => 'Short description EN',
                'placeholder' => 'Short summary shown in the catalogue.',
            ],
            'icon' => [
                'label' => 'Icon key',
                'placeholder' => 'truck',
                'helper' => 'Optional key used by public service components.',
            ],
            'image' => [
                'label' => 'Service image',
            ],
            'sort_order' => [
                'label' => 'Sort order',
            ],
            'is_active' => [
                'label' => 'Visible on public site',
                'helper' => 'Turn off to keep the service in admin without publishing it.',
            ],
            'full_description_fr' => [
                'label' => 'Full description FR',
                'placeholder' => 'Detailed public service description in French.',
            ],
            'full_description_en' => [
                'label' => 'Full description EN',
                'placeholder' => 'Detailed public service description in English.',
            ],
        ],
    ],
    'statuses' => [
        'visibility' => [
            'active' => 'Active',
            'hidden' => 'Hidden',
        ],
    ],
];
