<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Services\SeoService;

class SeoMiddleware
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // SEO verilerini view'larda kullanılabilir hale getir
        View::share('seoService', $this->seoService);

        return $response;
    }
}