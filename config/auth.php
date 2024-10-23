<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',           // Default guard for standard users
        'passwords' => 'users',     // Default password reset configuration
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Laravel supports session storage and token-based authentication out
    | of the box. You may define additional guards as needed.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [                     // Default web guard
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [                     // Default API guard (optional)
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        // Distributor Guard
        'distributor' => [
            'driver' => 'session',
            'provider' => 'distributors',
        ],

        // Supervisor Guard
        'supervisor' => [
            'driver' => 'session',
            'provider' => 'supervisors',
        ],

        // Factory Guard
        'factory' => [
            'driver' => 'session',
            'provider' => 'factories',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are retrieved from your database or other storage mechanisms.
    | If you have multiple user tables or models, you may define multiple
    | sources which represent each model/table.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [                   // Default user provider
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Distributor Provider
        'distributors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Distributor::class,
        ],

        // Supervisor Provider
        'supervisors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Supervisor::class,
        ],

        // Factory Provider
        'factories' => [
            'driver' => 'eloquent',
            'model' => App\Models\Factory::class,
        ],

        /*
        // Example of Database Provider (if needed)
        'users_db' => [
            'driver' => 'database',
            'table' => 'users',
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | Although you're not using password resets, Laravel requires at least one
    | password broker. Here, we're defining it for the default users. You can
    | add more brokers if you decide to implement password resets for other
    | user types in the future.
    |
    */

    'passwords' => [
        'users' => [                   // Default password reset configuration
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,           // Minutes
            'throttle' => 60,         // Minutes
        ],

        /*
        // Uncomment and configure if password resets are needed for other user types
        'distributors' => [
            'provider' => 'distributors',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'supervisors' => [
            'provider' => 'supervisors',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'factories' => [
            'provider' => 'factories',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800, // Seconds (3 hours)

];
