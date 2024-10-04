<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users as ONG
        $admin1 = DB::table('users')->insertGetId([
            'user_type' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@meadote.com',
            'password' => Hash::make('00000000'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin2 = DB::table('users')->insertGetId([
            'user_type' => 'admin',
            'name' => 'Sistema',
            'email' => 'sistema@meadote.com',
            'password' => Hash::make('00000000'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create ONG records for the users created above
        DB::table('ongs')->insert([
            [
                'user_id' => $admin1,
                'ong_name' => 'Admin ONG',
                'phone' => '123456789',
                'responsible_name' => 'Admin Responsible',
                'responsible_cpf' => '000.000.000-00',
                'cnpj' => '00.000.000/0000-00',
                'about_ong' => 'ONG administrada pelo Admin do sistema.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $admin2,
                'ong_name' => 'Sistema ONG',
                'phone' => '987654321',
                'responsible_name' => 'Sistema Responsible',
                'responsible_cpf' => '111.111.111-11',
                'cnpj' => '11.111.111/1111-11',
                'about_ong' => 'Usuário do sistema responsável por ações automatizadas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
