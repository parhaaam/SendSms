<?php
// config for Parhaaam/SendSms
return [

    'default' => 'kavenegar',
    'drivers' => [
        'kavenegar' => [
            'key'  => env('kavenegar_key', ''),
        ],
        'smsir' => [
            'key'    => env('smsir_key', ''),
            'secret' => env('smsir_key', ''),
        ]
    ]
];
