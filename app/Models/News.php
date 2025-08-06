<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
}
