<?php

return [
    'meta_title' => 'Track my appointment · GS AUTOBILAN',
    'meta_description' => 'Track your GS AUTOBILAN appointment request with your reference, phone number, and vehicle registration.',
    'hero' => [
        'eyebrow' => 'Request tracking',
        'title' => 'Track your appointment request',
        'lead' => 'Check your appointment confirmation and document preparation status.',
        'notice' => [
            'label' => 'Information',
            'body' => 'This service does not track your vehicle in real time on the inspection lane.',
            'confirmation' => 'It only shows your appointment request status and document preparation progress.',
        ],
    ],
    'lookup' => [
        'title' => 'Find your request',
        'lead' => 'Enter the information used when making your appointment request.',
        'help' => 'Need help?',
        'fields' => [
            'reference' => [
                'label' => 'Request reference',
                'placeholder' => 'Ex: GS-2026-NK-48192',
            ],
            'phone' => [
                'label' => 'Phone or WhatsApp number',
                'placeholder' => 'Ex: +237 678 844 791',
            ],
            'registration' => [
                'label' => 'Vehicle registration',
                'placeholder' => 'Ex: LT-123-AB',
            ],
        ],
        'submit' => 'Track my request',
        'errors' => [
            'validation' => 'Please check the three tracking details and try again.',
            'not_found' => 'No request matches those three details. Check your reference, phone, and vehicle registration.',
            'throttled' => 'Too many tracking attempts. Try again in :minutes min.',
        ],
        'recovery_prompt' => 'No longer have your reference?',
        'recovery_action' => 'We can help you find it',
    ],
    'result' => [
        'empty' => 'To be confirmed',
        'status_labels' => [
            'new_request' => 'New request',
            'pending_confirmation' => 'Pending confirmation',
            'confirmed' => 'Confirmed',
            'rescheduled' => 'Rescheduled',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'no_show' => 'No-show',
        ],
        'status_titles' => [
            'new_request' => 'Your request has been received.',
            'pending_confirmation' => 'Your request is being reviewed.',
            'confirmed' => 'Your visit has been confirmed by the agency.',
            'rescheduled' => 'Your appointment needs to be rescheduled.',
            'cancelled' => 'Your request has been cancelled.',
            'completed' => 'Your visit is complete.',
            'no_show' => 'Your visit is marked as no-show.',
        ],
        'status_bodies' => [
            'new_request' => 'Our team still needs to confirm the exact time slot.',
            'pending_confirmation' => 'An agent is checking availability and will contact you to finalize the slot.',
            'confirmed' => 'We are expecting you on the confirmed date with the required documents.',
            'rescheduled' => 'Please follow the agency instructions to choose a new slot.',
            'cancelled' => 'Contact the agency if you would like to submit a new request.',
            'completed' => 'Thank you for completing your visit at GS AUTOBILAN.',
            'no_show' => 'Contact the agency to learn about rescheduling options.',
        ],
        'document_labels' => [
            'not_reviewed' => 'Not reviewed',
            'complete' => 'Complete',
            'missing_info' => 'Missing information',
            'contact_agency' => 'Contact agency',
            'ready_for_visit' => 'Ready for visit',
        ],
        'dynamic_details' => [
            'reference' => 'Reference',
            'agency' => 'Agency',
            'requested_date' => 'Requested date',
            'requested_time' => 'Requested period',
            'confirmed_date' => 'Confirmed date',
            'confirmed_time' => 'Confirmed time',
            'booking_status' => 'Request status',
            'document_status' => 'File status',
        ],
        'messages' => [
            'title' => 'Public message',
            'fallback' => 'No additional public message for now.',
        ],
        'no_next_action' => 'No specific action is requested for now.',
        'timeline' => [
            [
                'label' => 'Request received',
                'meta' => 'May 12, 2026',
                'state' => 'completed',
            ],
            [
                'label' => 'Appointment confirmed',
                'meta' => 'May 13, 2026',
                'state' => 'current',
            ],
            [
                'label' => 'File ready',
                'meta' => 'In progress',
                'state' => 'upcoming',
            ],
            [
                'label' => 'Visit planned',
                'meta' => 'Upcoming',
                'state' => 'upcoming',
            ],
        ],
        'status' => [
            'label' => 'Confirmed',
            'title' => 'Your visit has been confirmed by the agency.',
            'body' => 'We are expecting you on the confirmed date with the required documents.',
            'download' => 'Download the summary',
        ],
        'details' => [
            [
                'icon' => 'ticket',
                'label' => 'Reference',
                'value' => 'GS-2026-NK-48192',
            ],
            [
                'icon' => 'map',
                'label' => 'Agency',
                'value' => 'GS AUTOBILAN Nkolbisson',
            ],
            [
                'icon' => 'calendar',
                'label' => 'Confirmed date',
                'value' => 'August 15, 2026',
            ],
            [
                'icon' => 'service',
                'label' => 'Service',
                'value' => 'Periodic technical inspection',
            ],
            [
                'icon' => 'vehicle',
                'label' => 'Vehicle',
                'value' => 'Light vehicle',
            ],
            [
                'icon' => 'clock',
                'label' => 'Confirmed period / time',
                'value' => 'Morning (07:00 – 11:00)',
            ],
            [
                'icon' => 'plate',
                'label' => 'Registration',
                'value' => 'LT-123-AB',
            ],
            [
                'icon' => 'calendar',
                'label' => 'Requested date',
                'value' => 'August 15, 2026 (Morning)',
            ],
            [
                'icon' => 'whatsapp',
                'label' => 'Confirmation contact',
                'value' => '+237 678 844 791',
            ],
        ],
        'dossier' => [
            'eyebrow' => 'File status',
            'title' => 'File to complete',
            'body' => 'Some items must be provided before your visit.',
            'action' => 'View items to complete',
        ],
        'next_action' => [
            'eyebrow' => 'Next step',
            'title' => 'Please complete your file.',
            'body' => 'Our team will contact you if additional information is required.',
            'whatsapp' => 'Message on WhatsApp',
            'call' => 'Call the agency',
        ],
    ],
];
