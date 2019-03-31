<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => true,
    'allowedOrigins' => explode(',', env('CORS_ALLOW_ORIGIN')),
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => [
        'X-PINGOTHER',
        'Origin',
        'X-Requested-With',
        'Content-Type',
        'Accept',
        'x-csrf-token',
        'authorization'
    ],
    'allowedMethods' => ['GET', 'POST', 'OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
