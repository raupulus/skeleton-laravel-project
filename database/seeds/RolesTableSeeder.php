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
        Role::firstOrCreate([
            'name' => 'superadmin',
            'display_name' => 'SuperAdministrador',
            'description' => 'Administrador principal de la aplicación'
        ]);

        ## Creo rol para los demás administradores.
        Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Administrador con poderes amplios pero no totales'
        ]);

        ## Creo rol para usuario normal
        Role::firstOrCreate([
            'name' => 'user',
            'display_name' => 'Usuario Normal',
            'description' => 'Usuario que puede acceder al contenido y editar el suyo'
        ]);
    }
}
