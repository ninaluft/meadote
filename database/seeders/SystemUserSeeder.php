<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Sistema',
            'email' => 'sistema@meadote.com',
            'password' => Hash::make('senha_segura'), // Criptografe a senha
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
