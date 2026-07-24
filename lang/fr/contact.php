<?php

return [
    'meta_title' => 'GS AUTOBILAN - Contact',
    'intro' => [
        'title' => 'Que souhaitez-vous faire ?',
        'lead' => 'Choisissez votre besoin pour être orienté rapidement.',
        'actions' => [
            [
                'label' => 'Je veux prendre<br>rendez-vous',
                'target' => 'booking',
                'icon' => 'images/contacts/contact-calendar.svg',
            ],
            [
                'label' => 'Je veux appeler<br>une agence',
                'target' => 'call',
                'icon' => 'images/contacts/contact-phone.svg',
            ],
            [
                'label' => "Je veux trouver<br>l’itinéraire",
                'target' => 'directions',
                'icon' => 'images/contacts/contact-map.svg',
            ],
            [
                'label' => "J’ai une question<br>ou un problème",
                'target' => 'question',
                'icon' => 'images/contacts/contact-question.svg',
            ],
        ],
    ],
    'agencies' => [
        'title' => 'Nos agences de visite technique',
        'status' => 'Ouvert actuellement',
        'actions' => [
            'book' => 'Prendre rendez-vous',
        ],
        'cards' => [
            [
                'id' => 'contact-agence-nkolbisson',
                'name' => 'GS AUTOBILAN Nkolbisson',
                'address' => 'Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert',
                'hours' => 'Lundi à Samedi : 07h00 – 18h00',
                'phone' => '+237 678 844 791 / +237 652 516 527',
                'email' => 'nkolbisson@gsautobilan.cm',
                'note' => 'Ouvert les jours fériés',
                'whatsappHref' => 'https://wa.me/237678844791',
                'mapEmbed' => 'https://maps.google.com/maps?hl=fr&q=3.8882487,11.4549352&z=16&output=embed',
                'mapTitle' => 'Carte GS AUTOBILAN Nkolbisson',
            ],
            [
                'id' => 'contact-agence-obili-scalom',
                'name' => 'GS AUTOBILAN Obili Scalom',
                'address' => 'Obili Scalom',
                'hours' => 'Lundi à Samedi : 07h00 – 19h00<br>Dimanche : 07h00 – 15h00',
                'phone' => '+237 678 844 791 / +237 658 473 182',
                'email' => 'obili@gsautobilan.cm',
                'note' => 'Ouvert 7j/7',
                'whatsappHref' => 'https://wa.me/237678844791',
                'mapEmbed' => 'https://maps.google.com/maps?hl=fr&q=3.8471748,11.4967492&z=16&output=embed',
                'mapTitle' => 'Carte GS AUTOBILAN Obili Scalom',
            ],
        ],
    ],
    'desk' => [
        'form' => [
            'title' => 'Envoyer un message',
            'fields' => [
                'name' => 'Nom complet',
                'phone' => 'Téléphone / WhatsApp',
                'email' => 'Email (optionnel)',
                'subject' => 'Sujet',
                'agency' => 'Agence concernée',
                'type' => 'Type de demande',
                'message' => 'Message',
            ],
            'placeholders' => [
                'name' => 'Votre nom complet',
                'phone' => 'Ex. : +237 6XX XXX XXX',
                'email' => 'exemple@email.com',
                'subject' => 'Objet de votre demande',
                'agency' => 'Sélectionnez une agence',
                'type' => 'Sélectionnez le type de demande',
                'message' => 'Décrivez votre demande...',
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
                    'value' => 'direction-generale',
                    'label' => 'Direction Générale — Bastos',
                ],
            ],
            'type_options' => [
                'Prise de rendez-vous',
                'Documents à préparer',
                'Suivi ou résultat',
                'Contre-visite',
                'Question administrative',
                'Autre demande',
            ],
            'note' => 'Nous vous répondons par téléphone, WhatsApp ou email selon votre préférence.',
            'submit' => 'Envoyer ma demande',
            'success' => 'Votre message a bien été envoyé. Notre équipe vous répondra rapidement.',
        ],
        'head_office' => [
            'label' => 'Administration',
            'title' => 'Direction Générale — Bastos',
            'lead' => 'Pour les questions administratives, partenariats et demandes corporate.',
            'address' => 'Bastos, Yaoundé',
            'phone' => '+237 222 220 682 / +237 695 300 400',
            'email' => 'direction@gsautobilan.cm',
            'call_href' => 'tel:+237222220682',
            'email_href' => 'mailto:direction@gsautobilan.cm',
            'actions' => [
                'call' => 'Appeler la direction',
                'email' => 'Envoyer un email',
            ],
            'notice' => [
                'title' => 'Pas de ligne de visite technique sur ce site',
                'body' => 'Ce site est dédié uniquement aux services administratifs et à la direction.',
            ],
        ],
    ],
    'faq' => [
        'title' => 'Questions fréquentes',
        'items' => [
            [
                'question' => 'Quels documents dois-je apporter ?',
                'answer' => 'Préparez la carte grise originale, une pièce d’identité, l’assurance en cours de validité et l’ancien document de visite lorsqu’il est disponible.',
            ],
            [
                'question' => "Comment se passe la confirmation d’un rendez-vous ?",
                'answer' => 'Votre demande est enregistrée, puis l’équipe GS AUTOBILAN confirme le créneau par téléphone ou WhatsApp selon les disponibilités.',
            ],
            [
                'question' => 'Êtes-vous ouverts les jours fériés ?',
                'answer' => 'Oui, les agences indiquées accueillent les véhicules les jours fériés selon les horaires confirmés sur la page.',
            ],
            [
                'question' => 'Quelle agence choisir ?',
                'answer' => 'Choisissez Nkolbisson ou Obili Scalom selon votre proximité, votre itinéraire et les horaires qui conviennent le mieux à votre passage.',
            ],
            [
                'question' => 'Comment suivre ma demande ?',
                'answer' => 'Utilisez la page de suivi avec votre référence, votre numéro de téléphone et l’immatriculation du véhicule lorsque ces informations sont disponibles.',
            ],
            [
                'question' => 'Que faire en cas de contre-visite ?',
                'answer' => 'Faites corriger les points signalés, conservez votre procès-verbal et contactez l’agence concernée pour organiser le nouveau passage.',
            ],
            [
                'question' => 'Où se trouve la Direction Générale ?',
                'answer' => 'La Direction Générale est à Bastos, Yaoundé. Elle traite les demandes administratives, partenariats et questions corporate.',
            ],
            [
                'question' => 'Puis-je venir sans rendez-vous ?',
                'answer' => 'Un passage peut dépendre de l’affluence du centre. Pour éviter l’attente, il est préférable de prendre rendez-vous ou de contacter l’agence avant de venir.',
            ],
        ],
    ],
];
