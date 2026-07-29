<?php

return [
    'accepted' => 'Veuillez confirmer :attribute.',
    'after_or_equal' => 'Le champ :attribute doit être aujourd’hui ou une date future.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'exists' => 'Le champ :attribute sélectionné n’est pas disponible.',
    'integer' => 'Le champ :attribute doit être un nombre valide.',
    'max' => [
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ],
    'regex' => 'Le format du champ :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_without' => 'Le champ :attribute est obligatoire lorsque :values n’est pas renseigné.',
    'string' => 'Le champ :attribute doit être du texte.',

    'custom' => [
        'agency_id' => [
            'exists' => 'Sélectionnez une agence GS AUTOBILAN active.',
            'required' => 'Sélectionnez une agence GS AUTOBILAN.',
        ],
        'confirmation_understood' => [
            'accepted' => 'Confirmez que GS AUTOBILAN validera le créneau définitif.',
        ],
        'email' => [
            'required_without' => 'Saisissez une adresse email ou un numéro de téléphone.',
        ],
        'phone' => [
            'regex' => 'Saisissez le numéro de téléphone au format international, par exemple +237699000000.',
            'required_without' => 'Saisissez un numéro de téléphone ou une adresse email.',
        ],
        'preferred_date' => [
            'after_or_equal' => 'Choisissez une date de rendez-vous à partir d’aujourd’hui.',
        ],
        'reference' => [
            'regex' => 'Saisissez une référence valide, par exemple GS-2026-000001.',
        ],
        'service_id' => [
            'exists' => 'Sélectionnez une prestation de visite technique disponible.',
            'required' => 'Sélectionnez une prestation de visite technique.',
        ],
        'vehicle_registration' => [
            'required' => 'Saisissez l’immatriculation du véhicule.',
        ],
        'whatsapp' => [
            'regex' => 'Saisissez le WhatsApp au format international, par exemple +237699000000.',
        ],
    ],

    'attributes' => [
        'agency_id' => 'agence',
        'confirmation_understood' => 'la confirmation du rendez-vous',
        'contact_mode' => 'mode de contact',
        'customer_message' => 'message',
        'customer_name' => 'nom complet',
        'email' => 'email',
        'message' => 'message',
        'name' => 'nom complet',
        'phone' => 'téléphone / WhatsApp',
        'preferred_date' => 'date souhaitée',
        'preferred_time_slot' => 'créneau souhaité',
        'reference' => 'référence',
        'service_id' => 'prestation',
        'service_type' => 'type de prestation',
        'subject' => 'sujet',
        'vehicle_brand_model' => 'marque et modèle',
        'vehicle_category' => 'catégorie du véhicule',
        'vehicle_registration' => 'immatriculation',
        'vehicle_type' => 'type de véhicule',
        'whatsapp' => 'WhatsApp',
    ],
];
