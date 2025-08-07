# 🚀 FPortal SEO Kurulum Təlimatları

## 1. Google Search Console Kurulumu

### Adım 1: Site Doğrulaması
1. [Google Search Console](https://search.google.com/search-console)'a daxil olun
2. "Property əlavə et" düyməsini basın
3. "URL prefix" seçin və saytınızın URL-ini daxil edin
4. HTML tag metodunu seçin
5. Verilən kodu `.env` faylında `GOOGLE_SEARCH_CONSOLE_VERIFICATION` dəyişəninə əlavə edin

```bash
GOOGLE_SEARCH_CONSOLE_VERIFICATION=your_verification_code_here
```

### Adım 2: Sitemap Göndərimi
```bash
# Sitemap yaradın
php artisan sitemap:generate

# Otomatik göndərim üçün Google Search Console API token alın
# və .env faylına əlavə edin
GOOGLE_SEARCH_CONSOLE_TOKEN=your_token_here
```

## 2. Google Analytics 4 Kurulumu

### Adım 1: GA4 Property Yaradın
1. [Google Analytics](https://analytics.google.com)'ə daxil olun
2. Yeni property yaradın
3. Measurement ID-ni kopyalayın (G-XXXXXXXXXX formatında)

### Adım 2: Konfigürasiya
```bash
# .env faylına əlavə edin
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

## 3. SEO Automation Aktivləşdirin

### Scheduled Jobs
```bash
# Crontab-a əlavə edin
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Manual Commands
```bash
# SEO audit
php artisan seo:audit

# Problemləri avtomatik düzəlt
php artisan seo:audit --fix

# Sitemap yenilə
php artisan sitemap:generate
```

## 4. Performance Monitoring

### Core Web Vitals
- Avtomatik olaraq Google Analytics'ə göndərilir
- Filament dashboard-da görünür

### Page Speed Optimization
```bash
# CSS və JS optimize edin
npm run build

# Images optimize edin (WebP formatına çevirin)
# Lazy loading aktivdir
```

## 5. Content Strategy

### Keyword Research
```php
// Xəbər yaradarkən keyword təklifləri alın
$keywords = app('App\Services\KeywordService')->suggestKeywords($content, $category);
```

### Internal Linking
```php
// Avtomatik internal link təklifləri
$suggestions = app('App\Services\KeywordService')->generateInternalLinkSuggestions($content);
```

## 6. Monitoring və Reporting

### Filament Dashboard
- SEO skoru
- Meta təsviri olmayan xəbərlər
- Featured image olmayan xəbərlər
- Google Search Console statistikaları

### Log Monitoring
```bash
# SEO loglarını izləyin
tail -f storage/logs/laravel.log | grep -i seo
```

## 7. Təkmilləşdirmə Tövsiyələri

### Hər Xəbər üçün:
- ✅ Unikal title (50-60 simvol)
- ✅ Meta description (150-160 simvol)
- ✅ Featured image (1200x630px)
- ✅ Alt text şəkillərdə
- ✅ Internal linklər

### Texniki SEO:
- ✅ SSL sertifikatı
- ✅ Mobile-friendly design
- ✅ Fast loading (Core Web Vitals)
- ✅ Structured data
- ✅ XML sitemap
- ✅ Robots.txt

## 8. Nəticələr

Bu kurulumdan sonra:

🎯 **Google'da görünmə müddəti**: 1-7 gün
🎯 **Axtarış nəticələrində mövqe**: 2-4 həftə
🎯 **Organic trafik artımı**: 1-3 ay

### Gözləmə Göstəriciləri:
- Click-through rate (CTR): 2-5%
- Average position: Top 10
- Organic sessions: 30% artım
- Page load speed: <3 saniyə

## 9. Troubleshooting

### Sitemap problemi:
```bash
# Sitemap yenidən yaradın
php artisan sitemap:generate

# Permissions yoxlayın
chmod 644 public/sitemap.xml
```

### Google Analytics məlumat gəlmir:
1. Measurement ID düzgün olduğunu yoxlayın
2. Ad blocker söndürün
3. Real-time reports yoxlayın

### Search Console verification:
1. Meta tag düzgün əlavə olunduğunu yoxlayın
2. Cache təmizləyin
3. DNS propagation gözləyin

## 10. Əlaqə

Texniki dəstək üçün: [email@fportal.az](mailto:email@fportal.az)