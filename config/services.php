<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'mode' => env('PAYPAL_MODE'),
    ],
    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT'),
        'maps_key' => env('GOOGLE_MAPS_API_KEY'),
    ],
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],
    'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ],
    'twilio' => [
        'sid'   => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from'  => env('TWILIO_FROM'),
    ],
    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'mailtrap' => [
            'transport' => 'smtp',
            'host' => env('MAILTRAP_HOST'),
            'port' => env('MAILTRAP_PORT'),
            'encryption' => env('MAILTRAP_ENCRYPTION'),
            'username' => env('MAILTRAP_USERNAME'),
            'password' => env('MAILTRAP_PASSWORD'),
        ],
    ],


];
