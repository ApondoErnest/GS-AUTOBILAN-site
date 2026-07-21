<?php

return [
    'meta_title' => 'Track my appointment · GS AUTOBILAN',
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
        'recovery_prompt' => 'No longer have your reference?',
        'recovery_action' => 'We can help you find it',
    ],
    'result' => [
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
