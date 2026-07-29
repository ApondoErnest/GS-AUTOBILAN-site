<?php

return [
    'navigation_label' => 'Rendez-vous',
    'model' => [
        'singular' => 'rendez-vous',
        'plural' => 'rendez-vous',
    ],
    'pages' => [
        'list' => [
            'title' => 'Rendez-vous',
            'subtitle' => 'Traitez les demandes, confirmations et dossiers documentaires depuis un bureau opérationnel unique.',
        ],
        'edit' => [
            'title' => 'Rendez-vous :reference',
            'subtitle' => 'Mettez à jour le client, le véhicule, le planning et les notes de suivi.',
        ],
    ],
    'actions' => [
        'edit' => 'Modifier',
    ],
    'table' => [
        'heading' => 'Bureau rendez-vous',
        'description' => 'Une vue compacte pour les contacts client, le planning, l\'agence responsable et le suivi documentaire.',
        'empty_heading' => 'Aucun rendez-vous',
        'empty_description' => 'Créez le premier rendez-vous pour suivre les demandes et la préparation des dossiers.',
        'copy_reference' => 'Référence copiée',
        'columns' => [
            'reference' => 'Référence',
            'contact' => 'Contact',
            'agency' => 'Agence / service',
            'visit' => 'Demande',
            'confirmed' => 'Confirmé',
            'status' => 'Rendez-vous',
            'documents' => 'Documents',
            'created' => 'Créé',
        ],
        'descriptions' => [
            'missing_contact' => 'Aucun contact secondaire',
            'no_time_slot' => 'Aucun créneau',
            'not_confirmed' => 'Non confirmé',
            'not_started' => 'Non démarré',
            'not_set' => 'Non défini',
            'whatsapp' => 'WhatsApp :phone',
        ],
        'filters' => [
            'status' => 'Statut rendez-vous',
            'agency' => 'Agence',
            'document_status' => 'Statut dossier',
            'visit_window' => 'Date de visite souhaitée',
            'from' => 'Du',
            'until' => 'Au',
        ],
    ],
    'form' => [
        'sections' => [
            'customer' => [
                'heading' => 'Client',
                'description' => 'Identité du client et coordonnées joignables.',
            ],
            'agency_service' => [
                'heading' => 'Agence et service',
                'description' => 'Affectez la demande au bon centre de contrôle et au bon service.',
            ],
            'vehicle' => [
                'heading' => 'Véhicule',
                'description' => 'Immatriculation et classification du véhicule à contrôler.',
            ],
            'schedule' => [
                'heading' => 'Planning et statut',
                'description' => 'Demande souhaitée, rendez-vous confirmé et état opérationnel.',
            ],
            'messages' => [
                'heading' => 'Messages et notes',
                'description' => 'Demande client, message public de suivi et notes privées équipe.',
            ],
        ],
        'fields' => [
            'reference' => [
                'label' => 'Référence',
                'helper' => 'Générée automatiquement à la création du rendez-vous.',
            ],
            'customer_name' => [
                'label' => 'Nom du client',
                'placeholder' => 'Nom complet',
            ],
            'phone' => [
                'label' => 'Téléphone',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'placeholder' => '+237 6XX XXX XXX',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'client@example.com',
            ],
            'agency_id' => [
                'label' => 'Agence',
                'placeholder' => 'Choisir une agence',
            ],
            'service_id' => [
                'label' => 'Service',
                'placeholder' => 'Choisir un service',
            ],
            'vehicle_registration' => [
                'label' => 'Immatriculation',
                'placeholder' => 'CE123AB',
            ],
            'vehicle_type' => [
                'label' => 'Type de véhicule',
                'placeholder' => 'Voiture, camion, bus...',
            ],
            'vehicle_category' => [
                'label' => 'Catégorie',
                'placeholder' => 'Léger, utilitaire, lourd...',
            ],
            'vehicle_brand_model' => [
                'label' => 'Marque / modèle',
                'placeholder' => 'Toyota Corolla',
            ],
            'preferred_date' => [
                'label' => 'Date souhaitée',
            ],
            'preferred_time_slot' => [
                'label' => 'Créneau souhaité',
                'placeholder' => '09h00-10h00',
            ],
            'confirmed_date' => [
                'label' => 'Date confirmée',
            ],
            'confirmed_time_slot' => [
                'label' => 'Créneau confirmé',
                'placeholder' => '10h00-11h00',
            ],
            'status' => [
                'label' => 'Statut',
            ],
            'customer_message' => [
                'label' => 'Message client',
                'placeholder' => 'Notes issues de la demande client',
            ],
            'public_message' => [
                'label' => 'Message public de suivi',
                'placeholder' => 'Message visible par le client',
            ],
            'internal_notes' => [
                'label' => 'Notes internes',
                'placeholder' => 'Notes privées pour l\'équipe opérations',
            ],
        ],
    ],
    'statuses' => [
        'unknown' => 'Inconnu',
        'booking' => [
            'new_request' => 'Nouvelle demande',
            'pending_confirmation' => 'En attente de confirmation',
            'confirmed' => 'Confirmé',
            'rescheduled' => 'Reprogrammé',
            'cancelled' => 'Annulé',
            'completed' => 'Terminé',
            'no_show' => 'Absence',
        ],
        'document' => [
            'not_reviewed' => 'Non vérifié',
            'complete' => 'Complet',
            'missing_info' => 'Informations manquantes',
            'contact_agency' => 'Contacter agence',
            'ready_for_visit' => 'Prêt pour visite',
        ],
    ],
];
