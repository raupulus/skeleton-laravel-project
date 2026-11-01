<?php

namespace Tests\Unit\Services;

use App\Models\Post;
use App\Models\User;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_seo_service_sets_and_returns_data_array(): void
    {
        $seo = new SeoService;
        $seo->setTitle('Título de Prueba')
            ->setDescription('Descripción de prueba')
            ->setKeywords('laravel, php, tests')
            ->setUrl('https://example.com/test')
            ->setType('article')
            ->setImage('https://example.com/image.jpg')
            ->setRobots('noindex,nofollow');

        $data = $seo->toArray();

        $this->assertEquals('Título de Prueba', $data['title']);
        $this->assertEquals('Descripción de prueba', $data['description']);
        $this->assertEquals('laravel, php, tests', $data['keywords']);
        $this->assertEquals('https://example.com/test', $data['url']);
        $this->assertEquals('article', $data['type']);
        $this->assertEquals('https://example.com/image.jpg', $data['image']);
        $this->assertEquals('noindex,nofollow', $data['robots']);
    }

    public function test_seo_service_loads_from_model(): void
    {
        $user = User::factory()->create();
        $post = Post::create([
            'title' => ['es' => 'Post de Prueba', 'en' => 'Test Post'],
            'excerpt' => ['es' => 'Extracto de prueba', 'en' => 'Test excerpt'],
            'seo_title' => ['es' => 'SEO Title Personalizado', 'en' => 'Custom SEO Title'],
            'seo_description' => ['es' => 'SEO Desc Personalizada', 'en' => 'Custom SEO Desc'],
            'seo_keywords' => ['es' => 'tag1, tag2', 'en' => 'tag1, tag2'],
            'user_id' => $user->id,
            'image' => 'posts/test.jpg',
        ]);

        app()->setLocale('es');
        $seo = new SeoService;
        $seo->fromModel($post);
        $data = $seo->toArray();

        $this->assertEquals('SEO Title Personalizado', $data['title']);
        $this->assertEquals('SEO Desc Personalizada', $data['description']);
        $this->assertEquals('tag1, tag2', $data['keywords']);
        $this->assertStringContainsString('storage/posts/test.jpg', $data['image']);
    }
}
