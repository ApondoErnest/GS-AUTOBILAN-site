<?php

return [
    'title' => 'Admin dashboard',
    'navigation_label' => 'Dashboard',
    'header' => [
        'eyebrow' => 'Operations command center',
        'heading' => 'Admin dashboard',
        'intro' => 'Monitor appointments, agency workload, document readiness, and content signals from one professional workspace.',
        'language_label' => 'Language',
        'role_label' => 'Role',
        'scope_label' => 'Scope',
        'updated_label' => 'Updated',
        'status_label' => 'Secure workspace',
        'status_value' => 'Protected access',
    ],
    'roles' => [
        'super_admin' => 'Super admin',
        'agency_admin' => 'Agency admin',
        'content_manager' => 'Content manager',
        'staff' => 'Staff',
    ],
    'scopes' => [
        'all_agencies' => 'All agencies',
        'agency_unassigned' => 'Agency not assigned',
        'content_workspace' => 'Content desk',
        'staff_workspace' => 'Staff workspace',
        'general' => 'General',
    ],
    'widgets' => [
        'booking' => [
            'heading' => 'Operations overview',
            'description' => 'Requests and appointment outcomes for your visible operations.',
            'total' => [
                'label' => 'Total bookings',
                'description' => 'All visible requests',
            ],
            'new' => [
                'label' => 'New requests',
                'description' => 'Waiting for first review',
            ],
            'pending' => [
                'label' => 'Pending confirmations',
                'description' => 'Needs appointment confirmation',
            ],
            'confirmed' => [
                'label' => 'Confirmed',
                'description' => 'Ready for the visit',
            ],
            'completed' => [
                'label' => 'Completed',
                'description' => 'Finished appointments',
            ],
            'no_show' => [
                'label' => 'No-shows',
                'description' => 'Missed appointments',
            ],
        ],
        'agency' => [
            'heading' => 'Agency workload',
            'description' => 'Bookings grouped by the agency scope available to you.',
            'visible_bookings' => 'Visible bookings',
        ],
        'alerts' => [
            'heading' => 'Attention queue',
            'description' => 'Operational follow-ups and recently publishable content signals.',
            'missing_info' => [
                'label' => 'Missing information',
                'description' => 'Document readiness alerts',
            ],
            'contact_agency' => [
                'label' => 'Contact agency',
                'description' => 'Client should call or visit',
            ],
            'new_contacts' => [
                'label' => 'New contact messages',
                'description' => 'Unprocessed public messages',
            ],
            'published_articles' => [
                'label' => 'Published articles',
                'description' => 'Visible news and advice',
            ],
        ],
        'activity' => [
            'heading' => 'Latest activity',
            'description' => 'Recent contact and content signals for the current staff scope.',
            'contacts_heading' => 'Contact messages',
            'articles_heading' => 'Content updates',
            'empty_contacts' => 'No contact messages yet.',
            'empty_articles' => 'No articles yet.',
            'subject_fallback' => 'Untitled message',
            'article_fallback' => 'Untitled article',
        ],
    ],
    'statuses' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ],
];
