<?php

return [
    'hero' => [
        'eyebrow' => 'Bienvenue chez GS AUTOBILAN',
        'title' => "Votre sécurité,<br>c'est notre métier.",
        'lead' => 'Centres professionnels de visite technique automobile à Yaoundé, avec un service rapide, transparent et orienté sécurité.',
        'trust_items' => [
            [
                'label' => '2 agences<br>opérationnelles',
                'icon' => 'heroicon-o-shield-check',
            ],
            [
                'label' => 'Ouvert les<br>jours fériés',
                'icon' => 'heroicon-o-clock',
            ],
            [
                'label' => 'Service<br>professionnel',
                'icon' => 'heroicon-o-check-badge',
            ],
            [
                'label' => 'Suivi du<br>rendez-vous',
                'icon' => 'heroicon-o-clipboard-document-list',
            ],
            [
                'label' => 'Bilingue<br>FR / EN',
                'icon' => 'heroicon-o-language',
            ],
        ],
    ],
    'agencies' => [
        'title' => 'Trouvez votre agence GS AUTOBILAN',
        'copy' => "Choisissez l'agence la plus proche, consultez l'itinéraire ou demandez votre rendez-vous en ligne.",
        'book_action' => 'Prendre RDV',
        'cards' => [
            [
                'name' => 'GS AUTOBILAN Nkolbisson',
                'address' => 'Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert',
                'hours' => '07h00 – 18h00, Lundi à Samedi',
                'holiday' => 'Ouvert les jours fériés',
                'phone' => '+237 678 844 791 / +237 652 516 527',
                'mapHref' => 'https://www.google.com/maps?q=3.8882487,11.4549352',
                'image' => 'images/homepage/agency-1.png',
            ],
            [
                'name' => 'GS AUTOBILAN Obili Scalom',
                'address' => 'Obili Scalom',
                'hours' => 'Lundi à Samedi: 07h00 – 19h00<br>Dimanche: 07h00 – 15h00',
                'holiday' => 'Ouvert les jours fériés',
                'phone' => '+237 678 844 791 / +237 658 473 182',
                'mapHref' => 'https://www.google.com/maps?q=3.8471748,11.4967492',
                'image' => 'images/homepage/agency-2.png',
            ],
        ],
    ],
    'inspection' => [
        'points_title' => 'Les points essentiels contrôlés',
        'services_action' => 'Voir tous nos services',
        'process_title' => 'Comment se déroule votre visite technique ?',
        'learn_action' => 'En savoir plus sur la visite technique',
        'points' => [
            [
                'label' => 'Freinage',
                'icon' => 'heroicon-o-cog-6-tooth',
            ],
            [
                'label' => 'Suspension',
                'icon' => 'heroicon-o-adjustments-vertical',
            ],
            [
                'label' => 'Ripage',
                'icon' => 'heroicon-o-arrows-right-left',
            ],
            [
                'label' => 'Pollution',
                'icon' => 'heroicon-o-cloud',
            ],
            [
                'label' => 'Réglage<br>des phares',
                'icon' => 'heroicon-o-light-bulb',
            ],
            [
                'label' => 'Pneumatiques',
                'icon' => 'heroicon-o-circle-stack',
            ],
            [
                'label' => 'Direction',
                'icon' => 'heroicon-o-arrow-path-rounded-square',
            ],
            [
                'label' => 'Signalisation',
                'icon' => 'heroicon-o-exclamation-triangle',
            ],
            [
                'label' => 'Châssis',
                'icon' => 'heroicon-o-truck',
            ],
            [
                'label' => 'Contrôle<br>visuel',
                'icon' => 'heroicon-o-eye',
            ],
        ],
        'steps' => [
            [
                'title' => 'Accueil & Dépôt',
                'copy' => "Arrivée au centre, accueil de l'usager et prise en charge initiale du véhicule.",
            ],
            [
                'title' => 'Vérification Documentaire',
                'copy' => 'Contrôle de la carte grise et des pièces administratives requises.',
            ],
            [
                'title' => 'Identification',
                'copy' => "Vérification de la concordance du numéro de châssis et des plaques d'immatriculation.",
            ],
            [
                'title' => 'Contrôle Technique',
                'copy' => "Passage sur les bancs de mesure : tests automatisés du système de freinage, de la suspension, du ripage et de l'alignement des phares.",
            ],
            [
                'title' => 'Contrôle Visuel',
                'copy' => 'Inspection approfondie sous châssis, usure des pneumatiques et intégrité de la structure par un technicien qualifié.',
            ],
            [
                'title' => 'Délivrance & Orientation',
                'copy' => "Remise du rapport d'inspection officiel, validation de la vignette de visite technique ou directives claires en cas de contre-visite.",
            ],
        ],
    ],
    'tariffs_gallery' => [
        'tariffs_title' => 'Tarifs par catégorie',
        'tariffs_action' => 'Voir tous les tarifs',
        'tariffs_source' => 'Tarifs officiels indicatifs par catégorie de véhicule.',
        'table' => [
            'category' => 'Catégorie',
            'type' => 'Type',
            'price' => 'Tarif',
            'validity' => 'Validité',
        ],
        'tariffs' => [
            [
                'category' => 'A',
                'type' => 'Taxi / Auto-école',
                'price' => '4 900 FCFA',
                'validity' => '03 mois',
            ],
            [
                'category' => 'B',
                'type' => 'Véhicule de tourisme',
                'price' => '17 900 FCFA',
                'validity' => '12 mois',
            ],
            [
                'category' => 'B1',
                'type' => 'Pickup 3,5 T / Véhicules utilitaires légers',
                'price' => '15 500 FCFA',
                'validity' => '06 mois',
            ],
            [
                'category' => 'C < 3,5T',
                'type' => 'Mini-bus',
                'price' => '15 500 FCFA',
                'validity' => '03 mois',
            ],
            [
                'category' => 'C',
                'type' => 'Grand bus / Coaster',
                'price' => '19 080 FCFA',
                'validity' => '03 mois',
            ],
            [
                'category' => 'D',
                'type' => 'Camions / Tracteurs / Sémi-remorques / Véhicules utilitaires lourds',
                'price' => '26 235 FCFA',
                'validity' => '06 mois',
            ],
            [
                'category' => 'D',
                'type' => 'Autres engins',
                'price' => '41 750 FCFA',
                'validity' => '06 mois',
            ],
        ],
        'why_title' => 'Pourquoi choisir<br>GS AUTOBILAN ?',
        'why_items' => [
            [
                'label' => 'Procédure claire et transparente',
                'icon' => 'heroicon-o-shield-check',
            ],
            [
                'label' => 'Agences accessibles',
                'icon' => 'heroicon-o-map-pin',
            ],
            [
                'label' => 'Service bilingue FR / EN',
                'icon' => 'heroicon-o-language',
            ],
            [
                'label' => 'Suivi du rendez-vous',
                'icon' => 'heroicon-o-clipboard-document-list',
            ],
            [
                'label' => 'Accompagnement client',
                'icon' => 'heroicon-o-user-group',
            ],
            [
                'label' => 'Ouvert les jours fériés',
                'icon' => 'heroicon-o-check-badge',
            ],
        ],
        'gallery_title' => 'Nos agences en images',
        'gallery_images' => [
            'images/homepage/agence-3.png',
            'images/homepage/agence-4.png',
            'images/homepage/agence-5.png',
            'images/homepage/agence-6.png',
        ],
    ],
    'advice_cta' => [
        'advice_title' => 'Conseils utiles avant votre visite',
        'tag' => 'Conseil',
        'read_action' => "Lire l'article",
        'all_articles_action' => 'Voir tous les articles',
        'articles' => [
            [
                'title' => 'Comment préparer votre véhicule pour la visite technique',
                'image' => 'images/homepage/prepare-visit.png',
                'slug' => 'preparer-votre-vehicule-visite-technique',
            ],
            [
                'title' => 'Documents nécessaires avant votre passage',
                'image' => 'images/homepage/necessary-docs.png',
                'slug' => 'documents-necessaires-visite-technique',
            ],
            [
                'title' => 'Que faire en cas de contre-visite ?',
                'image' => 'images/homepage/case-cv.png',
                'slug' => 'que-faire-en-cas-de-contre-visite',
            ],
        ],
        'cta_title' => 'Votre véhicule est prêt pour la visite technique ?',
        'background' => 'images/homepage/agence-6.png',
        'columns' => [
            [
                'title' => 'Comment préparer votre véhicule pour la visite technique',
                'items' => [
                    'Vérifiez les feux, clignotants, phares et essuie-glaces.',
                    'Contrôlez l’état des pneus, la pression et la roue de secours.',
                    'Assurez-vous du bon fonctionnement des freins et du klaxon.',
                    'Nettoyez les plaques, le numéro de châssis et les zones à inspecter.',
                    'Retirez les objets qui peuvent gêner le contrôle du véhicule.',
                ],
            ],
            [
                'title' => 'Documents nécessaires avant votre passage',
                'items' => [
                    'Carte grise originale du véhicule.',
                    'Attestation d’assurance en cours de validité.',
                    'Pièce d’identité du propriétaire ou du conducteur.',
                    'Ancienne vignette ou rapport de visite technique si disponible.',
                    'Autorisation ou documents société pour les véhicules professionnels.',
                ],
            ],
        ],
    ],
];
