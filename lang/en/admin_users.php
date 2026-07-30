<?php

return [
    'navigation_label' => 'Users',
    'empty_user' => 'Unnamed user',
    'empty_agency' => 'No agency assigned',
    'empty_roles' => 'No roles assigned',

    'model' => [
        'singular' => 'user',
        'plural' => 'users',
    ],

    'pages' => [
        'list' => [
            'title' => 'Users',
            'subtitle' => 'Manage staff identity, roles, agency scope, active access, and login visibility.',
        ],
        'create' => [
            'title' => 'New user',
            'subtitle' => 'Create a staff account and assign the right admin role before access is granted.',
        ],
        'edit' => [
            'title' => ':user',
            'subtitle' => 'Update staff identity, agency scope, active status, and role coverage.',
        ],
    ],

    'actions' => [
        'create' => 'New user',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
    ],

    'table' => [
        'heading' => 'Staff directory',
        'description' => 'A compact access-control view for staff identity, roles, agency scope, status, and last login.',
        'empty_heading' => 'No users yet',
        'empty_description' => 'Create the first staff account to start managing admin access.',
        'columns' => [
            'user' => 'Staff / identity',
            'roles' => 'Roles',
            'agency' => 'Agency scope',
            'status' => 'Access status',
            'last_login' => 'Last login',
        ],
        'descriptions' => [
            'never_logged_in' => 'Never logged in',
        ],
        'filters' => [
            'status' => 'Access status',
            'agency' => 'Agency scope',
            'role' => 'Role',
            'without_roles' => 'Without roles',
        ],
    ],

    'form' => [
        'sections' => [
            'identity' => [
                'heading' => 'User identity',
                'description' => 'Name, email, and password for staff authentication.',
            ],
            'access' => [
                'heading' => 'Access and agency',
                'description' => 'Admin panel access state, agency assignment, and last login visibility.',
            ],
            'roles' => [
                'heading' => 'Staff roles',
                'description' => 'Choose the permission profile that controls what the staff member can manage.',
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Staff member name',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'staff@example.com',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Leave blank to keep current password',
            ],
            'assigned_agency_id' => [
                'label' => 'Assigned agency',
            ],
            'is_active' => [
                'label' => 'Active admin access',
                'helper' => 'Inactive users cannot access the admin panel.',
            ],
            'last_login_at' => [
                'label' => 'Last login',
            ],
            'roles' => [
                'label' => 'Roles',
            ],
        ],
    ],

    'roles' => [
        'super_admin' => 'Super Admin',
        'agency_admin' => 'Agency Admin',
        'content_manager' => 'Content Manager',
    ],

    'statuses' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],
];
