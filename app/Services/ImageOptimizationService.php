<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizationService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function optimizeAndResize(string $imagePath, array $sizes = []): array
    {
        $defaultSizes = [
            'thumb' => ['width' => 300, 'height' => 200],
            'medium' => ['width' => 600, 'height' => 400],
            'large' => ['width' => 1200, 'height' => 800],
            'og' => ['width' => 1200, 'height' => 630] // Open Graph için
        ];

        $sizes = array_merge($defaultSizes, $sizes);
        $optimizedImages = [];

        $originalImage = $this->manager->read(Storage::path($imagePath));
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        foreach ($sizes as $sizeName => $dimensions) {
            $resizedImage = $originalImage->cover(
                $dimensions['width'],
                $dimensions['height']
            );

            // WebP formatında kaydet (modern tarayıcılar için)
            $webpPath = $directory . '/' . $filename . '_' . $sizeName . '.webp';
            $webpFullPath = Storage::path($webpPath);
            
            // Dizin yoksa oluştur
            $webpDir = dirname($webpFullPath);
            if (!is_dir($webpDir)) {
                mkdir($webpDir, 0755, true);
            }

            $resizedImage->toWebp(85)->save($webpFullPath);

            // JPEG formatında da kaydet (fallback için)
            $jpegPath = $directory . '/' . $filename . '_' . $sizeName . '.jpg';
            $jpegFullPath = Storage::path($jpegPath);
            
            $resizedImage->toJpeg(85)->save($jpegFullPath);

            $optimizedImages[$sizeName] = [
                'webp' => $webpPath,
                'jpeg' => $jpegPath,
                'width' => $dimensions['width'],
                'height' => $dimensions['height']
            ];
        }

        return $optimizedImages;
    }

    public function generateResponsiveImageHtml(array $images, string $alt, string $class = ''): string
    {
        if (empty($images)) {
            return '';
        }

        $html = '<picture class="' . $class . '">';
        
        // WebP sources
        foreach ($images as $sizeName => $image) {
            if ($sizeName === 'og') continue; // OG image'ı responsive'de kullanma
            
            $html .= '<source media="(max-width: ' . $image['width'] . 'px)" ';
            $html .= 'srcset="' . Storage::url($image['webp']) . '" ';
            $html .= 'type="image/webp">';
        }

        // JPEG fallback
        $largestImage = $images['large'] ?? $images['medium'] ?? $images['thumb'];
        $html .= '<img src="' . Storage::url($largestImage['jpeg']) . '" ';
        $html .= 'alt="' . htmlspecialchars($alt) . '" ';
        $html .= 'loading="lazy" ';
        $html .= 'width="' . $largestImage['width'] . '" ';
        $html .= 'height="' . $largestImage['height'] . '">';
        
        $html .= '</picture>';

        return $html;
    }

    public function generateImageSrcSet(array $images): string
    {
        $srcSet = [];
        
        foreach ($images as $sizeName => $image) {
            if ($sizeName === 'og') continue;
            $srcSet[] = Storage::url($image['jpeg']) . ' ' . $image['width'] . 'w';
        }

        return implode(', ', $srcSet);
    }

    public function compressImage(string $imagePath, int $quality = 85): string
    {
        $image = $this->manager->read(Storage::path($imagePath));
        $pathInfo = pathinfo($imagePath);
        
        $compressedPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_compressed.' . $pathInfo['extension'];
        $fullPath = Storage::path($compressedPath);

        if (strtolower($pathInfo['extension']) === 'png') {
            $image->toPng()->save($fullPath);
        } else {
            $image->toJpeg($quality)->save($fullPath);
        }

        return $compressedPath;
    }
}