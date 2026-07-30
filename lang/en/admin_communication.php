<?php

return [
    'title' => 'Communication',
    'navigation_label' => 'Overview',
    'subtitle' => 'Track customer messages, response status, assignment, and agency follow-up from one focused inbox.',
    'empty_value' => 'Not set',
    'empty_subject' => 'Message without subject',

    'command' => [
        'eyebrow' => 'Message desk',
        'heading' => 'Customer communication desk',
        'description' => 'Keep public contact requests, agency routing, assignments, and response progress visible without leaving the section.',
    ],

    'summary' => [
        'label' => 'Communication summary',
        'total' => [
            'label' => 'Visible messages',
            'description' => 'Messages available in your current scope.',
        ],
        'new' => [
            'label' => 'New',
            'description' => 'Customer messages still waiting for first review.',
        ],
        'in_review' => [
            'label' => 'In review',
            'description' => 'Messages currently being handled by staff.',
        ],
        'responded' => [
            'label' => 'Answered',
            'description' => 'Messages responded to or closed.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Message inbox',
        'description' => 'Open the contact records that arrived from the public website.',
        'empty' => 'No message workspace is available for your role or agency scope.',
        'messages' => [
            'label' => 'Contact messages',
            'description' => 'Review customer requests, assign ownership, update status, and record internal notes.',
        ],
    ],

    'workload' => [
        'heading' => 'Response workload',
        'description' => 'Messages grouped by response status in the current scope.',
        'metric' => ':count of :total messages',
    ],

    'latest' => [
        'heading' => 'Latest messages',
        'description' => 'Recent public contact requests and their handling state.',
        'empty' => 'No contact messages are visible yet.',
    ],

    'attention' => [
        'heading' => 'Attention queue',
        'description' => 'Communication items that may need assignment, review, or cleanup.',
        'empty' => 'No communication items need attention.',
        'new' => [
            'label' => 'New messages',
            'description' => 'Requests waiting for first review.',
        ],
        'in_review' => [
            'label' => 'In review',
            'description' => 'Messages still being handled.',
        ],
        'unassigned' => [
            'label' => 'Unassigned',
            'description' => 'Open messages without a staff owner.',
        ],
        'spam' => [
            'label' => 'Spam marked',
            'description' => 'Messages marked as spam for cleanup review.',
        ],
    ],
];
