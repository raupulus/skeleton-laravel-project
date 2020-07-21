<?php

use App\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::firstOrCreate([
            'name' => 'Español',
            'locale' => 'es_ES',
            'code' => 'esp',
            'code2' => 'es',
            'country' => 'España',
            'icon16' => 'es_16.png',
            'icon32' => 'es_32.png',
            'icon64' => 'es_64.png',
        ]);

        Language::firstOrCreate([
            'name' => 'English',
            'locale' => 'en_GB',
            'code' => 'eng',
            'code2' => 'en',
            'country' => 'United Kingdom',
            'icon16' => 'en_16.png',
            'icon32' => 'en_32.png',
            'icon64' => 'en_64.png',
        ]);
    }
}
