<?php

return [
    'navigation_label' => 'Bookings',
    'model' => [
        'singular' => 'booking',
        'plural' => 'bookings',
    ],
    'pages' => [
        'list' => [
            'title' => 'Bookings',
            'subtitle' => 'Review appointment requests, confirmation details, and document readiness in one operations desk.',
        ],
        'edit' => [
            'title' => 'Booking :reference',
            'subtitle' => 'Update the customer, vehicle, visit schedule, and follow-up notes.',
        ],
    ],
    'actions' => [
        'edit' => 'Edit',
    ],
    'table' => [
        'heading' => 'Booking desk',
        'description' => 'A compact working view for customer contacts, visit timing, agency ownership, and document follow-up.',
        'empty_heading' => 'No bookings yet',
        'empty_description' => 'Create the first booking to start tracking appointment requests and document readiness.',
        'copy_reference' => 'Reference copied',
        'columns' => [
            'reference' => 'Reference',
            'contact' => 'Contact',
            'agency' => 'Agency / service',
            'visit' => 'Visit request',
            'confirmed' => 'Confirmed',
            'status' => 'Booking',
            'documents' => 'Documents',
            'created' => 'Created',
        ],
        'descriptions' => [
            'missing_contact' => 'No secondary contact',
            'no_time_slot' => 'No time slot',
            'not_confirmed' => 'Not confirmed',
            'not_started' => 'Not started',
            'not_set' => 'Not set',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Booking status',
            'agency' => 'Agency',
            'document_status' => 'Document status',
            'visit_window' => 'Preferred visit date',
            'from' => 'From',
            'until' => 'Until',
        ],
    ],
    'form' => [
        'sections' => [
            'customer' => [
                'heading' => 'Customer',
                'description' => 'Client identity and reachable contact details.',
            ],
            'agency_service' => [
                'heading' => 'Agency and service',
                'description' => 'Assign the booking to the correct inspection center and service.',
            ],
            'vehicle' => [
                'heading' => 'Vehicle',
                'description' => 'Registration and vehicle classification for the visit.',
            ],
            'schedule' => [
                'heading' => 'Schedule and status',
                'description' => 'Preferred request, confirmed appointment, and operational state.',
            ],
            'messages' => [
                'heading' => 'Messages and notes',
                'description' => 'Customer request, public tracking message, and private team notes.',
            ],
        ],
        'fields' => [
            'reference' => [
                'label' => 'Reference',
                'helper' => 'Generated automatically when the booking is created.',
            ],
            'customer_name' => [
                'label' => 'Customer name',
                'placeholder' => 'Full name',
            ],
            'phone' => [
                'label' => 'Phone',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'customer@example.com',
            ],
            'agency_id' => [
                'label' => 'Agency',
                'placeholder' => 'Choose an agency',
            ],
            'service_id' => [
                'label' => 'Service',
                'placeholder' => 'Choose a service',
            ],
            'vehicle_registration' => [
                'label' => 'Registration',
                'placeholder' => 'CE123AB',
            ],
            'vehicle_type' => [
                'label' => 'Vehicle type',
                'placeholder' => 'Car, truck, bus...',
            ],
            'vehicle_category' => [
                'label' => 'Vehicle category',
                'placeholder' => 'Light, utility, heavy...',
            ],
            'vehicle_brand_model' => [
                'label' => 'Brand / model',
                'placeholder' => 'Toyota Corolla',
            ],
            'preferred_date' => [
                'label' => 'Preferred date',
            ],
            'preferred_time_slot' => [
                'label' => 'Preferred time slot',
                'placeholder' => '09h00-10h00',
            ],
            'confirmed_date' => [
                'label' => 'Confirmed date',
            ],
            'confirmed_time_slot' => [
                'label' => 'Confirmed time slot',
                'placeholder' => '10h00-11h00',
            ],
            'status' => [
                'label' => 'Status',
            ],
            'customer_message' => [
                'label' => 'Customer message',
                'placeholder' => 'Notes from the customer request',
            ],
            'public_message' => [
                'label' => 'Public tracking message',
                'placeholder' => 'Visible follow-up message for the customer',
            ],
            'internal_notes' => [
                'label' => 'Internal notes',
                'placeholder' => 'Private notes for the operations team',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Unknown',
        'booking' => [
            'new_request' => 'New request',
            'pending_confirmation' => 'Pending confirmation',
            'confirmed' => 'Confirmed',
            'rescheduled' => 'Rescheduled',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'no_show' => 'No-show',
        ],
        'document' => [
            'not_reviewed' => 'Not reviewed',
            'complete' => 'Complete',
            'missing_info' => 'Missing information',
            'contact_agency' => 'Contact agency',
            'ready_for_visit' => 'Ready for visit',
        ],
    ],
];
