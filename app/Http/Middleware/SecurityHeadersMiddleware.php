<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // XSS qorunması
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Content type sniffing qorunması
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Clickjacking qorunması
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // HTTPS yönləndirmə
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        
        // Referrer siyasəti
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Content Security Policy (CSP)
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.youtube.com https://www.google.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "img-src 'self' data: https: http:; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "frame-src 'self' https://www.youtube.com; " .
               "connect-src 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}