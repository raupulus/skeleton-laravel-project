<?php

namespace Tests\Unit;

use App\Enums\ContentStatus;
use App\Enums\Role;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\PageFactory;
use Database\Factories\PostCategoryFactory;
use Database\Factories\PostFactory;
use Database\Factories\SocialMediaFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_factory_states(): void
    {
        $published = PostFactory::new()->published()->create();
        $this->assertEquals(ContentStatus::Published, $published->status);
        $this->assertTrue($published->is_active);
        $this->assertNotNull($published->published_at);

        $draft = PostFactory::new()->draft()->create();
        $this->assertEquals(ContentStatus::Draft, $draft->status);
        $this->assertNull($draft->published_at);

        $featured = PostFactory::new()->featured()->create();
        $this->assertTrue($featured->featured);
    }

    public function test_page_factory_states_and_modular_content(): void
    {
        $active = PageFactory::new()->active()->create();
        $this->assertTrue($active->is_active);

        $inactive = PageFactory::new()->inactive()->create();
        $this->assertFalse($inactive->is_active);

        $modular = PageFactory::new()->withModularBlocks()->create();
        $contentEs = $modular->getTranslation('content', 'es');
        $this->assertIsArray($contentEs);
        $this->assertEquals('text', $contentEs[0]['type']);
        $this->assertEquals('cta', $contentEs[1]['type']);
    }

    public function test_post_category_factory(): void
    {
        $category = PostCategoryFactory::new()->active()->create();
        $this->assertInstanceOf(Category::class, $category);
        $this->assertNotEmpty($category->slug);
        $this->assertNotEmpty($category->getTranslation('name', 'es'));
        $this->assertNotEmpty($category->getTranslation('name', 'en'));
        $this->assertTrue($category->is_active);
    }

    public function test_social_media_factory(): void
    {
        $social = SocialMediaFactory::new()->active()->create();
        $this->assertInstanceOf(Setting::class, $social);
        $this->assertEquals('social', $social->group);
        $this->assertNotEmpty($social->value);
        $this->assertStringStartsWith('https://', $social->value);

        $inactiveSocial = SocialMediaFactory::new()->inactive()->create();
        $this->assertNull($inactiveSocial->value);
    }

    public function test_user_factory_states(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $this->assertEquals(Role::SuperAdmin, $superadmin->role);

        $admin = User::factory()->admin()->create();
        $this->assertEquals(Role::Admin, $admin->role);

        $inactive = User::factory()->inactive()->create();
        $this->assertFalse($inactive->is_active);
    }

    public function test_category_factory_states(): void
    {
        $active = CategoryFactory::new()->active()->create();
        $this->assertTrue($active->is_active);

        $inactive = CategoryFactory::new()->inactive()->create();
        $this->assertFalse($inactive->is_active);
    }
}
