<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $s = [
            ['key' => 'site_title', 'display_name' => 'Título del sitio', 'value' => 'Skeleton Laravel Project', 'type' => 'text', 'group' => 'general', 'order' => 1],
            ['key' => 'site_description', 'display_name' => 'Descripción del sitio', 'value' => 'Plantilla base profesional para proyectos Laravel 13 con Filament 5, API REST autenticada con Sanctum, soporte multi-idioma, SEO técnico y Docker.', 'type' => 'textarea', 'group' => 'general', 'order' => 2],
            ['key' => 'contact_email', 'display_name' => 'Email de contacto', 'value' => 'info@example.com', 'type' => 'text', 'group' => 'contact', 'order' => 1],
            ['key' => 'contact_phone', 'display_name' => 'Teléfono', 'value' => '+34 600 000 000', 'type' => 'text', 'group' => 'contact', 'order' => 2],
            ['key' => 'contact_address', 'display_name' => 'Dirección', 'value' => 'Calle Ejemplo 123, Madrid', 'type' => 'textarea', 'group' => 'contact', 'order' => 3],
            ['key' => 'facebook_url', 'display_name' => 'Facebook', 'value' => 'https://facebook.com', 'type' => 'text', 'group' => 'social', 'order' => 1],
            ['key' => 'twitter_url', 'display_name' => 'Twitter/X', 'value' => 'https://twitter.com', 'type' => 'text', 'group' => 'social', 'order' => 2],
            ['key' => 'instagram_url', 'display_name' => 'Instagram', 'value' => 'https://instagram.com', 'type' => 'text', 'group' => 'social', 'order' => 3],
            ['key' => 'linkedin_url', 'display_name' => 'LinkedIn', 'value' => 'https://linkedin.com', 'type' => 'text', 'group' => 'social', 'order' => 4],
            ['key' => 'github_url', 'display_name' => 'GitHub', 'value' => 'https://github.com', 'type' => 'text', 'group' => 'social', 'order' => 5],
            ['key' => 'default_meta_keywords', 'display_name' => 'Keywords por defecto', 'value' => 'laravel, php, skeleton', 'type' => 'text', 'group' => 'seo', 'order' => 1],
            ['key' => 'google_analytics_id', 'display_name' => 'Google Analytics ID', 'value' => '', 'type' => 'text', 'group' => 'seo', 'order' => 2],
        ];
        foreach ($s as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
