<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_file',
        'video_type',
        'thumbnail',
        'duration',
        'views',
        'is_active',
        'sort_order'
    ];

    // XSS qorunması üçün mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strip_tags($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strip_tags($value);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
        'sort_order' => 'integer'
    ];

    public function getVideoSourceAttribute()
    {
        if ($this->video_type === 'file' && $this->video_file) {
            return asset('storage/' . $this->video_file);
        }
        return $this->video_url;
    }

    public function isUploadedVideo()
    {
        return $this->video_type === 'file' && !empty($this->video_file);
    }

    public function isExternalVideo()
    {
        return $this->video_type === 'url' && !empty($this->video_url);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Video türüne göre gereksiz alanları temizle
            if ($model->video_type === 'file') {
                $model->video_url = null;
            } elseif ($model->video_type === 'url') {
                // Eğer video_file varsa ve eski dosyaysa sil
                if ($model->video_file && $model->getOriginal('video_file') !== $model->video_file) {
                    $oldFile = $model->getOriginal('video_file');
                    if ($oldFile && \Storage::disk('public')->exists($oldFile)) {
                        \Storage::disk('public')->delete($oldFile);
                    }
                }
                $model->video_file = null;
            }
        });

        static::deleting(function ($model) {
            // Video dosyası silinirken storage'dan da sil
            if ($model->video_file && \Storage::disk('public')->exists($model->video_file)) {
                \Storage::disk('public')->delete($model->video_file);
            }
            // Thumbnail silinirken storage'dan da sil
            if ($model->thumbnail && \Storage::disk('public')->exists($model->thumbnail)) {
                \Storage::disk('public')->delete($model->thumbnail);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getYoutubeIdAttribute()
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
