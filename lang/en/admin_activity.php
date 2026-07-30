<?php

return [
    'navigation_label' => 'Audit',
    'empty_value' => 'Not set',
    'empty_id' => 'unknown',
    'empty_causer' => 'System',

    'model' => [
        'singular' => 'audit event',
        'plural' => 'audit events',
    ],

    'pages' => [
        'list' => [
            'title' => 'Audit trail',
            'subtitle' => 'Read-only history of protected administrative activity.',
        ],
    ],

    'table' => [
        'heading' => 'Audit trail',
        'description' => 'A read-only security log for administrative events, affected records, users, and timestamps.',
        'empty_heading' => 'No audit events yet',
        'empty_description' => 'Protected admin activity will appear here when records are created, updated, or deleted.',
        'columns' => [
            'activity' => 'Activity',
            'log' => 'Log',
            'event' => 'Event',
            'subject' => 'Subject',
            'causer' => 'Causer',
            'created' => 'Created',
        ],
        'descriptions' => [
            'no_description' => 'Audit event',
        ],
        'filters' => [
            'log' => 'Log',
            'event' => 'Event',
            'created_window' => 'Created date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],

    'events' => [
        'created' => 'Created',
        'updated' => 'Updated',
        'deleted' => 'Deleted',
    ],

    'logs' => [
        'agencies' => 'Agencies',
        'articles' => 'Articles',
        'bookings' => 'Bookings',
        'contact_messages' => 'Contact messages',
        'document_readiness' => 'Document readiness',
        'gallery_items' => 'Gallery',
        'services' => 'Services',
        'settings' => 'Settings',
        'tariffs' => 'Tariffs',
        'testimonials' => 'Testimonials',
        'users' => 'Users',
    ],
];
