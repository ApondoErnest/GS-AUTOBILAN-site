<?php

return [
    'navigation_label' => 'Settings',
    'empty_key' => 'No key',

    'model' => [
        'singular' => 'setting',
        'plural' => 'settings',
    ],

    'pages' => [
        'list' => [
            'title' => 'Settings',
            'subtitle' => 'Manage structured JSON configuration used by the public website and admin defaults.',
        ],
        'create' => [
            'title' => 'New setting',
            'subtitle' => 'Create a structured configuration record with a stable key and JSON value.',
        ],
        'edit' => [
            'title' => ':setting',
            'subtitle' => 'Update the JSON configuration value for this setting.',
        ],
    ],

    'actions' => [
        'create' => 'New setting',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
    ],

    'table' => [
        'heading' => 'System settings',
        'description' => 'A compact view of structured configuration keys, JSON values, and update history.',
        'empty_heading' => 'No settings yet',
        'empty_description' => 'Create the first setting to manage structured site configuration.',
        'columns' => [
            'key' => 'Key / area',
            'value' => 'JSON value',
            'updated' => 'Updated',
        ],
        'descriptions' => [
            'area' => ':area area',
        ],
        'filters' => [
            'identity' => 'Identity',
            'seo' => 'SEO',
            'contact' => 'Contact',
        ],
    ],

    'form' => [
        'sections' => [
            'key' => [
                'heading' => 'Configuration key',
                'description' => 'Stable identifier used by the application to load this setting.',
            ],
            'value' => [
                'heading' => 'Structured value',
                'description' => 'JSON payload stored for the setting. Keep it valid and intentional.',
            ],
        ],
        'fields' => [
            'key' => [
                'label' => 'Key',
                'placeholder' => 'site_identity',
            ],
            'value_json' => [
                'label' => 'Value JSON',
            ],
        ],
    ],
];
