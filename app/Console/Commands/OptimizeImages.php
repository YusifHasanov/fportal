<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageOptimizationService;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class OptimizeImages extends Command
{
    protected $signature = 'seo:optimize-images {--force : Force re-optimization of existing images}';
    protected $description = 'Optimize images for better SEO and performance';

    protected $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        parent::__construct();
        $this->imageService = $imageService;
    }

    public function handle()
    {
        $this->info('Starting image optimization...');

        $news = News::whereNotNull('featured_image')->get();
        $bar = $this->output->createProgressBar($news->count());

        foreach ($news as $newsItem) {
            if ($newsItem->featured_image && Storage::exists($newsItem->featured_image)) {
                try {
                    $optimizedImages = $this->imageService->optimizeAndResize($newsItem->featured_image);
                    
                    // Meta data'ya optimized images bilgisini kaydet
                    $metaData = $newsItem->meta_data ?? [];
                    $metaData['optimized_images'] = $optimizedImages;
                    $newsItem->update(['meta_data' => $metaData]);
                    
                } catch (\Exception $e) {
                    $this->error('Error optimizing image for news ID ' . $newsItem->id . ': ' . $e->getMessage());
                }
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Image optimization completed!');
        
        return 0;
    }
}