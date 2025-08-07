<?php

namespace App\Services;

class PerformanceService
{
    public function generateWebVitalsScript()
    {
        return "
        <script>
        // Core Web Vitals tracking
        function sendToAnalytics(metric) {
            gtag('event', metric.name, {
                event_category: 'Web Vitals',
                event_label: metric.id,
                value: Math.round(metric.name === 'CLS' ? metric.value * 1000 : metric.value),
                non_interaction: true,
            });
        }

        // Import web-vitals library
        import('https://unpkg.com/web-vitals@3/dist/web-vitals.js').then(({onCLS, onFID, onFCP, onLCP, onTTFB}) => {
            onCLS(sendToAnalytics);
            onFID(sendToAnalytics);
            onFCP(sendToAnalytics);
            onLCP(sendToAnalytics);
            onTTFB(sendToAnalytics);
        });

        // Page load performance
        window.addEventListener('load', function() {
            const navigation = performance.getEntriesByType('navigation')[0];
            
            gtag('event', 'page_load_time', {
                event_category: 'Performance',
                value: Math.round(navigation.loadEventEnd - navigation.fetchStart),
                non_interaction: true,
            });
        });
        </script>";
    }

    public function generatePreloadTags($criticalResources = [])
    {
        $preloadTags = [];
        
        // Critical CSS
        $preloadTags[] = '<link rel="preload" href="' . asset('build/assets/app.css') . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
        
        // Critical fonts
        $preloadTags[] = '<link rel="preload" href="https://fonts.cdnfonts.com/css/gilroy-bold" as="style" crossorigin>';
        
        // Critical images
        foreach ($criticalResources as $resource) {
            if (isset($resource['type']) && $resource['type'] === 'image') {
                $preloadTags[] = '<link rel="preload" href="' . $resource['url'] . '" as="image">';
            }
        }
        
        return implode("\n    ", $preloadTags);
    }
}