<?php

return [

    /*
    |--------------------------------------------------------------------------
    | VoterListRegistry server path 
    |--------------------------------------------------------------------------
    |
    | Basically, the domain/server address of your VoterListRegistry installation.
    | 
    */

    'voterlistregistry_host' => env('VOTERLISTREGISTRY_HOST', 'http://example.com'),

    /*
    |--------------------------------------------------------------------------
    | VoterListRegistry service user 
    |--------------------------------------------------------------------------
    |
    | Basically, the service user for your VoterListRegistry conections.
    | 
    */

    'voterlistregistry_user' => env('VOTERLISTREGISTRY_USER', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | VoterListRegistry service password 
    |--------------------------------------------------------------------------
    |
    | Basically, the service password for your VoterListRegistry conections.
    | 
    */

    'voterlistregistry_password' => env('VOTERLISTREGISTRY_PASSWORD', 'password'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Request Header stuff.. 
    |--------------------------------------------------------------------------
    |
    | Many times you will find firewalls that block request where either or both 
    | user agent and referer are not set in the request header. We are polite and 
    | set our headers properly to say who we are. You should not use this in any way
    | at the other end to identify the source of the call as they are too easy to spoof.
    | 
    | Default values are usually fine... unless you need to spoof the referer.
    */

    'http_user_agent' => env('VOTERLISTREGISTRY_USER_AGENT', 'laravel-voterlistregistry-api'),
    'http_referer' => env('VOTERLISTREGISTRY_HTTP_REFERER', env('APP_URL'))
];
