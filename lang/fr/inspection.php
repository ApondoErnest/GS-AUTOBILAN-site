<?php

return [
    'meta_title' => 'GS AUTOBILAN - Visite Technique',
    'hero' => [
        'eyebrow' => 'Visite Technique',
        'title' => 'Comprendre et réussir votre visite technique',
        'lead' => 'Découvrez les contrôles effectués, préparez vos documents et suivez chaque étape de votre passage chez GS AUTOBILAN.',
        'prepare_href' => '#preparer-ma-visite',
        'actions' => [
            'prepare' => 'Préparer ma visite',
        ],
        'highlights' => [
            [
                'label' => 'Contrôle rigoureux',
                'icon' => 'heroicon-o-shield-check',
            ],
            [
                'label' => 'Procédure transparente',
                'icon' => 'heroicon-o-eye',
            ],
            [
                'label' => 'Équipements professionnels',
                'icon' => 'heroicon-o-wrench-screwdriver',
            ],
            [
                'label' => 'Orientation après contrôle',
                'icon' => 'heroicon-o-arrow-path-rounded-square',
            ],
        ],
    ],
    'importance' => [
        'title' => 'Pourquoi la visite technique est essentielle',
        'lead' => "La visite technique contribue à la sécurité de tous usagers de la route et à la protection de l’environnement. Elle garantit que votre véhicule respecte les exigences réglementaires en vigueur.",
        'cards' => [
            [
                'title' => 'Sécurité routière',
                'copy' => 'Identifie les défauts pouvant compromettre la sécurité du conducteur, des passagers et des autres usagers.',
                'icon' => 'heroicon-o-shield-check',
                'tone' => 'primary',
            ],
            [
                'title' => 'Prévention des risques',
                'copy' => "La détection précoce des anomalies permet d’éviter les pannes, les accidents et les coûts élevés.",
                'icon' => 'heroicon-o-exclamation-triangle',
                'tone' => 'danger',
            ],
            [
                'title' => 'Conformité du véhicule',
                'copy' => 'Vérification technique et documentaire structurée pour assurer le respect des normes légales en vigueur.',
                'icon' => 'heroicon-o-document-check',
                'tone' => 'primary',
            ],
        ],
    ],
    'control_points' => [
        'title' => 'Les principaux points de contrôle',
        'lead' => "Nos équipes vérifient les systèmes essentiels du véhicule à l’aide d’équipements spécialisés et d’inspections visuelles.",
        'items' => [
            [
                'title' => '1. Freinage',
                'copy' => 'Efficacité du freinage, état des disques et plaquettes.',
                'icon' => 'images/inspection/control-braking.svg',
            ],
            [
                'title' => '2. Suspension',
                'copy' => 'État des amortisseurs, ressorts et organes de liaison.',
                'icon' => 'images/inspection/control-suspension.svg',
            ],
            [
                'title' => '3. Éclairage et signalisation',
                'copy' => 'Fonctionnement des feux, clignotants, feux stop et réflecteurs.',
                'icon' => 'images/inspection/control-lighting.svg',
            ],
            [
                'title' => '4. Pneumatiques',
                'copy' => 'Usure, pression, état général et conformité.',
                'icon' => 'images/inspection/control-tyres.svg',
            ],
            [
                'title' => '5. Direction et ripage',
                'copy' => 'Jeu dans la direction, parallélisme et ripage des roues.',
                'icon' => 'images/inspection/control-steering.svg',
            ],
            [
                'title' => '6. Identification',
                'copy' => 'Concordance des numéros, plaques et marquages réglementaires.',
                'icon' => 'images/inspection/control-identification.svg',
            ],
            [
                'title' => '7. Inspection visuelle',
                'copy' => 'Contrôle des éléments mécaniques, carrosserie et châssis.',
                'icon' => 'images/inspection/control-visual.svg',
            ],
            [
                'title' => '8. Vérification documentaire',
                'copy' => 'Validité des documents et conformité administrative du véhicule.',
                'icon' => 'images/inspection/control-documents.svg',
            ],
        ],
    ],
    'process' => [
        'title' => 'Comment se déroule votre passage ?',
        'steps' => [
            [
                'title' => 'Accueil et réception',
                'copy' => 'Accueil du véhicule et vérification préliminaire.',
                'icon' => 'images/inspection/process-reception.svg',
            ],
            [
                'title' => 'Enregistrement du dossier',
                'copy' => 'Contrôle des documents et création du dossier de visite.',
                'icon' => 'images/inspection/process-file.svg',
            ],
            [
                'title' => 'Passage sur la ligne de contrôle',
                'copy' => "Contrôles techniques et tests grâce à l’aide d’équipements spécialisés.",
                'icon' => 'images/inspection/process-car.svg',
            ],
            [
                'title' => 'Synthèse des résultats',
                'copy' => 'Analyse des points contrôlés et détermination du résultat.',
                'icon' => 'images/inspection/process-results.svg',
            ],
            [
                'title' => 'Remise du procès-verbal',
                'copy' => 'Explication du résultat et remise du procès-verbal officiel.',
                'icon' => 'images/inspection/process-certificate.svg',
            ],
        ],
        'outcomes' => [
            [
                'title' => 'Accepté',
                'copy' => 'Le véhicule est conforme. Vous repartez avec votre procès-verbal valide.',
                'icon' => 'images/inspection/result-accepted.svg',
                'tone' => 'success',
            ],
            [
                'title' => 'Contre-visite requise',
                'copy' => 'Des défaillances mineures détectées. Une contre-visite est à effectuer.',
                'icon' => 'images/inspection/result-warning.svg',
                'tone' => 'warning',
            ],
            [
                'title' => 'Résultat défavorable',
                'copy' => 'Des défaillances majeures détectées. Le véhicule ne peut pas circuler.',
                'icon' => 'images/inspection/result-rejected.svg',
                'tone' => 'danger',
            ],
        ],
    ],
    'preparation' => [
        'title' => 'Préparez votre passage',
        'cards' => [
            [
                'variant' => 'light',
                'title' => 'Pièces à présenter',
                'icon' => 'images/inspection/prep-documents.svg',
                'items' => [
                    [
                        'label' => 'Carte grise originale',
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Pièce d’identité",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => 'Assurance en cours de validité',
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Ancien document de visite, lorsqu’il est disponible",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => 'Documents spécifiques à la catégorie du véhicule, le cas échéant',
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                ],
            ],
            [
                'variant' => 'light',
                'title' => 'Conseils pratiques',
                'icon' => 'images/inspection/prep-tips.svg',
                'items' => [
                    [
                        'label' => 'Vérifiez le fonctionnement des feux',
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Contrôlez l’état apparent des pneumatiques",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Assurez une bonne visibilité des éléments d’identification",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Facilitez l’accès au châssis et aux zones inspectées",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => 'Présentez-vous avec un véhicule dans un état permettant le contrôle',
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                    [
                        'label' => "Arrivez suffisamment tôt pour l’accueil administratif",
                        'icon' => 'images/inspection/prep-check.svg',
                    ],
                ],
            ],
            [
                'variant' => 'dark',
                'items' => [
                    [
                        'copy' => 'Ce parcours concerne les véhicules légers, utilitaires, taxis, véhicules de transport, poids lourds et autres catégories prises en charge.',
                        'icon' => 'images/inspection/prep-vehicles.svg',
                    ],
                    [
                        'copy' => 'La demande en ligne ne constitue pas une confirmation automatique. Votre créneau sera validé directement par l’équipe GS AUTOBILAN.',
                        'icon' => 'images/inspection/prep-shield.svg',
                    ],
                ],
            ],
        ],
        'notice' => [
            'copy' => 'Un dossier complet et un véhicule correctement préparé facilitent le passage, mais ne préjugent pas du résultat final du contrôle.',
            'icon' => 'images/inspection/prep-info.svg',
        ],
    ],
];
