<?php

return [
    'title' => 'Operations',
    'navigation_label' => 'Overview',
    'subtitle' => 'Track appointment flow, document readiness, and agency workload from a compact operations workspace.',
    'empty_value' => 'Not set',
    'command' => [
        'eyebrow' => 'Operations desk',
        'heading' => 'Today\'s operational pulse',
        'description' => 'Bookings, confirmation follow-ups, document alerts, and agency load stay visible without leaving the section.',
    ],
    'summary' => [
        'label' => 'Operations summary',
        'today' => [
            'label' => 'Today',
            'description' => 'Preferred visits dated today',
        ],
        'confirmations' => [
            'label' => 'Confirmations',
            'description' => 'New and pending bookings',
        ],
        'documents' => [
            'label' => 'Document alerts',
            'description' => 'Missing info or agency contact',
        ],
        'ready' => [
            'label' => 'Ready files',
            'description' => ':total total document files',
        ],
    ],
    'quick_links' => [
        'heading' => 'Priority actions',
        'description' => 'Move quickly into the operational records that need staff attention.',
        'empty' => 'No operational shortcuts are available for the current agency scope.',
        'bookings' => [
            'label' => 'Bookings',
            'description' => 'Review appointment requests',
        ],
        'documents' => [
            'label' => 'Documents',
            'description' => 'Check readiness records',
        ],
    ],
    'workload' => [
        'heading' => 'Agency workload',
        'description' => 'Visible bookings grouped by agency.',
        'metric' => 'visible bookings',
        'empty' => 'No agency workload is available yet.',
    ],
    'latest_bookings' => [
        'heading' => 'Latest bookings',
        'description' => 'Recent requests in the current operational scope.',
        'empty' => 'No bookings are visible yet.',
    ],
    'latest_documents' => [
        'heading' => 'Document readiness',
        'description' => 'Recently updated document files and their next state.',
        'empty' => 'No document readiness records are visible yet.',
    ],
    'statuses' => [
        'unknown' => 'Unknown',
        'booking' => [
            'new_request' => 'New request',
            'pending_confirmation' => 'Pending',
            'confirmed' => 'Confirmed',
            'rescheduled' => 'Rescheduled',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'no_show' => 'No-show',
        ],
        'document' => [
            'not_reviewed' => 'Not reviewed',
            'complete' => 'Complete',
            'missing_info' => 'Missing info',
            'contact_agency' => 'Contact agency',
            'ready_for_visit' => 'Ready',
        ],
    ],
];
