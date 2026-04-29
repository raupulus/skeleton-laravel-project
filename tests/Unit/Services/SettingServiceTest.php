<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_returns_correct_value(): void
    {
        Setting::create(['key' => 'test_key', 'display_name' => 'Test', 'value' => 'test_value', 'type' => 'text', 'group' => 'general']);
        $service = app(SettingService::class);
        $service->clearCache();
        $this->assertEquals('test_value', $service->get('test_key'));
    }

    public function test_setting_returns_default_when_not_found(): void
    {
        $service = app(SettingService::class);
        $service->clearCache();
        $this->assertEquals('default', $service->get('nonexistent', 'default'));
    }

    public function test_setting_helper_function_works(): void
    {
        Setting::create(['key' => 'helper_test', 'display_name' => 'Test', 'value' => 'works', 'type' => 'text', 'group' => 'general']);
        app(SettingService::class)->clearCache();
        $this->assertEquals('works', setting('helper_test'));
    }
}
