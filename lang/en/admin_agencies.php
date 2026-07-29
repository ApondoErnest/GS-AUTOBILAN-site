<?php

return [
    'navigation_label' => 'Agencies',
    'model' => [
        'singular' => 'agency',
        'plural' => 'agencies',
    ],
    'pages' => [
        'list' => [
            'title' => 'Agencies',
            'subtitle' => 'Manage branch identity, public contacts, opening status, and location readiness.',
        ],
        'create' => [
            'title' => 'New agency',
            'subtitle' => 'Create a public branch profile with bilingual location and contact details.',
        ],
        'edit' => [
            'title' => ':agency',
            'subtitle' => 'Update public branch details, visibility, contacts, hours, and map information.',
        ],
    ],
    'actions' => [
        'create' => 'New agency',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
    ],
    'table' => [
        'heading' => 'Agency directory',
        'description' => 'A compact working view for branch visibility, customer contacts, city coverage, and public readiness.',
        'empty_heading' => 'No agencies yet',
        'empty_description' => 'Create the first agency profile to publish branch details on the website.',
        'columns' => [
            'agency' => 'Agency / location',
            'contact' => 'Contact',
            'status' => 'Visibility',
            'order' => 'Order',
            'updated' => 'Updated',
        ],
        'descriptions' => [
            'hidden' => 'Hidden from public site',
            'no_contact' => 'No public contact',
            'no_location' => 'No location set',
            'no_phone' => 'No phone',
            'not_set' => 'Not set',
            'public' => 'Visible on public site',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Opening status',
            'visibility' => 'Public visibility',
            'updated_window' => 'Updated date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],
    'form' => [
        'sections' => [
            'identity' => [
                'heading' => 'Agency identity',
                'description' => 'Public branch name, URL key, display order, and opening state.',
            ],
            'contact' => [
                'heading' => 'Public contact',
                'description' => 'Customer-facing phone, WhatsApp, email, and map link.',
            ],
            'location' => [
                'heading' => 'Location',
                'description' => 'Address, city coverage, quarter, and map coordinates.',
            ],
            'hours' => [
                'heading' => 'Opening hours',
                'description' => 'Bilingual hours shown on the public website.',
            ],
            'descriptions' => [
                'heading' => 'Public descriptions',
                'description' => 'Short branch context for customer-facing agency pages.',
            ],
        ],
        'fields' => [
            'name_fr' => [
                'label' => 'Name FR',
                'placeholder' => 'GS AUTOBILAN Nkolbisson',
            ],
            'name_en' => [
                'label' => 'Name EN',
                'placeholder' => 'GS AUTOBILAN Nkolbisson',
            ],
            'slug' => [
                'label' => 'Slug',
                'placeholder' => 'nkolbisson',
            ],
            'status' => [
                'label' => 'Opening status',
            ],
            'is_active' => [
                'label' => 'Visible on public site',
                'helper' => 'Turn off to keep the branch in admin without publishing it.',
            ],
            'sort_order' => [
                'label' => 'Sort order',
            ],
            'phones' => [
                'label' => 'Public phones',
                'placeholder' => '+237 6XX XXX XXX',
                'helper' => 'Add one or more customer-facing phone numbers.',
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'agency@example.com',
            ],
            'map_link' => [
                'label' => 'Map link',
                'placeholder' => 'https://maps.google.com/...',
            ],
            'address_fr' => [
                'label' => 'Address FR',
                'placeholder' => 'Carrefour Nkolbisson',
            ],
            'address_en' => [
                'label' => 'Address EN',
                'placeholder' => 'Nkolbisson junction',
            ],
            'city' => [
                'label' => 'City',
                'placeholder' => 'Yaounde',
            ],
            'quarter' => [
                'label' => 'Quarter',
                'placeholder' => 'Nkolbisson',
            ],
            'latitude' => [
                'label' => 'Latitude',
            ],
            'longitude' => [
                'label' => 'Longitude',
            ],
            'opening_hours_fr' => [
                'label' => 'Opening hours FR',
                'key' => 'Period',
                'value' => 'Hours',
            ],
            'opening_hours_en' => [
                'label' => 'Opening hours EN',
                'key' => 'Period',
                'value' => 'Hours',
            ],
            'description_fr' => [
                'label' => 'Description FR',
                'placeholder' => 'Brief public description of this agency.',
            ],
            'description_en' => [
                'label' => 'Description EN',
                'placeholder' => 'Brief public description of this agency.',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Unknown',
        'agency' => [
            'operational' => 'Operational',
            'temporarily_closed' => 'Temporarily closed',
        ],
    ],
];
