<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\VideoGallery;
use App\Models\HeroSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredNews = News::published()
            ->featured()
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $latestNews = News::published()
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')
            ->take(8)
            ->get();

        $mostReadNews = News::published()
            ->with(['category', 'user', 'tags'])
            ->orderBy('views_count', 'desc')
            ->orderBy('published_at', 'desc') // Secondary sort for items with same views
            ->take(3)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('publishedNews')
            ->orderBy('sort_order')
            ->get();

        $featuredVideos = VideoGallery::active()
            ->ordered()
            ->take(4)
            ->get();

        // Hero video ayarları
        $heroSettings = HeroSettings::getSettings();

        return view('frontend.home', compact('featuredNews', 'latestNews', 'categories', 'featuredVideos', 'mostReadNews', 'heroSettings'));
    }
}
