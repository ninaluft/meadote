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
            'city' => 'Porto Alegre',
            'state' => 'RS',
            'cep' => '90010-001', // CEP válido de Porto Alegre, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin2 = DB::table('users')->insertGetId([
            'user_type' => 'admin',
            'name' => 'Sistema',
            'email' => 'sistema@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'São Paulo',
            'state' => 'SP',
            'cep' => '01001-000', // CEP válido de São Paulo, SP
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $ong = DB::table('users')->insertGetId([
            'user_type' => 'ong',
            'name' => 'ongpatinhas',
            'email' => 'ongpatinhas@ong.com',
            'password' => Hash::make('00000000'),
            'city' => 'Carazinho',
            'state' => 'RS',
            'cep' => '99500-000', // CEP válido de Carazinho, RS
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
            ],
            [
                'user_id' => $ong,
                'ong_name' => 'ONG Patinhas do bem',
                'phone' => '5499887766',
                'responsible_name' => 'Marina Luft',
                'responsible_cpf' => '222.222.222-22',
                'cnpj' => '22.222.222/2222-22',
                'about_ong' => 'Somos a Patinhas do Bem, uma ONG formada por voluntários apaixonados por animais. Nosso trabalho é resgatar, reabilitar e encontrar lares seguros e amorosos para cães e gatos em situação de vulnerabilidade. Além disso, realizamos campanhas de castração e ações de conscientização, visando reduzir o abandono e promover uma convivência harmoniosa entre pessoas e pets. Acreditamos que cada animal merece respeito e cuidado, e lutamos todos os dias para garantir isso. Junte-se a nós e ajude a salvar vidas!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Create tutor users
        $tutor1 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'João da Silva',
            'email' => 'joao.silva@meadote.com',
            'password' => Hash::make('12345678'),
            'city' => 'Não-Me-Toque',
            'state' => 'RS',
            'cep' => '99470-000', // CEP válido de Não-Me-Toque, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $tutor2 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'ninaluft',
            'email' => 'ninaluft@gmail.com',
            'password' => Hash::make('00000000'),
            'city' => 'Passo Fundo',
            'state' => 'RS',
            'cep' => '99010-000', // CEP válido de Passo Fundo, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create Tutor records for the users created above
        DB::table('tutors')->insert([
            [
                'user_id' => $tutor1,
                'full_name' => 'João da Silva',
                'date_of_birth' => '1990-05-15',
                'temporary_housing' => true,
                'cpf' => '222.222.222-22',
                'about_me' => 'Amante dos animais e tutor dedicado.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $tutor2,
                'full_name' => 'Marina Luft',
                'date_of_birth' => '1989-11-14',
                'temporary_housing' => false,
                'cpf' => '333.333.333-33',
                'about_me' => 'Tenho experiência com cães e gatos e adoro ajudar.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
