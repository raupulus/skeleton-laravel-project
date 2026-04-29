<?php

namespace Tests\Feature\Web;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_blog_page_is_accessible(): void
    {
        $this->get('/blog')->assertStatus(200);
    }

    public function test_about_page_is_accessible(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    public function test_contact_page_is_accessible(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    public function test_published_post_is_accessible(): void
    {
        $user = User::factory()->create();
        Post::factory()->create(['slug' => 'test-post', 'status' => 'published', 'is_active' => true, 'user_id' => $user->id]);
        $this->get('/blog/test-post')->assertStatus(200);
    }

    public function test_draft_post_returns_404(): void
    {
        $user = User::factory()->create();
        Post::factory()->create(['slug' => 'draft-post', 'status' => 'draft', 'user_id' => $user->id]);
        $this->get('/blog/draft-post')->assertStatus(404);
    }
}
