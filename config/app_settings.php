<?php

return [
    // jwt
    'access_token_ttl' => env('JWT_ACCESS_TOKEN_TTL', 1800),
    'refresh_token_ttl' => env('JWT_REFRESH_TOKEN_TTL', 604800),
    // frontend
    'frontend_url_main' => env('FRONTEND_URL_MAIN'),
    // email
    'email_address' => env('MAIL_USERNAME'),
    'email_sender' => env('MAIL_FROM_NAME'),
];
