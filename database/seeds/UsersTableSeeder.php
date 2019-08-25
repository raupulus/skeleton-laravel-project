<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'users';

        DB::table($table)->insert([
            'name' => 'Administrador Principal',
            'role_id' => 1,
            'nick' => 'elsuperadmin',
            'email' => 'admin@domain.es',
            'password' => bcrypt('temp'),
        ]);

        DB::table($table)->insert([
            'name' => 'Usuario Normal',
            'role_id' => 3,
            'nick' => 'elusernormal',
            'email' => 'user@domain.es',
            'password' => bcrypt('temp'),
        ]);
    }
}
