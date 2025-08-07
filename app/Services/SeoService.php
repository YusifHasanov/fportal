<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SeoService
{
    public function generateMetaTags(array $data): array
    {
        $defaults = [
            'title' => config('app.name', 'FPortal'),
            'description' => 'Azərbaycanın ən dəqiq futbol portalı. Yenilənən xəbərlər, canlı nəticələr, statistik göstəricilər və daha çoxdu.',
            'keywords' => 'futbol, xəbər, Azərbaycan, idman, transfer, canlı nəticə, statistika',
            'image' => asset('assets/og-image.jpg'),
            'url' => url()->current(),
            'type' => 'website',
            'locale' => 'az_AZ',
            'site_name' => 'FPortal'
        ];

        $meta = array_merge($defaults, $data);

        // Title optimization
        if (isset($data['title']) && $data['title'] !== $defaults['title']) {
            $meta['title'] = $data['title'] . ' - ' . $defaults['title'];
        }

        // Description optimization
        if (isset($data['description'])) {
            $meta['description'] = Str::limit(strip_tags($data['description']), 160);
        }

        return $meta;
    }

    public function generateStructuredData(string $type, array $data): array
    {
        $baseData = [
            '@context' => 'https://schema.org',
            '@type' => $type,
        ];

        switch ($type) {
            case 'NewsArticle':
                return array_merge($baseData, [
                    'headline' => $data['title'],
                    'description' => $data['description'] ?? '',
                    'image' => $data['image'] ?? asset('assets/og-image.jpg'),
                    'datePublished' => $data['published_at']->toISOString(),
                    'dateModified' => $data['updated_at']->toISOString(),
                    'author' => [
                        '@type' => 'Person',
                        'name' => $data['author'] ?? 'FPortal'
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'FPortal',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => asset('assets/logo.png')
                        ]
                    ],
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => $data['url']
                    ]
                ]);

            case 'Organization':
                return array_merge($baseData, [
                    'name' => 'FPortal',
                    'url' => url('/'),
                    'logo' => asset('assets/logo.png'),
                    'description' => 'Azərbaycanın ən dəqiq futbol portalı',
                    'sameAs' => [
                        'https://www.instagram.com/fportalaz',
                        'https://x.com/fportalaz',
                        'https://youtube.com/@fportalaz',
                        'https://t.me/fportal'
                    ]
                ]);

            case 'WebSite':
                return array_merge($baseData, [
                    'name' => 'FPortal',
                    'url' => url('/'),
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => url('/search?q={search_term_string}'),
                        'query-input' => 'required name=search_term_string'
                    ]
                ]);

            default:
                return $baseData;
        }
    }

    public function generateBreadcrumbs(array $items): array
    {
        $breadcrumbs = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($items as $index => $item) {
            $breadcrumbs['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null
            ];
        }

        return $breadcrumbs;
    }

    public function optimizeImageAlt(string $title, string $context = ''): string
    {
        $alt = $title;
        if ($context) {
            $alt .= ' - ' . $context;
        }
        return Str::limit($alt, 125);
    }

    public function generateCanonicalUrl(string $url = null): string
    {
        return $url ?: url()->current();
    }

    public function generateHreflangTags(): array
    {
        // Gelecekte çok dilli destek için
        return [
            'az' => url()->current(),
            'x-default' => url()->current()
        ];
    }
}