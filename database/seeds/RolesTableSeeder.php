<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ## Creo rol para el usuario administrador principal
        DB::table('users_roles')->insert([
            'name' => 'admin',
            'display_name' => 'Administrador',
        ]);

        ## Creo rol para usuario normal
        DB::table('users_roles')->insert([
            'name' => 'user',
            'display_name' => 'Usuario Normal',
        ]);
    }
}
