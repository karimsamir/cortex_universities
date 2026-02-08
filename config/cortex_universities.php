<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | The table name that will be used to store universities data.
    | You can change this if you want to use a different table name.
    |
    */
    'table_name' => 'universities',

    /*
    |--------------------------------------------------------------------------
    | Universities Data Path
    |--------------------------------------------------------------------------
    |
    | The path to the universities JSON files from rinvex/universities package.
    | The seeder will automatically look for universities data in this path.
    |
    */
    'data_path' => env('UNIVERSITIES_DATA_PATH', null),

    /*
    |--------------------------------------------------------------------------
    | Auto Import
    |--------------------------------------------------------------------------
    |
    | Whether to automatically import universities data when the package
    | is installed. Set to false if you want to import manually.
    |
    */
    'auto_import' => env('UNIVERSITIES_AUTO_IMPORT', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | How long to cache university queries in seconds. Set to null to disable caching.
    |
    */
    'cache_duration' => env('UNIVERSITIES_CACHE_DURATION', 3600),

    /*
    |--------------------------------------------------------------------------
    | Default Pagination
    |--------------------------------------------------------------------------
    |
    | Default number of universities to show per page when paginating.
    |
    */
    'per_page' => env('UNIVERSITIES_PER_PAGE', 25),

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for university search functionality.
    |
    */
    'search' => [
        'enabled' => true,
        'fields' => ['name', 'country', 'state', 'city'],
        'fuzzy' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for API endpoints if you want to expose universities via API.
    |
    */
    'api' => [
        'enabled' => false,
        'middleware' => ['api'],
        'prefix' => 'api/universities',
    ],
];
