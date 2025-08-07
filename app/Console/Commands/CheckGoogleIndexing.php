<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use Illuminate\Support\Facades\Http;

class CheckGoogleIndexing extends Command
{
    protected $signature = 'google:check-indexing {--limit=5 : Number of news to check}';
    protected $description = 'Check if news articles are indexed by Google';

    public function handle()
    {
        $this->info('🔍 Google indexing durumunu yoxlayıram...');
        
        $limit = $this->option('limit');
        $news = News::published()
            ->latest()
            ->limit($limit)
            ->get();
            
        if ($news->isEmpty()) {
            $this->warn('Yayımlanmış xəbər tapılmadı!');
            return;
        }
        
        $this->info("Son {$limit} xəbəri yoxlayıram...\n");
        
        foreach ($news as $article) {
            $url = route('news.show', $article->slug);
            $isIndexed = $this->checkGoogleIndexing($url, $article->title);
            
            $status = $isIndexed ? '✅ İndekslənib' : '❌ İndekslənməyib';
            $this->line("{$status} - {$article->title}");
            $this->line("   URL: {$url}\n");
            
            // Rate limiting
            sleep(1);
        }
        
        $this->info('🎯 Yoxlama tamamlandı!');
        $this->line('');
        $this->warn('💡 Məsləhət: Əgər xəbərlər indekslənməyibsə:');
        $this->line('1. php artisan sitemap:generate');
        $this->line('2. Google Search Console-da sitemap göndərin');
        $this->line('3. 24-48 saat gözləyin');
    }
    
    private function checkGoogleIndexing($url, $title)
    {
        try {
            // Google search query
            $searchQuery = 'site:' . parse_url($url, PHP_URL_HOST) . ' "' . $title . '"';
            $googleUrl = 'https://www.google.com/search?q=' . urlencode($searchQuery);
            
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'
            ])->timeout(10)->get($googleUrl);
            
            if ($response->successful()) {
                $content = $response->body();
                
                // Check if the specific URL appears in results
                return strpos($content, $url) !== false || 
                       strpos($content, 'did not match any documents') === false;
            }
            
            return false;
        } catch (\Exception $e) {
            $this->error("Xəta: {$e->getMessage()}");
            return false;
        }
    }
}
