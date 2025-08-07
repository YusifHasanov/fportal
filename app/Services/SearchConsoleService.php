<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchConsoleService
{
    private $siteUrl;
    private $accessToken;
    
    public function __construct()
    {
        $this->siteUrl = config('app.url');
        $this->accessToken = config('services.google.search_console_token');
    }
    
    public function submitSitemap($sitemapUrl = null)
    {
        if (!$this->accessToken) {
            Log::warning('Google Search Console access token not configured');
            return false;
        }
        
        $sitemapUrl = $sitemapUrl ?? $this->siteUrl . '/sitemap.xml';
        
        try {
            $response = Http::withToken($this->accessToken)
                ->put("https://www.googleapis.com/webmasters/v3/sites/" . urlencode($this->siteUrl) . "/sitemaps/" . urlencode($sitemapUrl));
                
            if ($response->successful()) {
                Log::info('Sitemap successfully submitted to Google Search Console', [
                    'sitemap_url' => $sitemapUrl
                ]);
                return true;
            } else {
                Log::error('Failed to submit sitemap to Google Search Console', [
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error submitting sitemap to Google Search Console', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    public function getSitemapStatus()
    {
        if (!$this->accessToken) {
            return null;
        }
        
        try {
            $response = Http::withToken($this->accessToken)
                ->get("https://www.googleapis.com/webmasters/v3/sites/" . urlencode($this->siteUrl) . "/sitemaps");
                
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Error getting sitemap status from Google Search Console', [
                'error' => $e->getMessage()
            ]);
        }
        
        return null;
    }
    
    public function getSearchAnalytics($startDate = null, $endDate = null)
    {
        if (!$this->accessToken) {
            return null;
        }
        
        $startDate = $startDate ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $endDate ?? now()->format('Y-m-d');
        
        $requestBody = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'dimensions' => ['query', 'page'],
            'rowLimit' => 100
        ];
        
        try {
            $response = Http::withToken($this->accessToken)
                ->post("https://www.googleapis.com/webmasters/v3/sites/" . urlencode($this->siteUrl) . "/searchAnalytics/query", $requestBody);
                
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Error getting search analytics from Google Search Console', [
                'error' => $e->getMessage()
            ]);
        }
        
        return null;
    }
    
    public function indexUrl($url)
    {
        if (!$this->accessToken) {
            return false;
        }
        
        try {
            $response = Http::withToken($this->accessToken)
                ->post("https://indexing.googleapis.com/v3/urlNotifications:publish", [
                    'url' => $url,
                    'type' => 'URL_UPDATED'
                ]);
                
            if ($response->successful()) {
                Log::info('URL successfully submitted for indexing', [
                    'url' => $url
                ]);
                return true;
            } else {
                Log::error('Failed to submit URL for indexing', [
                    'url' => $url,
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error submitting URL for indexing', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}