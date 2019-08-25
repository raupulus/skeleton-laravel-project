<?php

use App\Role;
use App\User;
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
        $table = 'users_roles';

        ## Creo rol para el usuario administrador principal.
        DB::table($table)->insert([
            'name' => 'superadmin',
            'display_name' => 'SuperAdministrador',
        ]);

        ## Creo rol para los demás administradores.
        DB::table($table)->insert([
            'name' => 'admin',
            'display_name' => 'Administrador',
        ]);

        ## Creo rol para usuario normal
        DB::table($table)->insert([
            'name' => 'user',
            'display_name' => 'Usuario Normal',
        ]);
    }
}
