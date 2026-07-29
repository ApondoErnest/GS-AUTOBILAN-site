<?php

return [
    'navigation_label' => 'Document readiness',
    'model' => [
        'singular' => 'document readiness file',
        'plural' => 'document readiness files',
    ],
    'pages' => [
        'list' => [
            'title' => 'Document readiness',
            'subtitle' => 'Manage the review state, missing information, and public next actions for booking files.',
        ],
        'edit' => [
            'title' => 'Readiness :reference',
            'subtitle' => 'Update the file status and the customer-facing follow-up messages.',
        ],
    ],
    'actions' => [
        'edit' => 'Edit',
    ],
    'table' => [
        'heading' => 'Document readiness desk',
        'description' => 'A compact working view for booking files, agency ownership, readiness status, and next customer action.',
        'empty_heading' => 'No document files yet',
        'empty_description' => 'Document readiness files are created automatically when public bookings arrive.',
        'copy_reference' => 'Reference copied',
        'columns' => [
            'reference' => 'Booking / customer',
            'contact' => 'Contact',
            'agency' => 'Agency / service',
            'booking_status' => 'Booking status',
            'readiness' => 'Readiness',
            'note' => 'Review note',
            'updated' => 'Updated',
        ],
        'descriptions' => [
            'missing_contact' => 'No secondary contact',
            'no_missing_info' => 'No missing information',
            'no_next_action' => 'No public next action',
            'not_set' => 'Not set',
            'not_updated_by' => 'Not assigned',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Readiness status',
            'agency' => 'Agency',
            'booking_status' => 'Booking status',
            'updated_window' => 'Updated date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],
    'form' => [
        'sections' => [
            'booking' => [
                'heading' => 'Booking context',
                'description' => 'The public booking this file belongs to. This link is managed by the booking flow.',
            ],
            'status' => [
                'heading' => 'Readiness status',
                'description' => 'Set the current document review state and any private missing-information note.',
            ],
            'public_actions' => [
                'heading' => 'Public next actions',
                'description' => 'Customer-facing instructions and tracking messages in both languages.',
            ],
        ],
        'fields' => [
            'booking_id' => [
                'label' => 'Booking',
                'helper' => 'Created automatically from the public booking request.',
            ],
            'updated_by' => [
                'label' => 'Last updated by',
            ],
            'status' => [
                'label' => 'Readiness status',
            ],
            'missing_information_note' => [
                'label' => 'Missing information',
                'placeholder' => 'Internal note about documents or details still needed',
            ],
            'next_action_fr' => [
                'label' => 'Next action FR',
                'placeholder' => 'Instruction shown to French-speaking customers',
            ],
            'next_action_en' => [
                'label' => 'Next action EN',
                'placeholder' => 'Instruction shown to English-speaking customers',
            ],
            'public_message_fr' => [
                'label' => 'Public message FR',
                'placeholder' => 'Tracking message shown in French',
            ],
            'public_message_en' => [
                'label' => 'Public message EN',
                'placeholder' => 'Tracking message shown in English',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Unknown',
        'document' => [
            'not_reviewed' => 'Not reviewed',
            'complete' => 'Complete',
            'missing_info' => 'Missing information',
            'contact_agency' => 'Contact agency',
            'ready_for_visit' => 'Ready for visit',
        ],
    ],
];
