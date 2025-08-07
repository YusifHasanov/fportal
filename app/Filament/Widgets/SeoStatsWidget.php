<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\News;
use App\Services\SearchConsoleService;
use Illuminate\Support\Facades\Cache;

class SeoStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalNews = News::published()->count();
        
        // SEO faktörları
        $newsWithoutMeta = News::published()
            ->whereNull('meta_description')
            ->orWhere('meta_description', '')
            ->count();
            
        $newsWithoutImages = News::published()
            ->whereNull('featured_image')
            ->orWhere('featured_image', '')
            ->count();
            
        $newsWithShortTitles = News::published()
            ->whereRaw('LENGTH(title) < 30')
            ->count();
            
        $newsWithLongTitles = News::published()
            ->whereRaw('LENGTH(title) > 60')
            ->count();
            
        $newsWithoutSlugs = News::published()
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->count();

        // Ətraflı SEO skoru hesablaması
        $seoScore = $this->calculateDetailedSeoScore([
            'total' => $totalNews,
            'without_meta' => $newsWithoutMeta,
            'without_images' => $newsWithoutImages,
            'short_titles' => $newsWithShortTitles,
            'long_titles' => $newsWithLongTitles,
            'without_slugs' => $newsWithoutSlugs,
        ]);

        // Google Search Console verileri (cache'li)
        $searchData = Cache::remember('search_console_data', 3600, function () {
            return app(SearchConsoleService::class)->getSearchAnalytics();
        });

        $totalClicks = $searchData['rows'] ?? 0;
        $avgPosition = isset($searchData['rows']) && count($searchData['rows']) > 0 
            ? round(collect($searchData['rows'])->avg('position'), 1) 
            : 0;

        return [
            Stat::make('SEO Skoru', $seoScore . '%')
                ->description($seoScore >= 80 ? 'Əla!' : 'Təkmilləşdirmə lazımdır')
                ->descriptionIcon($seoScore >= 80 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($seoScore >= 80 ? 'success' : 'warning'),
                
            Stat::make('Meta Təsviri Yoxdur', $newsWithoutMeta)
                ->description('Xəbərlərdə meta təsviri yoxdur')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($newsWithoutMeta > 0 ? 'danger' : 'success'),
                
            Stat::make('Şəkil Yoxdur', $newsWithoutImages)
                ->description('Xəbərlərdə featured image yoxdur')
                ->descriptionIcon('heroicon-m-photo')
                ->color($newsWithoutImages > 0 ? 'warning' : 'success'),
                
            Stat::make('Google Kliklər', $totalClicks)
                ->description('Son 30 gündə')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('info'),
                
            Stat::make('Orta Mövqe', $avgPosition)
                ->description('Google axtarışında')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($avgPosition <= 10 ? 'success' : 'warning'),
        ];
    }
    
    private function calculateDetailedSeoScore($data)
    {
        if ($data['total'] == 0) return 0;
        
        $score = 100; // Maksimum skor
        
        // Meta description yoxdursa -30 bal
        $metaScore = (($data['total'] - $data['without_meta']) / $data['total']) * 30;
        
        // Featured image yoxdursa -25 bal  
        $imageScore = (($data['total'] - $data['without_images']) / $data['total']) * 25;
        
        // Title uzunluğu problemləri -20 bal
        $titleIssues = $data['short_titles'] + $data['long_titles'];
        $titleScore = (($data['total'] - $titleIssues) / $data['total']) * 20;
        
        // Slug problemləri -15 bal
        $slugScore = (($data['total'] - $data['without_slugs']) / $data['total']) * 15;
        
        // Sitemap və indexing -10 bal
        $sitemapExists = file_exists(public_path('sitemap.xml')) ? 10 : 0;
        
        $finalScore = $metaScore + $imageScore + $titleScore + $slugScore + $sitemapExists;
        
        return round($finalScore);
    }
}
