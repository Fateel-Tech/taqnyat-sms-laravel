<?php

// config for FateelTech/TaqnyatSms
return [
    /**
     * This is the URL where the Taqnyat API is located.
     *
     * In most cases, you won't need to change this value.
     */
    'endpoint' => env('TAQNYAT_API_URL', 'https://api.taqnyat.sa'),

    /**
     * This is the sender name that will be used when sending SMS messages.
     */
    'sender_name' => env('TAQNYAT_API_SENDER_NAME', env('APP_NAME')),

    /**
     * This is the token that will be used to authenticate with the Taqnyat API
     */
    'bearer_token' => env('TAQNYAT_API_TOKEN'),

    /**
     * This is the timeout for the HTTP client
     */
    'timeout' => env('TAQNYAT_API_TIMEOUT', 10),
];
