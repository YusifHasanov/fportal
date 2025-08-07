<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Str;

class KeywordService
{
    private $footballKeywords = [
        'futbol', 'transfer', 'oyunçu', 'komanda', 'matç', 'qol', 'nəticə',
        'çempionat', 'kubок', 'məşqçi', 'stadion', 'azərbaycan', 'qarabağ',
        'neftçi', 'sabah', 'zirə', 'sumqayıt', 'keşlə', 'səbail',
        'premier liqası', 'çempionlar liqası', 'avropa liqası',
        'milli komanda', 'dünya çempionatı', 'avropa çempionatı'
    ];

    public function suggestKeywords($content, $category = null)
    {
        $suggestions = [];
        $content = strtolower($content);
        
        // Find relevant football keywords in content
        foreach ($this->footballKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                $suggestions[] = $keyword;
            }
        }
        
        // Add category-specific keywords
        if ($category) {
            $categoryKeywords = $this->getCategoryKeywords($category);
            $suggestions = array_merge($suggestions, $categoryKeywords);
        }
        
        // Add trending keywords based on recent news
        $trendingKeywords = $this->getTrendingKeywords();
        $suggestions = array_merge($suggestions, $trendingKeywords);
        
        return array_unique($suggestions);
    }
    
    public function generateSeoTitle($originalTitle, $keywords = [])
    {
        $title = $originalTitle;
        
        // Add year if news is recent
        if (!strpos($title, date('Y'))) {
            $title .= ' ' . date('Y');
        }
        
        // Add location if not present
        if (!strpos(strtolower($title), 'azərbaycan') && !strpos(strtolower($title), 'bakı')) {
            $title .= ' - Azərbaycan';
        }
        
        // Ensure title length is optimal (50-60 characters)
        if (strlen($title) > 60) {
            $title = Str::limit($title, 57);
        }
        
        return $title;
    }
    
    public function analyzeKeywordDensity($content)
    {
        $words = str_word_count(strtolower($content), 1, 'çğıöşüəÇĞIÖŞÜƏ');
        $totalWords = count($words);
        $wordCount = array_count_values($words);
        
        $density = [];
        foreach ($this->footballKeywords as $keyword) {
            $count = $wordCount[$keyword] ?? 0;
            if ($count > 0) {
                $density[$keyword] = [
                    'count' => $count,
                    'density' => round(($count / $totalWords) * 100, 2)
                ];
            }
        }
        
        return $density;
    }
    
    private function getCategoryKeywords($category)
    {
        $categoryKeywords = [
            'transfer' => ['transfer', 'oyunçu', 'imza', 'müqavilə', 'keçid'],
            'nəticə' => ['nəticə', 'matç', 'oyun', 'qol', 'hesab'],
            'xəbər' => ['xəbər', 'son dəqiqə', 'açıqlama', 'məlumat'],
            'milli' => ['milli komanda', 'azərbaycan', 'yığma', 'seçmə']
        ];
        
        return $categoryKeywords[strtolower($category)] ?? [];
    }
    
    private function getTrendingKeywords()
    {
        // Get most used keywords from recent news
        $recentNews = News::where('created_at', '>=', now()->subDays(7))
            ->pluck('title', 'content')
            ->take(20);
            
        $trendingWords = [];
        foreach ($recentNews as $content => $title) {
            $text = strtolower($title . ' ' . $content);
            foreach ($this->footballKeywords as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    $trendingWords[] = $keyword;
                }
            }
        }
        
        $trending = array_count_values($trendingWords);
        arsort($trending);
        
        return array_slice(array_keys($trending), 0, 5);
    }
    
    public function generateInternalLinkSuggestions($content)
    {
        $suggestions = [];
        $content = strtolower($content);
        
        // Find related news based on keywords
        foreach ($this->footballKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                $relatedNews = News::where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%")
                    ->where('status', 'published')
                    ->limit(3)
                    ->get(['id', 'title', 'slug']);
                    
                foreach ($relatedNews as $news) {
                    $suggestions[] = [
                        'anchor_text' => $keyword,
                        'url' => route('news.show', $news->slug),
                        'title' => $news->title
                    ];
                }
            }
        }
        
        return array_slice($suggestions, 0, 5);
    }
}