<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Optimization Settings
    |--------------------------------------------------------------------------
    |
    | Configuration untuk optimasi performa aplikasi
    |
    */

    'cache' => [
        'dashboard_ttl' => env('CACHE_DASHBOARD_TTL', 300), // 5 menit
        'statistics_ttl' => env('CACHE_STATISTICS_TTL', 600), // 10 menit
        'user_data_ttl' => env('CACHE_USER_DATA_TTL', 1800), // 30 menit
    ],

    'database' => [
        'chunk_size' => env('DB_CHUNK_SIZE', 1000),
        'query_timeout' => env('DB_QUERY_TIMEOUT', 30),
    ],

    'file_upload' => [
        'max_size' => env('FILE_MAX_SIZE', 10240), // 10MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
        'compress_images' => env('COMPRESS_IMAGES', true),
        'image_quality' => env('IMAGE_QUALITY', 85),
    ],

    'pagination' => [
        'default_per_page' => env('PAGINATION_PER_PAGE', 15),
        'max_per_page' => env('PAGINATION_MAX_PER_PAGE', 100),
    ],
];
