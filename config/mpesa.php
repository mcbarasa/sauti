<?php

return [
    'env'          => env('MPESA_ENV', 'sandbox'),
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'shortcode'    => env('MPESA_SHORTCODE', '174379'),
    'passkey'      => env('MPESA_PASSKEY'),
    'callback_url' => env('MPESA_CALLBACK_URL'),
    'base_url'     => env('MPESA_ENV') === 'production'
        ? 'https://api.safaricom.co.ke'
        : 'https://sandbox.safaricom.co.ke',
        'poll_interval' => env('MPESA_POLL_INTERVAL', 3000),
 
    /*
    |─────────────────────────────────────────────────────────
    | Max wait time before showing timeout (milliseconds)
    | Safaricom STK expires after ~60s; we give 75s
    |─────────────────────────────────────────────────────────
    */
    'max_wait' => env('MPESA_MAX_WAIT', 75000),
];