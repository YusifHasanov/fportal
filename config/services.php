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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'google' => [
        'analytics_id' => env('GOOGLE_ANALYTICS_ID'),
        'gtm_id' => env('GOOGLE_GTM_ID'),
        'search_console_verification' => env('GOOGLE_SEARCH_CONSOLE_VERIFICATION'),
        'search_console_token' => env('GOOGLE_SEARCH_CONSOLE_TOKEN'),
        'indexing_api_key' => env('GOOGLE_INDEXING_API_KEY'),
        
        // Service Account Credentials
        'service_account' => [
            'type' => env('GOOGLE_SERVICE_ACCOUNT_TYPE'),
            'project_id' => env('GOOGLE_SERVICE_ACCOUNT_PROJECT_ID'),
            'private_key_id' => env('GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY_ID'),
            'private_key' => env('GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY'),
            'client_email' => env('GOOGLE_SERVICE_ACCOUNT_CLIENT_EMAIL'),
            'client_id' => env('GOOGLE_SERVICE_ACCOUNT_CLIENT_ID'),
            'auth_uri' => env('GOOGLE_SERVICE_ACCOUNT_AUTH_URI'),
            'token_uri' => env('GOOGLE_SERVICE_ACCOUNT_TOKEN_URI'),
        ],
    ],

];
