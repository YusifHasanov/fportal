<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\News;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin kullanıcısı oluştur
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Örnek kategoriler oluştur
        $categories = [
            ['name' => 'Teknoloji', 'color' => '#3B82F6', 'description' => 'Teknoloji haberleri ve yenilikleri'],
            ['name' => 'Spor', 'color' => '#10B981', 'description' => 'Spor haberleri ve sonuçları'],
            ['name' => 'Ekonomi', 'color' => '#F59E0B', 'description' => 'Ekonomi ve finans haberleri'],
            ['name' => 'Sağlık', 'color' => '#EF4444', 'description' => 'Sağlık ve tıp haberleri'],
            ['name' => 'Eğitim', 'color' => '#8B5CF6', 'description' => 'Eğitim ve öğretim haberleri'],
        ];

        foreach ($categories as $index => $categoryData) {
            Category::firstOrCreate(
                ['slug' => \Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'color' => $categoryData['color'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }

        // Örnek etiketler oluştur
        $tags = ['Yenilik', 'Araştırma', 'Gelişim', 'Trend', 'Analiz', 'Rapor'];
        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => \Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'color' => '#6B7280',
                ]
            );
        }

        // Örnek haberler oluştur
        $techCategory = Category::where('name', 'Teknoloji')->first();
        $sportsCategory = Category::where('name', 'Spor')->first();
        
        $newsData = [
            [
                'title' => 'Yapay Zeka Teknolojisinde Son Gelişmeler',
                'excerpt' => 'Yapay zeka alanında yaşanan son gelişmeler ve bunların günlük hayatımıza etkileri.',
                'content' => '<p>Yapay zeka teknolojisi son yıllarda hızla gelişiyor ve hayatımızın her alanında etkisini gösteriyor. Bu haberde, yapay zeka alanındaki en son gelişmeleri ve bunların toplum üzerindeki etkilerini inceliyoruz.</p><p>Makine öğrenmesi algoritmaları, doğal dil işleme ve bilgisayarlı görü gibi alanlarda kaydedilen ilerlemeler, teknoloji dünyasını şekillendirmeye devam ediyor.</p>',
                'category_id' => $techCategory->id,
                'is_featured' => true,
            ],
            [
                'title' => 'Futbol Dünyasından Son Haberler',
                'excerpt' => 'Futbol liglerinden transfer haberleri ve maç sonuçları.',
                'content' => '<p>Bu hafta futbol dünyasında yaşanan gelişmeleri sizler için derledik. Transfer döneminin sıcak gelişmeleri ve lig maçlarının sonuçları burada.</p><p>Önemli transferler ve takım performansları hakkında detaylı analizler.</p>',
                'category_id' => $sportsCategory->id,
                'is_featured' => false,
            ],
        ];

        foreach ($newsData as $newsItem) {
            $news = News::create([
                'title' => $newsItem['title'],
                'slug' => \Str::slug($newsItem['title']),
                'excerpt' => $newsItem['excerpt'],
                'content' => $newsItem['content'],
                'status' => 'published',
                'is_featured' => $newsItem['is_featured'],
                'published_at' => now(),
                'category_id' => $newsItem['category_id'],
                'user_id' => $admin->id,
                'views_count' => rand(10, 100),
            ]);

            // Rastgele etiketler ekle
            $randomTags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $news->tags()->attach($randomTags);
        }
    }
}
