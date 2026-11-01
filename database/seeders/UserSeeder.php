<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => Role::SuperAdmin, 'is_active' => true, 'email_verified_at' => now()]);
        User::firstOrCreate(['email' => 'editor@example.com'], ['name' => 'Editor', 'password' => Hash::make('password'), 'role' => Role::Admin, 'is_active' => true, 'email_verified_at' => now()]);
        $users = [['name' => 'María García', 'email' => 'maria@example.com'], ['name' => 'Carlos López', 'email' => 'carlos@example.com'], ['name' => 'Ana Martínez', 'email' => 'ana@example.com'], ['name' => 'Pedro Sánchez', 'email' => 'pedro@example.com'], ['name' => 'Laura Fernández', 'email' => 'laura@example.com'], ['name' => 'Diego Rodríguez', 'email' => 'diego@example.com'], ['name' => 'Sofía Hernández', 'email' => 'sofia@example.com'], ['name' => 'Miguel Torres', 'email' => 'miguel@example.com'], ['name' => 'Elena Ruiz', 'email' => 'elena@example.com'], ['name' => 'Javier Moreno', 'email' => 'javier@example.com']];
        foreach ($users as $u) {
            User::firstOrCreate(['email' => $u['email']], array_merge($u, ['password' => Hash::make('password'), 'role' => Role::User, 'is_active' => true, 'email_verified_at' => now()]));
        }
    }
}
