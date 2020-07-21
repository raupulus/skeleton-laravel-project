<?php

use App\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SocialNetworksTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FileTypesSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubcategorySeeder::class);
        $this->call(ContentTypeSeeder::class);
        $this->call(ContentStatusSeeder::class);
        $this->call(ContentSeeder::class);
    }
}
