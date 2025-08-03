<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()
            ->with(['category', 'user', 'tags']);

        // Kategori filtresi
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Tag filtresi (çoklu seçim)
        if ($request->has('tags') && !empty($request->tags)) {
            $tags = is_array($request->tags) ? $request->tags : [$request->tags];
            $tags = array_filter($tags); // Boş değerleri temizle
            
            if (!empty($tags)) {
                $query->whereHas('tags', function ($q) use ($tags) {
                    $q->whereIn('slug', $tags);
                });
            }
        }
        
        // Tek tag filtresi (geriye dönük uyumluluk için)
        if ($request->has('tag') && $request->tag !== 'all') {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Arama filtresi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sıralama
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'commented':
                // Yorum sayısına göre sıralama (şimdilik views_count kullanıyoruz)
                $query->orderBy('views_count', 'desc');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $news = $query->paginate(12);

        // Filtreleme için gerekli veriler
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $tags = Tag::whereHas('news', function ($q) {
            $q->where('status', 'published');
        })->orderBy('name')->get();

        // Seçili kategori bilgisi
        $selectedCategory = null;
        if ($request->has('category') && $request->category !== 'all') {
            $selectedCategory = Category::where('slug', $request->category)->first();
        }

        // Seçili tag bilgisi
        $selectedTag = null;
        $selectedTags = [];
        
        if ($request->has('tag') && $request->tag !== 'all') {
            $selectedTag = Tag::where('slug', $request->tag)->first();
        }
        
        // Çoklu seçili tag'lar
        if ($request->has('tags') && !empty($request->tags)) {
            $tagSlugs = is_array($request->tags) ? $request->tags : [$request->tags];
            $tagSlugs = array_filter($tagSlugs);
            
            if (!empty($tagSlugs)) {
                $selectedTags = Tag::whereIn('slug', $tagSlugs)->get();
            }
        }

        return view('frontend.news.index', compact(
            'news', 
            'categories', 
            'tags', 
            'selectedCategory', 
            'selectedTag',
            'selectedTags'
        ));
    }

    public function show(News $news)
    {
        if ($news->status !== 'published') {
            abort(404);
        }

        $news->load(['category', 'user', 'tags']);
        $news->incrementViews();

        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.news.show', compact('news', 'relatedNews'));
    }
}
