<?php

return [
    'title' => 'Tariffs',
    'navigation_label' => 'Overview',
    'subtitle' => 'Monitor public tariff readiness, placeholder rows, official pricing, and update status.',
    'empty_value' => 'Not set',

    'command' => [
        'eyebrow' => 'Tariff desk',
        'heading' => 'Public tariff control',
        'description' => 'Keep vehicle-category tariffs aligned with the public website while tracking placeholders, official prices, visibility, and update dates.',
    ],

    'summary' => [
        'label' => 'Tariff summary',
        'active' => [
            'label' => 'Visible rows',
            'description' => ':total total tariff rows.',
        ],
        'official' => [
            'label' => 'Official prices',
            'description' => 'Rows with confirmed prices ready for customers.',
        ],
        'placeholders' => [
            'label' => 'Placeholders',
            'description' => 'Rows still waiting for official tariff confirmation.',
        ],
        'categories' => [
            'label' => 'Categories',
            'description' => 'Vehicle categories represented in the matrix.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Tariff workspace',
        'description' => 'Open the catalogue records that control public tariff rows.',
        'empty' => 'No tariff workspace is available for your role.',
        'tariffs' => [
            'label' => 'Tariff catalogue',
            'description' => 'Manage vehicle categories, prices, placeholders, notes, and visibility.',
        ],
    ],

    'readiness' => [
        'heading' => 'Publication readiness',
        'description' => 'How ready the tariff matrix is for public use.',
        'metric' => ':ready of :total ready',
        'visibility' => [
            'label' => 'Public visibility',
        ],
        'official_prices' => [
            'label' => 'Official pricing',
        ],
        'update_dates' => [
            'label' => 'Update dates',
        ],
        'bilingual_notes' => [
            'label' => 'Bilingual notes',
        ],
    ],

    'latest' => [
        'heading' => 'Latest tariff rows',
        'description' => 'Recently updated tariff records and pricing state.',
        'empty' => 'No tariff rows have been created yet.',
    ],

    'attention' => [
        'heading' => 'Attention queue',
        'description' => 'Rows that still need official pricing, visibility, or update review.',
        'empty' => 'No tariff rows need attention.',
        'placeholders' => [
            'label' => 'Placeholder rows',
            'description' => 'Rows still marked as pending confirmation.',
        ],
        'missing_prices' => [
            'label' => 'Missing prices',
            'description' => 'Rows without a numeric public tariff.',
        ],
        'hidden_rows' => [
            'label' => 'Hidden rows',
            'description' => 'Tariffs removed from public display.',
        ],
        'missing_dates' => [
            'label' => 'Missing update dates',
            'description' => 'Rows without an official update timestamp.',
        ],
    ],

    'statuses' => [
        'tariff' => [
            'placeholder' => 'Placeholder',
            'official' => 'Official',
        ],
    ],

    'resource' => [
        'navigation_label' => 'Tariffs',
        'model' => [
            'singular' => 'tariff',
            'plural' => 'tariffs',
        ],
        'pages' => [
            'list' => [
                'title' => 'Tariffs',
                'subtitle' => 'Manage public tariff rows, category coverage, placeholder status, prices, and update dates.',
            ],
            'create' => [
                'title' => 'New tariff',
                'subtitle' => 'Create a vehicle-category tariff row for the public matrix.',
            ],
            'edit' => [
                'title' => ':tariff',
                'subtitle' => 'Update category, pricing, publication status, notes, and official update timing.',
            ],
        ],
        'actions' => [
            'create' => 'New tariff',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'delete_selected' => 'Delete selected',
        ],
        'table' => [
            'heading' => 'Tariff catalogue',
            'description' => 'A compact working view for vehicle categories, official pricing, placeholders, notes, and public visibility.',
            'empty_heading' => 'No tariffs yet',
            'empty_description' => 'Create the first tariff row to start building the public tariff matrix.',
            'columns' => [
                'vehicle' => 'Vehicle / category',
                'category' => 'Category',
                'price' => 'Tariff',
                'pricing_state' => 'Pricing state',
                'visibility' => 'Visibility',
                'last_updated' => 'Updated',
                'order' => 'Order',
            ],
            'descriptions' => [
                'pending_price' => 'Pending official tariff',
                'not_updated' => 'Not updated',
                'no_notes' => 'No public notes',
            ],
            'filters' => [
                'category' => 'Category',
                'pricing_state' => 'Pricing state',
                'visibility' => 'Public visibility',
                'missing_price' => 'Missing price',
                'updated_window' => 'Official update date',
                'from' => 'From',
                'until' => 'Until',
            ],
        ],
        'form' => [
            'sections' => [
                'vehicle' => [
                    'heading' => 'Vehicle and category',
                    'description' => 'Category key, bilingual vehicle labels, validity, and display order.',
                ],
                'pricing' => [
                    'heading' => 'Price and publication',
                    'description' => 'Official amount, currency, placeholder state, visibility, and update timing.',
                ],
                'notes' => [
                    'heading' => 'Public notes',
                    'description' => 'Bilingual context displayed with the tariff row.',
                ],
            ],
            'fields' => [
                'category' => [
                    'label' => 'Category',
                    'placeholder' => 'light',
                ],
                'vehicle_type_fr' => [
                    'label' => 'Vehicle type FR',
                    'placeholder' => 'Vehicules legers',
                ],
                'vehicle_type_en' => [
                    'label' => 'Vehicle type EN',
                    'placeholder' => 'Light vehicles',
                ],
                'validity' => [
                    'label' => 'Validity',
                    'placeholder' => 'Annual',
                ],
                'sort_order' => [
                    'label' => 'Sort order',
                ],
                'price' => [
                    'label' => 'Price',
                    'placeholder' => '25000',
                ],
                'currency' => [
                    'label' => 'Currency',
                    'placeholder' => 'XAF',
                ],
                'last_updated_at' => [
                    'label' => 'Last updated',
                ],
                'is_active' => [
                    'label' => 'Visible on public site',
                    'helper' => 'Turn off to keep the row in admin without publishing it.',
                ],
                'is_placeholder' => [
                    'label' => 'Placeholder row',
                    'helper' => 'Keep enabled until the official tariff has been confirmed.',
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
            'placeholder' => 'Placeholder',
            'official' => 'Official',
            'active' => 'Active',
            'hidden' => 'Hidden',
        ],
        'categories' => [
            'light' => 'Light vehicles',
            'utility' => 'Utility vehicles',
            'taxi' => 'Taxis',
            'driving_school' => 'Driving schools',
            'public_transport' => 'Buses & public transport',
            'heavy_goods' => 'Heavy goods vehicles',
            'reinspection' => 'Re-inspection',
            'fleet' => 'Companies & vehicle fleets',
        ],
    ],
];
