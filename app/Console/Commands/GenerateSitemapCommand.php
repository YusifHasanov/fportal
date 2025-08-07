<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap';

    public function handle()
    {
        $this->info('🗺️  Sitemap yaradılır...');
        
        try {
            $controller = new SitemapController();
            $sitemap = $controller->index()->getContent();
            
            // Sitemap faylını public qovluğuna yaz
            $sitemapPath = public_path('sitemap.xml');
            File::put($sitemapPath, $sitemap);
            
            $this->info('✅ Sitemap uğurla yaradıldı: ' . $sitemapPath);
            
            // Robots.txt də yarat
            $robots = $controller->robots()->getContent();
            $robotsPath = public_path('robots.txt');
            File::put($robotsPath, $robots);
            
            $this->info('✅ Robots.txt uğurla yaradıldı: ' . $robotsPath);
            
            // Statistika göstər
            $newsCount = substr_count($sitemap, '<url>');
            $this->line("📊 Ümumi URL sayı: {$newsCount}");
            
        } catch (\Exception $e) {
            $this->error('❌ Xəta: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}