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
   
    // 'supportsCredentials' => false,
    // 'allowedOrigins' => ['*'],
    // 'allowedOriginsPatterns' => [],
    // 'allowedHeaders' => ['*'],
    // 'allowedMethods' => ['*'],
    // 'exposedHeaders' => [],
    // 'maxAge' => 0,

    // Laraval upgrade from 6 to 7...
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
