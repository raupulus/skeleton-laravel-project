<?php

namespace App\Providers;

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
        Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);
        Gate::policy(\App\Models\Page::class, \App\Policies\PagePolicy::class);
        Gate::policy(\App\Models\Post::class, \App\Policies\PostPolicy::class);
        Gate::policy(\App\Models\Category::class, \App\Policies\CategoryPolicy::class);
        Gate::policy(\App\Models\Slide::class, \App\Policies\SlidePolicy::class);
        Gate::policy(\App\Models\Section::class, \App\Policies\SectionPolicy::class);
        Gate::policy(\App\Models\Setting::class, \App\Policies\SettingPolicy::class);
        Gate::policy(\App\Models\SentEmail::class, \App\Policies\SentEmailPolicy::class);
    }
}
