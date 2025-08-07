<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\VideoGallery;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Cache::remember('sitemap', 3600, function () {
            return $this->generateSitemap();
        });

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function generateSitemap(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Ana sayfa
        $xml .= $this->addUrl(route('home'), now(), 'daily', '1.0');

        // Haber sayfaları
        $xml .= $this->addUrl(route('news.index'), now(), 'daily', '0.9');

        // Haberler
        News::published()
            ->select(['slug', 'updated_at'])
            ->chunk(100, function ($news) use (&$xml) {
                foreach ($news as $item) {
                    $xml .= $this->addUrl(
                        route('news.show', $item->slug),
                        $item->updated_at,
                        'weekly',
                        '0.8'
                    );
                }
            });

        // Kategoriler
        Category::select(['slug', 'updated_at'])
            ->chunk(100, function ($categories) use (&$xml) {
                foreach ($categories as $category) {
                    $xml .= $this->addUrl(
                        route('categories.show', $category->slug),
                        $category->updated_at,
                        'weekly',
                        '0.7'
                    );
                }
            });

        // Video galerisi
        $xml .= $this->addUrl(route('frontend.video-gallery.index'), now(), 'daily', '0.8');

        VideoGallery::select(['id', 'updated_at'])
            ->chunk(100, function ($videos) use (&$xml) {
                foreach ($videos as $video) {
                    $xml .= $this->addUrl(
                        route('frontend.video-gallery.show', $video->id),
                        $video->updated_at,
                        'weekly',
                        '0.6'
                    );
                }
            });

        $xml .= '</urlset>';

        return $xml;
    }

    private function addUrl(string $url, $lastmod = null, string $changefreq = 'weekly', string $priority = '0.5'): string
    {
        $xml = '<url>';
        $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
        
        if ($lastmod) {
            $xml .= '<lastmod>' . $lastmod->format('Y-m-d\TH:i:s+00:00') . '</lastmod>';
        }
        
        $xml .= '<changefreq>' . $changefreq . '</changefreq>';
        $xml .= '<priority>' . $priority . '</priority>';
        $xml .= '</url>';

        return $xml;
    }

    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin\n";
        $robots .= "Disallow: /storage/\n";
        $robots .= "Disallow: /vendor/\n";
        $robots .= "\n";
        $robots .= "Sitemap: " . route('sitemap') . "\n";

        return response($robots, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}