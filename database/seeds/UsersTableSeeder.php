<?php

use App\User;
use Carbon\Carbon;
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
        $table_users = 'users';
        $table_configuration = 'users_configuration';
        $table_data = 'users_data';
        $table_details = 'users_detail';
        $timestamp = Carbon::now();

        $users = [
            ## Datos de usuario administrador.
            [
                'name' => 'Administrador Principal',
                'role_id' => 1,
                'nick' => 'superadmin',
                'email' => 'admin@domain.es',
            ],

            ## Datos de usuario normal.
            [
                'name' => 'Usuario Normal',
                'role_id' => 3,
                'nick' => 'elusernormal',
                'email' => 'user@domain.es',
                'password' => bcrypt('temp'),
            ]
        ];

        /**
         * Inserto cada usuario creando los datos en las tablas dependientes.
         */
        foreach ($users as $user) {
            $userInDb = User::where('email', $user['email'])
                ->orWhere('nick', $user['nick'])
                ->first();

            if ($userInDb) {
                continue;
            }

            $configuration = DB::table($table_configuration)->insertGetId([
                'send_email' => true,
                'send_notification' => true,
                'send_notification_push' => true,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            $data = DB::table($table_data)->insertGetId([
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            $details = DB::table($table_details)->insertGetId([
                'profession' => 'Developer',
                'web' => 'https://fryntiz.es',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table($table_users)->insert(
                array_merge([
                    'configuration_id' => $configuration,
                    'data_id' => $data,
                    'detail_id' => $details,
                    'password' => bcrypt('123456'),
                    'remember_token' => true,
                    'email_verified_at' => $timestamp,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ], $user)
            );
        }
    }
}
