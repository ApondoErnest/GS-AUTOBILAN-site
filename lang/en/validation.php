<?php

return [
    'accepted' => 'Please confirm :attribute.',
    'after_or_equal' => 'The :attribute field must be today or a future date.',
    'date' => 'The :attribute field must be a valid date.',
    'email' => 'The :attribute field must be a valid email address.',
    'exists' => 'The selected :attribute is not available.',
    'integer' => 'The :attribute field must be a valid number.',
    'max' => [
        'string' => 'The :attribute field must not exceed :max characters.',
    ],
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_without' => 'The :attribute field is required when :values is not provided.',
    'string' => 'The :attribute field must be text.',

    'custom' => [
        'agency_id' => [
            'exists' => 'Select an active GS AUTOBILAN agency.',
            'required' => 'Select a GS AUTOBILAN agency.',
        ],
        'confirmation_understood' => [
            'accepted' => 'Confirm that GS AUTOBILAN will validate the final appointment slot.',
        ],
        'email' => [
            'required_without' => 'Enter an email address or a phone number.',
        ],
        'phone' => [
            'regex' => 'Enter the phone number in international format, for example +237699000000.',
            'required_without' => 'Enter a phone number or an email address.',
        ],
        'preferred_date' => [
            'after_or_equal' => 'Choose an appointment date from today onward.',
        ],
        'reference' => [
            'regex' => 'Enter a valid reference, for example GS-2026-000001.',
        ],
        'service_id' => [
            'exists' => 'Select an available technical inspection service.',
            'required' => 'Select a technical inspection service.',
        ],
        'vehicle_registration' => [
            'required' => 'Enter the vehicle registration number.',
        ],
        'whatsapp' => [
            'regex' => 'Enter the WhatsApp number in international format, for example +237699000000.',
        ],
    ],

    'attributes' => [
        'agency_id' => 'agency',
        'confirmation_understood' => 'appointment confirmation',
        'contact_mode' => 'contact mode',
        'customer_message' => 'message',
        'customer_name' => 'full name',
        'email' => 'email',
        'message' => 'message',
        'name' => 'full name',
        'phone' => 'phone / WhatsApp',
        'preferred_date' => 'preferred date',
        'preferred_time_slot' => 'preferred time slot',
        'reference' => 'reference',
        'service_id' => 'service',
        'service_type' => 'service type',
        'subject' => 'subject',
        'vehicle_brand_model' => 'brand and model',
        'vehicle_category' => 'vehicle category',
        'vehicle_registration' => 'vehicle registration',
        'vehicle_type' => 'vehicle type',
        'whatsapp' => 'WhatsApp',
    ],
];
