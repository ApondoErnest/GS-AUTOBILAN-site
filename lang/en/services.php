<?php

return [
    'meta_title' => 'GS AUTOBILAN - Our services',
    'hero' => [
        'eyebrow' => 'Our services',
        'title' => 'Technical inspection services designed for safety',
        'lead' => 'GS AUTOBILAN supports private motorists, professionals, and transporters with rigorous, clear, and transparent checks adapted to each type of vehicle.',
        'focus_items' => [
            [
                'label' => 'Light vehicles',
                'icon' => 'car',
            ],
            [
                'label' => 'Utility &amp;<br>heavy vehicles',
                'icon' => 'heroicon-o-truck',
            ],
            [
                'label' => 'Re-inspection',
                'icon' => 'heroicon-o-arrow-path',
            ],
            [
                'label' => 'Preparation &amp;<br>guidance',
                'icon' => 'heroicon-o-document-check',
            ],
        ],
        'actions' => [
            'discover' => 'Discover our services',
        ],
    ],
    'architecture' => [
        'core' => [
            'eyebrow' => 'Our service types',
            'cards' => [
                [
                    'id' => 'service-periodic-technical-inspection',
                    'title' => 'Periodic technical inspection',
                    'summary' => 'The main inspection for regulatory follow-up and verification of the vehicle’s general technical condition.',
                    'points' => [
                        'Essential component checks',
                        'Structured verification',
                        'Official report after the visit',
                    ],
                    'action' => 'Learn more',
                    'action_target' => 'technical_inspection',
                    'icon' => 'car',
                ],
                [
                    'id' => 'service-re-inspection',
                    'title' => 'Re-inspection',
                    'summary' => 'A targeted control visit after correcting the items reported during the previous inspection.',
                    'points' => [
                        'Targeted verification',
                        'Visit after repair',
                        'Guidance based on expected corrections',
                    ],
                    'action' => 'Understand re-inspection',
                    'action_target' => 'technical_inspection',
                    'icon' => 'heroicon-o-clipboard-document-check',
                ],
                [
                    'id' => 'service-guidance-preparation',
                    'title' => 'Guidance and preparation before your visit',
                    'summary' => 'Practical support to help you prepare your file and understand the requirements before inspection.',
                    'points' => [
                        'Document preparation',
                        'Understanding the type of visit',
                        'Help before appointment',
                    ],
                    'action' => 'View preparation',
                    'action_target' => 'booking',
                    'icon' => 'heroicon-o-user-circle',
                ],
            ],
        ],
        'vehicles' => [
            'eyebrow' => 'Vehicles supported',
            'conditions_action' => 'View all conditions',
            'profiles' => [
                [
                    'id' => 'light-vehicle',
                    'tab' => 'Light vehicle',
                    'icon' => 'car',
                    'image' => 'images/servicespage/light-vehicle.png',
                    'image_alt' => 'Light vehicle',
                    'title' => 'For light vehicles',
                    'copy' => 'The periodic technical inspection checks the different systems of your vehicle to help ensure your safety and the safety of other road users.',
                    'details' => [
                        [
                            'label' => 'Recommended service',
                            'value' => 'Periodic technical inspection',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Available centres',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Key documents',
                            'value' => 'Registration card, ID document, insurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Average duration',
                            'value' => '30 to 45 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'Good to know',
                    'notice_copy' => 'Presenting a complete file helps speed up your visit.',
                    'notice_items' => [
                        'Original registration card',
                        'ID document',
                        'Valid insurance certificate',
                        'Previous inspection document (if available)',
                    ],
                ],
                [
                    'id' => 'utility-vehicle',
                    'tab' => 'Utility vehicle',
                    'icon' => 'heroicon-o-truck',
                    'image' => 'images/servicespage/utility-vehicle.png',
                    'image_alt' => 'Utility vehicle',
                    'title' => 'For utility vehicles',
                    'copy' => 'The periodic technical inspection checks the different systems of your utility vehicle to help ensure your safety and the safety of other road users.',
                    'details' => [
                        [
                            'label' => 'Recommended service',
                            'value' => 'Periodic technical inspection',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Available centres',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Key documents',
                            'value' => 'Registration card, ID document, insurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Average duration',
                            'value' => '35 to 50 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'Good to know',
                    'notice_copy' => 'Presenting a complete file helps speed up your visit.',
                    'notice_items' => [
                        'Original registration card',
                        'ID document',
                        'Valid insurance certificate',
                        'Previous inspection document (if available)',
                    ],
                ],
                [
                    'id' => 'taxi-transport',
                    'tab' => 'Taxi / Transport',
                    'icon' => 'taxi',
                    'image' => 'images/servicespage/taxi-transport.png',
                    'image_alt' => 'Taxi or transport vehicle',
                    'title' => 'For taxis / transport',
                    'copy' => 'The periodic technical inspection checks the essential systems of your taxi or transport vehicle to help keep passengers, the driver, and other road users safe.',
                    'details' => [
                        [
                            'label' => 'Recommended service',
                            'value' => 'Periodic technical inspection',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Available centres',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Key documents',
                            'value' => 'Registration card, ID document, insurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Average duration',
                            'value' => '35 to 50 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'Good to know',
                    'notice_copy' => 'Presenting a complete file helps make your transport vehicle visit faster and easier.',
                    'notice_items' => [
                        'Original registration card',
                        'ID document',
                        'Valid insurance certificate',
                        'Transport authorization / licence',
                        'Previous inspection document (if available)',
                    ],
                ],
                [
                    'id' => 'heavy-vehicle',
                    'tab' => 'Heavy vehicle',
                    'icon' => 'heroicon-o-truck',
                    'image' => 'images/servicespage/heavy-vehicle.png',
                    'image_alt' => 'Heavy vehicle',
                    'title' => 'For heavy vehicles',
                    'copy' => 'The periodic technical inspection checks the compliance and safety of your heavy vehicle. It helps prevent risk, preserve your equipment, and protect everyone on the road.',
                    'details' => [
                        [
                            'label' => 'Recommended service',
                            'value' => 'Periodic technical inspection',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Available centres',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Key documents',
                            'value' => 'Registration card, ID document, insurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Average duration',
                            'value' => '45 to 60 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'Good to know',
                    'notice_copy' => 'Presenting a complete file helps speed up your visit.',
                    'notice_items' => [
                        'Original registration card',
                        'ID document',
                        'Valid insurance certificate',
                        'Transport documents / previous inspection',
                    ],
                ],
            ],
        ],
        'technical_matrix' => [
            'title' => 'What our inspections take into account',
            'lead' => 'Each visit includes a series of essential technical checks to help keep you safe.',
            'items' => [
                [
                    'title' => 'Braking',
                    'copy' => 'Efficiency, balance, and parking brake operation.',
                    'icon' => 'brake',
                ],
                [
                    'title' => 'Suspension',
                    'copy' => 'Condition of shock absorbers, springs, and suspension components.',
                    'icon' => 'suspension',
                ],
                [
                    'title' => 'Lighting & headlights',
                    'copy' => 'Operation, orientation, and condition of lights and lighting devices.',
                    'icon' => 'headlight',
                ],
                [
                    'title' => 'Tyres',
                    'copy' => 'Wear, general condition, compliance, and visual pressure check.',
                    'icon' => 'tire',
                ],
                [
                    'title' => 'Vehicle identification',
                    'copy' => 'Plate, chassis number, and other identification checks.',
                    'icon' => 'id-card',
                ],
                [
                    'title' => 'Visual inspection',
                    'copy' => 'Overall check of the vehicle’s visible condition and safety items.',
                    'icon' => 'eye',
                ],
                [
                    'title' => 'Alignment / side slip',
                    'copy' => 'Verification of steering behaviour and vehicle guidance.',
                    'icon' => 'steering',
                ],
                [
                    'title' => 'Documents & administrative consistency',
                    'copy' => 'Document review and consistency of file information.',
                    'icon' => 'clipboard',
                ],
            ],
        ],
        'decision_gate' => [
            'title' => 'Which service fits your need?',
            'routes' => [
                [
                    'intent' => 'I want to complete my regular inspection',
                    'result' => 'Periodic technical inspection',
                    'target' => 'technical_inspection',
                ],
                [
                    'intent' => 'I am returning after correcting issues',
                    'result' => 'Re-inspection',
                    'target' => 'technical_inspection',
                ],
                [
                    'intent' => 'I do not know which documents to prepare',
                    'result' => 'Guidance & preparation',
                    'target' => 'booking',
                ],
                [
                    'intent' => 'I want to choose a visit date',
                    'result' => 'Book an appointment',
                    'target' => 'booking',
                ],
            ],
            'cta' => [
                'title' => 'Move to the next step',
                'lead' => 'Choose the action that fits you best.',
                'actions' => [
                    [
                        'label' => 'Book an appointment',
                        'target' => 'booking',
                        'icon' => 'heroicon-o-calendar-days',
                    ],
                    [
                        'label' => 'Prepare my visit',
                        'target' => 'technical_inspection',
                        'icon' => 'heroicon-o-document-text',
                    ],
                    [
                        'label' => 'See our agencies',
                        'target' => 'agencies',
                        'icon' => 'heroicon-o-map-pin',
                    ],
                    [
                        'label' => 'View tariffs',
                        'target' => 'tariffs',
                        'icon' => 'heroicon-o-tag',
                    ],
                ],
                'notice' => 'Your appointment request will be confirmed by phone or WhatsApp by the GS AUTOBILAN team.',
            ],
        ],
    ],
];
