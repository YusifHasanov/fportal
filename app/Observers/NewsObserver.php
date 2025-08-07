<?php

namespace App\Observers;

use App\Models\News;
use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;

class NewsObserver
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function created(News $news)
    {
        $this->clearRelatedCaches();
    }

    public function updated(News $news)
    {
        $this->clearRelatedCaches();
    }

    public function deleted(News $news)
    {
        $this->clearRelatedCaches();
    }

    private function clearRelatedCaches()
    {
        // News ile ilgili cache'leri temizle
        $this->cacheService->clearNewsCache();
        
        // Sitemap cache'ini temizle
        Cache::forget('sitemap');
    }
}