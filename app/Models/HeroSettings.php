<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HeroSettings extends Model
{
    protected $fillable = [
        'enabled',
        'video_file',
        'title',
        'subtitle',
        'button_text',
        'button_url'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public static function getSettings()
    {
        return Cache::remember('hero_settings', 3600, function () {
            $settings = static::first();
            
            if (!$settings) {
                $settings = static::create([]);
            }

            return [
                'enabled' => $settings->enabled,
                'video_file' => $settings->video_file ? asset('storage/' . $settings->video_file) : null,
                'title' => $settings->title,
                'subtitle' => $settings->subtitle,
                'button_text' => $settings->button_text,
                'button_url' => $settings->button_url,
            ];
        });
    }

    protected static function boot()
    {
        parent::boot();

        // Video dosyası değiştiğinde eski dosyayı sil
        static::updating(function ($model) {
            $oldVideoFile = $model->getOriginal('video_file');
            $newVideoFile = $model->video_file;
            
            if ($oldVideoFile && $oldVideoFile !== $newVideoFile && Storage::disk('public')->exists($oldVideoFile)) {
                Storage::disk('public')->delete($oldVideoFile);
            }
        });

        static::saved(function ($model) {
            Cache::forget('hero_settings');
        });

        static::deleted(function ($model) {
            Cache::forget('hero_settings');
            
            if ($model->video_file && Storage::disk('public')->exists($model->video_file)) {
                Storage::disk('public')->delete($model->video_file);
            }
        });
    }
}
