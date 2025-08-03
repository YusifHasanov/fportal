<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $videos = VideoGallery::active()->ordered()->paginate(12);
        
        // Debug için
        if ($videos->count() === 0) {
            $allVideos = VideoGallery::all();
            logger('Video Gallery Debug', [
                'active_videos' => $videos->count(),
                'total_videos' => $allVideos->count(),
                'all_videos' => $allVideos->toArray()
            ]);
        }
        
        return view('frontend.video-gallery.index', compact('videos'));
    }

    public function show(VideoGallery $videoGallery)
    {
        if (!$videoGallery->is_active) {
            abort(404);
        }

        $videoGallery->incrementViews();
        
        $relatedVideos = VideoGallery::active()
            ->where('id', '!=', $videoGallery->id)
            ->ordered()
            ->limit(4)
            ->get();

        return view('frontend.video-gallery.show', compact('videoGallery', 'relatedVideos'));
    }
}
