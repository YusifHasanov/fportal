<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\News;
use App\Models\Category;

class CacheService
{
    const CACHE_TTL = 3600; // 1 saat

    public function getPopularNews(int $limit = 5)
    {
        return Cache::remember('popular_news_' . $limit, self::CACHE_TTL, function () use ($limit) {
            return News::published()
                ->with(['category'])
                ->orderBy('views_count', 'desc')
                ->take($limit)
                ->get();
        });
    }

    public function getFeaturedNews(int $limit = 3)
    {
        return Cache::remember('featured_news_' . $limit, self::CACHE_TTL, function () use ($limit) {
            return News::published()
                ->featured()
                ->with(['category'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getLatestNews(int $limit = 10)
    {
        return Cache::remember('latest_news_' . $limit, self::CACHE_TTL, function () use ($limit) {
            return News::published()
                ->with(['category'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getActiveCategories()
    {
        return Cache::remember('active_categories', self::CACHE_TTL * 2, function () {
            return Category::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    public function clearNewsCache()
    {
        $keys = [
            'popular_news_*',
            'featured_news_*',
            'latest_news_*',
            'sitemap'
        ];

        foreach ($keys as $pattern) {
            Cache::forget($pattern);
        }
    }
}