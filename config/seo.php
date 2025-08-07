<?php

return [
    'default' => [
        'title' => 'FPortal - Azərbaycanın Futbol Portalı',
        'description' => 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.',
        'keywords' => 'futbol, xəbər, Azərbaycan, idman, transfer, canlı nəticə, statistika, oyun',
        'image' => '/assets/og-image.jpg',
        'locale' => 'az_AZ',
        'site_name' => 'FPortal'
    ],

    'social' => [
        'twitter' => '@fportalaz',
        'facebook' => 'fportalaz',
        'instagram' => 'fportalaz',
        'youtube' => '@fportalaz',
        'telegram' => 'fportal'
    ],

    'organization' => [
        'name' => 'FPortal',
        'url' => env('APP_URL'),
        'logo' => '/assets/logo.png',
        'description' => 'Azərbaycanın ən dəqiq futbol portalı',
        'contact_point' => [
            'telephone' => '+994-XX-XXX-XX-XX',
            'contact_type' => 'customer service',
            'area_served' => 'AZ',
            'available_language' => 'Azerbaijani'
        ]
    ],

    'cache' => [
        'sitemap_ttl' => 3600, // 1 saat
        'meta_ttl' => 1800,    // 30 dəqiqə
    ],

    'image_optimization' => [
        'quality' => 85,
        'formats' => ['webp', 'jpeg'],
        'sizes' => [
            'thumb' => ['width' => 300, 'height' => 200],
            'medium' => ['width' => 600, 'height' => 400],
            'large' => ['width' => 1200, 'height' => 800],
            'og' => ['width' => 1200, 'height' => 630]
        ]
    ]
];