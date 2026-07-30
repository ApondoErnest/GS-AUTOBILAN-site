<?php

return [
    'title' => 'Users & Settings',
    'navigation_label' => 'Overview',
    'subtitle' => 'Manage staff access, role coverage, system settings, and audit visibility from one governance workspace.',
    'empty_value' => 'Not set',

    'command' => [
        'eyebrow' => 'Administration desk',
        'heading' => 'Access and system control room',
        'description' => 'Keep staff accounts, permissions, agency scope, configuration records, and audit activity visible in one compact command view.',
    ],

    'summary' => [
        'label' => 'Users and settings summary',
        'users' => [
            'label' => 'Staff users',
            'description' => 'Admin accounts registered in the system.',
        ],
        'active' => [
            'label' => 'Active access',
            'description' => 'Users currently allowed into the admin panel.',
        ],
        'super_admins' => [
            'label' => 'Super admins',
            'description' => 'High privilege accounts that can manage everything.',
        ],
        'settings' => [
            'label' => 'Settings',
            'description' => 'Structured configuration records.',
        ],
    ],

    'quick_links' => [
        'heading' => 'Access workspaces',
        'description' => 'Open the administrative records that control access, configuration, and audit review.',
        'empty' => 'No administrative workspace is available for your role.',
        'users' => [
            'label' => 'Staff users',
            'description' => 'Manage names, emails, roles, agency scope, active status, and last login visibility.',
        ],
        'settings' => [
            'label' => 'System settings',
            'description' => 'Review structured JSON settings that drive public site identity and defaults.',
        ],
        'audit' => [
            'label' => 'Audit trail',
            'description' => 'Inspect recent administrative events in read-only mode.',
        ],
    ],

    'roles' => [
        'heading' => 'Role coverage',
        'description' => 'Staff users grouped by assigned role.',
        'metric' => ':count of :total staff users',
    ],

    'latest_users' => [
        'heading' => 'Latest staff',
        'description' => 'Recently updated admin accounts and their access state.',
        'empty' => 'No staff users are registered yet.',
    ],

    'latest_activity' => [
        'heading' => 'Audit trail',
        'description' => 'Recent administrative events across protected records.',
        'empty' => 'No audit activity has been recorded yet.',
    ],

    'attention' => [
        'heading' => 'Attention queue',
        'description' => 'Access or governance items that may need review.',
        'empty' => 'No access or settings items need attention.',
        'inactive_users' => [
            'label' => 'Inactive users',
            'description' => 'Accounts currently blocked from the admin panel.',
        ],
        'unassigned_agency_admins' => [
            'label' => 'Agency admins without agency',
            'description' => 'Agency admins need an assigned branch to operate safely.',
        ],
        'users_without_roles' => [
            'label' => 'Users without roles',
            'description' => 'Accounts without a staff role cannot use the admin panel.',
        ],
        'recent_audit' => [
            'label' => 'Recent audit events',
            'description' => 'Administrative actions recorded during the last 24 hours.',
        ],
    ],
];
