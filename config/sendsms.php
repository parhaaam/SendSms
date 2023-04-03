<?php
// config for Parhaaam/SendSms
return [

    'default' => 'kavenegar',
    'drivers' => [
        'kavenegar' => [
            'key'            => env('kavenegar_key', ''),
            'provider_class' => \Parhaaam\SendSms\Drivers\Kavenegar\KavenegarSmsProvider::class
        ],
        'smsir' => [
            'key'            => env('smsir_key', ''),
            'secret'         => env('smsir_key', ''),
            'provider_class' => \Parhaaam\SendSms\Drivers\SmsIr\SmsIr::class
        ]
    ]
];
