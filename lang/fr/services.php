<?php

return [
    'meta_title' => 'GS AUTOBILAN - Nos services',
    'hero' => [
        'eyebrow' => 'Nos services',
        'title' => 'Des services de visite technique pensés pour la sécurité',
        'lead' => 'GS AUTOBILAN accompagne les particuliers, les professionnels et les transporteurs avec des contrôles rigoureux, clairs et transparents, adaptés à chaque type de véhicule.',
        'focus_items' => [
            [
                'label' => 'Véhicules légers',
                'icon' => 'car',
            ],
            [
                'label' => 'Utilitaires &amp;<br>poids lourds',
                'icon' => 'heroicon-o-truck',
            ],
            [
                'label' => 'Contre-visite',
                'icon' => 'heroicon-o-arrow-path',
            ],
            [
                'label' => 'Préparation &amp;<br>orientation',
                'icon' => 'heroicon-o-document-check',
            ],
        ],
        'actions' => [
            'discover' => 'Découvrir nos services',
        ],
    ],
    'architecture' => [
        'core' => [
            'eyebrow' => 'Nos types de prestations',
            'cards' => [
                [
                    'id' => 'service-visite-technique-periodique',
                    'title' => 'Visite technique périodique',
                    'summary' => "Le contrôle principal destiné au suivi réglementaire et à la vérification de l’état technique général du véhicule.",
                    'points' => [
                        'Contrôle des éléments essentiels',
                        'Vérification structurée',
                        "Rapport officiel à l’issue du passage",
                    ],
                    'action' => 'En savoir plus',
                    'action_target' => 'technical_inspection',
                    'icon' => 'car',
                ],
                [
                    'id' => 'service-contre-visite',
                    'title' => 'Contre-visite',
                    'summary' => 'Le passage de contrôle après correction des éléments signalés lors de la visite précédente.',
                    'points' => [
                        'Vérification ciblée',
                        'Passage après réparation',
                        'Orientation selon les corrections attendues',
                    ],
                    'action' => 'Comprendre la contre-visite',
                    'action_target' => 'technical_inspection',
                    'icon' => 'heroicon-o-clipboard-document-check',
                ],
                [
                    'id' => 'service-orientation-preparation',
                    'title' => 'Orientation et préparation au passage',
                    'summary' => 'Un accompagnement pratique pour vous aider à préparer votre dossier et à comprendre les exigences du passage.',
                    'points' => [
                        'Préparation des documents',
                        'Compréhension du type de passage',
                        'Aide avant rendez-vous',
                    ],
                    'action' => 'Voir la préparation',
                    'action_target' => 'booking',
                    'icon' => 'heroicon-o-user-circle',
                ],
            ],
        ],
        'vehicles' => [
            'eyebrow' => 'Véhicules pris en charge',
            'conditions_action' => 'Voir toutes les conditions',
            'profiles' => [
                [
                    'id' => 'vehicule-leger',
                    'tab' => 'Véhicule léger',
                    'icon' => 'car',
                    'image' => 'images/servicespage/light-vehicle.png',
                    'image_alt' => 'Véhicule léger',
                    'title' => 'Pour les véhicules légers',
                    'copy' => 'La visite technique périodique permet de vérifier les différents systèmes de votre véhicule afin d’assurer votre sécurité et celle des autres usagers de la route.',
                    'details' => [
                        [
                            'label' => 'Service recommandé',
                            'value' => 'Visite technique périodique',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Centres disponibles',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Documents clés',
                            'value' => 'Carte grise, Pièce d’identité, Assurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Durée moyenne',
                            'value' => '30 à 45 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'À savoir',
                    'notice_copy' => 'La présentation d’un dossier complet accélère votre passage.',
                    'notice_items' => [
                        'Carte grise originale',
                        'Pièce d’identité',
                        'Assurance en cours de validité',
                        'Ancien document de visite (si disponible)',
                    ],
                ],
                [
                    'id' => 'utilitaire',
                    'tab' => 'Utilitaire',
                    'icon' => 'heroicon-o-truck',
                    'image' => 'images/servicespage/utility-vehicle.png',
                    'image_alt' => 'Véhicule utilitaire',
                    'title' => 'Pour les utilitaires',
                    'copy' => 'La visite technique périodique permet de vérifier les différents systèmes de votre utilitaire afin d’assurer votre sécurité et celle des autres usagers de la route.',
                    'details' => [
                        [
                            'label' => 'Service recommandé',
                            'value' => 'Visite technique périodique',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Centres disponibles',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Documents clés',
                            'value' => 'Carte grise, Pièce d’identité, Assurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Durée moyenne',
                            'value' => '35 à 50 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'À savoir',
                    'notice_copy' => 'La présentation d’un dossier complet accélère votre passage.',
                    'notice_items' => [
                        'Carte grise originale',
                        'Pièce d’identité',
                        'Assurance en cours de validité',
                        'Ancien document de visite (si disponible)',
                    ],
                ],
                [
                    'id' => 'taxi-transport',
                    'tab' => 'Taxi / Transport',
                    'icon' => 'taxi',
                    'image' => 'images/servicespage/taxi-transport.png',
                    'image_alt' => 'Taxi ou véhicule de transport',
                    'title' => 'Pour les taxis / transport',
                    'copy' => 'La visite technique périodique permet de vérifier les systèmes essentiels de votre taxi ou véhicule de transport afin d’assurer la sécurité des passagers, du conducteur et des autres usagers de la route.',
                    'details' => [
                        [
                            'label' => 'Service recommandé',
                            'value' => 'Visite technique périodique',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Centres disponibles',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Documents clés',
                            'value' => 'Carte grise, Pièce d’identité, Assurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Durée moyenne',
                            'value' => '35 à 50 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'À savoir',
                    'notice_copy' => 'La présentation d’un dossier complet facilite et accélère le passage de votre véhicule de transport.',
                    'notice_items' => [
                        'Carte grise originale',
                        'Pièce d’identité',
                        'Assurance en cours de validité',
                        'Autorisation de transport / Licence',
                        'Ancien document de visite (si disponible)',
                    ],
                ],
                [
                    'id' => 'poids-lourd',
                    'tab' => 'Poids lourd',
                    'icon' => 'heroicon-o-truck',
                    'image' => 'images/servicespage/heavy-vehicle.png',
                    'image_alt' => 'Poids lourd',
                    'title' => 'Pour les poids lourds',
                    'copy' => 'La visite technique périodique permet de vérifier la conformité et la sécurité de votre poids lourd. Elle contribue à prévenir les risques, à préserver votre matériel et à garantir la sécurité de tous sur la route.',
                    'details' => [
                        [
                            'label' => 'Service recommandé',
                            'value' => 'Visite technique périodique',
                            'icon' => 'heroicon-o-shield-check',
                        ],
                        [
                            'label' => 'Centres disponibles',
                            'value' => 'Nkolbisson, Obili Scalom',
                            'icon' => 'heroicon-o-map-pin',
                        ],
                        [
                            'label' => 'Documents clés',
                            'value' => 'Carte grise, Pièce d’identité, Assurance',
                            'icon' => 'heroicon-o-document-text',
                        ],
                        [
                            'label' => 'Durée moyenne',
                            'value' => '45 à 60 minutes',
                            'icon' => 'heroicon-o-clock',
                        ],
                    ],
                    'notice_title' => 'À savoir',
                    'notice_copy' => 'La présentation d’un dossier complet accélère votre passage.',
                    'notice_items' => [
                        'Carte grise originale',
                        'Pièce d’identité',
                        'Assurance en cours de validité',
                        'Documents de transport / visite précédente',
                    ],
                ],
            ],
        ],
        'technical_matrix' => [
            'title' => 'Ce que nos contrôles prennent en compte',
            'lead' => 'Chaque visite comprend une série de vérifications techniques essentielles pour garantir votre sécurité.',
            'items' => [
                [
                    'title' => 'Freinage',
                    'copy' => 'Efficacité, équilibre et fonctionnement du frein de stationnement.',
                    'icon' => 'brake',
                ],
                [
                    'title' => 'Suspension',
                    'copy' => 'État des amortisseurs, des ressorts et des composants de la suspension.',
                    'icon' => 'suspension',
                ],
                [
                    'title' => 'Éclairage & phares',
                    'copy' => 'Fonctionnement, orientation et état de l’ensemble des feux et dispositifs lumineux.',
                    'icon' => 'headlight',
                ],
                [
                    'title' => 'Pneumatiques',
                    'copy' => 'Usure, état général, conformité et pression (visuelle).',
                    'icon' => 'tire',
                ],
                [
                    'title' => 'Identification du véhicule',
                    'copy' => 'Vérification des plaques, numéro de châssis et autres éléments d’identification.',
                    'icon' => 'id-card',
                ],
                [
                    'title' => 'Inspection visuelle',
                    'copy' => 'Contrôle global de l’état apparent du véhicule et des éléments de sécurité.',
                    'icon' => 'eye',
                ],
                [
                    'title' => 'Alignement / ripage',
                    'copy' => 'Vérification du comportement directionnel et du guidage du véhicule.',
                    'icon' => 'steering',
                ],
                [
                    'title' => 'Documents & cohérence administrative',
                    'copy' => 'Vérification des pièces et cohérence des informations du dossier.',
                    'icon' => 'clipboard',
                ],
            ],
        ],
        'decision_gate' => [
            'title' => 'Quel service vous correspond ?',
            'routes' => [
                [
                    'intent' => 'Je souhaite effectuer ma visite habituelle',
                    'result' => 'Visite technique périodique',
                    'target' => 'technical_inspection',
                ],
                [
                    'intent' => 'Je reviens après avoir corrigé des anomalies',
                    'result' => 'Contre-visite',
                    'target' => 'technical_inspection',
                ],
                [
                    'intent' => 'Je ne sais pas quels documents préparer',
                    'result' => 'Orientation & préparation',
                    'target' => 'booking',
                ],
                [
                    'intent' => 'Je veux choisir une date de passage',
                    'result' => 'Prendre rendez-vous',
                    'target' => 'booking',
                ],
            ],
            'cta' => [
                'title' => 'Passez à l’étape suivante',
                'lead' => 'Choisissez l’action qui vous convient le mieux.',
                'actions' => [
                    [
                        'label' => 'Prendre rendez-vous',
                        'target' => 'booking',
                        'icon' => 'heroicon-o-calendar-days',
                    ],
                    [
                        'label' => 'Préparer ma visite',
                        'target' => 'technical_inspection',
                        'icon' => 'heroicon-o-document-text',
                    ],
                    [
                        'label' => 'Voir nos agences',
                        'target' => 'agencies',
                        'icon' => 'heroicon-o-map-pin',
                    ],
                    [
                        'label' => 'Consulter les tarifs',
                        'target' => 'tariffs',
                        'icon' => 'heroicon-o-tag',
                    ],
                ],
                'notice' => 'Votre demande de rendez-vous sera confirmée par téléphone ou WhatsApp par l’équipe GS AUTOBILAN.',
            ],
        ],
    ],
];
