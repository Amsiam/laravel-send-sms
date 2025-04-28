<?php

return [
    'default' => env('SMS_DRIVER', 'bulk_sms'),

    'drivers' => [
        'bulk_sms' => [
            'driver' => 'bulk_sms',
            'api_key' => env('SMS_BULK_SMS_BD_API_KEY'),
            'sender_id' => env('SMS_BULK_SMS_BD_SENDERID'),
        ]
    ],
];
