<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Services\SitemapService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SitemapServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_service_generates_valid_xml(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => ['es' => 'Categoría Test', 'en' => 'Test Category'],
            'slug' => 'categoria-test',
            'is_active' => true,
        ]);

        $post = Post::create([
            'title' => ['es' => 'Post Sitemap', 'en' => 'Sitemap Post'],
            'slug' => 'post-sitemap',
            'status' => 'published',
            'is_active' => true,
            'user_id' => $user->id,
            'published_at' => now(),
        ]);
        $post->categories()->attach($category);

        $page = Page::create([
            'title' => ['es' => 'Página Sitemap', 'en' => 'Sitemap Page'],
            'slug' => 'pagina-sitemap',
            'status' => 'published',
            'is_active' => true,
            'user_id' => $user->id,
            'published_at' => now(),
        ]);

        $service = app(SitemapService::class);
        $service->generate();

        $sitemapPath = public_path('sitemap.xml');
        $this->assertFileExists($sitemapPath);

        $content = File::get($sitemapPath);
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('post-sitemap', $content);
        $this->assertStringContainsString('pagina-sitemap', $content);
        $this->assertStringContainsString('hreflang="es"', $content);
        $this->assertStringContainsString('hreflang="en"', $content);
    }
}
