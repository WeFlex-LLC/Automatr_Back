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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '40026398554-hk914b8vtr4qj3gi2l5vkrt00fsa0o8s.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '331261461769561',
        'client_secret' => '595c93fbe2730159acc82cc073b2e0d3',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],
    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],

];
