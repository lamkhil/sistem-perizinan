<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    |
    | Configuration untuk monitoring performa aplikasi
    |
    */

    'monitoring' => [
        'enabled' => env('PERFORMANCE_MONITORING', true),
        'slow_query_threshold' => env('SLOW_QUERY_THRESHOLD', 1000), // milliseconds
        'memory_threshold' => env('MEMORY_THRESHOLD', 128), // MB
        'log_slow_requests' => env('LOG_SLOW_REQUESTS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Optimization
    |--------------------------------------------------------------------------
    |
    | Configuration untuk optimasi gambar
    |
    */

    'images' => [
        'compress' => env('COMPRESS_IMAGES', true),
        'quality' => env('IMAGE_QUALITY', 85),
        'max_width' => env('IMAGE_MAX_WIDTH', 1920),
        'max_height' => env('IMAGE_MAX_HEIGHT', 1080),
        'lazy_loading' => env('LAZY_LOADING', true),
        'webp_conversion' => env('WEBP_CONVERSION', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Optimization
    |--------------------------------------------------------------------------
    |
    | Configuration untuk optimasi database
    |
    */

    'database' => [
        'query_cache' => env('DB_QUERY_CACHE', true),
        'connection_pooling' => env('DB_CONNECTION_POOLING', false),
        'slow_query_log' => env('DB_SLOW_QUERY_LOG', true),
        'chunk_size' => env('DB_CHUNK_SIZE', 1000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching Strategy
    |--------------------------------------------------------------------------
    |
    | Configuration untuk strategi caching
    |
    */

    'cache' => [
        'driver' => env('CACHE_DRIVER', 'database'),
        'ttl' => [
            'dashboard' => env('CACHE_DASHBOARD_TTL', 300),
            'statistics' => env('CACHE_STATISTICS_TTL', 600),
            'user_data' => env('CACHE_USER_DATA_TTL', 1800),
            'file_metadata' => env('CACHE_FILE_METADATA_TTL', 3600),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend Optimization
    |--------------------------------------------------------------------------
    |
    | Configuration untuk optimasi frontend
    |
    */

    'frontend' => [
        'minify_css' => env('MINIFY_CSS', true),
        'minify_js' => env('MINIFY_JS', true),
        'combine_assets' => env('COMBINE_ASSETS', true),
        'cdn_enabled' => env('CDN_ENABLED', false),
        'cdn_url' => env('CDN_URL', ''),
    ],
];
