<?php

return [
    'title' => 'Agencies & Services',
    'navigation_label' => 'Overview',
    'subtitle' => 'Monitor public agency details and the service catalogue from one operational workspace.',
    'empty_value' => 'Not set',
    'feed_empty' => 'No agency or service workspace is available for your role.',

    'command' => [
        'eyebrow' => 'Network desk',
        'heading' => 'Agency network and service catalogue',
        'description' => 'Keep branch information, public contact details, opening status, and service pages aligned with what customers see on the website.',
    ],

    'summary' => [
        'label' => 'Agencies and services summary',
        'agencies' => [
            'label' => 'Visible agencies',
            'description' => ':total total agencies in your scope.',
        ],
        'operational' => [
            'label' => 'Operational',
            'description' => 'Active branches marked ready for customers.',
        ],
        'services' => [
            'label' => 'Active services',
            'description' => ':total total services in the catalogue.',
        ],
        'hidden' => [
            'label' => 'Hidden items',
            'description' => 'Agencies or services removed from public display.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Management workspaces',
        'description' => 'Open the branch or service records that control the public customer experience.',
        'empty' => 'No management workspaces are available for your role.',
        'agencies' => [
            'label' => 'Agencies',
            'description' => 'Review location identity, contacts, hours, status, and map details.',
        ],
        'services' => [
            'label' => 'Services',
            'description' => 'Maintain bilingual service pages, images, ordering, and visibility.',
        ],
    ],

    'readiness' => [
        'heading' => 'Public readiness',
        'description' => 'How complete and visible the customer-facing network data is.',
        'metric' => ':ready of :total ready',
        'empty' => 'No readiness data is available for your role.',
        'agency_visibility' => [
            'label' => 'Agency visibility',
        ],
        'contact_ready' => [
            'label' => 'Contact ready',
        ],
        'service_visibility' => [
            'label' => 'Service visibility',
        ],
        'bilingual_services' => [
            'label' => 'Bilingual services',
        ],
    ],

    'latest_agencies' => [
        'heading' => 'Latest agencies',
        'description' => 'Recently updated branch records and public availability.',
        'empty' => 'No agency records are visible yet.',
    ],

    'latest_services' => [
        'heading' => 'Latest services',
        'description' => 'Recently updated service pages and catalogue visibility.',
        'empty' => 'No service records are visible yet.',
    ],

    'attention' => [
        'heading' => 'Attention queue',
        'description' => 'Network or catalogue details that may need review before they support the public website.',
        'empty' => 'No agency or service items need attention.',
        'closed_agencies' => [
            'label' => 'Temporarily closed',
            'description' => 'Agencies currently marked unavailable.',
        ],
        'hidden_agencies' => [
            'label' => 'Hidden agencies',
            'description' => 'Branch records not shown on the public website.',
        ],
        'hidden_services' => [
            'label' => 'Hidden services',
            'description' => 'Service pages removed from the public catalogue.',
        ],
        'service_media' => [
            'label' => 'Service media missing',
            'description' => 'Service pages without a dedicated image.',
        ],
    ],

    'statuses' => [
        'unknown' => 'Unknown',
        'hidden' => 'Hidden',
        'agency' => [
            'operational' => 'Operational',
            'temporarily_closed' => 'Temporarily closed',
        ],
        'service' => [
            'active' => 'Active',
        ],
    ],
];
