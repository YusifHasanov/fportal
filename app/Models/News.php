<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Services\SearchConsoleService;

class News extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_featured',
        'views_count',
        'published_at',
        'category_id',
        'user_id',
        'meta_data',
    ];

    // XSS qorunması üçün mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strip_tags($value);
    }

    public function setExcerptAttribute($value)
    {
        $this->attributes['excerpt'] = strip_tags($value);
    }

    // Content'den resim dosya adlarını temizle
    public function getContentAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        // Trix attachment caption'larını kaldır
        $cleanContent = preg_replace(
            '/<figcaption[^>]*class="[^"]*trix-attachment__caption[^"]*"[^>]*>.*?<\/figcaption>/s',
            '',
            $value
        );

        // Figcaption etiketlerini tamamen kaldır
        $cleanContent = preg_replace('/<figcaption[^>]*>.*?<\/figcaption>/s', '', $cleanContent);

        // Data-trix-attachment içindeki text node'ları temizle
        $cleanContent = preg_replace(
            '/(<figure[^>]*data-trix-attachment[^>]*>.*?<img[^>]*>)([^<]*?)(<\/figure>)/s',
            '$1$3',
            $cleanContent
        );

        // Dosya adı pattern'lerini kaldır (örn: "filename.jpg 123 KB")
        $cleanContent = preg_replace('/\b\w+\.(jpg|jpeg|png|gif|webp)\s*\d+(\.\d+)?\s*(KB|MB|bytes?)\b/i', '', $cleanContent);

        return $cleanContent;
    }

    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'published_at' => 'datetime',
        'meta_data' => 'array',
    ];

    protected static function booted()
    {
        // Yeni haber yayınlandığında Google'a bildir
        static::updated(function ($news) {
            if ($news->wasChanged('status') && $news->status === 'published') {
                dispatch(function () use ($news) {
                    app(SearchConsoleService::class)->indexUrl($news->canonical_url);
                })->afterResponse();
            }
        });

        static::created(function ($news) {
            if ($news->status === 'published') {
                dispatch(function () use ($news) {
                    app(SearchConsoleService::class)->indexUrl($news->canonical_url);
                })->afterResponse();
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->sharpen(10);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // SEO optimizasyonu için accessor'lar
    public function getSeoTitleAttribute(): string
    {
        return $this->title . ' - FPortal';
    }

    public function getSeoDescriptionAttribute(): string
    {
        if ($this->excerpt) {
            return Str::limit(strip_tags($this->excerpt), 160);
        }
        
        return Str::limit(strip_tags($this->content), 160);
    }

    public function getSeoKeywordsAttribute(): string
    {
        $keywords = ['futbol', 'xəbər', 'Azərbaycan', 'idman'];
        
        if ($this->category) {
            $keywords[] = $this->category->name;
        }
        
        if ($this->tags->count() > 0) {
            $keywords = array_merge($keywords, $this->tags->pluck('name')->toArray());
        }
        
        return implode(', ', array_unique($keywords));
    }

    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // 200 kelime/dakika
    }

    public function getCanonicalUrlAttribute(): string
    {
        return route('news.show', $this->slug);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }
        
        return asset('assets/og-image.jpg');
    }
}
