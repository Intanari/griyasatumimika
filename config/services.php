<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'midtrans' => [
        'server_key'      => env('MIDTRANS_SERVER_KEY'),
        'client_key'      => env('MIDTRANS_CLIENT_KEY'),
        'is_production'   => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN),
        'expired_minutes' => (int) env('MIDTRANS_EXPIRED_MINUTES', 15),
    ],

    'donation' => [
        'poll_interval_ms'      => (int) env('DONATION_POLL_INTERVAL_MS', 400),
        'sync_interval_ms'      => (int) env('DONATION_SYNC_INTERVAL_MS', 12000),
    ],

];
