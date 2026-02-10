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
    | Auto Import
    |--------------------------------------------------------------------------
    |
    | Whether to automatically import universities data when the package
    | is installed. Set to false if you want to import manually.
    |
    */
    'auto_import' => env('UNIVERSITIES_AUTO_IMPORT', true),

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
