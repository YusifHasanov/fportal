<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Services\SeoService;

class SeoAuditCommand extends Command
{
    protected $signature = 'seo:audit {--fix : Automatically fix common SEO issues}';
    protected $description = 'Perform SEO audit and optionally fix issues';

    public function handle()
    {
        $this->info('🔍 Starting SEO Audit...');
        
        $issues = [];
        
        // Check news without meta descriptions
        $newsWithoutMeta = News::whereNull('meta_description')
            ->orWhere('meta_description', '')
            ->count();
            
        if ($newsWithoutMeta > 0) {
            $issues[] = "❌ {$newsWithoutMeta} news articles missing meta descriptions";
            
            if ($this->option('fix')) {
                $this->fixMissingMetaDescriptions();
            }
        }
        
        // Check news without proper titles
        $newsWithShortTitles = News::whereRaw('LENGTH(title) < 30')->count();
        if ($newsWithShortTitles > 0) {
            $issues[] = "⚠️  {$newsWithShortTitles} news articles have titles shorter than 30 characters";
        }
        
        // Check news without images
        $newsWithoutImages = News::whereNull('featured_image')
            ->orWhere('featured_image', '')
            ->count();
            
        if ($newsWithoutImages > 0) {
            $issues[] = "❌ {$newsWithoutImages} news articles missing featured images";
        }
        
        // Check sitemap freshness
        $sitemapPath = public_path('sitemap.xml');
        if (!file_exists($sitemapPath)) {
            $issues[] = "❌ Sitemap not found - run php artisan sitemap:generate";
        } elseif (filemtime($sitemapPath) < strtotime('-1 day')) {
            $issues[] = "⚠️  Sitemap is older than 1 day - consider regenerating";
        }
        
        if (empty($issues)) {
            $this->info('✅ No SEO issues found!');
        } else {
            $this->warn('SEO Issues Found:');
            foreach ($issues as $issue) {
                $this->line($issue);
            }
        }
        
        $this->info('🎯 SEO Audit completed!');
    }
    
    private function fixMissingMetaDescriptions()
    {
        $this->info('🔧 Fixing missing meta descriptions...');
        
        $newsWithoutMeta = News::whereNull('meta_description')
            ->orWhere('meta_description', '')
            ->get();
            
        foreach ($newsWithoutMeta as $news) {
            $metaDescription = app(SeoService::class)->generateMetaDescription($news->content);
            $news->update(['meta_description' => $metaDescription]);
        }
        
        $this->info("✅ Fixed {$newsWithoutMeta->count()} meta descriptions");
    }
}
