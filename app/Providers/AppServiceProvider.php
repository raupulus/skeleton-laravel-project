<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Section;
use App\Models\SentEmail;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\SectionPolicy;
use App\Policies\SentEmailPolicy;
use App\Policies\SettingPolicy;
use App\Policies\SlidePolicy;
use App\Policies\UserPolicy;
use App\Services\SeoService;
use App\Services\SettingService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeoService::class);
        $this->app->singleton(SettingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Slide::class, SlidePolicy::class);
        Gate::policy(Section::class, SectionPolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(SentEmail::class, SentEmailPolicy::class);
    }
}
