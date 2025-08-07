<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'seo:generate-sitemap';
    protected $description = 'Generate XML sitemap for SEO';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $controller = new SitemapController();
        $sitemap = $controller->index();
        
        // Public dizinine sitemap.xml dosyasını kaydet
        $path = public_path('sitemap.xml');
        File::put($path, $sitemap->getContent());

        $this->info('Sitemap generated successfully at: ' . $path);
        
        return 0;
    }
}