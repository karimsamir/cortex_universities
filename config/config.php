<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,
    
    'tables' => [
        'universities' => 'universities',
    ],

    // Universities Models
    'models' => [
        'university' => \Cortex\Universities\Models\University::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | How long to cache university queries in seconds. Set to null to disable caching.
    |
    */
    'cache_duration' => env('UNIVERSITIES_CACHE_DURATION', 3600),


];
