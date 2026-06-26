<?php

return [
    'name' => env('WEBADMIN_NAME', 'Sparkxe Admin'),
    'title' => env('WEBADMIN_TITLE', 'Sparkxe Admin Dashboard'),
    'description' => 'Sparkxe admin dashboard for managing website content, users, and services.',
    'asset_path' => 'webadmin/assets',

    /*
    |--------------------------------------------------------------------------
    | Licensed third-party assets (CDN)
    |--------------------------------------------------------------------------
    | Flaticon UIcons (free with attribution), Font Awesome Free (SIL OFL),
    | Bootstrap Icons (MIT), Google Fonts (Instrument Sans - OFL).
    */
    'cdn' => [
        'flaticon_uicons' => 'https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.css',
        'fontawesome' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        'bootstrap_icons' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        'google_fonts' => 'https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap',
    ],

    'styles' => [
        'plugins' => [
            'plugins/simplebar/simplebar',
            'plugins/node-waves/waves',
            'plugins/bootstrap-select/css/bootstrap-select.min',
            'plugins/flatpickr/flatpickr.min',
            'plugins/datatables/datatables.min',
        ],
        'app' => [
            'css/utilities',
            'css/styles',
            'css/sparkxe-admin',
        ],
    ],

    'scripts' => [
        'core' => [
            'plugins/global/global.min',
            'plugins/sortable/Sortable.min',
            'plugins/chartjs/chart',
            'plugins/flatpickr/flatpickr.min',
            'plugins/apexcharts/apexcharts.min',
            'plugins/datatables/datatables.min',
            'js/appSettings',
            'js/main',
        ],
        'module' => 'js/main',
    ],

    'images' => [
        'logo' => 'webadmin/assets/images/logo.svg',
        'favicon' => 'webadmin/assets/images/favicon.png',
        'apple_touch_icon' => 'webadmin/assets/images/apple-touch-icon.png',
    ],
];
