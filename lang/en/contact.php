<?php

return [
    'meta_title' => 'GS AUTOBILAN - Contact',
    'intro' => [
        'title' => 'What would you like to do?',
        'lead' => 'Choose your need so we can guide you quickly.',
        'actions' => [
            [
                'label' => 'I want to book<br>an appointment',
                'target' => 'booking',
                'icon' => 'images/contacts/contact-calendar.svg',
            ],
            [
                'label' => 'I want to call<br>an agency',
                'target' => 'call',
                'icon' => 'images/contacts/contact-phone.svg',
            ],
            [
                'label' => 'I want to find<br>directions',
                'target' => 'directions',
                'icon' => 'images/contacts/contact-map.svg',
            ],
            [
                'label' => 'I have a question<br>or a problem',
                'target' => 'question',
                'icon' => 'images/contacts/contact-question.svg',
            ],
        ],
    ],
    'agencies' => [
        'title' => 'Our technical inspection agencies',
        'status' => 'Open now',
        'actions' => [
            'book' => 'Book an appointment',
        ],
        'cards' => [
            [
                'id' => 'contact-agency-nkolbisson',
                'name' => 'GS AUTOBILAN Nkolbisson',
                'address' => 'Carrefour Onana, next to Ajaxx station, coming from Dagobert',
                'hours' => 'Monday to Saturday: 07:00 – 18:00',
                'phone' => '+237 678 844 791 / +237 652 516 527',
                'email' => 'nkolbisson@gsautobilan.cm',
                'note' => 'Open on public holidays',
                'whatsappHref' => 'https://wa.me/237678844791',
                'mapEmbed' => 'https://maps.google.com/maps?hl=en&q=3.8882487,11.4549352&z=16&output=embed',
                'mapTitle' => 'Map of GS AUTOBILAN Nkolbisson',
            ],
            [
                'id' => 'contact-agency-obili-scalom',
                'name' => 'GS AUTOBILAN Obili Scalom',
                'address' => 'Obili Scalom',
                'hours' => 'Monday to Saturday: 07:00 – 19:00<br>Sunday: 07:00 – 15:00',
                'phone' => '+237 678 844 791 / +237 658 473 182',
                'email' => 'obili@gsautobilan.cm',
                'note' => 'Open 7 days a week',
                'whatsappHref' => 'https://wa.me/237678844791',
                'mapEmbed' => 'https://maps.google.com/maps?hl=en&q=3.8471748,11.4967492&z=16&output=embed',
                'mapTitle' => 'Map of GS AUTOBILAN Obili Scalom',
            ],
        ],
    ],
    'desk' => [
        'form' => [
            'title' => 'Send a message',
            'fields' => [
                'name' => 'Full name',
                'phone' => 'Phone / WhatsApp',
                'email' => 'Email (optional)',
                'subject' => 'Subject',
                'agency' => 'Agency concerned',
                'type' => 'Request type',
                'message' => 'Message',
            ],
            'placeholders' => [
                'name' => 'Your full name',
                'phone' => 'Ex: +237 6XX XXX XXX',
                'email' => 'example@email.com',
                'subject' => 'Subject of your request',
                'agency' => 'Select an agency',
                'type' => 'Select the request type',
                'message' => 'Describe your request...',
            ],
            'agency_options' => [
                [
                    'value' => 'nkolbisson',
                    'label' => 'GS AUTOBILAN Nkolbisson',
                ],
                [
                    'value' => 'obili-scalom',
                    'label' => 'GS AUTOBILAN Obili Scalom',
                ],
                [
                    'value' => 'head-office',
                    'label' => 'Head Office — Bastos',
                ],
            ],
            'type_options' => [
                'Appointment request',
                'Documents to prepare',
                'Tracking or result',
                'Counter-visit',
                'Administrative question',
                'Other request',
            ],
            'note' => 'We reply by phone, WhatsApp or email depending on your preference.',
            'submit' => 'Send my request',
            'success' => 'Your message has been sent. Our team will reply quickly.',
        ],
        'head_office' => [
            'label' => 'Administration',
            'title' => 'Head Office — Bastos',
            'lead' => 'For administrative questions, partnerships and corporate requests.',
            'address' => 'Bastos, Yaounde',
            'phone' => '+237 222 220 682 / +237 695 300 400',
            'email' => 'direction@gsautobilan.cm',
            'call_href' => 'tel:+237222220682',
            'email_href' => 'mailto:direction@gsautobilan.cm',
            'actions' => [
                'call' => 'Call head office',
                'email' => 'Send an email',
            ],
            'notice' => [
                'title' => 'No technical inspection lane at this site',
                'body' => 'This site is dedicated only to administrative and management services.',
            ],
        ],
    ],
    'faq' => [
        'title' => 'Frequently asked questions',
        'items' => [
            [
                'question' => 'Which documents should I bring?',
                'answer' => 'Prepare the original registration card, an identity document, valid insurance and the previous inspection document when available.',
            ],
            [
                'question' => 'How is an appointment confirmed?',
                'answer' => 'Your request is recorded, then the GS AUTOBILAN team confirms the time slot by phone or WhatsApp depending on availability.',
            ],
            [
                'question' => 'Are you open on public holidays?',
                'answer' => 'Yes, the listed agencies receive vehicles on public holidays according to the confirmed hours shown on the page.',
            ],
            [
                'question' => 'Which agency should I choose?',
                'answer' => 'Choose Nkolbisson or Obili Scalom based on proximity, your route and the opening hours that best fit your visit.',
            ],
            [
                'question' => 'How can I track my request?',
                'answer' => 'Use the tracking page with your reference, phone number and vehicle registration once those details are available.',
            ],
            [
                'question' => 'What should I do for a counter-visit?',
                'answer' => 'Have the listed issues corrected, keep your inspection report and contact the concerned agency to arrange the next visit.',
            ],
            [
                'question' => 'Where is the Head Office?',
                'answer' => 'The Head Office is in Bastos, Yaounde. It handles administrative requests, partnerships and corporate questions.',
            ],
            [
                'question' => 'Can I come without an appointment?',
                'answer' => 'A visit may depend on centre traffic. To avoid waiting, it is better to book an appointment or contact the agency before coming.',
            ],
        ],
    ],
];
