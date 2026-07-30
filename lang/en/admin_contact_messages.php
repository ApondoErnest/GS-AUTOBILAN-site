<?php

return [
    'navigation_label' => 'Messages',
    'empty_subject' => 'Message without subject',
    'empty_agency' => 'No agency assigned',

    'model' => [
        'singular' => 'contact message',
        'plural' => 'contact messages',
    ],

    'pages' => [
        'list' => [
            'title' => 'Contact messages',
            'subtitle' => 'Manage public contact requests, agency routing, assignments, status, and internal follow-up.',
        ],
        'create' => [
            'title' => 'Log message',
            'subtitle' => 'Record a customer contact handled outside the public website form.',
        ],
        'edit' => [
            'title' => ':message',
            'subtitle' => 'Update routing, response status, assignment, and internal follow-up notes.',
        ],
    ],

    'actions' => [
        'create' => 'Log message',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
    ],

    'table' => [
        'heading' => 'Message inbox',
        'description' => 'A compact working view for customer requests, agency ownership, response state, assignment, and received date.',
        'empty_heading' => 'No contact messages yet',
        'empty_description' => 'Public contact requests will appear here when customers submit the website form.',
        'columns' => [
            'subject' => 'Subject / message',
            'sender' => 'Sender',
            'agency' => 'Agency',
            'status' => 'Response status',
            'assigned' => 'Assigned',
            'received' => 'Received',
        ],
        'descriptions' => [
            'unassigned' => 'Unassigned',
            'no_contact' => 'No phone or email',
            'no_message' => 'No message text',
        ],
        'filters' => [
            'status' => 'Response status',
            'agency' => 'Agency',
            'unassigned' => 'Unassigned',
            'received_window' => 'Received date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],

    'form' => [
        'sections' => [
            'sender' => [
                'heading' => 'Sender and routing',
                'description' => 'Customer identity, contact channels, and the agency responsible for follow-up.',
            ],
            'message' => [
                'heading' => 'Customer request',
                'description' => 'The subject and message received from the customer.',
            ],
            'handling' => [
                'heading' => 'Handling notes',
                'description' => 'Response state, staff ownership, and internal follow-up context.',
            ],
        ],
        'fields' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Client name',
            ],
            'phone' => [
                'label' => 'Phone',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'client@example.com',
            ],
            'agency_id' => [
                'label' => 'Agency',
            ],
            'subject' => [
                'label' => 'Subject',
                'placeholder' => 'Booking information request',
            ],
            'message' => [
                'label' => 'Message',
                'placeholder' => 'Customer request or follow-up detail.',
            ],
            'status' => [
                'label' => 'Response status',
            ],
            'assigned_user_id' => [
                'label' => 'Assigned user',
            ],
            'internal_notes' => [
                'label' => 'Internal notes',
                'placeholder' => 'Private handling notes for staff.',
            ],
        ],
    ],

    'statuses' => [
        'new' => 'New',
        'in_review' => 'In review',
        'responded' => 'Responded',
        'closed' => 'Closed',
        'spam' => 'Spam',
        'unknown' => 'Unknown',
    ],
];
